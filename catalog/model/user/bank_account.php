<?php
class ModelUserBankAccount extends Model {

	public function getUserBankAccount(){
		$sql="select * from ".DB_PREFIX."user_bank_account where `default`=1";
		$res=$this->db->query($sql);
		return $res->row;
	}

}