<?php

class Sms extends Medium{

	public function run($action,$data){

		switch ($action) {

			case 'send':return $this->send($data);break;

			case 'balance':return $this->balance($data);break;
		}
	}

	public function send($data){

		$mobile=explode(',',$data['mobile']); //电话

		if(empty($mobile)) return -1;

		foreach($mobile as $m){

			if(!preg_match('/^\d{11}$/',$m)) exit(ERROR_MOBILE_NUMBER);
		}

		$count=count($mobile);

		if($count==0) exit(ERROR_EMPTY_MOBILE);

		if($_SERVER['REQUEST_METHOD']=='GET' && $count>50) exit(ERROR_MORE_MOBILE);

		if($_SERVER['REQUEST_METHOD']=='POST' && $count>2000) exit(ERROR_MORE_MOBILE);

		// $content=$data['content']; 

		// if(empty($content)) exit(ERROR_EMPTY_CONTENT);

		// if(strlen($content)>1500) exit(ERROR_MORE_CONTENT);


		$customer_id=S('uid');

		include_once MODEL.'customer.model.php';

		$m_customer=new CustomerMysql();

		$customer=$m_customer->getCustomer($customer_id);

		// $customer=SQL::customer('getCustomer',array($customer_id));

		$content_len=mb_strlen($content,'UTF8');
            
        $multiple=1;

       	$content_len>70 && $multiple=ceil($content_len/70);

		if(($count*$multiple)>$customer['sms_count']) exit(ERROR_BALANCE);

		$tempid=$data['tempid']; // 模板

		if(empty($tempid)) exit(ERROR_EMPTY_TEMPID);

		$params=$data['params']; // 模板参数

		$signtag=$data['signtag']; // 签名

		$data=array('customer_id'=>$customer_id,'phones'=>implode(',',$mobile),'params'=>$params,'tempid'=>$tempid,'count'=>$count,'message'=>$content);

		include_once MEDIUM.'ucpass.php';

		$ucpass=new Ucpass();

		$rescode=$ucpass->template($data);

		// M::ucpass('template',$data);

		if($rescode=='000000'){

			include_once MODEL.'sms.model.php';
			// include_once MODEL.'customer.model.php';

			$m_sms=new SmsMysql();

			$status=$m_sms->addSms($data);

			// $status=MysqlModel::sms('addSms',array($data));

			$m_customer=new CustomerMysql();

			$m_customer->updateCustomerSmsCount($customer_id,$count*$multiple);

			// MysqlModel::customer('updateCustomerSmsCount',array($customer_id,$count*$multiple));

			exit(SUCCESS_SEND);

		}else{
			exit($rescode);
		}
	}


	public function balance(){

		$customer_id=S('customer_id');

		$customer=MysqlModel::customer('getCustomer',array($customer_id));

		return (int)$customer['sms_count'];
	}
}