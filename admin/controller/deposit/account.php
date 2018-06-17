<?php
 class ControllerDepositAccount extends ControllerBase {

    protected $error=array();

    public function __construct($registry){
        parent::__construct($registry);
        $this->data['account_action']=$this->url->link('deposit/account', 'token=' . $this->session->data['token']);
        $this->data['record_action']=$this->url->link('deposit/record', 'token=' . $this->session->data['token']);
    }

    public function index(){
        $this->document->setTitle('充值');
        $this->data['token']=$this->session->data['token'];

        $this->load->model('user/bank_account');
        $this->getList();
    }

    protected function getList() {
        
        if (isset($this->request->get['page'])) {
            $page = $this->request->get['page'];
        } else {
            $page = 1;
        }
                        
        $url = '';

        if (isset($this->request->get['page'])) {
            $url .= '&page=' . $this->request->get['page'];
        }

        
        $this->data['insert'] = $this->url->link('deposit/account/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
        $this->data['delete'] = $this->url->link('deposit/account/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');

        $this->data['customers'] = array();

        $data = array(
            'start'                    => ($page - 1) * $this->config->get('config_admin_limit'),
            'limit'                    => $this->config->get('config_admin_limit')
        );
        
        $customer_total = $this->model_user_bank_account->getUserBankAccountTotal($data);
    
        $results = $this->model_user_bank_account->getUserBankAccounts($data);
        foreach ($results as $result) {
            $action = array();
        
            $action[] = array(
                'text' => $this->language->get('text_edit'),
                'href' => $this->url->link('deposit/account/update', 'token=' . $this->session->data['token'] . '&bank_account_id=' . $result['bank_account_id'] . $url, 'SSL')
            );
            
            $this->data['accounts'][] = array(
                'bank_account_id'    => $result['bank_account_id'],
                'realname'           => $result['realname'],
                'email'          => $result['email'],
                'card_number' => $result['card_number'],
                'bank_name'         => $result['bank_name'] ,
                'phone'       => $result['phone'],
                'status'     => $result['status'],
                'default'       => $result['default'],
                'action'         => $action
            );
        }   
                    
        $this->data['heading_title'] = $this->language->get('heading_title');

        $this->data['button_insert'] = $this->language->get('button_insert');
        $this->data['button_delete'] = $this->language->get('button_delete');
        $this->data['button_filter'] = $this->language->get('button_filter');

        $this->data['token'] = $this->session->data['token'];

        if (isset($this->error['warning'])) {
            $this->data['error_warning'] = $this->error['warning'];
        } else {
            $this->data['error_warning'] = '';
        }
        
        if (isset($this->session->data['success'])) {
            $this->data['success'] = $this->session->data['success'];
        
            unset($this->session->data['success']);
        } else {
            $this->data['success'] = '';
        }
        
        $url = '';

        if (isset($this->request->get['page'])) {
            $url .= '&page=' . $this->request->get['page'];
        }
        
        $pagination = new Pagination();
        $pagination->total = $customer_total;
        $pagination->page = $page;
        $pagination->limit = $this->config->get('config_admin_limit');
        $pagination->text = $this->language->get('text_pagination');
        $pagination->url = $this->url->link('account/customer', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');
            
        $this->data['pagination'] = $pagination->render();

        $this->template = 'deposit/account.tpl';
        $this->children = array(
            'common/header',
            'common/footer'
        );
                
        $this->render();
    }

    public function insert() {
        $this->language->load('account/customer');

        $this->document->setTitle($this->language->get('heading_title'));
        
        $this->load->model('user/bank_account');
            
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->model_user_bank_account->addUserBankAccount($this->request->post);
            
            $this->session->data['success'] = $this->language->get('text_success');
          
            $url = '';

            if (isset($this->request->get['page'])) {
                $url .= '&page=' . $this->request->get['page'];
            }
            
            $this->redirect($this->url->link('deposit/account', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }
        
        $this->getForm();
    } 
   
    public function update() {
        $this->language->load('account/customer');

        $this->document->setTitle($this->language->get('heading_title'));
        
        $this->load->model('user/bank_account');
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->model_user_bank_account->editBankAccount($this->request->get['bank_account_id'], $this->request->post);
            
            $this->session->data['success'] = $this->language->get('text_success');
      
            $url = '';

            if (isset($this->request->get['page'])) {
                $url .= '&page=' . $this->request->get['page'];
            }
            
            $this->redirect($this->url->link('deposit/account', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }
    
        $this->getForm();
    }   

    public function delete() {
        $this->language->load('account/customer');

        $this->document->setTitle($this->language->get('heading_title'));
        
        $this->load->model('user/bank_account');
            
        if (isset($this->request->post['selected']) && $this->validateDelete()) {
            foreach ($this->request->post['selected'] as $bank_account_id) {
                $this->model_user_bank_account->deleteBankAccount($bank_account_id);
            }
            
            $this->session->data['success'] = $this->language->get('text_success');

            $url = '';

            if (isset($this->request->get['page'])) {
                $url .= '&page=' . $this->request->get['page'];
            }
            
            $this->redirect($this->url->link('deposit/account', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }
    
        $this->getList();
    }  
    
    protected function getForm() {
        $this->data['heading_title'] = $this->language->get('heading_title');

        $this->data['text_enabled']=$this->language->get('text_enabled');
        $this->data['text_disabled']=$this->language->get('text_disabled');
 
        $this->data['button_save'] = $this->language->get('button_save');
        $this->data['button_cancel'] = $this->language->get('button_cancel');
        $this->data['button_remove'] = $this->language->get('button_remove');
    
        $this->data['token'] = $this->session->data['token'];

        if (isset($this->error['warning'])) {
            $this->data['error_warning'] = $this->error['warning'];
        } else {
            $this->data['error_warning'] = '';
        }

        if (isset($this->error['realname'])) {
            $this->data['error_realname'] = $this->error['realname'];
        } else {
            $this->data['error_realname'] = '';
        }
        
        if (isset($this->error['bank_name'])) {
            $this->data['error_bank'] = $this->error['bank_name'];
        } else {
            $this->data['error_bank'] = '';
        }

        if (isset($this->error['card_number'])) {
            $this->data['error_card'] = $this->error['card_number'];
        } else {
            $this->data['error_card'] = '';
        }
        
        if (isset($this->error['phone'])) {
            $this->data['error_phone'] = $this->error['phone'];
        } else {
            $this->data['error_phone'] = '';
        }
        
        
        $url = '';
        
        if (isset($this->request->get['page'])) {
            $url .= '&page=' . $this->request->get['page'];
        }
        
        if (!isset($this->request->get['bank_account_id'])) {
            $this->data['action'] = $this->url->link('deposit/account/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
        } else {
            $this->data['action'] = $this->url->link('deposit/account/update', 'token=' . $this->session->data['token'] . '&bank_account_id=' . $this->request->get['bank_account_id'] . $url, 'SSL');
        }
          
        $this->data['cancel'] = $this->url->link('account/customer', 'token=' . $this->session->data['token'] . $url, 'SSL');

        if (isset($this->request->get['bank_account_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
            $account_info = $this->model_user_bank_account->getUserBankAccount($this->request->get['bank_account_id']);
        }

        if (isset($this->request->post['bank_account_id'])) {
            $this->data['bank_account_id'] = $this->request->post['bank_account_id'];
        } elseif (!empty($account_info)) { 
            $this->data['bank_account_id'] = $account_info['bank_account_id'];
        }else {
            $this->data['bank_account_id'] = 0;
        }

        if (isset($this->request->post['realname'])) {
            $this->data['realname'] = $this->request->post['realname'];
        } elseif (!empty($account_info)) { 
            $this->data['realname'] = $account_info['realname'];
        } else {
            $this->data['realname'] = '';
        }

        if (isset($this->request->post['bank_name'])) {
            $this->data['bank_name'] = $this->request->post['bank_name'];
        } elseif (!empty($account_info)) { 
            $this->data['bank_name'] = $account_info['bank_name'];
        } else {
            $this->data['bank_name'] = '';
        }

        if (isset($this->request->post['card_number'])) {
            $this->data['card_number'] = $this->request->post['card_number'];
        } elseif (!empty($account_info)) { 
            $this->data['card_number'] = $account_info['card_number'];
        } else {
            $this->data['card_number'] = '';
        }

        if (isset($this->request->post['phone'])) {
            $this->data['phone'] = $this->request->post['phone'];
        } elseif (!empty($account_info)) { 
            $this->data['phone'] = $account_info['phone'];
        } else {
            $this->data['phone'] = '';
        }
        
        if (isset($this->request->post['status'])) {
            $this->data['status'] = $this->request->post['status'];
        } elseif (!empty($account_info)) { 
            $this->data['status'] = $account_info['status'];
        } else {
            $this->data['status'] = 1;
        }

        
        if (isset($this->request->post['default'])) { 
            $this->data['default'] = $this->request->post['default'];
        } elseif (!empty($account_info)) { 
            $this->data['default'] = $account_info['default'];
        } else {
            $this->data['default'] = 1;
        }
        
        $this->template = 'deposit/account_form.tpl';
        $this->children = array(
            'common/header',
            'common/footer'
        );
                
        $this->render();
    }
             
    protected function validateForm() {
        if (!$this->user->hasPermission('modify', 'deposit/account')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        if ((utf8_strlen($this->request->post['realname']) < 1) || (utf8_strlen($this->request->post['realname']) > 32)) {
            $this->error['realname'] = $this->language->get('error_realname');
        }

        if (isset($this->request->get['bank_account_id'])) {
        	$account_info = $this->model_user_bank_account->getUserBankAccount($this->request->post['bank_account_id']);
            if ($account_info && ($this->request->get['bank_account_id'] != $account_info['bank_account_id'])) {
                $this->error['warning'] = $this->language->get('error_exists');
            }
        }
        
        if ((utf8_strlen($this->request->post['phone']) < 3) || (utf8_strlen($this->request->post['phone']) > 32)) {
            $this->error['phone'] = $this->language->get('error_phone');
        }

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
        if (!$this->user->hasPermission('modify', 'deposit/account')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }   
         
        if (!$this->error) {
            return true;
        } else {
            return false;
        }  
    }

 }
