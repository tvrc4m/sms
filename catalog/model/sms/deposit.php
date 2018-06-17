<?php 
class ModelSmsDeposit extends Model {

	public function insertDeposit($customer_id,$data) {
		
		$sql="INSERT INTO ".DB_PREFIX."sms_deposit (sms_cat_id,customer_id,realname,count,amount,status,) VALUES ({$data['cat_id']},{$data['customer_id']},\"{$data['realname']}\",{$data['count']},{$data['amount']},{$data['status']})";
		
		$query = $this->db->query($sql);
	
		return $this->db->getLastId();
	}

	public function getCustomerDeposit($customer_id,$data){
		$sql="SELECT * FROM ".DB_PREFIX.'sms_deposit WHERE customer_id='.$customer_id;
		if(!empty($data['filter_status'])){
			$sql.=' AND `status`="'.$data['filter_status'].'"';
		}
		f (isset($data['start']) || isset($data['limit'])) {

			if ($data['start'] < 0) {
				$data['start'] = 0;
			}				

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}	
		
			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}
		$res=$this->db->query($sql);
		return $res->rows;
	}

	public function getCustomerDepositTotal($data){
		$sql="SELECT count(*) as 'count' FROM ".DB_PREFIX.'sms_deposit WHERE customer_id='.$customer_id;
		if(!empty($data['filter_status'])){
			$sql.=' AND `status`="'.$data['filter_status'].'"';
		}
		$res=$this->db->query($sql);
		return $res->row['count'];
	}

	public function updateCustomerDeposit($customer_id,$outbox_id,$data){
		$sql="";
	}
}
