<?php

namespace ruhrpottmetaller;

use IntlDateFormatter;

class Controller
{
    private ?array $request;
    private ?View $View;
    private ?View $Inner_View;
    private ?\mysqli $mysqli;
    private bool $isAjax = false;
    private string $errorText = '';

    public function __construct(array $request)
    {
        $Utility_Connect = new UtilityConnect();
        $this->mysqli = $Utility_Connect->dbConnect();

        $this->View = new View();
        $this->Inner_View = new View();
        $this->request = $request;

        $this->setRequestParameters();
        $this->updateData();
        $this->requestToOutputType();
    }

    private function setRequestParameters()
    {
        if (
            isset($this->request['special'])
            and $this->request['special'] == 'concert'
            and isset($this->request['type'])
        ) {
            switch ($this->request['type']) {
                case 'edit':
                    if (isset($this->request['id'])) {
                        $this->request['edit_id'] = $this->request['id'];
                    }
                    //no break
                case 'add':
                    $this->request['edit'] = 'concert';
                    break;
                case 'published':
                    if (isset($this->request['id'])) {
                        $this->request['save_id'] = $this->request['id'];
                        $this->request['save'] = 'concert';
                        $this->request['published'] = 1;
                    }
                    break;
                case 'del':
                    if (isset($this->request['id'])) {
                        $this->request['del_id'] = $this->request['id'];
                    }
                    $this->request['del'] = 'concert';
                    break;
                case 'sold_out':
                    if (isset($this->request['id'])) {
                        $this->request['save_id'] = $this->request['id'];
                    }
                    $this->request['save'] = 'concert';
                    $this->request['sold_out'] = 1;
                    break;
            }
            unset($this->request['special']);
        }

        if (!isset($this->request['month'])) {
            $month = $this->getMonth();
            $this->request['month'] = $month;
        }
    }

    private function updateData()
    {
        if (
            isset($this->request['del'])
            and $this->request['del'] == 'concert'
            and isset($this->request['del_id'])
        ) {
            $this->errorText = $this->delConcert();
        }

        if (isset($this->request['save'])) {
            switch ($this->request['save']) {
                case 'concert':
                    $this->errorText = $this->saveConcert();
                    break;
                default:
                    $this->errorText = $this->saveGeneral();
            }
        }
    }

    private function requestToOutputType()
    {
        if (isset($this->request['edit'])) :
            switch ($this->request['edit']) {
                case 'concert':
                    //no break
                default:
                    $this->passDataToConcertEditor();
                    break;
            }
        elseif (isset($this->request['ajax'])) :
            $this->isAjax = true;
            switch ($this->request['ajax']) {
                case 'event_editor_change_lineup':
                    $this->passDataToLineup();
                    break;
                case 'event_editor_change_band':
                    $this->passDataToSubLineup();
                    break;
                case 'event_editor_change_city':
                    //no break
                case 'event_editor_change_venue':
                    $this->passDataToSubEditor();
                    break;
                case 'event_editor_set_url':
                    $this->passDataToUrlField();
                    break;
            }
        else :
            if (!isset($this->request['display'])) {
                $this->request['display'] = 'concert';
            }

            switch ($this->request['display']) {
                case 'license':
                    $this->passDataToLicenseDisplay();
                    break;
                case 'band':
                    $this->passDataToBandsDisplay();
                    break;
                case 'city':
                    $this->passDataToCitiesDisplay();
                    break;
                case 'venue':
                    $this->passDataToVenuesDisplay();
                    break;
                case 'preferences':
                    $this->passDataToPrefEdit();
                    break;
                case 'export':
                    if (isset($this->request['display_id'])) {
                        $this->passDataToConcertExport();
                    } else {
                        $this->passDataToConcertsExport();
                    }
                    break;
                case 'concert':
                    //no break
                default:
                    if (isset($this->request['display_id'])) {
                        $this->isAjax = true;
                        $this->passDataToConcertExport();
                    } else {
                        $this->passDataToConcertsDisplay();
                    }
                    break;
            }
        endif;
    }

    public function getOutput(): string
    {
        if ($this->isAjax == true) {
            $this->View->setTemplate('ajax');
        } else {
            $this->View->setTemplate('ruhrpottmetaller-editor');
        }
        $this->View->assign('pagetitle', 'ruhrpottmetaller-editor – ');
        $this->View->assign('month', $this->request['month']);
        $this->View->assign('menu_entrys', array(
            array('Concerts', 'concert'),
            array('Bands', 'band'),
            array('Cities','city'),
            array('Venues', 'venue'),
            array('Export', 'export'),
            array('Preferences','preferences')
        ));
        $this->View->assign('content', $this->Inner_View->getOutput());
        return $this->View->getOutput();
    }

    private function passDataToConcertEditor()
    {
        $Session_Model = new ModelSession();
        $this->prefillConcertEditor($Session_Model);
        $City_Model = new ModelCity($this->mysqli);
        $cities = $City_Model->getCities('');
        array_splice(
            $cities,
            0,
            0,
            array(array('id' => 0, 'name' => ''))
        );
        $cities[] = array('id' => '1', 'name' => 'New city');
        $this->Inner_View->assign('request', $this->request);
        $this->Inner_View->assign('error_text', $this->errorText);

        $city_venue_form = $this->getCityVenueForm(
            $this->request['city_id'],
            $this->request['venue_id']
        );
        $this->Inner_View->assign('city_venue_form', $city_venue_form);

        $venue_new_form = $this->getVenueNewForm($this->request['venue_id']);
        $this->Inner_View->assign('venue_new_form', $venue_new_form);

        $this->Inner_View->assign('cities', $cities);
        $this->Inner_View->assign('month', $this->request['month']);

        $lineup = $this->getLineUp($Session_Model);
        $this->Inner_View->assign('lineup', $lineup);

        $this->Inner_View->setTemplate('concert_edit');
        $this->View->assign('subtitle', 'concert editor');
    }

    private function passDataToLicenseDisplay()
    {
        $this->Inner_View->setTemplate('license');
        $this->View->assign('subtitle', 'License');
    }

    private function passDataToBandsDisplay()
    {
        $Band_Model = new ModelBand($this->mysqli);
        $filter_value = $this->getFilterValue();
        $result = $Band_Model->getBands($filter_value);
        $this->passGeneralDataToDisplay($result, $filter_value);
        $this->View->assign('subtitle', 'bands');
    }

    private function passDataToCitiesDisplay()
    {
        $City_Model = new ModelCity($this->mysqli);
        $filter_value = $this->getFilterValue();
        $result = $City_Model->getCities($filter_value);
        $this->passGeneralDataToDisplay($result, $filter_value);
        $this->View->assign('subtitle', 'cities');
    }

    private function passDataToVenuesDisplay()
    {
        $Venue_Model = new ModelVenue($this->mysqli);
        $filter_value = $this->getFilterValue();
        $result = $Venue_Model->getVenuesByCity($filter_value);
        $this->passGeneralDataToDisplay($result, $filter_value);
        $this->View->assign('subtitle', 'venues');
    }

    private function getFilterValue()
    {
        if (isset($this->request['display_filter'])) {
            $filter_value = $this->request['display_filter'];
            unset($this->request['display_filter']);
        } else {
            $filter_value = '';
        }
        return $filter_value;
    }

    private function passGeneralDataToDisplay(array $result, string $filter_value)
    {
        $this->Inner_View->assign(
            'filter_value_changer',
            $this->getFilterValueChanger($filter_value)
        );
        if (count($result) > 0) {
            $data = $this->getDataArray($this->request['display']);
            $this->Inner_View->assign('display', $this->request['display']);
            $this->Inner_View->assign('result', $result);
            $this->Inner_View->assign('filter_value', $filter_value);
            $this->Inner_View->assign('data_array', $data);
            $this->Inner_View->assign('error_text', $this->errorText);
            $this->Inner_View->assign('month', $this->request['month']);
            $this->Inner_View->setTemplate('general_display');
        } else {
            $this->Inner_View->setTemplate('general_display_no_data');
        }
    }

    private function passDataToPrefEdit()
    {
        if (isset($this->errorText) and $this->errorText != '') {
            $this->Inner_View->assign('error_text', $this->errorText);
        } else {
            $this->Inner_View->assign('error_text', '');
        }
        $Pref_Model = new ModelPreferences($this->mysqli);
        $result = $Pref_Model->getPreferences();
        $data = $this->getDataArray('preferences');

        foreach ($data as $field) {
            if (isset($this->request[$field['ref']])) {
                $result[0][$field['ref']] = $this->request[$field['ref']];
            }
        }

        $this->Inner_View->assign('result', $result);
        $this->Inner_View->assign('data_array', $data);
        $this->Inner_View->setTemplate('pref_edit');
        $this->View->assign('subtitle', 'preferences');
    }

    private function getDataArray(string $type): array
    {
        switch ($type) {
            case 'preferences':
                $data[] = array(
                    'ref' => 'save',
                    'type' => 'hidden',
                    'value' => 'preferences'
                );
                $data[] = array(
                    'name' => 'Export lang',
                    'ref' => 'export_lang',
                    'type' => 'select',
                    'options' => array('en_GB' => 'English', 'de_DE' => 'German')
                );
                $data[] = array(
                    'name' => 'Header',
                    'ref' => 'header',
                    'type' => 'textarea',
                    'description' => 'Export header'
                );
                $data[] = array(
                    'name' => 'Footer',
                    'ref' => 'footer',
                    'type' => 'textarea',
                    'description' => 'Footer header'
                );
                $data[] = array(
                    'ref' => 'month',
                    'type' => 'hidden',
                    'value' => $this->request['month']
                );
                break;
            case 'city':
                $data[] = array(
                    'ref' => 'save_id',
                    'type' => 'hidden_save'
                );
                $data[] = array(
                    'name' => 'Name',
                    'ref' => 'name',
                    'type' => 'string',
                    'description' => 'Name of the city'
                );
                break;
            case 'venue':
                $data[] = array(
                    'ref' => 'save_id',
                    'type' => 'hidden_save'
                );
                $data[] = array(
                    'name' => 'Name',
                    'ref' => 'name',
                    'type' => 'string_edit',
                    'description' => 'Name of the venue'
                );
                $data[] = array(
                    'name' => 'City',
                    'ref' => 'city_name',
                    'type' => 'string_display'
                );
                $data[] = array(
                    'name' => 'Default URL',
                    'ref' => 'url',
                    'type' => 'string_edit',
                    'description' => 'Default URL of the venue'
                );
                break;
            case 'band':
                $data[] = array(
                    'ref' => 'save_id',
                    'type' => 'hidden_save'
                );
                $data[] = array(
                    'name' => 'Name',
                    'ref' => 'name',
                    'type' => 'string',
                    'description' => 'Name of the Band'
                );
                $data[] = array(
                    'name' => 'Visible',
                    'ref' => 'visible',
                    'type' => 'bool',
                    'description' => 'Visible'
                );
                break;
            default:
                $data = array();
        }
        return $data;
    }

    private function getFilterValueChanger($filter_value): string
    {
        $PropertyChanger = new View();
        switch ($this->request['display']) {
            case 'band':
            //no break
            case 'city':
                $alphabet = range('A', 'Z');
                array_unshift($alphabet, '');
                $alphabet[] = '%';
                $result = array_combine($alphabet, $alphabet);
                break;
            case 'venue':
                $City_Model = new ModelCity($this->mysqli);
                $result = $City_Model->getCities('');
                $city_ids = array_column($result, 'id');
                $city_names = array_column($result, 'name');
                $result = array_combine($city_ids, $city_names);
                $result = array('' => '') + $result;
                break;
        }
        $PropertyChanger->assign('request', $this->request);
        $PropertyChanger->assign('filter_value_list', $result);
        $PropertyChanger->assign('filter_value', $filter_value);
        $PropertyChanger->setTemplate('filter_value_changer');
        return $PropertyChanger->getOutput();
    }

    private function passDataToConcertExport()
    {
        $Concert_Model = new ModelConcert($this->mysqli);
        $concerts = $Concert_Model->getConcert($this->request['display_id']);
        $result = $this->processConcertData(
            $concerts,
            'concert_export'
        );
        $this->Inner_View->assign('concerts', $result['concerts']);
        $this->Inner_View->setTemplate($result['template']);
    }

    private function passDataToConcertsExport()
    {
        $Pref_Model = new ModelPreferences($this->mysqli);
        $preferences = $Pref_Model->getPreferences();
        $Concert_Model = new ModelConcert($this->mysqli);
        $concerts = $Concert_Model->getConcerts($this->request['month']);
        $result = $this->processConcertData(
            $concerts,
            'export'
        );
        $this->Inner_View->assign('header', $preferences[0]['header']);
        $this->Inner_View->assign('footer', $preferences[0]['footer']);
        $this->Inner_View->assign('concerts', $result['concerts']);
        $this->Inner_View->assign('month_changer', $this->getMonthChanger());
        $this->Inner_View->setTemplate('concert_export');
        $this->View->assign('subtitle', 'export');
    }

    private function passDataToConcertsDisplay()
    {
        $monthChanger = $this->getMonthChanger();
        $Concert_Model = new ModelConcert($this->mysqli);
        $concerts = $Concert_Model->getConcerts($this->request['month']);
        $result = $this->processConcertData(
            $concerts,
            'concert'
        );

        $Session_Model = new ModelSession();
        $Session_Model->delConcertDisplayStatus();
        $this->Inner_View->assign('concerts', $result['concerts']);
        $this->Inner_View->assign('month', $this->request['month']);
        $this->Inner_View->assign('month_changer', $monthChanger);
        $this->Inner_View->setTemplate($result['template']);
        $this->View->assign('subtitle', 'concerts');
    }

    private function passDataToLineup()
    {
        $error = false;
        $Session_Model = new ModelSession();
        if (isset($this->request['type']) and isset($this->request['row'])) {
            switch ($this->request['type']) {
                case 'add':
                    $Session_Model->setBandLineUp($this->request['row']);
                    break;
                case 'del':
                    $Session_Model->delBandLineUp($this->request['row']);
                    break;
                case 'shift':
                    if (isset($this->request['direction'])) {
                        $Session_Model->shiftBandLineUp(
                            $this->request['row'],
                            $this->request['direction']
                        );
                    } else {
                        $error = true;
                    }
                    break;
                case 'save':
                    if (
                        isset($this->request['field'])
                        and isset($this->request['value'])
                    ) {
                        $Session_Model->updateBandLineUp(
                            $this->request['row'],
                            $this->request['field'],
                            $this->request['value']
                        );
                        exit;
                    } else {
                        $error = true;
                    }
            }
        } else {
            $error = true;
        }

        if ($error == true) {
            $error_text = 'Something weird happened. The request could not be processed!';
        } else {
            $error_text = '';
        }
        $this->Inner_View->setTemplate('ajax');
        $lineup = $this->getLineUp($Session_Model, $error_text);
        $this->Inner_View->assign('content', $lineup);
    }

    private function getLineUp(ModelSession $Session_Model, string $error_text_lineup = ''): string
    {
        $lineUp = new View();
        $lineUp->setTemplate('lineup');
        $bands = $Session_Model->GetBandsLineUp();
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
        $lineUp->assign('band_select_options', $band_select_options);
        $lineUp->assign('band_new_form', $band_new_form);
        $lineUp->assign('error_text', $error_text_lineup);
        $lineUp->assign('lineup', $bands);
        return $lineUp->getOutput();
    }

    private function passDataToSubLineup()
    {
        $request = $this->request;
        switch ($request['type']) {
            case 'band_select_options':
                if (isset($request['first_sign']) and isset($request['band_id'])) {
                    $band_select_options = $this->getBandSelectOptions(
                        $request['first_sign'],
                        $request['band_id']
                    );
                    $this->Inner_View->assign('content', $band_select_options);
                } else {
                    $this->Inner_View->assign(
                        'content',
                        '<option value="0">Something weird happened!</option>'
                    );
                }
                break;
            case 'band_new_form':
                if (isset($request['row']) and isset($request['band_id'])) {
                    $band_new_form = $this->getBandNewForm(
                        $request['row'],
                        $request['band_id']
                    );
                    $this->Inner_View->assign('content', $band_new_form);
                } else {
                    $this->Inner_View->assign(
                        'content',
                        '<strong>Something weird happened!</strong>'
                    );
                }
                break;
        }
        $this->Inner_View->setTemplate('ajax');
    }

    private function passDataToSubEditor()
    {
        $request = $this->request;
        if (isset($request['city_id']) and isset($request['venue_id'])) {
            $city_venue_form = $this->getCityVenueForm(
                $request['city_id'],
                $request['venue_id']
            );
            $this->Inner_View->assign('content', $city_venue_form);
        } elseif (isset($request['venue_id'])) {
            $venue_new_form = $this->getVenueNewForm($request['venue_id']);
            $this->Inner_View->assign('content', $venue_new_form);
        } else {
            $error_text = '<strong>Something weird happened!</strong>';
            $this->Inner_View->assign('content', $error_text);
        }
        $this->Inner_View->setTemplate('ajax');
    }

    private function passDataToUrlField()
    {
        if (
            isset($this->request['venue_id'])
            and $this->request['venue_id'] != 0
            and $this->request['venue_id'] != 1
        ) {
            $VenueModel = new ModelVenue($this->mysqli);
            $venue = $VenueModel->getVenueById($this->request['venue_id']);
            $this->Inner_View->assign('content', $venue[0]['url']);
        } else {
            $this->Inner_View->assign('content', '');
        }
        $this->Inner_View->setTemplate('ajax');
    }

    private function getMonthChanger(): string
    {
        $monthChanger = new View();
        $monthChanger->setTemplate('month_changer');
        if (isset($this->request['display'])) {
            $request_month_prev['display'] = $this->request['display'];
            $request_month_next['display'] = $this->request['display'];
        }
        $request_month_now['month'] = $this->getMonth();
        $month_next = $this->request['month'] . '-01 + 1 month';
        $month_prev = $this->request['month'] . '-01 - 1 month';
        $request_month_next['month'] = $this->getMonth($month_next);
        $request_month_prev['month'] = $this->getMonth($month_prev);
        $month_human = date('M Y', strtotime($this->request['month'] . '-01'));
        $monthChanger->assign('request_now', $request_month_now);
        $monthChanger->assign('request_next_month', $request_month_next);
        $monthChanger->assign('request_prev_month', $request_month_prev);
        $monthChanger->assign('month_human', $month_human);
        return $monthChanger->getOutput();
    }

    private function getFirstSign(?string $band_name): string
    {
        $first_char = mb_substr($band_name ?? '', 0, 1);
        $first_char = mb_strtoupper($first_char);
        if (in_array($first_char, range('A', 'Z'))) {
            return $first_char;
        } else {
            return '%';
        }
    }

    private function getCityVenueForm(?string $city_id, ?string $venue_id): string
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
        $City_Venue_Form->assign('city_id', $city_id);
        $City_Venue_Form->assign('venues', $venues);
        $City_Venue_Form->assign('venue_id', $venue_id);
        $City_Venue_Form->setTemplate('city_venue_form');
        return $City_Venue_Form->getOutput();
    }

    private function getVenueNewForm($venue_id): string
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
        return $Venue_New_Form->getOutput();
    }

    private function getBandSelectOptions($first_sign, ?int $band_id): string
    {
        if ($first_sign == '') {
            $bands = array(
                array('id' => 1, 'name' => 'TBA'),
                array('id' => 2, 'name' => 'Support')
            );
        } else {
            $Band_Model = new ModelBand($this->mysqli);
            $bands = $Band_Model->getBands($first_sign);
        }
        array_splice($bands, 0, 0, array(array('id' => 0, 'name' => '')));
        $bands[] = array('id' => 3, 'name' => 'New band');
        $Band_Select_Options = new View();
        $Band_Select_Options->assign('bands', $bands);
        $Band_Select_Options->assign('band_id', $band_id);
        $Band_Select_Options->setTemplate('band_select_options');
        return $Band_Select_Options->getOutput();
    }

    private function getBandNewForm(int $row, ?int $band_id): string
    {
        $Session_Model = new ModelSession();
        $lineup = $Session_Model->getBandsLineup();
        $Band_New_Form = new View();
        $Band_New_Form->assign('band_new_name', $lineup[$row]['band_new_name']);
        $Band_New_Form->assign('row', $row);
        $Band_New_Form->assign('band_id', $band_id);
        $Band_New_Form->setTemplate('band_new_form');
        return $Band_New_Form->getOutput();
    }

    private function prefillConcertEditor(ModelSession $Session_Model)
    {
        $model_involved = (isset($this->request['edit_id']) and is_numeric($this->request['edit_id']));
        if ($model_involved) {
            $Concert_Model = new ModelConcert($this->mysqli);
            $concert = $Concert_Model->getConcert($this->request['edit_id']);
        } else {
            $concert = array();
        }

        $this->setRequestEditor($concert, 'name', $model_involved);
        $this->setRequestEditor($concert, 'date_start', $model_involved);
        $this->setRequestEditor($concert, 'city_id', $model_involved);
        $this->setRequestEditor($concert, 'url', $model_involved);

        if (!isset($this->request['length'])) {
            if ($model_involved and $concert[0]['date_end'] != '') {
                $date_start = strtotime($concert[0]['date_start']);
                $date_end = strtotime($concert[0]['date_end']);
                $seconds_per_day = 3600 * 24;
                $length = ($date_end - $date_start) / $seconds_per_day;
                $this->request['length'] = $length + 1;
            } else {
                $this->request['length'] = 1;
            }
        }

        if ($this->request['city_id'] == 1) {
            $this->request['venue_id'] = 1;
        } else {
            $this->setRequestEditor($concert, 'venue_id', $model_involved);
        }

        if (isset($this->request['band_id'])) :
            $length_lineup = count($this->request['band_id']);
            $first_sign_check_result = $this->checkLineupArray(
                'first_sign',
                $length_lineup
            );
            $addition_check_result  = $this->checkLineupArray(
                'addition',
                $length_lineup
            );
            $new_band_id = 3;
            if (in_array($new_band_id, $this->request['band_id'])) {
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
                $band_index < count($this->request['band_id']);
                $band_index++
            ) :
                $Session_Model->setBandLineUp($band_index);
                $Session_Model->updateBandLineUp(
                    $band_index,
                    'band_id',
                    $this->request['band_id'][$band_index]
                );
                if ($band_new_name_check_result['include_array']) :
                    $Session_Model->updateBandLineUp(
                        $band_index,
                        'band_new_name',
                        $this->request['band_new_name'][$band_index]
                    );
                endif;

                if ($addition_check_result['include_array']) :
                    $Session_Model->updateBandLineUp(
                        $band_index,
                        'addition',
                        $this->request['addition'][$band_index]
                    );
                endif;

                if ($first_sign_check_result['include_array']) :
                    $Session_Model->updateBandLineUp(
                        $band_index,
                        'first_sign',
                        $this->request['first_sign'][$band_index]
                    );
                else :
                    $Band_Model = new ModelBand($this->mysqli);
                    $band_id = $this->request['band_id'][$band_index];
                    $band = $Band_Model->getBand($band_id);
                    $first_sign = $this->getFirstSign($band[0]['name']);
                    $Session_Model->updateBandLineUp(
                        $band_index,
                        'first_sign',
                        $first_sign
                    );
                endif;
            endfor;

            if (
                 ($band_new_name_check_result['error']
                 or $addition_check_result['error']
                 or $first_sign_check_result['error'])
                 and !isset($this->request['save_id'])
            ) :
                 $this->errorText = 'Array lengths in URL parameters does not match! Some data is ignored.';
            endif;
        elseif ($model_involved) :
            $Session_Model->delLineUp();
            for (
                $band_index = 0;
                $band_index < count($concert[0]['bands']);
                $band_index++
            ) :
                $band = $concert[0]['bands'][$band_index];
                $Session_Model->setBandLineUp($band_index);
                $first_sign = $this->getFirstSign($band['name']);
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

    private function setRequestEditor(array $data_array, string $parameter, bool $model_involved): void
    {
        if (!isset($this->request[$parameter])) {
            if ($model_involved) {
                $this->request[$parameter] = $data_array[0][$parameter];
            } else {
                $this->request[$parameter] = null;
            }
        }
    }

    private function checkLineupArray(string $array_name, int $length_lineup): array
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

    private function delConcert(): string
    {
        $Concert_Model = new ModelConcert($this->mysqli);
        $result = $Concert_Model->delConcert($this->request['del_id']);
        if ($result < 1) {
            return 'Concert could not be deleted';
        } else {
            return '';
        }
    }

    private function saveGeneral(): string
    {
        $type = $this->request['save'];
        $data = $this->getDataArray($type);
        $error = false;

        foreach ($data as $field) {
            if (
                !isset($this->request[$field['ref']])
                and $field['type'] != 'string_display'
            ) {
                $error = true;
            } elseif (
                $field['type'] != 'hidden'
                and $field['type'] != 'string_display'
            ) {
                $values[] = $this->request[$field['ref']];
            }
        }
        if ($error === false) {
            $class = 'ruhrpottmetaller\\Model' . ucfirst($type);
            $method = 'update' . ucfirst($type);
            $Data_Model = new  $class($this->mysqli);
            $return = call_user_func(array($Data_Model, $method), ...$values);
        }

        $this->request['display'] = $type;

        if ($error === true or $return === -1) {
            return "Saving has gone wrong";
        }
        return "";
    }

    private function saveConcert(): string
    {
        $Concert_Model = new ModelConcert($this->mysqli);

        $error_text = '';
        $error = false;
        if (isset($this->request['url'])) :
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
            if ($this->request['url'] == '') {
                $error_text .= "The URL is empty.<br>\n";
            }
            if (!isset($this->request['length'])) {
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
                $error_text .= "Array lengths in the URL parameters does not match! Some data is ignored.<br>\n";
            }

            if ($error_text != '') {
                $this->rewriteSaveEdit();
                return $error_text;
            }

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
                $result = $Concert_Model->updateConcert(
                    $this->request['save_id'],
                    $this->request['name'],
                    $this->request['date_start'],
                    $this->request['date_end'],
                    $this->request['venue_id'],
                    $this->request['url']
                );
            } else {
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
                    ) :
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
            } else {
                $error = true;
            }
        endif;

        if ($error) {
            $error_text .= 'Saving of concert data has gone wrong! ';
            $this->rewriteSaveEdit();
        } else {
            $Session_Model = new ModelSession();
            $Session_Model->delLineUp();
        }

        if (
            isset($this->request['published'])
            and $this->request['published'] == 1
        ) {
            $ModelConcert = new ModelConcert($this->mysqli);
            $result = $ModelConcert->setPublished($this->request['save_id']);
        }
        if (
            isset($this->request['sold_out'])
            and $this->request['sold_out'] == 1
        ) {
            $result = $Concert_Model->setSoldOut($this->request['save_id']);
        }

        if (isset($result) and $result == -1) {
            $error_text .= 'Property change could not be saved. ';
        }
        return $error_text;
    }

    private function rewriteSaveEdit(): void
    {
        if (isset($this->request['save_id'])) {
            $this->request['edit_id'] = $this->request['save_id'];
        }
        $this->request['edit'] = $this->request['save'];
    }

    private function setNewProperty(string $type): string
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
            $classname = 'ruhrpottmetaller\Model' . $type_uc;
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

    private function processConcertData($concerts, string $type = 'concert'): array
    {
        if (count($concerts) == 0) :
            $template = 'default_no_data';
        else :
            $Pref_Model = new ModelPreferences($this->mysqli);
            $pref_export = $Pref_Model->getPreferencesExportLang();
            switch ($pref_export[0]['export_lang']) {
                case 'de_DE':
                    $time_format_without_month = 'EE, d.';
                    $time_format_with_month = 'E, d. MMM';
                    break;
                default:
                    $time_format_without_month = 'E, d';
                    $time_format_with_month = 'E, d MM';
            }
            for (
                $concert_index = 0;
                $concert_index < count($concerts);
                $concert_index++
            ) :
                $time_start = strtotime($concerts[$concert_index]['date_start']);
                $two_weeks = 1209600;
                $two_months = 5184000;
                if (
                    ($time_start - time() < $two_weeks and is_null($concerts[$concert_index]['date_end'])
                    or ($time_start - time() < $two_months and !is_null($concerts[$concert_index]['date_end'])))
                    and $concerts[$concert_index]['published'] === 0
                ) {
                    $concerts[$concert_index]['status'] = 'urgent';
                } elseif ($concerts[$concert_index]['published'] === 1) {
                    $concerts[$concert_index]['status'] = 'published';
                } else {
                    $concerts[$concert_index]['status'] = 'unpublished';
                }

                if ($type == 'concert_export') {
                    $format = datefmt_create(
                        $pref_export[0]['export_lang'],
                        IntlDateFormatter::FULL,
                        IntlDateFormatter::FULL,
                        null,
                        IntlDateFormatter::GREGORIAN,
                        $time_format_with_month
                    );
                    $date_human = datefmt_format($format, $time_start);
                    $concerts[$concert_index]['date_human'] = $this->removeDotAfterDayOfWeek($date_human);
                    $template = 'concert_export';
                } elseif ($type == 'export') {
                    $format = datefmt_create(
                        $pref_export[0]['export_lang'],
                        IntlDateFormatter::FULL,
                        IntlDateFormatter::FULL,
                        null,
                        IntlDateFormatter::GREGORIAN,
                        $time_format_with_month
                    );
                    $date_human = datefmt_format($format, $time_start);
                    $concerts[$concert_index]['date_human'] = $this->removeDotAfterDayOfWeek($date_human);
                    $template = 'concert_export';
                } else {
                    $format = datefmt_create(
                        $pref_export[0]['export_lang'],
                        IntlDateFormatter::TRADITIONAL,
                        IntlDateFormatter::FULL,
                        null,
                        IntlDateFormatter::GREGORIAN,
                        $time_format_without_month
                    );
                    $date_human = datefmt_format($format, $time_start);
                    $concerts[$concert_index]['date_human'] = $this->removeDotAfterDayOfWeek($date_human);
                    $template = 'default';
                }
                if ($concerts[$concert_index]['date_end'] != '') {
                    $time_end = strtotime($concerts[$concert_index]['date_end']);
                    if ($type == 'export' or $type == 'concert_export') {
                        $format = datefmt_create(
                            $pref_export[0]['export_lang'],
                            IntlDateFormatter::FULL,
                            IntlDateFormatter::FULL,
                            null,
                            IntlDateFormatter::GREGORIAN,
                            $time_format_with_month
                        );
                    } else {
                        $format = datefmt_create(
                            $pref_export[0]['export_lang'],
                            IntlDateFormatter::SHORT,
                            IntlDateFormatter::FULL,
                            null,
                            IntlDateFormatter::GREGORIAN,
                            $time_format_without_month
                        );
                    }
                    $date_end_human = datefmt_format(
                        $format,
                        $time_end
                    );
                    $date_end_human = $this->removeDotAfterDayOfWeek($date_end_human);
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
                    if ($band['visible'] == 1) {
                        $concerts[$concert_index]['bands'][$lineup_index]['visible'] = 'visible';
                    } else {
                        $concerts[$concert_index]['bands'][$lineup_index]['visible'] = 'invisible';
                        $concerts[$concert_index]['visible'] = false;
                    }
                }
            endfor;
        endif;
        $result['concerts'] = $concerts;
        $result['template'] = $template;
        return $result;
    }

    private function removeDotAfterDayOfWeek($date): string
    {
        return substr($date, 0, 2) . substr($date, 3);
    }

    private function getMonth(?string $date = null): string
    {
        if (is_null($date)) {
            return date('Y-m');
        } else {
            return date('Y-m', strtotime($date));
        }
    }
}
