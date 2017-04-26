<?php 
/**
 * 款项抽象类
 * @copyright   Copyright (c) 2006 - 2013 TOP UNION 展联软件友拓通
 * @category   	账目信息
 * @package  	Action
 * @author    	何剑波
 * @version 	2.1,2013-08-06
 */

class AbsFundsPublicModel extends RelationCommonModel {
	/// 关联ID
	protected $relation_id		= 0;
	/// 关联类型值
	protected $relation_type	= 0;
	/// 模块名称
	protected $module_name		= null; 
	/// 规格配置字段
	protected $storge_field		= array();
	/// 库存表名
	protected $trueTableName 	= 'paid_detail';
	///列表查询的表的名字
	public $indexTableName		= ''; 
	///列表查询的表的合计distinct对应的值
	public $indexCountPk		= 'paid_id'; 
	///对象类型
	public $comp_type			= ''; 
	  					
	/**
	 * 列表方法
	 */
	
	/**
	 * 列表
	 *
	 * @return unknown
	 */
	public function indexSql(){ 
		$info['field']	=	' * '.$this->fundsField();
		$info['from']	=	$this->indexTableName?$this->indexTableName:$this->tableName;
		$info['extend']	=	' WHERE  '._search().$this->fundsWhere().' order by paid_date desc';
		$sql	= 'select '.$info['field'].' from '.$info['from'].' '.$info['extend']; 
		$count	=	0;
		$sql_count	= 'select count(distinct('.$this->indexCountPk.')) as count '.' from '.$info['from'].' where '._search().$this->fundsWhere();
		$list	=	$this->query($sql_count);
		$count	=	$list[0]['count'];
		$info['sql']	=	$sql;
		$info['count']	=	$count;
		return $info;
	}  
	
	/**
	 * 默认的where条件
	 *
	 * @return string
	 */
	public function fundsWhere(){
		isset($this->object_type)	&&	$where[]	=	' object_type='.$this->object_type;
		if (is_array($where)){
			$str	=	' and '.join(' and ',$where);
		} 
		return $str;
	}

	/**
	 * 默认的where条件
	 *
	 * @return string
	 */
	public function fundsField(){
		switch ($this->comp_type){
			case 1:
				$field	=	' , comp_id as factory_id ';
				break;
			case 2:
				$field	=	' , comp_id as logistics_id ';
				break;
			case 3:
				$field	=	' , comp_id as express_id ';
                break;
            case 4:
				$field	=	' , comp_id as warehouse_id ';
				break;			
		} 
		if (in_array($this->comp_type,array(1,2,3,4)) && $this->indexTableName!=''){
			$field	.=	' ,paid_id as id, quantity*price as owed_money ';	
		} 
		return $field;
	}
	
	/**
	 * 获取列表
	 *
	 * @return array
	 */
	public function index(){
		$sql			= ACTION_NAME.'Sql';
		$_sql			= $this->$sql();
		if (!empty($_sql['count'])){
			$_limit			= _page($_sql['count']);	
		}
		return $list	= $this->indexList($_limit,$_sql['sql']);
	}

	/**
	 * 根据SQL语句获取数据
	 *
	 * @param array $limit
	 * @param string $sql
	 * @return array
	 */
	function indexList($limit,$sql){ 
		return	_formatList($this->db->query($sql._limit($limit)));    
	}
	
							
	/**
	 * 初始化与调用规则
	 */ 
	 
	/**
	 * 默认匹配相对应的数据
	 *
	 * @param array $info
	 */
	public function _beforeFund(&$info){ 
		isset($this->object_type)	&&	$info['object_type']	=	$this->object_type;
		isset($this->comp_type)		&&	$info['comp_type']		=	$this->comp_type; 
	} 
	
	/**
	 * 外部调用更新款项
	 *
	 * @param int or array $info 参数
	 * @param int or array $action 动作
	 * @return bool
	 */
	 public function paidDetail($info,$action=null) {
		$function	=	empty($action)?'_fund':$action;
		/// 执行前置操作 
	 	if (method_exists($this,'_before'.ucfirst($function))) { 
	 		call_user_func(array($this,'_before'.ucfirst($function)));
	 	}  
	 	$info	=	$this->$function($info); 
	 	/// 执行后置操作
	 	if (method_exists($this,'_after'.ucfirst($function))) {
	 		call_user_func(array($this,'_after'.ucfirst($function)));
	 	}
	 	return $info;
	 }
	  
	 /**
	  * 保存款项信息
	  *
	  * @param array $info
	  * @return array
	  */
	 public function _saveFunds($info){  
	 	if ($info['id']>0 && isset($info['id'])){
			return $this->_updateFunds($info);
		}else{    
			///如果原币种不存在默认给予 currency_id 的值 ,转账支付需要从新记录下转换之前的币种
			if($info['paid_type']==3 && $info['bank_id']>0) {
				$bank_currency				=	S('bank_currency'); 
				if (!isset($info['currency_id'])) {
					$info['currency_id']	=	$bank_currency[$info['bank_id']]['currency_id'];
				}
	 			$info['befor_currency_id']	=	$bank_currency[$info['bank_id']]['currency_id'];
			}else{
				if (empty($info['befor_currency_id']) || $info['befor_currency_id']<=0 || !isset($info['befor_currency_id'])){
					$info['befor_currency_id']	=	$info['currency_id'];
				}
			}    
			$info['comp_name']	= $this->getCompName($info); 
			$paid_id = $this->_insertFunds($info);  
			///插入支票OR转账
			if(in_array($info['paid_type'],array(2,3))) { 
		 		$info['paid_id']			=	$paid_id; 
		 		$info['paid_object_type']	=	$info['object_type']; 
		 		///银行转入转出与实际币种上得不同重新计算银行转入转出的金额
		 		if ($info['paid_type']==3) {
		 			unset($info['currency_id']); 
		 		}else{
		 			$info['currency_id']=$info['befor_currency_id'];
		 		}
		 		if ($info['befor_rate']) {
		 				$info['money']	=	$info['money']/$info['befor_rate'];
		 		}
				BankCenter($info,4);
			} 
			return $paid_id;
		} 
	 }
	 
	 /**
	  * 删除款项
	  *
	  * @param array $info
	  * @return array
	  */
	 public function _deleteFunds($info){
	 	return $this->_deleteToHideFunds($info);
	 }
	 
	 /**
	  * 删除对账操作(客户/厂家/物流)
	  *
	  * @param array $info
	  * @return array
	  */
	 public function _deleteCheckAccountFunds($id){
	 	
	 	if ($id<=0){return ;}
		///判断单据是否有捆绑
		$paid_info	=	$this->where('id='.$id)->find(); 
		///不指定支付
		switch ($paid_info['object_type_extend']){ 
			case 4:///不指定总平帐
				///1.删除平帐损失
				///2.删除绑定关系
				///3.删除该笔支付 
				/**
				 * 特殊处理
				 */
				$operate_id	=	$paid_info['reserve_id']; 
				$is_close	=	$paid_info['object_id']; ///特殊处理***
				if (!empty($operate_id)){ 
					$paid_for		=	M('PaidFor');
					$paid_for_list	=	$paid_for->where('to_hide=1 and operate_id=\''.$operate_id.'\'')->select();
					///删除paid_for中打包的关心
					$this->_deleteOperatePaidFor($operate_id); 
					///删除paid_detail打包关系
					$this->updateOperateId($paid_for_list,false,4,' operate_id=\''.$operate_id.'\'');	   	
					if ($is_close>0) {
						$this->updateIsClose('to_hide=1 and is_close='.$is_close,0);
					}
					///删除平帐损失
					$this->_deleteFunds($is_close);
				}
				///删除该笔支付
				$vo	=	$this->_deleteFunds($id);  
				break;	
		} 
		return $vo;
	 }
	 
	 /**
	  * 平账操作
	  *
	  * @param array $info
	  */
	 public function _closeOutFunds($info){
	 	///不指定平帐 
 		$funds	=	$info['funds'];
 		$object_type_extend	=	$info['object_type_extend'];///默认为0 1,为指定支付但是没有平账 2为指定支付且平账 3为总平账包括厂家对账 
		if ($this->comp_type==1) {
			$basic_id		=	$funds['basic_id'];
		}else{
			$basic_id		=	C('MAIN_BASIC_ID');
		}
		$comp_id		=	$funds['comp_id'];
		$currency_id	=	$funds['currency_id']; 
		$paid_date		=	formatDate($funds['paid_date']);   
		$paid_id_array	=	$info['paid_info'];     
		///生成新的历史平帐记录
		if($comp_id>0 && $basic_id>0 && $currency_id>0 && in_array($object_type_extend,array(2,3,4))) { 
			$this->format_data = false;
			$model	= M($this->getCompPaidDetail($this->comp_type));   
			///首先查询本次需要平帐打包的所有paid_id
			if ($object_type_extend==2){ 
				$extend_paid_date	=	$model
				->where(' comp_id = '.$comp_id.' and basic_id='.$basic_id.' and currency_id='.$currency_id.' and ( paid_id in ('.join(',',$paid_id_array).') )')
				->max('paid_date');///损失日期	 
				///指定支付平帐(只针对指定的欠款进行平账)
				$extend_paid_id_all	= $model
		 			->field('paid_id') 
							->where('( paid_id in ('.join(',',$paid_id_array).') )')
							->select();   
			}elseif ($object_type_extend==3){ 
				$extend_paid_date	=	$model
				->where(' is_close=0 and comp_id = '.$comp_id.' and basic_id='.$basic_id.' and currency_id='.$currency_id.' and ( paid_id in ('.join(',',$paid_id_array).') )')
				->max('paid_date');///损失日期
				if (empty($extend_paid_date)) { $extend_paid_date = date("Y-m-d"); } 
				$extend_paid_id_all	= $model
		 			->field('paid_id') 
							->where(' is_close=0 and comp_id = '.$comp_id.' and basic_id='.$basic_id.' and currency_id='.$currency_id.' and paid_date<=\''.$extend_paid_date.'\' ')
							->select(); 
			}elseif ($object_type_extend==4){
				///过虑掉对账插入的信息 
                                //添加 ！empty($paid_id_array)  zmx 2013-05-06
				(is_array($paid_id_array)&&!empty($paid_id_array))	&&	$where	=	' and paid_id not in ('.join(',',$paid_id_array).') ';
				///对账平账损失
				$extend_paid_id_all	= $model
		 			->field('paid_id') 
							->where(' is_close=0 and comp_id = '.$comp_id.' and basic_id='.$basic_id.' and currency_id='.$currency_id.' and paid_date<=\''.$paid_date.'\' '.$where.' ')
							->select();   
				$extend_paid_date	=	$paid_date;///损失日期
			} 
			///统计本次需要平帐打包的所有paid_id 
			foreach ((array)$extend_paid_id_all as $key=>$value) {
			    $close_out_paid_id_array[]	=	$value['paid_id'];
			}
			if (empty($extend_paid_date)) {
				$extend_paid_date	=	date('Y-m-d');
			} 
			if (is_array($close_out_paid_id_array)){ 
			 	$paid_info	= $model
			 			->field( 	$basic_id.' as basic_id, '.$currency_id.' as currency_id, \''.$extend_paid_date.'\' as paid_date,
									 '.$comp_id.'  as comp_id,'.$this->comp_type.' as comp_type,0 as object_id,0 as reserve_id,
									sum(income_type*(need_paid)*-1) as account_money,
									0 as money,
									0 as id,
									'.$this->object_type.' as object_type
									') 
								->where(' paid_id in ('.join(',',$close_out_paid_id_array).') ')->group('comp_id')
								->find();  
			}	 	

			if (!is_array($paid_info)){
				return ;
			}
///							echo $model->getLastSql();
///							echo '<br>'; 
			///如果是指定支付平帐,平帐金额小于0即无平帐损失就不需要记录本次平帐损失的记录.
///			if ($object_type_extend==2 && $paid_info['money']<=0){
///				return false;
///			} 
			///如果是对账减去当次指定金额 2011-09-02 需求调整
			if ($object_type_extend==4) {   
					$paid_info['account_money']	=	$paid_info['account_money']-moneyFormat($funds['money'],1); 
			}	 
			$paid_info['object_type_extend']	=	0;///默认为0 1,为指定支付但是没有平账 2为指定支付且平账 3为总平账包括厂家对账
			$paid_info['comments']				=	$funds['close_out_comments'];		///总平备注 	  
			$paid_info['comp_name']				= 	$this->getCompName($funds); 
			$paid_info['id']					= 	$this->_saveFunds($paid_info);  
			$paid_info['extend_paid_id']		= 	$close_out_paid_id_array;  
 
			///如果是总平或者对账把所有打包关系指定到is_close字段但中
			if (in_array($object_type_extend,array(3,4))) { 
				$where	=	' comp_type='.$this->comp_type.' 
				and comp_id='.$comp_id.' 
				and basic_id='.$basic_id.' 
				and currency_id='.$currency_id.' 
				and paid_date<=\''.$extend_paid_date.'\' 
				and is_close=0 and to_hide=1 '; 
				///打包记录
				$this->updateIsClose($where,$paid_info['id']);
			} 
			return $paid_info;
		}
	 }
	 
	 /**
	  * 获取对应的客户厂家物流公司的名称
	  *
	  * @param array $info
	  * @return array
	  */
	 public function getCompName($info){ 
	 	$comp_id	=	intval($info['comp_id']);
	 	if ($comp_id>0){  
		 	switch ($this->comp_type){
		 		case 1:
		 			$name	=	'factory';
		 			break;
		 		case 2:
		 			$name	=	'logistics';
		 			break;
		 		case 3:
		 			$name	=	'express';
		 			break;		
		 	}  
		 	$company	=	SOnly($name,$comp_id);
	 	} 
	 	return $company[$name.'_name'];
	 }
	  
	 /**
	  * 配置paid_detail中补充paid_income_type对应的值
	  *
	  * @param array $info
	  * @return array
	  */
	 public function _getPaidIncomeType(&$info){
		$object_type_with_paid_income_type	=	array(
						120,123,124,125,101,102,127,129,131,
						201,202,229,220,221,
						301,302,329,320,
                        401,402,429,420,
						800,
						); 
		if (in_array($info['object_type'],$object_type_with_paid_income_type)){
			$info['paid_income_type']	=	-1;///相对客户欠款 相对公司对厂家的欠款 等等 参考2.01的系统修改的触发器
		}else{
			$info['paid_income_type']	=	1;
		} 
		return $info;								
	 }
	 
	  
	/**
	 * 插入款项信息
	 *
	 * @param array $info
	 * @return array
	 */
	public function _insertFunds($info){    
		///利润使用
		isset($info['money'])&&				$info['base_money']			=	$info['money'];
		isset($info['account_money'])&&		$info['base_account_money']	=	$info['account_money'];  
		///配置补充paid_income_type对应的值
		$this->_getPaidIncomeType($info);  
		if (false === $this->create($info,'',false)) {    
			throw_json($this->getError());
		}    
		///保存POST信息->返回主表ID 
		$id		=	$this->add();     
 		if ($id!==false) { ///保存成功 
			///款项需要特殊记录日志的信息的语言包
			$this->addFundsLog('insert',$info,$id);
			return	$id;  
		} else {    
			///失败提示  
			throw_json($this->getError());
		} 
	}
	 
	/**
	 * 款项日记
	 *
	 * @param string $type
	 * @param array $info
	 * @param int $id
	 */
	public function addFundsLog($type='insert',$info,$id){ 
		///日记说明的数组
		$log_object_type = C('PAID_DETAIL_LANG');
		switch ($type) {
			case 'insert':
				$note = L('add'); 
				break;
			case 'save':
				$note = L('edit'); 
				break;	 
			default:
				$note = L('delete'); 
				break;
		}   
		$note .= $log_object_type[$info['object_type']].L('module_funds').' ';	
		switch ($info['paid_type']){
			case 1:
///				$note .= L('cash').' ';  
			break;
			case 2:
				$note .= L('bill').' ';  
			break;
			case 3:
				$note .= L('bank').' ';  
			break;		
		} 
		
		$note .= $info['paid_date'].' ';  
		switch ($info['comp_type']){
			case 1:///客户 
				///多个公司
				if (C('show_many_basic')==1){
					$note .= SOnly('basic',$info['basic_id'],'basic_name').' ';  	
				}
				$note .= $info['comp_name'].' ';  
				///判断是否多币种
				if (C('client_currency_count')>1){
					$note .= SOnly('currency',$info['currency_id'],'currency_no').' ';  
				}
				break;
			case 2:///厂家 
				$note .= $info['comp_name'].' ';  
				///判断是否多币种
				if (C('factory_currency_count')>1){
					$note .= SOnly('currency',$info['currency_id'],'currency_no').' ';  
				}
				break;
			case 3:///物流 
				$note .= $info['comp_name'].' '; 
				if (C('logistics_currency_count')>1){  
					$note .= SOnly('currency',$info['currency_id'],'currency_no').' ';  
				}
				break;
			default:
				if ($info['pay_class_id']>0){
					$note .= L('pay_class_name').':'.SOnly('pay_class',$info['pay_class_id'],'pay_class_name').' ';  
				} 
				break;	
		} 
		///金额
		$note .= L('money').':'.moneyFormat($info['money'],0,C('MONEY_LENGTH')).' ';
		///折扣
		if ($info['account_money']>0){ 
			$note .= L('account_money').':'.moneyFormat($info['account_money'],0,C('MONEY_LENGTH')).' ';
		}    
		Log::insertLog($note,MODULE_NAME,ACTION_NAME);
	}
	  
	/**
	 * 获取款项信息
	 *
	 * @param int $id
	 * @return array
	 */
	public function _paidInfo($id){
		if ($id>0){
			return	$this->where('id='.intval($id))->find();	 
		}
	}
	
	/**
	 * 更新款项信息
	 *
	 * @param array $info
	 * @return array
	 */
	public function _updateFunds($info){
		///利润使用
		isset($info['money'])&&				$info['base_money']			=	$info['money'];
		isset($info['account_money'])&&		$info['base_account_money']	=	$info['account_money']; 
 		foreach ((array)$info as $key=>$row) { if ($row==''){ unset($info[$key]);} }  
		if ($this->create($info,'',false)) {	 		
	 		$r = $this->save();
	 		if (false === $r) {
	 			throw_json($this->getError());
	 		}	
	 		$this->addFundsLog('save',$info,$info['id']);
	 		return $info['id'];
	 	} else {
	 		throw_json($this->getError());
	 	}
	}
	
	/**
	 * 删除款项信息
	 *
	 * @param int $id
	 * @return array
	 */
	public function _deleteToHideFunds($id){  
		if (is_int($id)){
			$condition 	= 'id='.$id;   
		}elseif (is_array($id)){
			$condition 	= 'id in ('.join(',',$id).') ';  
		}elseif (is_string($id) && !empty($id)){
			$condition 	= 'id in ('.$id.') ';  
		}else{
			return false;
		}  
		///删除前记录所有信息提供给日志使用
		$log		=	$this->where($condition)->select();  
		
		$list		=	$this->where($condition)->delete();  
		///如果有paid_for信息一并删除 
		$this->_deletePaidFor($condition,'string'); 
		
		///如果删除操作失败提示错误
		if ($list===false) {  
			throw_json($this->getError('删除银行信息出错'));
		}
		foreach ((array)$log as $key=>$row) { 
			$this->addFundsLog('delete',$row,$row['id']);
		}
		return true;  
	 } 
	
	/**
	 * 操作公用方法
	 */
	   
	/**
	 * 删除
	 *
	 * @param int $id
	 * @return array
	 */
	public function deleteOp($id){ 
		$id=	is_array($id)?$id['id']:$id; 
		$this->_beforCheckDelete($id);
		if ($id>0){ 
			$vo	=	$this->_deleteFunds($id); 
		} 
		return $vo;
	} 
	
	
	/**
	 * 插入款项信息
	 *
	 * @param array $info
	 * @return array
	 */
	private function _insertPaidFor($info){    
		$model	=	M('PaidFor');
		///如果不需要格式化的话
		$model->format_data = false; 
		///模型验证
		if (false === $model->create($info,'',false)) {   
			throw_json($model->getError());
		} 
		///保存POST信息->返回主表ID 
		$id		=	$model->add(); 
		if ($id!==false) { ///保存成功 
			return	$id;  
		} else {   
			///失败提示  
			throw_json($model->getError());
		} 
	}
		 
	/**
	 * 删除关联操作
	 *
	 * @param int $paid_id
	 * @param string $type
	 */
	function _deletePaidFor($paid_id,$type='int'){
		$PaidFor	=	M('PaidFor');
		if($type=='int') {
			///关联操作的ID
			$condition	=	$PaidFor->where(' paid_id='.$paid_id.'')->group('paid_id')->getField('group_concat(operate_id) as operate_id');   	
		}elseif ($type=='array'){
			if(is_array($paid_id)) {
				///关联操作的ID  
				$where	=	' paid_id in ('.join(',',$paid_id).' )';
				$condition	=	$PaidFor->where($where)->group('paid_id')->getField('group_concat(operate_id) as operate_id');  
			}else{
				///关联操作的ID  
				$where	=	' paid_id in ('.$paid_id.' )';
				$condition	=	$PaidFor->where($where)->group('paid_id')->getField('group_concat(operate_id) as operate_id');  
			} 
		}elseif ($type=='string'){
			if(!empty($paid_id)) {
				$where 		= str_replace("id","paid_id",$paid_id);
				$condition	=	$PaidFor->where($where)->group('paid_id')->getField('group_concat(operate_id) as operate_id');   
			} 
		} 
		if(!empty($condition)) {
			$PaidFor->where('operate_id in ('.$condition.' )')->setField('to_hide',2);  
///			$PaidFor->where('operate_id in ('.$condition.' )')->delete();   
		} 
	}
	
	/**
	 * 删除paid_for关联操作
	 *
	 * @param array $operate_id
	 * @param string $type
	 */
	function _deleteOperatePaidFor($operate_id,$type='int'){
		$PaidFor	=	M('PaidFor');
		if($type=='int') {
			///关联操作的ID
			$condition	=	' operate_id=\''.$operate_id.'\' and to_hide=1 ';  	
		}elseif ($type=='array'){
			if(is_array($operate_id)) {
				///关联操作的ID  
				$where	=	' operate_id in ('.join(',',$operate_id).' )'; 
			} 
		}elseif ($type=='string'){
			 
		} 
		if(!empty($condition)) {
			$PaidFor->where($condition)->setField('to_hide',2);   
///			$PaidFor->where($condition)->delete();   
		} 
	}
	 
	/**
	 * 查看款项信息
	 *
	 * @param int $id
	 * @return array
	 */
	public function fundInfo($id){ 
		///查看款项信息
		if($id>0) {
			$info = _formatList($this
			->where('object_id='.$id.' and comp_type='.$this->comp_type.' and object_type='.$this->object_type.' and to_hide=1')
			->select());  
			return $info;
		}
	}
	
	/**
	 * 公用方法
	 */
	
	/**
	 * 根据打包的paid_detail的ID把相对应的paid_for信息记录进去
	 *
	 * @param int $comp_type
	 * @param int $paid_for
	 * @param int $currency_id 如果有币种输入币种
	 */ 
	public function addPaidFor($comp_type=0,$paid_for,$currency_id=false){
 
		$currency_id>0	&&	$where 	= ' and currency_id='.$currency_id.' ';
		$operate_id		= $this->getMaxOperateId();
		$model			= M($this->getCompPaidDetail($comp_type)); 
		$paid_list		= $model->field('paid_id,need_paid as money,'.$operate_id.' as operate_id,income_type,'.$comp_type.' as comp_type')
							->where('paid_id in ('.join(',',$paid_for).')  '.$where)->order('money asc,paid_date asc')->select();
		if (count($paid_list)>0){
			$rs				= $model->where('paid_id in ('.join(',',$paid_for).') '.$where)->field('sum(if(income_type*need_paid>0,income_type*need_paid,0)) as paid_money,sum(if(income_type*need_paid<0,-1*income_type*need_paid,0)) as debt_money, count(need_paid=0) as zero_records')->find();
			if($rs['zero_records'] == 0 && ($rs['paid_money']==0 || $rs['debt_money']==0)) return;//没有零款项记录且欠/付款合计为零时，不进行绑定。有零款项时必须绑定，否则会有问题，例：对账金额与欠款金额完全一致时，删除该对账时，原有欠款没有解除绑定，应付金额仍为零。
			$money			= $rs['paid_money']-$rs['debt_money'];	//付款-欠款
			$field_name		= $money>0?'debt_money':'paid_money';
			$reversal		= $money>0?1:-1;
			foreach($paid_list as $key=>$row){
				if(!($money==0||($field_name =='paid_money' && $row['income_type']*$row['money']>0)||($field_name =='debt_money' && $row['income_type']*$row['money']<0))){
					if($rs[$field_name]==0){
						$row['money']		= 0;
					}elseif(($rs[$field_name]-$reversal*$row['income_type']*$row['money']<0)){
						$row['money']		= $reversal*$row['income_type']*$rs[$field_name];
						$rs[$field_name]	= 0;
					}else{
						$rs[$field_name]	-=	$reversal*$row['income_type']*$row['money'];
					}
				}
				$this->_insertPaidFor($row);
			}				
		}
		return $paid_list; 
	}
	
	
	/**
	 * 款项类工具方法
	 */
	 
	/**
	 * 更改paid_detail中指定支付的打包关系记录在OperateId字段当中
	 *
	 * @param array $info
	 * @param bool $delete
	 * @param int $object_type_extend
	 * @param string $where
	 * @return array
	 */
	public function updateOperateId($info,$delete=false,$object_type_extend,$where=''){
		if (empty($where)) {
			$where	=	' and 1 ';
		}else{
			$where	=	' and '.$where;
		}
		if (!is_array($info)){
			return ;
		} 
		foreach ((array)$info as $key=>$value) {
		    $paid_array[]	=	$value['paid_id'];
		}
		if ($delete==false){  
			///对于总平跟对账的处理方案
			if ($object_type_extend==3) {
				$this->where(' id in ('.join(',',$paid_array).' ) '.$where)->setField('operate_id','');
				$this->where(' id in ('.join(',',$paid_array).' ) '.$where.' and object_type_extend='.$object_type_extend)->setField('object_type_extend',0); 
			}elseif ($object_type_extend==4){
				$this->where(' id in ('.join(',',$paid_array).' ) '.$where)->setField('operate_id','');
			}else{
				///对于指定平账
					///7-26 lee修改了对于先总平后再对总平后的该笔款项进行指定支付平账后导致的BUG object_type_extend 被修改成0 的错误修改
///				$this->where(' id in ('.join(',',$paid_array).' )')->setField(array('operate_id','object_type_extend'),array('',0));
				$this->where(' id in ('.join(',',$paid_array).' )')->setField('operate_id','');
				$this->where(' ( id in ('.join(',',$paid_array).' ) && object_type_extend<>4 )')->setField('object_type_extend',0);
			} 
		}else{
			$operate_id	=	$info[0]['operate_id'];
			$this->where(' id in ('.join(',',$paid_array).' ) '.$where)->setField('operate_id',$operate_id);  
		}  
		return true;
	}
	 
	/**
	 * 更改paid_detail中指定支付的打包关系记录在is_close字段当中
	 *
	 * @param string $where
	 * @param int $id
	 * @return array
	 */
	public function updateIsClose($where,$id=0){ 
		if (empty($where)){ 
			return ;
		}    
		$this->where($where)->setField('is_close',$id);
		return true;
	}
	
	/**
	 * 更改paid_detail中state的状态
	 *
	 * @param string $where
	 * @param int $state
	 * @return bool
	 */
	public function updateState($where,$state=1){ 
		if (empty($where)){ 
			return ;
		}    
		$this->where($where)->setField('state',$state);    
		return true;
	}
	
	/**
	 * 获取PaidFor中最大的operate_id序号
	 *
	 * @return unknown $operate_id
	 */
	public function getMaxOperateId(){ 
		$PaidFor	=	M('PaidFor');
		$today 		= 	date("ymd");  
		$max_operate_id = $PaidFor->where('operate_id LIKE \'%'.$today.'%\'')->max('operate_id');
		if(empty($max_operate_id)) {
			$operate_id	=	$today.'000001';
		}else{
			$operate_id	=	$max_operate_id+1;
		} 
		return $operate_id;
	} 
	
	/**
	 * 获取上次款项表中的ID
	 *
	 * @param int $id
	 * @return array
	 */
	public function getBeforPaidIdArray($id){
		$paid_id = $this
			->where('object_id='.$id.' and comp_type='.$this->comp_type.' and object_type='.$this->object_type.' and to_hide=1') 
			->Field('id')
			->select();
		if(is_array($paid_id)) {
			foreach ((array)$paid_id as $key=>$row) {
				$paid_array[$row['id']]	=	$row['id'];
			}
		}  
		return $paid_array; 
	}
	 
	/**
	 * 处理款项表中ID的差集,直接删除
	 *
	 * @param array $old_id_array
	 * @param array $new_id_array
	 * @return array
	 */
	public function array_diff_id_key($old_array,$new_array){
		if(!is_array($old_array)) { return true; }
		foreach ((array)$new_array as $key=>$row) {
		    if($row['id']>0 && in_array($row['id'],$old_array)) {
		    	 unset($old_array[$row['id']]);	///删除修改后还存在的款项表中的ID
		    }
		}
		///删除款项差集
		if(count($old_array)>0) {
			$vo	=	$this->_deleteFunds($old_array); 
		} 
	}
	
	/**
	 * 格式化整理页面Post传递来的数据整理成paid_detail需要的数据格式
	 *
	 * @param array $info
	 * @param string $info_key 获取的下标
	 * @param bool $returnType	true=>array false=>bool 返回的类型
	 * @return array
	 */
	public function formatAdvance($info,$info_key='advance',$returnType=true){ 
		$funds	=	$info['funds'];   
		///对页面多种款项支付时没有点击"新增"的特殊处理
		$this->beforFormatAdvance($info);  
	 	
		if(is_array($info['cash'])) {
			foreach ((array)$info['cash'] as $key=>$row) {
				if(is_array($row)) {  
					$row['basic_id']			=	$funds['basic_id'];	///所属公司
					$row['befor_currency_id']	=	$row['currency_id'];///转换前的币种
					$row['currency_id']			=	$funds['currency_id'];///转换后的币种
					$row['paid_date']			=	$row['paid_date'];///日期
					$row['paid_type']			=	1;///现金
					$row['comp_id']				=	$funds['comp_id'];///客户ID
					$row['comp_type']			=	$this->comp_type;///客户类型
					$row['comp_name']			=	$funds['comp_name'];///客户名称
					$row['object_type']			=	$this->object_type;///款项类型
					$row['object_id']			=	$funds['object_id'];///销售单ID
					$row['reserve_id']			=	$funds['reserve_id'];///关联ID
                    $row['warehouse_id']        =	$funds['warehouse_id'];///所属仓库ID
					if ($row['rate']>0){
						$row['befor_rate']			=	$row['rate'];///临时汇率 
						if ($row['befor_currency_id']!=$funds['currency_id']){///当收款币种与指定的币种有差异的时候
							$row['money']				=	moneyFormat($row['money'],1)*moneyFormat($row['rate'],1);	 
						} 
						unset($row['rate']);
					} 
					$paid_info[]	=	$row;								    
				}
			}						
		}
		if(is_array($info['bill'])) {
			foreach ((array)$info['bill'] as $key=>$row) {
				if(is_array($row)) { 
					$row['basic_id']			=	$funds['basic_id'];	///所属公司
					$row['befor_currency_id']	=	$row['currency_id'];///转换前的币种
					$row['currency_id']			=	$funds['currency_id'];///转换后的币种
					$row['paid_date']			=	$row['paid_date'];///日期
					$row['bill_date']			=	$row['bill_date'];///日期
					$row['paid_type']			=	2;///支票
					$row['comp_id']				=	$funds['comp_id'];///客户ID
					$row['comp_type']			=	$this->comp_type;///客户类型
					$row['comp_name']			=	$funds['comp_name'];///客户名称
					$row['object_type']			=	$this->object_type;///款项类型
					$row['object_id']			=	$funds['object_id'];///销售单ID
					$row['reserve_id']			=	$funds['reserve_id'];///关联ID
                    $row['warehouse_id']        =	$funds['warehouse_id'];///所属仓库ID
					if ($row['rate']>0){
						$row['befor_rate']			=	$row['rate'];///临时汇率
						if ($row['befor_currency_id']!=$funds['currency_id']){///当收款币种与指定的币种有差异的时候
							$row['money']				=	moneyFormat($row['money'],1)*moneyFormat($row['rate'],1);	 
						} 
						unset($row['rate']);
					} 
					$paid_info[]	=	$row;								    
				}
			}						
		}
		if(is_array($info['transfer'])) {  
			foreach ((array)$info['transfer'] as $key=>$row) { 
				if(is_array($row)) { 
					$row['basic_id']			=	$funds['basic_id'];	///所属公司
					$row['befor_currency_id']	=	$row['currency_id'];///转换前的币种
					$row['currency_id']			=	$funds['currency_id'];///转换后的币种
					$row['paid_date']			=	$row['paid_date'];///日期
					$row['paid_type']			=	3;///转账
					$row['comp_id']				=	$funds['comp_id'];///客户ID
					$row['comp_type']			=	$this->comp_type;///客户类型
					$row['comp_name']			=	$funds['comp_name'];///客户名称
					$row['object_type']			=	$this->object_type;///款项类型
					$row['object_id']			=	$funds['object_id'];///销售单ID
					$row['reserve_id']			=	$funds['reserve_id'];///关联ID 
                    $row['warehouse_id']        =	$funds['warehouse_id'];///所属仓库ID
					if ($row['rate']>0){
						$row['befor_rate']			=	$row['rate'];///临时汇率
						if ($row['befor_currency_id']!=$funds['currency_id']){///当收款币种与指定的币种有差异的时候
							$row['money']				=	moneyFormat($row['money'],1)*moneyFormat($row['rate'],1);	 
						} 
						unset($row['rate']);
					}
					$paid_info[]	=	$row;
				}								    
			}						
		} 
		if (empty($paid_info)){
			///根据类型返回相应的信息
			if ($returnType) {
				///获取本次指定的最大日期作为本次付款的日期
				if (is_array($info['check_info'])) { 
					$paid_date	=	$this->where(' id in ('.join(',',$info['check_info']).') ')
										->max('paid_date');///损失日期  
				}  
				///如果没有输入任何收款信息补充一条虚拟的信息
				$paid_info[]	=	$this->addFundsEmptyInfo($funds,$paid_date); 
			}else{
				return false;
			} 
		}
		return $paid_info;
	}
	 
	/**
	 * 业务规则验证
	 *
	 * @return unknown
	 */
	public function _brf(){  
		/// 业务规则检查
        $all_tags 	 	= C('extends');
        $action_tag_name = MODULE_NAME.'^'.ACTION_NAME;   
        if (isset($all_tags[$action_tag_name])) {   
        	tag($action_tag_name,$this->data);
        } 
	}
	
	/**
	 * 获取数组中最大日期的时间
	 *
	 * @param array 	$paid_info
	 * @param string 	$info_key
	 * @return array
	 */
	public function getListMaxDate($paid_info,$info_key='paid_date'){
		///获取输入款项中最大日期
		$count	=	count($paid_info);
		if($count>1){ 
			///欧洲格式
			if (C('digital_format')=='eur') {
				foreach ((array)$paid_info as $key=>$row) {
					 if ($key==0) {
					 	$max_paid_date	=	$row[$info_key];
					 }else{  
						if (strtotime(formatDate($row[$info_key]))>strtotime(formatDate($max_paid_date))) {
							$max_paid_date	=	$row[$info_key];
						} 
					 }
			 	}	 		
			}else{
				///中国格式
				foreach ((array)$paid_info as $key=>$row) {
					 if ($key==0) {
					 	$max_paid_date	=	$row[$info_key];
					 }else{  
						if (strtotime($row[$info_key])>strtotime($max_paid_date)) {
							$max_paid_date	=	$row[$info_key];
						} 
					 }
			 	}	 		
			} 
			$max_date	=	$max_paid_date; 
		}elseif ($count==1){ 
			$max_date	=	$paid_info[0][$info_key];
		}
		return $max_date;
	}
	
	
	/**
	 * 判断是否有已经输入的款项信息
	 * @param array $info
	 * @return boolean
	 */
	public function hasInputFunds($info){
		if (is_array($info['cash']) || is_array($info['bill']) || is_array($info['transfer'])){
			$has_input_funds	= false;
		} else {
			$has_input_funds	= true;	
		}	
		return $has_input_funds;
	}

	/**
	 * 返回款项类型 1: cash(现金), 2: bill(支票), 3: transfer(转账);
	 * @author jph 20140709
	 * @param int $pay_paid_type
	 * @return string
	 */
	public function getPayPaidType($pay_paid_type){
		switch ($pay_paid_type){
			case 1:
				$type	= 'cash';
				break;
			case 2:
				$type	= 'bill';
				break;
			case 3:
				$type	= 'transfer';
				break;		
		}
		return $type;
	}
	
	/**
	 * 对页面多种款项支付时没有点击"新增"的特殊处理
	 *
	 * @param array $info
	 * @return array
	 */
	public function beforFormatAdvance(&$info){
		$pay_paid_type			= $this->getPayPaidType($info['pay_paid_type']);
		if (!empty($pay_paid_type) && (moneyFormat($info['pay_' . $pay_paid_type . '_money'],1)!=0 || moneyFormat($info['pay_' . $pay_paid_type . '_account_money'],1)!=0 || $this->hasInputFunds($info))){
			$funds_fields	= array('currency_id', 'money', 'account_money', 'rate', 'paid_date', 'comments');
			switch ($pay_paid_type) {
				case 'cash':
					break;
				case 'bill':
					$funds_fields[]	= 'bill_no';
					$funds_fields[]	= 'bill_date';					
					break;
				case 'transfer':
					$funds_fields[]	= 'bank_id';
					break;
			}			
			foreach ($funds_fields as $field) {
				$info[$pay_paid_type]['sys_add'][$field]		= $info['pay_' . $pay_paid_type . '_' . $field];
			}
		}		
///		return $info; 
	}
	 
	/**
	 * 模拟一条收款未0的数据(指定支付但不输入款项的时候专门使用)
	 *
	 * @param array $info
	 * @param string $paid_date
	 * @return array
	 */
	public function addFundsEmptyInfo($info,$paid_date=''){ 
		$paid_date	=	empty($paid_date)?date("Y-m-d"):$paid_date; 
		return $empty_info	=	array(
										'currency_id'			=>$info['currency_id'],
										'befor_currency_id'		=>$info['currency_id'],
										'basic_id'				=>$info['basic_id'],
										'comp_id'				=>$info['comp_id'],
										'money'					=>0,
										'account_money'			=>0,
										'paid_date'				=>$paid_date,
										'comments'				=>'',
										'object_type'			=>$this->object_type,
										'comp_type'				=>$this->comp_type,
										'befor_rate'			=>1, 
								); 
	}
	 
	 
	/**
	 * 验证公告方法
	 */ 
	
	/**
	 * 删除前的再次验证的公用函数
	 *
	 * @param int $id paid_id
	 * @return bool
	 */
	public function _beforCheckDelete($id){ 
///		$m			= MODULE_NAME;
///		$a			= ACTION_NAME; 
///		$business	= Brf::validBusiness($m,$a);	  
 
		if ($id>0) {
			///删除前再次验证是否可以删除
			$error	=	$this->checkDelete($id,'int'); 
			///验证情况
			if ($error['state']==-1) {
				///错误提示
				throw_json(join(',',$error['error_msg']).'!');
///				throw_json(join(',',$error['error_msg']));
			}
		} 
		return true; 
	}
	
	/**
	 * 插入前的业务规则验证
	 *
	 * @param array $info
	 * @return bool
	 */
	public function checkInsert($info){
		return true;
	}
	
	/**
	 * 修改插入数据前的业务规则验证
	 *
	 * @param array $info
	 * @return bool
	 */
	public function checkUpdate($info){
		return true;
	}
	
	/**
	 * 修改前的业务规则验证
	 *
	 * @param array $info
	 * @return bool
	 */
	public function checkEdit($info){
		return true;
	}
	
	/**
	 * 验证该笔款项是否可以被删除
	 *
	 * @param array $info 数组中应包含被删除款项表中的id 已经 comp_type
	 * @param string $type
	 * @return array
	 */
	public function checkDelete($info,$type='array'){    
		$error				=	array();
		$error['state']		=	1;    
		if (is_array($info)) {
			 if ($info['paid_id']) { 
				$id					=	intval($info['paid_id']); 
			}else{
				$id					=	intval($info['id']); 
			} 
		}else{
			$id					=	intval($info); 
		}      
		if ($id>0 && $this->comp_type>0) {  
			$comp_type	=	$this->comp_type; 
			$model		=	M($this->getCompPaidDetail($comp_type));
			if (data_permission_validation($model->where('paid_id='.$id)->find(), 'comp_id') === false) {
				$error['state']			=	-1;
				$error['error_msg'][]	=	L('data_right_error');///款项验证,参数错误,请重新操作
			} elseif (is_array($model->where(' (have_paid>0 or is_close>0) and paid_id='.$id)->find())) {
				$error['state']			=	-1; 
				$error['error_msg'][]	=	L('error_is_designated_cant_del');///已指定操作,不可删除
			} 
		}else{
			$error['state']			=	-1; 
			$error['error_msg'][]	=	L('error_funds_values_error');///款项验证,参数错误,请重新操作
		}   
		return $error; 
	}
	 
	/**
	 * 验证该笔款项是否可以被删除(厂家、客户、物流收款列表)
	 *
	 * @param array $info 数组中应包含被删除款项表中的id 已经 comp_type
	 * @param string $type
	 * @return array
	 */
	public function checkFundsDelete($info,$type='array'){
		 
		$id	=	is_array($info)?$info['id']:$info;
		$error				=	array();
		$error['state']		=	1;   
		if ($id>0 && $this->comp_type>0) {  
			$model		=	M($this->getCompPaidDetail($this->comp_type));

			$paid_info	=	$model->where(' (have_paid!=0 or original_money=0) and paid_id='.$id)->find();
			///验证是否是预收款
			if ($paid_info['object_type']==$this->object_type_advance && $this->object_type_advance>0) { 
				$error['state']			=	-1;
				$error['error_msg'][]	=	L('error_sale_is_advance');///'预收款，不可删除，请至销售单处删除预收信息';
				return $error;
			}
			///验证是否已对账
			$error		=	$this->checkAccountDate($paid_info,'delete');  
			if ($error['state']<0) { 
				return $error;
			}
			///验证是否已被捆绑操作
			if (!empty($paid_info['operate_id']) && $paid_info['object_type_extend']<2) {  
				$error['state']			=	-1;
				$error['error_msg'][]	=	L('error_is_designated_cant_del');///已绑定，该笔款项不可被操作
				return $error;
			}
			//exit;
///			echo $model->getLastSql();
///			echo '<br>';
		}else{
			$error['state']		=	-1; 
			$error['error_msg'][]	=	L('error_funds_values_error');///'款项验证,参数错误,请重新操作';
		} 
		return $error; 
	}
	
	/**
	 * 保存前的验证(厂家、客户、物流收款付款)
	 *
	 * @param array $info
	 * @return array
	 */
	public function checkFundsInsert($info){
		
		$error['state']	=	1;
		$info['funds']	=	array(
								 	'basic_id'=>$info['basic_id'],
								 	'comp_id'=>$info['comp_id'], 
								 	'currency_id'=>$info['currency_id'], 
                                    'warehouse_id'=>$info['warehouse_id'], 
	 	); 
	 	$count_check_info	=	count($info['check_info']); 
	 	$object_type_extend	=	0;
	 	///object_type_extend 默认为0 1,为指定支付但是没有平账 2为指定支付且平账 3为总平账包括厂家对账
	 	if ($info['close_out']==2){ 
			if ($count_check_info>0){ 
				$paid_for	=	$info['check_info'];
				$object_type_extend	=	2;
			}else{
				$object_type_extend	=	3;
			}
	 	}else{
	 		if ($count_check_info>0){ 
	 			$paid_for	=	$info['check_info'];
	 			$object_type_extend	=	1;
	 		}
	 	} 
	 	
	 	$paid_info	=	$this->formatAdvance($info);  
	 	///验证输入的 日期是否全部大于最后一次指定的或者总平的日期 
	 	foreach ((array)$paid_info as $key=>$row) { 
	 		$error	=	$this->checkPaidDate($row);
	 		if ($error['state']<0){
	 			return $error;
	 		} 
	 	}
	 	
	 	if ($object_type_extend==3) { 
	 		///格式化页面来的信息	
///			$paid_info	=	$this->formatAdvance($info);  
			///获取付款中最大日期(模拟本次支付中的款项最大日期)
		 	$_POST['paid_date']	=	$this->getListMaxDate($paid_info); 
			///验证是否有在路上,未确认的款项    
			if ($this->checkHaveStateZero($_POST)==false) {  
				$error['state']			=	-1;
				if ($_POST['comp_type']==1) { 
					$error['error_msg'][]	=	L('error_cant_close_out_have_sale');///'不可总平,销售单未实际发货'; 
				}else{
					$error['error_msg'][]	=	L('error_cant_close_out_have_on_load');///'不可总平,有在路上的款项'; 
				}   
				return $error;
			}    
			///验证输入的款项日期是否在指定支付的区间内
			foreach ((array)$paid_info as $key=>$row) {
				if ($this->checkPaidDateNoInPaidForMiddle($row)==false) { 
					$error['state']			=	-1;
///					$error['error_msg'][]	=	'总平操作中，收款日期'.$row['paid_date'].',不能在指定支付的区间内,请修改'; 
					$error['error_msg'][]	=	L('error_close_out_valide_date_1').$row['paid_date'].L('error_close_out_valide_date_2'); 
				}	 	
			} 
			
			if ($error['state']==-1) {
				return $error;
			}
	 	} 
	 	
	 	///验证是否有指定或者输入信息
///	 	if ($object_type_extend==0) { 
///	 		///格式化页面来的信息	
///	 		if ($this->formatAdvance($info,'advance',false)==false) {
///	 			$error['state']			=	-1;
///				$error['error_msg'][]	=	L('error_input_funds_info');///'请输入指定信息，或者款项信息。';  
///	 		} 
///	 	}   
	 	return $error;
	}
	
	
	/**
 	 * 验证输入的日期是否大于对账日期(客户、厂家、物流、)
 	 *
 	 * @param array $info	paid_detail中的数据或者页面组合成paid_detail的模拟信息
 	 * @param string $action insert=>验证日期是否大于对账日期 ，delete=>验证如果对账过，即款项不可以被删除
 	 * 验证的数组格式
 	 * ///对象类型
 		$comp_type		=	intval($info['comp_type']);
 		$currency_id	=	intval($info['currency_id']);
 		$comp_id		=	intval($info['comp_id']); 
 		$basic_id		=	intval($info['basic_id']);
 		$paid_date		=	$info['paid_date'];		///输入验证的日期
 	 * 
 	 * @return unknown
 	 */
 	public function checkAccountDate($info,$action='insert'){ 
 		
 		$error['state']			=	1;
 		///对象类型
 		$comp_type				=	(empty($info['comp_type']))?$this->comp_type:intval($info['comp_type']); 
 		$currency_id			=	intval($info['currency_id']);
 		$comp_id				=	intval($info['comp_id']); 
 		$basic_id				=	intval($info['basic_id']);
 		$paid_id				=	intval($info['paid_id']);
 		$object_type_extend		=	intval($info['object_type_extend']);
	 	
 		if ($comp_type>0 && $currency_id>0 && $comp_id>0 && $basic_id>0) {
			 $object_type_array	=	array( 		
			 							1=>'129',
								 		2=>'229',
								 		3=>'329',);
			 $close_outobject_type_array	=	array( 		
			 							1=>'103',
								 		2=>'203',
								 		3=>'303',);	
			/// 错误信息的日期提示
			$object_type_date	=	array( 		
			 							1=> C('FLOW.DELIVERY') ? L('delivery').L('date') : L('sale').L('date'),
								 		2=> L('real_arrive_date'),
								 		3=> L('real_arrive_date'),);	 	 		
	 		///款项类型
	 		$object_type		=	$object_type_array[$comp_type]; 
	 		$model_paid_detail 	= M($this->getCompPaidDetail($comp_type));
	 		
	 		$where	=	' and ( (object_type='.$object_type.' ) or ( object_type_extend=3 and object_type='.$close_outobject_type_array[$comp_type].' ) )';
	 		///过滤掉本次为平账或者对账的信息
	 		if ($paid_id>0 && in_array($object_type_extend,array(3,4))) {
	 			if ($object_type_extend==3) {
	 				$paid_info	=	$this->find($paid_id);
	 				$where	.=	' and paid_id not in (select id from paid_detail where to_hide=1 and object_type_extend=3 and is_close='.$paid_info['is_close'].')';
	 			}else{
	 				$where	.=	' and paid_id<>'.$paid_id;
	 			} 
	 		} 
	 		///获取最大对账日期
	 		$max_paid_date = $model_paid_detail  
	 				->where(' currency_id='.$currency_id.' and basic_id='.$basic_id.' and comp_id='.$comp_id.$where)->max('paid_date');   
///	 				echo $model_paid_detail->getLastSql();
///	 				echo '<br>';
			if (empty($max_paid_date)) {
				return $error;
			}   
			$info['comp_name']	=	$this->getCompName($info);
	 		///插入的对账日期的验证
	 		if ($action=='insert') {
	 			if ($max_paid_date >= formatDate($info['paid_date'])) { 			
		 			$error['state']			=	-1;
					$error['error_msg'][]	=	$info['comp_name'].' '.$object_type_date[$comp_type].$info['paid_date'].' '.L('error_input_paid_date_is_max');///'该日期，小于对账日期，请重新输入';
					return $error;
	 			}
	 		}else{///删除款项的对账日期的验证  
	 			if ($max_paid_date >= formatDate($info['paid_date'])) { 			
		 			$error['state']			=	-1;
					$error['error_msg'][]	=	$info['comp_name'].' '.$max_paid_date.' '.L('error_is_check_account_cant_del');///'已对账,不可删除';
					return $error;
	 			}
	 		}
 		}
   		 
 	}
 	
 	/**
 	 * 根据用户类型返回相对应的款项表
 	 *
 	 * @param int $comp_type
 	 * @return array
 	 */
 	public function getCompPaidDetail($comp_type){
 		if ($comp_type>0) {
 			$paid_detail	=	array(
 									1=>'ClientPaidDetail',
 									2=>'FactoryPaidDetail',
 									3=>'LogisticsPaidDetail',
                                    4=>'WarehousePaidDetail'); 
 			return $paid_detail[$comp_type];
 		}
 		return false;
 	}
 	 
 	/**
 	 * 验证对帐日期
 	 *
 	 * @param string $need_chk_date
 	 * @param array $info
 	 * @return array
 	 */
	public function validCheckAccountDate($need_chk_date,$info) {  
		///日期格式化   
		$chk_model 	  = MODULE_NAME;
///		if($chk_model == 'Instock' && isset($this->data['modify_real_arrive_date']) && !$this->data['modify_real_arrive_date']) {return true;}	
		 
		if (in_array($chk_model, array('LoadContainer', 'Instock')) && $this->comp_type==2) { /// 订货装柜  
///			if (C('FLOW.ORDERS')) { 
			if ($chk_model=='LoadContainer') { 
				foreach ((array)$info['detail'] as $list) {
					if ($list['orders_id']>0){
						$order_ids[] = $list['orders_id'];	
					}
				} 
				/// 查找订单中的厂家及币种
				$order_ids 	= array_unique($order_ids);
				$rs			= M('Orders')->field('factory_id,currency_id')
										->where('id in ('.implode(',', $order_ids).')')
										->select();	 					
				if (is_array($rs)) {
					foreach ($rs as $list) {
						$comp_id[] 		= $list['factory_id'];
						$currency_id[]	= $list['currency_id'];
					}
				} 
			} else {/// 没有订货流程时只接从明细中取厂家及币种 
				//////验证过滤对过账的信息
				if ($info['id']>0 && ACTION_NAME=='update'){
					$validPass	=	array();
					$passInfo	=	$this->EditPassInfo($info['id']); 
					foreach ((array)$passInfo as $list) {
						$validPass[]	=	$list['comp_id'].'_'.$list['currency_id'];
					}  
				}   
				 
				foreach ((array)$info['detail'] as $list) {  
					$str	=	$list['factory_id'].'_'.$list['currency_id'];  
					if (in_array($str,$validPass)){  	 
						continue;
					}
					if ($list['factory_id']>0 && $list['currency_id']>0){   
						$comp_id[] 		= $list['factory_id'];
						$currency_id[]	= $list['currency_id'];
					}  
				} 
			}  	 
			if (count($comp_id)>0 && count($currency_id)>0) {  
				$model	=	M('PaidDetail');
			 	$where=	'to_hide=1 and comp_type=1 and comp_id in ('.join(',',$comp_id).') and currency_id in ('.join(',',$currency_id).') and ( (object_type=229) or (object_type=203 and object_type_extend=3 ))';
				$paid_date = $model->where($where)->max('paid_date');  
///				echo $model->getLastSql();
///				exit;
			}else {
				return true;
			}	 
		}elseif ($chk_model == 'Instock' && C('instock.instock_logistics_funds')==1 && $info['comp_type']==3){
			///验证过滤对过账的信息
		 	if ($info['id']>0 && ACTION_NAME=='update'){
					$validPass	=	array();
					$passInfo	=	$this->EditPassInfo($info['id']); 
					if (is_array($passInfo)){ return true; }
			} 
			$where	=	'comp_id='.$info['logistics_id'].' 
			and currency_id='.$info['currency_id'].' 
			and basic_id='.C('MAIN_BASIC_ID').' 
			and ( (object_type=329) or (object_type=303 and object_type_extend=3 ))';			
			$paid_date = M('LogisticsPaidDetail')->where($where)->max('paid_date');	   
		} else {  
			$model		=	M($this->getCompPaidDetail($this->comp_type));
			if (in_array($this->comp_type,array(2,3))){
				$info['basic_id']	=	C('MAIN_BASIC_ID');
			}
			
			switch ($this->comp_type){
				case 1:
					isset($info['client_id'])	&&	$info['comp_id']	=	$info['client_id'];
					$paidDetailWhere	=	' and ( (object_type=129) or (object_type=103 and object_type_extend=3 ))';
					break;
				case 2:
					isset($info['factory_id'])	&&	$info['comp_id']	=	$info['factory_id'];
					$paidDetailWhere	=	' and ( (object_type=229) or (object_type=203 and object_type_extend=3 ))';
					break;
				case 3:
					isset($info['logistics_id'])	&&	$info['comp_id']	=	$info['logistics_id'];
					$paidDetailWhere	=	' and ( (object_type=329) or (object_type=303 and object_type_extend=3 ))';
					break;		
			}  
			$where	=	'comp_id='.$info['comp_id'].' 
			and currency_id='.$info['currency_id'].' 
			and basic_id='.$info['basic_id'].' 
			'.$paidDetailWhere;
			$paid_date = $model->where($where)->max('paid_date');	
		}	  
		if ($paid_date && $need_chk_date <= $paid_date) { /// 有对帐日期 
			return false;
		}	 
		return true;	
	}
 	 
 	/**
 	 * 验证这个日期不可以在paid_for中的打包日期(对账与总平中控制 总平日期或者对账日期的区间)
 	 *
 	 * @param array $info
 	 * @return array
 	 */
 	public function checkPaidDateNoInPaidForMiddle($info){   
 		extract($info); 
 		///验证方法
/// 		1.找到比这个输入日期最靠近且最大的所有日期的当日的所有paid_id(如果没有即该日期有效)
		
/// 		2.如果有paid_id验证这个找到的日期之前的有是否捆绑了笔在输入的日期之前的信息是否存在，如果存在即不可以使用
		if (!empty($paid_date) && $basic_id>0 && $comp_type>0 && $comp_id>0&& $currency_id>0) { 
			$model	=	M('PaidDetail');
			$paid_array	=	$model->field('id')->where(' currency_id='.$currency_id.' and basic_id='.$basic_id.' and comp_type='.$comp_type.' and to_hide=1 and comp_id='.$comp_id.' and paid_date>\''.formatDate($paid_date).'\'')->select();
///			echo $model->getLastSql();
///			echo '<br>';
		 	if (!is_array($paid_array)) {
		 		return true;
		 	}
		 	///所有该日期之前的单据
			foreach ((array)$paid_array as $key=>$row) {
				 	$paid_id[]	=	$row['id'];
			} 
		 	$for	=	M('PaidFor');
                        // in 查询 效率 很低 拆分修改 --zmx 2013-05-06
                        $tmp    = array();
                        $operate_id = M('paid_for')->field('operate_id')->where('to_hide=1 and paid_id in ('.join(',',$paid_id).')')->group('operate_id')->select();
                        foreach((array)$operate_id as $key=>$val){
                            $tmp[]  = $val['operate_id'];
                        }
                        $paid_id    = M('paid_for')->field('paid_id')
                                        ->where('operate_id in ('.(empty($tmp)?0:join(',',$tmp)).')')
                                        ->group('paid_id')
                                        ->select();
                        $tmp    = array();
                        foreach((array)$paid_id as $key=>$val){
                            $tmp[]  = $val['paid_id'];
                        }
                        $middle_info    = $model->field('id')
                                        ->where(' currency_id='.$currency_id.' and id in ('.(empty($tmp)?0:join(',',$tmp)).') and paid_date<=\''.formatDate($paid_date).'\'')
                                        ->select();
//		 	$middle_info	=	$model->field('id')
//                                ->where(' currency_id='.$currency_id.' and id in ( 
//                                    select paid_id from paid_for where operate_id in ( 
//                                    select operate_id from paid_for where to_hide=1 and paid_id in ('.join(',',$paid_id).') group by operate_id 
//                                        ) group by paid_id 
//                                    ) and paid_date<=\''.formatDate($paid_date).'\'')
//                                ->select();
                        
///			echo $model->getLastSql();
///			echo '<br>';
			if (is_array($middle_info)) { 
				return false;
			}else { 
				return true;
			}
		}else{ 
			return false;
		}  
 	}
 	
 	/**
 	 * 判断是否有,验证是否有在路上,未确认的款项,不能总平的条件
 	 *
 	 * @param array $info
 	 * @param bool $is_date 判断是否需要增加日期区间的验证
 	 * @return bool
 	 */
 	public function checkHaveStateZero($info){
 		$bool	=	 false;
 		extract($info);  
 		if ($comp_type>0 && $currency_id>0 && $basic_id>0 && $comp_id>0) {   
 			///如果是客户 并且未开启配货模块即不验证 未发货的的信息
 			if ($comp_type==1 && C('sale.relation_sale_follow_up')==2){
 				return $bool	=	true;
 			} 
 			if ($paid_date) {	$where	=	' and paid_date<=\''.formatDate($paid_date).'\' ';	} 
	 		///验证是否有在路上,未确认的款项
			$state_info	=	$this->where('comp_type='.$_POST['comp_type'].' and currency_id='.$currency_id.' and basic_id='.$_POST['basic_id'].' and comp_id='.$_POST['comp_id'].' and state=0 '.$where)->find();  
///			echo $this->getLastSql();
			///验证是否有在路上,未确认的款项
			if (empty($state_info['id'])) {  
				$bool	=	 true;
			}  
		} 
		return $bool;
 	}
 	  
 	/**
 	 * 验证销售单是否可被删除或修改
 	 *
 	 * @param int $id
 	 * @return bool
 	 */
 	public function _checkSaleOrder($id){
 		$error['state']	=	1; 
 		if ($id>0) {
 			$sale_info	= M('sale_order')->where('id='.$id)->find();
 			///判断预付款等是否有在被指定过其他的款项支付
			if (!empty($sale_info['sale_order_no'])) {
				$comp_paid_detail	=	M($this->getCompPaidDetail($this->comp_type));
				$money				=	$comp_paid_detail->where('account_no=\''.$sale_info['sale_order_no'].'\'')->getField('sum(have_paid*income_type) as money ');
				if ($money!=0) {
					$error['state']	=	-1;
					$error['error_msg'][]	=	L('error_is_designated_cant_del');///已指定操作,不可删除
				} 
			} 
			if ($error['state']==1) {   
				$model		= M($this->getCompPaidDetail($this->comp_type));
			 	$paid_info	= $model->where('object_id='.$id.' and object_type='.$this->object_type.' ')
									->find();  		
				///验证是否被对账或总平
				$error	=	$this->checkAccountDate($paid_info);	 	
			} 
 		}
 		return $error;
 	}
 	
 	/**
 	 * 款项Token的验证
 	 *
 	 * @param array $info post
 	 */
 	public function fundCheckToken(&$info){
 		 ///表单令牌验证
        if(C('TOKEN_ON') && !$this->autoCheckToken($info)) {
           	$this->error = L('_TOKEN_ERROR_'); 
		  	throw_json($this->getError()); 
        }else{
        	$info	=	$this->deleteToken($info);
        }
 	}
 	
 	/**
	 * 验证某日期以前的款项是否可以被插入
	 *
	 * @param array $info
	 * @param string $data_name 验证的日期字段
	 */
	public function checkPaidDate($info,$data_name='paid_date'){  
		$error['state']	=	1;    
		if (!empty($info[$data_name])){
			if ($this->validCheckAccountDate(formatDate($info[$data_name],'vf_date'),$info)===false){
				$error['state']	=	-1;
				switch ($this->comp_type){
					case 1:
						$error['error_msg'][]	=	$info[$data_name].L('error_input_paid_date_is_max');///该日期小于等于对账或平账日期，请重新操作
						break;
					case 2:
						$error['error_msg'][]	=	$info[$data_name].L('error_input_paid_date_is_max');///该日期小于等于对账或平账日期，请重新操作
						break;
					case 3:
						$error['error_msg'][]	=	$info[$data_name].L('error_input_paid_date_is_max');///该日期小于等于对账或平账日期，请重新操作
						break;		
				} 
				
			} 			
		} 
		return $error; 
	} 
	
}
?>