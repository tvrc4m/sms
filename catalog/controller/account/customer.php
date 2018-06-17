<?php

class ControllerAccountCustomer extends Controller {

    protected $error=array();

	public function index(){

		$this->document->setTitle('帐户编辑');

        $this->data['save_action']=$this->url->link('account/customer', 't=' . $this->session->data['t']);

        $this->load->model('account/customer');

        $customer=$this->model_account_customer->getCustomer($this->customer_id);

        $customer_info=array(
            'name'=>$customer['name'],
            'email'=>$customer['email'],
            'phone'=>$customer['telephone']
        );
        $this->data['customer']=$customer_info;
        
		 $this->children = array(
            'common/header',
            'common/footer'
        );

        $this->template = 'account/customer.tpl';
       
        $this->response->setOutput($this->render());
	}

    public function save(){
        $this->document->setTitle('帐户编辑');

        $this->data['save_action']=$this->url->link('account/customer', 't=' . $this->session->data['t']);
        
        $this->load->model('account/customer');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {

            $this->model_account_customer->editCustomer($this->request->post);

            die(json_encode(array('ret'=>1)));
        }

        die(json_encode(array('errors'=>$this->error,'ret'=>-1)));
    }

    private function validate(){
        if(empty($this->request->post['name'])){
            $this->error['error_name']="用户名不能为空";
        }
        if(empty($this->request->post['email']) || !preg_match('/\w+@\w+\.\w+/', $this->request->post['email'])){
            $this->error['error_email']="邮箱格式错误";
        }
        if(empty($this->request->post['phone']) || !preg_match('/^\d{11}$/',$this->request->post['phone'])){
            $this->error['error_phone']="手机号码格式错误";
        }

        return $this->error?false:true;
    }
}
