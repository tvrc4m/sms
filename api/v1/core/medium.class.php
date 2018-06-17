<?php
/****	中间件类	***/

abstract class Medium{

	public function __construct(){

	}

	/**
	*	调用Medium静态方法
	*	@param dir Medium下的第一层文件夹名--小写
	*	@param args array args[0]->文件名(无后缀) args[1]->run具体方法参数数组
	*   @return run方法的结果值
	*/

	public static function __callStatic($cls,$args){
		
		$classname=ucfirst($cls);

		$file=MEDIUM.$cls.'.php';
		
		if(!is_file($file)) exit('medium file not found');
		
		include_once($file);

		$cls=new $classname;
		
		return $cls->run($args[0],$args[1]);
	}

	/**
	*	Medium子类的标准入口方法
	*	@param data 参数数组 
	*/
	abstract public function run($action,$data);
}