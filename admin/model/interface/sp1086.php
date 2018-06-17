<?php

define("INTERFACE_SP1086_UNAME",'传媒一号');
define("INTERFACE_SP1086_PASSWORD",'888888');

class ModelInterfaceSp1086 extends Model {

	private $URL_SEND="http://www.sp1086.com/sms/smsInterface.do?";

	private $URL_BALANCE="http://www.sp1086.com/sms/smsBalance.do?";

	private $URL_CHECK="http://www.sp1086.com/sms/checkFilterWord.do?";

	public function sendSms($mobile,$content){
		$chunks=array_chunk($mobile,1000);
		$result=array();
		foreach ($chunks as $chunk) {
			$params=array('username'=>INTERFACE_SP1086_UNAME,'password'=>INTERFACE_SP1086_PASSWORD,'mobile'=>implode(',', $chunk),'content'=>$content);
			$url=$this->URL_SEND.http_build_query($params);
			$res=$this->http_post($url);
			if($re['resultcode']==0){
				
			}
		}
	}

	public function smsBalance(){
		$params=array('username'=>INTERFACE_SP1086_UNAME,'password'=>INTERFACE_SP1086_PASSWORD);
		$url=$this->URL_BALANCE.http_build_query($params);
		$res=$this->http_post($url);
		if($res['resultcode']==0){
			return array('balance_num'=>$res['smsbalancenum'],'send_num'=>$res['smssendednum']);
		}
	}

	public function checkFilter($content){
		$params=array('username'=>INTERFACE_SP1086_UNAME,'password'=>INTERFACE_SP1086_PASSWORD,'content'=>$content);
		$url=$this->URL_CHECK.http_build_query($params);
		$res=$this->http_post($url);
		$status=$res['resultcode'];
		return !$status;
	}

	private function http_post($url){
		$ch = curl_init();
	    curl_setopt( $ch, CURLOPT_URL, $url );
	    curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, true );
	    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
	    curl_setopt( $ch, CURLOPT_AUTOREFERER, true );
	    curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, 10);
	    curl_setopt( $ch, CURLOPT_TIMEOUT, 600);
	    $content = curl_exec( $ch );
	    $xml=simplexml_load_string($content);
	    return $this->XML2Array($xml,true);
	}
	private function XML2Array ( $xml , $recursive = true ){
	    if ( ! $recursive )
	    {
	        $array = simplexml_load_string ( $xml ) ;
	    }
	    else
	    {
	        $array = $xml ;
	    }
	    
	    $newArray = array () ;
	    $array = ( array ) $array ;
	    foreach ( $array as $key => $value )
	    {
	        $value = ( array ) $value ;
	        if ( isset ( $value [ 0 ] ) )
	        {
	            $newArray [ $key ] = trim ( $value [ 0 ] ) ;
	        }
	        else
	        {
	            $newArray [ $key ] = XML2Array ( $value , true ) ;
	        }
	    }
	    return $newArray ;
	}
}