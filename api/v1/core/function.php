<?php

/*
*   跳转
*/
function go($url){
    header('Location: ' . $url);
    exit();
}

// URL重定向
function redirect($url, $time=0, $msg='') {
    //多行URL地址支持
    $url = str_replace(array("\n", "\r"), '', $url);
    if (empty($msg))
        $msg = "系统将在{$time}秒之后自动跳转到{$url}！";
    if (!headers_sent()) {
        // redirect
        if (0 === $time) {
            header('Location: ' . $url);
        } else {
            header("refresh:{$time};url={$url}");
            echo($msg);
        }
        exit();
    } else {
        $str = "<meta http-equiv='Refresh' content='{$time};URL={$url}'>";
        $time != 0 && $str .= $msg;
        exit($str);
    }
}
function ajaxFinish($msg){
    header("Location:/tip?msg={$msg}");
    exit();
}
function _404(){

    exit();
}

function _tip($message){

    exit();
}

/**
*	重定向到指定的action方法
*/
function redirectAction($action,$method){
	$instance=A($action);
	if(method_exists($instance,$method))
		$instance->$method();
	else
		exit('不存在控制器方法');
}

/**
 * 获取客户端IP
 * @return string 获取的IP地址
 */
function getip() {
    if (!empty($_SERVER["HTTP_CLIENT_IP"]))
        $ip = $_SERVER["HTTP_CLIENT_IP"];
    else if (!empty($_SERVER["HTTP_X_FORWARDED_FOR"]))
        $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
    else if (!empty($_SERVER["REMOTE_ADDR"]))
        $ip = $_SERVER["REMOTE_ADDR"];
    else
        $ip = '';
    preg_match("/[\d\.]{7,15}/", $ip, $ips);
    $ip = isset($ips[0]) ? $ips[0] : 'Unknown';
    unset($ips);
    return $ip;
}

/**
 * 多级对象转数组
 * @param obj $object 待转换的对象
 * @return array
 */
function obj2array($object = NULL) {
    $array = (array) $object;
    foreach ($array as $key => $val) {
        //判断是否为对象或数组，因为数组中可能还会存在对象
        if (is_object($val) || is_array($val)) {
            $val = obj2array($val);
        }
        $array[$key] = $val;
    }
    return $array;
}

/**
 * HTML转文本简化,只替换style,frame,script,br
 * @param string $str 需要替换的字符
 * @return string
 */
function html2text($str) {
    $str = preg_replace("/<sty(.*)\\/style>|<scr(.*)\\/script>|<scr(.*)\\/script>|<!--(.*)-->/isU", '', $str);
    return strip_tags(str_replace(array('<br />', '<br>', '<br/>'), "\n", $str));
}

/**
 * 中文字符截取
 * @param string $string 截取的字符数据
 * @param int $length 截取的字符长度
 * @param string $dot 截取后的字符加上的字符，默认为...
 * @param string $charset 字符编码，默认为utf-8
 * @return string 截取后的数据
 */
function cutstr($string, $length, $dot = '...', $charset = 'utf-8') {
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
/*
*判断是否为utf8编码
*/
function is_utf8($word)
{
    if (preg_match("/^([".chr(228)."-".chr(233)."]{1}[".chr(128)."-".chr(191)."]{1}[".chr(128)."-".chr(191)."]{1}){1}/",$word) == true || preg_match("/([".chr(228)."-".chr(233)."]{1}[".chr(128)."-".chr(191)."]{1}[".chr(128)."-".chr(191)."]{1}){1}$/",$word) == true || preg_match("/([".chr(228)."-".chr(233)."]{1}[".chr(128)."-".chr(191)."]{1}[".chr(128)."-".chr(191)."]{1}){2,}/",$word) == true){
        return true;
    }else{
        return false;
    }
}

function encrypt($plain_text,$key=COOKIE_ENCRYPT_KEY){
    $plain_text = trim($plain_text);  
    $iv = substr(md5($key), 0,mcrypt_get_iv_size (MCRYPT_CAST_256,MCRYPT_MODE_CFB));  
    $c_t = mcrypt_cfb (MCRYPT_CAST_256, $key, $plain_text, MCRYPT_ENCRYPT, $iv);  
    return trim(chop(base64_encode($c_t)));  
}

function decrypt($c_t,$key=COOKIE_ENCRYPT_KEY){  
    $c_t = trim(chop(base64_decode($c_t)));  
    $iv = substr(md5($key), 0,mcrypt_get_iv_size (MCRYPT_CAST_256,MCRYPT_MODE_CFB));  
    $p_t = mcrypt_cfb (MCRYPT_CAST_256, $key, $c_t, MCRYPT_DECRYPT, $iv);  
    return trim(chop($p_t));  
}
/*
* 分页方法
*  @param total 总页数
*  @param page 当前页数
*  return array
*/
function page($total,$page,$limit=40){

        $pagetotal=$total%$limit!=0?intval($total/$limit)+1:intval($total/$limit);
        
        if($page>$pagetotal || $pagetotal==1) return array();

        $urlpage=array();

        $pagerange=$page<=5?($pagetotal>=7?range(1, 7):range(1,$pagetotal)):($pagetotal>=$page+3?range($page-3, $page+3):range($page-4, $pagetotal));

        $requesturl=$_SERVER['REQUEST_URI'];

        if(strpos($requesturl,'?')!==false){

            $querystring=substr($requesturl, strpos($requesturl,'?'));

            $newurl=preg_replace('/page=\d+&?/','',$requesturl);

            $url='http://'.$_SERVER['HTTP_HOST'].$newurl;

            if(substr($url,-1,1)=='?' || substr($url,-1,1)=='&'){

                foreach ($pagerange as $p) {

                    $urlpage['pages'][]=$p==1?array('page'=>$p,'pageurl'=>substr($url,0,-1)):array('page'=>$p,'pageurl'=>$url.'page='.$p);

                }

                $pagetotal!=$page && $urlpage['next']=$url.'page='.($page+1);

                $page!=1 && $urlpage['first']=substr($url,0,-1);

                $page>1 && $urlpage['prev']=$url.'page='.($page-1);

            }else{

                foreach ($pagerange as $p) {

                    $urlpage['pages'][]=$p==1?array('page'=>$p,'pageurl'=>$url):array('page'=>$p,'pageurl'=>$url.'&page='.$p);

                }

                $pagetotal!=$page && $urlpage['next']=$url.'&page='.($page+1);

                $page!=1 && $urlpage['first']=$url;

                $page>1 && $urlpage['prev']=$url.'&page='.($page-1);

            }
            

        }else{

            $url='http://'.$_SERVER['HTTP_HOST'].$requesturl;

            foreach ($pagerange as $p) {
                    
                $urlpage['pages'][]=array('page'=>$p,'pageurl'=>$url.'?page='.$p);

            }

            $pagetotal!=$page && $urlpage['next']=$url.'?page='.($page+1);

            $page!=1 && $urlpage['first']=substr($url,0,-1);

            $page>1 && $urlpage['prev']=$url.'?page='.($page-1);

        }

        $urlpage['total']=$pagetotal;

        return $urlpage;
}

function ajaxpage($total,$page,$pagecount=40){

    $total=$total<40?1:($total/40==0?$total/40:$total/40+1);
    
    if($page>$total) return array();

    $urlpage=array();

    $pagerange=$page<=5?($total>=7?range(1, 7):range(1,$total)):($total>=$page+3?range($page-3, $page+3):range($page-4, $total));

    foreach ($pagerange as $p) {

        $urlpage['pages'][]=array('page'=>$p);

    }
    
    return $urlpage;
}
function nextPageUrl($page){

    $url='http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

    $next=$page+1;

    $nexturl=preg_replace('/page=\d+/',"page=$next",$url);

    if(strpos($url,'page=')===false){

        if(strpos($url,'?')!==false){

            if(substr($url,-1,1)!='?') $nexturl.="&page=$next";

             else $nexturl.="page=$next";

        }else{

            $nexturl.="?page=$next";

        }
    }
    return $nexturl;
}