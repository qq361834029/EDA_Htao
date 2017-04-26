<?php

/**
 * 仓库信息管理
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category    基本信息
 * @package   Action
 * @author     jph
 * @version  2.1,2014-01-17
 */

class WarehousePublicAction extends BasicCommonAction {
	public $_asc 			=  true;  	//默认排序
	public $_sortBy 		=  'w_no';  //默认排序字段
	public $_default_post	=  array('query'=>array('to_hide'=>1));  //默认post值处理
	public $_default_format	=  array('dd'=>array('basic_id'=>'basic'),'format_date'=>false);  //_formatArray需要格式化的数组
	public $_cacheDd		=  array(6);  
	protected $_old_w_no;//更新前仓库编号
	//自动编号  
	public $_setauto_cache	= 'setauto_warehouse_no';//编号对应超管配置中的值
	public $_auto_no_name	= 'w_no';		 //编号no 
	
	public function _initialize() {
		parent::_initialize(); 
		$userInfo	=	getUser(); 
		if ($userInfo['role_type']==C('SELLER_ROLE_TYPE')) {//卖家
			$_POST['query']['is_use'] = 1;
			$this->assign("is_factory", true);
		}
        if($_POST['is_return_sold']!=C('NO_RETURN_SOLD')){
            $_POST['relation_warehouse_id'] = 0;
        }
	}
	
	public function _after_insert(){ 
    	$this->setIsDefault();//如果是默认仓库,取消其他仓库的默认状态
		parent::_after_insert();
	}
	
	
	public function _before_update() {
		//更新前的仓库编号（用于判断是否更新库位）
		$this->_old_w_no	= M('Warehouse')->where('id=' . $_POST['id'])->getField('w_no');
	}
	
	public function _after_update(){
		$this->setIsDefault();//如果是默认仓库,取消其他仓库的默认状态
		if ($this->_old_w_no != M('Warehouse')->where('id=' . $this->id)->getField('w_no')) {//更新所属仓库,更新条形码中的仓库编号
			$where	= 'l.warehouse_id=' . $this->id;
			A('WarehouseLocation')->updateBarcodeNo($where);
		}		
		parent::_after_update();
	}
	
	 /// 如果是默认仓库,取消其他仓库的默认状态
	public function setIsDefault(){ 
		//如果是默认仓库,取消其他仓库的默认状态
		if($_POST['is_default']==1){
			//获取当前Action名称
		 	$name = $this->getActionName();
	 		//获取当前模型
			$model 	= D($name);   
			$id		= $this->id;
			if ($id>0) { 
				$condition 	= 'id<>'.$id;  
				$list	=	$model->where($condition)->setField('is_default',2);
			}
		} 
	}
	public function _before_index(){
  		getOutPutRand();
  	}	 
    public function edit() {
        $id   = intval($_GET['id']);
        if($id > 0){
            $this->assign('exist_sale_order',M('sale_order')->where('warehouse_id='.$id)->count());
        }
        parent::edit();
    }
}