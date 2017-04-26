<?php
/**
 * 流程明细显示
 *
 * @param array $params
 * @param string $content
 * @param object $smarty
 * @param bool $repeat
 *  flow:流程模块
 *  thead:明细表格标题  flow_barcode flow_color flow_size flow_quantity flow_capability flow_dozen flow_config 根据流程配置获取标题
 *  		以action_开头的表示 根据参数action来判断是否显示该标题  action_语言包
 *  op_show:需要显示操作列的action
 *  action:该列需要显示的action
 *  viewaction:需要查看显示的action 默认view 需在{td}标签中添加view参数指明显示的字段
 *  index:所在行数变量重命名
 *  item:所在行数据 变量重命名
 *  key:所在行数据索引重命名
 *  tfoot:是否显示统计行 默认：true
 *  tbody_empty:明细值为空时 是否显示空白行 默认：true 显示5行
 */
function smarty_block_detail_table($params, $content,&$smarty, &$repeat){
	define('TPL_MODULE_NAME', !empty($smarty->getVariable('tpl_module_name')->value) ? $smarty->getVariable('tpl_module_name')->value : MODULE_NAME);
	define('TPL_ACTION_NAME', !empty($smarty->getVariable('tpl_action_name')->value) ? $smarty->getVariable('tpl_action_name')->value : ACTION_NAME);
	if(empty($content)){
		$repeat	= true;
	}
	$from			= array();
	$detail_item	= 'item';
	$detail_index	= 'index';
	$detail_key		= 'key';
	$viewaction		= array('view','viewNotPrice');
	$tfoot			= true;
	$tbody_empty	= false;
	$barcode		= true;
	foreach($params as $_key=>$_val){
		switch($_key){
			case 'from':
				$from		= $_val;break;
			case 'item':
				$detail_item= $_val;break;
			case 'key':
				$detail_key	= $_val;break;
			case 'index':
				$detail_index=$_val;break;
			case 'action':
				$smarty->assign('detail_action',$_val);break;
			case 'op_show':
				$smarty->assign('detail_op_show',$_val);break;
			case 'viewaction':
				$$_key	= $_val;break;
			case 'tfoot':
				$$_key	= $_val;break;
			case 'flow':
				$flow	= $_val;
				$smarty->assign('flow',$_val);break;
			case 'thead':
				break;
			case 'tbody_empty':
				$$_key	= $_val;
				break;
			case 'barcode':
				$$_key	= $_val;
				break;
			default:
				$extra	.= $_key.'="'.$_val.'" ';
				$params['extra']=$extra;
				break;
		}
	}
	$display	= 'display:none;';
	$smarty->assign('viewaction',$viewaction);
	$block_index	= $flow.'_block_detail_index';
	$block_key		= $flow.'_block_detail_key'; 
	if(empty($smarty->tpl_vars[$block_index])){
		$smarty->tpl_vars[$block_index]	= (array)$from;
	}
	$index			= intval($smarty->tpl_vars[$block_key]);
	$smarty->tpl_vars[$block_key]=$index+1;
	if(ACTION_SENT_EMAIL==1){
		$style		= "border-top:1px solid #cccccc;border-right:1px solid #cccccc;height:26px;line-height:26px;padding-left:3px;padding-right:3px;color:#333333;font-weight: normal;white-space:nowrap;font-size:12px;";
		/*$content	= preg_replace('|(<td)|',"\${1} style=\"".$style."\"",$content);*/
	}
	if($index==0){
        if(ACTION_NAME!='outStock'){
            C('barcode',false);
        }
		if($barcode==true&&C('barcode')){
			$barcode='<td class="barcode" style="'.$style.'" ><span id="barcode">&nbsp;</span></td>';
			$content= preg_replace('/(<tr.*?>)(.*?)/i',"\${1} $barcode \${2}",$content);
		}
		if(ACTION_SENT_EMAIL==1){
			$content	= preg_replace('|(<tr)|',"\${1} ".$display,$content);
		}
		$smarty->assign($detail_index,$index);
		$smarty->assign('none','none');
		$smarty->assign('detail_tfoot',0);
		$smarty->assign('mail_style',$display);
		$content	= '';
		$repeat=true;
		print $content;
	}else{
		$index==1 && smarty_function_detail_thead($params,$smarty);
		$cache_item		= $smarty->getVariable($detail_item)->value;
		list($key,$item)= each($smarty->tpl_vars[$block_index]);
		$smarty->assign($detail_index,$index);
		$smarty->assign($detail_key,$key);
		$smarty->assign($detail_item,$item);
		$smarty->assign('none','');
		$smarty->assign('mail_style','');
		$count	= count($from);
		$max_row= intval($params['add_max_row'] > 0 ? $params['add_max_row'] : (C('add_max_row') > 0 ? C('add_max_row') : 5));
		if(($count>0&&$count>=$index)||($count==0&&$index<=$max_row)){
			/*if($barcode==true&&C('barcode')){
//				$cache_item		= $smarty->getVariable($detail_item)->value;
			$cache_barcode	= smarty_function_getBarcode($cache_item['product_id'],$cache_item['color_id'],$cache_item['size_id']);
				$barcode='<td class="barcode" style="'.$style.'" abc><span id="barcode">'.$cache_barcode.'&nbsp;</span></td>';
				$content= preg_replace('/(<tr.*?>)(.*?)/i',"\${1} $barcode \${2}",$content);
			}*/
			if($tbody_empty==true&&$index>1&&$count==0){
				$repeat = false;
				print '</tbody></table>';
			}else{
				
				$repeat=true;
				print  $content;
			}
		}else{
			$detail_tfoot	= $smarty->getVariable('detail_tfoot')->value;
/*			if($barcode==true&&C('barcode')){//是否显示条码列
				$cache_barcodde	= $detail_tfoot==1?'':smarty_function_getBarcode($cache_item['product_id'],$cache_item['color_id'],$cache_item['size_id']);
				$barcode='<td class="barcode" style="'.$style.'" ><span id="barcode">'.$cache_barcodde.'&nbsp;</span></td>';
				$content= preg_replace('/(<tr.*?>)(.*?)/i',"\${1} $barcode \${2}",$content);
			}*/
			
			if($detail_tfoot==1){
				/*$content	= preg_replace('|(<td)|',"\${1} style=\"color:red;font-weight:bold;text-align:right;border-right:1px solid #CCCCCC;border-top: 1px solid #CCCCCC;height: 26px; line-height: 26px;white-space: nowrap;font-size:12px;\"",$content);*/
				$repeat=false;
				print '</tbody><tfoot>'.$content.'</tfoot></table>';
			}else{
				$smarty->assign('detail_tfoot',1);
				//是否显示 tfoot
				if($tfoot==false){
					$repeat=false;
					print $content.'</tbody></table>';
				}else{
					$repeat=true;
					print $content;
				}
				reset($smarty->tpl_vars[$block_index]);
				$smarty->assign($detail_index,0);
			}
		}
	}
}

/**
 * 明细表格标题
 *
 * @param array $params
 *  flow:流程模块
 *  thead:标题名称  flow_color flow_size flow_quantity flow_capability flow_dozen flow_config 根据流程配置获取标题
 * 
 */
function smarty_function_detail_thead($params,&$smarty){
	define('TPL_MODULE_NAME', !empty($smarty->getVariable('tpl_module_name')->value) ? $smarty->getVariable('tpl_module_name')->value : MODULE_NAME);
	define('TPL_ACTION_NAME', !empty($smarty->getVariable('tpl_action_name')->value) ? $smarty->getVariable('tpl_action_name')->value : ACTION_NAME);	
	$flow	= $type = '';
	$config	= $thead = $show = array();
	$barcode= true;
	$warehouse=false;
	$action_name=TPL_ACTION_NAME;
	extract($params);
	$config	= (array)C($flow);
	$config['show']	= (array)$config['show'];
//	if($barcode&&TPL_ACTION_NAME!='view'){
//		$output	.= smarty_function_barcode();
//	}
//	$output	.= '<table cellspacing="0" cellpadding="0" class="detail_list" '.$extra.'><thead>';
    $output = '' ;
    if($add_thead){
        $currency   = SOnly('currency', SOnly('warehouse', $add_thead,'w_currency_id'));
        $output = '<tr><th colspan ="'.a2bc(in_array(TPL_ACTION_NAME,array('add', 'edit')),'5','4').'" style="border-right:none;text-align:center;" >'.  SOnly('warehouse', $add_thead,'w_name').L('warehouse_fee').'</th><th class="t_left" colspan ="2" style="border-right:none;text-align:center;">'.str_replace(array('欧元'), array($currency['currency_name']) ,L('EUR_CMB_day')).'</th></tr>';
    }
	$output	.= '<tr>';
	$td_qn	= $td_ware = 0;
	/*if(C('barcode')&&$barcode==true){
		$output	.= '<th>'.L('barcode').'</th>';
		$td_qn++;
	}*/
	
	foreach($thead as $_key=>$_val){
		switch($_val){
			//条形码
			case 'flow_barcode':
				if(C('barcode')==1){
					$output	.= '<th>'.L('barcode').'</th>';
					$td_qn++ ;
				}
				break;
			//颜色
			case 'flow_color':
				if($config['color']==1){
					$output	.= '<th>'.L('color').'</th>';
					$td_qn++ ;
				}
				break;
			//尺码
			case 'flow_size':
				if($config['size']==1){
					$output	.= '<th>'.L('size').'</th>';
					$td_qn++ ;
				}
				break;
			//箱数
			case 'flow_quantity':
				$output	.= '<th>'.L('quantity').'</th>';
				$td_qn++ ;
				break;
			//每包箱数
			case 'flow_capability':
				if($config['storage_format']>=2){
					$output	.= '<th>'.L('capability').'</th>';
					$td_qn++ ;
				}
				break;
			//每箱数量
			case 'flow_dozen':
				if($config['storage_format']==3){
					$output	.= '<th>'.L('dozen').'</th>';
					$td_qn++ ;
				}
				break;
			//总金额
			case 'flow_row_total':
				if($config['storage_format']>=2){
					$output	.= '<th>'.L('sum_quantity').'</th>';
					$td_qn++ ;
				}
				break;
			//尾箱
			case 'flow_mantissa':
				if($config['mantissa']==1){
					$output	.= '<th>'.L('mantissa_2').'</th>';
					$td_qn++ ;
				}
				break;
			//仓库
			case 'flow_multi_storage':
				if($flow=='sale'&&C('sale.relation_sale_follow_up')==1){ //销售流程 配置为有后续流程 不显示仓库
					break;
				}
				if(C('multi_storage')==1){
					$output	.= '<th>'.L('warehouse').'</th>';
					$td_qn++ ;
					$td_ware = $td_qn;
				}
				break;
			//颜色、尺码、箱、包、条
			case 'flow_config':
				if($config['color']==1){
					$output	.= '<th>'.L('color').'</th>';
					$td_qn++ ;
				}
				if($config['size']==1){
					$output	.= '<th>'.L('size').'</th>';
					$td_qn++ ;
				}
				if($config['storage_format']>=1){
					$output	.= '<th>'.L('quantity').'</th>';
					$td_qn++ ;
				}
				if($config['storage_format']>=2){
					$output	.= '<th>'.L('capability').'</th>';
					$td_qn++ ;
				}
				if($config['storage_format']==3){
					$output	.= '<th>'.L('dozen').'</th>';
					$td_qn++ ;
				}
				if($config['storage_format']>=2){
					$output .= '<th>'.L('sum_quantity').'</th>';
					$td_qn++ ;
				}
				break;
			//厂家币种
			case 'flow_factory_currency':
				$data = smarty_function_currencyHead($_val);
				$td_qn	+= $data['td_qn'];
				$output	.= $data['thead'];
				break;
			//客户币种
			case 'flow_client_currency':
				$data = smarty_function_currencyHead($_val);
				$td_qn	+= $data['td_qn'];
				$output	.= $data['thead'];
				break;
			//物流公司币种
			case 'flow_logistics_currency':
				$data = smarty_function_currencyHead($_val);
				$td_qn	+= $data['td_qn'];
				$output	.= $data['thead'];
				break;
			//本公司币种
			case 'flow_company_currency':
				$data = smarty_function_currencyHead($_val);
				$td_qn	+= $data['td_qn'];
				$output	.= $data['thead'];
				break;
			//运费
			case 'flow_show_instock_logistics_funds':
				if(C('instock.instock_logistics_funds')==1&&TPL_ACTION_NAME!='add'&&C('instock.instock_price_show')==1){
					$output	.= '<th>'.L('delivery_fee').'</th>';
					$td_qn++;
				}
				break;
			//入库单价
			case 'flow_instock_price_show':
				if(C('instock.instock_price_show')==1){
					$output	.= '<th>'.L('price').'</th>';
					$td_qn++;
				}
				break;
			//入库金额
			case 'flow_instock_total_money':
				if(C('instock.instock_price_show')==1){
					$output .= '<th>'.L('money').'</th>';
					$td_qn++;
				}
				break;
			//入库 运费按立方算时 显示每箱尺寸
			case 'flow_per_size':
				if(C('instock.delivery')==2){
					$output .= '<th>'.L('per_size').'</th>';
					$td_qn++;
				}
				break;
			//入库 运费按立方算时 显示每箱数量
			case 'flow_per_capability':
				if(C('instock.delivery')==2){
					$output .= '<th>'.L('per_capability').'</th>';
					$td_qn++;
				}
				break;
			//销售折扣
			case 'flow_sale_discount':
				if(C('sale.sale_client_count_money')==1){
					$output	.= '<th>'.L('discount').'</th>';
					$td_qn++;
				}
				break;
			//销售折扣金额
			case 'flow_sale_account_money'://added by jp 20131227
				if(C('sale.sale_client_count_money')==1){
					$output	.= '<th>'.L('account_money').'</th>';
					$td_qn++;
				}
				break;				
			//销售折后金额
			case 'flow_sale_after_discount':
				if(C('sale.sale_client_count_money')==1){
					$output	.= '<th>'.L('after_discount_money').'</th>';
					$td_qn++;
				}
				break;
			//发货单价
			case 'flow_delivery_price':
				if(C('delivery.delivery_price_show')==1){
					$output	.='<th>'.L('price').'</th>';
					$td_qn++;
				}
				break;
			//发货金额
			case 'flow_delivery_money':
				if(C('delivery.delivery_price_show')==1){
					$output	.='<th>'.L('money').'</th>';
					$td_qn++;
				}
				break;
			//发货折扣
			case 'flow_delivery_discount':
				if(C('delivery.delivery_price_show')==1 && C('sale.sale_client_count_money')==1){
					$output	.= '<th>'.L('discount').'</th>';
					$td_qn++;
				}
				break;
			//发货折扣金额
			case 'flow_delivery_account_money'://added by jp 20131227
				if(C('delivery.delivery_price_show')==1 && C('sale.sale_client_count_money')==1){
					$output	.= '<th>'.L('account_money').'</th>';
					$td_qn++;
				}
				break;					
			//发货折后金额
			case 'flow_delivery_after_discount':
				if(C('delivery.delivery_price_show')==1 && C('sale.sale_client_count_money')==1){
					$output	.= '<th>'.L('after_discount_money').'</th>';
					$td_qn++;
				}
				break;
			//换货显示仓库   销售有后续流程 不显示仓库  没有则显示仓库
			case 'flow_return_sale_warehouse':
				if(C('multi_storage')==1&&C('sale.relation_sale_follow_up')==2){
					$output	.= '<th>'.L('warehouse').'</th>';
					$td_qn++;
					$td_ware = $td_qn;
				}
				break;
			//退货显示仓库
			case 'flow_return_warehouse':
				if(C('multi_storage')==1){
					$output	.= '<th>'.L('warehouse').'</th>';
					$td_qn++;
					$td_ware = $td_qn;
				}
				break;
			//发票显示成分
			case 'flow_invoice_ingredient':
				if($config['ingredient']==1&&$config['product_from']==2){
					$output	.= '<th>'.L('invoice_ingredient').'</th>';
					$td_qn++;
				}
				break;
			//发票显示折扣
			case 'flow_invoice_discount_money':
				if(C('invoice.discount_money')==1){
					$output	.= '<th>'.L('discount').'</th>';
					$td_qn++;
				}
				break;
			//发票显示折后金额
			case 'flow_invoice_discount_after_money':
				if(C('invoice.discount_money')==1){
					$output	.= '<th>'.L('after_discount_money').'</th>';
					$td_qn++;
				}
				break;
			//发票显示产品号
			case 'flow_invoice_product_no':
				if(C('invoice.product')==1){
					$output	.= '<th>'.L('product_no').'</th>';
					$td_qn++;
				}
				break;
			//发票公司名称
			case 'flow_invoice_company':
				if(C('invoice.company_from')==2||(C('invoice.company_from')==1&&C('show_many_basic')==1)){
					$output	.= '<th>'.L('basic_name').'</th>';
					$td_qn++;
				}
				break;
			case 'flow_unload_quantity':
				if(C('order.storage_format')>1){
					$output	.= '<th>'.L('unload_quantity').'</th>';
					$td_qn++;
				}
				break;
			//查验规格，查验重量，查验状态，查验备注 added by jp 20140320
			case 'flow_check_config':
				if (TPL_ACTION_NAME !== 'add') {
					$output	.= '<th>'.L('check_spec_detail').'</th>';
					$td_qn++ ;
					$output	.= '<th>'.L('check_weight_with_unit').'</th>';
					$td_qn++ ;
					$output	.= '<th>'.L('check_status').'</th>';
					$td_qn++ ;
					$output	.= '<th>'.L('check_comments').'</th>';
					$td_qn++ ;
				}
				break;	
			case 'flow_instock_in_quantity':
				if ($flow =='instock' && TPL_ACTION_NAME !== 'add' ) {
					$output	.= '<th>'.L('in_quantity').'</th>';
					$td_qn++ ;
				}
				break;	
			case 'flow_instock_diff_quantity':
				if ($flow =='instock' && TPL_ACTION_NAME !== 'add') {
					$output	.= '<th>'.L('diff_quantity').'</th>';
					$td_qn++ ;
				}
				break;
			case 'p_id':
				if ($flow =='sale' &&  TPL_ACTION_NAME == 'view') {
					$output	.= '<th>'.L('product_id').'</th>';
					$td_qn++ ;
				}
				break;
			case 'verify_quantity':
				if ($flow == 'verify') {
					$output	.= '<th>'.L('verify_quantity').'</th>';
					$td_qn++ ;
				}
				break;
            //序列号ID added by yyh 20140929
            case 'flow_serial_id_config':
                if(TPL_ACTION_NAME === 'view'){
                    $output	.= '<th>'.L('serial_id').'</th>';
					$td_qn++ ;
                }
                break;
			//箱号ID added by jp 20140408
			case 'flow_box_id_config':
				if (TPL_ACTION_NAME === 'view') {
					$output	.= '<th>'.L('box_id').'</th>';
					$td_qn++ ;
				}
				break;	
			//产品ID added by jp 20140408
			case 'flow_product_id_config':
				if (TPL_ACTION_NAME === 'view') {
					$output	.= '<th>'.L('product_id').'</th>';
					$td_qn++ ;
				}
				break;				
			default:
				if(substr($_val,0,6)=='action'){
					if(in_array($action_name,$action)){
						$lang	= substr($_val,7);
						if($lang=='load_quantity'&&C('loadContainer.storage_format')==1){
							$output .= '';
						}else{
							$output .= '<th>'.L($lang).'</th>';
							$td_qn++;
						}
					}
				}else{
					$output	.= '<th>'.$_val.'</th>';
					$td_qn++;
				}
				break;
		}
	}
	
	if($op_show !== false && (empty($op_show) || in_array(TPL_ACTION_NAME,$op_show))&&ACTION_SENT_EMAIL!=1){
		$output .= '<th>'.L('operation').'</th>';
		$td_qn++;
	}
	if($barcode==true){
		$input_barcode = smarty_function_barcode();
	}
	if((($td_ware>0&&$warehouse==true)||!empty($input_barcode))&&TPL_ACTION_NAME!='view'&&ACTION_SENT_EMAIL!=1){
		
		$first_tr = '<tr bgcolor="#E9E9E9" id="tr_barcode"><td colspan="2" class="b_none t_left">'.$input_barcode.'</td>';
		
		for($i=3;$i<=$td_qn;$i++){
			if($i==($td_ware-1)&&$warehouse==true){
				$first_tr	.= '<td class="t_right b_none">'.L('warehouse').'：</td>';
			}elseif ($i==$td_ware&&$warehouse==true){
				$first_tr	.= '<td class="b_none t_left"><input type="hidden" jqware="" name="warehouse_id"><input type="text" name="warehouse_name" url="'.U('AutoComplete/warehouse').'" class="w100" jqac /></td>';
			}else{
				$first_tr	.= '<td class="b_none"></td>';
			}
		}
		$first_tr	.= '</tr>';
	}
	if(ACTION_SENT_EMAIL==1){
		$output = preg_replace('|(<th)|',"\${1} style='
								border-right:1px solid #cccccc;
								background:url(\"".__PUBLIC__."/Images/Default/list_bg.gif\") 50% 50% repeat-x;
								height:26px;
								line-height:15px;
								color:#333333;
								padding:0;
								font-size:12px;
								text-align:center;' ",$output);
		$output	= '<table cellspacing="0" cellpadding="0" style="width:100%;border:1px solid #cccccc;" class="detail_list" '.$extra.'><thead>'.$first_tr.$output.'</thead><tbody>';
	}else{
		$output	= '<table cellspacing="0" cellpadding="0" class="detail_list" '.$extra.'><thead>'.$first_tr.$output.'</thead><tbody>';
	}
	
//	$output	.= '</tr></thead><tbody>';
	print $output;
}

function smarty_function_currencyHead($type){
	$type	= strtolower($type);
	$data	= C(str_replace('flow_','',$type));
	$data	= @explode(',',$data);
	if(count($data)>1){
		$return['thead']	= '<th>'.L('currency').'</th>';
		$return['td_qn']	= 1;
	}else{
		$return['td_qn']	= 0;
	}
	return $return;
}



function smarty_block_td($params, $content,&$smarty, &$repeat){
	define('TPL_MODULE_NAME', !empty($smarty->getVariable('tpl_module_name')->value) ? $smarty->getVariable('tpl_module_name')->value : MODULE_NAME);
	define('TPL_ACTION_NAME', !empty($smarty->getVariable('tpl_action_name')->value) ? $smarty->getVariable('tpl_action_name')->value : ACTION_NAME);
	if(empty($content)){
		$repeat	= true;
	}
	$show	= false;
	$autoshow=true;
	$type	= $extra = '';
	$flow			= $smarty->getVariable('flow')->value;
	$action_name	= $smarty->getVariable('detail_action')->value;
	$item			= $smarty->getVariable('item')->value;
	$viewaction		= $smarty->getVariable('viewaction')->value;
	foreach($params as $_key=>$_val){
		switch($_key){
			case 'item':
				$smarty->assign($_key,$_val);break;
			case 'flow':
				$$_key	= $_val;break;
			case 'type':
				$$_key	= $_val;break;
			case 'action':
				$$_key	= $_val;break;
			case 'view':
				$$_key	= $_val;
				break;
			case 'viewaction':
				$$_key	= (array)$_val;break;
			case 'view_delimiter':
				$$_key	= $_val;
				break;			
			case 'w_id':
				$w_name	= $_val;break;
			case 'currency_name':
				$currency_name = $_val;break;
			case 'viewstate':
				$$_key	= $_val;break;
			case 'tfoot_value':
				$$_key	= $_val;break;
			case 'tfoot':
				$$_key	= $_val;break;
			case 'style':
				$$_key	= $_val;
//				$extra	.= $_key.'="'.smarty_function_escape_special_chars($_val).'" ';
				break;
			default:
				$extra	.= $_key.'="'.smarty_function_escape_special_chars($_val).'" ';break;
		}
	}
	$action_name	= TPL_ACTION_NAME;
	if(!in_array(TPL_ACTION_NAME,$action)&&!empty($action)){
		$show=false;
		$repeat=false;
	}
//	if($view=='product_no'){
//		$content	.= smarty_function_autoShow();
//	}
	if(!empty($flow)&&!empty($type)){
		$config	= C($flow);
		switch($type){
			//条形码
			case 'flow_barcode':
				if(C('barcode')==1){
					$show=true;
				}
				break;
			//颜色
			case 'flow_color':
				if($config['color']==1){
					$show=true;
				}
				break;
			//尺码
			case 'flow_size':
				if($config['size']==1){
					$show=true;
				}
				break;
			//箱数
			case 'flow_quantity':
				$show=true;
				break;
			//每箱包数
			case 'flow_capability':
				if($config['storage_format']>=2){
					$show=true;
				}
				break;
			//每包数量
			case 'flow_dozen':
				if($config['storage_format']>=3){
					$show=true;
				}
				break;
			//总数量
			case 'flow_row_total':
				if($config['storage_format']>=2){
					$show=true;
				}
				break;
			//尾箱
			case 'flow_mantissa':
				if($config['mantissa']==1){
					$show=true;
				}
				break;
			//仓库
			case 'flow_multi_storage':
				if($flow=='sale'&&C('sale.relation_sale_follow_up')==1){	//销售流程 配置为有后续流程 不需要显示仓库
					$show=false;
					break;
				}
				if(C('multi_storage')==1){//多仓库
					$show=true;
				}else{
					smarty_function_getDefaultWarehouse($w_name,$smarty,$repeat);
				}
				break;
			//换货显示仓库   销售有后续流程 不显示仓库  没有则显示仓库
			case 'flow_return_sale_warehouse':
				if(C('sale.relation_sale_follow_up')==1){
					$show=false;
				}else{
					if(C('multi_storage')==1){//多仓库
						$show=true;
					}else{
						$show=false;
						smarty_function_getDefaultWarehouse($w_name,$smarty,$repeat);
					}
				}
				break;
			case 'flow_return_warehouse':
				if(C('multi_storage')==1){
					$show=true;
				}else{
//					$show=false;
					smarty_function_getDefaultWarehouse($w_name,$smarty,$repeat);
				}
				break;
			//厂家币种
			case 'flow_factory_currency':
				$show	= smarty_function_getFlowCurrency($type,$currency_name,$smarty,$repeat);
				break;
			//客户币种
			case 'flow_client_currency':
				$show	= smarty_function_getFlowCurrency($type,$currency_name,$smarty,$repeat);
				break;
			//物流公司币种
			case 'flow_logistics_currency':
				$show	= smarty_function_getFlowCurrency($type,$currency_name,$smarty,$repeat);
				break;
			//本公司币种
			case 'flow_company_currency':
				$show	= smarty_function_getFlowCurrency($type,$currency_name,$smarty,$repeat);
				break;
			//运费  入库显示金额为否时  不显示明细 运费
			case 'flow_show_instock_logistics_funds':
				if(C('instock.instock_logistics_funds')==1&&TPL_ACTION_NAME!='add'&&C('instock.instock_price_show')==1){
						$show=true;
				}
				break;
			//入库单价
			case 'flow_instock_price_show':
				if(C('instock.instock_price_show')==1){
					$show=true;
				}else{
					$repeat==false && print '<input type="hidden" name="detail['.$smarty->getVariable('index')->value.'][price]" value="'.$item['price'].'">';
				}
				break;
			//入库金额
			case 'flow_instock_total_money':
				if(C('instock.instock_price_show')==1){
					$show=true;
				}
				break;
			case 'flow_per_size':
				if(C('instock.delivery')==2){
					$show=true;
				}
				break;
			case 'flow_per_capability':
				if(C('instock.delivery')==2){
					$show=true;
				}
				break;
			//销售折扣
			case 'flow_sale_discount':
				if(C('sale.sale_client_count_money')==1){
					$show=true;
				}
				break;
			//销售折扣金额 added by jp 20131227
			case 'flow_sale_account_money':
				if(C('sale.sale_client_count_money')==1){
					$show=true;
				}
				break;				
			//销售折后金额
			case 'flow_sale_after_discount':
				if(C('sale.sale_client_count_money')==1){
					$show=true;
				}
				break;
			//发货单价
			case 'flow_delivery_price':
				if(C('delivery.delivery_price_show')==1){
					$show=true;
				}else{
					$show=false;
					$repeat==false && print '<input type="hidden" name="detail['.$smarty->getVariable('index')->value.'][price]" value="'.$item['price'].'" row_total_money>';
				}
				break;
			//发货金额
			case 'flow_delivery_money':
				if(C('delivery.delivery_price_show')==1){
					$show=true;
				}
				break;
			//发货折扣
			case 'flow_delivery_discount':
				if(C('delivery.delivery_price_show')==1 && C('sale.sale_client_count_money')==1){
					$show=true;
				}else{//added by jp 20131227
					$show=false;
					$repeat==false && print '<input type="hidden" name="detail['.$smarty->getVariable('index')->value.'][discount]" value="'.$item['discount'].'" row_total_disount>';
				}
				break;
			//发货折扣金额 added by jp 20131227
			case 'flow_delivery_account_money':
				if(C('delivery.delivery_price_show')==1 && C('sale.sale_client_count_money')==1){
					$show=true;
				} else {
					$show=false;
					$repeat==false && print '<input type="hidden" name="detail['.$smarty->getVariable('index')->value.'][account_money]" value="'.$item['account_money'].'" row_total_account_money>';
				}
				break;					
			//发货折扣金额
			case 'flow_delivery_after_discount':
				if(C('delivery.delivery_price_show')==1 && C('sale.sale_client_count_money')==1){
					$show=true;
				}
				break;
			//发票显示成分
			case 'flow_invoice_ingredient':
				if($config['ingredient']==1&&$config['product_from']==2){
					$show=true;
				}
				break;
			//订货明细里 装柜总箱数
			case 'flow_load_quantity':
				if(C('loadContainer.storage_format')==1){
					$show=false;
				}else{
					$show=true;
				}
				break;
			//出发票显示折扣
			case 'flow_invoice_discount_money':
				if(C('invoice.discount_money')==1){
					$show = true;
				}
				break;
			//出发票显示折后金额
			case 'flow_invoice_discount_after_money':
				if(C('invoice.discount_money')==1){
					$show = true;
				}
				break;
			//发票产品号
			case 'flow_invoice_product_no':
				if(C('invoice.product')==1){
					$show = true;
				}
				break;
			//发票公司名称
			case 'flow_invoice_company':
				if(C('invoice.company_from')==2||(C('invoice.company_from')==1&&C('show_many_basic')==1)){
					$show = true;
				}
				break;
			case 'flow_unload_quantity':
				if(C('order.storage_format')>1){
					$show = true;
				}
				break;
			//查验规格，查验重量，查验状态，查验备注 added by jp 20140320
			case 'flow_check_config':
				if (TPL_ACTION_NAME !== 'add') {
					$show = true;
					if (getUser('role_type') == C('SELLER_ROLE_TYPE')){//卖家不可编辑，直接显示
						$viewaction[]	= TPL_ACTION_NAME;
					}
				}
				break;	
			case 'flow_instock_in_quantity':
				if ($flow =='instock' && TPL_ACTION_NAME !== 'add') {
					$show = true;
				}
				break;	
			case 'flow_instock_diff_quantity':
				if ($flow =='instock' && TPL_ACTION_NAME !== 'add') {
					$show = true;
				}
				break;
			case 'p_id':
				if ($flow =='sale' &&  TPL_ACTION_NAME == 'view') {
					$show = true;
				}
				break;
			case 'verify_quantity':
				if ($flow == 'verify') {
					$show = true;
				}
				break;	                
            //序列号ID added by yyh 20140929
            case 'flow_serial_id_config':
				if (TPL_ACTION_NAME === 'view') {
					$show = true;
				}
                break;                
			//箱号ID added by jp 20140408
			case 'flow_box_id_config':
				if (TPL_ACTION_NAME === 'view') {
					$show = true;
				}
				break;		
			//产品ID added by jp 20140408
			case 'flow_product_id_config':
				if (TPL_ACTION_NAME === 'view') {
					$show = true;
				}
				break;					
			default:
				$show=true;break;
		}
	}else{
		$show=true;
	}
	//根据状态去判断是否可编辑
	$state	= $item[key($viewstate)];
	if(in_array(TPL_ACTION_NAME,$viewaction)&&!empty($view)){
		$print	= 'print_view';
		$smarty->assign('readonly','');
	}elseif(in_array($state,reset($viewstate))&&!empty($viewstate)){
		$print	= 'print_readonly';
		preg_match("/<input.*?type=\"text\".*?class=\"(.*?)\".*?>/i",$content,$rs);
		if(empty($rs[1])){
			$smarty->assign('readonly','readonly class="disabled"');
		}else{
			$smarty->assign('readonly','readonly');
			$content= preg_replace('/(<input.*?type=\"text\".*?class=\")(.*?)(\".*?>)/i',"\${1}\${2} disabled\${3}",$content);
		}
		$content= str_replace('jqac','',$content);
	}else{
		$print	= 'print';
		$smarty->assign('readonly','');
	}
	//
	if(ACTION_SENT_EMAIL==1){
		$style	.= 'border-top:1px solid #cccccc;border-right:1px solid #cccccc;height:26px;line-height:26px;padding-left:3px;padding-right:3px;color:#333333;font-weight: normal;white-space:nowrap;font-size:12px;';
		
	}
	if($view=='dd_mantissa'&&(TPL_ACTION_NAME=='view'||ACTION_SENT_EMAIL==1)){
		$item['mantissa']==1 && $item['dd_mantissa']='';
		$item['mantissa']==2 && $item['dd_mantissa']='√';
		$print= 'print_view';
	}
	//退货显示图标
	if($view=='treatment'&&TPL_MODULE_NAME=='ReturnSaleOrder'&&TPL_ACTION_NAME=='view'){
		$print = 'print_readonly';
	}
	if($show==true&&!empty($content)){
		$detail_tfoot	= $smarty->getVariable('detail_tfoot')->value;
		if($detail_tfoot==1){//加入底部
			$style	= 'style="'.$style.' color:red;font-weight: bold;"';
			foreach($tfoot as $key=>$val){
				$tfoot_extra .= $key.'="'.smarty_function_escape_special_chars($val).'" ';
			}
			print '<td  '.$tfoot_extra.$style.'>'.$tfoot_value.'&nbsp;</td>';
		}else{
			$style	= 'style="'.$style.'"';
			if($view=='product_no'){
				$content	.= smarty_function_autoShow(array(),$smarty);
			}elseif($view=='product_id' && TPL_MODULE_NAME=='ReturnSaleOrder' && getUser('role_type') != C('SELLER_ROLE_TYPE')){
                $content	.= smarty_function_autoShow(array(),$smarty,'ReturnRealStorage');
            }
			switch($print){
				case 'print':
					print '<td '.$extra.$style.'>'.$content.'</td>';break;
				case 'print_view':
					if($view=='product_no'){
						print '<td '.$extra.$style.'>'.$item[$view].smarty_function_autoShow(array(),$smarty).'</td>';
                    }elseif($view=='product_id' && TPL_MODULE_NAME=='ReturnSaleOrder' && getUser('role_type') != C('SELLER_ROLE_TYPE')){
                        print '<td '.$extra.$style.'>'.$item[$view].smarty_function_autoShow(array(),$smarty,'ReturnRealStorage').'</td>';
                    }else{
						$views	= explode(',', $view);
						foreach ($views as $view) {
							$html[]	= $item[$view];
						}
						print '<td '.$extra.$style.'>' . implode($view_delimiter ? $view_delimiter : ",", $html) . '</td>';
					}
					break;
				case 'print_readonly':
					print '<td '.$extra.$style.'>'.$content.'</td>';break;
				default:
					break;
			}
		}
	}
}
?>