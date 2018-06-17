<?php 
class ModelAccountCustomer extends Model {


	public function addCustomer($data) {
      	$this->db->query("INSERT INTO " . DB_PREFIX . "customer SET name = '" . $this->db->escape($data['name']) . "', email = '" . $this->db->escape($data['email']) . "', telephone = '" . $this->db->escape($data['telephone']) . "', customer_group_id = '" . (int)$data['customer_group_id'] . "', salt = '" . $this->db->escape($salt = substr(md5(uniqid(rand(), true)), 0, 9)) . "', password = '" . $this->db->escape(sha1($salt . sha1($salt . sha1($data['password'])))) . "', status = '" . (int)$data['status'] . "',approved=1, date_added = NOW()");
      	
      	$customer_id = $this->db->getLastId();
		return $customer_id;      	
	}

	public function editCustomer($customer_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "customer SET name = '" . $this->db->escape($data['name']) . "', email = '" . $this->db->escape($data['email']) . "', telephone = '" . $this->db->escape($data['telephone']) . "', customer_group_id = '" . (int)$data['customer_group_id'] . "', status = '" . (int)$data['status'] . "' WHERE customer_id = '" . (int)$customer_id . "'");
	
      	if ($data['password']) {
        	$this->db->query("UPDATE " . DB_PREFIX . "customer SET salt = '" . $this->db->escape($salt = substr(md5(uniqid(rand(), true)), 0, 9)) . "', password = '" . $this->db->escape(sha1($salt . sha1($salt . sha1($data['password'])))) . "' WHERE customer_id = '" . (int)$customer_id . "'");
      	}
	}

	public function addCustomerBlack($customer_id){
		$this->db->query("UPDATE " . DB_PREFIX . "customer SET status =0  WHERE customer_id = '" . (int)$customer_id . "'");
	}

	public function cancelCustomerBlack($customer_id){
		$this->db->query("UPDATE " . DB_PREFIX . "customer SET status =1  WHERE customer_id = '" . (int)$customer_id . "'");
	}

	public function delCustomer($platform_Customer_id){
		$sql="DELETE FROM ".DB_PREFIX.'platform_Customer WHERE platform_Customer_id='.$platform_Customer_id;
		$this->db->query($sql);
	}

	public function getCustomer($customer_id){
		$res=$this->db->query("SELECT * FROM ".DB_PREFIX.'customer WHERE customer_id='.$customer_id);
		return $res->row;
	}

	public function getCustomerTotal($data){
		$sql="SELECT count(*) as 'count' FROM ".DB_PREFIX.'customer WHERE 1=1';
		
		if(!empty($data['filter_name'])){
			$sql.=' AND `name` like "%'.$data['filter_name'].'%"';
		}
		if(!empty($data['filter_phone'])){
			$sql.=' AND `telephone` = "'.$data['filter_phone'].'"';
		}
		if(!empty($data['filter_email'])){
			$sql.=' AND `email` = "'.(int)$data['filter_email'].'"';
		}
		if(!empty($data['filter_remark'])){
			$sql.=' AND `remark` like "%'.$data['filter_remark'].'%"';
		}

		$query = $this->db->query($sql);
	
		return $query->row['count'];
	}

	public function recharge($customer_id,$count){
		$sql="UPDATE ".DB_PREFIX."customer SET sms_count=sms_count+{$count} WHERE customer_id={$customer_id};";
		$this->db->query($sql);
		return $this->db->countAffected();
	}

	public function getCustomers($data = array()) {
		$sql = "SELECT c.customer_id,c.name,c.email,c.telephone,c.sms_count,c.status,cgd.name AS customer_group FROM " . DB_PREFIX . "customer c LEFT JOIN " . DB_PREFIX . "customer_group_description cgd ON (c.customer_group_id = cgd.customer_group_id) WHERE cgd.language_id = '" . (int)$this->config->get('config_language_id') . "'";

		$implode = array();
		
		if (!empty($data['filter_name'])) {
			$implode[] = "c.name LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
		}
		
		if (!empty($data['filter_email'])) {
			$implode[] = "c.email LIKE '" . $this->db->escape($data['filter_email']) . "%'";
		}

		if (!empty($data['filter_customer_group_id'])) {
			$implode[] = "c.customer_group_id = '" . (int)$data['filter_customer_group_id'] . "'";
		}	
				
		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			$implode[] = "c.status = '" . (int)$data['filter_status'] . "'";
		}	
		
		if (!empty($data['filter_date_added'])) {
			$implode[] = "DATE(c.date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
		}
		
		if ($implode) {
			$sql .= " AND " . implode(" AND ", $implode);
		}
		
		$sort_data = array(
			'c.name',
			'c.email',
			'customer_group',
			'c.status',
			'c.date_added'
		);	
			
		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];	
		} else {
			$sql .= " ORDER BY c.name";	
		}
			
		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
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

	public function getTotalCustomers($data = array()) {
      	$sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "customer";
		
		$implode = array();
		
		if (!empty($data['filter_name'])) {
			$implode[] = "name LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
		}
		
		if (!empty($data['filter_email'])) {
			$implode[] = "email LIKE '" . $this->db->escape($data['filter_email']) . "%'";
		}
		
		if (!empty($data['filter_customer_group_id'])) {
			$implode[] = "customer_group_id = '" . (int)$data['filter_customer_group_id'] . "'";
		}	
		
		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			$implode[] = "status = '" . (int)$data['filter_status'] . "'";
		}			
		
		if (isset($data['filter_approved']) && !is_null($data['filter_approved'])) {
			$implode[] = "approved = '" . (int)$data['filter_approved'] . "'";
		}		
				
		if (!empty($data['filter_date_added'])) {
			$implode[] = "DATE(date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
		}
		
		if ($implode) {
			$sql .= " WHERE " . implode(" AND ", $implode);
		}
				
		$query = $this->db->query($sql);
				
		return $query->row['total'];
	}

	public function getCustomerByEmail($email) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "customer WHERE LCASE(email) = '" . $this->db->escape(utf8_strtolower($email)) . "'");
	
		return $query->row;
	}

	public function deleteCustomer($customer_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "customer WHERE customer_id = '" . (int)$customer_id . "'");
	}

}
