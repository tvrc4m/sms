<?php
class ModelAccountCustomerSmsCat extends Model {

	public function getCustomerSmsCat($customer_id){
		$sql="select cc.sms_cat_id,sc.name,cc.count from ".DB_PREFIX.'customer_sms_cat cc,'.DB_PREFIX.'sms_cat sc where cc.customer_id='.$customer_id.' and cc.sms_cat_id=sc.sms_cat_id';
		$res=$this->db->query($sql);
		return $res->rows;
	}

}