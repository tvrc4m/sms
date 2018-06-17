<?php

class SmsMysql extends MysqlModel{

	protected $table='sms_outbox';

	public function addSms($data){

		$time=date('Y-m-d H:i:s');

		$data['update_time']=$data['send_time']=date('Y-m-d H:i:s');

		$param=array('_insert'=>'sms_outbox','_value'=>$data);

		$status=$this->query($param);

		return $status;
	}

	public function updateSmsError($error){

		$data['send_error']=$error;

		$param=array('_update'=>'sms_outbox','_set'=>$data);

		$status=$this->query($param);

		return $status;
	}
}