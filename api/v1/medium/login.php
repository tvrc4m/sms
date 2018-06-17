<?php

class Login extends Medium{

	public function run($action,$data){

		switch ($action) {

			case 'authorize':return $this->authorize($data);break;
			
		}
	}

	public function authorize($data){

		$app_id=$data['appid'];

		$token=$data['token'];

		include_once MODEL.'app.model.php';

		$app=new AppMysql();

		$app=$app->getApp($app_id);

		// $app=MysqlModel::app('getApp',array($app_id));
		if(empty($app)) return false;
		
		if($app['token']==$token){

			$customer_id=$app['customer_id'];

			include_once MODEL.'customer.model.php';

			$m_customer=new CustomerMysql();

			$customer=$m_customer->getCustomer($customer_id);

			// $customer=MysqlModel::customer('getCustomer',array($customer_id));

			if(empty($customer)) return false;

			S('u',$customer);
			S('uid',$customer['customer_id']);

			return true;
		} 

		return false;
	}
}