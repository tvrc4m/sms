<?php

// 发件箱

class ControllerSmsOutbox extends Controller {

	public function index(){

		$this->document->setTitle('发件箱');
		$this->data['success'] = '';
        $this->data['error_warning'] = '';

        $this->data['send_action']=$this->url->link('sms/send', 'token=' . $this->session->data['token']);

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
        if (isset($this->request->get['filter_client'])) {
            $this->data['filter_client'] = $this->request->get['filter_client'];
        } else {
            $this->data['filter_client'] = '';
        }
        if (isset($this->request->get['filter_message'])) {
            $this->data['filter_message'] = $this->request->get['filter_message'];
        } else {
            $this->data['filter_message'] = '';
        }
        if (isset($this->request->get['filter_status'])) {
            $this->data['filter_status'] = $this->request->get['filter_status'];
        } else {
            $this->data['filter_status'] = '';
        }
        if (isset($this->request->get['filter_api'])) {
            $this->data['filter_api'] = $this->request->get['filter_api'];
        } else {
            $this->data['filter_api'] = '1';
        }
    	
        $this->load->model('sms/outbox');

        $customer_id=$this->session->data['customer_id'];

        $page=empty($_GET['page'])?1:$_GET['page'];

        $limit=20;

        $this->data['start']=($page-1)*$limit;

        $this->data['limit']=$limit;

        $outbox=$this->model_sms_outbox->getOutbox($this->data);

        $total=$this->model_sms_outbox->getOutBoxTotal($this->data);

        $url = '';

        if (isset($this->request->get['page'])) {
            $url .= '&page=' . $this->request->get['page'];
        }
        
        $pagination = new Pagination();
        $pagination->total = $total;
        $pagination->page = $page;
        $pagination->limit = $limit;
        $pagination->text = $this->language->get('text_pagination');
        $pagination->url = $this->url->link('sms/outbox', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');
            
        $this->data['pagination'] = $pagination->render();

        $sms=array();

        foreach ($outbox as $box) {
            $sms_id=$box['sms_id'];
            $download=$this->url->link('sms/outbox/download_phone', "id={$sms_id}&token=" . $this->session->data['token']);
            $sms[]=array_merge($box,array('download'=>$download));
        }

        $this->data['outbox']=$sms;

        $this->data['status']=array(1=>"等待发送",2=>"正在发送",3=>"发送成功",4=>"发送失败",5=>"取消发送");

        $this->template = 'sms/outbox.tpl';
        
        $this->children = array(
            'common/header',
            'common/footer'
        );
        $this->response->setOutput($this->render());
	}

    public function download_phone(){

        $sms_id=$this->request->get['id'];

        $this->load->model('sms/outbox');

        $sms=$this->model_sms_outbox->getOutboxDetail($sms_id);

        $phones=preg_replace('/,/', "\r\n", $sms['phones']);

        header('Content-type: application/txt');

        header('Content-Disposition: attachment; filename="outbox_'.$sms_id.'.txt"');

        echo $phones;
    }
	
}