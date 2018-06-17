<?php
/**
 * Created by JetBrains PhpStorm.
 * User: rocket
 * Date: 13-3-22
 * Time: 下午2:31
 * To change this template use File | Settings | File Templates.
 */
function ifecho(&$v, $out = null,$elseout="") {
    if ($out !== null) {
        echo isset ( $v )&&strlen($v)>0 ? $out : $elseout;
    } else {
        echo isset ( $v )&&strlen($v)>0 ? $v : "";
    }
}

//optimize for Load Blance structor @tom.han>>
if(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
    define('REMOTE_CLIENT_IP','HTTP_X_FORWARDED_FOR');
}else{
    define('REMOTE_CLIENT_IP','REMOTE_ADDR');
} //<< @tom.han

function ifecho3($v, $out="",$elseout="") {
    echo $v? $out : $elseout;
}

function unzip($zipfile_path, $extract_path) {
    $zip = new ZipArchive ();
    $res = $zip->open ( $zipfile_path);
    if ($res === TRUE) {
        $zip->extractTo ($extract_path );
        $zip->close ();
        return false;
    } else {
        return false;
    }
}

function isHTTPS() {
    if (isset ( $_SERVER ['HTTPS'] )) {
        if ($_SERVER ['HTTPS'] === 1) { //Apache
            return true;
        } else if (strtolower($_SERVER ['HTTPS']) === 'on') { //IIS
            return true;
        }else if($_SERVER['SERVER_PORT'] == 443){ //其他
            return true;
        }
    }
    if(isset($_SERVER['HTTP_X_FORWARDED_PROTO'])) {
        if(strtolower($_SERVER['HTTP_X_FORWARDED_PROTO']) === 'https'){
            return true;
        }
    }
    return false;
}

function SpHtml2Text($str)
{
    $str = preg_replace("/<sty(.*)\\/style>|<scr(.*)\\/script>|<!--(.*)-->/isU","",$str);
    $alltext = "";
    $start = 1;
    for($i=0;$i<strlen($str);$i++)
    {
        if($start==0 && $str[$i]==">")
        {
            $start = 1;
        }
        else if($start==1)
        {
            if($str[$i]=="<")
            {
                $start = 0;
                $alltext .= " ";
            }
            else if(ord($str[$i])>31)
            {
                $alltext .= $str[$i];
            }
        }
    }
    $alltext = str_replace("　"," ",$alltext);
    $alltext = preg_replace("/&([^;&]*)(;|&)/","",$alltext);
    $alltext = preg_replace("/[ ]+/s"," ",$alltext);
    return $alltext;
}

/***
 * $arr = array(
‘d’ => array(‘id’ => 5, ‘name’ => 1, ‘age’ => 7),
‘b’ => array(‘id’ => 2,’name’ => 3,’age’ => 4),
‘a’ => array(‘id’ => 8,’name’ => 10,’age’ => 5),
‘c’ => array(‘id’ => 1,’name’ => 2,’age’ => 2)
);print_r(multi_array_sort($arr,’age’));
 * @param $multi_array
 * @param $sort_key
 * @param int $sort
 * @return array|bool
 */
function multi_array_sort($multi_array,$sort_key,$sort=SORT_ASC){
    if(is_array($multi_array)){
        foreach ($multi_array as $row_array){
            if(is_array($row_array)){
                $key_array[] = $row_array[$sort_key];
            }else{
                return false;
            }
        }
    }else{
        return false;
    }
    array_multisort($key_array,$sort,$multi_array);
    return $multi_array;
}

/**
 * @param null $arr
 * @param $url
 * @return mixed|null
 *
 */
function httpRequest($text){

    // $url = "https://maps.googleapis.com/maps/api/place/textsearch/json?query=" . $text . "&key=AIzaSyAzGN1-Nmt5TJNDbGNDtb7SCEjRe2iK_5w&sensor=false";

    $options = array(
        CURLOPT_URL => $url,
        CURLOPT_HEADER => 0,
        CURLOPT_RETURNTRANSFER => 1,
    );

    global $log;

    $log->write('REQ:' . var_export($options, true));

    $ch = curl_init();
    curl_setopt_array($ch, $options);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

//    curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,true); ;
//    curl_setopt($ch,CURLOPT_CAINFO,DIR_SYSTEM . 'certificate/cacert.pem');

    $result = curl_exec($ch);
    curl_close($ch);

    $log->write('REP:' . var_export($result, true));
    $result = json_decode($result);
    return $result;
}

function checkEmailAddress($mailAddress){
    $res = array();
    $res['validity'] = 'false';
    if(preg_match("/^[\w_]+@[\w]+(\.[\w]+){1,3}$/i",$mailAddress) > 0){
        return true;
    }else{
        return false;
    }
}

function getTimeList() {
    $time_list = array();
    for ($i = 0; $i < 24; $i++) {
        $time_list[] = str_pad($i, 2, '0', STR_PAD_LEFT) . ':00';
        $time_list[] = str_pad($i, 2, '0', STR_PAD_LEFT) . ':30';
    }
    return $time_list;
}

function Array2String($Array)
{
    $Return='';
    $NullValue="^^^";
    foreach ($Array as $Key => $Value) {
        if(is_array($Value))
            $ReturnValue='^^array^'.Array2String($Value);
        else
            $ReturnValue=(strlen($Value)>0)?$Value:$NullValue;
        $Return.=urlencode(base64_encode($Key)) . '|' . urlencode(base64_encode($ReturnValue)).'||';
    }
    return urlencode(substr($Return,0,-2));
}

// convert a string generated with Array2String() back to the original (multidimensional) array
// usage: array String2Array ( string String)
function String2Array($String)
{
    $Return=array();
    $String=urldecode($String);
    $TempArray=explode('||',$String);
    $NullValue=urlencode(base64_encode("^^^"));
    foreach ($TempArray as $TempValue) {
        list($Key,$Value)=explode('|',$TempValue);
        $DecodedKey=base64_decode(urldecode($Key));
        if($Value!=$NullValue) {
            $ReturnValue=base64_decode(urldecode($Value));
            if(substr($ReturnValue,0,8)=='^^array^')
                $ReturnValue=String2Array(substr($ReturnValue,8));
            $Return[$DecodedKey]=$ReturnValue;
        }
        else
            $Return[$DecodedKey]=NULL;
    }
    return $Return;
}

function trimSeoStr($String)
{
    //trim special codes from the beginning and ending
    $String = trim($String);

    //preg replace not numbers or alphabets
    $replaceArr = array("&"," ","/","@","amp;",".");
    $String = str_replace($replaceArr,'-',$String);
    $String = str_replace('---','-',$String);
    $String = str_replace('--','-',$String);
    $String = str_replace('--','-',$String);
    $String = strtolower($String);
//    $String = preg_grep("/^([a-z][A-Z][0-9])+/","/-/",$String);
    return $String;
}
