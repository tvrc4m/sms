<?php

class ControllerFinanceDeposit extends Controller {

	public function index(){

		$this->document->setTitle('帐户充值');

        $this->data['amount_action']=$this->url->link('finance/amount', 't=' . $this->session->data['t']);
        $this->data['deposit_action']=$this->url->link('finance/deposit', 't=' . $this->session->data['t']);

        $this->data['t']=$this->session->data['t'];

        $this->load->model('user/bank_account');

        $account=$this->model_user_bank_account->getUserBankAccount();

        $this->data['account']=$account;
		
		$this->template = 'finance/deposit.tpl';
        $this->children = array(
            'common/header',
            'common/footer'
        );
        $this->response->setOutput($this->render());
	}
}