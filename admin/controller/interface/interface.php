<?php

// 发件箱

class ControllerInterfaceInterface extends Controller {

    public function __construct($registry){
        parent::__construct($registry);
        $token=$this->session->data['token'];
        $this->data['interface_list']=$this->url->link('interface/interface', 'token=' . $token);
        $this->data['new']=$this->url->link('interface/interface/update', 'token=' . $token);
    }

	public function index(){

		$this->document->setTitle('接口列表');
		$this->data['success'] = '';
        $this->data['error_warning'] = '';
        $this->getList();
	}

    public function getList(){

        $token=$this->session->data['token'];

        if (isset($this->request->get['filter_name'])) {
            $this->data['filter_name'] = $this->request->get['filter_name'];
        } else {
            $this->data['filter_name'] = '';
        }
        if (isset($this->request->get['filter_phone'])) {
            $this->data['filter_phone'] = $this->request->get['filter_phone'];
        } else {
            $this->data['filter_phone'] = '';
        }
        if (isset($this->request->get['filter_client'])) {
            $this->data['filter_client'] = $this->request->get['filter_client'];
        } else {
            $this->data['filter_client'] = '';
        }
        if (isset($this->request->get['filter_message'])) {
            $this->data['filter_message'] = $this->request->get['filter_message'];
        } else {
            $this->data['filter_message'] = '';
        }
        if (isset($this->request->get['filter_status'])) {
            $this->data['filter_status'] = $this->request->get['filter_status'];
        } else {
            $this->data['filter_status'] = '';
        }


        
        $this->load->model('interface/interface');

        $interfaces=$this->model_interface_interface->getInterfaces();

        $new=array();

        foreach ($interfaces as $interface) {
            $update="index.php?route=interface/interface/update&sms_interface_id={$interface['sms_interface_id']}&token={$token}";
            $delete="index.php?route=interface/interface/delete&sms_interface_id={$interface['sms_interface_id']}&token={$token}";
            if($interface['status']){
                $default="index.php?route=interface/interface/forbidden&sms_interface_id={$interface['sms_interface_id']}&token={$token}";
            }else
                $default="index.php?route=interface/interface/set_default&sms_interface_id={$interface['sms_interface_id']}&token={$token}";
            $new[]=array_merge($interface,array('update'=>$update,'delete'=>$delete,'set_default'=>$default));
        }

        $this->data['interfaces']=$new;

        $this->template = 'interface/interface_list.tpl';
        
        $this->children = array(
            'common/header',
            'common/footer'
        );
        $this->response->setOutput($this->render());
    }

     public function insert() {

        $this->document->setTitle('添加新接口');
        
        $this->load->model('interface/interface');
            
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {

            $this->model_interface_interface->addInterface($this->request->post);
            
            $this->session->data['success'] = $this->language->get('text_success');
          
            $this->redirect($this->url->link('interface/interface', 'token=' . $this->session->data['token'], 'SSL'));
        }
        
        $this->getForm();
    } 
   
    public function update() {
        $this->language->load('interface/interface');

        $this->document->setTitle('更新接口信息');
        
        $this->load->model('interface/interface');
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            // print_r($this->request->post);exit();
            $this->model_interface_interface->editInterface($this->request->post);
            
            $this->session->data['success'] = $this->language->get('text_success');
      
            $this->redirect($this->url->link('interface/interface', 'token=' . $this->session->data['token'], 'SSL'));
        }
    
        $this->getForm();
    }   

    // public function delete() {
    //     $this->language->load('interface/interface');

    //     $this->load->model('interface/interface');
            
    //     if (isset($this->request->get['sms_interface_id']) && $this->validateDelete()) {

    //         $this->model_interface_interface->delInterface($this->request->get['sms_interface_id']);
            
    //         $this->session->data['success'] = $this->language->get('text_success');

    //         $this->redirect($this->url->link('interface/interface', 'token=' . $this->session->data['token'],'SSL'));
    //     }
    
    //     $this->getList();
    // } 

    public function set_default(){
        $sms_interface_id=$this->request->get['sms_interface_id'];

        if(empty($sms_interface_id)){
            $this->redirect($this->url->link('interface/interface', 'token=' . $this->session->data['token'], 'SSL'));
        }

        $this->load->model('interface/interface');

        $this->model_interface_interface->setDefaultByID($sms_interface_id);

        $this->redirect($this->url->link('interface/interface', 'token=' . $this->session->data['token'], 'SSL'));
    }

    public function forbidden(){
        $sms_interface_id=$this->request->get['sms_interface_id'];

        if(empty($sms_interface_id)){
            $this->redirect($this->url->link('interface/interface', 'token=' . $this->session->data['token'], 'SSL'));
        }

        $this->load->model('interface/interface');

        $this->model_interface_interface->forbidden($sms_interface_id);

        $this->redirect($this->url->link('interface/interface', 'token=' . $this->session->data['token'], 'SSL'));
    }

     protected function getForm() {

        $this->data['heading_title'] = $this->language->get('heading_title');
 
        $this->data['text_enabled'] = $this->language->get('text_enabled');
        $this->data['text_disabled'] = $this->language->get('text_disabled');
        $this->data['text_select'] = $this->language->get('text_select');
        $this->data['text_none'] = $this->language->get('text_none');
        $this->data['text_wait'] = $this->language->get('text_wait');
        $this->data['text_no_results'] = $this->language->get('text_no_results');
        
        $this->data['column_action'] = $this->language->get('column_action');
        
        $this->data['entry_name'] = $this->language->get('entry_name');
        $this->data['entry_email'] = $this->language->get('entry_email');
        $this->data['entry_telephone'] = $this->language->get('entry_telephone');
        $this->data['entry_password'] = $this->language->get('entry_password');
        $this->data['entry_confirm'] = $this->language->get('entry_confirm');
        $this->data['entry_customer_group'] = $this->language->get('entry_customer_group');
        $this->data['entry_status'] = $this->language->get('entry_status');
        $this->data['entry_default'] = $this->language->get('entry_default');
        $this->data['entry_comment'] = $this->language->get('entry_comment');
 
        $this->data['button_save'] = $this->language->get('button_save');
        $this->data['button_cancel'] = $this->language->get('button_cancel');
        $this->data['button_remove'] = $this->language->get('button_remove');
    
        $this->data['token'] = $this->session->data['token'];

        if (isset($this->request->get['sms_interface_id'])) {
            $this->data['sms_interface_id'] = $this->request->get['sms_interface_id'];
        } else {
            $this->data['sms_interface_id'] = 0;
        }

        if (isset($this->error['warning'])) {
            $this->data['error_warning'] = $this->error['warning'];
        } else {
            $this->data['error_warning'] = '';
        }

        if (isset($this->error['name'])) {
            $this->data['error_name'] = $this->error['name'];
        } else {
            $this->data['error_name'] = '';
        }
        
        if (isset($this->error['account'])) {
            $this->data['error_account'] = $this->error['account'];
        } else {
            $this->data['error_account'] = '';
        }
        
        if (isset($this->error['password'])) {
            $this->data['error_password'] = $this->error['password'];
        } else {
            $this->data['error_password'] = '';
        }
        
        if (!isset($this->request->get['sms_interface_id'])) {
            $this->data['action'] = $this->url->link('interface/interface/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
        } else {
            $this->data['action'] = $this->url->link('interface/interface/update', 'token=' . $this->session->data['token'] . '&sms_interface_id=' . $this->request->get['sms_interface_id'] . $url, 'SSL');
        }
          
        $this->data['cancel'] = $this->url->link('account/customer', 'token=' . $this->session->data['token'] . $url, 'SSL');

        if (isset($this->request->get['sms_interface_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
            $interface_info = $this->model_interface_interface->getInterface($this->request->get['sms_interface_id']);
        }
            
        if (isset($this->request->post['name'])) {
            $this->data['name'] = $this->request->post['name'];
        } elseif (!empty($interface_info)) { 
            $this->data['name'] = $interface_info['name'];
        } else {
            $this->data['name'] = '';
        }

        if (isset($this->request->post['account'])) {
            $this->data['account'] = $this->request->post['account'];
        } elseif (!empty($interface_info)) { 
            $this->data['account'] = $interface_info['account'];
        } else {
            $this->data['account'] = '';
        }
        
        if (isset($this->request->post['status'])) {
            $this->data['status'] = $this->request->post['status'];
        } elseif (!empty($interface_info)) { 
            $this->data['status'] = $interface_info['status'];
        } else {
            $this->data['status'] = 1;
        }

        if (isset($this->request->post['password'])) { 
            $this->data['password'] = $this->request->post['password'];
        } elseif (!empty($interface_info)) { 
            $this->data['password'] = $interface_info['password'];
        } else {
            $this->data['password'] = '';
        }
        
        // if (isset($this->request->post['is_default'])) { 
        //     $this->data['is_default'] = $this->request->post['is_default'];
        // } elseif (!empty($interface_info)) { 
        //     $this->data['is_default'] = $interface_info['is_default'];
        // } else {
        //     $this->data['is_default'] = '';
        // }
        
        $this->template = 'interface/interface_form.tpl';
        $this->children = array(
            'common/header',
            'common/footer'
        );
        // print_r($this->data);exit();
        $this->response->setOutput($this->render());
    }
             
    protected function validateForm() {
        if (!$this->user->hasPermission('modify', 'interface/interface')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        if ((utf8_strlen($this->request->post['name']) < 1) || (utf8_strlen($this->request->post['name']) > 32)) {
            $this->error['name'] = $this->language->get('error_name');
        }

        if ((utf8_strlen($this->request->post['account']) < 1)) {
            $this->error['account'] = $this->language->get('error_account');
        }

        if ((utf8_strlen($this->request->post['password']) < 1)) {
            $this->error['password'] = $this->language->get('error_password');
        }
        
        // $interface_info = $this->model_interface_interface->getInterface($this->request->post['sms_interface_id']);
        
        // if (!isset($this->request->get['customer_id'])) {
        //     if ($interface_info) {
        //         $this->error['warning'] = $this->language->get('error_exists');
        //     }
        // } else {
        //     if ($interface_info && ($this->request->get['customer_id'] != $interface_info['customer_id'])) {
        //         $this->error['warning'] = $this->language->get('error_exists');
        //     }
        // }
        
        
        if ($this->error && !isset($this->error['warning'])) {
            $this->error['warning'] = $this->language->get('error_warning');
        }
        
        if (!$this->error) {
            return true;
        } else {
            return false;
        }
    }    

    protected function validateDelete() {
        if (!$this->user->hasPermission('modify', 'interface/interface')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }   
         
        if (!$this->error) {
            return true;
        } else {
            return false;
        }  
    }

}