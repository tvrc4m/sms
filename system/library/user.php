<?php
class User {
	private $user_id;
	private $username;
  	private $permission = array();
    private $identity;
    private $store_id;

  	public function __construct($registry) {
		$this->db = $registry->get('db');
		$this->request = $registry->get('request');
		$this->session = $registry->get('session');
		
    	if (isset($this->session->data['user_id']) && isset($this->session->data['identity']) && $this->session->data['identity'] == 'vendor') {

            $user_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "vendor WHERE vendor_id = '" . (int)$this->session->data['user_id'] . "' AND status = '1'");

            if ($user_query->num_rows) {
                $this->user_id = $user_query->row['vendor_id'];
                $this->username = $user_query->row['vendorname'];
                $this->identity = $this->session->data['identity'];
                $this->store_id = $user_query->row['store_id'];;

                $this->db->query("UPDATE " . DB_PREFIX . "vendor SET ip = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "' WHERE vendor_id = '" . (int)$this->session->data['user_id'] . "'");

                //add the access & modify start
                $files = glob(DIR_APPLICATION . 'controller/*/*.php');

                foreach ($files as $file) {
                    $data = explode('/', dirname($file));

                    $permission = end($data) . '/' . basename($file, '.php');

                    $this->data['permissions'][] = $permission;

                }

                $this->permission['access'] = $this->data['permissions'];
                $this->permission['modify'] = $this->data['permissions'];
                //add the access & modify end

            } else {
                $this->logout();
            }

    	}elseif(isset($this->session->data['user_id']) && isset($this->session->data['identity']) && $this->session->data['identity'] == 'admin') {

            $user_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "user WHERE user_id = '" . (int)$this->session->data['user_id'] . "' AND status = '1'");

            if ($user_query->num_rows) {
                $this->user_id = $user_query->row['user_id'];
                $this->username = $user_query->row['username'];
                $this->identity = $this->session->data['identity'];
                $this->store_id = 0;

                $this->db->query("UPDATE " . DB_PREFIX . "user SET ip = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "' WHERE user_id = '" . (int)$this->session->data['user_id'] . "'");

                $user_group_query = $this->db->query("SELECT permission FROM " . DB_PREFIX . "user_group WHERE user_group_id = '" . (int)$user_query->row['user_group_id'] . "'");

                $permissions = unserialize($user_group_query->row['permission']);

                if (is_array($permissions)) {
                    foreach ($permissions as $key => $value) {
                        $this->permission[$key] = $value;
                    }
                }
            } else {
                $this->logout();
            }

        }
  	}
		
  	public function login($username, $password, $identity = 'vendor') {

        $result = false;

        if($identity == 'vendor') {

            $user_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "vendor WHERE vendorname = '" . $this->db->escape($username) . "' AND (password = SHA1(CONCAT(salt, SHA1(CONCAT(salt, SHA1('" . $this->db->escape($password) . "'))))) OR password = '" . $this->db->escape(md5($password)) . "') AND status = '1'");
            
            if ($user_query->num_rows) {
                $this->session->data['user_id'] = $user_query->row['vendor_id'];
                $this->session->data['identity'] = $identity;

                $this->user_id = $user_query->row['vendor_id'];
                $this->username = $user_query->row['vendorname'];
                $this->identity = $identity;
                $this->store_id = $user_query->row['store_id'];

                //add the access & modify start
                $files = glob(DIR_APPLICATION . 'controller/*/*.php');

                foreach ($files as $file) {
                    $data = explode('/', dirname($file));

                    $permission = end($data) . '/' . basename($file, '.php');

                    $this->data['permissions'][] = $permission;

                }

                $this->permission['access'] = $this->data['permissions'];
                $this->permission['modify'] = $this->data['permissions'];
                //add the access & modify end

                $result = true;
            } else {
                $result = false;
            }

        }elseif($identity == 'admin') {

            $user_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "user WHERE username = '" . $this->db->escape($username) . "' AND (password = SHA1(CONCAT(salt, SHA1(CONCAT(salt, SHA1('" . $this->db->escape($password) . "'))))) OR password = '" . $this->db->escape(md5($password)) . "') AND status = '1'");

            if ($user_query->num_rows) {
                $this->session->data['user_id'] = $user_query->row['user_id'];
                $this->session->data['identity'] = $identity;

                $this->user_id = $user_query->row['user_id'];
                $this->username = $user_query->row['username'];
                $this->identity = $identity;
                $this->store_id = 0;

                $user_group_query = $this->db->query("SELECT permission FROM " . DB_PREFIX . "user_group WHERE user_group_id = '" . (int)$user_query->row['user_group_id'] . "'");

                $permissions = unserialize($user_group_query->row['permission']);

                if (is_array($permissions)) {
                    foreach ($permissions as $key => $value) {
                        $this->permission[$key] = $value;
                    }
                }

                $result = true;
            } else {
                $result = false;
            }

        }

        return $result;

  	}

  	public function logout() {
		unset($this->session->data['user_id']);
	
		$this->user_id = '';
		$this->username = '';
		
		session_destroy();
  	}

  	public function hasPermission($key, $value) {
    	if (isset($this->permission[$key])) {
	  		return in_array($value, $this->permission[$key]);
		} else {
	  		return false;
		}
  	}
  
  	public function isLogged() {
    	return $this->user_id;
  	}
  
  	public function getId() {
    	return $this->user_id;
  	}
	
  	public function getUserName() {
    	return $this->username;
  	}

    public function getStoreId() {
        return $this->store_id;
    }

    public function getIdentity() {
        return $this->identity;
    }

}
?>