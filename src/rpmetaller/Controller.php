<?php

namespace rpmetaller;

//The controller
class Controller
{
    //NULL Array from $_GET and $_POST.
    private $request = null;
    //string Name of the template.
    private $template = '';
    //object Object representing the (outer) view.
    private $view = null;
    //Mysql link identifier
    private mysqli = null;
    //string String containing error messages
    private $error_text = '';

    /**
     * Initialize the controller.
     *
     * @param array $request Array from  $_GET and $_POST
     */
    public function __construct($request)
    {
        $Utility_Connect = new UtilityConnect;
        $this->mysqli = $Utility_Connect->db_connect();

        $this->view = new View();
        //translate actions induced by the special parameters
        if (
            isset($request['special'])
            and $request['special'] == 'concert'
            and isset($request['type'])
        ) {
            switch($request['type']) {
                case 'edit':
                    if (isset($request['id'])) {
                        $request['edit_id'] = $request['id'];
                    }
                case 'add':
                    $request['edit'] = 'concert';
                    break;
                case 'published':
                    if (isset($request['id'])) {
                        $request['save_id'] = $request['id'];
                    }
                    $request['save'] = 'concert';
                    $request['published'] = 1;
                    break;
                case 'del':
                    if (isset($request['id'])) {
                        $request['del_id'] = $request['id'];
                    }
                    $request['del'] = 'concert';
                    break;
                case 'sold_out':
                    if (isset($request['id'])) {
                        $request['save_id'] = $request['id'];
                    }
                    $request['save'] = 'concert';
                    $request['sold_out'] = 1;
                    break;
            }
        }
        $this->request = $request;
        //Deleting and saving concerts
        if (isset($request['del']) and isset($request['del_id'])) {
            switch($request['del']) {
            case 'concert':
                $Concert_Model = new ModelConcert($this->mysqli);
                $Concert_Model->delConcert($request['del_id']);
                break;
            }
        }
        if (isset($request['save'])) {
            switch($request['save']) {
            case 'concert':
                $this->error_text = $this->saveConcert();
                break;
            }

        }
        $request = $this->request;
        /**
         * translation of request parameters to the name of the
         * corresponding template.
         */
        if (isset($request['edit'])) {
            switch($request['edit']) {
            case 'concert':
            case 'default':
                $this->template = 'concert_edit';
                break;
            }
        } elseif (isset($request['display'])) {
            switch($request['display']) {
                case 'license':
                    $this->template = 'license';
                    break;
                case 'export':
                    if (isset($request['display_id'])) {
                        $this->template = 'concert_export';
                    } else {
                        $this->template = 'export';
                    }
                    break;
                case 'concert':
                default:
                    if (isset($request['display_id'])) {
                        $this->template = 'concert_export';
                    } else {
                        $this->template = 'default';
                    }
                    break;
            }
        } elseif (isset($request['special'])) {
            switch ($request['special']) {
                case 'lineup':
                    $this->template = 'lineup';
                    break;
                case 'lineup_sub':
                    $this->template = 'lineup_sub';
                    break;
                case 'edit_sub':
                    $this->template = 'edit_sub';
                    break;
                case 'set_url':
                    $this->template = 'set_url';
                    break;
            }
        }
    }

    /**
     * Function to display the content
     *
     * @return string Content of the application
     */
    public function display()
    {
        $innerView = new View();
        if (isset($this->request['month'])) {
            $month = $this->request['month'];
        } else {
            //Create the month value containing the current month
            $month = $this->getMonth();
            $this->request['month'] = $month;
        }
        $request = $this->request;
        $this->view->assign('month', $month);
        switch($this->template) {
            case 'license':
                $innerView->setTemplate('license');
                $this->view->assign('subtitle', 'License');
                break;
            case 'concert_edit':
                $Session_Model = new ModelSession();
                $this->prefillConcertEditor($Session_Model);
                $request = $this->request;
                $City_Model = new ModelCity($this->mysqli);
                $cities = $City_Model->getCities();
                array_splice(
                    $cities,
                    0,
                    0,
                    array(array('id' => 0, 'name' => ''))
                );
                $cities[] = array('id' => 1, 'name' => 'New city');
                $innerView->assign('request', $request);
                $innerView->assign('error_text', $this->error_text);

                $city_venue_form = $this->getCityVenueForm(
                    $request['city_id'],
                    $request['venue_id']
                );
                $innerView->assign('city_venue_form', $city_venue_form);

                $venue_new_form = $this->getVenueNewForm(
                    $request['venue_id']
                );
                $innerView->assign('venue_new_form', $venue_new_form);

                $innerView->assign('cities', $cities);
                $innerView->assign('month', $month);

                $lineup = $this->getLineUp($Session_Model);
                $innerView->assign('lineup', $lineup);

                $innerView->setTemplate('concert_edit');
                $this->view->assign('subtitle', 'concert editor');
                break;
            case 'edit_sub':
                $ajax = 1;
                if (isset($request['city_id']) and isset($request['venue_id'])) {
                    $city_venue_form = $this->getCityVenueForm(
                        $request['city_id'],
                        $request['venue_id']
                    );
                    $innerView->assign('content', $city_venue_form);
                } elseif (isset($request['venue_id'])) {
                    $venue_new_form = $this->getVenueNewForm(
                        $request['venue_id']
                    );
                    $innerView->assign('content', $venue_new_form);

                } else {
                    $error_text = '<strong>Something weird happened!</strong>';
                    $innerView->assign('content', $error_text);
                }
                $innerView->setTemplate('ajax');
                break;
            case 'set_url':
                $ajax = 1;
                if (isset($request['venue_id'])) {
                    $VenueModel = new ModelVenue($this->mysli);
                    $venue = $VenueModel->getVenueById($request['venue_id']);
                    $innerView->assign('content', $venue[0]['url']);
                } else {
                    $innerView->assign('content', '');
                }
                $innerView->setTemplate('ajax');
                break;
            case 'lineup':
                $ajax = 1;
                $error = false;
                $Session_Model = new ModelSession();
                if (isset($request['type']) and isset($request['row'])) {
                    switch($request['type']) {
                        case 'add':
                            $Session_Model->setBandLineUp($request['row']);
                            break;
                        case 'del':
                            $Session_Model->delBandLineUp($request['row']);
                            break;
                        case 'shift':
                            if (isset($request['direction'])) {
                                $Session_Model->shiftBandLineUp(
                                    $request['row'],
                                    $request['direction']
                                );
                            } else {
                                $error = true;
                            }
                            break;
                        case 'save':
                            if (
                                isset($request['field'])
                                and isset($request['value'])
                            ) {
                                $Session_Model->updateBandLineUp(
                                    $request['row'],
                                    $request['field'],
                                    $request['value']
                                );
                                exit;
                            } else {
                                $error = true;
                            }
                    }
                }
                else {
                    $error = true;
                }

                if ($error == true) {
                    $error_text = 'Something weird happened. The request could not be processed!';
                } else {
                    $error_text = '';
                }
                $innerView->setTemplate('ajax');
                $lineup = $this->getLineUp($_Session_Model, $error_text);
                $innerView->assign('content', $lineup);
                break;
            case 'lineup_sub':
                $ajax = 1;
                switch($request['type']) {
                    case 'band_select_options':
                        if (
                            isset($request['first_sign'])
                            and isset($request['band_id'])
                        ) {
                            $band_select_options = $this->getBandSelectOptions(
                                $request['first_sign'],
                                $request['band_id']
                            );
                            $innerView->assign('content', $band_select_options);
                        } else {
                            $innerView->assign(
                                'content',
                                '<option value="0">Something weird happened!</option>'
                            );
                        }
                        break;
                    case 'band_new_form':
                        if (isset($request['row']) and isset($request['band_id']))
                        {
                            $band_new_form = $this->getBandNewForm(
                                $request['row'],
                                $request['band_id']
                            );
                            $innerView->assign('content', $band_new_form);
                        } else {
                            $innerView->assign('content', '<strong>Something weird happened!</strong>');
                        }
                        break;
                }
                $innerView->setTemplate('ajax');
                break;
            case 'export':
                /**
                 * Get header and footer from the database and pass it to the
                 * inner view
                 */
                $Pref_Model = new ModelPref($this->mysqli);
                $prefs = $Pref_Model->getPref();
                $Concert_Model = new ModelConcert($this->mysqli);
                $concerts = $Concert_Model->getConcerts($month);
                $result = $this->processConcertData($concerts, $month);
                //Assign header and footer to the inner view
                $innerView->assign('header', $prefs[0]['header']);
                $innerView->assign('footer', $prefs[0]['footer']);
                $innerView->assign('concerts', $result['concerts']);
                $innerView->assign('month_changer', $this->getMonthChanger());
                $innerView->setTemplate('concert_export');
                $this->view->assign('subtitle', 'export');
                break;
            case 'concert_export':
                $ajax = 1;
                //Output of just one concert
                $Concert_Model = new ModelConcert($this->mysqli);
                $concerts = $Concert_Model->getConcert($request['display_id']);
                $result = $this->processConcertData($concerts, $month);
                $innerView->assign('concerts', $result['concerts']);
                $innerView->setTemplate($result['template']);
                break;
            case 'default':
            default:
                /**
                 * Initialize a View object for the second line of the web
                 * application, load the template and pass the output to the
                 * inner View.
                 */
                $monthChanger = $this->getMonthChanger();
                $Concert_Model = new ModelConcert($this->mysqli);
                $concerts = $Concert_Model->getConcerts($month);
                $result = $this->processConcertData($concerts, $month);
                /**
                 * By reloading the default page the status of the individual
                 * concert exports must be reseted.
                 */
                $Session_Model = new ModelSession();
                $Session_Model->delConcertDisplayStatus();
                $innerView->assign('concerts', $result['concerts']);
                $innerView->assign('month', $month);
                $innerView->assign('month_changer', $monthChanger);
                $innerView->setTemplate($result['template']);
                $this->view->assign('subtitle', 'concerts');
        }
        if (isset($ajax) and $ajax = 1) {
            //On ajax calls the template of the outer view should be empty
            $this->view->setTemplate('ajax');
        } else {
            //No ajax call -> load the outer template
            $this->view->setTemplate('rpmetaller-editor');
        }
        $this->view->assign('pagetitle', 'rpmetaller-editor – ');
        $this->view->assign('menu_entrys', array(
            array('Concerts', 'concert'),
            array('Bands', 'band'),
            array('Cities','city'),
            array('Venues', 'venue'),
            array('Export', 'export'),
            array('Preferences','pref')
        ));
        $this->view->assign('content', $innerView->loadTemplate());
        return $this->view->loadTemplate();
    }

    /**
     * Initialize a view for the second line of the web application if necessary,
     * set the template, assign the data to the view, and load the template.
     *
     * @return string Output of the corresponding template.
     */
    private function getMonthChanger()
    {
        //Initialize a new View class for the second line of the web application
        $monthChanger = new View();
        //Set the corresponding template
        $monthChanger->setTemplate('month_changer');
        /**
         * If the display parameter is set, it is passend to all links on the
         * second line
         */
        if(isset($this->request['display'])) {
            $request_month_prev['display'] = $this->request['display'];
            $request_month_next['display'] = $this->request['display'];
        }
        /**
         * Generate parameters for the current month, the next month and the
         * previous month.
         */
        $request_month_now['month'] = $this->getMonth();
        $month_next = $this->request['month'] . '-01 + 1 month';
        $month_prev = $this->request['month'] . '-01 - 1 month';
        $request_month_next['month'] = $this->getMonth($month_next);
        $request_month_prev['month'] = $this->getMonth($month_prev);
        $month_human = date('M Y', strtotime($this->request['month'] . '-01'));
        //Assign the variables to the MonthChanger template
        $monthChanger->assign('request_now', $request_month_now);
        $monthChanger->assign('request_next_month', $request_month_next);
        $monthChanger->assign('request_prev_month', $request_month_prev);
        $monthChanger->assign('month_human', $month_human);
        return $monthChanger->loadTemplate();
    }

    /**
     * Generete a view for the concert lineup
     *
     * @param object $Session_Model Object to access data in the session
     * @return string Output of the lineup template.
     */
    private function getLineUp($Session_Model, $error_text_lineup = '')
    {
        //Initialize a new view for displaying the lineup
        $lineUp = new View();
        //Set the corresponding template
        $lineUp->setTemplate('lineup');
        //Get the actual lineup
        $bands = $Session_Model->GetBandsLineUp();
        //Add a initial lineup to the session if the lineup is empty
        if (count($bands) == 0) {
            $Session_Model->setBandLineUp(0);
            $bands = $Session_Model->GetBandsLineUp();
        }
        $band_select_options = array();
        $band_new_form = array();
        for ($lineup_index = 0; $lineup_index < count($bands); $lineup_index++) {
            $band_select_options[$lineup_index] = $this->getBandSelectOptions(
                $bands[$lineup_index]['first_sign'],
                $bands[$lineup_index]['band_id']
            );
            $band_new_form[$lineup_index] = $this->getBandNewForm(
                $lineup_index,
                $bands[$lineup_index]['band_id']
            );
        }
    //Set variables and arrays for the view
        $lineUp->assign('band_select_options', $band_select_options);
        $lineUp->assign('band_new_form', $band_new_form);
        $lineUp->assign('error_text', $error_text_lineup);
        $lineUp->assign('lineup', $bands);
        return $lineUp->loadTemplate();
    }
    /**
     * Returns the first char in capital letters or '%' for a special symbol
     *
     * @param string $band_name Name of the Band.
     * @return string Capital letter or '%'.
     */
    private function getFirstSign($band_name)
    {
        $first_char = mb_substr($band_name, 0, 1);
        $first_char = mb_strtoupper($first_char);
        if (in_array($first_char, range('A','Z'))) {
            return $first_char;
        } else {
            return '%';
        }
    }

    /**
     * Display the option tags for the select element to choose a band.
     *
     * @param integer  $city_id The id of the choosen city.
     * @param integer  $venue_id Band id The id of the choosen venue.
     * @return string Output of the template.
     */
    private function getCityVenueForm ($city_id, $venue_id)
    {
        $City_Venue_Form = new View();
        $Venue_Model = new ModelVenue($this->mysqli);
        if ($city_id == 0) {
            $venues = $Venue_Model->getVenues();
        } elseif ($city_id == 1) {
            $venues = array();
            if (isset($this->request['city_new_name'])) {
                $city_new_name = $this->request['city_new_name'];
                $City_Venue_Form->assign('city_new_name', $city_new_name);
            } else {
                $City_Venue_Form->assign('city_new_name', null);
            }
        } else {
            $venues = $Venue_Model->getVenuesByCity($city_id);
        }
        array_splice($venues, 0, 0, array(array('id' => 0, 'name' => '')));
        //Test, if the band id is in the array with the choosen bands
        $City_Venue_Form->assign('city_id', $city_id);
        $City_Venue_Form->assign('venues', $venues);
        $City_Venue_Form->assign('venue_id', $venue_id);
        $City_Venue_Form->setTemplate('city_venue_form');
        return $City_Venue_Form->loadTemplate();
    }

    /**
     *  Display the form to enter the name of a new venue and to enter a standard
     *  URL for that venue if needed.
     *
     * @param integer $venue_id Band id of the band.
     * @return string Output of the template.
     */
    private function getVenueNewForm($venue_id)
    {
        $Venue_New_Form = new View();
        if ($venue_id == 1) {
            if (isset($this->request['venue_new_name'])) {
                $venue_new_name = $this->request['venue_new_name'];
                $Venue_New_Form->assign('venue_new_name', $venue_new_name);
            } else {
                $Venue_New_Form->assign('venue_new_name', null);
            }
            if (isset($this->request['venue_url'])) {
                $venue_url = $this->request['venue_url'];
                $Venue_New_Form->assign('venue_url', $venue_url);
            } else {
                $Venue_New_Form->assign('venue_url', null);
            }
        }
        $Venue_New_Form->assign('venue_id', $venue_id);
        $Venue_New_Form->setTemplate('venue_new_form');
        return $Venue_New_Form->loadTemplate();
    }

    /**
     * Display the option tags for the select element to choose a band.
     *
     * @param integer|string $first_sign First (capital) letter of the band
     *  or '%' for a special symbol
     * @param integer  $band_id Band id
     * @return string Output of the template.
     */
    private function getBandSelectOptions ($first_sign, $band_id)
    {
        $Band_Select_Options = new View();
        if ($first_sign == '') {
            $bands = array(
                array('id' => 1, 'name' => 'TBA'),
                array('id' => 2, 'name' => 'Support')
            );
        } else {
            $Band_Model = new BandModel($this->mysqli);
            $bands = $Band_Model->getBands($first_sign);
        }
        array_splice($bands, 0, 0, array(array('id' => 0, 'name' => '')));
        $bands[] = array('id' => 3, 'name' => 'New band');
        //Test, if the band id is in the array with the choosen bands
        $Band_Select_Options->assign('bands', $bands);
        $Band_Select_Options->assign('band_id', $band_id);
        $Band_Select_Options->setTemplate('band_select_options');
        return $Band_Select_Options->loadTemplate();
    }

    /**
     *  Display the form to enter the name of a new band. Either with type="text"
     *  or type="hidden.
     *
     * @param integer $row Row of the lineup
     * @param integer $band_id Band id of the band.
     * @return string Output of the template.
     */
    private function getBandNewForm($row, $band_id)
    {
        $Session_Model = new ModelSession();
        $lineup = $Session_Model->getBandsLineup();
        $Band_New_Form = new View();
        $Band_New_Form->assign('band_new_name', $lineup[$row]['band_new_name']);
        $Band_New_Form->assign('row', $row);
        $Band_New_Form->assign('band_id', $band_id);
        $Band_New_Form->setTemplate('band_new_form');
        return $Band_New_Form->loadTemplate();
    }

    /**
     * Includes the data from various sources to prefill the the concert formula.
     *
     * @param object $Session_Model Model to access the PHP Session
     */
    private function prefillConcertEditor($Session_Model)
    {
        $model_involved = isset(
            $this->request['edit_id']
        ) and is_int(
            $this->request['edit_id']
        );
        if ($model_involved == true) {
            $Concert_Model = new ModelConcert($this->mysqli);
            $concert = $Concert_Model->getConcert($this->request['edit_id']);
        }
        else {
            $concert = array();
        }

        $this->setRequestEditor($concert, 'name', $model_involved);
        $this->setRequestEditor($concert, 'date_start', $model_involved);
        $this->setRequestEditor($concert, 'city_id', $model_involved);
        $this->setRequestEditor($concert, 'url', $model_involved);

        if (!isset($request['length'])) {
            if ($model_involved == true and !is_null($concert[0]['date_end'])) {
                $date_start = strtotime($concert[0]['date_start']);
                $date_end = strtotime($concert[0]['date_end']);
                $seconds_per_day = 3600 * 24;
                $length = ($date_end - $date_start) / $seconds_per_day;
                $this->request['length'] = length;
            } else {
                $this->request['length'] = 1;
            }
        }

        if ($this->request['city_id'] == 1) {
            $this->request['venue_id'] = 1;
        } else {
            $this->setRequestEditor($concert, 'venue_id', $model_involved);
        }

        /**
         * The important array with lineup information is the array with
         * the band_ids. Other information are added also to the lineup
         * if the corresponding arrays have the same size.
         */
        if (isset($this->request['band_id'])):
            $length_lineup = count($this->request['band_id']);
            $new_band_id = 3;
            $first_sign_check_result = $this->checkLineupArray(
                'first_sign',
                $length_lineup
            );
            $addition_check_result  = $this->checkLineupArray(
                'addition',
                $length_lineup
            );

            if (in_array($this->request['band_id'])) {
                $band_new_name_check_result = $this->checkLineupArray(
                    'band_new_name',
                    $length_lineup
                );
            } else {
                $band_new_name_check_result = array(
                    'include_array' => false,
                    'error' => false
                );
            }

            $Session_Model->delLineUp();
            for (
                $band_index = 0;
                $band_index < count($request['band_id']);
                $band_index++
            ):
                $Session_Model->setBandLineUp($band_index);
                $Session_Model->updateBandLineUp(
                    $band_index,
                    'band_id',
                    $this->request['band_id'][$band_index]
                );
                if ($band_new_name_check_result['include_array'] == true):
                    $Session_Model->updateBandLineUp(
                        $band_index,
                        'band_new_name',
                        $this->request['band_new_name'][$band_index]
                    );
                endif;

                if ($addition_check_result['include_array'] == true):
                    $Session_Model->updateBandLineUp(
                        $band_index,
                        'addition',
                        $this->request['addition'][$band_index]
                    );
                endif;

                if ($first_sign_check_result['include_array'] == true):
                    $Session_Model->updateBandLineUp(
                        $band_index,
                        'first_sign',
                        $this->request['first_sign'][$band_index]
                    );
                else:
                    $Band_Model = new ModelBand($this->mysqli);
                    $band_id = $request['band_id'][$band_index];
                    $band = $Band_Model->getBand($band_id);
                    $first_sign = $this->getFirstSign($band[0]['name']);
                    $Session_Model->updateBandLineUp(
                        $band_index,
                        'first_sign',
                        $first_sign
                    );
                endif;
            endfor;
            /**
             * This defines the error text which is displayed directly above the
             * lineup.
             */
             if (
                 ($band_new_name_check_result['error'] == true
                 or $addition_check_result['error'] == true
                 or $first_sign_check_result['error'] == true)
                 and !isset($this->request['save_id'])
             ):
                 $this->error_text = 'Array lengths in URL parameters does not match! Some data is ignored.';
             endif;
        elseif ($model_involved == true):
            $Session_Model->delLineUp();
            for (
                $band_index = 0;
                $band_index < count($concert[0]['bands']);
                $band_index++
            ):
                $band = $concert[0]['bands'][$band_index];
                $Session_Model->setBandLineUp($band_index);
                $first_sign = $this->getFirstSign($band['name'], 0, 1);
                $Session_Model->updateBandLineUp(
                    $band_index,
                    'first_sign',
                    $first_sign
                );
                $Session_Model->updateBandLineUp(
                    $band_index,
                    'band_id',
                    $band['id']
                );
                $Session_Model->updateBandLineUp(
                    $band_index,
                    'addition',
                    $band['zusatz']
                );
            endfor;
        endif;
    }

    /**
     * Set a parameter which is loaded into an editor formula if it does not
     * exist.
     *
     * @param array $data_array Contain the data from the model.
     * @param integer $parameter Define the parameter name.
     * @param boolean $model_involved Define if data from the model is available.
     */
    private function setRequestEditor($data_array, $parameter, $model_involved)
    {
        if (!isset($this->request[$parameter])) {
            if ($model_involved == true) {
                $this->request[$parameter] = $data_array[0][$parameter];
            } else {
                $this->request[$parameter] = null;
            }
        }
    }

    /**
     * Check if parameter arrays with additional information exist and if they
     * have the right length.
     *
     * @param string $array_name The name of the parameter array which is
     *  checked.
     * @param integer $length_lineup The length of the reference array.
     * @return array Associative array with to keys:
     *  boolean error true: error, false: no error
     *  boolean include_array true: parameter array must be included, false:
     *      array must not be included
     */
    private function checkLineupArray($array_name, $length_lineup)
    {
        if (
            isset($this->request[$array_name])
            and count($this->request[$array_name]) == $length_lineup
        ) {
            $include_array = true;
            $error = false;
        } elseif (
            isset($this->request[$array_name])
            and count($this->request[$array_name]) != $length_lineup
        ) {
            $include_array = false;
            $error = true;
        } else {
            $include_array = false;
            $error = false;
        }
        return array('include_array' => $include_array, 'error' => $error);
    }

    /**
     * This function has the purpose of interacting withe the Concert Model.
     *
     * @return integer Value of 0 or greater -> Succes, -1 -> Error.
     */
    private function saveConcert()
    {
        $Concert_Model = new ModelConcert($this->mysqli);
        /**
         * The starting date is the only value that must be provided.
         * So if it is present, a concert should be inserted or updated
         */

        $error_text = '';
        $error = false;
        if (isset($this->request['url'])):
            $year = substr($this->request['date_start'], 0, 4);
            $month = substr($this->request['date_start'], 5, 2);
            $day = substr($this->request['date_start'], 8, 2);
            if (
                !is_numeric($year)
                or !is_numeric($month)
                or !is_numeric($day)
                or !checkdate($month, $day, $year)
            ) {
                $error_text = "The provided date is not correct.<br>\n";
            }
            if (!isset($this->request['name'])) {
                $this->request['name'] = null;
            }
            if ($this->request['url'] == '' ) {
                $error_text .= "The URL is empty.<br>\n";
            }
            if (!isset($this->request['lenght'])) {
                $this->request['length'] = 1;
            }
            if (!isset($this->request['venue_id'])) {
                $this->request['venue_id'] = null;
            }
            if (!isset($this->request['band_id'])) {
                $this->request['band_id'] = array();
            }
            if (!isset($this->request['addition'])) {
                $this->request['addition'] = array();
            }
            if (!isset($this->request['band_new_name'])) {
                $this->request['band_new_name'] = array();
            }

            $band_id_length = count($this->request['band_id']);
            $band_new_name_length = count($this->request['band_new_name']);
            $addition_length = count($this->request['addition']);
            if (
                $band_new_name_length != $band_id_length
                or $addition_length != $band_id_length
            ) {
                $error_text .="Array lengths in the URL parameters does not match! Some data is ignored.<br>\n";
            }

            if ($error_text != '') {
                $this->rewriteSaveEdit();
                return $error_text;
            }

            //The concert overview should jump to the month in which the concert
            //happens.
            $month = $this->getMonth($this->request['date_start']);
            $this->request['month'] = $month;

            if ($this->request['length'] == 1) {
                $this->request['date_end'] = null;
            } else {
                $date_start = $this->request['date_start'];
                $length = $this->request['length'];
                $date_end = strtotime($date_start . '+' . ($length - 1) . 'day');
                $this->request['date_end'] = date('Y-m-d', $date_end);
            }

            $error_text .= $this->setNewProperty('city');
            $error_text .= $this->setNewProperty('venue');
            $request = $this->request;

            if ($error_text != '') {
                $this->rewriteSaveEdit();
                return $error_text;
            }

            if (
                isset($this->request['save_id'])
                and $this->request['save_id'] > 0
            ) {
                //If the save id is set -> Update of exisiting concert
                $result = $Concert_Model->updateConcert(
                    $this->request['save_id'],
                    $this->request['name'],
                    $this->request['date_start'],
                    $this->request['date_end'],
                    $this->request['venue_id'],
                    $this->request['url']
                );
            }
            else {
                //No save id -> Insert a new concert
                $result = $Concert_Model->setConcert(
                    $this->request['name'],
                    $this->request['date_start'],
                    $this->request['date_end'],
                    $this->request['venue_id'],
                    $this->request['url']
                );
                $this->request['save_id'] = $result;
            }

            $save_id = $this->request['save_id'];
            if (is_numeric($save_id) and $save_id > 0) {
                $result = $Concert_Model->delBands($this->request['save_id']);
                $Band_Model = new ModelBand($this->mysqli);
                for (
                    $lineup_index = 0;
                    $lineup_index < count($request['band_id']);
                    $lineup_index++
                ) {
                    $band_new_id = 3;
                    $band_new_name_array = $this->request['band_new_name'];
                    $band_new_name = $band_new_name_array[$lineup_index];
                    if (
                        $request['band_id'][$lineup_index] == $band_new_id
                        and $band_new_name != ''
                    ):
                        $result = $Band_Model->setBand($band_new_name);
                        if ($result > $band_new_id) {
                            $this->request['band_id'][$lineup_index] = $result;
                        } else {
                            $error_text = 'Adding a new band have gone wrong. ';
                            $error = true;
                        }
                    endif;
                    $result = $Concert_Model->setBand(
                        $save_id,
                        $this->request['band_id'][$lineup_index],
                        $this->request['addition'][$lineup_index]
                    );
                    if ($result == -1) {
                        $error = true;
                    }
                }
            }
            else {
                $error = true;
            }
        endif;

        if (
            isset($this->request['published'])
            and $this->request['published'] == 1
        ) {
            $result = $Concert_Model->setPublished($this->request['save_id']);
        }
        if (
            isset($this->request['sold_out'])
            and $this->request['sold_out'] == 1
        ) {
            $result = $Concert_Model->setSoldOut($this->request['save_id']);
        }

        if ((isset($result) and $result < 1) or $error == true) {
            $error_text .= 'Saving of concert data has gone wrong! ';
            $this->rewriteSaveEdit();
        } else {
            $Session_Model = new ModelSession();
            $Session_Model->delLineUp();
        }
        return $error_text;
    }

    /**
     * Rewrites parameters to reopen the editor.
     */
    private function rewriteSaveEdit()
    {
        if (isset($this->request['save_id'])) {
            $this->request['edit_id'] = $this->request['save_id'];
        }
        $this->request['edit'] = $this->request['save'];
    }

    /**
     * Insert a new property into the database and write the new id into the
     * request array.
     *
     * @param string $type Property which is checked.
     * @param array $request Combined array containing GET and POST data.
     * @return string String witch contains possible error messages.
     */
    private function setNewProperty($type)
    {
        $request = $this->request;
        $error_text = '';
        if (
            isset($request[$type . '_id'])
            and $request[$type . '_id'] == 1
            and isset($request[$type . '_new_name'])
            and $request[$type . '_new_name'] != ''
        ) {
            $type_uc = ucfirst($type);
            $classname = 'Model' . $type_uc;
            $Property_Model = new $classname($this->mysqli);
            if ($type == 'city') {
                $result = $Property_Model->setCity($request['city_new_name']);
                $request['venue_id'] = 1;
            } elseif (
                $type == 'venue'
                and isset($request['city_id'])
                and isset($request['venue_url'])
            ) {
                $result = $Property_Model->setVenue(
                    $request['venue_new_name'],
                    $request['city_id'],
                    $request['venue_url']
                );
            } else {
                $result = -1;
            }

            if ($result > 1) {
                $request[$type . '_id'] = $result;
            } else {
                $error_text = sprintf(
                    'Adding the new %1$s has gone wrong. ',
                    $type
                );
            }
        }
        $this->request = $request;
        return $error_text;
    }

    /**
     * Checks for errors, if the dataset is empty or if the concert data should
     * be displayed or not and than processes the concert data, if necessary.
     *
     * @param array $concert Array with concert data.
     * @param string $month Month from which the data is processed.
     * @return array $result Array witch processed data and template
     */
    private function processConcertData($concerts, $month)
    {
        /**
         * Load the session model to access the session if the output contains
         * the export of just one concert
         */
        if ($this->template == 'concert_export') {
            $Session_Model = new ModelSession();
        }
        if (count($concerts) == 0):
            //No concerts in the chosen month.
            $template = 'default_no_data';
        elseif (
            $this->template == 'concert_export'
            and $Session_Model->getConcertDisplayStatus($this->request['display_id']) == 1
        ):
            $template = 'empty_output';
            $Session_Model->changeConcertDisplayStatus($this->request['display_id']);
        else:
            //Load Model to access the preference table
            $Pref_Model = new ModelPref($this->mysqli);
            //Access database entry with the export language setting
            $pref_export = $Pref_Model->getPrefExportLang();
            switch($pref_export[0]['export_lang']) {
                case 'de_DE':
                    setlocale(LC_TIME, "de_DE", "de_DE.utf8");
                    $timeformat_without_month = '%a, %d.';
                    $timeformat_with_month = '%a, %d. %b';
                    break;
                default:
                    $timeformat_without_month = '%a, %d';
                    $timeformat_with_month = '%a, %d %b';
            }
            for(
                $concert_index = 0;
                $concert_index < count($concerts);
                $concert_index++
            ):
                $time_start = strtotime($concerts[$concert_index]['date_start']);
                //Determine the status of the concert.
                $two_weeks = 1209600;
                $two_months = 5184000;
                if ((($time_start - time() < $two_weeks
                    and is_null($concerts[$concert_index]['date_end']))
                    or ($time_start - time() < $two_months
                    and !is_null($concerts[$concert_index]['date_end'])))
                    and $concerts[$concert_index]['publiziert'] == 0
                ) {
                    $concerts[$concert_index]['status'] = 'urgent';
                } elseif ($concerts[$concert_index]['publiziert'] == 1) {
                    $concerts[$concert_index]['status'] = 'published';
                } else {
                    $concerts[$concert_index]['status'] = 'unpublished';
                }

                if ($this->template == 'concert_export') {
                    /**
                     * Determine the human readable date for the concert table.
                     * Output for a concert export should also include the name
                     * of the month.
                     */
                    $concerts[$concert_index]['date_human'] = strftime(
                        $timeformat_with_month,
                        $time_start
                    );
                    //Switch the display status
                    $display_id = $this->request['display_id'];
                    $Session_Model->changeConcertDisplayStatus($display_id);
                    $template = 'concert_export';
                } elseif ($this->template == 'export') {
                    //Export of many concerts
                    $concerts[$concert_index]['date_human'] = strftime(
                        $timeformat_with_month,
                        $time_start
                    );
                    $template = 'concert_export';
                } else {
                    //Normal display of concerts in a table.
                    $concerts[$concert_index]['date_human'] = strftime(
                        $timeformat_without_month,
                        $time_start
                    );
                    $template = 'default';
                }
                $date = date('Y-m-d', $time_start);
                if ($concerts[$concert_index]['date_end'] != '') {
                    $time_end = strtotime($concerts[$concert_index]['date_end']);
                    if ($this->template == 'concert') {
                        $date_end_human = strftime(
                            $timeformat_with_month,
                            $time_end
                        );
                    }
                    else {
                        $date_end_human = strftime(
                            $timeformat_without_month,
                            $time_end
                        );
                    }
                    $date_human = $concerts[$concert_index]['date_human'];
                    $date_human = $date_human . ' – ' . $date_end_human;
                    $concerts[$concert_index]['date_human'] = $date_human;
                }

                if ($concerts[$concert_index]['venue_name'] == '') {
                    $concerts[$concert_index]['venue_city'] = '';
                } else {
                    $venue_name =  $concerts[$concert_index]['venue_name'];
                    $city_name = $concerts[$concert_index]['city_name'];
                    $venue_city = $venue_name . ', ' . $city_name;
                    $concerts[$concert_index]['venue_city'] = $venue_city;
                }

                for (
                    $lineup_index = 0;
                    $lineup_index < count($concerts[$concert_index]['bands']);
                    $lineup_index++
                ) {
                    $band = $concerts[$concert_index]['bands'][$lineup_index];
                    if ($band['nazi'] == 1) {
                        $concerts[$concert_index]['bands'][$lineup_index]['nazi'] = 'nazi';
                        //Write a non-export indicator to the concert-array.
                        $concerts[$concert_index]['nazi'] = 1;
                    }
                    else {
                        $concerts[$concert_index]['bands'][$lineup_index]['nazi'] = 'nonazi';
                    }
                }
            endfor;
        endif;
        $result['concerts'] = $concerts;
        $result['template'] = $template;
        return $result;
    }

    /**
     * Get the month from the current date or a submitted string.
     *
     * @param string $date Optional date from which the month is generated
     * @return string Generated date
     */
    private function getMonth($date = null)
    {
        if (is_null($date)) {
            return date('Y-m');
        } else {
            return date('Y-m', strtotime($date));
        }
    }
}
