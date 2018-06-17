<?php 
class ModelInterfaceInterface extends Model {

	public function getInterfaces(){
		$sql="SELECT sms_interface_id,name,account,status from ".DB_PREFIX."sms_interface;";
		$res=$this->db->query($sql);
		return $res->rows;
	}

	public function addInterface($data){
		$sql="INSERT INTO ".DB_PREFIX."sms_interface set `name`='".$data['name']."',account='".$data['account']."',password='".$data['password']."',status=".(int)$data['status'];
		$this->db->query($sql);
		return $this->db->getLastId();
	}

	public function editInterface($data){
		if(!empty($data['password'])){
			$sql="UPDATE ".DB_PREFIX."sms_interface set `name`='".$data['name']."',account='".$data['account']."',password='".$data['password']."',status=".(int)$data['status']." where sms_interface_id=".(int)$data['sms_interface_id'];
		}else{
			$sql="UPDATE ".DB_PREFIX."sms_interface set `name`='".$data['name']."',account='".$data['account']."',status=".(int)$data['status']." where sms_interface_id=".(int)$data['sms_interface_id'];
		}
		$this->db->query($sql);
		return $this->db->countAffected();
	}

	public function delInterface($sms_interface_id){
		$sql="DELETE FROM ".DB_PREFIX."sms_interface where sms_interface_id=".(int)$sms_interface_id;
		$this->db->query($sql);
		return $this->db->countAffected();
	}

	public function getInterface($sms_interface_id){
		$sql="SELECT * FROM ".DB_PREFIX."sms_interface where sms_interface_id=".(int)$sms_interface_id;
		$res=$this->db->query($sql);
		return $res->row;
	}

	public function setDefaultByID($sms_interface_id){
		$sql="UPDATE ".DB_PREFIX."sms_interface set status=1 where sms_interface_id=".$sms_interface_id;
		$this->db->query($sql);
		$sql="UPDATE ".DB_PREFIX."sms_interface set status=0 where sms_interface_id!=".$sms_interface_id;
		$this->db->query($sql);
	}

	public function forbidden($sms_interface_id){
		$sql="UPDATE ".DB_PREFIX."sms_interface set status=0 where sms_interface_id=".$sms_interface_id;
		$this->db->query($sql);
	}

	public function getDefaultInterface(){
		$sql="select * FROM ".DB_PREFIX."sms_interface where status=1 limit 1";
		$res=$this->db->query($sql);
		return $res->row;
	}
}
