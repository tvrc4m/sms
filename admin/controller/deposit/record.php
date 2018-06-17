<?php

class ControllerDepositRecord extends ControllerBase{

	public function __construct($registry){
        parent::__construct($registry);
        $this->data['account_action']=$this->url->link('deposit/account', 'token=' . $this->session->data['token']);
        $this->data['record_action']=$this->url->link('deposit/record', 'token=' . $this->session->data['token']);
    }

	public function index(){
		// ＝1 升序 ＝2 降序
		$sort_count=$_GET['count'];
		$sort_time=$_GET['time'];
		$page=$_GET['page'];

		if(empty($page)) $page=1;


		$this->document->setTitle('充值记录');

        $this->load->model('account/customer_deposit');

     	$records=$this->model_account_customer_deposit->getCustomerDeposit('','','',1);
     	
     	$this->data['sort_count']=$sort_count;
     	$this->data['sort_time']=$sort_time;
     	$this->data['records']=$records;

     	$baseurl=$this->url->link('deposit/record', 'token=' . $this->session->data['token'] . '&page={page}', '');

     	$counturl=$baseurl.($sort_count==1?'&count=2':'&count=1').'&time='.$sort_time;
     	$timeurl=$baseurl.'&count='.$sort_count.($sort_time==1?'&time=2':'&time=1');

     	$this->data['counturl']=$counturl;
     	$this->data['timeurl']=$timeurl;

     	$this->template="deposit/record.tpl";

     	$this->children = array(
			'common/header',
			'common/footer'
		);

     	$this->render();
	}
}