<?php
 class ControllerAccountApp extends ControllerBase {

    protected $error=array();

    public function index(){

    }

    public function insert(){

        $this->document->setTitle('创建应用');
        
        if ($this->request->server['REQUEST_METHOD'] == 'POST' && $this->validateForm()) {

            $this->load->model('account/app');

             $this->model_account_app->addApp($this->request->post);

             $this->redirect($this->url->link('account/customer', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }

        $this->data['customer_id']=$this->request->get['customer_id'];

        $this->getForm();
    }

    public function getForm(){

        if (!isset($this->request->get['app_id'])) {
            $this->data['action'] = $this->url->link('account/app/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
        } else {
            $this->data['action'] = $this->url->link('account/app/update', 'token=' . $this->session->data['token'] . '&app_id=' . $this->request->get['app_id'] . $url, 'SSL');
        }

        $this->template = 'app/app_form.tpl';
        $this->children = array(
            'common/header',
            'common/footer'
        );
        
        $this->render();
    }

    public function validateForm(){

        $post=$this->request->post;

        $customer_id=$post['customer_id'];
        $app_id=$post['app_id'];

        if(empty($customer_id)){

            $this->error['customer']='请选择注册用户';
        }

        if(empty($post['name']) && utf8_strlen($post['name'])>32){

            $this->error['name']='应用名称不能为空且要小于32个字符';   
        }

        return $this->error?false:true;
    }

}
