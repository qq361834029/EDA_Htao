<?php

function smarty_function_note($params)
{	extract($params);
	$params['content'] && $content = '<div class="fl">'.$params['content'].'</div>';
	$params['tabs'] && $content = $params['content'];
	$add_button = '';
	$no_add_module = array('PreDelivery','Delivery','InstockStorage','ReturnSaleOrderStorage');
	if(C('instock.add')==2){$no_add_module[] = 'Instock';}
	if($insert!==false && isset($_SESSION['_MODULE_ACCESS_'][strtoupper(MODULE_NAME)]['INSERT']) && !in_array(MODULE_NAME,$no_add_module)) {
		$add_button = '<a href="javascript:;" onclick="addTab(\''.U(MODULE_NAME.'/add').'\',\''.title('add').'\')"><dt><span class="icon icon-list-add"></span>'.title('add').'</dt></a>';
	}

	if($export==true){
		$export_button='<a href="javascript:;" onclick="javascript:ExportMytable(\''.MODULE_NAME.'\');"><dt class="margin_right_8"><span class="icon icon-list-export"></span>'.L('export').'</dt></a>';
	}
	if(MODULE_NAME == 'SaleOrder'){
		$export_button	.='<a href="javascript:;" onclick="javascript:ExportMytable(\'' . MODULE_NAME . 'Report\');"><dt class="margin_right_8"><span class="icon icon-list-export"></span>'.L('export_report').'</dt></a>';
	}
	if($exportBarcode==true){
		$exportBarcode_button='<a href="javascript:;" onclick="javascript:$.quicklyExportBarcode(\''.MODULE_NAME.'\', null, \'batch\');"><dt class="margin_right_8"><span class="icon icon-list-export"></span>'.L('exportBarcode').'</dt></a>';
	}	
	if($expand==true){
		$export_button.='<a href="javascript:;" onclick="javascript:expandAllDetail();"><dt class="margin_right_8"><span class="icon icon-list-expand"></span>'.L('add_open').'</dt></a>';
	}
    if($accord_location_export    == true && ($_SESSION[C('ADMIN_AUTH_KEY')] || getUser('role_type')==C('WAREHOUSE_ROLE_TYPE'))){
        $accord_location_export_button='<a href="javascript:;" onclick="javascript:ExportMytable(\'location'.MODULE_NAME.'\');"><dt class="margin_right_8"><span class="icon icon-list-export"></span>'.L('accord_location_export').'</dt></a>';
	}
    if($accord_sku_export    == true && ($_SESSION[C('ADMIN_AUTH_KEY')] || getUser('role_type')==C('WAREHOUSE_ROLE_TYPE'))){
        $accord_sku_export_button='<a href="javascript:;" onclick="javascript:ExportMytable(\'sku'.MODULE_NAME.'\');"><dt class="margin_right_8"><span class="icon icon-list-export"></span>'.L('accord_sku_export').'</dt></a>';
	}
    if($all_delete == true){
		$all_delete_button='<a href="javascript:;" onclick="javascript:AllDelete();"><dt class="margin_right_8"><span class="icon icon-list-del"></span>'.L('delete_all_check').'</dt></a>';
	}
	//按先进先出规则      add by lxt 2015.06.16
	if ($accord_fifo_export==true && ($_SESSION[C('ADMIN_AUTH_KEY')] || getUser('role_type')==C('WAREHOUSE_ROLE_TYPE'))){
	    $accord_fifo_export    =   '<a href="javascript:;" onclick="javascript:ExportMytable(\'fifo'.MODULE_NAME.'\');"><dt class="margin_right_8"><span class="icon icon-list-export"></span>'.L('accord_fifo_export').'</dt></a>';
	}else{
        $accord_fifo_export = '';
    }
    //新增出库批次 add by yyh 20150831
    if($out_batch== true){//新页面打开查询页面token需要重置
        $out_batch  = '<a href="javascript:;" onclick="isCheckPackBox('.$out_batch.',\''.U('OutBatch/add?record_check_token='.$out_batch).'\',\''.L('add').L('module_outbatch').'\');"><dt class="margin_right_8"><span class="icon icon-shortcut-car"></span>'.L('outStock').'</dt></a>';
    }
    //清空勾选 add by yyh 20150831
    if($clean_check == true){
        $clean_check  = '<a href="javascript:;" onclick="cleanCheck(\''.MODULE_NAME.'\');"><dt class="margin_right_8"><span class="icon icon-restore"></span>'.L('clean_check').'</dt></a>';
    }
    
    //销售单批量上传 add by yyh 20150831
    if($batch_upload == true){
        $batch_upload   = '<a href="javascript:;" onclick="javascript:$.batchUpload();"><dt class="margin_right_8"><span class="icon icon-list-addInvoice"></span>'.L('batch_upload').'</dt></a>';
    }
	//合并订单
	$combine_button = '';
	if($combine==true){
		$combine_button='<a href="javascript:;" onclick="javascript:CombineSaleOrderCheck(this);" url="'.U('/Public/addCombine').'"><dt class="margin_right_8"><span class="icon icon-list-expand"></span>'.L('order_combin').'</dt></a>';
	}
	//退货入库单导出      add by lxt 2015.09.22
	if ($return_storage==true){
	    $return_storage_button =   '<a href="javascript:;" onclick="javascript:$.quicklyExportReturnStorage();"><dt class="margin_right_8"><span class="icon icon-list-export"></span>'.L('piking_export').'</dt></a>';
	}
    if(MODULE_NAME == 'OutBatch'){
        $out_batch_node_content = '<span style="color:#0088D1;">'.L('out_batch_node_content').'</span>'; 
    }
	if($print!==false){
		$print_button	= '<a href="javascript:;" onclick="javascript:PrintMytable(\'' . $printid . '\');"><dt class="margin_right_8"><span class="icon icon-list-print"></span>'.L('print').'</dt></a>';
	}
	$html =  '<div class="woaicss">';
	$html .= '<div class="fl"><ul class="woaicss_title woaicss_title_bg1" id="woaicsstitle">';
	$html .= smarty_function_flow_tabs($tabs);
	$html .= '</ul></div>';
	$html .= '<div class="note_left">'.$content.$out_batch_node_content.'</div>';
		$html .= '<div class="note_right">
				<dl>
					'.$add_button.$print_button.$clean_check.$out_batch.$exportBarcode_button.$export_button.$combine_button.$accord_location_export_button.$accord_sku_export_button.$all_delete_button.$return_storage_button.$batch_upload.$accord_fifo_export.'
				</dl>
			</div>';
	$html .= '</div>';
	return $html;
}

function smarty_function_flow_tabs($flow=null){
	$tabs = '';
	switch ($flow) {
		case 'orders':
			$tabs = '';
			$class = '';
			if (isset($_SESSION['_MODULE_ACCESS_']['ORDERS']['ORDERS'])) {
				ACTION_NAME == 'index' && $class=' class="woaicss_click" ';
				$href  = U(MODULE_NAME.'/index');
				$title = title('index');
				$tabs .= '<li><a href="javascript:;" onclick="linkTab(\''.$href.'\',\''.$title.'\',1)"'.$class.'>'.$title.'</a></li>';
			}
			$class = '';
			if (isset($_SESSION['_MODULE_ACCESS_']['ORDERS']['ALISTUNFINISHORDER'])) {
				ACTION_NAME == 'alistUnfinishOrder' && $class=' class="woaicss_click" ';
				$href  = U(MODULE_NAME.'/alistUnfinishOrder');
				$title = title('alistUnfinishOrder');
				$tabs .= '<li><a href="javascript:;" onclick="linkTab(\''.$href.'\',\''.$title.'\',1)"'.$class.'>'.$title.'</a></li>';
			}
			$class = '';
			if (isset($_SESSION['_MODULE_ACCESS_']['ORDERS']['ALISTFINISHORDER'])) {
				ACTION_NAME == 'alistFinishOrder' && $class=' class="woaicss_click" ';
				$href  = U(MODULE_NAME.'/alistFinishOrder');
				$title = title('alistFinishOrder');
				$tabs .= '<li><a href="javascript:;" onclick="linkTab(\''.$href.'\',\''.$title.'\',1)"'.$class.'>'.$title.'</a></li>';
			}
			break;
		case 'loadContainer':
			$tabs = '';
			$class = '';
			if (isset($_SESSION['_MODULE_ACCESS_']['LOADCONTAINER']['LOADCONTAINER'])) {
				ACTION_NAME == 'index' && $class=' class="woaicss_click" ';
				$href  = U(MODULE_NAME.'/index');
				$title = title('index');
				$tabs .= '<li><a href="javascript:;" onclick="linkTab(\''.$href.'\',\''.$title.'\',1)"'.$class.'>'.$title.'</a></li>';
			}
			$class = '';
			
			if (isset($_SESSION['_MODULE_ACCESS_']['LOADCONTAINER']['ALISTUNDELIVERY'])) {
				ACTION_NAME == 'alistUndelivery' && $class=' class="woaicss_click" ';
				$href  = U(MODULE_NAME.'/alistUndelivery');
				$title = title('alistUndelivery');
				$tabs .= '<li><a href="javascript:;" onclick="linkTab(\''.$href.'\',\''.$title.'\',1)"'.$class.'>'.$title.'</a></li>';
			}
			$class = '';
			if (isset($_SESSION['_MODULE_ACCESS_']['LOADCONTAINER']['WAITLOADCONTAINER'])) {
				ACTION_NAME == 'waitLoadContainer' && $class=' class="woaicss_click" ';
				$href  = U(MODULE_NAME.'/waitLoadContainer');
				$title = title('waitLoadContainer');
				$tabs .= '<li><a href="javascript:;" onclick="linkTab(\''.$href.'\',\''.$title.'\',1)"'.$class.'>'.$title.'</a></li>';
			}
			break;
		case 'instock':
			$tabs = '';
			$class = '';
			if (isset($_SESSION['_MODULE_ACCESS_']['INSTOCK']['INSTOCK'])) {
				ACTION_NAME == 'index' && $class=' class="woaicss_click" ';
				$href  = U(MODULE_NAME.'/index');
				$title = title('index');
				$tabs .= '<li><a href="javascript:;" onclick="linkTab(\''.$href.'\',\''.$title.'\',1)"'.$class.'>'.$title.'</a></li>';
			}
			$class = '';
			if (isset($_SESSION['_MODULE_ACCESS_']['INSTOCK']['WAITINSTOCK'])) {
				ACTION_NAME == 'waitInstock' && $class=' class="woaicss_click" ';
				$href  = U(MODULE_NAME.'/waitInstock');
				$title = title('waitInstock');
				$tabs .= '<li><a href="javascript:;" onclick="linkTab(\''.$href.'\',\''.$title.'\',1)"'.$class.'>'.$title.'</a></li>';
			}
			break;
		case 'saleOrder':
			$tabs = '';
			$class = '';
			if (isset($_SESSION['_MODULE_ACCESS_']['SALEORDER']['SALEORDER'])) {
				ACTION_NAME == 'index' && $class=' class="woaicss_click" ';
				$href  = U(MODULE_NAME.'/index');
				$title = title('index');
				$tabs .= '<li><a href="javascript:;" onclick="linkTab(\''.$href.'\',\''.$title.'\',1)"'.$class.'>'.$title.'</a></li>';
			}
			/*
			$class = '';
			if (isset($_SESSION['_MODULE_ACCESS_']['SALEORDER']['ALISTUNFINISH'])) {
				ACTION_NAME == 'alistUnfinish' && $class=' class="woaicss_click" ';
				$href  = U(MODULE_NAME.'/alistUnfinish');
				$title = title('alistUnfinish');
				$tabs .= '<li><a href="javascript:;" onclick="linkTab(\''.$href.'\',\''.$title.'\',1)"'.$class.'>'.$title.'</a></li>';
			}
			$class = '';
			if (isset($_SESSION['_MODULE_ACCESS_']['SALEORDER']['ALISTFINISH'])) {
				ACTION_NAME == 'alistFinish' && $class=' class="woaicss_click" ';
				$href  = U(MODULE_NAME.'/alistFinish');
				$title = title('alistFinish');
				$tabs .= '<li><a href="javascript:;" onclick="linkTab(\''.$href.'\',\''.$title.'\',1)"'.$class.'>'.$title.'</a></li>';
			}*/
			break;
		case 'preDelivery':
			$tabs = '';
			$class = '';
			if (isset($_SESSION['_MODULE_ACCESS_']['PREDELIVERY']['PREDELIVERY'])) {
				ACTION_NAME == 'index' && $class=' class="woaicss_click" ';
				$href  = U(MODULE_NAME.'/index');
				$title = title('index');
				$tabs .= '<li><a href="javascript:;" onclick="linkTab(\''.$href.'\',\''.$title.'\',1)"'.$class.'>'.$title.'</a></li>';
			}
			$class = '';
			if (isset($_SESSION['_MODULE_ACCESS_']['PREDELIVERY']['WAITPREDELIVERY'])) {
				ACTION_NAME == 'waitPreDelivery' && $class=' class="woaicss_click" ';
				$href  = U(MODULE_NAME.'/waitPreDelivery');
				$title = title('waitPreDelivery');
				$tabs .= '<li><a href="javascript:;" onclick="linkTab(\''.$href.'\',\''.$title.'\',1)"'.$class.'>'.$title.'</a></li>';
			}
			break;
		case 'delivery':
			$tabs = '';
			$class = '';
			if (isset($_SESSION['_MODULE_ACCESS_']['DELIVERY']['DELIVERY'])) {
				ACTION_NAME == 'index' && $class=' class="woaicss_click" ';
				$href  = U(MODULE_NAME.'/index');
				$title = title('index');
				$tabs .= '<li><a href="javascript:;" onclick="linkTab(\''.$href.'\',\''.$title.'\',1)"'.$class.'>'.$title.'</a></li>';
			}
			$class = '';
			if (isset($_SESSION['_MODULE_ACCESS_']['DELIVERY']['WAITDELIVERY'])) {
				ACTION_NAME == 'waitDelivery' && $class=' class="woaicss_click" ';
				$href  = U(MODULE_NAME.'/waitDelivery');
				$title = title('waitDelivery');
				$tabs .= '<li><a href="javascript:;" onclick="linkTab(\''.$href.'\',\''.$title.'\',1)"'.$class.'>'.$title.'</a></li>';
			}
			break;
		case 'returnSaleOrder':
			$tabs = '';
			$class = '';
			if (isset($_SESSION['_MODULE_ACCESS_']['RETURNSALEORDER']['RETURNSALEORDER'])) {
				ACTION_NAME == 'index' && $class=' class="woaicss_click" ';
				$href  = U(MODULE_NAME.'/index');
				$title = title('index');
				$tabs .= '<li><a href="javascript:;" onclick="linkTab(\''.$href.'\',\''.$title.'\',1)"'.$class.'>'.$title.'</a></li>';
			}
			/*
			$class = '';
			if (isset($_SESSION['_MODULE_ACCESS_']['RETURNSALEORDER']['ALISTRETURNORDER'])) {
				ACTION_NAME == 'alistReturnOrder' && $class=' class="woaicss_click" ';
				$href  = U(MODULE_NAME.'/alistReturnOrder');
				$title = title('alistReturnOrder');
				$tabs .= '<li><a href="javascript:;" onclick="linkTab(\''.$href.'\',\''.$title.'\',1)"'.$class.'>'.$title.'</a></li>';
			}
			$class = '';
			if (isset($_SESSION['_MODULE_ACCESS_']['RETURNSALEORDER']['ALISTSALEORDER'])) {
				ACTION_NAME == 'alistSaleOrder' && $class=' class="woaicss_click" ';
				$href  = U(MODULE_NAME.'/alistSaleOrder');
				$title = title('alistSaleOrder');
				$tabs .= '<li><a href="javascript:;" onclick="linkTab(\''.$href.'\',\''.$title.'\',1)"'.$class.'>'.$title.'</a></li>';
			}
			$class = '';
			if (isset($_SESSION['_MODULE_ACCESS_']['RETURNSALEORDER']['RETURNNOUSE'])) {
				ACTION_NAME == 'returnNoUse' && $class=' class="woaicss_click" ';
				$href  = U(MODULE_NAME.'/returnNoUse');
				$title = title('returnNoUse');
				$tabs .= '<li><a href="javascript:;" onclick="linkTab(\''.$href.'\',\''.$title.'\',1)"'.$class.'>'.$title.'</a></li>';
			}*/
			break;
		case 'saleStorage':
			if (C('loadContainer.sale_storage')!=1) {
				return ;
			}
			$tabs = '';
			$class = '';
			if (isset($_SESSION['_MODULE_ACCESS_']['SALESTORAGE']['SALESTORAGE'])) {
				ACTION_NAME == 'index' && $class=' class="woaicss_click" ';
				$href  = U(MODULE_NAME.'/index');
				$title = title('index');
				$tabs .= '<li><a href="javascript:;" onclick="linkTab(\''.$href.'\',\''.$title.'\',1)"'.$class.'>'.$title.'</a></li>';
			}
			$class = '';
			if (isset($_SESSION['_MODULE_ACCESS_']['SALESTORAGE']['LCSTORAGE'])) {
				ACTION_NAME == 'lcStorage' && $class=' class="woaicss_click" ';
				$href  = U(MODULE_NAME.'/lcStorage');
				$title = title('lcStorage');
				$tabs .= '<li><a href="javascript:;" onclick="linkTab(\''.$href.'\',\''.$title.'\',1)"'.$class.'>'.$title.'</a></li>';
			}
			break;
		case 'realStorage':
			$tabs = '';
			$class = '';
			if (isset($_SESSION['_MODULE_ACCESS_']['REALSTORAGE']['REALSTORAGE'])) {
				ACTION_NAME == 'index' && $class=' class="woaicss_click" ';
				$href  = U(MODULE_NAME.'/index');
				$title = title('index');
				$tabs .= '<li><a href="javascript:;" onclick="linkTab(\''.$href.'\',\''.$title.'\',1)"'.$class.'>'.$title.'</a></li>';
			}
			$class = '';
			if (isset($_SESSION['_MODULE_ACCESS_']['REALSTORAGE']['MULTISTORAGE'])) {
				ACTION_NAME == 'multiStorage' && $class=' class="woaicss_click" ';
				$href  = U(MODULE_NAME.'/'.$_SESSION['_MODULE_ACCESS_']['REALSTORAGE']['MULTISTORAGE']['module']);
				$title = title('multiStorage');
				$tabs .= '<li><a href="javascript:;" onclick="linkTab(\''.$href.'\',\''.$title.'\',1)"'.$class.'>'.$title.'</a></li>';
			}
			break;
		case 'emailList':
			$tabs = '';
			$class = '';
			if (isset($_SESSION['_MODULE_ACCESS_']['EMAILLIST']['EMAILLIST'])) {
				ACTION_NAME == 'index' && $class=' class="woaicss_click" ';
				$href  = U(MODULE_NAME.'/index');
				$title = title('index');
				$tabs .= '<li><a href="javascript:;" onclick="linkTab(\''.$href.'\',\''.$title.'\',1)"'.$class.'>'.$title.'</a></li>';
			}
			$class = '';
			if (isset($_SESSION['_MODULE_ACCESS_']['EMAILLIST']['UNSENTEMAILLIST'])) {
				ACTION_NAME == 'unsentEmailList' && $class=' class="woaicss_click" ';
				$href  = U(MODULE_NAME.'/unsentEmailList');
				$title = title('unsentEmailList');
				$tabs .= '<li><a href="javascript:;" onclick="linkTab(\''.$href.'\',\''.$title.'\',1)"'.$class.'>'.$title.'</a></li>';
			}
			$class = '';
			if (isset($_SESSION['_MODULE_ACCESS_']['EMAILLIST']['DELETEEMAILLIST'])) {
				ACTION_NAME == 'deleteEmailList' && $class=' class="woaicss_click" ';
				$href  = U(MODULE_NAME.'/deleteEmailList');
				$title = title('deleteEmailList');
				$tabs .= '<li><a href="javascript:;" onclick="linkTab(\''.$href.'\',\''.$title.'\',1)"'.$class.'>'.$title.'</a></li>';
			}
			break;
		case 'dhlList':
		case 'correosList':
			$tabs	= '';
			$module	= strtoupper($flow);
			if (isset($_SESSION['_MODULE_ACCESS_'][$module][$module])) {
				$class= ACTION_NAME == 'index' ? ' class="woaicss_click" ' : '';
				$href  = U(MODULE_NAME.'/index');
				$title = title('index');
				$tabs .= '<li><a href="javascript:;" onclick="linkTab(\''.$href.'\',\''.$title.'\',1)"'.$class.'>'.$title.'</a></li>';
			}
			$action	= 'requestList';
			if (isset($_SESSION['_MODULE_ACCESS_'][$module][strtoupper($action)])) {
				$class= ACTION_NAME == $action ? ' class="woaicss_click" ' : '';
				$href  = U(MODULE_NAME.'/' . $action);
				$title = title($action);
				$tabs .= '<li><a href="javascript:;" onclick="linkTab(\''.$href.'\',\''.$title.'\',1)"'.$class.'>'.$title.'</a></li>';
			}
			break;
		default:
			break;
	}
	return $tabs;
}


?>