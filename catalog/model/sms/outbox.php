<?php 
class ModelSmsOutbox extends Model {

	public function insertOutbox($customer_id,$phones,$message,$timer,$is_timer=0,$clients=array(),$groups=array(),$multiple=1) {
		
		$count=count($phones)*$multiple;
		$clients=implode(',', $clients);
		$groups=implode(',', $groups);
		$phones=implode(',', $phones);
		$time=date('Y-m-d H:i:s');
		$sql="INSERT INTO ".DB_PREFIX."sms_outbox set customer_id={$customer_id},clients='{$clients}',groups='{$groups}',phones='{$phones}',`count`={$count},message='{$message}',status=1,is_timer={$is_timer},timer='{$timer}',added_time='{$time}',update_time='{$time}',send_time='{$time}';";
		$query = $this->db->query($sql);
		
		return $this->db->getLastId();
	}

	public function getCustomerOutbox($customer_id,$data){
		$sql="SELECT * FROM ".DB_PREFIX.'sms_outbox where  customer_id='.$customer_id;
		if(!empty($data['filter_status'])){
			$sql.=' AND status="'.$data['filter_status'].'"';
		}
		
		if(!empty($data['filter_phone'])){
			$sql.=' AND phones like "%'.$data['filter_phone'].'%"';
		}
		if(!empty($data['filter_message'])){
			$sql.=' AND message like "%'.$data['filter_message'].'%"';
		}

		$sql.=' ORDER BY send_time DESC';
		
		if (isset($data['start']) || isset($data['limit'])) {

			if ($data['start'] < 0) {
				$data['start'] = 0;
			}				

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}	
		
			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}
		
		// echo $sql;exit();
		$res=$this->db->query($sql);
		return $res->rows;
	}

	public function getOutboxDetail($customer_id,$sms_id){
		$sql="select * FROM ".DB_PREFIX."sms_outbox where customer_id={$customer_id} and sms_id={$sms_id}";
		$res=$this->db->query($sql);
		return $res->row;
	}

	public function getCustomerOutBoxTotal($customer_id,$data){
		$sql="SELECT count(*) as count FROM ".DB_PREFIX.'sms_outbox where customer_id='.$customer_id;
		if(!empty($data['filter_status'])){
			$sql.=' AND status="'.$data['filter_status'].'"';
		}
		
		if(!empty($data['filter_phone'])){
			$sql.=' AND phones like "%'.$data['filter_phone'].'%"';
		}
		if(!empty($data['filter_message'])){
			$sql.=' AND message like "%'.$data['filter_message'].'%"';
		}
		$res=$this->db->query($sql);
		return $res->row['count'];
	}

	public function updateCustomerOutBox($customer_id,$outbox_id,$data){
		$sql="";
	}
}
