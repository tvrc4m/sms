<?php
class ModelUserBankAccount extends Model {

	public function addUserBankAccount($data) {
		$this->db->query("INSERT INTO `" . DB_PREFIX . "user_bank_account` SET realname = '" . $this->db->escape($data['realname']) . "', bank_name = '" . $this->db->escape($data['bank_name']) . "', card_number = '" . $this->db->escape($data['card_number']) . "', phone = '" . $this->db->escape($data['phone']). "', `default` = '" . (int)$data['default'] . "',status='".(int)$data['status']. "'");
		$bank_account_id=$this->db->getLastId();
		if($data['default']){
			$this->db->query('UPDATE '.DB_PREFIX."user_bank_account set `default`=0 where bank_account_id!={$bank_account_id}");
		}
	}

	public function editBankAccount($bank_account_id,$data){
		$this->db->query("UPDATE `" . DB_PREFIX . "user_bank_account` SET realname = '" . $this->db->escape($data['realname']) . "', bank_name = '" . $this->db->escape($data['bank_name']) . "', card_number = '" . $this->db->escape($data['card_number']) . "', phone = '" . $this->db->escape($data['phone']) . "', `default` = '" . (int)$data['default'] . "',status='".(int)$data['status']."' where bank_account_id={$bank_account_id}");
		if($data['default']){
			$this->db->query('UPDATE '.DB_PREFIX."user_bank_account set `default`=0 where bank_account_id!={$bank_account_id}");
		}
	}

	public function deleteBankAccount($bank_account_id){
		$this->db->query("delete from ".DB_PREFIX."user_bank_account where bank_account_id={$bank_account_id}");
	}

	public function getUserBankAccount($bank_account_id){
		$sql="select * from ".DB_PREFIX."user_bank_account where bank_account_id={$bank_account_id}";
		$res=$this->db->query($sql);
		return $res->row;
	}

	public function getUserBankAccounts(){
		$sql="select * from ".DB_PREFIX."user_bank_account";
		$res=$this->db->query($sql);
		return $res->rows;
	}

	public function getUserBankAccountTotal(){
		$sql="select count(*) as count from ".DB_PREFIX."user_bank_account";
		$res=$this->db->query($sql);
		return $res->rows['count'];
	}
}