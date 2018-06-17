<?php 
class ModelClientClient extends Model {

	public function getUserClients($customer_id,$data=array()) {
		
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

	public function getClients($customer_id,$clients){
		$str_client=implode(',', $clients);
		$sql="SELECT * FROM ".DB_PREFIX."client WHERE customer_id= {$customer_id} and client_id in ({$str_client})";
		$res=$this->db->query($sql);
		return $res->rows;
	}

	public function delClient($customer_id,$client_id){
		$sql="DELETE FROM ".DB_PREFIX.'client WHERE client_id='.$client_id.' AND customer_id='.$customer_id;
		$this->db->query($sql);
		return $this->db->countAffected();
	}

	public function addClient($customer_id,$data){

		$this->db->query("INSERT INTO " . DB_PREFIX . "client SET name = '" . $this->db->escape($data['name']) . "',customer_id=".$customer_id.", client_group_id = '" . (int)$data['group_id'] .  "', phone = '" . $this->db->escape($data['phone']) . "', email = '" . $this->db->escape($data['email']) . "', sex = '" . (int)$data['sex'] . "', company = '" . $this->db->escape($data['company']) . "',remark='".$this->db->escape($data['remark'])."'");
		
		return $this->db->getLastId();
	}

	public function getUserGroupClients($customer_id,$group_id){
		$sql="SELECT * FROM ".DB_PREFIX.'client WHERE client_group_id="'.$group_id.'" AND customer_id='.$customer_id;
		$res=$this->db->query($sql);
		return $res->rows;
	}

	public function getClient($client_id){
		$res=$this->db->query("SELECT * FROM ".DB_PREFIX.'client WHERE client_id='.$client_id);
		return $res->row;
	}

	public function editClient($customer_id,$data){
		$this->db->query("UPDATE " . DB_PREFIX . "client SET name = '" . $this->db->escape($data['name']) . "', client_group_id = '" . (int)$data['group_id'] . "', phone = '" . (int)$data['phone'] . "', email = '" . $this->db->escape($data['email']) . "', sex = '" . (int)$data['sex'] . "', company = '" . $this->db->escape($data['company']) . "',remark='".$this->db->escape($data['remark'])."' WHERE customer_id=".$customer_id.' AND client_id='.$data['client_id']);
		// return $this->db->countAffected();
		return 1;
	}

	public function getClientCountInGroups($groups){
		if(empty($groups)) return 0;
		$sql="SELECT count(*) as 'count' FROM ".DB_PREFIX.'client WHERE client_group_id in("'.implode(',', $groups).'")';
		$res=$this->db->query($sql);
		return $res->row['count'];
	}

	public function getClientsInGroups($groups){
		if(empty($groups)) return 0;
		$sql="SELECT client_id,phone FROM ".DB_PREFIX.'client WHERE client_group_id in("'.implode(',', $groups).'")';
		$res=$this->db->query($sql);
		return $res->rows;
	}
}