<?php

 class ControllerInterfaceSp1086 extends Controller {

 	public function index(){

 		$this->load->model('interface/sp1086');

 		$balance=$this->model_interface_sp1086->smsBalance();

 		$this->data['balance']=$balance;

 		$this->template = 'interface/info.tpl';
        $this->children = array(
            'common/header',
            'common/footer'
        );
        $this->response->setOutput($this->render());

 	}
 }