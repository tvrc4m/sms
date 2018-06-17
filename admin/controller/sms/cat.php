<?php

//手机彩信

class ControllerSmsCat extends Controller {

	public function index(){
		 
		$this->document->setTitle('短信类别');
		$this->data['success'] = '';
        $this->data['error_warning'] = '';

        $this->load->model('sms/cat');

        $cats=$this->model_sms_cat->getSmsCats();

        $this->data['cats']=$cats;

        $this->template = 'sms/cat.tpl';

        $this->children = array(
            'common/header',
            'common/footer'
        );
        
        $this->response->setOutput($this->render());
	}
	
}