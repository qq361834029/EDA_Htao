<?php
/**
 * RelationCommonModel
 * @copyright   Copyright (c) 2006 - 2013 TOP UNION 展联软件友拓通
 * @category   	账目信息
 * @package  	Model
 * @author    	何剑波
 * @version 	2.1,2013-07-22
 */

class RelationCommonModel extends RelationModel {
	
	public $Mdate	=	array(); 
	
	protected $_list_limit = true;
	
	/**
	 * 列表
	 *
	 * @param string $action_name
	 * @return array
	 */
	public function index($action_name){ 
		$action_name	= $action_name?$action_name:ACTION_NAME;
		$sql			= $action_name.'Sql';  
		$_sql			= $this->$sql(); 
		$_formatListKey	= ACTION_NAME.'_'.MODULE_NAME.'_'.__CLASS__.'_'.__FUNCTION__; 
		return _formatList($this->query($_sql),$_formatListKey);  
	}
	
	/**
	 * 根据sql语句返回相应的数组
	 *
	 * @param array $limit
	 * @param string $sql
	 * @return array
	 */
	function indexList($limit,$sql){  
		$_formatListKey	= ACTION_NAME.'_'.MODULE_NAME.'_'.__CLASS__.'_'.__FUNCTION__; 
		if ($this->_list_limit == true) {
			$list = _formatList($this->db->query($sql._limit($limit)),$_formatListKey);  
		}else {
			$list = _formatList($this->db->query($sql),$_formatListKey);  
		}
		
		return $list;
	}
	
	
	/**
	 * 流程验证
	 *
	 * @param array $data
	 * @return array
	 */
	public function ValidDetailInfo($data){  
		$name	=	'_validDetail';
		return $this->_validSubmitDetail($data,$name);   
	} 
	
	/**
	 * 流程产品验证
	 *
	 * @param array $data
	 * @param string $dateKey
	 * @return array
	 */
	public function _validBeforDate(&$data,$dateKey){
		$module_name	= $data['module_name'] ? $data['module_name'] : MODULE_NAME;
		$temp			=	'temp';
		//特殊处理验证两个明细的地方需要重新调整$temp对应的值的product_no验证
		if ($module_name=='ReturnSaleOrder'){
			if ($dateKey=='sale'){ 
				$temp	=	'temp2';
			}   
		}  
		if (empty($dateKey)){ return $data;}  
		$first = null;  
		foreach ((array)$data[$dateKey] as $key=>$value){ //循环验证明细  			
			switch ($module_name) {
				case 'Shipping':
					if (!empty($value['area']) || !empty($value['country_id'])) {//派送方式有选择国家的明细不过滤 added by jp 20140303
						continue 2;//跳出嵌套switch的foreach需要加2
					}
					break;
				case 'Instock':
					if ($dateKey == 'box' && !empty($value['box_no'])) {//头程发货有箱号的明细不过滤 added by jp 20140310
						continue 2;//跳出嵌套switch的foreach需要加2
					}
					break;
				case 'ReturnService':
					if (!empty($value['item_number'])) {//退货服务有项目编号的明细不过滤 added by jp 20140310
						continue 2;//跳出嵌套switch的foreach需要加2
					}	
					break;
                case 'Factory':
                    if(!empty($value['warehouse_id']) || !empty($value['express_discount'])){//卖家快递折扣明细不过滤 added by yyh 20140923
						continue 2;//跳出嵌套switch的foreach需要加2
                    }
                    break;
                case 'WarehouseFee':
                    //仓储费明细不过滤added by yyh  20150817
                    if(!empty($value['warehouse_id'])){
                        continue 2;
                    }
					break;
                case 'PackBox':
                    if(!empty($value['return_sale_order_id'])){
                        continue 2;
                    }
					break;
                case 'OutBatch':
                    if(!empty($value['pack_box_id'])){
                        continue 2;
                    }
					break;
                case 'Cost':
                    if(!empty($value['shipping_cost_name'])){//快递成本明细不过滤 added by yyh 20140923
                        continue 2;//跳出嵌套switch的foreach需要加2
                    }
					break;
                case 'DomesticShippingFee':
                case 'ProcessFee':
                case 'ReturnProcessFee':
                    if (!empty($value['weight_begin']) || !empty($value['weight_end']) || !empty($value['price'])){//退货处理奋勇明细不过滤    add by lxt 2015.06.15
                        continue 2;//跳出嵌套switch的foreach需要加2
                    }
					break;
				default:
					break;
			}	
			if (empty($value['product_id']) && empty($data[$temp][$key]['product_no']) && empty($data[$temp][$key]['product_name']) ){   //发票配置为不显示产品号时 只有产品名称
				if (empty($first) && $key>0 && MODULE_NAME != 'WarehouseFee'){
					$first	=	$key; 
					continue;
				}  
				unset($this->vdata[$dateKey][$key]);  //验证直接post后的数据
				unset($data[$dateKey][$key]);  
			}
            if($module_name == 'Product'){
                if (empty($value['quantity']) && empty($value['product_son_id']) && empty($data[$temp][$key]['product_no']) && empty($data[$temp][$key]['product_name']) ){   //发票配置为不显示产品号时 只有产品名称
                    if (empty($first) && $key>0){
                        $first	=	$key; 
                        continue;
                    }
                    unset($this->vdata[$dateKey][$key]);  //验证直接post后的数据
                    unset($data[$dateKey][$key]);  
                }
            }else{
                if (empty($value['product_id']) && empty($data[$temp][$key]['product_no']) && empty($data[$temp][$key]['product_name']) ){   //发票配置为不显示产品号时 只有产品名称
                    if (empty($first) && $key>0){
                        $first	=	$key; 
                        continue;
                    }  
                    unset($this->vdata[$dateKey][$key]);  //验证直接post后的数据
                    unset($data[$dateKey][$key]);  
                }
            }
            if($module_name =='InstockStorage' && empty($value['in_quantity'])){
                if (empty($first) && $key>0){
					$first	=	$key; 
					continue;
				}  
				unset($this->vdata[$dateKey][$key]);  //验证直接post后的数据
				unset($data[$dateKey][$key]);  
            }
		}     
		if (count($data[$dateKey])>1 && !empty($first)){	
			unset($this->vdata[$dateKey][$first]); //验证直接post后的数据
			unset($data[$dateKey][$first]); 
		}
		return $data;
	}
	
	
	/**
	 * 对入库信息格式化
	 *
	 * @return array
	 */
	public function setPost(){
		$this->Mdate	=	$_POST; 
		return $_POST;
	}
	
	/**
	 * 更新验证
	 *
	 * @return bool
	 */
	public function checkInsert(){
		return true;
	}
	
	/**
	 * 更新验证
	 *
	 * @return bool
	 */
	public function checkEdit(){
		return true;
	}
	
	/**
	 * 更新验证
	 *
	 * @return bool
	 */
	public function checkUpdate(){
		return true;
	}
	
	/**
	 * 删除验证
	 *
	 * @return bool
	 */
	public function checkDelete(){
		return true;
	}
	
	/**
	 * 业务规则验证
	 *
	 */
	public function _brf(){ 
		// 业务规则检查
        $all_tags 	 	= C('extends');
        $action_tag_name = $this->_module.'^'.$this->_action;
        if (isset($all_tags[$action_tag_name])) {
        	// 添加关联类的模块信息
			$_POST['_module'] = $this->_module;
			$_POST['_action'] = $this->_action;
        	tag($action_tag_name,array_merge($_GET,$_POST));
        } 
	}
	
	/**
	 * 前置操作
	 *
	 * @param array $info
	 * @return array
	 */
	function _beforeModel($info){ 
		return true; 
	} 
	
	/**
	 * 后置操作
	 *
	 * @param array $info
	 * @param string $action_name
	 * @return array
	 */
	function _afterModel($info,$action_name=''){
		return true;
	}
	
	/**
	 * 关联insert
	 *
	 * @return array
	 */
	public function relationInsert(){ 
		//重新组合POST来的信息 
		$info	= $this->setPost();
		//模型验证 
		if ($this->create($info)) {	  
			$this->_brf();
			if($this->_beforeModel($info) === false){//不能使用$this去更新数据，因为会引起$this->data变化，造成后面关联保存出错
				$this->error_type	= 1;
				return false;
			}
			$id = $this->relation(true)->add();   
			if (false === $id) {
				$this->error_type	=	2;
				return false; 
			}	 
			$this->id	=	$id;  
			empty($info) ? $_POST['id'] = $id : $info['id'] = $id; 
			$this->_afterModel($info); 
			$this->execTags($info);   
		} else {     
			$this->error_type	=	1; 
			return false; 
		} 
	}
	
	/**
	 * tags执行
	 *
	 * @param array $info
	 */
	public function execTags($info){
		$tag_name = $this->_module;
		if (empty($info)) {
			$info = $_POST;
		} 
		// 添加关联类的模块信息
		$info['_module'] = $this->_module;
		$info['_action'] = $this->_action;
		tag($tag_name,$info); //标签  
	} 
	 
	/**
	 * 保存编辑操作
	 *
	 * @return array
	 */
	public function relationUpdate() { 
		$info	=	$this->setPost();
	 	if ($this->create($info)) {	
		 		$this->_brf();
	 			$this->id	=	$info['id'];
				if($this->_beforeModel($info) === false){//不能使用$this去更新数据，因为会引起$this->data变化，造成后面关联保存出错
		 			$this->error_type	= 1;
		 			return false;
				}
		 		$r = $this->relation(true)->save();
		 		if (false === $r) {
		 			$this->error_type	=	2;
		 			return false;
		 		}
		 		$this->_afterModel($info); 
		 		$this->execTags($info);
	 	} else {
	 		$this->error_type	=	1;
			return false;  
	 	}
	 }
	
	
	/**
	 * 删除订货信息
	 *
	 * @param int $id
	 * @param string $module
	 */
	public  function relationDelete($id,$module=null) { 
			$this->_brf(); 
			$this->id = $id;
			//$relation = array('detail');			
			// 删除操作
			$info = array('id'=>$id);
			if($this->_beforeModel($info) === false){
				$this->error_type	= 1;
				return false;
			}
			
			$r = $this->relation(true)->delete($id); 
			if (false === $r) {
				halt($this->getError());
			}
			
			$info['id']	=	$this->id;
			$module && $info['method_name'] = $module;
			$this->_afterModel($info,'delete'); 
			$this->execTags($info);   	
	} 
	
	/**
	 * 规格
	 *
	 * @param string $fix
	 * @return string
	 */
	public function getStockStandard($fix=''){
		$str	='	count(distinct '.$fix.'product_id) as product_qn,'.$this->getQuantity($fix).' ';
		return $str;
	}
	
	/**
	 * 获取当前通用规格的sql(列表)
	 *
	 * @param string $fix
	 * @param bool $sum
	 * @param bool $discount
	 * @return string
	 */
	public function getQuantity($fix='',$sum=true,$discount=false){
		$sum_field	=	$sum==true?'sum':'';
		$str	='	
					'.$sum_field.'('.$fix.'quantity) as sum_qua,
					'.$sum_field.'('.$fix.'quantity) as sum_quantity,
					'.$sum_field.'('.$fix.'real_quantity) as sum_real_quantity,
					'.$sum_field.'('.$fix.'quantity*'.$fix.'price) as money '; 
		return $str;
	}
	
	/**
	 * 获取当前通用规格的sql(明细)
	 *
	 * @param string $fix
	 * @param bool $sum
	 * @param bool $discount
	 * @return string
	 */
	public function getQuantityDetail($fix='',$sum=false,$discount=false){
		$sum_field	=	$sum==true?'sum':'';
		$str	='	
					'.$sum_field.'('.$fix.'quantity) as sum_qua,
					'.$sum_field.'('.$fix.'quantity) as sum_quantity, 
					'.$sum_field.'('.$fix.'quantity*'.$fix.'price) as money '; 
		return $str;
	}
	/**
	 * 
	 * 箱数验证 是否可输入小数
	 * @param unknown_type $data
	 */
	public function validQuantity($data){
		$quantity_format	= C('quantity_format');
		foreach($data['detail'] as $key=>$val){
			$sum	= Floatval($val['quantity'])*Floatval($val['capability']);
			if($quantity_format==2){
				if(intval($sum)!=$sum){
					$error['name']	= 'detail['.$key.'][quantity]';
					$error['sum']	= intval($sum).'__'.$sum;
					$error['value']	= L('quantity_format_error');
					$this->error[] = $error;	
				}
			}elseif(intval($val['quantity'])!=$val['quantity']){
				$error['name']	= 'detail['.$key.'][quantity]';
				$error['value']	= L('quantity_format_error');
				$this->error[] = $error;	
			}
		}
	}

	public function validDetailProdcut($data){ 
		foreach($data['detail'] as $key=>$val){
			if($val['product_id']){
				$data['aaaabbbb']=1;
			}
		}
		return $this->_validSubmit($data);
	
	}
        
    
    public function editStateUpdateValid($info = array()) {
		return true;
	}
    
	public function editStateUpdate(){
        $info   = $_POST;
        unset($info['old_instock_type']);
        tag(MODULE_NAME.'^'. $info['method_name'], $info);   
		$result	= $this->save($info);   	
		if (false !== $result) {
            $this->setModuleInfo(MODULE_NAME, $info['method_name']);
            $info[$info['state_name']]    = $info['state_value'];
			$this->execTags($info);
		}
		return $result;
	}
}
?>