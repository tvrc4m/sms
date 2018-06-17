<?php
 class ControllerClientGroup extends Controller {

    protected $error=array();

    public function index(){
        $this->document->setTitle('群组列表');

        $this->getList();
    }

    public function getList(){

        $this->load->model('client/group');

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

        if (isset($this->request->get['filter_remark'])) {
            $this->data['filter_remark'] = $this->request->get['filter_remark'];
        } else {
            $this->data['filter_remark'] = '';
        }

        $groups= $this->model_client_group->getUserGroups($this->customer_id,$this->request->get);

        $total=$this->model_client_group->getUserGroupsTotal($this->customer_id,$this->request->get);

        $this->data['groups']=$groups;

        $pagination = new Pagination();
        $pagination->total = $total;
        $pagination->page = $page;
        $pagination->limit = $limit;
        $pagination->text = $this->language->get('text_pagination');
        $pagination->url = $this->url->link('client/group', 't=' . $this->session->data['t']  . '&page={page}', 'SSL');

        $this->data['pagination'] = $pagination->render();

        $this->template = 'client/group_list.tpl';
        $this->children = array(
            'common/header',
            'common/footer'
        );
        $this->response->setOutput($this->render());

    }
    
 }
