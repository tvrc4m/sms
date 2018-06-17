<?php
 class ControllerClientFilter extends Controller {

    public function index(){
        $this->document->setTitle('客户管理');

        $this->getList();
    }

    public function getList(){
        $this->data['success'] = '';
        $this->data['route'] = $this->url->link('blend/channel', 't=' . $this->session->data['t']);
        $this->data['error_warning'] = '';

        $this->template = 'client/client_list.tpl';
        $this->children = array(
            'common/header',
            'common/footer'
        );
        $this->response->setOutput($this->render());
    }

 }
