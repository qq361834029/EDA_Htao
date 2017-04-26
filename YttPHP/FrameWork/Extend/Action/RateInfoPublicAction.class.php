<?php
/**
 +------------------------------------------------------------------------------
 *	汇率列表
 +------------------------------------------------------------------------------
 * @copyright   2011 展联软件友拓通
 * @category   	基本信息
 * @package  	Action 
 +------------------------------------------------------------------------------
 */
class RateInfoPublicAction extends BasicCommonAction {
	 
	
	
	//列表
	public function index() {	 
		//获取当前Action名称
	 	$name = $this->getActionName(); 
 		//获取当前模型
		$model 	= D($name);      
		//条件
		$opert	=	array('where'=>_search($this->_default_where,$this->_default_post));
		//格式化+获取列表信息  
		$list			=	$this->_listAndFormat($model,$opert);   
		$currencyDd		=	S('currency'); 
		foreach ((array)$list['list'] as $key=>$value) {
		 	$list['list'][$key]['to_currency_no']	=	$currencyDd[$value['to_currency_id']]['currency_no'];
		 	$list['list'][$key]['currency_no']		=	$currencyDd[$value['from_currency_id']]['currency_no'];
		}  
		//assign
		$this->assign('list',$list);
		//display
		$this->displayIndex();
	}

	
	 //修改
	public function edit() {
		//自动补上编号
    	$this->_autoMaxNo();
		//获取当前Action名称
	 	$name = $this->getActionName();
 		//获取当前模型
		$model 	= D($name);   
		//模型ID
		$id 	= 	intval($_REQUEST[$model->getPk()]);  
		if ($id>0) {
			$vo 					= _formatArray($model->getById($id),$this->_default_format);  
			$vo['to_currency_no'] 	= SOnly('currency',$vo['to_currency_id'],'currency_no'); 
			//如果查询结果是空提示错误 
			if (!is_array($vo)) {
				exit(L('data_right_error'));
			} 
			$model->cacheLockVersion($vo);
			$this->rs	=	$vo; 
		}else {
			$this->error(L('_ERROR_'));
		}
		$this->display (); 
	} 

	
	 //更新
	public function update() {
		//获取当前Action名称
	 	$name = $this->getActionName();
 		//获取当前模型
		$model 	= D($name);   
		//主表ID
		$id 	= 	intval($_POST[$model->getPk()]); 
		//模型验证
		if (false === $model->create ($_POST)) {
			$this->error ( $model->getError (),$model->errorStatus);
		}  
		//更新数据
		$list	=	$model->save(); 
		if (false !== $list) {
			$this->id	=	$id; 
		} else { 
			$this->error (L('_ERROR_'));
		}
		
	}	
	
	public function _after_update(){
		$info['id']	=	$this->id;
		tag('rateinfo',$info); 
		parent::_after_update();
	} 
	
	
}