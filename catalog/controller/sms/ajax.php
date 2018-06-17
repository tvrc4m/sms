<?php
 class ControllerSmsAjax extends Controller {

    protected $error=array();

    public function addressbook(){

        $customer_id=$this->session->data['customer_id'];
        $this->load->model('client/client');

        $customers=$this->model_client_client->getUserClients($customer_id);
        $data=array();

        foreach ($customers as $customer) {
            $data[]=array('customer_id'=>$customer['customer_id'],'name'=>$customer['name'],'phone'=>$customer['phone']);
        }

        echo json_encode($data);
    }

    public function send(){

        $client=$this->request->post['client'];

        if(empty($client)) die(json_encode(array('ret'=>-1,'error'=>'未选择联系人')));

        $timer=$this->request->post['datetime'];

        $is_timer=$this->request->post['is_timer'];
        
        if($is_timer==1){
            if(empty($timer) || strtotime($timer)<time()){
                die(json_encode(array('ret'=>-1,'error'=>'请选择未来的某一个时间')));
            }else{
                $timer=strtotime($timer);
            }
        }else{
            $is_timer=0;
        }

        $message=$this->request->post['message'];

        if(empty($message)) die(json_encode(array('ret'=>-1,'error'=>'短信内容不能为空')));

        $customer_id=$this->session->data['customer_id'];

        $this->load->model('client/client');
        $this->load->model('interface/interface');

        $cs=$this->model_client_client->getClients($customer_id,$client);
        
        $clients=$phones=array();

        $this->load->model('sms/outbox');
        

        $success=array();

        foreach ($cs as $c) {

            if(!empty($c['phone'])){

                $phones[]=$c['phone'];
                $clients[]=$c['client_id'];
            }
        }
        
        $message_len=mb_strlen($message,'UTF8');
            
        $multiple=1;

        if($message_len<=70){

            $multiple=1;
        }else{
            $multiple=1+ceil(($message_len-70)/65);
        }

        $this->load->model('account/customer');
        $customer=$this->model_account_customer->getCustomer($customer_id);

        $count=$multiple*count($phones);

        if($customer['sms_count']<$count){
            die(json_encode(array('ret'=>-1,'error'=>'剩余短信为0,须发送{$count}条,则先充值,谢谢')));
        }

        $default_interface=$this->model_interface_interface->getDefaultInterface();

        if(empty($default_interface)){
            $status=1;
        }else{

            $interface=$default_interface['name'];
            $this->load->model("sms/{$interface}");
            $action="model_sms_{$interface}";
            $this->{$action}->sendSms($phones,$message);
        }

        if($status){
            $this->model_sms_outbox->insertOutbox($customer_id,$phones,$message,$timer,$is_timer,$clients,array(),$multiple);
            $this->model_account_customer->updateCustomerSmsCount($customer_id,$count);
        }

        die(json_encode(array('status'=>$status,'count'=>$count)));
    }
    
    public function group_send(){
        $group=$this->request->post['group'];

        if(empty($group)) die(json_encode(array('ret'=>-1,'error'=>'未选择联系人')));

        $timer=$this->request->post['datetime'];

        $is_timer=$this->request->post['is_timer'];
    
        if($is_timer==1){
            if(empty($timer) || strtotime($timer)<time()){
                die(json_encode(array('ret'=>-1,'error'=>'请选择未来的某一个时间')));
            }else{
                $timer=strtotime($timer);
            }
        }else{
            $is_timer=0;
        }

        $message=$this->request->post['message'];

        if(empty($message)) die(json_encode(array('ret'=>-1,'error'=>'短信内容不能为空')));

        $customer_id=$this->session->data['customer_id'];

        $this->load->model('account/customer');
        $this->load->model('client/client');
        $this->load->model('sms/outbox');
        $this->load->model('interface/interface');
        
        $customer=$this->model_account_customer->getCustomer($customer_id);

        $group_client=$this->model_client_client->getClientsInGroups($group);

        $clients=$phones=array();

        foreach ($group_client as $c) {

            if(!empty($c['phone'])){

                $phones[]=$c['phone'];
                $clients[]=$c['client_id'];
            }
        }

        $message_len=mb_strlen($message,'UTF8');
            
        $multiple=1;

        if($message_len<=70){

            $multiple=1;
        }else{
            $multiple=1+ceil(($message_len-70)/65);
        }

        $count=$multiple*count($phones);

        if($customer['sms_count']<$count){
            die(json_encode(array('ret'=>-1,'error'=>'剩余短信为0,须发送{$count}条,则先充值,谢谢')));
        }

        $default_interface=$this->model_interface_interface->getDefaultInterface();

        if(empty($default_interface)){
            $status=1;
        }else{

            $interface=$default_interface['name'];
            $this->load->model("sms/{$interface}");
            $action="model_sms_{$interface}";
            $this->{$action}->sendSms($phones,$message);
        }
        
        if($status){
            $this->model_sms_outbox->insertOutbox($customer_id,$phones,$message,$timer,$is_timer,$clients,$group,$multiple);
            $this->model_account_customer->updateCustomerSmsCount($customer_id,$count);
        }
        
        die(json_encode(array('status'=>$status,'count'=>$count)));
    }
 }
