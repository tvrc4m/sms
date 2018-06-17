<?php 
class ModelSmsCat extends Model {

	public function getSmsCats(){
		$sql="select * from ".DB_PREFIX.'sms_cat';
		$res=$this->db->query($sql);
		return $res->rows;
	}
}