<?php  

class ComplexOrderPublicAction extends RelationCommonAction {

	public function __construct(){
		parent::__construct(); 
		$this->assign('sid',session_id());
		$this->assign('file_tocken',md5(time()));
		if (getUser('role_type')==C('SELLER_ROLE_TYPE')) {
			$_POST['sale_order']['query']['factory_id'] = intval(getUser('company_id'));
		}
	}
	//删除发货操作
	public function setState(){
		$model   = D('SaleOrder');
		$pk	     = $model->getPk();
		$id      = intval($_REQUEST[$pk]);
		$state   = intval($_REQUEST['state']);
		if ($id>0) { 
			//主表
			//$list		  = $model->where('id='.$id)->setField(array('out_stock_type'=>0)); 
			//明细表
			$count		  = $model->where('id='.$id.' and sale_order_state not in ('.C('SALE_ORDER_OUT_STOCK').')')->count();
			//echo $model->getLastSql();exit;
			if(intval($count)>0){
				throw_json(L('cant_out_stock_delete'));
			}

			$detail_model = M('sale_order_detail');
			$list		  = $detail_model->where('sale_order_id='.$id)->setField(array('real_quantity'=>0,'state'=>$state)); 
			$this->id     = $id;
			if ($list==false) {
				$this->error(L('_OPERATION_WRONG_'));
			}
			$this->success(L('_OPERATION_SUCCESS_')); 
		}else{
			$this->error(L('_ERROR_'));
		} 
	}

	//列表
	public function _autoIndex($temp_file=null) { 
		//复合订单处理查询
		$_POST['sale_order']['morethan']['out_stock_type']       = 2; //复合订单 大于等于2
        $_POST['sale_order']['in']['sale_order_state']    = C('SALE_ORDER_OUT_STOCK');  
		$_POST['sale_order_detail']['morethan']['real_quantity'] = 1; 

		$this->action_name = ACTION_NAME;
    	$model			   = D('SaleOrder');	
    	$list			   = $model->index();
		if($list['list']){
			$userInfo		 = getUser();
			$table_str_start = '<table frame=void width="100%" border="0" cellspacing="0" cellpadding="0"><tbody>';
			$table_str_end   = '</tbody></table>';
			foreach($list['list'] as $key=>&$val){
				$sale_order_id[$val['id']] = $val['id'];
			}
			//取订单明细产品数量
			if($sale_order_id){
				$sale_order_detail	= M('sale_order_detail');
				$sql	 = 'SELECT *
							FROM sale_order_detail
							WHERE sale_order_id in ('.implode(',',$sale_order_id).')';
				$info	 = $sale_order_detail->query($sql);
				if($info){
					foreach($info as $q_v){
						$q_key = $q_v['sale_order_id'].'_'.$q_v['product_id'];
						if(!isset($q_data[$q_key])){
							$q_data[$q_key] = $q_v['quantity'];
						}else{
							$q_data[$q_key] += $q_v['quantity'];
						}
						if(!isset($r_data[$q_key])){
							$r_data[$q_key] = $q_v['real_quantity'];
						}else{
							$r_data[$q_key] += $q_v['real_quantity'];
						}
					}
				}
			}
			//取快递方式明细
			$express_model	= M('express');
			$sql = 'select b.express_id,b.id,b.price,b.weight_begin,b.weight_end,b.step_price,b.registration_fee	
					from express a 
					left join express_detail b
					on a.id=b.express_id
					left join warehouse c
					on a.warehouse_id=c.id
					where b.is_express=1 and c.is_use=1 and a.status=1';
			$express_list_data = $express_model->query($sql);
			if($express_list_data){
				foreach($express_list_data as $e_k=>$e_v){
					$e_key = $e_v['express_id'].'_'.$e_v['id'];
					$e_data[$e_key] = $e_v;
				}
			}
			
			foreach($list['list'] as $key=>&$val){
				//复合订单不进行修改，删除
				$list['list'][$key]['is_del']	 = 0;
				$list['list'][$key]['is_update'] = 0;
	
				$list['list'][$key]['product_detail_info'] = '';
				if($val['p_ids']){		
					$tmp = explode(',',$val['p_ids']);
					if(is_array($tmp)&&count($tmp)>0){
						foreach($tmp as $k=>$v){
							$p_info						   = SOnly('product',$v);
							if($p_info){
								$tmp_p_key = $val['id'].'_'.$v;
								$list['list'][$key]['product_detail_info'] .= '<tr>'.
									'<td class="t_center" width="10%" style="border:0px">'.$v.'</td>'.
									'<td class="t_center" width="20%" style="border:0px">'.$p_info['product_no'].'</td>'.
									'<td class="t_center" width="20%" style="border:0px">'.$p_info['product_name'].'</td>'.
									'<td class="t_center" width="10%" style="border:0px">'.$q_data[$tmp_p_key].'</td>'.	
									'<td class="t_center" width="10%" style="border:0px">'.$r_data[$tmp_p_key].'</td>'.	
									'</tr>';
							}
						}
					}
				}
				if($list['list'][$key]['product_detail_info']){
					$list['list'][$key]['product_detail_info'] = $table_str_start.$list['list'][$key]['product_detail_info'].$table_str_end;
				}
			}
		}
		$this->list	= $list;
		$this->displayIndex($temp_file);
	}  
}
?>