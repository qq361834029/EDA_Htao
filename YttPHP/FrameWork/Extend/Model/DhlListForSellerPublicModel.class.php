<?php 
/**
 * DHL 请求队列列表
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category   	基本信息
 * @package  	Model
 * @author    	jph
 * @version 	2.1,2016-05-25
 */
class DhlListForSellerPublicModel extends CommonModel {
	/// 模型名与数据表名不一致，需要指定
	protected $tableName = 'dhl_log_detail';

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

	public function indexSql($default_where = 'b.request_status in("Failed","Abnormal") ', $order = 'last_request_time desc'){
		$where			= $default_where . ' AND ' . getWhere($_POST['main']);
		$exists			= 'SELECT 1 FROM sale_order s WHERE s.id = object_id AND ' . getWhere($_POST['sale_order']);
		$count			= M('dhl_list')->alias('b')->exists($exists, $_POST['sale_order'])->where($where)->count();
		$this->setPage($count);
		$ids			= $this->field('max(a.id) as id')->join('a left join dhl_list b on a.dhl_list_id=b.id')->exists($exists, $_POST['sale_order'])->where($where)->group('dhl_list_id')->order($order)->page()->selectIds();
		$sql = 'select a.id,dhl_list_id,dhl_log_id,c.status_code,c.status_message,a.status_code as deal_status_code,a.status_message as deal_status_message,
			b.object_id,b.object_no,s.factory_id
			from dhl_log_detail a
			left join dhl_list b on a.dhl_list_id=b.id
			left join dhl_log c on a.dhl_log_id=c.id
			left join sale_order s on b.object_id=s.id
			where a.id in'.$ids;
		return $sql;
	}
}