<?php

class CustomerMysql extends MysqlModel{

	protected $table='customer';

	public function getCustomer($customer_id){

		$param=array('_select'=>'*','_where'=>array('customer_id'=>$customer_id));

		return $this->get($param);
	}

	public function updateCustomerSmsCount($customer_id,$count){

		$sql="UPDATE lt_customer SET sms_count=sms_count-{$count} WHERE customer_id={$customer_id}";

		$this->query($sql);
	}
}