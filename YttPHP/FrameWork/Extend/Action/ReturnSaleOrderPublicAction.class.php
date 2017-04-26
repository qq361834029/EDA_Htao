<?php 

/**
 * 退换货管理
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category    销售
 * @package   Action
 * @author     何剑波
 * @version  2.1,2012-07-22
 */

class ReturnSaleOrderPublicAction extends RelationCommonAction {

	public function __construct(){
		parent::__construct(); 
		$this->assign('sid',session_id());
		$this->assign('file_tocken',md5(time()));
		if (isset($_GET['w_id'])) {
			$_POST['return_sale_order_detail']['query']['warehouse_id']	= $_GET['w_id'];
			$_POST['temp']['warehouse_name_use']			= SOnly('warehouse', $_GET['w_id'], 'w_name');
		}
		if (isset($_GET['factory_id'])) {
			$_POST['main']['query']['factory_id']			= $_GET['factory_id'];
			$_POST['temp']['factory']						= SOnly('factory',$_GET['factory_id'], 'factory_name');
		}	
		//提醒的退货日期特殊处理         add by lxt 2015.09.24
		if (isset($_GET['return_order_date'])){
		    $_POST['main']['date']['needdate_from_return_order_date'] =   $_GET['return_order_date'];
		}	
		if (isset($_GET['lt_return_order_date'])){
		    $_POST['main']['date']['lt_return_order_date']    =   $_GET['lt_return_order_date'];
		}
//        if(!in_array($_POST['return_reason'], C('CHECK_PACK_RETURN_REASON'))){
//            $_POST['outer_pack']    = '';
//            $_POST['within_pack']   = '';
//        }
        //包装完整无需记录包装
        if($_POST['outer_pack']!=C('CHANGE_PACK')){
            $_POST['outer_pack_id'] = '';
        }
        if($_POST['within_pack']!=C('CHANGE_PACK')){
            $_POST['within_pack_id']= '';
        }
       if( !in_array($_POST['return_sale_order_state'], array(C('PROCESS_COMPLETE'),C('DROPPED')))){
           $_POST['returned_date'] = '';
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
		///默认post值处理
		if(!$_POST['main']['query']['return_sale_order_state'] && ACTION_NAME != 'remind'){
			$_POST['main']['query']['return_sale_order_state'] = isset($_GET['return_sale_order_state']) ? $_GET['return_sale_order_state'] : 9;
		}
        $_POST['user']['like']['if(real_name="",user_name,real_name)'] = $_POST['user']['like']['real_name'];
        unset($_POST['user']['like']['real_name']);
	}

	///退货列表
	public function alistReturnOrder(){
		$this->_autoIndex('index');
	}
	///换货列表
	public function alistSaleOrder(){
		$this->_autoIndex('index');
	}
    
    public function _after_insert() {//add yyh 20140113 上传图片
        $info['id']	=	$this->id; 
		if(!empty($_POST['file_tocken'])){
			D('Gallery')->update($this->id,$_POST['file_tocken']);//更新产品图片关联信息
		}
		//退货物流单条形码        add by lxt 2015.09.01
		$this->generateBarcode();
		if($type){
			if($this->_trans == true){
				commit();
				$this->_trans_commit = true;
			}
			return true;
		}else{
            if($_POST['submit_type'] == 4){
                $_POST['out_stock_type']    = TRUE;
				$printInfo					= $this->getPrintInfo();
                $this->success(L('_OPERATION_SUCCESS_'),'',array('status'=>1,'href'=>U('/ReturnSaleOrder/add/'),'title'=>title(ACTION_NAME,'ReturnSaleOrder'), 'module_name' => MODULE_NAME, 'printInfo' => $printInfo));
            }else{
                parent::_after_insert();
            }
        }
    }
    //更新后重新生成退货物流单条形码       add by lxt 2015.09.01
    public function _after_update(){
        $this->generateBarcode();
        if($_POST['submit_type'] == 4){
			$_POST['out_stock_type']    = TRUE;
			$printInfo					= $this->getPrintInfo();
            $this->success(L('_OPERATION_SUCCESS_'),'',array('status'=>1,'href'=>U('/ReturnSaleOrder/edit/','id='.$this->id),'title'=>title(ACTION_NAME,'ReturnSaleOrder'), 'module_name' => MODULE_NAME, 'printInfo' => $printInfo));
        }else{
            parent::_after_update();
        }
    }

	public function  getPrintInfo(){
		$info       =   D('ReturnSaleOrder')->relation(true)->find($this->id);
		$htmlInfo   = $this->returnLogisticsNoLabel($info);
		$printInfo	= array(
						'size'	=> array(
								'width' => '120mm',
								'height' => '90mm'
							),
						'info'	=>$htmlInfo
					);
		return $printInfo;
	}

	public function _before_index(){
        getOutPutRand();
    }

    public function _autoIndex($temp_file=null) { 
		$this->action_name = ACTION_NAME;
    	$model			   = $this->getModel(); 	
    	$list			   = $model->index();   
		if($list['list']){
			$table_str_start = '<table frame=void width="100%" border="0" cellspacing="0" cellpadding="0"><tbody>';
			$table_str_end   = '</tbody></table>';
			foreach((array)$list['list'] as $val){
				$return_sale_order_id[$val['id']] = $val['id'];
			}
			if($return_sale_order_id){
				//取订单明细产品数量
				$return_sale_order_detail = M('return_sale_order_detail');
				$sql	 = 'SELECT return_sale_order_id,product_id,quantity
							FROM return_sale_order_detail
							WHERE return_sale_order_id in ('.implode(',',$return_sale_order_id).')';
				$info	 = $return_sale_order_detail->query($sql);
				$q_data	 = array();
				foreach((array)$info as $q_v){
					$q_data[$q_v['return_sale_order_id'].'_'.$q_v['product_id']] += $q_v['quantity'];
				}	 
                //
				$storage_info   =   M('ReturnSaleOrderStorageDetail')->where('return_sale_order_id in('.join(',',$return_sale_order_id).')')->group('return_sale_order_id')->getField('return_sale_order_id,sum(quantity) as quantity');
				//取额外费用(服务费用)
                $return_sale_order_detail_service   = M('return_sale_order_detail_service')->where('return_sale_order_id in ('.implode(',',$return_sale_order_id).')')->group('return_sale_order_id')->getField('return_sale_order_id,sum(price)');
            }
            
			foreach($list['list'] as &$val){
                $val['return_service_price']    = $return_sale_order_detail_service[$val['id']];
				$val['is_del']					= $model->checkDelete($val['id'], $val['return_sale_order_state']);
				$val['is_update']				= $model->checkEdit($val['id'], $val['return_sale_order_state'], $storage_info[$val['id']]['quantity']);
				$val['product_detail_info'] = '';
				if($val['p_ids']){		
					$tmp = explode(',',$val['p_ids']); 
					foreach((array)$tmp as $v){
						$p_info	= SOnly('product',$v);
						if($p_info){
							$tmp_p_key = $val['id'].'_'.$v;
							$val['product_detail_info'] .= '<tr>'.
								'<td class="t_center" width="10%" style="border:0px">'.$v.'</td>'.
								'<td class="t_center" width="30%" style="border:0px">'.$p_info['product_no'].'</td>'.
								'<td class="t_center" width="30%" style="border:0px">'.$p_info['product_name'].'</td>'.
								'<td class="t_center" width="10%" style="border:0px">'.$q_data[$tmp_p_key].'</td>'.	  
								'</tr>';
						}
					} 
				}
				$val['product_detail_info']&&$val['product_detail_info']=$table_str_start.$val['product_detail_info'].$table_str_end;
				//
				if (isset($storage_info[$val['id']]) && !$storage_info[$val['id']]['quantity']){
				    $val['can_storage'] =   true;
				}
			}
		}
		$this->list	= $list;
		$this->displayIndex($temp_file);
	}  
	
	/**
	 * 退货提醒(按仓库统计及状态)
	 * @author jph 20140804
	 */
	public function remind(){
		///获取当前Action名称
		$name		= $this->getActionName();
 		///获取当前模型
		$model		= D($name);
		$this->rs	= $model->getReturnSaleOrderStat();
		
		$url		= 'ReturnSaleOrder/index';
		if ($_POST['main']['query']['factory_id'] > 0) {
			$url	.= '/factory_id/' . $_POST['main']['query']['factory_id'];
		}
		$show		= array();
		$td			= array('value'=>'w_name','title'=>L('warehouse_name'), 'total_title'=> 'title','link'=>array('url'=>$url,'link_id'=>array('w_id'=>'warehouse_id', 'return_sale_order_state'=>-2)));
		//仓库名称
		if (getUser('role_type') != C('WAREHOUSE_ROLE_TYPE')) {
			$show[]		= $td;
		}
		
		//各种状态列
		foreach (C('RETURN_SALE_ORDER_STATE') as $state=>$state_name) {
			$td['value']										= 'dml_state_sum_' . $state;
			$td['title']										= $state_name;
			$td['link']['link_id']['return_sale_order_state']	= 'state_' . $state;
			$td['total_title']									= $td['value'];//列合计字段
			$show[]												= $td;
		}
        
		//行合计
		$td['value']										= 'dml_state_sum';
		$td['title']										= L('sum_quantity');
		$td['link']['link_id']['return_sale_order_state']	= -2;
		$td['total_title']									= $td['value'];//列合计字段
		$show[]												= $td;
		$this->show											= $show;
		if ($this->rs['list']) {//页面合计
			$this->all_total	= array($this->rs['total']);
		}

		$tpl_name											= $_POST['search_form'] ? 'remind_list' : 'remind';
		$this->display($tpl_name);
	}
	//生成退货物流单条形码       add by lxt 2015.09.01
	public function generateBarcode(){
	    $id    =   $this->id;
	    $model =   'ReturnSaleOrder';
	    $path  =   BARCODE_PATH . ucfirst($model);
	    $code  =   M($model)->where('id='.$id)->getField('return_logistics_no');
	    $name  =   array(
	        'name' =>  $id,
	        'code' =>  $code,
	    );
	    $barcode_config		= array(
	        'w'            =>  215,
	        'h'            =>  70,
	        'thickness'    =>  40,
	    );
	    createBarcodeImg($name, $path, $barcode_config,array(),2);
	}
	//
	public function returnLogisticsNoLabel($info){
	    $html  =   '
	        <div>
	        <div sytle="margin:auto;position:relative;font-family:Arial,sans-serif;">
	           <div id="top_return_logistics_no" style="margin-left:0.5pt;margin-top:10.5pt;height:10.5pt"><strong>Return LP:'.$info['return_logistics_no'].'</strong></div>
	           <div id="barcode" style="margin-left:0.5pt;height:52.5pt"><img src="'.BARCODE_PATH . 'ReturnSaleOrder/' . $info['id'] . '.' . C('BARCODE_PC_TYPE').'"></div>
               <div style="margin-left:0.5pt">
                   <div style="font-size:16pt"><strong>From:'.$info['addition']['country_name'].'</strong></div>
                   <div style="font-size:10.5pt">Return Order:'.$info['order_no'].'</div>
               </div>
               <div style="margin-left:0.5pt">
                   <div style="font-size:10.5pt">'.$info['factory_addition']['consignee'].'</div>
                   <div style="font-size:10.5pt">'.$info['factory_addition']['mobile'].'</div>
                   <div style="font-size:10.5pt">'.$info['factory_addition']['address'].'</div>
                   <div style="font-size:10.5pt">'.$info['factory_addition']['address2'].'</div>
               </div>
	        </div>
            </div>
	        ';
	    return $html;
	}
}