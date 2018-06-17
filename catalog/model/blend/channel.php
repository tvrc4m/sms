<?php 
class ModelBlendChannel extends Model {

	public function getChannels($data) {
		
		$sql="SELECT p.name as 'platform',pc.name 'name',pc.platform_channel_id,pc.remark FROM ".DB_PREFIX.'platform_channel pc,'.DB_PREFIX.'platform p WHERE pc.platform_id=p.platform_id';
		
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

	public function delChannel($platform_channel_id){
		$sql="DELETE FROM ".DB_PREFIX.'platform_channel WHERE platform_channel_id='.$platform_channel_id;
		$this->db->query($sql);
	}

	public function addChannel($data){

		$this->db->query("INSERT INTO " . DB_PREFIX . "platform_channel SET name = '" . $this->db->escape($data['name']) . "', platform_id = '" . (int)$data['platform_id'] . "',remark='".$this->db->escape($data['remark'])."'");
		
		return $this->db->getLastId();
	}

	public function getCountByName($name,$except_channel_id=NULL){
		$sql="SELECT COUNT(*) as 'count' FROM ".DB_PREFIX.'platform_channel WHERE LOWER(`name`)="'.$this->db->escape(trim(strtolower($name))).'"';
		if(!empty($except_channel_id)){
			$sql.=" AND platform_channel_id!=".$except_channel_id;
		}
		$res=$this->db->query($sql);
		return $res->row['count'];
	}

	public function getChannel($platform_channel_id){
		$res=$this->db->query("SELECT * FROM ".DB_PREFIX.'platform_channel WHERE platform_channel_id='.$platform_channel_id);
		return $res->row;
	}

	public function editChannel($data){
		$this->db->query("UPDATE " . DB_PREFIX . "platform_channel SET name = '" . $this->db->escape($data['name']) . "', platform_id = '" . (int)$data['platform_id'] . "',remark='".$this->db->escape($data['remark'])."' WHERE platform_channel_id=".(int)$data['platform_channel_id']);
		// return $this->db->countAffected();
		return 1;
	}
}
?>