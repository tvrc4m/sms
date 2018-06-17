<?php

//手机彩信

class ControllerSmsSms extends Controller {

	public function index(){
		 
		$this->document->setTitle('短信群发功能');
		$this->data['success'] = '';
        $this->data['error_warning'] = '';

        $this->data['cat_action'] =$this->url->link('sms/cat', 'token=' . $this->session->data['token'], 'SSL');
        $this->data['outbox_action'] =$this->url->link('sms/outbox', 'token=' . $this->session->data['token'], 'SSL');

        $this->template = 'sms/header.tpl';
        $this->children = array(
            'common/header',
            'common/footer'
        );
        $this->response->setOutput($this->render());
	}
	
}