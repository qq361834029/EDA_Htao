<?php 
/**
 * 客户/厂家/物流款项公共类
 * @copyright   Copyright (c) 2006 - 2013 Top Union 展联软件友拓通
 * @category   	账目信息
 * @package  	Model
 * @author    	何剑波
 * @version 	2.1,2013-07-22
 */

class ObjectFundsPublicModel extends AbsFundsPublicModel {
	/// 模型名与数据表名不一致，需要指定
	protected $tableName 			= 'paid_detail';
	///表查询
	public $comp_paid_detail 		= 'factory_paid_detail'; 
	///合计数量的count对应的字段id
	public $indexCountPk 			= 'id'; 
	///款项类型
	public $object_type				=	'';///厂家不指定收款2
	///厂家平账款项类型
	public $object_type_close_out	=	'';
	///对象类型
	public $comp_type				=	'';	 
	///
	public $sale_object_type		=	'';
	
	/// 自动验证设置
	protected $_validate	 =	 array(
				array("comp_id",'validObjectFundsInfo','require',1,'callbacks'), 	 
			); 
		 
	public $_step1	=	array(
				array("comp_id",'require',"require",1), 
				array("basic_id",'require',"require",1), 
				array("currency_id",'pst_integer',"require",1), 
                array("warehouse_id",'require',"require",1),
	);
	
	public $_step2	=	array(
				array("comp_id",'require',"require",1), 
				array("basic_id",'require',"require",1), 
				array("currency_id",'pst_integer',"require",1),  
	);
	public $_cash	=	array(
				array("pay_cash_currency_id",'require',"require",1), /// 0表示存在字段就验证 
				array("pay_cash_money",'require',"require",1),
				array("pay_cash_money",'zmoney','double',1), 
				array("pay_cash_account_money",'require','require',1), 
				array("pay_cash_account_money",'double','double',1), 
				array("pay_cash_rate",'require','require',0), 
				array("pay_cash_rate",'double','double',0),     
				array("pay_cash_paid_date",'require',"require",1), ///1为必须验证 
///				array("pay_cash_paid_date",'validCheckAccountDate',"order_date_chk",1,'callback'), ///销售日期必须大于最近一次对帐日期 
	);
	
	public $_bill	=	array(
				array("pay_bill_currency_id",'require',"require",1), /// 0表示存在字段就验证 
				array("pay_bill_bill_no",'require',"require",1), /// 0表示存在字段就验证   
				array("pay_bill_bill_no",'require',"unique",1,'bill_no'),      
///				array("pay_bill_bill_no","validBillNo",'validBillNo',1,'callback',3,'validBillNo'), 
				array("pay_bill_money",'require',"require",1), /// 0表示存在字段就验证   
				array("pay_bill_money",'zmoney',"double",1), /// 0表示存在字段就验证   
				array("pay_bill_rate",'require',"require",0), /// 0表示存在字段就验证   
				array("pay_bill_rate",'double',"double",0), /// 0表示存在字段就验证   
				array("pay_bill_account_money",'require',"require",1), /// 0表示存在字段就验证   
				array("pay_bill_account_money",'double',"double",1), /// 0表示存在字段就验证   
				array("pay_bill_paid_date",'require',"require",1), ///1为必须验证 
				array("pay_bill_bill_date",'require',"require",1), ///1为必须验证  
///				array("pay_bill_paid_date",'validCheckAccountDate',"order_date_chk",1,'callback'), ///销售日期必须大于最近一次对帐日期 
	);
	
	public $_transfer	=	array(
				array("pay_transfer_bank_id",'require',"require",1), /// 0表示存在字段就验证   
				array("pay_transfer_money",'require',"require",1), /// 0表示存在字段就验证   
				array("pay_transfer_money",'zmoney',"double",1), /// 0表示存在字段就验证   
				array("pay_transfer_account_money",'require',"require",1), /// 0表示存在字段就验证 
				array("pay_transfer_account_money",'double',"double",1), /// 0表示存在字段就验证 
				array("pay_transfer_rate",'require',"require",0), /// 0表示存在字段就验证     
				array("pay_transfer_rate",'double',"double",0), /// 0表示存在字段就验证     
				array("pay_transfer_paid_date",'require',"require",1), ///1为必须验证  
                array("pay_transfer_contact_name",'require',"require",1), /// 1为必须验证  
///				array("pay_transfer_paid_date",'validCheckAccountDate',"order_date_chk",1,'callback'), ///销售日期必须大于最近一次对帐日期 
	);
	
	public $_funs	=	array(
				array("comp_id",'require',"require",1), 
				array("basic_id",'require',"require",1), 
				array("pay_cash_money",'require',"require",1),
				array("pay_cash_money",'money','double',1), 
	);
	 
	/**
	 * ajax验证现金/支票/转账的提交验证
	 *
	 * @param array $info
	 * @return array
	 */
	public function validPaidFunds($info){  
		$detailFunds	=	'_'.strtolower($info['type']);  
		$this->_validSubmit($info,$detailFunds);   
		$error	=	array(
							'errorStatus'=>$this->errorStatus,
							'error'=>$this->error,
		);
		return $error;
	}
	
	/**
	 * 提交表单验证
	 *
	 * @param array $data
	 * @return array
	 */
	public function validObjectFundsInfo($data){  
		if ($data['step']==1){
			$name	=	'_step1';   
			$this->_validSubmit($data,$name);  
			return ;
		}else{ 
			if ($data['close_out']==2){
				$this->_step2[]	= array("close_out_comments",'require',"require",1);
			}
			$name	=	'_step2';
			$this->_validSubmit($data,$name); 

			$pay_paid_type	= $this->getPayPaidType($data['pay_paid_type']);
			if (!empty($pay_paid_type) && (moneyFormat($data['pay_' . $pay_paid_type . '_money'],1)!=0 || moneyFormat($data['pay_' . $pay_paid_type . '_account_money'],1)!=0 || $this->hasInputFunds($data))){  
				$detailFunds	= '_' . $pay_paid_type;
				$this->_validSubmit($data,$detailFunds);   
			}
			return ;
		}     
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
        	tag($action_tag_name,$this->vdata);
        } 
	}
	 
	
	/**
	 * 列表
	 *
	 * @return unknown
	 */
	public function indexSql(){ 
        if(getUser('role_type')==C('WAREHOUSE_ROLE_TYPE')){
            $warehouse  = ' and warehouse_id in ('.getUser('company_id').',0) ';
        }else{
            if(!empty($_POST['warehouse_id'])){
                $warehouse  = ' and warehouse_id in ('.$_POST['warehouse_id'].',0) ';
            }
        }
        $info['field']	=	' * '.$this->fundsField().' , (money/befor_rate) as befor_money ';
		$info['from']	=	$this->indexTableName?$this->indexTableName:$this->tableName; 
		$this->object_type>0&& 			$object_type[]	= $this->object_type;
		$this->object_type_advance>0&& 	$object_type[]	= $this->object_type_advance; 
		$info['extend']	=	' WHERE  '._search(_search_array(_getSpecialUrl($_GET))).' and object_type in ('.join(',',$object_type).')'.$warehouse.' order by paid_date desc,comp_id asc';
		$sql	= 'select '.$info['field'].' from '.$info['from'].' '.$info['extend'];
		$sql_count	= 'select count(distinct('.$this->indexCountPk.')) as count '.' from '.$info['from'].' WHERE  '._search().' and object_type in ('.join(',',$object_type).')'.$warehouse.' ';
		$list	=	$this->query($sql_count);
		$count	=	(int)$list[0]['count'];
		$info['sql']	=	$sql;
		$info['count']	=	$count;
        $_POST['where'] =   $info['extend'];
		return $info;
	}  
	
	/**
	 * 根据SQL语句获取数据
	 *
	 * @param array $limit
	 * @param array $sql
	 * @return array
	 */
	function indexList($limit,$sql){  
		$list	= _formatList($this->db->query($sql._limit($limit)),ACTION_NAME.'_'.MODULE_NAME); 
		switch (MODULE_NAME){
			case 'ClientFunds':
				$currencyCount	=	C('client_currency_count'); 
				break;
			case 'FactoryFunds':
				$currencyCount	=	C('factory_currency_count');
				break;
			case 'LogisticsFunds':
				$currencyCount	=	C('logistics_currency_count');
				break;		
            case 'WarehouseFunds':
				$currencyCount	=	C('warehouse_currency_count');
				break;
		} 
		///选择币种数量大于1个以上的需要显示币种
		if ($currencyCount>1){
			$currency	=	S('currency'); 
			foreach ((array)$list['list'] as $key=>$row) { 
				$list['list'][$key]['dml_befor_money']	=	'('.$currency[$row['befor_currency_id']]['currency_no'].')'.$row['dml_befor_money'];
				$list['list'][$key]['dml_money']			=	'('.$row['currency_no'].')'.$row['dml_money'];
				$list['list'][$key]['dml_account_money']	=	'('.$row['currency_no'].')'.$row['dml_account_money'];
			}   
		} 
        $expand['sum_group_by']     = array('currency_id','befor_currency_id');
        $list   = _formatList($list['list'],'',1,'',$expand);
		return $list;
	}
	 
	/**
	 *  获取明细信息(用于查看/编辑)
	 *
	 * @param int $id
	 * @return array
	 */
	public function getInfo($id) {
		$rs = $this->field('* '.$this->fundsField().',(money/befor_rate) as befor_money ')->find($id);  
		if (false === $rs || $rs == null) { /// 记录不存在或没权限查看该记录
			halt(L('data_right_error'));
		}			
		///兑换前的币种  
		$rs['before_currency_no']	=	SOnly('currency',$rs['befor_currency_id'],'currency_no'); 
		$info['rs']	=	_formatArray($rs);  
		///显示打包关系
		$paid_for	=	M('paid_for');
		$for_info	=	_formatList($paid_for->field('money as paid_for_money,paid_id,operate_id as for_operate_id')->where('operate_id in ( select operate_id from paid_for where paid_id='.$id.' and to_hide=1  )')->order('operate_id,paid_id')->select()); 
		///判断显示是否有打包关系
		if (is_array($for_info)) {
			///获取所有打包的paid_id
			foreach ((array)$for_info['list'] as $key=>$row) {
					$paid_id[]	=$row['paid_id']; 
			} 
			///获取所有paid_id的信息
			$client			=	M($this->comp_paid_detail);
			$paid_info_list	=	_formatList($client->where(' paid_id in ('.join(',',$paid_id).')')->select());
			$url = C('FLOW_URL');
			foreach ((array)$paid_info_list['list'] as $key=>$row) {  
				$row['dd_object_type']		=	L($row['dd_object_type']);  
				if (isset($url[$row['object_type']])){
					$link_url				= ($row['object_type'] == 102 ? $url[$row['object_type']][$row['relation_type']] : $url[$row['object_type']]).$row['object_id'];
					$row['link']			= U($link_url); 
					$url_arr				= @explode('/',  ltrim($link_url,'/'));
					$row['link_title']		= title($url_arr[1],$url_arr[0]);
				}   
				$paid_info[$row['paid_id']]	=	$row;
			} 
			
			///组合打包信息数据
			foreach ((array)$for_info['list'] as $key=>$row) { 
					$for_list[$row['for_operate_id']][]	=	array_merge($row,$paid_info[$row['paid_id']]); 
			}
			$info['for_list']	=	$for_list;		
		}  
		return $info; 
	}
	 
	/**
	 * 格式化成要插入的数据
	 *
	 * @param array $info
	 * @return array
	 */
	public function setFundsList($info){
		
		///款项令牌验证 
	 	$info['funds']		=	array(	'basic_id'=>$info['basic_id'],
									 	'comp_id'=>$info['comp_id'], 
									 	'currency_id'=>$info['currency_id'],); 
	 	$count_check_info	=	count($info['check_info']);///页面中选中的个数
	 	$object_type_extend	=	0;///object_type_extend 默认为0 1,为指定支付但是没有平账 2为指定支付且平账 3为总平账包括厂家对账
	 	if ($info['close_out']==2){ 
			if ($count_check_info>0){ 
				$paid_for	=	$info['check_info'];
				$object_type_extend	=	2;
			}else{
				$object_type_extend	=	3;
			}
	 	}else{
	 		if ($count_check_info>0){ 
	 			$paid_for			=	$info['check_info'];
	 			$object_type_extend	=	1;///指定支付
	 		}
	 	}    
	 	
		///格式化页面来的信息	 
		$paid_info	=	$this->formatAdvance($info);   
		return $paid_info;
	}
	  
	/**
	 * 厂家款项
	 *
	 * @param array $info 页面中传递来的数据
	 * @return array $vo
	 */
	public function _fund($info){    
		///款项令牌验证 
	 	$info['funds']		=	array(	'basic_id'=>$info['basic_id'],
									 	'comp_id'=>$info['comp_id'], 
									 	'currency_id'=>$info['currency_id'],
                                        'warehouse_id'=>$info['warehouse_id'],); 
	 	$count_check_info	=	count($info['check_info']);///页面中选中的个数
	 	$object_type_extend	=	0;///object_type_extend 默认为0 1,为指定支付但是没有平账 2为指定支付且平账 3为总平账包括厂家对账
 
	 	if ($info['close_out']==2){ 
			if ($count_check_info>0){ 
				$paid_for	=	$info['check_info'];
				$object_type_extend	=	2;
			}else{
				$object_type_extend	=	3;
			}
	 	}else{
	 		if ($count_check_info>0){ 
	 			$paid_for			=	$info['check_info'];
	 			$object_type_extend	=	1;///指定支付
	 		}
	 	}    
		///格式化页面来的信息	 
		$paid_info	=	$this->formatAdvance($info);   
		///插入新预付款信息
		foreach ((array)$paid_info as $key=>$row) { 
			$row['object_type_extend']	= $object_type_extend; 
			$paid_id					= $this->_saveFunds($row);   
			$vo[]						= $paid_id;  
			$paid_for[]					= $paid_id;  
		} 
		
		///判断是否有指定平账目
		if ($info['close_out']==2){ 
			///平帐信息 
			$close_out			=	array('funds'=>$info,'paid_info'=>$paid_for,'object_type_extend'=>$object_type_extend);	 
			$fundsCloseOut		=	$this->CloseOut($close_out); 
			if(is_array($fundsCloseOut) && $fundsCloseOut['id']>0) {
				$paid_for[]	=	$fundsCloseOut['id'];
				///平帐的所有被打包的ID
				if (is_array($fundsCloseOut['extend_paid_id'])){
					$paid_for	=	array_merge($paid_for,$fundsCloseOut['extend_paid_id']);
					$paid_for	=	array_unique($paid_for);///移除重复的paid_id的信息
				} 
			} 
		} 
		
		///打包paid_detail中的信息在paid_for中
		if(count($paid_for)>1 && $object_type_extend>0) { 
			///绑定记录  
 			$insert_paid_for	=	$this->addPaidFor($this->comp_type,$paid_for,$info['currency_id']);
 			if ($object_type_extend>1){
 				///更改paid_detail中指定支付的打包关系记录在OperateId字段当中
 				$this->updateOperateId($insert_paid_for,true,'','( operate_id is null or operate_id="" )'); 
 			} 
		}
		unset($info); 
		return $vo;
	}
	 
	/**
	 * 删除销售单
	 *
	 * @param array(int) $id
	 * @return 删除销售单
	 */
	public function deleteOp($id){ 
		$id=	is_array($id)?$id['id']:$id;
		if ($id<=0){
			return ;
		}
		///判断单据是否有捆绑
		$paid_info	=	$this->where('id='.$id)->find();
 
		///不指定支付
		switch ($paid_info['object_type_extend']){
			case 0:///不指定付款
				///1.删除该笔支付
				$vo	=	$this->_deleteFunds($id);  
				break;
			case 1:///指定支付
				///1.删除指定支付之间的paid_for中包含该paid_id的打包关系的所有打包关系
				///2.删除该笔支付
				
				///删除指定支付之间的paid_for中包含该paid_id的打包关系的所有打包关系
				$this->_deletePaidFor($id);
				///删除该笔支付
				$vo	=	$this->_deleteFunds($id);   
				break;	
			case 2:
				///指定支付平帐
				///1.删除平帐损失
				///2.删除绑定关系
				///3.删除该笔支付	
				$operate_id	=	$paid_info['operate_id']; 
				if (!empty($operate_id)){
					$close_paid_id 	= $this
							->where('operate_id=\''.$operate_id.'\' and comp_type='.$this->comp_type.' and object_type='.$this->object_type_close_out.' and to_hide=1')
							->getField('id');  
					$paid_for		=	M('PaidFor');
					$paid_for_list	=	$paid_for->where('to_hide=1 and operate_id=\''.$operate_id.'\'')->select();
					///删除paid_for中打包的关心
					$this->_deleteOperatePaidFor($operate_id); 
					///删除paid_detail打包关系
					$this->updateOperateId($paid_for_list,false);	 	 
					///删除平帐损失
					$this->_deleteFunds($close_paid_id);
				}
				///删除该笔支付
				$vo	=	$this->_deleteFunds($id); 
				break;		
			case 3:
				///不指定总平帐
				///1.删除平帐损失
				///2.删除绑定关系
				///3.删除该笔支付 
				$operate_id	=	$paid_info['operate_id'];
				$is_close	=	$paid_info['is_close'];
				if (!empty($operate_id)){ 
					$paid_for		=	M('PaidFor');
					$paid_for_list	=	$paid_for->where('to_hide=1 and operate_id=\''.$operate_id.'\'')->select();
					///删除paid_for中打包的关心
					$this->_deleteOperatePaidFor($operate_id);  
					///删除paid_detail打包关系
					$this->updateOperateId($paid_for_list,false,$paid_info['object_type_extend'],' operate_id=\''.$operate_id.'\'');	 
					///删除总平IS_CLOSE打包记录	
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
	 * 不指定总平
	 *
	 * @param array $info
	 * @return array
	 */
	public function CloseOut($info){ 
		return Funds($info,$this->object_type_close_out);
	} 
	
	/**
	 * 获取款型指定可选择信息
	 *
	 * @param array $info 页面中post的值
	 * @return array
	 */
	public function getCheckFundsInfo($info){
		$Model 		  =	 M($this->comp_paid_detail); 
		$list 		  =  _formatList($Model->where('basic_id='.$info['basic_id'].' and comp_id='.$info['comp_id'].' and currency_id='.$info['currency_id'].' and need_paid<>0 and state=1 and is_close=0 ')->order('object_type asc,paid_date asc')->select());   
		$linkModel	=	D('AbsStat');
 		foreach ((array)$list['list'] as $key=>$row) {
 			$object_type	=	$row['object_type'];
 			$object_type_nb	=	$this->comp_type*100; 
 			if ($object_type==($object_type_nb+1)) {
 				///期初
 				$fund['Ini'][]	=	$row;
 			}elseif (in_array($object_type,array($object_type_nb+20))){
 				///应付款OR应收款
 				$row	=	$linkModel->objectTypeCommentSubsidiary($row); 
 				$fund['sale'][]	=	$row;
 			}elseif (in_array($object_type,array($object_type_nb+2,$object_type_nb+29))){
 				///其它应付款OR其它应收款
				if ($object_type == 102) {//added by jp 20140526
					$row	=	$linkModel->objectTypeCommentSubsidiary($row); 
				}
 				$fund['other'][]	=	$row;
 			}elseif (in_array($object_type,array($object_type_nb+24))){
 				///要合并的退货款记录
 				$row	=	$linkModel->objectTypeCommentSubsidiary($row); 
 				$fund['return'][]	=	$row;
 			}else{
 				$row	=	$linkModel->objectTypeCommentSubsidiary($row); 
 				///要合并的付款记录
 				$fund['funds'][]	=	$row;
 			}
 		}
		return $fund;
	}
	
	
	/**
	 * 厂家款项信息
	 *
	 * @param array $info
	 * @return array
	 */
	public function getAccountInfo($info){ 
		extract($info);  
		if ($comp_id>0 && $basic_id>0 && $currency_id>0 && $comp_type>0&&$warehouse_id>0) {  
			$model	=	M($this->comp_paid_detail);
			$funds['is_account_money']		=	2;///默认未有未确认款项
			///欠款
			$funds['money']			=	$model->where('comp_id='.$comp_id.' and basic_id='.$basic_id.' and currency_id='.$currency_id.' and warehouse_id='.$warehouse_id.' and need_paid<>0 and is_close=0 ')->getField('sum(need_paid*income_type*-1) as money');
			///未发货金额 
			$funds['account_money']	=	$model->where('comp_id='.$comp_id.' and basic_id='.$basic_id.' and currency_id='.$currency_id.' and warehouse_id='.$warehouse_id.' and state=0 and is_close=0 ')->getField('sum(original_money*income_type*-1) as money'); 
			if ($funds['account_money']>0) {
				$funds['is_account_money']		=	1;
			}  
			$funds	=	_formatArray($funds); 
		} 
		return $funds;
	}
	
	
	/**
	 * 插入前的验证
	 *
	 * @param array $info
	 * @return array
	 */
	public function checkInsert($info){ 
		return $this->checkFundsInsert($info); 
	}
	 
	/**
	 * 删除前的款项验证
	 *
	 * @param array $info 数组中应包含被删除款项表中的id 已经 comp_type
	 * @param string $type
	 * @return array
	 */
	public function checkDelete($info,$type='array'){   
		return $this->checkFundsDelete($info,$type); 
	}
	
}