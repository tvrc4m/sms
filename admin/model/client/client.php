<?php 
class ModelClientClient extends Model {

	public function getUserClients($customer_id,$data) {
		
		$sql="SELECT * FROM ".DB_PREFIX.'client WHERE customer_id= '.$customer_id;
		
		if(!empty($data['filter_name'])){
			$sql.=' AND `name` like "%'.$data['filter_name'].'%"';
		}
		if(!empty($data['filter_phone'])){
			$sql.=' AND `phone` = "'.$data['filter_phone'].'"';
		}
		if(!empty($data['filter_sex'])){
			$sql.=' AND `sex` = "'.(int)$data['filter_sex'].'"';
		}
		if(!empty($data['filter_remark'])){
			$sql.=' AND `remark` like "%'.$data['filter_remark'].'%"';
		}

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}				

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}	
		
			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}	
		
		$query = $this->db->query($sql);
	
		return $query->rows;
	}

	public function getUserClientsTotal($customer_id,$data){
		$sql="SELECT count(*) as 'count' FROM ".DB_PREFIX.'client WHERE customer_id='.$customer_id;

		if(!empty($data['filter_name'])){
			$sql.=' AND `name` like "%'.$data['filter_name'].'%"';
		}
		if(!empty($data['filter_phone'])){
			$sql.=' AND `phone` = "'.$data['filter_phone'].'"';
		}
		if(!empty($data['filter_sex'])){
			$sql.=' AND `sex` = "'.(int)$data['filter_sex'].'"';
		}
		if(!empty($data['filter_remark'])){
			$sql.=' AND `remark` like "%'.$data['filter_remark'].'%"';
		}
		
		$query = $this->db->query($sql);
	
		return $query->row['count'];
	}

	public function delUserClient($customer_id,$client_id){
		$sql="DELETE FROM ".DB_PREFIX.'client WHERE client_id='.$client_id.' AND customer_id='.$customer_id;
		$this->db->query($sql);
	}

	public function addUserClient($customer_id,$data){

		$this->db->query("INSERT INTO " . DB_PREFIX . "client SET name = '" . $this->db->escape($data['name']) . "',customer_id=".$customer_id.", client_group_id = '" . (int)$data['group_id'] .  "', phone = '" . (int)$data['phone'] . "', email = '" . $this->db->escape($data['email']) . "', sex = '" . (int)$data['sex'] . "', company = '" . $this->db->escape($data['company']) . "',remark='".$this->db->escape($data['remark'])."'");
		
		return $this->db->getLastId();
	}

	public function getUserGroupClients($group_id){
		$sql="SELECT * FROM ".DB_PREFIX.'client WHERE client_group_id="'.$group_id.'" AND customer_id='.$customer_id;
		$res=$this->db->query($sql);
		return $res->rows;
	}

	public function getClient($client_id){
		$res=$this->db->query("SELECT * FROM ".DB_PREFIX.'client WHERE client_id='.$client_id);
		return $res->row;
	}

	public function editUserClient($customer_id,$data){
		$this->db->query("UPDATE " . DB_PREFIX . "client SET name = '" . $this->db->escape($data['name']) . "', client_group_id = '" . (int)$data['group_id'] . "', phone = '" . (int)$data['phone'] . "', email = '" . $this->db->escape($data['email']) . "', sex = '" . (int)$data['sex'] . "', company = '" . $this->db->escape($data['company']) . "',remark='".$this->db->escape($data['remark'])."' WHERE customer_id=".$customer_id.' AND client_id'=$client_id);
		// return $this->db->countAffected();
		return 1;
	}
}
?>