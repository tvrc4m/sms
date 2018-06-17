<?php

class ControllerAccountIndex extends Controller {

	public function index(){

		$this->document->setTitle('帐户管理');

        $this->data['customer_action']=$this->url->link('account/customer', 't=' . $this->session->data['t']);
        $this->data['password_action']=$this->url->link('account/password', 't=' . $this->session->data['t']);

        $this->data['t']=$this->session->data['t'];

		 $this->children = array(
            'common/header',
            'common/footer'
        );

        $this->template = 'account/account_header.tpl';
       
        $this->response->setOutput($this->render());
	}
}
