<?php 
class ModelClientGroup extends Model {

	public function getUserAllGroup($customer_id) {
		
		$sql="SELECT * FROM ".DB_PREFIX.'client_group WHERE customer_id='.$customer_id;
		
		$query = $this->db->query($sql);
	
		return $query->rows;
	}

	public function getUserGroups($customer_id,$data=array()){

		$sql="SELECT * FROM ".DB_PREFIX.'client_group WHERE customer_id='.$customer_id;

		if(!empty($data['filter_name'])){
			$sql.=' AND `name` like "%'.$data['filter_name'].'%"';
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

	public function getUserGroupsTotal($customer_id, $data=array()){
		$sql="SELECT count(*) as 'count' FROM ".DB_PREFIX.'client_group WHERE customer_id='.$customer_id;

		if(!empty($data['filter_name'])){
			$sql.=' AND `name` like "%'.$data['filter_name'].'%"';
		}
		if(!empty($data['filter_remark'])){
			$sql.=' AND `remark` like "%'.$data['filter_remark'].'%"';
		}
		$query = $this->db->query($sql);
	
		return $query->row['count'];
	}

	public function delUserClientGroup($customer_id,$group_id,$delClient=0){
		$sql="DELETE FROM ".DB_PREFIX.'client_group WHERE customer_id='.$customer_id.' AND client_group_id='.$group_id;
		$this->db->query($sql);
		$status=$this->db->countAffected();
		if($status && $delClient){
			$sql="UPDATE ".DB_PREFIX.'client SET client_group_id=0 WHERE client_group_id='.$group_id;
		}
		return $status;
	}

	public function addClientGroup($customer_id,$data){

		$this->db->query("INSERT INTO " . DB_PREFIX . "client_group SET name = '" . $this->db->escape($data['name'])."',customer_id=".$customer_id.",remark='".$this->db->escape($data['remark'])."'");
		
		return $this->db->getLastId();
	}

	public function getClientGroup($customer_id,$group_id){
		$res=$this->db->query("SELECT * FROM ".DB_PREFIX.'client_group WHERE customer_id='.$customer_id.' AND client_group_id='.$group_id);
		return $res->row;
	}

	public function editClientGroup($customer_id,$data){
		$this->db->query("UPDATE " . DB_PREFIX . "client_group SET name = '" . $this->db->escape($data['name']) ."',remark='".$this->db->escape($data['remark'])."' WHERE client_group_id=".intval($data['group_id']).' AND customer_id='.$customer_id);
		// return $this->db->countAffected();
		return 1;
	}

	public function checkGroupName($customer_id,$name,$except_group_id=NULL){
		$sql="SELECT count(*) as 'count' FROM ".DB_PREFIX.'client_group WHERE name="'.$name.'" AND customer_id='.$customer_id;
		if(!empty($except_group_id)){
			$sql.=' AND client_group_id!='.$except_group_id;
		}
		$res=$this->db->query($sql);
		return $res->row['count'];
	}
}
?>