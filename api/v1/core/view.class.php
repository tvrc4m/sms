<?php

/**
*视图层
*/
class View{
	
	public static $_instance=null;
	
	protected $view=null;

	protected $title;

	protected $keyword;

	protected $description;
	
	public function __construct(){
		$this->init();
	}
	
	/**
	*	单例模式
	*/
	public static function Instance(){
		if(self::$_instance==null){
			$c=get_called_class();
			self::$_instance=new $c;
		}
		return self::$_instance;
	}
	/**
	*	初始化smarty类
	*/
	private function init(){
		
		//检测登录cookie
		// P('CheckLogin');
	}

	/**
	*	安全性过滤
	*/
	private function stripslashes_array(&$array) {
		while(list($key,$var) = each($array)) {
			if ($key != 'argc' && $key != 'argv' && (strtoupper($key) != $key || ''.intval($key) == "$key")) {
				is_string($var) && $array[$key] = stripslashes($var);
				is_array($var) && $array[$key] = stripslashes_array($var);
			}
		}
		return $array;
	}
	/**
	**	向页面赋值
	*/
	public function assign($array){
		foreach($array as $k=>$v){
			$this->view->assign($k,$v);
		}
	}

	/**
	*	显示页面
	*/
	public function display($tpl,$cache_id=null,$compile_id=null,$suffix='.tpl'){
		
		$this->assign(array('pageTitle'=>$this->title,'pageKeyword'=>$this->keyword,'pageDescription'=>$this->description));

		$this->view->display($tpl.$suffix,$cache_id,$compile_id);
	}

	/**
	*	获取页面内容
	*/

	public function fetch($tpl,$cache_id=null,$compile_id=null,$suffix='.tpl'){
		
		return $this->view->fetch($tpl.$suffix,$cache_id,$compile_id);
	}
}