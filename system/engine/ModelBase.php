<?php
abstract class ModelBase extends Model{
	protected $index;

	public function find($data,$params,$split=' '){
		$this->sphinx->init();
		$this->_setParams($params);
		$keyword=$this->_setKeyword($data);
		return $this->sphinx->Query($keyword);
	}

	/**
	*	返回一条数据信息---立即执行返回数据----单一数组
	*	@param data array|string 查询词
	*	@param params array 属性设置数组
	*	@param split string 查询词分割符
	*	@return array 返回数组
	*/
	public function get($data,$param,$split=' '){
		$result=$this->find($data,$param,$split);
		if(isset($result['value']) && !empty($result['value']))
			return $result['value'][0];
		return array();
	}
	public function add($sign,$data,$params,$split=' '){
		Coreseek::Instance()->add($sign,$data,$params,$split);
	}

	public function summary($keywords,$index='*'){

		return $this->sphinx->BuildKeywords($keywords,$index);
	}
	/**
	*	设置属性
	*	@params array 跟类字段一一对应
	*/
	private function _setParams($params){
		!isset($params['_index']) && $params['_index']=$this->index;
		$this->sphinx->setParmas($params);
	}
	/*
	*	设置查询词
	*	@param data array 查询
	*	@return string 查询词
	*	@return string 查询词
	*/
	private function _setKeyword($data){
		$keyword='';
		if(is_array($data))
			foreach($data as $k=>$v) !empty($v) && $keyword.=empty($kv)?' '.$v.' ':' '.$k.' '.$v.' ';
		else if(is_string($data)) $keyword=$data;
		return $keyword;
	}
	/**
	*	设置过虑值或范围
	*/
	private function _setFilters($filters){
		foreach($filters as $k=>$v)
			!empty($v) && $this->_filters[]['type']=$k=='values'?SPH_FILTER_VALUES:($k=='range'?SPH_FILTER_RANGE:SPH_FILTER_FLOATRANGE);
	}
}
