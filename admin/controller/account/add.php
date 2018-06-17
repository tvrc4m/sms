<?php
 class ControllerAccountAdd extends Controller {

    public function index(){
        $this->document->setTitle('添加客户');

        $this->getForm();
    }

    public function getForm(){
        $this->data['success'] = '';
        $this->data['route'] = $this->url->link('blend/channel', 'token=' . $this->session->data['token']);
        $this->data['error_warning'] = '';

        $this->load->model('client/client');

        $this->load->model('client/group');

        $post=$this->request->post;

        $clientinfo=array();

        if(isset($post['client_id'])){
            $clientinfo=$this->model_client_client->getClient();
        }

        $groups=$this->model_client_group->getAllGroup();

        $this->data['groups']=$groups;

        if (isset($this->request->post['name'])) {
            $this->data['name'] = $this->request->post['name'];
        } elseif (isset($clientinfo['name'])) {
            $this->data['name'] = $clientinfo['name'];
        } else{
            $this->data['name'] = '';
        }

        if (isset($this->request->post['phone'])) {
            $this->data['phone'] = $this->request->post['phone'];
        } elseif (isset($clientinfo['phone'])) {
            $this->data['phone'] = $clientinfo['phone'];
        } else{
            $this->data['phone'] = '';
        }

        if (isset($this->request->post['sex'])) {
            $this->data['sex'] = $this->request->post['sex'];
        } elseif (isset($clientinfo['sex'])) {
            $this->data['sex'] = $clientinfo['sex'];
        } else{
            $this->data['sex'] = '';
        }

        $this->template = 'client/client_form.tpl';
        $this->children = array(
            'common/header',
            'common/footer'
        );
        $this->response->setOutput($this->render());
    }

 }
