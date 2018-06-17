<?php
class ModelUserChangePassword extends Model {

	public function insertIdentifyCode($data) {
		$this->db->query("REPLACE INTO `" . DB_PREFIX . "user_change_password` SET user_id = '" . $this->db->escape($data['user_id']) . "', code = '" . $this->db->escape($data['code']) . "', create_time = " . time());
	}

	public function getIdentifyCodeByUserID($user_id){
		$res=$this->db->query("SELECT user_id,code,create_time FROM ".DB_PREFIX.'user_change_password WHERE user_id='.$user_id);
		return $res->row;
	}

	public function deleteIdentifyByUserID($user_id){
		$this->db->query("DELETE FROM ".DB_PREFIX.'user_change_password WHERE user_id='.$user_id);
	}
}