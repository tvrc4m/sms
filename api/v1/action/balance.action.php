<?php

class BalanceAction extends APIAction{

	public function index(){

		$balance=Medium::sms('balance');

		echo $balance;

		exit();
	}
}