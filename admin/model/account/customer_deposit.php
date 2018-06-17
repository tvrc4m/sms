<?php

class ModelAccountCustomerDeposit extends Model {

	public function addCustomerDeposit($data) {

		$this->db->query("INSERT INTO " . DB_PREFIX . "customer_deposit SET customer_id = '" . (int)$data['customer_id'] . "', realname = '" . $data['realname'] . "', count = '" . (int)$data['count'] . "', amount = '" . $data['amount'] . "', status = 1");
	
		$deposit_id = $this->db->getLastId();
		
		return $deposit_id;
	}

	public function getCustomerDeposit($where,$sort=array(),$page=1,$limit=100){
		// $sort=array_map(function($array), $sort){
		// 	return $array['']
		// }
		$sql="SELECT * FROM ".DB_PREFIX."customer_deposit";
		$query=$this->db->query($sql);
		return $query->rows;
	}
}