<?php
/*
 * 控制层
 */
class Action extends View{

	public function __construct(){

		parent::__construct();
	}
}

class APIAction extends Action{

	public function __construct(){

		parent::__construct();

		$this->check();
	}

	public function check(){

		$appid=$_REQUEST['appid'];

		$token=$_REQUEST['token'];

		include_once MEDIUM.'login.php';

		$login=new Login();

		$status=$login->authorize(array('appid'=>$appid,'token'=>$token));

		if($status) return true;
		
		exit(ERROR_AUTHORIZE);
	}
}