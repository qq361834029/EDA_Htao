<?php

/**
 * 产品派送方式管理
 * @copyright   Copyright (c) 2006 - 2013 TOP UNION 展联软件友拓通
 * @category   	派送管理
 * @package  	Model
 * @author    	jph
 * @version 	2.1,2014-03-01
*/

class GlsPrinterNamePublicModel extends RelationCommonModel {
	
	/// 定义真实表名
	protected $tableName = 'gls_printer_name';
	
	/// 定义表关联
	protected $_link	 = array();	
	/// 自动验证设置
	protected $_validate	 =	 array(
			array("mac_address",'require','require',1),
			array("mac_address",'','unique',1,'unique'),
			array("printer_name",'require','require',1),
			array("printer_name",'',"unique",1,'unique'),//验证唯一
		);

	/**
	 * 所有派送方式列表SQL
	 *
	 * @return  array
	 */
	public function indexSql(){
		if (isset($_REQUEST['_sort'])) {
			$order	= $_REQUEST['_sort']!=1?' ' . $_REQUEST['_order'] . ' desc':' ' . $_REQUEST['_order'];
		} else {
			$order	= ' mac_address desc';
		}
		$count 	= $this->where(getWhere($_POST))->count();
		$this->setPage($count);
		$ids	= $this->field('id')->where(getWhere($_POST))->order($order)->page()->selectIds();
		
		$info['from'] 	= ' gls_printer_name ';
		$info['group'] 	= ' order by '.$order;
		$info['where'] 	= ' where id in'.$ids;
		$info['field'] 	= '*';
		return  'select '.$info['field'].' from '.$info['from'].$info['where'].$info['group']; 
		
	}

	public function view(){
		return $this->getInfo($this->id);
	}
	public function edit(){
		return $this->getInfo($this->id);
	}

	public function getInfo($id){
		$rs		= $this->where('id='.(int)$id)->find();
		if (false === $rs || $rs == null) { /// 记录不存在或没权限查看该记录
			halt(L('data_right_error'));
		}
		return $rs;
	}
}