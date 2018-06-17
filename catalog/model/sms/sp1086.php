<?php 

class ModelSmsSp1086 extends Model{

	private $URL_SEND="http://www.sp1086.com/sms/smsInterface.do?";
	private $URL_BALANCE="http://www.sp1086.com/sms/smsBalance.do?";

	private $uname;

	private $password;

	public function __construct($registry) {

		parent::__construct($registry);
		
		$sql="select account,password from ".DB_PREFIX."sms_interface where `name`='sp1086'";
		$res=$this->db->query($sql);
		$this->uname=$res->row['account'];
		$this->password=$res->row['password'];
	}

	public function sendSms($mobile,$content){
		$chunks=array_chunk($mobile,10000);
		$status=0;
		foreach ($chunks as $chunk) {
			$params=array('username'=>$this->uname,'password'=>$this->password,'mobile'=>implode(',', $chunk),'content'=>$content);
			$url=$this->URL_SEND.http_build_query($params);
			$res=$this->http_post($url);
			if($re['resultcode']==0){
				$status=1;
			}else{
				$status=0;
			}
		}
		return $status;
	}

	public function smsBalance(){
		$params=array('username'=>$this->uname,'password'=>$this->password);
		$url=$this->URL_BALANCE.http_build_query($params);
		$res=$this->http_post($url);
		if($res['resultcode']==0){
			return array('balance_num'=>$res['smsbalancenum'],'send_num'=>$res['smssendednum']);
		}
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
	            $newArray [ $key ] = $this->XML2Array ( $value , true ) ;
	        }
	    }
	    return $newArray ;
	}
}