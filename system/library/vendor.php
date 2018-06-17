<?php
class Vendor {
	private $store_id;

  	public function __construct() {
        $this->store_id = 1;
  	}

  	public function getStoreId() {
    	return $this->store_id;
  	}

}
?>