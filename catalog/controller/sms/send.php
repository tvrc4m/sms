<?php

class ControllerSmsSend extends Controller {

    protected $error=array();

	public function index(){

		$this->document->setTitle('发送短信');

		$this->data['t']=$this->session->data['t'];

        $this->data['send_action']=$this->url->link('sms/send', 't=' . $this->session->data['t']);
        $send_success=$this->url->link('sms/success', 't=' . $this->session->data['t']);

        $this->load->model('account/customer');
        $customer=$this->model_account_customer->getCustomer($this->session->data['customer_id']);

        $this->data['sms_count']=$customer['sms_count'];
        
        if ($this->request->server['REQUEST_METHOD'] == 'POST') {

            $post=$this->request->post;

            $this->validate($post);

            if(!empty($this->error)){
                exit(json_encode(array('ret'=>-1,'errors'=>$this->error)));
            }

            $message=$post['message'];

            if(!empty($post['sign'])){
                $message.=' 【'.$post['sign'].'】';
            }

            $this->load->model('sms/sp1086');

            $phones=array_filter(array_unique(preg_split('/[\n\r]/', $post['phones'])));
            $aviables=array();
            foreach ($phones as $phone) {
                if(preg_match('/^\d{11}$/', $phone)){
                    $aviables[]=$phone;
                }
            }
            
            $customer_id=$this->session->data['customer_id'];

            $timer=$this->request->post['datetime'];

            $is_timer=$this->request->post['is_timer'];
            
            if($is_timer==1){
                $timer=strtotime($timer);
            }else{
                $is_timer=0;
            }

            $message_len=mb_strlen($message,'UTF8');
            
            $multiple=1;

            if($message_len<=70){

                $multiple=1;
            }else{
                $multiple=1+ceil(($message_len-70)/65);
            }

            $this->load->model('interface/interface');

            $default_interface=$this->model_interface_interface->getDefaultInterface();

            if(empty($default_interface)){
                $status=1;
            }else{
                $status=1;
                // $interface=$default_interface['name'];
                // $this->load->model("sms/{$interface}");
                // $action="model_sms_{$interface}";
                // $status=$this->{$action}->sendSms($aviables,$message);
            }

            if($status){

                $this->load->model('sms/outbox');
                $this->model_sms_outbox->insertOutbox($customer_id,$aviables,$message,$timer,$is_timer,array(),array(),$multiple);

                $phone_count=count($aviables);

                $customer=$this->model_account_customer->updateCustomerSmsCount($this->session->data['customer_id'],$phone_count*$multiple);

                $customer=$this->model_account_customer->getCustomer($this->session->data['customer_id']);

                $this->data['sms_count']=$sms_count=$customer['sms_count'];

                exit(json_encode(array('ret'=>1,'message'=>"你的短信已经发送,共发送".$phone_count."条,目前您的帐户的条数还有".$sms_count."条")));
            }

            exit(json_encode(array('ret'=>-1)));
        }

        if (!empty($this->error['error_message'])) {
            $this->data['error_message'] = $this->error['error_message'];
        } else {
            $this->data['error_message']='';
        }

        if (!empty($this->error['error_phone'])) {
            $this->data['error_phone'] = $this->error['error_phone'];
        } else {
            $this->data['error_phone']='';
        }

        if (!empty($this->error['error_timer'])) {
            $this->data['error_timer'] = $this->error['error_timer'];
        } else {
            $this->data['error_timer']='';
        }

        if (isset($this->request->post['message'])) {
            $this->data['message'] = $this->request->post['message'];
        } else {
            $this->data['message']='';
        }

        if (isset($this->request->post['datetime'])) {
            $this->data['datetime'] = $this->request->post['datetime'];
        } else {
            $this->data['datetime']='';
        }

        if (isset($this->request->post['is_timer'])) {
            $this->data['is_timer'] = $this->request->post['is_timer'];
        } else {
            $this->data['is_timer']='';
        }

        if (isset($this->request->post['phones'])) {
            $this->data['phones'] = $this->request->post['phones'];
        } else {
            $this->data['phones']='';
        }
// echo $this->data['phones'];exit();
		$this->children = array(
            'common/header',
            'common/footer'
        );

        $this->template = 'sms/send.tpl';
       	
        $this->response->setOutput($this->render());
	}

    private function validate($post){
        if(empty($post['message'])){
            $this->error['error_message']="短信内容不能为空!";
        }
        if(empty($post['phones'])){
            $this->error['error_phone']="发送手机号不能为空!";
        }else{
            $phones=array_filter(array_unique(preg_split('/[\n\r]/', $post['phones'])));
            $aviables=array();
            foreach ($phones as $phone) {
                if(preg_match('/^\d{11}$/', $phone)){
                    $aviables[]=$phone;
                }
            }
            if(empty($aviables)){
                $this->error['error_phone']="发送手机号不能为空!";
            }

            $message_len=mb_strlen($post['message'],'UTF8');
            
            $multiple=1;

            if($message_len<=70){

                $multiple=1;
            }else{
                $multiple=1+ceil(($message_len-70)/65);
            }

            $this->load->model('account/customer');
            $customer=$this->model_account_customer->getCustomer($this->session->data['customer_id']);
            $sms_send_total=count($aviables)*$multiple;
            if($customer['sms_count']<$sms_send_total){
                $this->error['error_phone']="剩余短信为{$customer['sms_count']},须发送{$sms_send_total}条,请先充值,谢谢!";
            }
        }
        

        $timer=$this->request->post['datetime'];

        $is_timer=$this->request->post['is_timer'];
        
        if($is_timer==1){
            if(empty($timer) || strtotime($timer)<time()){
                $this->error['error_timer']='请选择未来的某一个时间';
            }
        }

        return $this->error?0:1;
    }

    private function cutstr($string, $length, $dot = '...', $charset = 'utf-8') {
        if (strlen($string) <= $length || $length <= 0)
            return $string;
        $string = str_replace(array('&nbsp;', '&amp;', '&quot;', '&#039;', '&ldquo;', '&rdquo;', '&mdash;', '&lt;', '&gt;', '&middot;', '&hellip;'), array(' ', '&', '"', "'", '“', '”', '—', '<', '>', '·', '…'), $string);
        $strcut = '';
        if (strtolower($charset) == 'utf-8') {
            $n = $tn = $noc = 0;
            while ($n < strlen($string)) {
                $t = ord($string[$n]);
                if ($t == 9 || $t == 10 || (32 <= $t && $t <= 126)) {
                    $tn = 1;
                    $n++;
                    $noc++;
                } else if (194 <= $t && $t <= 223) {
                    $tn = 2;
                    $n += 2;
                    $noc += 2;
                } else if (224 <= $t && $t < 239) {
                    $tn = 3;
                    $n += 3;
                    $noc += 2;
                } else if (240 <= $t && $t <= 247) {
                    $tn = 4;
                    $n += 4;
                    $noc += 2;
                } else if (248 <= $t && $t <= 251) {
                    $tn = 5;
                    $n += 5;
                    $noc += 2;
                } else if ($t == 252 || $t == 253) {
                    $tn = 6;
                    $n += 6;
                    $noc += 2;
                } else {
                    $n++;
                }
                if ($noc >= $length)
                    break;
            }
            if ($noc > $length)
                $n -= $tn;
            $strcut = substr($string, 0, $n);
        } else {
            for ($i = 0; $i < $length - strlen($dot) - 1; $i++)
                $strcut .= ord($string[$i]) > 127 ? $string[$i] . $string[++$i] : $string[$i];
        }
        $strcut = str_replace(array('&', '"', '<', '>'), array('&', '"', '&lt;', '&gt;'), $strcut);
        return $strcut . $dot;
    } 
}