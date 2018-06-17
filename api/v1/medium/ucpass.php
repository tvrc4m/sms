<?php

class Ucpass extends Medium{

	protected $accountsid='cb150925a01b8d0764105effaa241dc5';
	protected $token='0876b932073ddd6ad71958580c7f0b09';
	protected $appId='07a7ea6c718942e9bc48cce58cd26217';

	public function run($action,$data){

		switch ($action) {

			case 'template':return $this->template($data);break;
			
		}
	}

	public function template($data){

		require_once(EXTEND.'Ucpaas.class.php');

		//初始化必填
		$options['accountsid']=$this->accountsid;
		$options['token']=$this->token;

		//初始化 $options必填
		$ucpass = new Ucpaas($options);

		//短信验证码（模板短信）,默认以65个汉字（同65个英文）为一条（可容纳字数受您应用名称占用字符影响），超过长度短信平台将会自动分割为多条发送。分割后的多条短信将按照具体占用条数计费。
		$to = $data['phones'];
		$templateId = $data['tempid'];
		$param=$data['params'];

		$result=$ucpass->templateSMS($this->appId,$to,$templateId,$param);

		$result=json_decode($result);

		return '000000';

		return $result->resp->respCode;
	}
}