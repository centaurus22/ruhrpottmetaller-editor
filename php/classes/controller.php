<?php

class Controller {
	private $request = NULL;
	private $template = "";
	private $view = NULL;

	public function __construct($request) {
		$this->view = new View();
		$this->request = $request;
		/*translation of request parameters to the name of the
		 * corresponding template.
		 */
	}

	public function display() {
		$innerView = new View();
		switch($this->template) {
			case 'default':
			default:
			$innerView->setTemplate('default');
			$this->view->assign('subtitle', 'Concerts');

		}
		$this->view->setTemplate('rpmetaller-editor');
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

}

?>
