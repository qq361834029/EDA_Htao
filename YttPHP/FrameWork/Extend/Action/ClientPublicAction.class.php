<?php
/**
 * 买家信息管理
 * @copyright   2012 展联软件友拓通
 * @category   	基本信息
 * @package  	Action
 * @version 	2014-01-15
 * @author    	jph
 */
class ClientPublicAction extends BasicCommonAction {
	
	//默认post值处理
	protected 	$_default_post	=  array('query'=>array('to_hide'=>1)); 
	//默认where条件 
  	protected 	$_default_where	=  ''; 
  	//需要更新的缓存字典 
//  	protected 	$_cacheDd		=  array(14);  //客户数据量太大，已改成读取数据库方式 仍可以用S('client')读取客户数据 by jph 20140911
  	
  	public		$_sortBy		= 'comp_no';
  	//自动编号 
	public 		$_setauto_leng	= 10;
	//编号对应超管配置中的值
	public 		$_setauto_cache	= 'setauto_client_no';	
	//编号no
	public 		$_auto_no_name	= 'comp_no';	

	 public function __construct() { 
    	parent::__construct(); 
    	if (getUser('role_type')==C('SELLER_ROLE_TYPE')) {//角色类型为卖家类型
			$_POST['query']['factory_id'] = intval(getUser('company_id'));
		}
        if(ACTION_NAME == 'insert'){
            $max_no = intval(D('Client')->order($this->_auto_no_name.' desc')->getField($this->_auto_no_name))+1;
            $leng	=	$this->_setauto_leng>0?$this->_setauto_leng:3;
            $max_no	=	str_pad($max_no,$leng,'0',STR_PAD_LEFT); ;
            $_POST['comp_no']   = $max_no;
        }
    }
	
	public function add() {
    	///自动补上编号
//    	$this->_autoMaxNo();
		$userInfo	=	getUser(); 
		if ($userInfo['company_id'] > 0) {
			$this->assign("fac_id", $userInfo['company_id']);
			$this->assign("fac_name", SOnly('factory',$userInfo['company_id'], 'factory_name'));		
		}		
    }
	
	public function index() {	
	 	$name = $this->getActionName();
	 	if ($this->_view_model===true){
	 		$name	=	$name.'View';
	 	}  	
		$model 	= 	D($name);      
		///条件
		$opert	=	array('where'=>_search($this->_default_where,$this->_default_post),'sortBy'=>$this->_sortBy);
		///格式化+获取列表信息   
		$_formatListKey	= ACTION_NAME.'_'.MODULE_NAME; 
		$list	= $this->_listAndFormat($model,$opert,$_formatListKey);
		if (in_array(MODULE_NAME, C('MERGE_ADDRESS_MODULE'))) {//added by jp 20140115
			_mergeAddress($list);
		}
	
		if(is_array($list['list'])&&$list['list']){
			foreach ($list['list'] as $key=>$val) {
				$client_id[] = $val['id'];
			}
			$sale_order		 = M('sale_order');
			$sale_order_ids  = array();
			$sale_order_ids  = $sale_order->group('client_id')->where('client_id in (' . implode(',', $client_id) . ')')->getField('id,client_id');
			foreach($list['list'] as $k=>$v){
				$list['list'][$k]['is_del'] = in_array($v['id'], $sale_order_ids)?0:1;
			}
		}

		//pr($list,'',1);
		///assign
		$this->assign('list',$list);
		///display
		$this->displayIndex();
	}	

	public function delete(){ 
		$name	= $this->getActionName(); 
		$model 	= D($name);    
		$pk		= $model->getPk ();
		$id 	= intval($_REQUEST[$pk]);
		if ($id>0) { 
			$SaleOrder  = M('SaleOrder');
			$count      = $SaleOrder->where('client_id='.$id)->count(); ///总个数
			if(intval($count)>0){
				throw_json(L('client_exist_sale_order'));
			}

			$condition 	= $pk.'='.$id; 
			$list		= $model->where($condition)->delete();
			$this->id	= $id;   
			///如果删除操作失败提示错误
			if ($list==false) {
				$this->error(L('data_right_del_error'));
			}
		}else{
			$this->error(L('_ERROR_'));
		} 
    }
	
	public function _before_index(){
		getOutPutRand();
	}
	//新城市增加
	public function _before_insert() {
		if($_POST['country_id']&&$_POST['city_name']){	
			$data['parent_id']     = $_POST['country_id'];
			$data['district_name'] = $_POST['city_name'];
			$District			   = D('District');  
			$info				   = $District->create($data);
			if (false !== $info) {  
				$city_id		   = $District->add($info);
				cacheDd(2, $city_id);
				$_POST['city_id']  = $city_id;
			}  	
		}
	}
}