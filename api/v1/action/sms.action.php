<?php

class SmsAction extends APIAction{

	public function send(){

		include_once MEDIUM.'sms.php';

		$sms=new Sms();

		$sms->send($_REQUEST);

		// M::ucpass('template',array());
	}
}