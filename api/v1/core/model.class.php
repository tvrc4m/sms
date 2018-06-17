<?php
/*
 * 模块类
 */
abstract class Model{
    
	protected $_db=null;
	
	protected $_cache=null;

	protected static $instance=null;
	
	protected static $_instances=array();

	public function __construct(){
		//$this->_cache=MemoryCache::Instance();	
	}
	/**
	*	单例模式
	*/
	public static function Instance(){
		$c=get_called_class();
		if(isset(self::$_instances[$c])) return self::$_instances[$c];
		self::$instance=new $c();
		self::$instance->init();
		self::$_instances[$c]=self::$instance;
		return self::$instance;
	}
	/**
	*	Model子类
	*/
	public static function getStorges(){
		return array('MysqlModel'=>'mysql','MongoModel'=>'mongo','SphinxModel'=>'sphinx','RedisModel'=>'redis');
	}

	/**
	* Model静态方法调用
	* @param dir Model目录下的目录
	* @param args[0]->文件名(不带type.php),args[1]->要调用的方法,args[2]->调用方法的参数
	* @return 原方法返回值
	*/

	public static function __callStatic($cls,$args){

		$storges=self::getStorges();

		$storge=$storges[get_called_class()];

		$classname=ucfirst($cls).ucfirst($storge);

		$file=MODEL.$cls.'.model.php';
		// echo $file;exit();
		if(!is_file($file)) exit('model file not found');
		
		include_once($file);

		return call_user_func_array(array(call_user_func_array(array($classname,'Instance')),$args[0]),$args[1]);
	}
	
	abstract protected function init();
	
	/**
	*	设置缓存
	*/
	public function setcache($k,$v,$expiration=3600){
		$this->_cache->set($k,$v,$expiratio);
	}
	
	/**
	*	读取缓存
	*/
	public function getcache($k){
		return $this->_cache->get($k);
	}
	
}
/**
*	MYSQL模块类
*/
class MysqlModel extends Model{

	protected $prefix='lt_';
	
	protected $table='';

	public function __construct(){
		$this->init();
	}
	
	protected function init(){
		$this->_db=new DBMysql();
		$this->_db->connect();
		$this->_db->table=$this->table;
	}

	public function find($params){
		return $this->_db->find($params);
	}
	
	public function query($params){
		return $this->_db->query($params);
	}
	
	public function get($params){
		return $this->_db->get($params);
	}
	
	public function count($params){
		return $this->_db->count($params);
	}

	public function lastID(){
		
		return $this->_db->lastID();
	}
}
/**
*	MONGO模块类
*/
class MongoModel extends Model{
	
	protected $table='';
	
	protected function init(){
		$this->_db=DBMongo::Instance();
	}
	
	public function find($params){
		$this->_setTable($params);
		return $this->_db->find($params);
	}
	
	public function get($params){
		$this->_setTable($params);
		return $this->_db->get($params);
	}
	
	public function query($params){
		$this->_setTable($params);
		return $this->_db->query($params);
	}

	public function count($params){
		$this->_setTable($params);
		return $this->_db->count($params);
	}

	public function removeNull($where,$field){

		$params=array('update'=>$where,'_set'=>array('$pullAll'=>array($field=>array(null))));
		
		return $this->query($params);
	}

	public function extradata($id,$field,$data,$count,$tongji,$otherSetDate=array()){

		$ret=$this->get(array('findOne'=>array('_id'=>$id),'fields'=>array("{$field}"=>1)));
		
		$total=count($ret[$field]);

		$setData=array_merge(array('$push'=>array("{$field}"=>$data),'$inc'=>array("{$tongji}"=>1)),$otherSetDate);

		$addparams=array('update'=>array('_id'=>$id),'_set'=>$setData,'_options'=>array('upsert'=>1));	
		
		if($total<$count){

			return $this->query($addparams);	#直接添加

		}else{

			$setData=array_merge(array('$pop'=>array("{$field}"=>-1)),$otherSetDate);#删除头部的数据

			$params=array('update'=>array('_id'=>$id),'_set'=>$setData);

			$this->query($params);

			return $this->query($addparams);
		}
	}
	/**
	*	设置table名
	*/
	protected function _setTable(&$params){	
		if($this->table && !isset($params['_table'])){
			$params['_table']=$this->table;
		}
	}
	
}