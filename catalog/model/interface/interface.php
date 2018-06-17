<?php 
class ModelInterfaceInterface extends Model {

	public function getDefaultInterface(){
		$sql="select * FROM ".DB_PREFIX."sms_interface where status=1 limit 1";
		$res=$this->db->query($sql);
		return $res->row;
	}
}
