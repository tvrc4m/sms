<?php
/*
*数据库抽象类---定义数据库基本功能
*数据库基类应该实现为单例模式
*/
abstract class DB{
	
	public static $_instance=null;
	
	private $_link=null;
	
	protected $prefix='lt_';
	
	/*
	*私有构造函数---不允许NEW对象
	*/
	public function __construct(){
		
	}
	/**
	*	单例模式
	*/
	public static function Instance(){
		if(self::$_instance==null){
			$c=get_called_class();
			self::$_instance=new $c();
			self::$_instance->connect();
		}
		return self::$_instance;
	}
	
	abstract protected function connect($connectstring=null);
	
	
	public function __destruct(){
		self::$_instance=null;
		$this->_link=null;
	}
}

class DBMysql extends DB{

	public $table;
	
	protected $_select='*';
	protected $_where;	
	protected $_order;
	protected $_group;
	protected $_having;
	protected $_join;
	
	protected $_limit;
	protected $_insert;
	protected $_value;
	protected $_update;
	protected $_set;
	
	protected $_delete;
	
	protected $sqlType=array('select','update','delete','insert');
	
	/*
	*连接
	*/
	public  function connect($connectstring=null){
		$this->_link=mysql_pconnect(DB_HOST,DB_USER,DB_PASSWD);
		if(!mysql_ping($this->_link)){
			mysql_close($this->_link);
			$this->_link=mysql_pconnect(DB_HOST,DB_USER,DB_PASSWD);
		}
		mysql_select_db(DB_NAME,$this->_link);
		mysql_set_charset(DB_CHARSET,$this->_link);
	}
	/*
	*	重新初始化选项
	*/
	protected function init(){
		$this->_select='*';
		$this->_table=$this->_where=$this->_order=$this->_group=$this->_join=$this->_update=$this->_set=$this->_delete=$this->_insert=$this->_limit=$this->_value=$this->_having='';
	}
	/**
	* 	查询
	*/
	public function find($params){
		$result=$this->_query($params);
		$rows=array();
		while($row=mysql_fetch_assoc($result)){
			$rows[]=$row;
		}
		mysql_free_result($result);
		return $rows;
	}
	/*
	*	获取单行
	*/
	public function get($params){
		$result=$this->query($params);
		$row=mysql_fetch_assoc($result);
		mysql_free_result($result);
		return $row;
	}
	/*
	*	获取总的个数
	*/
	public function count($params){
		$result=$this->query($params);
		$row=mysql_fetch_array($result,MYSQL_NUM);
		mysql_free_result($result);
		return $row[0];
	}

	public function escape($value){

		return mysql_real_escape_string($value,$this->_link);
	}

	public function lastID(){

		return mysql_insert_id($this->_link);
	}
	/**
	*	更新|插入|删除
	*/
	public function query($params){
		if(is_array($params)) return $this->_query($this->_sql($params));
		else if(is_string($params)) return $this->_query($params);
		return mysql_affected_rows($this->_link);
	}
	/**
	*	构造查询
	*/
	private function _query($sql){
		if(!$this->_link){
			$this->connect();
		}
		$query=mysql_query($sql,$this->_link);
		// echo $sql.'<br />';
		if(!$query){
            echo $sql.'<br />';
			print_r(mysql_error($this->_link));
			exit('数据执行有错');
		}
		return $query;
	}
	/**
	*	初始化选项
	*/
	private function _set($params){
		$this->init();
		foreach($params as $key=>$value){
			if(!property_exists($this,$key))
				exit('不存在此属性，可能有待添加');
			$this->$key=$value;
		}
	}

	// 拼接values部分
	protected function set($sets){
		foreach($sets as $field=>&$value){
			$value="`{$field}`='".$this->escape($value)."'";
		}
		return implode(',',$sets);
	}

	// 拼接where部分
	protected function where($where,$split=' AND '){
		if(!is_array($where)) return $where;
		foreach($where as $field=>&$value){
			$value="`{$field}`='{$value}'";
		}
		return implode($split,$where);
	}
	/*
	*	构造SQL语句
	*/
	private function _sql($params){
		$this->_set($params);
		$sql='';
		if($this->_insert){
			$sql='INSERT INTO '.$this->prefix.$this->table.' SET '.$this->set($this->_value);
		}else if($this->_update){
			$sql='UPDATE '.$this->prefix.$this->table.' SET '.$this->set($this->_set);
		}else if($this->_delete){
			$sql='DELETE FROM '.$this->prefix.$this->table;
		}else{
			$sql='SELECT '.$this->_select.' FROM '.$this->prefix.$this->table;
		}
		if(!empty($this->_where))
			$sql.=' WHERE '.$this->where($this->_where);
		if(!empty($this->_order))
			$sql.=' ORDER BY '.$this->_order;
		if(!empty($this->_group))
			$sql.=' GROUP BY '.$this->_group;
		if(!empty($this->_limit)){
			$sql.=' LIMIT '.$this->_limit;
		}
		return $sql;
	}
}