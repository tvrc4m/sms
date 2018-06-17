<?php

//手机彩信

class ControllerSmsIndex extends Controller {

	public function index(){
		 
		$this->document->setTitle('短信群发功能');
		$this->data['success'] = '';
        $this->data['error_warning'] = '';


        $this->data['send_action']=$this->url->link('sms/send', 't=' . $this->session->data['t']);
    

        $this->template = 'sms/sms_header.tpl';
        $this->children = array(
            'common/header',
            'common/footer'
        );
        $this->response->setOutput($this->render());
	}


	
}