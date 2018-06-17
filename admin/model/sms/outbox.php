<?php 
class ModelSmsOutbox extends Model {

	public function getOutbox($data){
		$sql="SELECT * FROM ".DB_PREFIX.'sms_outbox'.' where 1=1 ';
		if(!empty($data['filter_status'])){
			$sql.=' AND status="'.$data['filter_status'].'"';
		}
		if(!empty($data['filter_api'])){
			$sql.=' AND (tempid IS NULL OR tempid=0) ';
		}
		
		if(!empty($data['filter_phone'])){
			$sql.=' AND phones like "%'.$data['filter_phone'].'%"';
		}
		if(!empty($data['filter_message'])){
			$sql.=' AND message like "%'.$data['filter_message'].'%"';
		}

		$sql.=" ORDER BY added_time DESC";

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

	public function getOutBoxTotal($data){
		$sql="SELECT count(*) as count FROM ".DB_PREFIX.'sms_outbox where 1=1 ';
		if(!empty($data['filter_status'])){
			$sql.=' AND status="'.$data['filter_status'].'"';
		}
		if(!empty($data['filter_api'])){
			$sql.=' AND (tempid IS NULL OR tempid=0) ';
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
	public function getOutboxDetail($sms_id){
		$sql="select * FROM ".DB_PREFIX."sms_outbox where sms_id={$sms_id}";
		$res=$this->db->query($sql);
		return $res->row;
	}
}
