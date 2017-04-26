<?php 

/**
 * 发货入库
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category   	发货入库
 * @package  	Action
 * @author    	yyh
 * @version 	20141119
*/

class ReturnSaleOrderStoragePublicAction extends RelationCommonAction {
	
	public function __construct() { 
        foreach ($_POST['detail'] as $key=>$val){
            if(empty($val['quantity'])||$val['quantity']<=0){
                unset($_POST['detail'][$key]);
            }
        }
    	parent::__construct(); 
        $userInfo	=	getUser();
        if(isset($_GET['id'])){
            $w_id   = M('return_sale_order_storage')->where('id='.(int)$_GET['id'])->getField('warehouse_id');
        }
        if (getUser('role_type')==C('SELLER_ROLE_TYPE')) {
			$_POST['main']['query']['factory_id']   = intval(getUser('company_id'));
			if (getUser('company_id') > 0) { 
				$this->assign("fac_id", getUser('company_id'));
				$this->assign("fac_name", SOnly('factory',getUser('company_id'), 'factory_name'));		
			}	
		}elseif (getUser('role_type')==C('WAREHOUSE_ROLE_TYPE')) {
			$_POST['return_sale_order_detail']['query']['warehouse_id'] = intval(getUser('company_id'));
		}
        foreach($_POST['detail'] as $val){
                //只有location_id有值时才添加到数组中   edit by lxt 2015.06.30
                if (!empty($val['location_id'])){
                    $location_id[$val['location_id']]      = $val['location_id'];
                }
            }
        if(count($location_id) > 0){//有库位才进行查询  edit by lxt 2015.06.30
            $location           = M('location')->where('id in ('.  implode(',',$location_id).')')->getField('id,warehouse_id');//按实际库位存入不用仓库
            foreach($_POST['detail'] as &$val){
                    $val['warehouse_id']    = empty($location[$val['location_id']])?0:$location[$val['location_id']];
            }
        }
        //特殊处理提醒条件st      add by lxt 2015.09.24
        if (isset($_GET['factory_id'])){
            $_POST['main']['query']['factory_id']   =   $_GET['factory_id'];
            $_POST['temp']['factory']               =   SOnly('factory',$_GET['factory_id'], 'factory_name');
        }
        if (isset($_GET['only_pic'])){
            $_POST['main']['query']['only_pic']     =   $_GET['only_pic'];
        }
        
        $this->assign('w_id',$w_id);
        $this->assign('sid',session_id());
		$this->assign('file_tocken',md5(time()));
        //包装完整时清空包装和包装数量
        if($_POST['outer_pack']!=C('CHANGE_PACK')){
            $_POST['outer_pack_id'] = '';
            $_POST['outer_pack_quantity'] = '';
        }
        if($_POST['within_pack']!=C('CHANGE_PACK')){
            $_POST['within_pack_id']= '';
            $_POST['within_pack_quantity'] = '';
        }
        $this->assign('rand',md5(time()));
	}
    public function _before_index(){
        getOutPutRand();
    }

	public function _autoIndex($temp_file=null) { 
        
        if($_GET['to_create_time']){
            $_POST['state_log']['date']['needdate_to_create_time']	= $_GET['to_create_time'];
            $_POST['set_post']['query']['is_out_batch'] = $_GET['is_out_batch'];
            $_POST['main']['query']['factory_id']       = C('CAINIAO_FACTORY_ID');
            $_POST['temp']['factory']                   = SOnly('factory',C('CAINIAO_FACTORY_ID') ,'factory_name').','.SOnly('factory',C('CAINIAO_FACTORY_ID') ,'comp_email');
        }
		$this->action_name = ACTION_NAME;
    	$model			   = $this->getModel();
    	$list			   = $model->index();
		if($list['list']){
			$table_str_start = '<table frame=void width="100%" border="0" cellspacing="0" cellpadding="0"><tbody>';
			$table_str_end   = '</tbody></table>';
			foreach((array)$list['list'] as $val){
				$return_sale_order_id[$val['id']] = $val['id'];
			}
			//取订单明细产品数量
			if($return_sale_order_id){
				$return_sale_order_detail = M('return_sale_order_detail');
				$sql	= 'SELECT a.id,b.product_id,b.quantity,c.quantity as in_quantity
							FROM return_sale_order_storage as a
                            RIGHT JOIN return_sale_order_detail b on a.return_sale_order_id=b.return_sale_order_id
                            LEFT JOIN return_sale_order_storage_detail as c on a.id=c.return_sale_order_storage_id AND b.product_id=c.product_id
							WHERE a.id in ('.implode(',',$return_sale_order_id).') group by c.id';
				$info	 = $return_sale_order_detail->query($sql);
				$q_data	 = array();
				foreach((array)$info as $q_v){
					$q_data[$q_v['id'].'_'.$q_v['product_id']]['quantity'] += $q_v['quantity'];
                    $q_data[$q_v['id'].'_'.$q_v['product_id']]['in_quantity'] += $q_v['in_quantity'];
				}	
			}
			foreach($list['list'] as &$val){
				if(getUser('role_type')==C('SELLER_ROLE_TYPE')){
					if(in_array($val['return_sale_order_state'], explode(',',C('SELLER_CAN_EDIT_RETURN_STATE')))){
						$val['is_del']    = 1;
						$val['is_update'] = 1;
					}else{
						$val['is_del']    = 0;
						$val['is_update'] = 0;
					}
				}elseif($_SESSION[C('SUPER_ADMIN_AUTH_KEY')] !== true){
					$val['is_del']		  = 1;
				} 
				
				$val['product_detail_info'] = '';
				if($val['p_ids']){		
					$tmp = explode(',',$val['p_ids']); 
					foreach((array)$tmp as $v){
						$p_info	= SOnly('product',$v);
						if($p_info){
							$tmp_p_key = $val['id'].'_'.$v;
                            if ($q_data[$tmp_p_key]['quantity'] > 0) {
                                empty($q_data[$tmp_p_key]['in_quantity']) && $q_data[$tmp_p_key]['in_quantity']=0;
                                $val['product_detail_info'] .= '<tr>' .
                                        '<td class="t_center" width="15%" style="border:0px">' . $v . '</td>' .
                                        '<td class="t_center" width="20%" style="border:0px">' . $p_info['product_no'] . '</td>' .
                                        '<td class="t_center" width="15%" style="border:0px">' . $p_info['product_name'] . '</td>' .
                                        '<td class="t_center" width="20%" style="border:0px">' . $q_data[$tmp_p_key]['quantity'] . '</td>' .
                                        '<td class="t_center" width="20%" style="border:0px">' . $q_data[$tmp_p_key]['in_quantity'] . '</td>' .
                                        '</tr>';
                            }
                        }
					} 
				}
				$val['product_detail_info']&&$val['product_detail_info']=$table_str_start.$val['product_detail_info'].$table_str_end;
			}
		}
		$this->list	= $list;
        if(getUser('role_type')==C('WAREHOUSE_ROLE_TYPE')){
            $is_return_sold = M('warehouse')->where('id='.getUser('company_id'))->getField('is_return_sold');
        }
        $this->assign('is_return_sold',$is_return_sold);
		$this->displayIndex($temp_file);
	}
    public function add(){
        $return_sale_order_id           = (int)$_GET['id'];
        $return_sale_order_storage_id   = M('ReturnSaleOrderStorage')->where('return_sale_order_id='.$return_sale_order_id)->getField('id');
        if(!empty($return_sale_order_storage_id)){
            $rs     = D('ReturnSaleOrderStorage')->getInfoReturnSaleOrderStorage($return_sale_order_storage_id);
        }else{
            $rs     = D('ReturnSaleOrder')->getInfoReturnSaleOrder($return_sale_order_id);
        }
        $this->assign('rs',$rs);
    }
    public function _after_add() {
        $temp_file = empty($this->_Member) ? ACTION_NAME : $this->_Member . ACTION_NAME;
        $this->display($temp_file);
    }
    public function delete() {
		$this->id	=	intval($_GET['id']);
		if ($this->id > 0) {  
			$model	= $this->getModel(); 
			if (D('returnSaleOrderStorage')->storageDelete($this->id)===false){ 
				if ($model->error_type==1){
					$this->error ( $model->getError(),$model->errorStatus);	
				}else{
					$this->error (L('_ERROR_'));
				} 
			}  
		} else {
			$this->error(L('_ERROR_ACTION_'));
		}
    }
    public function update() {
        if(empty($_POST['id'])){
            D('ReturnSaleOrderStorage')->returnStorageInsert($_POST,true);
            D('ReturnSaleOrder')->updateReturnStateById($_POST['return_sale_order_id']);
        }else{
            parent::update();
        }
    }
    //处理操作、删除操作st  add by lxt 2015.09.07
    public function deal(){
        $id	=	intval($_GET['id']);
        if ($id > 0) {
            ///获取当前Action名称
            $name = $this->getActionName();
            ///获取当前模型
            $model 		= D($name);
            $this->id	= $id;
            $model->setId($id);
            $this->rs	= $model->edit();
            $model->cacheLockVersion($this->rs);
        } else {
            $this->error(L('_ERROR_ACTION_'));
        }
    }
    //
    public function _after_deal(){
        $temp_file	=	empty($this->_Member)?ACTION_NAME:$this->_Member.ACTION_NAME;
        $this->display($temp_file);
    }
    //
    public function updateDeal(){
        $this->id	=	intval($_POST['id']);
        if ($this->id > 0) {
            $model	= $this->getModel();
            startTrans();
            if ($model->relationUpdate()===false){
				rollback();
                if ($model->error_type==1){
                    $this->error ( $model->getError(),$model->errorStatus);
                }else{
                    $this->error (L('_ERROR_'));
                }
            }else{
				commit();
			}
        } else {
            $this->error(L('_ERROR_ACTION_'));
        }
    }
    //
    public function _after_updateDeal(){
        $this->success(L('_OPERATION_SUCCESS_'));
    }
    //
    public function deleteDeal(){
        $this->id	=	intval($_GET['id']);
        if ($this->id > 0) {
            $model	= D('ReturnSaleOrderStorage');
            startTrans();
            if ($model->deleteDeal($this->id)===false){
				rollback();
                if ($model->error_type==1){
                    $this->error ( $model->getError(),$model->errorStatus);
                }else{
                    $this->error (L('_ERROR_'));
                }
            }else{
				commit();
			}
        } else {
            $this->error(L('_ERROR_ACTION_'));
        }
    }
    //
    public function _after_deleteDeal(){
        $this->success(L('_OPERATION_SUCCESS_'));
    }
}
?>