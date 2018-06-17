<?php

class ControllerAccountPassword extends Controller {

    protected $error=array();

	public function index(){

		$this->document->setTitle('修改帐户密码');

        $this->load->model('account/customer');

        $customer=$this->model_account_customer->getCustomer($this->customer_id);

        $customer_info=array(
            'name'=>$customer['firstname'],
            'email'=>$customer['email']
        );
        $this->data['customer']=$customer_info;

		 $this->children = array(
            'common/header',
            'common/footer'
        );

        $this->template = 'account/password.tpl';
       
        $this->response->setOutput($this->render());
	}

    public function change(){

        $this->load->model('account/customer');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {

            $this->model_account_customer->editPassword($this->request->post['new']);

            unset($_SESSION);
            
            die(json_encode(array('ret'=>1,'redirect'=>$this->url->link('common/login', 'relogin=1'))));
        }

        die(json_encode(array('errors'=>$this->error,'ret'=>-1)));
    }

    private function validate(){
        if(empty($this->request->post['old'])){
            $this->error['error_old']="旧密码不正确!";
        }else{
            $customer_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE (password = SHA1(CONCAT(salt, SHA1(CONCAT(salt, SHA1('" . $this->db->escape($this->request->post['old']) . "'))))) OR password = '" . $this->db->escape(md5($password)) . "') AND status = '1'");
            if(empty($customer_query->row)){
                $this->error['error_old']="旧密码不正确!";
            }
        }
        if(empty($this->request->post['new']) || strlen($this->request->post['new']<6)){
            $this->error['error_new']="新密码须大于6位数!";
        }
        if(empty($this->request->post['newtwo']) || $this->request->post['newtwo']!=$this->request->post['new']){
            $this->error['error_newtwo']="两次密码不一致!";
        }

        return $this->error?false:true;
    }
}
