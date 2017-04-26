<?php 
/**
 * CORREOS 请求队列列表
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category   	基本信息
 * @package  	Model
 * @author    	jph
 * @version 	2.1,2016-05-25
 */
class CorreosListForSellerPublicModel extends CommonModel {
	/// 模型名与数据表名不一致，需要指定
	protected $tableName = 'correos_log';

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
		$count			= M('correos_list')->alias('b')->exists($exists, $_POST['sale_order'])->where($where)->count();
		$this->setPage($count);
		$ids			= $this->field('max(a.id) as id')->join('a left join correos_list b on a.correos_list_id=b.id')->exists($exists, $_POST['sale_order'])->where($where)->group('correos_list_id')->order($order)->page()->selectIds();
		$sql = 'select a.id,correos_list_id,a.status_code,a.status_message,
				b.object_id,b.object_no,s.factory_id
				from correos_log a
				left join correos_list b on a.correos_list_id=b.id
				left join sale_order s on b.object_id=s.id
				where a.id in'.$ids;
		return $sql;
	}
}