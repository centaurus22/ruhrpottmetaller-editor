<?php

//The controller
class Controller
{
    //NULL Array from $_GET and $_POST.
    private $request = null;
    //string Name of the template.
    private $template = '';
    //object Object representing the (outer) view.
    private $view = null;
    //string String containing error messages
    private $error_text = '';

    /**
     * Initialize the controller.
     *
     * @param array $request Array from  $_GET and $_POST
     */
    public function __construct($request)
    {
        $this->view = new View();
        //translate actions induced by the special parameters
        if (isset($request['special']) and $request['special'] == 'concert' and isset($request['type'])){
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
                include_once('classes/model_concert.php');
                $Concert_Model = new ConcertModel();
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
                include_once('model_session.php');
                $Session_Model = new SessionModel();
                $this->prefillConcertEditor($Session_Model);
                $request = $this->request;
                include_once('model_city.php');
                $City_Model = new CityModel();
                $cities = $City_Model->getCities();
                array_splice($cities, 0, 0, array(array('id' => 0, 'name' => '')));
                $cities[] = array('id' => 1, 'name' => 'New city');
                $innerView->assign('request', $request);
                $innerView->assign('error_text', $this->error_text);
                $innerView->assign('city_venue_form', $this->displayCityVenueForm($request['city_id'], $request['venue_id']));
                $innerView->assign('venue_new_form', $this->displayVenueNewForm($request['venue_id']));
                $innerView->assign('cities', $cities);
                $innerView->assign('month', $month);
                $innerView->assign('lineup', $this->displayLineUp($Session_Model));
                $innerView->setTemplate('concert_edit');
                $this->view->assign('subtitle', 'concert editor');
                break;
            case 'edit_sub':
                $ajax = 1;
                if (isset($request['city_id']) and isset($request['venue_id'])) {
                    $innerView->assign('content', $this->displayCityVenueForm($request['city_id'], $request['venue_id']));
                } elseif (isset($request['venue_id'])) {
                    $innerView->assign('content', $this->displayVenueNewForm($request['venue_id']));

                } else {
                    $innerView->assign('content', '<strong>Something weird happened!</strong>');
                }
                $innerView->setTemplate('ajax');
                break;
            case 'set_url':
                $ajax = 1;
                if (isset($request['venue_id'])) {
                    include_once('classes/model_venue.php');
                    $VenueModel = new VenueModel;
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
                include_once('model_session.php');
                $Session_Model = new SessionModel();
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
                                $Session_Model->shiftBandLineUp($request['row'], $request['direction']);
                            } else {
                                $error = true;
                            }
                            break;
                        case 'save':
                            if (isset($request['field']) and isset($request['value'])) {
                                $Session_Model->updateBandLineUp($request['row'], $request['field'], $request['value']);
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
                $innerView->assign('content', $this->displayLineUp($Session_Model, $error_text));
                break;
            case 'lineup_sub':
                $ajax = 1;
                switch($request['type']) {
                    case 'band_select_options':
                        if (isset($request['first_sign']) and isset($request['band_id'])) {
                            $innerView->assign('content', $this->displayBandSelectOptions($request['first_sign'], $request['band_id']));
                        } else {
                            $innerView->assign('content', '<option value="0">Something weird happened!</option>');
                        }
                        break;
                    case 'band_new_form':
                        if (isset($request['row']) and isset($request['band_id']))
                        {
                            $innerView->assign('content', $this->displayBandNewForm($request['row'], $request['band_id']));
                        } else {
                            $innerView->assign('content', '<strong>Something weird happened!</strong>');
                        }
                        break;
                }
                $innerView->setTemplate('ajax');
                break;
            case 'export':
                //Get header and footer from the database and pass it to the inner view
                include_once('classes/model_pref.php');
                $Pref_Model = new PrefModel();
                $prefs = $Pref_Model->getPref();
                include_once('classes/model_concert.php');
                $Concert_Model = new ConcertModel();
                $concerts = $Concert_Model->getConcerts($month);
                $result = $this->processConcertData($concerts, $month);
                //Assign header and footer to the inner view
                $innerView->assign('header', $prefs[0]['header']);
                $innerView->assign('footer', $prefs[0]['footer']);
                $innerView->assign('concerts', $result['concerts']);
                $innerView->assign('month_changer', $this->displayMonthChanger());
                $innerView->setTemplate('concert_export');
                $this->view->assign('subtitle', 'export');
                break;
            case 'concert_export':
                $ajax = 1;
                //Output of just one concert
                include_once('classes/model_concert.php');
                $Concert_Model = new ConcertModel;
                $concerts = $Concert_Model->getConcert($request['display_id']);
                $result = $this->processConcertData($concerts, $month);
                $innerView->assign('concerts', $result['concerts']);
                $innerView->setTemplate($result['template']);
                break;
            case 'default':
            default:
                //Initialize a View object for the second line of the web application, load the
                //template and pass the output to the inner View.
                $monthChanger = $this->displayMonthChanger();
                include_once('classes/model_concert.php');
                $Concert_Model = new ConcertModel();
                $concerts = $Concert_Model->getConcerts($month);
                $result = $this->processConcertData($concerts, $month);
                //By reloading the default page the status of the individual concert exports
                //must be reseted.
                include_once('model_session.php');
                $Session_Model = new SessionModel;
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
     * Initialize a view for the second line of the web application if necessary, set the template,
     * assign the data to the view, and load the template.
     *
     * @return string Output of the corresponding template.
     */
    private function displayMonthChanger()
    {
        //Initialize a new View class for the second line of the web application
        $monthChanger = new View();
        //Set the corresponding template
        $monthChanger->setTemplate('month_changer');
        //If the display parameter is set, it is passend to all links on the second line
        if(isset($this->request['display'])) {
            $request['display'] = $this->request['display'];
            $request_next_month['display'] = $this->request['display'];
            $request_prev_month['display'] = $this->request['display'];
        }
        //Generate parameters for the current month, the next month and the previous month
        $request_now['month'] = $this->getMonth();
        $request_next_month['month'] = $this->getMonth($this->request['month'] . '-01 + 1 month');
        $request_prev_month['month'] = $this->getMonth($this->request['month'] . '-01 - 1 month');
        $month_human = date('M Y', strtotime($this->request['month'] . '-01'));
        //Assign the variables to the MonthChanger template
        $monthChanger->assign('request_now', $request_now);
        $monthChanger->assign('request_next_month', $request_next_month);
        $monthChanger->assign('request_prev_month', $request_prev_month);
        $monthChanger->assign('month_human', $month_human);
        return $monthChanger->loadTemplate();
    }

    /**
     * Generete a view for the concert lineup
     *
     * @param object $Session_Model Object to access data in the session
     * @return string Output of the lineup template.
     */
    private function displayLineUp($Session_Model, $error_text_lineup = '')
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
            $band_select_options[$lineup_index] = $this->displayBandSelectOptions($bands[$lineup_index]['first_sign'], $bands[$lineup_index]['band_id']);
            $band_new_form[$lineup_index] = $this->displayBandNewForm($lineup_index, $bands[$lineup_index]['band_id']);
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
    private function displayCityVenueForm ($city_id, $venue_id)
    {
        $City_Venue_Form = new View();
        require_once('model_venue.php');
        $Venue_Model = new VenueModel();
        if ($city_id == 0) {
            $venues = $Venue_Model->getVenues();
        } elseif ($city_id == 1) {
            $venues = array();
            if (isset($this->request['city_new_name'])) {
                $City_Venue_Form->assign('city_new_name', $this->request['city_new_name']);
            } else {
                $City_Venue_Form->assign('city_new_name', NULL);
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
     *  Display the form to enter the name of a new venue and to enter a standard URL for that venue if
     *  needed.
     *
     * @param integer $venue_id Band id of the band.
     * @return string Output of the template.
     */
    private function displayVenueNewForm($venue_id)
    {
        $Venue_New_Form = new View();
        if ($venue_id == 1) {
            if (isset($this->request['venue_new_name'])) {
                $Venue_New_Form->assign('venue_new_name', $this->request['venue_new_name']);
            } else {
                $Venue_New_Form->assign('venue_new_name', null);
            }
            if (isset($this->request['venue_url'])) {
                $Venue_New_Form->assign('venue_url', $this->request['venue_url']);
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
     * @param integer|string $first_sign First (capital) letter of the band or '%' for a special symbol
     * @param integer  $band_id Band id
     * @return string Output of the template.
     */
    private function displayBandSelectOptions ($first_sign, $band_id)
    {
        $Band_Select_Options = new View();
        if ($first_sign == '') {
            $bands = array(
                array('id' => 1, 'name' => 'TBA'),
                array('id' => 2, 'name' => 'Support')
            );
        } else {
            require_once('model_band.php');
            $Band_Model = new BandModel();
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
     *  Display the form to enter the name of a new band. Either with type="text" or type="hidden.
     *
     * @param integer $row Row of the lineup
     * @param integer $band_id Band id of the band.
     * @return string Output of the template.
     */
    private function displayBandNewForm($row, $band_id)
    {
        include_once('classes/model_session.php');
        $Session_Model = new SessionModel();
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
        $model_involved = isset($this->request['edit_id']) and is_int($this->request['edit_id']);
        if ($model_involved == true) {
            include_once('model_concert.php');
            $Concert_Model = new ConcertModel();
            $concert = $Concert_Model->getConcert($this->request['edit_id']);
        }
        else {
            $concert = array();
        }

        $this->editorSetRequestParameters($concert, 'name', $model_involved);
        $this->editorSetRequestParameters($concert, 'date_start', $model_involved);
        $this->editorSetRequestParameters($concert, 'city_id', $model_involved);
        $this->editorSetRequestParameters($concert, 'url', $model_involved);

        if (!isset($request['length'])) {
            if ($model_involved == true and !is_null($concert[0]['date_end'])) {
                $date_start = strtotime($concert[0]['date_start']);
                $date_end = strtotime($concert[0]['date_end']);
                $seconds_per_day = 3600 * 24;
                $this->request['length'] = ($date_end - $date_start) / $seconds_per_day;
            } else {
                $this->request['length'] = 1;
            }
        }

        if ($this->request['city_id'] == 1) {
            $this->request['venue_id'] = 1;
        } else {
            $this->editorSetRequestParameters($concert, 'venue_id', $model_involved);
        }

        /**
         * The important array with lineup information is the array with
         * the band_ids. Other information are added also to the lineup
         * if the corresponding arrays have the same size.
         */
        if (isset($this->request['band_id'])) {
            $request = $this->request;
            $length_lineup = count($request['band_id']);
            $new_band_id = 3;
            $result_first_sign_check = $this->checkLineupArrays('first_sign', $length_lineup);
            $result_addition_check  = $this->checkLineupArrays('addition', $length_lineup);
            if (in_array($this->request['band_id'])) {
                $result_band_new_name_check = $this->checkLineupArrays('band_new_name', $length_lineup);
            } else {
                $result_band_new_name_check = array('include_array' -> false, 'error' -> false);
            }

            $request = $this->request;
            $Session_Model->delLineUp();
            for($band_index = 0; $band_index < count($request['band_id']); $band_index++) {
                $Session_Model->setBandLineUp($band_index);
                $Session_Model->updateBandLineUp($band_index, 'band_id', $request['band_id'][$band_index]);
                if ($result_band_new_name_check['include_array'] == true) {
                    $Session_Model->updateBandLineUp($band_index, 'band_new_name', $request['band_new_name'][$band_index]);
                }
                if ($result_addition_check['include_array'] == true) {
                    $Session_Model->updateBandLineUp($band_index, 'addition', $request['addition'][$band_index]);
                }
                if ($result_first_sign_check['include_array'] == true) {
                    $Session_Model->updateBandLineUp($band_index, 'first_sign', $request['first_sign'][$band_index]);
                } else {
                    include_once('model_band.php');
                    $Band_Model = new BandModel;
                    $band = $Band_Model->getBand($request['band_id'][$band_index]);
                    $first_sign = $this->getFirstSign($band[0]['name']);
                    $Session_Model->updateBandLineUp($band_index, 'first_sign', $first_sign);
                }
            }
            $this->request = $request;
            /**
            * This defines the error text which is displayed directly above the lineup.
            */
            if (($result_band_new_name_check['error'] == true
                or $result_addition_check['error'] == true
                or $result_first_sign_check['error'] == true)
                and !isset($this->request['save_id'])) {
                $this->error_text = 'Array lengths in URL parameters does not match! Some data is ignored.';
            }
        } elseif ($model_involved == true) {
            $Session_Model->delLineUp();
            for ($band_index = 0; $band_index < count($concert[0]['bands']); $band_index++) {
                $Session_Model->setBandLineUp($band_index);
                $first_sign = $this->getFirstSign($concert[0]['bands'][$band_index]['name'], 0, 1);
                $Session_Model->updateBandLineUp($band_index, 'first_sign', $first_sign);
                $Session_Model->updateBandLineUp($band_index, 'band_id', $concert[0]['bands'][$band_index]['id']);
                $Session_Model->updateBandLineUp($band_index, 'addition', $concert[0]['bands'][$band_index]['zusatz']);
            }

        }
    }

    /**
     * Set a parameter which is loaded into an editor formula if it does not
     * exist.
     *
     * @param array $data_array Contain the data from the model.
     * @param integer $parameter Define the parameter name.
     * @param boolean $model_involved Define if data from the model is available.
     */
    private function editorSetRequestParameters($data_array, $parameter, $model_involved)
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
    private function checkLineupArrays($array_name, $length_lineup)
    {
        if (isset($this->request[$array_name]) and count($this->request[$array_name]) == $length_lineup) {
            $include_array = true;
            $error = false;
        } elseif (isset($this->request[$array_name]) and count($this->request[$array_name]) != $length_lineup) {
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
        $request = $this->request;
        include_once('classes/model_concert.php');
        $Concert_Model = new ConcertModel();
        /**
         * The starting date is the only value that must be provided.
         * So if it is present, a concert should be inserted or updated
         */

        $error_text = '';
        $error = false;
        if (isset($request['url'])) {

            $year = substr($request['date_start'], 0, 4);
            $month = substr($request['date_start'], 5, 2);
            $day = substr($request['date_start'], 8, 2);
            if (!is_numeric($year) or !is_numeric($month) or !is_numeric($day) or checkdate($month, $day, $year) == false) {
                $error_text = "The provided date is not correct.<br>\n";
            }
            if (!isset($request['name'])) {
                $request['name'] = null;
            }
            if ($request['url'] == '' ) {
                $error_text .= "The URL is empty.<br>\n";
            }
            if (!isset($request['lenght'])) {
                $request['length'] = 1;
            }
            if (!isset($request['venue_id'])) {
                $request['venue_id'] = null;
            }
            if (!isset($request['band_id'])) {
                $request['band_id'] = array();
            }
            if (!isset($request['addition'])) {
                $request['addition'] = array();
            }
            if (!isset($request['band_new_name'])) {
                $request['band_new_name'] = array();
            }
            if (count($request['band_new_name']) != count($request['band_id']) or count($request['addition']) != count($request['band_id'])) {
                $error_text .="Array lengths in the URL parameters does not match! Some data is ignored.<br>\n";
            }

            if ($error_text != '') {
                $this->rewriteSaveEdit();
                return $error_text;
            }

            //The concert overview should jump to the month in which the concert
            //happens.
            $request['month'] = $this->getMonth($request['date_start']);

            if ($request['length'] == 1) {
                $request['date_end'] = null;
            } else {
                $request['date_end'] = strtotime($request['date_start'] . '+' . ($request['length'] - 1) . 'day');
                $request['date_end'] = date('Y-m-d', $request['date_end']);
            }

            $this->request = $request;
            $error_text .= $this->setNewProperty('city', $this->request);
            $error_text .= $this->setNewProperty('venue', $this->request);
            $request = $this->request;

            if ($error_text != '') {
                $this->rewriteSaveEdit();
                return $error_text;
            }

            if (isset($request['save_id']) and $request['save_id'] != '') {
                //If the save id is set -> Update of exisiting concert
                $result = $Concert_Model->updateConcert($request['save_id'], $request['name'],
                    $request['date_start'], $request['date_end'], $request['venue_id'],
                    $request['url']);
            }
            else {
                //No save id -> Insert a new concert
                $result = $Concert_Model->setConcert($request['name'], $request['date_start'],
                    $request['date_end'], $request['venue_id'], $request['url']);
                $request['save_id'] = $result;
            }

            if (is_numeric($request['save_id']) and $request['save_id'] > 0) {
                $result = $Concert_Model->delBands($request['save_id']);
                require_once('classes/model_band.php');
                $Band_Model = new BandModel;
                for ( $lineup_index = 0; $lineup_index < count($request['band_id']); $lineup_index++ ) {
                    if ($request['band_id'][$lineup_index] == 3 and $request['band_new_name'][$lineup_index] != '') {
                        $result = $Band_Model->setBand($request['band_new_name'][$lineup_index]);
                        if ($result > 3) {
                            $request['band_id'][$lineup_index] = $result;
                        } else {
                            $error_text = 'Adding a new band have gone wrong. ';
                            $error = true;
                        }
                    }
                    $result = $Concert_Model->setBand($request['save_id'], $request['band_id'][$lineup_index],
                        $request['addition'][$lineup_index]);
                    if ($result == -1) {
                        $error = true;
                    }
                }
            }
            else {
                $error = true;
            }
        }

        if (isset($request['published']) and $request['published'] == 1) {
            $result = $Concert_Model->setPublished($request['save_id']);
        }
        if (isset($request['sold_out']) and $request['sold_out'] == 1) {
            $result = $Concert_Model->setSoldOut($request['save_id']);
        }

        if ($result < 1 or $error == true) {
            $error_text .= 'Saving of concert data has gone wrong! ';
            $this->rewriteSaveEdit();
        } else {
            include_once('model_session.php');
            $Session_Model = new SessionModel();
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
    private function setNewProperty($type, $request)
    {
        $error_text = '';
        if (isset($request[$type . '_id']) and $request[$type . '_id'] == 1
            and isset($request[$type . '_new_name']) and $request[$type . '_new_name'] != '') {
            require_once('classes/model_' . $type . '.php');
            $type_uc = ucfirst($type);
            $classname = $type_uc . 'Model';
            $Property_Model = new $classname;
            if ($type == 'city') {
                $result = $Property_Model->setCity($request['city_new_name']);
                $request['venue_id'] = 1;
            } elseif ($type == 'venue' and isset($request['city_id']) and isset($request['venue_url'])) {
                $result = $Property_Model->setVenue($request['venue_new_name'], $request['city_id'], $request['venue_url']);
            } else {
                $result = -1;
            }

            if ($result > 1) {
                $request[$type . '_id'] = $result;
            } else {
                $error_text = sprintf('Adding the new %1$s has gone wrong. ', $type);
            }
        }
        $this->request = $request;
        return $error_text;
    }

    /**
     * Checks for errors, if the dataset is empty or if the concert data should be displayed or not
     * and than processes the concert data, if necessary.
     *
     * @param array $concert Array with concert data.
     * @param string $month Month from which the data is processed.
     * @return array $result Array witch processed data and template
     */
    private function processConcertData($concerts, $month)
    {
        //Load the session model to access the session if the output contains the export of just one concert
        if ($this->template == "concert_export") {
            include_once('classes/model_session.php');
            $Session_Model = new SessionModel;
        }
        if (count($concerts) == 0) {
            //No concerts in the chosen month.
            $template = 'default_no_data';
        }
        //If the concert_export template is set and the display status of the concert is 1,
        //the display status ist changed to 0 and no information are displayed-
        elseif ($this->template == "concert_export" and
            $Session_Model->getConcertDisplayStatus($this->request['display_id']) == 1) {
            $template = 'empty_output';
            $Session_Model->changeConcertDisplayStatus($this->request['display_id']);
        } else {
            //Load Model to access the preference table
            include_once('classes/model_pref.php');
            $Pref_Model = new PrefModel();
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
            for($concert_index = 0; $concert_index < count($concerts); $concert_index++) {
                $time_start = strtotime($concerts[$concert_index]['date_start']);
                //Determine the status of the concert.
                $two_weeks = 1209600;
                $two_months = 5184000;
                if ((($time_start - time() < $two_weeks
                    and is_null($concerts[$concert_index]['date_end']))
                    or ($time_start - time() < $two_months
                    and !is_null($concerts[$concert_index]['date_end'])))
                    and $concerts[$concert_index]['publiziert'] == 0) {
                    $concerts[$concert_index]['status'] = 'urgent';
                }
                elseif ($concerts[$concert_index]['publiziert'] == 1) {
                    $concerts[$concert_index]['status'] = 'published';
                }
                else {
                    $concerts[$concert_index]['status'] = 'unpublished';
                }
                if ($this->template == 'concert_export') {
                    //Determine the human readable date for the concert table.
                    //Output for a concert export should also include the name of the month.
                    $concerts[$concert_index]['date_human'] = strftime($timeformat_with_month, $time_start);
                    //Switch the display status
                    $Session_Model->changeConcertDisplayStatus($this->request['display_id']);
                    $template = 'concert_export';
                }
                elseif ($this->template == 'export') {
                    //Export of many concerts
                    $concerts[$concert_index]['date_human'] = strftime($timeformat_with_month, $time_start);
                    $template = 'concert_export';
                }
                else {
                    //Normal display of concerts in a table.
                    $concerts[$concert_index]['date_human'] = strftime($timeformat_without_month, $time_start);
                    $template = 'default';
                }
                $date = date('Y-m-d', $time_start);
                if ($concerts[$concert_index]['date_end'] != '') {
                    $time_end = strtotime($concerts[$concert_index]['date_end']);
                    if ($this->template == 'concert') {
                        $date_end_human = strftime($timeformat_with_month, $time_end);
                    }
                    else {
                        $date_end_human = strftime($timeformat_without_month, $time_end);
                    }
                    $concerts[$concert_index]['date_human'] = $concerts[$concert_index]['date_human'] . ' – ' . $date_end_human;
                }

                if ($concerts[$concert_index]['venue_name'] == '') {
                    $concerts[$concert_index]['venue_city'] = '';
                } else {
                    $concerts[$concert_index]['venue_city'] = $concerts[$concert_index]['venue_name'] . ', ' . $concerts[$concert_index]['city_name'];
                }

                for($lineup_index = 0; $lineup_index < count($concerts[$concert_index]['bands']); $lineup_index++) {
                    if ($concerts[$concert_index]['bands'][$lineup_index]['nazi'] == 1) {
                        $concerts[$concert_index]['bands'][$lineup_index]['nazi'] = 'nazi';
                        //Write a non-export indicator to the concert-array.
                        $concerts[$concert_index]['nazi'] = 1;
                    }
                    else {
                        $concerts[$concert_index]['bands'][$lineup_index]['nazi'] = 'nonazi';
                    }
                }
            }
        }
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
