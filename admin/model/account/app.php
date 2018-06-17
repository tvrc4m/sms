<?php 
class ModelAccountApp extends Model {

	public function addApp($data) {
		$token=uniqid('HX');
		$customer_id=(int)$data['customer_id'];
      	$this->db->query("INSERT INTO " . DB_PREFIX . "app SET name = '" . $this->db->escape($data['name']) . "', token = '" . $token . "', customer_id = '" . $customer_id . "'");
      	
      	$app_id = $this->db->getLastId();
		return $app_id;
	}
}