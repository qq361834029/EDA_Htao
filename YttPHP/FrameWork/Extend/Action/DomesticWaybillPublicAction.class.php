<?php 

/**
 * 国内运单
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category   	国内运单
 * @package  	Action
 * @author    	YYH
 * @version 	2.1,2015-05-06
*/

class DomesticWaybillPublicAction extends RelationCommonAction {
	
	public function __construct() { 
    	parent::__construct(); 
//		$userInfo	=	getUser();
//		if ($userInfo['role_type']==C('WAREHOUSE_ROLE_TYPE')){//仓储
//			$w_id	= intval($userInfo['company_id']);
//			$_POST['detail']['query']['warehouse_id'] = $w_id;
//			if ($w_id > 0) {
//				$this->assign("w_id", $w_id);
//				$this->assign("w_name", SOnly('warehouse',$w_id, 'w_name'));		
//			}				
//		}
		$this->assign('sid',session_id());
		$this->assign('file_tocken',md5(time()));
	}

	public function _autoIndex($temp_file=null) { 
		$this->action_name = ACTION_NAME;
    	$model 			   = $this->getModel();
		$list			   = $model->index();
        $warehouse         = S('warehouse');
        foreach($list['list'] as &$val){
            $warehouse_id_arr   = array_unique(explode(',', $val['warehouse_id']));
            foreach($warehouse_id_arr as $key=>$v){
                if($key==0){
                    $val['warehouse_no']    .=  $warehouse[$v]['w_no'];
                }else{
                    $val['warehouse_no']    .=  ';'.$warehouse[$v]['w_no'];
                }
            }
        }
    	$this->list		   = $list;
		$this->displayIndex($temp_file);
	}  
    public function selectProduct(){   
        $keys   = array('product_id', 'location_id');
        foreach ($keys as $key) {
            if (array_key_exists($key, $_GET)) {             
                $data[$key] = $_GET[$key];
            }
        }       
        $data['quantity']   = array('gt',0);   
        $data['_string']    = 'is_return_sold=2';
        $list   = M('storage')->alias('s')->field('s.id,s.product_id,sum(s.quantity) as quantity,p.product_no,p.product_name')->join('inner join __WAREHOUSE__ w ON s.warehouse_id = w.id inner join __PRODUCT__ p ON s.product_id = p.id')->where($data)->group('s.product_id')->select();                                  
        if($list==NULL){
          echo "库存为零！";            
        }else{
        $this->assign('list',$list);
        C('SHOW_PAGE_TRACE',false);
        $this->display('select_product');
        }
    }          
}
?>