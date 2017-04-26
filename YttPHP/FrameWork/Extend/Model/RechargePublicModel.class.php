<?php

/**
 * 卖家充值信息管理
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category   	银行信息
 * @package  	Model
 * @author    	jph
 * @version 	2.1,2014-06-04
*/

class RechargePublicModel extends RelationCommonModel {
	/// 模型名与数据表名不一致，需要指定
	protected $tableName = 'recharge';
	
	
	/// 表单验证
	protected $_validate	 =	 array(
		array("factory_id",'require',"require",1),
		array("currency_id",'require',"require",1),
		array("bank_id",'require',"require",1),
		array("recharge_date",'require',"require",1),
		array("money",'require',"require",1),
		array("money",'money',"money_error",1),
        array("warehouse_id",'require',"require",1),
		array('','validGallery','',1,'callbacks'), //验证是否上次图片
	);
		
	/// 自动填充
	protected $_auto = array(
		array("confirm_state", 0, 1), // 确认状态 默认待确认  0:待确认 1:已确认
		array("create_time", "date", 1, "function", "Y-m-d H:i:s"), // 创建时间
		array("update_time", "date", 2, "function", "Y-m-d H:i:s"), // 更新时间
	);	
	
	//必须上传汇款凭证
	public function validGallery(){
		if(!empty($this->id)) {
			$map['relation_id'] = $this->id;
			$map['relation_type'] = 34;
		}else{
			$map['tocken'] = $_POST['tocken'];
		}
		$isExist = M('Gallery')->where($map)->getField('id');
		if(empty($isExist)){
			$error['name']	= 'file_upload';
			$error['value']	= L('no_upload_payment');
			$this->error[]  = $error;
		}
	}
	
	//编辑充值确认
	public function editConfirm(){
		//验证
		if(!is_numeric($_POST['confirm_money'])) throw_json(L('valid_money'));
		if($_POST['confirm_money'] <= 0)  throw_json(L('confirm_money').L('not_less_than_zero'));
		if(empty($_POST['confirm_date'])) throw_json(L('require_confirm_date'));
		if(empty($_POST['confirm_currency_id'])) throw_json(L('require_currency_id'));
		if(!is_numeric($_POST['opened_y']) || $_POST['opened_y'] < 0 ) throw_json(L('valid_rate'));

		//待确认更改为已确认
		if($_POST['confirm_state'] == 0){	
			$saveData['confirm_state'] = 1;
		}
		if(!empty($_POST['confirm_comments'])) $saveData['confirm_comments'] = trim($_POST['confirm_comments']);
		$saveData['confirm_date'] = $_POST['confirm_date'];
		$saveData['confirm_currency_id'] = $_POST['confirm_currency_id'];
		$saveData['opened_y'] = $_POST['opened_y'];
		$saveData['money_to'] = $_POST['money_to'];	
		$saveData['confirm_money'] = round($_POST['confirm_money'],2);	//保留两位小数
		$result	= $this->where('id='.intval($_POST['id']))->save($saveData);   	
		if (false !== $result) {
			//待确认更改为已确认时才执行
			if($_POST['confirm_state'] == 0){	
				$_POST['confirm_state'] = 1;	//已改为已确认状态
				$this->execTags($_POST);
			}
		}
		return $result;
	}	
	
	
	//充值确认/取消
	public function confirm(){
		//确认
		if($_GET['confirm_state'] == 1){
			$saveData['confirm_state'] = 1;
			$saveData['confirm_money'] = round($_GET['money'],2);//自动填充确认金额
		}else{	//取消
			$saveData['confirm_state'] = 0;
			$saveData['confirm_date'] = null;
			$saveData['confirm_currency_id'] = null;
			$saveData['opened_y'] = 0.0000;
			$saveData['money_to'] = 0.00000000;	
			$saveData['confirm_money'] = 0.00;
			$saveData['confirm_comments'] = null;
		}
		$result	= $this->where('id='.intval($_GET['id']))->save($saveData);   	
		if (false !== $result) {
			$this->execTags($_GET);
		}
		return $result;
	}	
	
	
	/**
	 * 所有充值列表SQL
	 *
	 * @return  array
	 */
	function indexSql(){ 
		///条件
		if (getUser('role_type') == C('WAREHOUSE_ROLE_TYPE')) {
			$default_where = ' warehouse_id in (' . getUser('company_id') . ',0) ';
		} else {
			if (!empty($_POST['warehouse_id'])) {
				$default_where = ' warehouse_id in (' . $_POST['warehouse_id'] . ',0)  ';
			}
		}
		//卖家	
		if((getUser('role_type') == C('SELLER_ROLE_TYPE'))){
			if(!empty($default_where)) $default_where .= ' AND ';
			$default_where = ' factory_id='.getUser('company_id');
		}
		//默认状态为已确认
		if(empty($_POST['query']['confirm_state'])){
			$_POST['query']['confirm_state'] = 0;
			if(!empty($default_where)) $default_where .= ' AND ';
			$default_where .= 'confirm_state=0';
		}
		if(!empty($default_where)) $default_where .= ' AND ';
		$where = $default_where.getWhere($_POST);
		$count 	= $this->where($where)->count();
		$this->setPage($count);
		$ids	= $this->field('id')->where($where)->order('recharge_date desc')->page()->selectIds();
		$info['from'] 	= 'recharge r 
						   left join gallery g on r.id=g.relation_id and g.relation_type=34';
		$info['group'] 	= ' group by r.id order by r.recharge_date desc';
		$info['where'] 	= ' where r.id in'.$ids;
		$info['field'] 	= 'r.id AS id,
						   r.money,
						   r.opened_y,
						   r.money_to,
						   r.factory_id,
						   r.warehouse_id,
						   r.bank_id,
						   r.currency_id,
						   r.recharge_date,
						   r.comments,
						   r.confirm_state,
						   r.confirm_money,
						   r.confirm_currency_id,
						   r.confirm_comments,
						   g.cpation_name,
						   g.file_url';
		return  'select '.$info['field'].' from '.$info['from'].$info['where'].$info['group'];
	}
}