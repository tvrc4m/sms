<?php

class ControllerFinanceIndex extends Controller {

	public function index(){

		$this->document->setTitle('帐户管理');

        $this->data['amount_action']=$this->url->link('finance/amount', 't=' . $this->session->data['t']);
        $this->data['deposit_action']=$this->url->link('finance/deposit', 't=' . $this->session->data['t']);

        $this->data['t']=$this->session->data['t'];
		

		$this->template = 'finance/finance_header.tpl';
        $this->children = array(
            'common/header',
            'common/footer'
        );
        $this->response->setOutput($this->render());
	}
}