<?php 
class ModelBlendPlatform extends Model {

	public function getAllPlatform() {
		$res=$this->db->query('SELECT * FROM '.DB_PREFIX.'platform');
		return $res->rows;
	}

}
?>