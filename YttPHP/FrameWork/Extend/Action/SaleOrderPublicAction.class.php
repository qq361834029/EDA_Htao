<?php  
/**
 * 销售
 * @copyright   Copyright (c) 2006 - 2013 Top Union 展联软件友拓通
 * @category   	销售信息
 * @package  	Action
 * @author    	何剑波
 * @version 	2.1,2013-07-22
 */

class SaleOrderPublicAction extends RelationCommonAction {

	public function __construct(){
		parent::__construct();
		$this->assign('sid',session_id());
		$this->assign('file_tocken',md5(time()));
		if (getUser('role_type')==C('SELLER_ROLE_TYPE')) {
			$_POST['sale_order']['query']['sale_order.factory_id']   = intval(getUser('company_id'));
			if (getUser('company_id') > 0) {
				$this->assign("fac_id", getUser('company_id'));
				$this->assign("fac_name", SOnly('factory',getUser('company_id'), 'factory_name'));		
			}	
		}elseif (getUser('role_type')==C('WAREHOUSE_ROLE_TYPE')) {
			$_POST['sale_order']['query']['sale_order.warehouse_id'] = intval(getUser('company_id'));
			if (getUser('company_id') > 0) {
				$w_id = getUser('company_id');
				$this->assign("w_id", $w_id);
				$this->assign("warehouse_id", $w_id);
				$this->assign("w_name", SOnly('warehouse',getUser('company_id'), 'w_name'));		
			}	
		}elseif (isset ($_GET['client_id'])) {
			$_POST['sale_order']['query']['client_id']    = intval($_GET['client_id']);
		}
		///默认post值处理
		if(!$_POST['sale_order']['query']['sale_order_state']){
			$_POST['sale_order']['query']['sale_order_state'] = 1;
		}
        
        if(isset($_POST['has_track_no'])){
            switch ($_POST['has_track_no']){//关联追踪单号情况
                case 0:
                    $_POST['sale_order']['is_null']['track_no']         = FALSE;
                    break;
                case 1:
                    $_POST['sale_order']['is_null']['track_no']         = TRUE;
                    break;
            }
            unset($_POST['has_track_no']);
        }
        if(isset($_POST['sale_order']['query']['out_stock_type'])){//订单类型--订单列表
            if($_POST['sale_order']['query']['out_stock_type']==2){
               $_POST['sale_order']['morethan']['out_stock_type'] = $_POST['sale_order']['query']['out_stock_type']; 
               unset($_POST['sale_order']['query']['out_stock_type']);
            }                    
        }
        if(empty($_POST['query']['a.order_type']) or $_POST['query']['a.order_type']==-2){            
            if(isset($_POST['order_type_change'])){
            switch ($_POST['order_type_change']){//是否转仓情况
                case 1:
                    $_POST['query']['a.order_type'] = 5;                        
                    break;
                case 0:                   
                    $_POST['notequal']['a.order_type'] = 5;
                    break;
              }
                 
            }           
        } 
        if(isset($_POST['is_registered'])){ 
            switch ($_POST['is_registered']){//是否挂号情况
                case 0:
                    $_POST['query']['a.is_registered'] = 2;                        
                    break;
                case 1:                   
                    $_POST['query']['a.is_registered'] = 1;
                    break;
            }
        }
        if(isset($_POST['out_stock_type'])){
            switch ($_POST['out_stock_type']){//订单类型--出库
                case 1:
                    $_POST['query']['a.out_stock_type']   = $_POST['out_stock_type'];
                    break;
                case 2:
                    $_POST['morethan']['a.out_stock_type'] = $_POST['out_stock_type'];
                    break;
            }
        }
	}
	
	/**
	 * 后置操作
	 *
	 * @param array $info
	 * @param string $action_name
	 * @return array
	 */
	function _after_update(){
		if (in_array(ACTION_NAME,array('insert','update'))) {
			//暂时取消令牌验证
			C('TOKEN_ON',false);
			$client_info	   = $_POST['addition'][1];
			$client_info['id'] = $_POST['client_id'];
			$client			   = M('Client');
			///更新客户的资料
			///模型验证
			if (false === $client->create ($client_info)) {
				$this->error ( $client->getError (),$client->errorStatus);
			} 
			///更新数据
			$list	=	$client->save();
			if(false === $list){
				$this->error (L('_ERROR_'));
			}
			$this->generateBarcode();
		}	
		//卖家角色修改订单为已作废跳转列表页
		if($_POST['sale_order_state']==C('SALEORDER_OBSOLETE')&&getUser('role_type')==C('SELLER_ROLE_TYPE')){
			$this->success(L('_OPERATION_SUCCESS_'),'',array('status'=>2,'href'=>U('/SaleOrder/view/id/'.$_POST['id']),'title'=>title('view','SaleOrder'))); 
		}
		if($_POST['from_type']=='out_stock'){
			//退出出库中订单队列 added by jp 20160706
			$queue	= S('queue_out_stock_sale_order');
			unset($queue[$this->id]);
			S('queue_out_stock_sale_order', $queue);
			
            $info	= M('saleOrder')->join('a left join express e on a.express_id=e.id')->where('a.id='.$this->id)->field('e.shipping_type, e.company_id, a.sale_order_no, a.Labelurl')->find();
			$_POST	= array_merge($_POST, $info);
            $post	= session('post_SaleOrder_outStock');
			unset($post['query']['p.custom_barcode']);
			unset($post['query']['e.shipping_type']);
            unset($post['query']['a.express_id']);
            unset($post['query']['a.order_type']);
			session('post_SaleOrder_outStock', $post);
			$post['is_gls']	= (in_array($info['company_id'], C('GLS_API_EXPRESS_ID')) && D('Gls')->isUseGlsApi($this->id))?1:0;//is_gls
			$post['id']	= $_POST['id'];//
			$post['mac_address']	= $_POST['mac_address'];//
			$this->success(L('_OPERATION_SUCCESS_'),'',array('status'=>1,'href'=>U('/SaleOrder/outStock/s_r/1'),'title'=>title('outStock','SaleOrder'), 'module_name' => MODULE_NAME, 'printInfo'=>A('Ajax')->getSaleOrderHTML($this->id),'$post' => $post));
		}else{
			$this->success(L('_OPERATION_SUCCESS_')); 
		}
	}
    public function getPrintHtmlITN($data,$is_pdf=false){
        if($data['addition'][1]['country_id'] !=  C('IT_COUNTRY_ID')){
            $country_id     =  $data['addition'][1]['country_name'].' '.SOnly('country',$data['addition'][1]['country_id'], 'abbr_district_name');
        }
        $addition   = M('sale_order_addition')->where('id='.$data['addition'][1]['id'])->select();
        $data['weight'] = M('sale_order')->where('id='.$data['id'])->getField('weight');
        $data   = _formatArray($data);
        $nbsp   = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
        $nbsp2  = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
        $br     = '<br /><br /><br /><br /><br />';
        if(!$is_pdf){
            $nbsp   .= '&nbsp;&nbsp;';
            $nbsp2  .= '&nbsp;&nbsp;';
            $br     .= '<br />';
        }
        $html   =   '
                    <div style="color: #000;">
                        <style type="text/css">
                            span {font-family:Arial,sans-serif;font-weight:bolder;line-height: 10pt;}
                        </style>
                        <br />
                        <span>'.$nbsp.'FROM:EDA ITALY SRL</span><br />
                        <span>'.$nbsp.'(LOGISTICA PER CONTO TERZI)</span><br />
                        <span>'.$nbsp.'VIA SANTA CORNELIA 5/S1</span><br />
                        <span>'.$nbsp.'00060 FORMELLO RM ITALY(peso:'.$data['edml_weight'].'g)</span><br />
                            '.$br.'
                        <span>'.$nbsp2.'TO:'.$data['addition'][1]['consignee'].'<br />
                            <br />
                            <br />
                        <span>'.$nbsp2.$data['addition'][1]['address'].' '.$data['addition'][1]['address2'].'</span><br />
                        <span>'.$nbsp2.$data['addition'][1]['post_code'].'&nbsp;&nbsp;'.$data['addition'][1]['city_name'].'&nbsp;&nbsp;'.$data['addition'][1]['company_name'].'<br />
                        <span>'.$nbsp2.$country_id.'<br />
                    <br />
                    </div>';
        return $html;
    }
    
    public function getPrintHtml($data,$is_pdf=false){
        if(in_array($data['express_id'], array(C('EXPRESS_DPW_ID'),C('EXPRESS_PL-DPW_ID')))) {
            $pdw    = 'warensendung';
        }
        switch ($data['company_id']){
        case C('EXPRESS_IT-POST_ID'):
            $company    = 'EDA ITALY srl   VIA SANTA CORNELIA  5/A S 1   00060 FORMELLO (RM)';
            break;
        case C('MAIL_ES_CORREOS_ID'):
            $company    = 'Eda Warehousing034 S.L，C/Barrio  Estación.53-Pol.Yeles(Toledo) ，45220';
            break;
        case C('EXPRESS_FR_POST_ID'):
        case C('EXPRESS_FR_POST_EXPRESS_ID'):
            $company    = 'Eda Warehousing FR.  34av charles de gaulle(lot45/46) 93240 stains';
            break;
		case  C('EXPRESS_DEUTSCHE_POST_ID'):
			$where['id']=$data['express_id'];
			$shipping_type=M('express')->where($where)->getField('shipping_type');
			if($shipping_type== C('SHIPPING_TYPE_SURFACE')&&$data['warehouse_id']==C('EXPRESS_PL_WAREHOUSE_ID')){
				$company    = 'ABZ Logistics GmbH·Schubertstraße 67·15234 Frankfurt (Oder)';
			}else{
				$company    = 'Eda Warehousing DE. UG Industrie str. 11421107 Hamburg';
			}
			break;
        case C('EXPRESS_ES_CORREOS_ID')://西班牙邮政
			$warehouse	= M('Warehouse')->find(C('EXPRESS_ES_WAREHOUSE_ID'));
            $company    = $warehouse['w_basic_name'] . ' ' . $warehouse['w_address'];
            break;
        default :
            $company    = 'Eda Warehousing DE. UG Industrie str. 11421107 Hamburg';
            break;
        }
        if(!empty($data['addition'][1]['address2'])){
            $data['addition'][1]['address2'].='</br>';
        }
        if(!empty($pdw)){
            $pdw.='</br>';
        }
        if($is_pdf){
            $html   ='<style>span{font-size:7px;text-align:center;"}</style>'
                    . '<br><br><span style="font-size:6px;text-indent:10px;"><u>&nbsp;'.$company.'</u></span><br>
                <span>'.$pdw.'</span><br>
                <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$data['addition'][1]['consignee'].'<br></span>
                <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$data['addition'][1]['address2'].'
                '.$data['addition'][1]['address'].'<br></span>
                <span style="width:10px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$data['addition'][1]['post_code'].'  '.$data['addition'][1]['city_name'].'</span>';
        }else{
            $html   ='<table><tr>	<td><div style="width: 186px;height: 100px;float: left;color: #000; ">
                        <div style="font-family:Arial,sans-serif;text-decoration:underline;text-align:center;margin: 15px 5px 5px 5px;font-size:8px;"><u>'.$company.'</u>
                        </div>               
                        <div style="font-family:Arial,sans-serif;line-height: normal;margin: 0 0 0 25px;text-align: left;font-size:10.5px;">
                            '.$pdw.'
                                '.$data['addition'][1]['consignee'].'</br>
                                '.$data['addition'][1]['address2'].'
                                '.$data['addition'][1]['address'].'</br>
                                '.$data['addition'][1]['post_code'].'  '.$data['addition'][1]['city_name'].'
                        </div>
                    </div>
                    </td>
                    </tr>
            </table>';
        }
        return $html;
    }
	
    public function getPrintHtmlDefault($data,$is_pdf){
		$id	= intval($data['id']);
		if ($id <= 0) return '';
		$sale_order_detail	= _formatList(M('SaleOrderDetail')->field('product_id, sum(quantity) as quantity')->where('product_id>0 and sale_order_id=' . $id)->group('product_id')->getField('product_id, product_id, quantity'));
		foreach ($sale_order_detail['list'] as $val) {
			$prefix				= ($val['quantity'] > 1 ? $val['quantity'] . '*' : '');
			$product[]			= $prefix . $val['product_id'];
			$custom_barcode[]	= $prefix . $val['custom_barcode'];
		}
		$this->generateBarcode($id);
		$src	= BARCODE_PATH . 'SaleOrder/' . $id . '.' . C('BARCODE_PC_TYPE');
		if ($is_pdf) {
			$img	= '<img height="101.25pt" src="'.$src.'">';
		} else {
			$img	= '<img src="'.$src.'?'.time().'">';
		}
		$text	= $data['sale_order_no'] . '<br />
					Attention: For assistance, please contact<br />
					your online vendors.<br />
					' . implode('-', $product);
		if ($data['company_id'] == C('EXPRESS_ES_SUER_ID')) {
			$text	.= '<br />' . implode('-', $custom_barcode);
			$text	.= '<div style="font-family:Arial,sans-serif; font-size:5.4pt; margin: 0px; padding: 0px;">'
							.$data['addition'][1]['consignee'].'<br/>
							'.$data['addition'][1]['address2'].' '.$data['addition'][1]['address'].'<br/>
							'.$data['addition'][1]['post_code'].' '.$data['addition'][1]['city_name'].'<br/>
						</div>';
		}
		return '<div>
				   ' . $img . '<br />
					<table style="font-family:Arial,sans-serif;float: left;color: #000; padding-left:30px;margin-left: 22.5pt;line-height: normal;font-size:8pt; font-weight:bolder;">
						<tr><td>' . $text . '</td></tr>
					</table>
                </div>';
    }
    
    public function _before_index(){
		getOutPutRand();
	}

	//列表
	public function _autoIndex($temp_file=null) { 
		$this->action_name = ACTION_NAME;
    	$model			   = $this->getModel();
    	///格式化+获取列表信息  	
    	$list = $model->index();   
		if($list['list']){
			$table_str_start = '<table frame=void width="100%" border="0" cellspacing="0" cellpadding="0"><tbody>';
			$table_str_end   = '</tbody></table>';
			foreach($list['list'] as $val){
				$sale_order_id[$val['id']]	= $val['id'];
				if($val['delivery_fee_paid_id'] <= 0 && intval($val['express_id'])>0&&intval($val['express_detail_id'])>0){
					$expected_delivery_costs_sale[$val['id']]	= $val['id'];
				}
			}  
            //已删除的订单
            $sale_order_state_arr   = M('state_log')->where('object_type='.array_search('SaleOrder', C('STATE_OBJECT_TYPE')).' and state_id='.C('SALE_ORDER_DELETED').' and object_id in ('.  implode(',', $sale_order_id).')')->group('object_id')->getField('object_id',true);
            //已发货过的
            $sale_order_id_shipped  = M('state_log')->where('object_type='.array_search('SaleOrder', C('STATE_OBJECT_TYPE')).' and state_id='.C('SHIPPED').' and object_id in ('.  implode(',', $sale_order_id).')')->group('object_id')->getField('object_id',true);
            //取订单明细产品数量
			$details				= M('SaleOrderDetail')
										->field('sod.sale_order_id as sale_id,sod.product_id,p.product_no,sum(sod.quantity) as quantity')
										->join('sod left join product p on p.id=sod.product_id')
										->where('sod.sale_order_id in (' . implode(',', $sale_order_id) . ')')
										->group('sod.sale_order_id,sod.product_id')
										->select();
			$product_detail_info	= array();
			foreach ($details as $detail) {
				$product_detail_info[$detail['sale_id']]	.=	'<tr>'.
																	'<td class="t_center" width="10%" style="border:0px">'.$detail['product_id'].'</td>'.
																	'<td class="t_center" width="30%" style="border:0px">'.$detail['product_no'].'</td>'.
																	'<td class="t_center" width="10%" style="border:0px">'.$detail['quantity'].'</td>'.	  
																'</tr>';
				$product_list[$detail['product_id']]			= array('product_id' => $detail['product_id']);
                $product_id_arr[$detail['sale_id']]['detail'][] = array('product_id'=>$detail['product_id'],'quantity'=>$detail['quantity']);
			}
            $product_info	= $model->getProductInfo($product_list);
            foreach($product_id_arr as &$data){
				$data	= $model->getTotalWeightCube($product_info,$data);
            }
			unset($details, $product_info, $product_list);
			//其他费用合计
			$other_fee_total		= D('ClientOtherArrearages')->getOtherFeeTotal($sale_order_id);
			//附件信息
			$relation_id = 'relation_type ='.C('DOWNLOAD_FILE_TYPE').' and relation_id in (' . implode(',', $sale_order_id) . ')';
			$gallery_list = M('gallery')->where($relation_id)->getField('relation_id', true);				

			//预计快递费用
			if ($expected_delivery_costs_sale) {
				$field						= 's.id as sale_order_id, (f.price+if(is_registered=1, "1", 0)*f.registration_fee+if(f.step_price>0, ceil(if(d.calculation=1 and ceil(s.cube_long*s.cube_wide*s.cube_high/6000*2)/2*1000>s.weight,ceil(s.cube_long*s.cube_wide*s.cube_high/6000*2)/2*1000,s.weight)/1000)*f.step_price,0))*if(ed.express_discount>0 && d.shipping_type in (' . implode(',',C('SHIPPING_TYPE_EXPRESS')) . '),ed.express_discount,1) as expected_delivery_costs';
				$join						= array(
					'left join __EXPRESS_DETAIL__ f on f.id=s.express_detail_id ',
					'left join __EXPRESS__ d on d.id=f.express_id ',
					'left join __EXPRESS_DISCOUNT__ ed on ed.factory_id=s.factory_id and ed.warehouse_id=s.warehouse_id ',
				);
				$where						= array(
					's.id'	=> array('in', $expected_delivery_costs_sale),
				);			
				$expected_delivery_costs	= $model->field($field)->alias('s')->join($join)->where($where)->getField('sale_order_id, expected_delivery_costs');
			}
			//dhl允许手动删除发货订单
			$dhl_delete_sale_ids			= express_api_allow_manually_delete_sale_order_id('DHL', $sale_order_id);
			
			//correos允许手动删除发货订单
			$correos_delete_sale_ids		= express_api_allow_manually_delete_sale_order_id('CORREOS', $sale_order_id);

			//gls允许手动删除发货订单
			$gls_delete_sale_ids		= D('Gls')->getAllowManualDeleteSale($sale_order_id);
			
			foreach($list['list'] as &$val){
                //是否出库过
                $val['is_out']  = in_array($val['id'], $sale_order_id_shipped);
                //是投保未填投保金额背景蓝色
                if($val['is_insure'] == 1 && $val['insure_price'] <= 0){
                    $val['is_background']  = 1;
                }
                //对未出库的订单获取最新的订单重量和派送费用信息
                if(!in_array($val['sale_order_state'], array(C('SHIPPED'),C('SALE_ORDER_POST_OFFICE_RETURNED')))){
                    $val['weight']               = $product_id_arr[$val['id']]['detail_total']['weight'];
                    $val['dml_weight']           = $product_id_arr[$val['id']]['detail_total']['dml_weight'];
                    $val['edml_weight']          = $product_id_arr[$val['id']]['detail_total']['edml_weight'];
                    $val['volume_weight']        = $product_id_arr[$val['id']]['volume_weight'];
                    $val['dml_volume_weight']    = $product_id_arr[$val['id']]['dml_volume_weight'];
                    $val['edml_volume_weight']   = $product_id_arr[$val['id']]['edml_volume_weight'];
                }
                if($val['calculation']==1&&$val['weight']<$val['volume_weight']){
                    $val['weight']         = $val['volume_weight'];
                    $val['dml_weight']     = $val['dml_volume_weight'];
                    $val['edml_weight']    = $val['edml_volume_weight'];     
                }
				//追踪单号加网址
				if(!empty($val['web_url'])&&!empty($val['track_no'])){
					$link_class			= $val['track_no_update_tips'] == 1 ? ' class="track_no_update_tips" ' : '';
					$track_no			= $val['courier_id'] == C('EXPRESS_IT-GLS_ID') ? preg_replace('/^R2/','',$val['track_no']) : $val['track_no'];
					$val['track_no']	= '<a href="'.$val['web_url'].$track_no.'" ' . $link_class . ' target="_blank">'.$val['track_no'].'</a>';
				}

				//删除/编辑权限判断
                if(in_array($val['id'], $sale_order_state_arr) && $val['sale_order_state']!=C('SALE_ORDER_DELETED')){
                    $is_update  = 0;
                }else{
                    $is_update  = 1;
                }
				$val['is_update']	= $is_update  == 0 ? 0 : saleOrderCheckEdit($val['sale_order_state'],$val['id']);
				$val['is_del']		= saleOrderCheckDelete($val['sale_order_state'],in_array($val['id'],$sale_order_id_shipped));
				if($product_detail_info[$val['id']]){
					$val['product_detail_info'] = $table_str_start.$product_detail_info[$val['id']].$table_str_end;
				}

				//预计快递费用
				if($val['delivery_fee_paid_id'] <= 0 && intval($val['express_id'])>0&&intval($val['express_detail_id'])>0){
					$val['delivery_fee']		= $expected_delivery_costs[$val['id']];
					$val['dml_delivery_fee']	= moneyFormat($val['delivery_fee'],0, C('money_length'));
				}
				
				//其他费用合计
				if(isset($other_fee_total['list'][$val['id']])){
					foreach ($other_fee_total['list'][$val['id']] as $other_fee) {
						$val['other_fee_total'][]	= $other_fee['currency_no'] . ':' . $other_fee['dml_other_fee_total'];
					}
					$val['other_fee_total']		= implode("<br />", $val['other_fee_total']);					
					$val	= array_merge($val, $other_fee_total['list'][$val['id']]);
				}
				//有附件则加上小红旗标识
                if (in_array($val['id'], $gallery_list)) {
                    $val['sale_order_no'] .="<img src='" . __PUBLIC__ . "/Images/Default/red_flag.gif' style='width:17px;height:16px;'>";
                }		
                //ebay,amazon
                if(in_array($val['order_type'],C('ORDER_TYPE'))){
                    $order_type		= C('ORDER_TYPE_TABLE_NAME');
                    $site_array		= S($order_type[$val['order_type']]);
					$other_type		= $site_array[$val['other_type_user_id'].'_'.$val['factory_id']];
                    $view_module	= C('ORDER_TYPE_MODULE_NAME');
                    $title			= L('view').L($order_type);
                    if($other_type['id'] > 0){
                        $val['order_type_name']   = '<a onclick="addTab(\''.U('/'.$view_module[$val['order_type']].'/view/id/'.$other_type['id']).'\',\''.$title.'\',1);" href="javascript:;">'.$val['order_type_name'].'</a>';
						//只有超管用户才能看到连接到EBAY的功能
						if($val['order_type'] == 2 && C('USER_AUTH_TYPE') ==2 && $_SESSION[C('ADMIN_AUTH_KEY')]){
							$site_url	= S('URLDetails'.$other_type['site_id']);
							$ebay_site	= $site_url['ViewItemURL'];
							$item_id	= explode('-',$val['transaction_id']);
							$val['order_type_name'] .= '  <a href="'.$ebay_site.$item_id[0].'" target="_blank">E</a>';
						}
                    }
                }
                if(!empty($val['package_bg'])){
                    $val['order_no']    = $val['order_no'].'|'.$val['package_bg'];
                }
				if (in_array($val['id'], $dhl_delete_sale_ids) || in_array($val['id'], $correos_delete_sale_ids) || in_array($val['id'], $gls_delete_sale_ids)) {
					$val['express_api_delete']	= 1;
				}
			}
		}	
        $this->list	= $list;
		$this->displayIndex($temp_file);
	}  

	//订单出库
	public function outStock(){
		if (getUser('role_type') == C('SELLER_ROLE_TYPE')) {
		   throw_json(L('_VALID_ACCESS_'));
		}
		if(intval($_REQUEST['id'])>0 && intval($_REQUEST['verifyType'])==1){
			$sale_order_id	  = $_REQUEST['id'];
			$verifyType		  = 1;//验证复合订单
		} 
		
		if (!empty($_REQUEST['query']['custom_barcode']) ||  $sale_order_id>0){  
			$model 			  = $this->getModel();
//			$where				= array(
//				'custom_barcode'	=> $_REQUEST['query']['p.custom_barcode'],
//			);
//			$this->product_id = M('product')->where($where)->getField('id');
			$rs               = $model->getOutStockList($sale_order_id);
			foreach ($model->express_api_tips as $express_type) {
				$this->express_api_tips   .= sprintf(L($express_type . '_unfinished_not_allowed_outstock'), title('index', $express_type . 'List')) . '<br />';
			}
            if(!empty($rs)){
                //有附件则在订单单号后面添加小红旗
                $count = M('gallery')->where('relation_type ='.C('DOWNLOAD_FILE_TYPE').' and relation_id='.$rs['id'])->count();	
                if($count>0){
                    $img    = "<img src='" . __PUBLIC__ . "/Images/Default/red_flag.gif' style='width:20px;height:20px;'>";
                }
                $rs['new_order_no'] = $rs['order_no'].$img;
			}
            $this->rs           = $rs;
			$model->cacheLockVersion($this->rs);
			if(intval($this->rs['id'])>0){
				$this->id	  = $this->rs['id']; 
				$this->verifyType = $verifyType;
				$model->setId($this->id);
			}
		}
	}
	
	public function _after_outStock($temp_file){
		if ($_POST['search_form']) {
			$p_tpl	   = is_array($this->rs)&&$this->rs?'outStockInfo':'noticeInfo';
			$temp_file = empty($this->tplName)?$p_tpl:$this->tplName;
		}else { 
			$temp_file = empty($temp_file)?ACTION_NAME:$temp_file;  
		} 
		
		$this->display($this->_Member.$temp_file);
	}	

	/// 删除
    //判断是否发货过的销售单是则需要增加未分配数量
    //->条件(1.先出记录(先进先出排序)2.已上架记录3.当前销售单产品数量)
    //->条件3按序从(条件1中按序减去条件2得到的数组中)获取A(产品/库位/数量)
    //->将A增加(加上未分配)到未分配数量中并验证仓储费对账
	public function  _before_delete() {
		$id = intval($_GET['id']);
        //判断是否发货过的销售单是则需要增加未分配数量
        $model  = $this->getModel();
        $is_out_arr = $model->isSent($id);
        if(in_array($id, $is_out_arr)){
            //GET条件
            //1.先出记录(先进先出排序)
            //订单关联的拣货导入单ID
            $fileRelationDetail     = M('FileRelationDetail');
            $picking_import_id      = $fileRelationDetail->where('relation_id=' . $id . ' and file_type=' . array_search('PickingImport', C('CFG_FILE_TYPE')))->getField('object_id');
            $pickingModel   = D('Picking');
            $stock_out_product  = $pickingModel->getStockOut($picking_import_id);
            //2.已重新上架数量
            if($picking_import_id > 0){
                $back_shelves   = M('StorageLog')->where('relation_type=18 and main_id='.$picking_import_id)->field('product_id,location_id,sum(quantity) as quantity')->group('product_id,location_id')->getField('product_id,product_id,location_id,quantity');
            }
            //3.当前销售单产品数量
            $sale_order_info    = M('SaleOrderDetail')->where('sale_order_id='.$id)->group('product_id')->field('product_id,sum(quantity) as quantity')->getField('product_id,product_id,quantity');
            //先出记录中减去已经重新上架数量
            $this->getBackShelvesInfo($stock_out_product,$back_shelves);
            //获得新的重新上架库位
            $new_back_shelves   = $this->getBackShelvesInfo($stock_out_product, $sale_order_info);
            //仓储费对账验证验证
            $in_date    = time();
            foreach($new_back_shelves as $in_date_info){
                $in_date    = min(strtotime($in_date_info['in_date']),$in_date);
            }
            $in_date    = date('Y-m-d',$in_date);
            $sale_order_main    = M('sale_order')->find($id);
            $sale_order_main['in_date'] = $in_date;
            $checkWarehouseAccount  = D('CheckWarehouseAccount');
            $checkWarehouseAccount->checkWarehouseAccount();
            foreach($new_back_shelves as $val){
                $model->setBackShelves($val,$picking_import_id);
            }
        }
	}
    
    public function getBackShelvesInfo(&$stock_out_product,$back_shelves){
        foreach($back_shelves as $p_id=>$val){
            foreach($stock_out_product[$p_id] as $key=>&$s_info){
                if(!isset($val['location_id']) || $val['location_id'] == $s_info['location_id']){
                    if($s_info['quantity'] > $val['quantity']){
                        $s_info['quantity']     -= $val['quantity'];
                        $val['location_id']     = $s_info['location_id'];
                        $val['in_date']         = $s_info['in_date'];
                        $back_shelves_info[]    = $val;
                    }else{
                        $back_shelves_info[]    = $s_info;
                        unset($stock_out_product[$p_id][$key]);
                    }  
                }
            }
        }
        return $back_shelves_info;
    }

    /// 删除
	public function  delete() {
		$this->id	=	intval($_GET['id']);
		if ($this->id > 0) {  
			$model			  = $this->getModel();
			if ($model->relationDelete($this->id)===false){ 
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
        if($_POST['sale_order_state'] == C('ERROR_ADDRESS')){
            foreach($_POST['detail'] as &$val){
                unset($val['real_quantity']);
            }
            unset($val);
        }	
		$this->id	=	intval($_POST['id']); 	
		if ($this->id > 0) {  
			$model		= $this->getModel();
			$from_type	= trim($_POST['from_type']);
            //订单编辑页改成已发货新增-出库时间
            if($_POST['submit_type'] != 3 && $_POST['sale_order_state'] == C('SHIPPED')){
                $send_date  = M('sale_order')->where('id='.$_POST['id'])->getField('send_date');
                if($send_date==0){
                    $_POST['send_date']=   date('Y-m-d H:i:s',time());
                }
            }
			if ($model->relationUpdate()===false){
				if ($model->error_type==1){  
					$this->error ( $model->getError(),$model->errorStatus);	
				}else{
					$this->error (L('_ERROR_'));
				} 
			}
			//删除该订单缓存
			
		} else {
			$this->error(L('_ERROR_ACTION_'));
		} 	 
	}
	
	public function _after_insert() {
        if (!empty($_POST['file_tocken'])) {
            D('Gallery')->update($this->id, $_POST['file_tocken']);
        }
		$this->generateBarcode();
		parent::_after_insert();
	}
	
	/**
	 * 创建条形码
	 * @author jph 20140227
	 * @param type $code 产品id
	 * @param type $sku  产品编号
	 * @param type $product_name 产品名称
	 * @param type $product_barcode_config 配置
	 */
	public function generateBarcode($id = null){
		if (is_null($id)) {
			$id	= $this->id;
		}		
		$name		= 'SaleOrder';
		$path		= BARCODE_PATH . ucfirst($name);
		$code		= M($name)->where('id='.$id)->getField('sale_order_no');
		$filename	= $path . '/' . $id . '.' . C('BARCODE_PC_TYPE');
		$sale_order_detail	= M('SaleOrderDetail')->field('if(sum(quantity)>1, concat(sum(quantity),"*",product_id), product_id) as product')->where('product_id>0 and sale_order_id=' . $id)->group('product_id')->getField('product', true);
		$barcode_config		= array(
								'pc_height'	=> 195,
								'y'			=> 100, 
								'file_name'	=> $id,
							);			
		$hri				= array(
								'Attention: For assistance, please contact ' . "\n" . 'your online vendors.',
								implode('-', $sale_order_detail),
							);
		$hri=null;
		if (is_null($hri)) {
			$barcode_config['pc_height']	= 135;
		}
		return generateBarcode($code, $path, $hri, $barcode_config);
	}

    public function updateAddress(){
        ///获取当前Action名称
        $name = $this->getActionName();
        ///获取当前模型
        $model = D($name);
		startTrans();
        if ($model->updateAddressValid($_POST) === true && $model->updateAddress() !== false) {//验证信息
			commit();
            $this->success(L('_OPERATION_SUCCESS_'));
        } else {
			rollback();
            if ($model->error_type == 1) {
                $this->error($model->getError(), $model->errorStatus);
            } else {
                $this->error(L('_ERROR_'));
            }
        }
    }
    public function edit() {
        $count_return   = M('ReturnSaleOrder')->where('sale_order_id='.$_GET['id'])->count();
        $this->assign('count_return',$count_return);
        $state      = M('sale_order')->where('id='.$_GET['id'])->getField('sale_order_state');
        $is_sent    = saleOrderCheckEdit($state,$_GET['id']);
        $this->assign('is_sent',$is_sent);
        $this->assign('sale_order_deleted',($state == C('SALE_ORDER_DELETED')));
        parent::edit();
    }
    public function batchUpload(){
        $sale_order_id  = intval($_POST['sale_order_id']);
        if (!empty($_POST['file_tocken']) && $sale_order_id > 0) {
            D('Gallery')->update($sale_order_id, $_POST['file_tocken']);
        }
    }
    
    public function batchEdit(){
        $list   = explode(',', $_POST['id']);
        $model  = D('SaleOrder');
        $warehouse_id   = intval($_POST['warehouse_id']);
        $express_id     = intval($_POST['express_id']);
        foreach($list as $id){
            $info   = $model->getInfo($id);
            $info['warehouse_id']   = $warehouse_id;
            $info['express_id']     = $express_id;
            $data   = $model->setpost($info);
            if($data['express_id'] <= 0){
                $error[$info['sale_order_no']]   = $info['sale_order_no'];
            }else{
                $sale_order_id_arr  = $value['id'];
                $model->save($value);
            }
        }
        $model->updateSaleOrderStateById($sale_order_id_arr,C('SALE_ORDER_STATE_PENDING'),L('batch_edit'));
        if(!empty($error)){
            $this->error(implode(',', $error).L('not_meet_delivery'));
        }
    }

	public function wayBillAddress($info, $is_factory = false){
		$prefix		= $is_factory ? 'comp_' : '';
		$address	= '';
		if ($is_factory) {
			$address	.= $info['basic_name'];
		} else {
			$address	.= $info['consignee'];
		}
		if ($info[$prefix . 'address']) {
			$address	.= '<br /> ' . $info[$prefix . 'address'];
		}
		if ($info[$prefix . 'address2']) {
			$address	.= '<br /> ' . $info[$prefix . 'address2'];
		}
		if ($info[$prefix . 'post_code'] || $info[$prefix . 'city_name']) {
			$address	.= '<br /> ' . $info[$prefix . 'post_code'];
			if ($info[$prefix . 'city_name']) {
				$address	.= ', ' . $info[$prefix . 'city_name'];
			}
		}
		if ($info[$prefix . 'country_id']) {
			$address	.= '<br /> ' . trim(reset(explode(',', SOnly('country', $info[$prefix . 'country_id'], 'district_name'))));
		}
		return $address;
	}


	//出库运单打印 add yyh 20160301
    public function printWaybillLabel($id){
        $where['a.id']		= $id;
        $info				= _formatArray(M('SaleOrder')->where($where)->alias('a')
														->join('
															INNER JOIN __SALE_ORDER_ADDITION__ b ON a.id=b.sale_order_id
															INNER JOIN __CLIENT__ c ON a.client_id=c.id
															INNER JOIN __COMPANY__ f ON a.factory_id=f.id and f.comp_type=1
															INNER JOIN __COMPANY_FACTORY__ cf ON f.id=cf.factory_id
															INNER JOIN __WAREHOUSE__ w on w.id=a.warehouse_id')
														->field('a.id, a.factory_id, date(a.send_date) as send_date, a.sale_order_no, c.comp_no as client_no, w.w_address, w.w_basic_name, '
																. 'f.basic_name_en as basic_name, f.country_id as comp_country_id,f.comp_name,f.address as comp_address,f.address2 as comp_address2,f.post_code as comp_post_code,f.city_name as comp_city_name, f.mobile, f.fax, '
																. 'b.consignee, b.address,b.address2,b.post_code,b.city_name,b.country_id,'
																. 'cf.vat_number, cf.reg_number, cf.house_bank, cf.account_holder, cf.bank_code, cf.iban_account')
														->find());
		$company_name		= $info['basic_name'];
		$factory_address	= $this->wayBillAddress($info, true);
		$client_address		= $this->wayBillAddress($info);
		$warehouse_address	= $info['w_basic_name'] . '<br /> ' . $info['w_address'];
		$send_date			= date('m.d.Y', $info['send_date'] != '0000-00-00' ? strtotime($info['send_date']) : time());
		$this->generateBarcode($info['id']);
		$filename			= BARCODE_PATH . 'SaleOrder/' . $info['id'] . '.' . C('BARCODE_PC_TYPE') . '?' . time();
		$gallery			= D('Gallery')->getAry($info['factory_id'],30, 1);
		$logo				= getUploadPath($gallery['relation_type']) . $gallery['file_url'];
		$logo_size			= getimagesize($logo);
		$logo_rate			= $logo_size[0] / $logo_size[1];
		if ($logo_rate >= 1) {
			$logo_width		= 320;
			$logo_height	= $logo_width / $logo_rate;
		} else {
			$logo_height	= 200;
			$logo_width		= $logo_height * $logo_rate;
		}
		$detail				= M('SaleOrderDetail')->alias('a')->join('left join product p on a.product_id=p.id')->where(array('sale_order_id' => $info['id']))->select();
		foreach ($detail as $val) {
			$detail_html	.= '<tr height=18 style="height:13.5pt">
								  <td colspan=3>' . $val['quantity'] . '</td>
								  <td colspan=3>' . $val['product_name'] . '</td>
								  <td colspan=4>' . $val['product_no'] . '</td>
								</tr>';
		}
		$htmlInfo			= '<div>
								<style>
									td{
										padding:0px;
										color:black;
										font-size:11.0pt;
										font-weight:400;
										font-style:normal;
										text-decoration:none;
										font-family:宋体, sans-serif;
										text-align:general;
										border:none;
										white-space:normal;
									}
									.xl66{
										color:black;
										font-size:12.0pt;
										font-family:Calibri, sans-serif;
									}
									.xl67{
										color:black;
										font-size:14.0pt;
										font-family:Calibri, sans-serif;
									}
									.xl68{
										border-top:.5pt solid windowtext;
										border-right:none;
										border-bottom:none;
										border-left:none;
									}
								</style>
								<div style="width: 100%; height: 100%">
								<table border=0 cellpadding=0 cellspacing=0 width=745 style="border-collapse: collapse;table-layout:fixed; width:559pt; margin-left: 3px;">
								 <tr height=4 style="height:3pt">
								  <td width=72 style="width:54pt"></td>
								  <td width=72 style="width:54pt"></td>
								  <td width=72 style="width:54pt"></td>
								  <td width=72 style="width:54pt"></td>
								  <td width=72 style="width:54pt"></td>
								  <td width=72 style="width:54pt"></td>
								  <td width=72 style="width:54pt"></td>
								  <td width=72 style="width:54pt"></td>
								  <td width=72 style="width:54pt"></td>
								 <td width=97 style="width:73pt"></td>
								 </tr>
								 <tr>
								  <td colspan=5 style="vertical-align: middle;">
									<img width=300 src="' . $filename . '">
								  </td>
								  <td colspan=5 rowspan=3 style="vertical-align: middle;">
									<img width="' . $logo_width . '" height="' . $logo_height . '" src="' . $logo . '" />
								  </td>
								 </tr>
								 <tr height=36 style="height:27pt">
								  <td colspan=5></td>
								 </tr>
								 <tr height=126 style="height:94.5pt">
								  <td colspan=5 style="vertical-align: top;">' . $factory_address . '</td>
								 </tr>
								 <tr height=18 style="height:13.5pt">
								  <td colspan=5 rowspan=2 style="vertical-align: top;">' . $client_address . '</td>
								  <td class=xl66 colspan=5>Versandanschrift:</td>
								 </tr>
								 <tr height=108 style="height:81pt">
								  <td colspan=5 style="vertical-align: top;">' . $warehouse_address . '</td>
								 </tr>
								 <tr height=21 style="height:15.75pt">
								  <td colspan=10><span class=xl66>Lieferschein</span>&nbsp;' . $info['sale_order_no'] . '</td>
								 </tr>
								 <tr height=21 style="height:15.75pt">
								  <td colspan=10><span class=xl66>Kundennummer:</span>&nbsp;' . $info['client_no'] . '</td>
								 </tr>
								 <tr height=18 style="height:13.5pt">
								  <td colspan=10></td>
								 </tr>
								 <tr height=25 style="height:18.75pt">
								  <td class=xl67>Menge</td>
								  <td colspan=2></td>
								  <td class=xl67 colspan=2>Artikelname</td>
								  <td></td>
								  <td class=xl67 colspan=2>Artikelnummer</td>
								  <td colspan=2></td>
								 </tr>
								 <tr height=18 style="height:13.5pt">
								  <td class=xl68 colspan=10></td>
								 </tr>
								 ' . $detail_html . '
								 <tr height=54 style="height:40.5pt">
								  <td class=xl68 colspan=10></td>
								 </tr>
								 <tr height=39 style="height:29.25pt">
								  <td colspan=10 style="vertical-align: top;"><span class=xl66>Lieferdatum:</span>&nbsp;' . $send_date . '</td>
								 </tr>
								 <tr>
								  <td colspan=10 style="vertical-align: top;">Die Ware
								  bleibt bis zur vollst&auml;ndigen Bezahlung Eigentum von ' . $company_name . '. Es gelten unsere Allgemeinen Gesch&auml;ftsbedingungen.<br>
									<br>
									Wir bedanken uns für Ihren Auftrag und würden uns freuen, wenn Sie uns
								  wieterempfehlen!
								  <br>
								  </td>
								 </tr>
								<tr height=39 style="height:29.25pt">
								  <td class=xl66 colspan=10 style="vertical-align: bottom;">Mit freundlichen Grü&szlig;en</td>
								 </tr>
								 <tr>
								  <td colspan=10 style="vertical-align: top; padding-top: 10px;">' . $company_name . '</td>
								 </tr>
								</table>
								<table style="position: absolute; bottom: 0px;">
								 <tr height=21 style="height:15.75pt">
								  <td rowspan=4 width=144 style="width:108pt; vertical-align: top;">' . $factory_address . '</td>
								  <td width=288 style="width:216pt"><span class=xl66>Telefon:</span>&nbsp;' . $info['mobile'] . '</td>
								  <td width=313 style="width:235pt"><span class=xl66>Kontoinhaber:</span>&nbsp;' . $info['account_holder'] . '</td>
								 </tr>
								 <tr height=21 style="height:15.75pt">
								  <td><span class=xl66>Telefax:</span>&nbsp;' . $info['fax'] . '</td>
								  <td><span class=xl66>BIC:</span>&nbsp;' . $info['bank_code'] . '</td>
								 </tr>
								 <tr height=21 style="height:15.75pt">
								  <td><span class=xl66 style="vertical-align: top;">Umsatzsteuer ID:</span>&nbsp;' . $info['vat_number'] . '</td>
								  <td><span class=xl66>IBAN:</span>&nbsp;' . $info['iban_account'] . '</td>
								 </tr>
								 <tr height=21 style="height:15.75pt">
								  <td colspan=2><span class=xl66 style="vertical-align: top;">Handelsregister:</span>&nbsp;' . $info['reg_number'] . '</td>
								 </tr>
								</table>
								</div>
							</div>';
        return $htmlInfo;
    }

	/**
	 * 删除API发货
	 */
	public function deleteShipmentDD(){
		$sale_order_id	= (int)$_GET['id'];
		if ($sale_order_id > 0) {
			$model	= M('SaleOrder');
			$data	= $model->find($sale_order_id);
			//数据权限验证
			if (data_permission_validation($data) === false){
				$this->error(L('data_right_error'));
			}
			$company_id = M('express')->where('id=' . $data['express_id'])->getField('company_id');
			switch ($company_id){
				case C('EXPRESS_ES_CORREOS_ID'):
					$express_type	= 'correos';
					break;
				case C('EXPRESS_DHL_ID'):
				default :
					$express_type	= 'dhl';
					break;
			}
			if(in_array($company_id, C('GLS_API_EXPRESS_ID'))){
				D('Gls')->deleteGlsShip($sale_order_id);
			}else{
			//新增删除API发货请求队列
			$_GET[$express_type. '_list_id']	= express_api_delete_request($express_type, $sale_order_id);
			//执行删除API发货
			if ($_GET[$express_type. '_list_id'] > 0) {
				try {
					express_api_load_file($express_type);
					$process_request	= $express_type . '_process_request';
					$result				= $process_request('deleteShipmentDD');
					if (is_object($result)) {
						$error	= $result->getError();
						if (!empty($error)) {
							$this->error(implode("<br />", $error));
						}
					} else {
						$this->error(L('_RECORD_HAS_UPDATE_'));
					}
				} catch (Exception $ex) {
					$ajax	= array(
						'code'	=> $ex->getCode(),
						'msg'	=> $ex->getMessage(),
					);
					$this->error(L('_OPERATION_WRONG_'), 0, '', $ajax);
				}
			}
			}
		} else {
			$this->error(L('data_right_error'));
		}
		$ajax			= array(
			'status'	=> 1,
			'href'		=> U('/SaleOrder/index'),
			'title'		=> title('index'),
		);
		$this->success(L('_OPERATION_SUCCESS_'), '', $ajax);
	}
}
?>