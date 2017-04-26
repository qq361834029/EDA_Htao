<?php

function smarty_function_wz($params)
{	
	$action        = $params['action'];
	$print_name    = $params['printid'];
	$print_width   = $params['print_width'] ? ','.$params['print_width'] : '';
	$print_height  = $params['print_height'] ? ','.$params['print_height'] : '';
	$is_update     = $params['is_update'];
	$button		   = $params['button'];
	if ($action) {
		$action = explode(',',$action);
		$return_action = '';
		foreach ($action as $value) {
			switch ($value) {
				case 'save':
					$button_text    = isset($params[$value.'_name']) ? L($params[$value.'_name']):L('submit');
                    if(MODULE_NAME  == 'InstockImport' && ACTION_NAME  == 'add'){
                        $return_action .='<input class="button_new" type="button" value="'.$button_text.'" onclick="javascript:$dom.find(\'#submit_type\').val(0);$.checkRepeat(this);">';
                    }elseif(MODULE_NAME  == 'ReturnSaleOrder' && ACTION_NAME  == 'add') {
                        $return_action .='<input class="button_new" type="button" value="'.$button_text.'" onclick="javascript:$dom.find(\'#check_repeat\').val(0);$(this.form).submitForm(0);">';
                    }else{
                        $return_action .='<input class="button_new" type="button" value="'.$button_text.'" onclick="javascript:$(this.form).submitForm(0);">';
                    }
                    break;
				case 'save_print':
					$button_text    = ACTION_NAME=='outStock'?L('ship_print'):L('save_print');
					$return_action .='<input class="button_new" type="button" value="'.$button_text.'" onclick="javascript:$(this.form).submitForm(4);">';
					break;				
				case 'list':
                    if(MODULE_NAME  == 'InstockImport' && ACTION_NAME  == 'add'){
                        $return_action .='<input class="button_new " type="button" value="'.L('submit_list').'" onclick="javascript:$dom.find(\'#submit_type\').val(1);$.checkRepeat(this);">';
					}else{
                        $return_action .='<input class="button_new " type="button" value="'.L('submit_list').'" onclick="javascript:$(this.form).submitForm(1);">';
					}
                    break;
				case 'save_announce':
					$return_action .='<input class="button_new " type="button" value="'.L('save_announce').'" onclick="javascript:$(this.form).submitForm(5);">';
                    break;
				case 'hold':
					$return_action .='<input class="button_new" type="button" value="'.L('hold').'" onclick="javascript:$(this.form).submitForm(2);">';
					break;
				case 'confirm':
					$return_action .='<input class="button_new" type="button" value="'.L('recharge_confirm').'" onclick="javascript:$(this.form).submitForm(1);">';
					break;
				case 'temp':
					$return_action .='<input class="button_new" type="button" value="'.L('temp').'" onclick="javascript:$(this.form).submitForm(3);">';
					break;
				case 'reset':
					$button_text = 'onclick="javascript:loadTab();"';
					if(ACTION_NAME=='outStock'){
						if($_GET['verifyType']==1){
							/*
							$button_text = ' onclick="$.edit(this);" url="'.U('/SaleOrder/outStock/id/'.$_GET['id'].'/verifyType/1').'" 
											title="'.L('verify_delivery').'" ';
							*/
							$button_text = 'onclick="javascript:loadTab();"';
						}elseif($_POST['query']['b.product_id']>0){
							$button_text = ' onclick="javascript:outStockReset();" ';
						}
					}
					$return_action .='<input class="button_new" type="button" '.$button_text.' value="'.L('reset').'">'; 
					break;
                case 'print_waybill'://订单出库 打印运单add yyh20160301
                    $return_action .='<input class="button_new" type="button" value="'.L('print_waybill').'" onclick="$.printWaybill();">';
                    break;
                case 'submit':
					$return_action .='<input class="button_new" type="button" value="'.L('sub').'" onclick="javascript:$(this.form).submitForm(2);">';
					break;
				default:
					break;
			}
		}
		if($button==true){
			return '<input type="hidden" value="0" id="submit_type" name="submit_type"><input type="hidden" value="js" name="referer">
				    <div class="button_out_stock">'.$return_action.'</div>';
		}
		$return_action = '<input type="hidden" value="0" id="submit_type" name="submit_type"><input type="hidden" value="js" name="referer"><div class="button_place">'.$return_action.'</div>';
	}
	$return = '<div class="nav_bg"><div class="nav_word">'.L('current_position').' >> ';
	$parent = parentsTitle(MODULE_NAME);
	if(MODULE_NAME !== 'ClientStat'){
		$return_link = '<font class="tbold">'.$parent.'-> <a href="javascript:;" onclick="javascript:linkTab(\''.U(MODULE_NAME.'/index').'\',\''.title('index').'\',1)">'.title('index').'</a> -> ';
	}else{
		$return_link = '<font class="tbold">'.$parent.'-> '.title('index').' -> ';
	}
	
	switch (ACTION_NAME) {
		case 'add':
			$return .= $return_link.title('add');
			$action = 'INSERT';
			break;
		case 'edit':
            $title  = isset($params['title']) ? L($params['title']) : title('edit');
			$return .= $return_link.$title;
			$action = 'UPDATE';
			break;
		case 'view':
			$return .= $return_link.title('view');
			$action = 'VIEW';
			break;
		case 'insertcity':
			$return .= $return_link.title('insertcity');
			$action = ACTION_NAME=='index' ? strtoupper(MODULE_NAME) : strtoupper(ACTION_NAME);
			break;
		default:
			$return .= '<font class="tbold">'.$parent.' -> '.title(ACTION_NAME);
			$action = ACTION_NAME=='index' ? strtoupper(MODULE_NAME) : strtoupper(ACTION_NAME);
			break;
	}
	$return .= '</font>';
	$return .= '( <a href="javascript:;" onclick="closeTab()">'.L('close').'</a>';
	$module = strtoupper(MODULE_NAME);
	// 有显示的菜单才可以做为快捷菜单添加
	if ($_SESSION['_MODULE_ACCESS_'][$module][$action]['group_id']>0 || ACTION_NAME=='insertcity') {
		$return .= ' <a href="javascript:;" url="'.U('Ajax/setShortcutMenu').'" onclick="$.shortcutMenu(this,\''.MODULE_NAME.'\',\''.ACTION_NAME.'\')">'.L('fast_key').'</a>';
	}
	$return .= ' )</div>';
	$return .= $return_action;
	$return .= '<div class="note_right" style="margin:10px 30px 0 0;"><dl>';
	if (in_array($action,array('VIEW','VIEWNOTPRICE'))||$params['print']==true) {
		if(isset($_SESSION['_MODULE_ACCESS_'][$module]['UPDATE'])&&($is_update==1||!isset($is_update))) {	
			$return .= '<a href="javascript:;" onclick="$.edit(this);" url="'.U('/'.MODULE_NAME.'/edit/id/'.$_GET['id']).'" title="'.title('edit').'"><dt><span class="icon icon-list-edit icon-detail"></span>'.title('edit').'</dt></a>';
		}
		if (!isset($params['print']) || $params['print']!==false) {
			$return .='<a href="javascript:;" onclick="javascript:PrintMytable(\''.$print_name.'\''.$print_width.$print_height.');"><dt><span class="icon icon-list-print"></span>'.L('print').'</dt></a>';
		}
	}
	$return .= '</dl></div></div><div class="fill_top"></div>';
	return $return;
}



?>