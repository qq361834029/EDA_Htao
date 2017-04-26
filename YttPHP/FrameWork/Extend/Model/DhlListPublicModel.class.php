<?php 
/**
 * DHL 请求队列列表
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category   	基本信息
 * @package  	Model
 * @author    	jph
 * @version 	2.1,2016-05-25
 */
class DhlListPublicModel extends CommonModel {
	/// 模型名与数据表名不一致，需要指定
	protected $tableName = 'dhl_list';

	/**
	 * 列表
	 *
	 * @return array
	 */
	public function index(){
		$sql			= ACTION_NAME . 'Sql';
		$_sql			= $this->$sql();
		$_formatListKey	= ACTION_NAME . '_' . MODULE_NAME . '_' . __CLASS__ . '_' . __FUNCTION__;
		return _formatList($this->query($_sql),$_formatListKey);
	}

	public function requestListSql($default_where = '1', $order = 'last_request_time desc'){
		$where			= $default_where . ' AND ' . getWhere($_POST['main']);
		$exists			= 'SELECT 1 FROM sale_order WHERE sale_order.id = object_id AND ' . getWhere($_POST['sale_order']);
		$count			= $this->exists($exists, $_POST['sale_order'])->where($where)->count();
		$this->setPage($count);
		$ids			= $this->field('id')->exists($exists, $_POST['sale_order'])->where($where)->order($order)->page()->selectIds();
		$info['from'] 	= 'dhl_list';
		$info['where'] 	= ' where id in'.$ids;
		$info['field'] 	= 'id, request_type as express_api_request_type, object_id, object_no, shipmentNumber, Labelurl, request_status as express_api_request_status, create_time, last_request_time';
		return  'select ' . $info['field'] . ' from ' . $info['from'] . $info['where'] . ' order by ' . $order;
	}

	public function indexSql(){
		$order	= 'last_request_time asc';
		return $this->requestListSql(express_api_get_need_request_where(true), $order);
	}
		
}