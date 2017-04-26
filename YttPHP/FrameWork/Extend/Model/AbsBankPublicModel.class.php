<?php 
/**
 * 款项抽象类
 * @copyright   Copyright (c) 2006 - 2013 Top Union 展联软件友拓通
 * @category   	账目信息
 * @package  	Model
 * @author    	何剑波
 * @version 	2.1,2013-07-22
 */

class AbsBankPublicModel extends RelationModel {
	/// 关联ID
	protected $relation_id		= 0;
	/// 关联类型值
	protected $relation_type	= 0;
	/// 模块名称
	protected $module_name		= null; 
	/// 规格配置字段
	protected $storge_field		= array();
	/// 库存表名
	protected $trueTableName 	= 'bank_center';
	///列表查询的表的名字
	public $indexTableName		=	''; 
	///列表查询的表的合计distinct对应的值
	public $indexCountPk		=	'id'; 
	 
							
	/**
	 * 列表方法
	 */
	
	/**
	 * 列表
	 *
	 * @return array
	 */
	public function indexSql(){ 
		$info['field']	=	' * ';
		$info['from']	=	$this->indexTableName?$this->indexTableName:$this->tableName;
		$info['extend']	=	' WHERE  '._search().$this->fundsWhere().' order by delivery_date ';
		$sql	= 'select '.$info['field'].' from '.$info['from'].' '.$info['extend']; 
		$count	=	0;
		$sql_count	= 'select count(distinct('.$this->indexCountPk.')) as count '.' from '.$info['from'].' WHERE  '._search().$this->fundsWhere().' ';
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
		isset($this->bank_object_type)	&&	$where[]	=	' bank_object_type='.$this->bank_object_type;
		if (is_array($where)){
			$str	=	' and '.join(' and ',$where);
		}
		return $str;
	}

	/**
	 * 默认的where条件
	 *
	 * @return unknown
	 */ 
	
	/**
	 * 获取列表
	 *
	 * @return array
	 */
	public function index(){
		$sql			= ACTION_NAME.'Sql';
		$_sql			= $this->$sql();
		$_limit			= _page($_sql['count']);
		return $list	= $this->indexList($_limit,$_sql['sql']);
	}

	/**
	 * 根据SQL语句获取数据
	 *
	 * @param $limit
	 * @param $sql
	 * @return array
	 */
	function indexList($limit,$sql){ 
		$list	= _formatList($this->db->query($sql._limit($limit))); 
		//pr($list,'total');
		return $list;
	}
	
							
	/**
	 * 初始化与调用规则
	 */ 
	
	/**
	 * 默认补充基础数据信息
	 *
	 * @param array $info
	 */
	public function _beforeFund(&$info){ 
		isset($this->bank_object_type)	&&	$info['bank_object_type']	=	$this->bank_object_type;  
	} 
	
	/**
	 * 插入银行款项信息
	 *
	 * @param array $info
	 * @return array
	 */
	public function _fund($info){  
		$vo		= $this->_saveFunds($info);
		return $vo;
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
	 	///默认补充基础数据信息
	 	$this->_beforeFund($info); 
	 	///执行银行款项信息
	 	$info	=	$this->$function($info);
	 	/// 执行后置操作
	 	if (method_exists($this,'_after'.ucfirst($function))) {
	 		call_user_func(array($this,'_after'.ucfirst($function)));
	 	}
	 	return $info;
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
			->where('object_id='.$id.' and bank_object_type='.$this->bank_object_type.' and to_hide=1')
			->select());  
			return $info;
		}
	}
	
	 
	/**
	 * 获取款项信息
	 * 
	 */
	public function _paidInfo($id){
		if ($id>0){
			return	$this->where('id='.intval($id))->find();	 
		}
	} 
	
	
	/**
	 * 操作公用方法
	 */ 
	
	/**
	 * 款项类工具方法
	 */  
	  
	 
	/**
	 * 验证公告方法
	 */ 
	 
	
 	
 	/**
	 * 初始化与调用规则
	 */
	 
	 
	 /**
	  * 保存款项信息
	  *
	  * @param array $info
	  */
	 public function _saveFunds($info){
	 	///如果有银行ID 并且 币种未空 自动根据银行币种补充信息
	 	if(!isset($info['currency_id']) && $info['bank_id']>0 ) { 
	 		$info['currency_id']	=	SOnly('bank_currency',$info['bank_id'],'currency_id');
	 	}
	 	///如果没有币种默认给予本位币~!(转回国内使用)
	 	if (empty($info['currency_id'])){
	 		$info['currency_id']	=	C('currency');
	 	}
		if (empty($this->paid_object_type)){
			$this->paid_object_type = 1004;
		}
		$info['paid_object_type']	= $this->paid_object_type;
	 	
	 	if ($info['id']>0 && isset($info['id'])){
			return $this->_updateFunds($info);
		}else{   
			$bank_id = $this->_insertFunds($info); 
			return $bank_id;
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
	 * 款项日记
	 *
	 * @param string $type
	 * @param array $info
	 * @param int $id
	 * @return array
	 */
	private function addFundsLog($type='insert',$info,$id){
		$bank_object_type = C('BANK_OBJECT_LANG');
		if (!in_array($info['bank_object_type'],array(3,2,5)) || ($info['bank_object_type'] == 5 && $info['income_type'] == -1)){//edited by jp 20131211 (add ",5" and " || ($info['bank_object_type'] == 5 && $info['income_type'] == -1)")
			return true;
		}
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
		$log .= L('module_'.MODULE_NAME).'，';
		$note .= $bank_object_type[$info['bank_object_type']].L('module_funds').' ';	
		switch ($info['relevance_cash']){
			case 1:
				$note .= L('cash').' ';  
			break;
			case 2:
				$note .= L('bank').' ';  
			break;
			case 3:
				$note .= L('bill').' ';  
			break;		
		} 
		
		switch ($info['income_type']){
			case 1:
				$note .= L('income').' ';  
			break;
			default:
				$note .= L('outlay').' ';  
			break;
		}  
		///日期
		$note .= $info['delivery_date'].' ';  
		///币种
		$note .= SOnly('currency',$info['currency_id'],'currency_no').' ';  
		///银行
		if ($info['bank_id']>0){
			$note .= L('bank_name').':'.SOnly('bank',$info['bank_id'],'bank_name').' ';  	
		} 	 
		///金额
		$note .= L('money').':'.moneyFormat($info['money'],0,C('MONEY_LENGTH')).' ';
		Log::insertLog($note,MODULE_NAME,ACTION_NAME);
	}
	  
	 /**
	  * 插入款项信息
	  *
	  * @param array $info
	  * @return array
	  */
	private function _insertFunds($info){  
		///模型验证  
		if (false === $this->create($info,'',false)) {    
			halt($this->getError());
		}    
		///保存POST信息->返回主表ID 
		$id		=	$this->add();  
		if ($id!==false) { ///保存成功 
			$this->addFundsLog('insert',$info,$id);
			return	$id;  
		} else {   
			///失败提示  
			halt($this->getError());
		} 
	}
	
	/**
	 * 更新款项信息
	 *
	 * @param array $info
	 * @return array
	 */
	private function _updateFunds($info){
		if ($this->create($info,'',false)) {	 		
	 		$r = $this->save();
	 		if (false === $r) {
	 			halt($this->getError());
	 		}	
	 		return $info['id'];
	 	} else {
	 		halt($this->getError());
	 	}
	}
	
	/**
	 * 删除款项信息
	 *
	 * @param int $id
	 * @return array
	 */
	private function _deleteToHideFunds($id){  
	 	if (is_int($id)){
			$condition 	= 'id='.$id;   
		}elseif (is_array($id)){
			$condition 	= 'id in ('.join(',',$id).') ';  
		}elseif (is_string($id) && !empty($id)){
			$condition 	= 'id in ('.$id.') ';  
		}else{
			return false;
		}  
		$list		=	$this->where($condition)->delete();      
		///如果删除操作失败提示错误
		if ($list===false) {  
			halt($this->getError('删除银行信息出错'));
		}else{
			$info = M($this->trueTableName.'_del')->find($id);
			$this->addFundsLog('delete',$info,$id);
		}
		return true; 
		
	 }
	  
	 
	/**
	 * 操作公用方法
	 */
	
	/**
	 * 删除款项
	 *
	 * @param int $id 银行中心ID
	 * @return array
	 */
	public function deleteOp($id){  
		if($id>0) { 
			$vo	=	$this->_deleteFunds($id); 
			return $vo; 
		} 
	} 
	
	/**
	 * 获取银行编号
	 *
	 * @param string $bank_object_type
	 * @param string $fix
	 * @param array $date
	 * @return array
	 */
	public function getBankNo($bank_object_type,$fix,$date){
		
			if($bank_object_type>0 && !empty($fix) && !empty($date)) {
				$value['prefix']	=	$fix;
				$flow_no_field		=	'bank_no';
				/// 操作自身不可覆盖当前属性直接取值，欧洲格式转为中国格式后生成单号
				$no_date 		= formatDate($date,'mg_date');   
				$sql = 'select max('.$flow_no_field.') as no from '.$this->trueTableName.' 
							where left('.$flow_no_field.',8)=\''.$value['prefix'].$no_date.'\' and bank_object_type='.$bank_object_type;  
				$temp_no = mysql_fetch_array(mysql_query($sql),MYSQL_ASSOC); 
				$last_no = $temp_no['no']; 
				if (empty($last_no)) {
					$last_no = $value['prefix'].$no_date.'0001';
				}else {
					$last_no = str_replace($value['prefix'],'',$last_no); 
					$last_no += 1; 
					$last_no =	$value['prefix'].$last_no;
				}
	        }  
		return $last_no;
	} 
	
}
?>