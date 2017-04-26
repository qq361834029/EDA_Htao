<?php
/**
 * 产品类别管理
 * @copyright   2011 展联软件友拓通
 * @category   	基本信息
 * @package  	Action 
 */
class ProductClassPublicAction extends BasicCommonAction {
	
	protected $_cacheDd 		=  array('16'); //更新的Dd
	protected $_default_format	=  array('dd'=>array('parent_id'=>'product_class'));  //_formatArray需要格式化的数组 
	public $_setauto_cache		= 'setauto_productclass_no';//编号对应超管配置中的值
	public $_auto_no_name		= 'class_no';		 //编号no 
	 
	
	public function _before_index(){
		$expand	= C('PRODUCT_CLASS_LEVEL')==1?'':'true';
		$this->assign('expand',$expand);
		getOutPutRand();
	} 
	
	public function index(){ 
		//获取当前Action名称
	 	$name 		= MODULE_NAME.'View';  
 		//获取当前模型
		$model 		= D($name);    
		$to_hide 	= intval($_POST['stohide']);
		empty($to_hide) && $_POST['stohide'] = '1'; 
		$list	=	_formatList(_list($model,$model->getIndex()));  
		$this->assign('list',$list);
		//display
		if ($_POST['search_form']) {
			$this->display ('list');
		}else {
			$this->display();
		}
	}
	
	//修改
	public function edit() {
		//产品自动编号
		$this->_autoMaxNo();	
		//获取当前Action名称
	 	$name = $this->getActionName();
 		//获取当前模型
		$model 	= D($name);   
		//模型ID
		$id 	= 	intval($_REQUEST[$model->getPk()]);  
		if ($id>0) {
			if (method_exists($model,'getInfo')) {
				$vo = _formatArray($model->getInfo($id),$this->_default_format);  
			}else{
				$vo = _formatArray($model->getById($id),$this->_default_format);  
			}
			if ($vo['parent_id']>0){ 
				$vo['parent_name']	= SOnly('product_class', $vo['parent_id'], 'class_name');
			} 
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
	
	 
}