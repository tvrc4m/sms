<?php

//手机彩信

class ControllerSmsUpload extends Controller {

	public function txt(){

        if($_FILES['txtfile']['type']!='text/plain' && pathinfo($_FILES['txtfile']['name'],PATHINFO_EXTENSION)!='txt'){
            die(json_encode(array('status'=>-1,'error'=>'只能上传txt文件')));
        }

        $content=file_get_contents($_FILES['txtfile']['tmp_name']);

        $data=array_filter(array_unique(preg_split('/[\n\r]/', $content)));

        $total=count($data);

        $result=array();

        foreach ($data as $phone) {
            if(preg_match('/^\d{11}$/', $phone)){
                $result[]=$phone;
            }
        }

        $count=count($result);

        echo json_encode(array('status'=>1,'total'=>$total,'avaiable'=>$count,'unavaiable'=>$total-$count,'values'=>$result));
	}

    public function xml(){

    }

	
}