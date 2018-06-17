<?php       
class ControllerCommonLogout extends Controller {   
	public function index() {

 		unset($this->session->data['t']);

		$this->redirect($this->url->link('common/login', '', 'SSL'));
  	}
}  
?>