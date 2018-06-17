<?php

class ControllerFinanceAmount extends Controller {

	public function index(){

		$this->document->setTitle('帐户管理');

        $this->data['amount_action']=$this->url->link('finance/amount', 't=' . $this->session->data['t']);
        $this->data['deposit_action']=$this->url->link('finance/deposit', 't=' . $this->session->data['t']);

        $this->data['t']=$this->session->data['t'];

        $this->load->model('account/customer');

        $customer=$this->model_account_customer->getCustomer($this->session->data['customer_id']);

        $this->data['sms_count']=$customer['sms_count'];
		
		$this->template = 'finance/amount.tpl';
        $this->children = array(
            'common/header',
            'common/footer'
        );
        $this->response->setOutput($this->render());
	}
}