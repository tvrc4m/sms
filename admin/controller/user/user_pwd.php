<?php
class ControllerUserUserPwd extends Controller{
	private $error = array();
    public function sendIdentityCode(){
    	//避免反复发送
    	if(!empty($this->session->data['send_code_time'])){
    		if($this->session->data['send_code_time']+60>time()){
    			exit();
    		}
    	}
    	$this->session->data['send_code_time']=time();
    	$this->language->load('user/user_pwd');
    	if(!isset($this->request->post['phone']) || !preg_match('/^\d{8,11}$/', $this->request->post['phone'])){
    		echo json_encode(array("ret"=>-1));
    		exit();
    	}
    	$phone=$this->request->post['phone'];
	    require_once('../system/library/webChat/webChat.php');
        $webChat = new WebChat();

        $code=rand(1000,9999);

        $content=sprintf($this->language->get("content_identity_code"),$code);

        $status=$webChat->sendMsgBySms($phone,$content);

        if($status){
        	$this->load->model('user/change_password');
        	$this->model_user_change_password->insertIdentifyCode(array('user_id'=>$this->session->data['user_id'],'code'=>$code));
        }

        echo json_encode(array("ret"=>(int)$status));
    }

    public function validateCode(){
    	$this->language->load('user/user_pwd');
    	$code=$this->request->get['code'];
    	if(empty($code)){
    		echo json_encode(array('ret'=>0));
    		exit();
    	}
    	$this->load->model('user/change_password');
        $res=$this->model_user_change_password->getIdentifyCodeByUserID($this->session->data['user_id']);
        if(empty($res)){
        	echo json_encode(array('ret'=>0));
        	exit();
        }
        $ctime=$res['create_time'];
        if($ctime+1800>=time()){ //有效期内
        	if(trim($code)==$res['code']){
        		echo json_encode(array('ret'=>1));
        	}else{
        		echo json_encode(array('ret'=>-1));
        	}
        }else{
        	echo json_encode(array('ret'=>-2));
        }
    }

    public function changePassword() {
        $this->language->load('user/user_pwd');
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {

        	$this->load->model("user/user");
        	$this->load->model('user/change_password');
        	$user_id=$this->session->data['user_id'];
        	$this->model_user_user->editPassword($user_id,$this->request->post['pwd']);
        	$this->model_user_change_password->deleteIdentifyByUserID($user_id);
        	unset($_SESSION);
        	echo json_encode(array('ret'=>1,'redirect'=>$this->url->link('common/login', 'relogin=1')));
        }else{
        	echo json_encode(array('ret'=>-1,'error'=>$this->error));
        }
    }

    protected function validateForm(){

    	if (!$this->user->hasPermission('modify', 'user/user_pwd')) {
      		$this->error['warning'] = $this->language->get('error_permission');
    	}

    	if ((utf8_strlen($this->request->post['pwd']) < 6)) {
      		$this->error['pwd_error'] = $this->language->get('error_pwd');
    	}
		
		if (!isset($this->request->post['repwd']) || $this->request->post['pwd']!==$this->request->post['repwd']) {
				$this->error['repwd_error'] = $this->language->get('error_repwd');
		}
		
    	if ((utf8_strlen($this->request->post['code']) !=4)) {
			$this->load->model('user/change_password');
        	$res=$this->model_user_change_password->getIdentifyCodeByUserID($this->session->data['user_id']);
        	if($res['create_time']+1800<time() && $this->request->post['code']!=$res['code']){
        		$this->error['code_error'] = $this->language->get('error_code');
        	}
    	}
    	if (!$this->error) {
      		return true;
    	} else {
      		return false;
    	}
    }
}