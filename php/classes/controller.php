<?php
//
class Controller {
	//NULL Array from $_GET and $_POST.
	private $request = NULL;
	//string Name of the template.
	private $template = '';
	//string folder in which images are stored.
	private $image_path = 'images';
	//object Object of the (outer) view.
	private $view = NULL;
	//integer Defines if the call is an ajax call.
	private $ajax = 0;

	/**
	 * Initialize the controller.
	 *
	 * @param array request Array from  $_GET and $_POST
	 */
	public function __construct($request) {
		$this->view = new View();
		//translate actions induced by the special parameters
		if (isset($request['special'])) {
			switch($request['special']) {
				case 'edit_concert':
					if (isset($request['id'])) {
						$request['edit_id'] = $request['id'];
					}
				case 'add_concert':
					$request['edit'] = 'concert';
					break;
				case 'published_concert':
						if (isset($request['id'])) {
							$request['save_id'] = $request['id'];
						}
						$request['save'] = 'concert';
						$request['published'] = 1;
						break;
				case 'del_concert':
						if (isset($request['id'])) {
							$request['del_id'] = $request['id'];
						}
						$request['del'] = 'concert';
						break;
				case 'sold_out_concert':
						if (isset($request['id'])) {
							$request['save_id'] = $request['id'];
						}
						$request['save'] = 'concert';
						$request['sold_out'] = 1;
						break;
				}
		}
		$this->request = $request;
		//Execution of save or del actions
		//Open database connection
		$mysqli = ConnectModel::db_connect();
		if (isset($request['del']) AND isset($request['del_id'])) {
			switch($request['del']) {
				case 'concert':
					$Concert_Model = new ConcertModel($mysqli);
					$Concert_Model->delConcert($request['del_id']);
					break;
			}
		}
		if (isset($request['save']) AND isset($request['save_id'])) {
			switch($request['save']) {
			case 'concert':
				$result = save_concert($mysqli);
				break;
			}

		}
		ConnectModel::db_disconnect($mysqli);
		/**
		 * translation of request parameters to the name of the
		 * corresponding template.
		 */

		if (isset($request['display'])) {
			switch($request['display']) {
			case 'license':
				$this->template = 'license';
				break;
			case 'concert':
			default:
					if (isset($request['display_id'])) {
						$this->template = 'concert';
					}
					else {
						$this->template = 'default';
					}
			}
		}
		elseif (isset($request['edit'])) {

		}
	}

	/**
	 * Function to display the content
	 *
	 * @return stringt Content of the application
	 */
	public function display() {
		$innerView = new View();
		if (isset($this->request['month'])) {
			$month =  $this->request['month'];
		}
		else {
			//Create the month value containing the current month
			$month = date('Y-m'); 
			$this->request['month'] = $month;
		}
		$this->view->assign('month', $month);
		$innerView->assign('image_path', $this->image_path);
		switch($this->template) {
			case 'license':
				$innerView->setTemplate('license');
				$this->view->assign('subtitle', 'License');
				break;
			case 'concert':
				//To determine if the ajax concert output should be empty or not, the access of the 
				//session is necessary
				$ajax = 1;
			case 'default':
			default:
				//Initialize a View object for the second line of the web application, load the
				//template and pass the output to the inner View
				$monthChanger = $this->displayMonthChanger();
				$innerView->assign('month_changer', $monthChanger);
				$mysqli = ConnectModel::db_connect();
				//Load the models for accessing the concert table
				$Concert_Model = new ConcertModel($mysqli);
				$Concert_Model->startConcertDisplaySession();
				if ($this->template == 'concert') {
					//Output of just one concert
					$innerView->setTemplate('concert');
					$concerts = $Concert_Model->getConcert($this->request['display_id']);
				} 
				else {
					//Normal output of data of all concerts from one month.
					$innerView->setTemplate('default');
					$concerts = $Concert_Model->getConcerts($month);
					//By reloading the default page the status of the individual concert exports
					//must be reseted.
					$Concert_Model->delConcertDisplayStatus();
				}
				
				if (!$concerts) {
					//Database query failure
					$innerView->setTemplate('query_failure');
				}
				elseif (!($concerts->num_rows)) {
					//No concerts in the chosen month.
					$innerView->assign('month', $month);
					$innerView->setTemplate('default_no_data');
				}
				elseif ($this->template == "concert" AND 
					$Concert_Model->getConcertDisplayStatus($this->request['display_id'])) {
					$innerView->setTemplate('empty_output');
					$Concert_Model->changeConcertDisplayStatus($this->request['display_id']);
				}
				else {
					//Load Model to access the preference table
					$Pref_Model = new PrefModel($mysqli);
					//Access database entry with the export language setting
					$pref_export_result = $Pref_Model->getPrefExportLang();
					$pref_export = $pref_export_result->fetch_assoc();
					switch($pref_export['export_lang']) {
					case 'de_DE':
						setlocale(LC_TIME, "de_DE", "de_DE.utf8");
						$timeformat_without_month = '%a, %d.';
						$timeformat_with_month = '%a, %d. %b';

						break;
					default:
						$timeformat_without_month = '%a, %d';
						$timeformat_with_month = '%a, %d %b';
					}
					$concerts_array = array();
					while($concert = $concerts->fetch_assoc()) {
						$time_start = strtotime($concert['datum_beginn']);
						//Determine the status of the concert.
						if ((($time_start - time() < 1209600 AND is_null($concert['datum_ende'])) 
							OR ($time_start - time() < 5184000 AND !is_null($concert['datum_ende'])))
							AND !$concert['publiziert']) {
							$status='urgent';
						}
						elseif ($concert['publiziert']) {
							$status='published';
						}
						else { 
							$status='unpublished';
						}
						//Determine the human readable date for the concert table.
						if ($this->template == 'concert') {
							//Output for a concert export should include the month.
							$date_human = strftime($timeformat_with_month, $time_start);
							//Switch the display status
							$Concert_Model->changeConcertDisplayStatus($this->request['display_id']);
						}
						else {
							$date_human = strftime($timeformat_without_month, $time_start);
						}
						$date = date('Y-m-d', $time_start);
						if ($concert['datum_ende']) {
							$time_end = strtotime($concert['datum_ende']);
							if ($this->template == 'concert') {
								$date_end_human = strftime($timeformat_with_month, $time_end);
							}
							else {
								$date_end_human = strftime($timeformat_without_month, $time_end);
							}
							$date_human = $date_human . ' – ' . $date_end_human;
						}	
						$bands = $Concert_Model->getBands($concert['id']);
						$bands_array = array();
						if (!$bands) {
							//Database query failure
							$innerView->setTemplate('query_failure');
							break;
						}
						while($band = $bands->fetch_assoc()) {
							if ($band['nazi']) {
								$nazi = 'nazi';
							}
							else {
								$nazi = 'nonazi';
							}
							//Additions to the band names in the Lineup should be in brackets.
							array_push($bands_array, array($band['name'], $band['zusatz'], $nazi));
						}
						//Attach the concert status and the bands to the data array.
						$concert ['date_human'] = $date_human;
						$concert ['date'] = $date;
						$concert ['status'] = $status;
						$concert ['bands'] = $bands_array;
						array_push($concerts_array, $concert);
					}
					$innerView->assign('month', $month);
					$innerView->assign('concerts', $concerts_array);
				}
				$this->view->assign('subtitle', 'Concerts');
		}
		if (isset($ajax) AND $ajax = 1) {
			//On ajax calls the template of the outer view should be empty
			$this->view->setTemplate('ajax');
		}
		else {
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
	public function displayMonthChanger() {
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
		$request_now['month'] = date('Y-m');
		$request_next_month['month'] = date('Y-m', strtotime($this->request['month'] . '-01 + 1 month'));
		$request_prev_month['month'] = date('Y-m', strtotime($this->request['month'] . '-01 - 1 month'));
		$month_human = date('M Y', strtotime($this->request['month'] . '-01'));
		//Assign the variables to the MonthChanger template
		$monthChanger->assign('request_now', $request_now);
		$monthChanger->assign('request_next_month', $request_next_month);
		$monthChanger->assign('request_prev_month', $request_prev_month);
		$monthChanger->assign('month_human', $month_human);
		return $monthChanger->loadTemplate();
	}
	/**
	 * This function has the purpose of interacting withe the Concert Model.
	 *
	 * @param link identifier mysqli Link identifier of the database connection.
	 * @return integer Value of 0 or greater -> Succes, -1 -> Error.
	 */
	public function save_concert($mysqli) {
		$request = $this->request;
		$Concert_Model = new ConcertModel($mysqli);
		/*The starting date is the only value that must be provided.
		 * So if it is present, a concert should be inserted or updated*/
		if (isset($request['date_start'])) {
			if (!isset($request['name'])) {
				$request['name'] = NULL;
			}
			if (!isset($request['url'])) {
				$request['url'] = NULL;
			}
			if (!isset($request['date_end'])) {
				$request['date_end'] = NULL;
			}
			if (!isset($request['venue_id'])) {
				$request['venue_id'] = NULL;
			}
			if (!isset($request['band'])) {
				$request['band'] = array();
			}
			if (!isset($request['addition'])) {
				$request['addition'] = array();
			}
			if (isset($request['save_id'])) {
				//If the save id is set -> Update of exisiting concert
				$result = $Concert_Model->updateConcert($request['save_id'], $request['name'],
					$request['date_start'], $request['date_end'], $request['venue_id'],
					$request['url']);
			}
			else {
				//No save id -> Insert a new concert
				$result = $Concert_Model->setConcert($request['name'], $request['date_start'],
					$request['date_end'], $request['venue_id'], $request['url']);
			}
			//Update Bands if the lenght of the bands array and the addition array is the same
			if (count($request['band']) == count($request['addition'])) {
				$result = $Concert_Model->delBands($request['save_id']);
				for ( $n = 1; $n < count($request['band']) - 1; $n++ ) {
					$result = $Concert_Model->setBand($request['save_id'], request['band'][$n],
						$request['addition'][$n]);
				}
			}
			else {
				$result = 0;
			}
		}
		if (isset($this->request['save_id'])) {
			if (isset($this->request['published']) AND $this->request['published']) {
				$result = $Concert_Model->setPublished($this->request['save_id']);
			}
			if (isset($this->request['sold_out']) AND $this->request['sold_out']) {
				$result = $Concert_Model->setSoldOut($this->request['save_id']);
			}
		}
		return $result;
	}
}
?>
