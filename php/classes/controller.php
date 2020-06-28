<?php

class Controller {
	private $request = NULL;
	private $template = '';
	private $image_path = 'images';
	private $view = NULL;
	private $ajax = 0;

	public function __construct($request) {
		$this->view = new View();
		$this->request = $request;
		/*translation of request parameters to the name of the
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
				$monthChanger = $this->displayMonthChanger();
				//Add the month value to the request parameter. So it can
				//be passed  to the displayMonthChanger function.
				$innerView->assign('month_changer', $monthChanger->loadTemplate());
				$mysqli = ConnectModel::db_connect();
				//Load the models.
				$Model = new ConcertModel($mysqli);
				$Model->startConcertDisplaySession();
				if ($this->template == 'concert') {
					//Output of just one concert
					$innerView->setTemplate('concert');
					$concerts = $Model->getConcert($this->request['display_id']);
				} 
				else {
					//Normal output of data of all concerts from one month.
					$innerView->setTemplate('default');
					$concerts = $Model->getConcerts($month);
					$Model->delConcertDisplayStatus();
				}
				
				if (!$concerts) {
					//Database query failure
					$innerView->setTemplate('query_failure');
				}
				elseif (!($concerts->num_rows)) {
					//No concerts in the chosen month.
					$innerView->setTemplate('default_no_data');
				}
				elseif ($this->template == "concert" AND 
					$Model->getConcertDisplayStatus($this->request['display_id'])) {
					$innerView->setTemplate('empty_output');
					$Model->changeConcertDisplayStatus($this->request['display_id']);
				}
				else {
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
							$date_human = date('D, d M', $time_start);
							//Switch the display status
							$Model->changeConcertDisplayStatus($this->request['display_id']);
						}
						else {
							$date_human = date('D, d', $time_start);
						}
						$date = date('Y-m-d', $time_start);
						if ($concert['datum_ende']) {
							$time_end = strtotime($concert['datum_ende']);
							if ($this->template == 'concert') {
								$date_end_human = date('D, d M', $time_end);
							}
							else {
								$date_end_human = date('D, d', $time_end);
							}
							$date_human = $date_human . ' – ' . $date_end_human;
						}	
						$bands = $Model->getBands($concert['id']);
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
	
	public function displayMonthChanger() {
		//Controll the second line to choose the month
		$monthChanger = new View();
		$monthChanger->setTemplate('month_changer');
		if(isset($this->request['display'])) {
			$request['display'] = $this->request['display'];
			$request_next_month['display'] = $this->request['display'];
			$request_prev_month['display'] = $this->request['display'];
		}
		//Generate parameter for the current month, the next month and the previous month
		$request_now['month'] = date('Y-m');
		$request_next_month['month'] = date('Y-m', strtotime($this->request['month'] . '-01 + 1 month'));
		$request_prev_month['month'] = date('Y-m', strtotime($this->request['month'] . '-01 - 1 month'));
		$month_human = date('M Y', strtotime($this->request['month'] . '-01'));
		//Assign the variables to the MonthChanger template
		$monthChanger->assign('request_now', $request_now);
		$monthChanger->assign('request_next_month', $request_next_month);
		$monthChanger->assign('request_prev_month', $request_prev_month);
		$monthChanger->assign('month_human', $month_human);
		return $monthChanger;
	}
}
?>
