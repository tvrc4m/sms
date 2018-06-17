<?php
 class ControllerAccountAjax extends Controller {

    protected $error=array();

    public function index(){
        $this->document->setTitle('添加群组');

        $this->getForm();
    }

    public function getGroup(){

        if(empty($this->request->get['group_id'])){
            die(json_encode(array('ret'=>0)));
        }
        $this->load->model('client/group');
        $info=$this->model_client_group->getClientGroup($this->request->get['group_id']);
        die(json_encode(array('ret'=>1,'info'=>$info)));
    }

    public function updateGroup(){

        $name=$this->request->get['name'];
        if(empty($name)){
            die(json_encode(array('ret'=>0)));
        }
        $remark=$this->request->get['remark'];
        
        $group_id=empty($this->request->get['group_id'])?0:$this->request->get['group_id'];
        $this->load->model('client/group');
        $status=$this->model_client_group->checkGroupName($name,$group_id);
        if($status){
            die(json_encode(array('ret'=>-1)));
        }

        if($group_id){
            // Edit
            $this->model_client_group->editClientGroup(array('name'=>$name,'remark'=>$remark,'group_id'=>$group_id));
        }else{
            // Add
            $group_id=$this->model_client_group->addClientGroup(array('name'=>$name,'remark'=>$remark));
        }

        die(json_encode(array('ret'=>$group_id)));
    }

    public function delGroup(){
        if(empty($this->request->get['group_id'])){
            die(json_encode(array('ret'=>0)));
        }
        $delClient=$this->request->get['client'];
        $this->load->model('client/group');
        $status=$this->model_client_group->delClientGroup($this->request->get['group_id'],$delClient);
        die(json_encode(array('ret'=>$status)));
    }

    public function getClient(){
        if(empty($this->request->get['client_id'])){
            die(json_encode(array('ret'=>0)));
        }
        $this->load->model('client/client');
        $info=$this->model_client_client->getClient($this->request->get['client_id']);
        die(json_encode(array('ret'=>1,'client'=>$info)));
    }

    public function updateClient(){

        $post=$this->request->post;

        if($this->validateClientForm($post)){

            $this->load->model('client/client');
            $lastid=$this->model_client_client->addClient($post);
            if($lastid){
                die(json_encode(array('ret'=>1)));
            }else{
                die(json_encode(array('ret'=>-2)));
            }
        }
        die(json_encode(array('ret'=>-1,'error'=>$this->error)));

    }

    public function delClient(){
        if(empty($this->request->get['client_id'])){
            die(json_encode(array('ret'=>0)));
        }
        $this->load->model('client/client');
        $status=$this->model_client_client->delClient($this->request->get['client_id']);
        die(json_encode(array('ret'=>$status)));
    }

    public function getForm(){
        $this->data['success'] = '';
        $this->data['error_warning'] = '';

        $this->load->model('client/group');

        $post=$this->request->post;

        $groupinfo=array();

        if(isset($post['group_id'])){
            $groupinfo=$this->model_client_group->getClientGroup($group_id);
        }

        if (isset($this->request->post['name'])) {
            $this->data['name'] = $this->request->post['name'];
        } elseif (isset($groupinfo['name'])) {
            $this->data['name'] = $groupinfo['name'];
        } else{
            $this->data['name'] = '';
        }

        $this->template = 'client/client_group_form.tpl';
        $this->children = array(
            'common/header',
            'common/footer'
        );
        $this->response->setOutput($this->render());
    }

    public function recharge(){
        $customer_id=$this->request->get['customer_id'];
        $sms_count=$this->request->get['sms_count'];
        if(!$customer_id || !$sms_count){
            die(json_encode(array('ret'=>0)));
        }
        $this->load->model('account/customer');
        $customer=$this->model_account_customer->getCustomer($customer_id);
        if(empty($customer)) die(json_encode(array('ret'=>-1)));
        $status=$this->model_account_customer->recharge($customer_id,$sms_count);
        if($status){
            $this->load->model('account/customer_deposit');
            $this->model_account_customer_deposit->addCustomerDeposit(array('customer_id'=>$customer_id,'realname'=>$realname,'count'=>$sms_count,'amount'=>$amount));
        }
        die(json_encode(array('ret'=>$status)));
    }

    public function validateClientForm($post){
        if(empty($post['name'])){
            $this->error['error_name']='名称不能为空!';
        }
        
        if(empty($post['phone']) || !preg_match('/^\d{11}$/', $post['phone'])){
            $this->error['error_phone']='手机号码格式不正确';
        }

        if($this->error){
            return false;
        }
        return true;
    }

 }
