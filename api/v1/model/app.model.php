<?php

class AppMysql extends MysqlModel{

	protected $table='app';

	public function getApp($app_id){

		$param=array('_select'=>'*','_where'=>array('app_id'=>$app_id));

		return $this->get($param);
	}

	public function addApp($data){

	}
}