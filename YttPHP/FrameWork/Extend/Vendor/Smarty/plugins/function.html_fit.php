<?php


/**
 * 产品配比:还有一个计算合计的JS函数在对应JS文件中
 *
 * @param  array $params
 * @return string
 */
function smarty_function_html_fit($params){
	if (!C('PRODUCT_COLOR') || !C('PRODUCT_SIZE')) {return ;}
	$extra = '';
	$id = 'fit';
	$readonly = false;
	$value = array();
	foreach($params as $key => $val) {
		 switch ($key) {
		 	case 'value':
		 		$total = array();
				$_color = S('color');
				$_size	= S('size');
			case 'readonly':
		 	case 'id':
		 		$$key = $val;
		 		break;
		 	default:
		 		$extra .= ' '.$key.'="'.$val.'"';
		 		break;
		 }
	}  
	
//	 设置固定值
	$max_row 	= C('FIT_MAX_ROW') ? C('FIT_MAX_ROW')+2 : 7;
	$max_cols	= C('FIT_MAX_COLS') ? C('FIT_MAX_COLS')+2 : 7;
	
	$_html[1][1] = '<td class="alltotal_color w80">'.L('color').'/'.L('size').'</td>';
	$_html[1][$max_cols] = '<td class="total_color">'.L(total).'</td>';
	$_html[$max_row][1] = '<td class="total_color">'.L(total).'</td>';
	$function = empty($readonly) ? 'editOutput' : 'viewOutput';
	$td_extra = ' onmouseover="javascript:setBgColor(this);" onmouseout="javascript:clearBgColor();"';
	return $function($id,$_html,$extra,$value,$_color,$_size,$max_row,$max_cols,$td_extra);
}


function editOutput($id,$_html,$extra,$value,$_color,$_size,$max_row,$max_cols,$td_extra){
	// 添加合计事件,数量控件有效
	$onkeyup = ' onkeyup="javascript:sumQuantity(this);"';
	$html = '<table'.$extra.' id="'.$id.'">';
	for ($i=1;$i<=$max_row;$i++){
		$html .= '<tr>';
		for ($j=1;$j<=$max_cols;$j++){
			$ids = 'row="'.$i.'" cols="'.$j.'"';
			$index = 'rowindex="'.$i.'" colsindex="'.$j.'"';
			if (isset($_html[$i][$j])) {
				$html .= $_html[$i][$j];
			}else {
				if ($i==1) { 
					$html .= '
					<td  class="size_color" '.$index.'>
					<input type="hidden" name="fit['.$i.']['.$j.']" id="fit['.$i.']['.$j.']" value="'.$value[$i][$j].'">
					<input name="temp[]" value="'.$_size[$value[$i][$j]]['size_name'].'" url="'.U('/AutoComplete/size').'" jqac>
					</td>';
				}elseif ($j==1){ 
					$html .= '
					<td class="size_color" '.$index.'>
					<input type="hidden" name="fit['.$i.']['.$j.']" id="fit['.$i.']['.$j.']" value="'.$value[$i][$j].'">
					<input name="temp[]" value="'.$_color[$value[$i][$j]]['color_name'].'" url="'.U('/AutoComplete/color').'" jqac>
					</td>';
				}elseif ($i==$max_row && $j==$max_cols){
					$html .= '<td id="all_total" class="alltotal_color">'.$total['all'].'</td>';
				}elseif($i==$max_row){
					$html .= '<td id="total_cols'.$j.'" class="total_color">'.$total['cols'][$j].'</td>';
				}elseif($j==$max_cols){
					$html .= '<td id="total_row'.$i.'" class="total_color">'.$total['row'][$i].'</td>';
				}else {
					$total['row'][$i] += $value[$i][$j];
					$total['cols'][$j] += $value[$i][$j];
					$total['all'] += $value[$i][$j];
					$html .= '<td '.$td_extra.' '.$index.'><input name=fit['.$i.']['.$j.'] type="text" value="'.$value[$i][$j].'"'.$ids.$onkeyup.'></td>';
				}
			}
		}
		$html .='</tr>';
	}
	$html .= '</table><div style="clear:both;height:5px;"><div>';
	return $html;
}

function viewOutput($id,$_html,$extra,$value,$_color,$_size,$max_row,$max_cols,$td_extra){
	// 添加合计事件,数量控件有效
	$html = '<table'.$extra.' id="'.$id.'">';
	for ($i=1;$i<=$max_row;$i++){
		$html .= '<tr>';
		for ($j=1;$j<=$max_cols;$j++){
			$index = 'rowindex="'.$i.'" colsindex="'.$j.'"';
			if (isset($_html[$i][$j])) {
				$html .= $_html[$i][$j];
			}else {
				if ($i==1) {
					$html .= '<td class="size_color" '.$index.'>'.$_size[$value[$i][$j]]['size_name'].'</td>';
				}elseif ($j==1){
					$html .= '<td class="size_color" '.$index.'>'.$_color[$value[$i][$j]]['color_name'].'</td>';
				}elseif ($i==$max_row && $j==$max_cols){
					$html .= '<td id="all_total" class="alltotal_color">'.$total['all'].'</td>';
				}elseif($i==$max_row){
					$html .= '<td id="total_cols'.$j.'" class="total_color">'.$total['cols'][$j].'</td>';
				}elseif($j==$max_cols){
					$html .= '<td id="total_row'.$i.'" class="total_color">'.$total['row'][$i].'</td>';
				}else {
					$total['row'][$i] += $value[$i][$j];
					$total['cols'][$j] += $value[$i][$j];
					$total['all'] += $value[$i][$j];
					$html .= '<td '.$index.$td_extra.'>'.$value[$i][$j].'</td>';
				}
			}
		}
		$html .='</tr>';
	}
	$html .= '</table><div style="clear:both;height:5px;"><div>';
	return $html;
}
?>