<?php
 class ControllerClientClient extends Controller {

    public function index(){
        $this->document->setTitle('客户管理');
        $this->data['t']=$this->session->data['t'];
        $this->data['client_list_action']=$this->url->link('client/client/getList', 't=' . $this->session->data['t']);
        $this->data['group_list_action']=$this->url->link('client/group', 't=' . $this->session->data['t']);
        $this->data['add_action']=$this->url->link('client/add', 't=' . $this->session->data['t']);
        $this->data['add_group_action']=$this->url->link('client/group_add', 't=' . $this->session->data['t']);

        $this->load->model('client/group');
        $this->data['groups']= $this->model_client_group->getUserAllGroup($this->customer_id);

        $this->template = 'client/client_header.tpl';
        $this->children = array(
            'common/header',
            'common/footer'
        );
        $this->response->setOutput($this->render());
    }


    public function getList(){
        $this->data['success'] = '';
        $this->data['route'] = $this->url->link('blend/channel', 't=' . $this->session->data['t']);
        $this->data['error_warning'] = '';

        $page=1;

        $limit=50;

        if (isset($this->request->get['page'])) {
            $this->data['page'] = (int)$this->request->get['page'];
        }

        $this->request->get['limit']=$limit;

        $this->request->get['start']=($page-1)*$limit;

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
        if (isset($this->request->get['filter_email'])) {
            $this->data['filter_email'] = $this->request->get['filter_email'];
        } else {
            $this->data['filter_email'] = '';
        }
        if (isset($this->request->get['filter_sex'])) {
            $this->data['filter_sex'] = $this->request->get['filter_sex'];
        } else {
            $this->data['filter_sex'] = '';
        }

        if (isset($this->request->get['filter_remark'])) {
            $this->data['filter_remark'] = $this->request->get['filter_remark'];
        } else {
            $this->data['filter_remark'] = '';
        }

        $this->load->model('client/client');

        $this->data['clients']=$this->model_client_client->getUserClients($this->customer_id,$this->request->get);
        
        $total=$this->model_client_client->getUserClientsTotal($this->customer_id,$this->request->get);

        // $this->load->model('account/customer_sms_cat');

        // $sms_cats=$this->model_account_customer_sms_cat->getCustomerSmsCat($this->customer_id);

        // $this->data['sms_cats']=$sms_cats;

        $pagination = new Pagination();
        $pagination->total = $total;
        $pagination->page = $page;
        $pagination->limit = $limit;
        $pagination->text = $this->language->get('text_pagination');
        $pagination->url = $this->url->link('client/group', 't=' . $this->session->data['t']  . '&page={page}', 'SSL');
        $this->data['pagination'] = $pagination->render();
        
        $this->template = 'client/client_list.tpl';
        $this->children = array(
            'common/header',
            'common/footer'
        );
        $this->response->setOutput($this->render());
       
    }

    public function update(){
        
    }

 }
