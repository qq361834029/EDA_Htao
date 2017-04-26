<?php
/**
 * 用于统计表格（统计表格过于复杂，只针对简单功能）
 * @param array $params
 *  - array from  数据源
 *  - string group 分组字段
 *  - string name 控件命名空间（同个页面多个tr）
 * @param string $content
 * @param object $smarty
 * @param bool $repeat
 */
function smarty_block_tr($params, $content,&$smarty, &$repeat){
	if(empty($content)){
		$repeat	= true;
	}
	$extra	=  '';
	$class	=  '';
	foreach($params as $_key=>$_val){
		switch($_key){
			case 'from':
				$$_key	= $_val;break;
			case 'group':
				break;
			case 'row':
				break;
			case 'class':
				$class	= $_val;
				break;
			case 'row_total':
				break;
			case 'name':
				$$_key	= $_val;
				$extra	.= $_key.='="'.$_val.'" ';
				break;
			default:
				$extra	.= $_key.'="'.$_val.'" ';
				break;
		}
	}
	$block_index	= 'block_stat_index_'.$name;
	$block_from		= 'block_stat_data_from_'.$name;
	$index			= intval($smarty->tpl_vars[$block_index]);
	$index			+=1;
	$smarty->tpl_vars[$block_index]	= $index;
	$block_content	= $content;
	if($index==1){
		$dataGrid	= new SmartyStatDataGrid($smarty);
		$dataGrid->setParams($params);
		$from		= _formatList($dataGrid->getData());
		$from		= $from['list'];
		$smarty		= $dataGrid->smarty;
		$smarty->assign('block_stat_from_count_'.$name,count($from));
		$smarty->tpl_vars[$block_from]	= $from;
	}
	//echo $smarty->getVariable('block_stat_from_count_'.$name)->value.'value ';
	if($smarty->getVariable('block_stat_from_count_'.$name)->value>=$index-1){
		list($key,$item)= each($smarty->tpl_vars[$block_from]);
		$smarty->assign('item',$item);
		$repeat		= true;
		/*
		if($class){
			$extra .=getClass($class,$item);
		}
		*/
		if($index>1){
			print '<tr '.$key.$extra.'>'.$content.'</tr>';
		}
	}
}

function getClass($class,$item){
	foreach (explode(';',$class) as $v){
		list($k,$v) = explode('=>',$v);
		$class_array[$k]=$v;
	}
	if(is_array($class_array)){
		if(in_array($item[$class_array['field']],explode(',',$class_array['requirement']))){
			$class_str ='class='.$class_array['class_name'];
		}
	}else{
		$class_str ='class='.$class_array;
	}
	return $class_str;
}

/**
 * td标签
 *
 * @param array $params
 *  - string merge 合并字段  多个用，隔开
 *  - string class 样式
 *  - string title 标题
 *  - bool total_link 合计时 是否需要链接
 *  - array link 链接参数
 * @param string $content
 * @param object $smarty
 * @param bool $repeat
 */
function smarty_block_td($params, $content,&$smarty, &$repeat){
	$extra	= '';
	$total_link	= true;
	foreach($params as $key=>$val){
		switch ($key){
			case 'merge':
				$merge	= $val;
				//需要合并的参数
				$stat_merge	= (array)$smarty->tpl_vars['block_merge_params'];
				if(!in_array($val,$stat_merge)){
					$stat_merge[]=$val;
					$smarty->tpl_vars['block_merge_params']	= $stat_merge;
				}
				break;
			case 'class':
				$$key	= $val;
				break;
			case 'title':
				$$key	= $val;
				break;
			case 'total_link':
				$$key	= $val;
				break;
			case 'link':
				$$key	=$val;
				break;
			default:
				$extra	.= $key.'="'.$val.'"';
				break;
		}
	}
	if(empty($content)){
		$repeat	= true;
	}
//	echo '<pre>';print_r($link);
	$item	= $smarty->getVariable('item')->value;
	if(!empty($link)){
		$url	= smarty_function_getUrl($link['url'],$link['link_id'],$item);
	}
	if($item['group_total']==1){
		$class	= 'red '.$class;
		isset($title)	&& $content	= $title.(empty($title)?'':'：');
		if(is_array($total_link)){
			$url		= smarty_function_getUrl($total_link['url'],$total_link['link_id'],$item);
			$url_arr	= @explode('/',$url);
			$content	= '<a onclick="addTab(\''.U('/'.$url).'\',\''.title($url_arr[1],$url_arr[0]).'\',1);" href="javascript:;">'.$content.'</a>';
		}elseif($total_link==false){
			$content	= preg_replace('/<a\s.*?>\s*(.*?)\s*<\/a>/i', '${1}', $content);
		}
	}elseif(!empty($url)){
		$url_arr= @explode('/',$url);
		$content	= '<a onclick="addTab(\''.U('/'.$url).'\',\''.title($url_arr[1],$url_arr[0]).'\',1);" href="javascript:;">'.$content.'</a>';
	}
//	echo $url;
	if(!empty($merge)){
		$dataGrid	= new SmartyStatDataGrid($smarty);
		$index		= $dataGrid->getMergeIndex($merge,$item);
		$rowspan	= $item[$index.'_rowspan'];
		if($item[$index.'_show']==0){
			$repeat==false && print '<td rowspan="'.$rowspan.'" '.$extra.' class="'.$class.'">'.$content.'</td>';
		}
	}else{
		$repeat==false && print '<td '.$extra.' class="'.$class.'">'.$content.'</td>';
	}
}



class SmartyStatDataGrid extends Smarty {
	//Smarty对象
	public $smarty;
	public $from;
	public $group;
	public $sum;
	public $merge;
	public $list;
	public $row_total;
	public $row;
	public $name;
	public function __construct(&$smarty){
		$this->smarty	= $smarty;
	}
	//参数
	public function setParams($params){
		foreach($params as $key=>$val){
			$this->$key	= $val;
		}
	}
	//重组数据
	public function getData(){
		$this->list	= $this->setGroupData();
		$this->mergeData();
		$this->resetData();
		return $this->from;
	}
	//分组数据
	public function setGroupData(){
		$list	= array();
		foreach($this->from as $_key=>$_val){
			$index	= $this->getGroupIndex($this->group,$_val);
			$list[$index]['list'][]	= $_val;
		}
		return $list;
	}
	//分组索引
	public function getGroupIndex($group,$list){
		if(empty($group)){
			return 0;
		}
		$param	= explode(',',$group);
		foreach($param as $_key=>$_val){
			$info[]	= $list[$_val];
		}
		return md5($group.'|'.implode(',',$info));
	}
	//合并行
	public function mergeData(){
		unset($this->smarty->tpl_vars['rowspan']);
		$merge_params	= $this->getMergeParams();
		foreach($this->list as $_key=>$_val){
			foreach($_val['list'] as $key=>$val){
				foreach($merge_params as $param){
					$index	= $this->getMergeIndex($param,$val);
					if(intval($this->smarty->tpl_vars['rowspan'][$index.'_rowspan'])>0){	// 添加判断是否合并
						$this->list[$_key]['list'][$key][$index.'_show']	= 1;
					}
					$this->smarty->tpl_vars['rowspan'][$index.'_rowspan']	+= 1; 
				}
			}
		}
	}
	public function getMergeParams(){
		
		return $this->smarty->tpl_vars['block_merge_params'];
	}
	//合并索引
	public function getMergeIndex($param,$list){
		$index	= explode(',',$param);
		foreach($index as $key=>$val){
			$info[]	= $list[$val];
		}
		return md5($param.'|'.implode(',',$info));
	}
	//输出数据
	public function resetData(){
		$info			= array();
		$merge_params	= $this->getMergeParams();
		$row_total		= $this->row_total;
		$row			= $this->row;
		foreach($this->list as $_key=>$_val){
			$total_count	= 0;
			foreach($_val['list'] as $key=>$val){
				$total_index	= $this->getTotalIndex($row,$val);
				if(empty($total[$total_index])){
					$total[$total_index]	= $val;
					$total_count++;
				}else{
					foreach($row_total as $row_key=>$row_val){
						$total[$total_index][$row_key]	+= $val[$row_key];
					}
				}
				//合并行数
				foreach($merge_params as $param){
					$index	= $this->getMergeIndex($param,$val);
					$val[$index.'_rowspan']	= $this->smarty->tpl_vars['rowspan'][$index.'_rowspan'];
					
					//合计行
					foreach($total as $t_key=>$tmp){
						$total[$t_key][$index.'_rowspan']	= $total_count;
						$total[$t_key][$index.'_show']		= 0;
					}
					foreach($row_total as $row_key=>$row_val){
						if(empty($row_val)){
							continue;
						}
						$row_index	= $this->getMergeIndex($row_val,$val);
						if($row_index==$index&&$val[$index.'_show']==1){
							$total[$total_index][$row_key] -= $val[$row_key];
						}
					}
				}
//				echo '<pre>';print_r($val);
				$info[]	= $val;
			}
			if(!empty($row_total)){
				$i=0;
				foreach($total as $total_key=>$total_val){
					
					if($i>0){
						foreach($total_val as $t_key=>$t_val){
							if(stripos($t_key,'_show')>0){
								$total_val[$t_key]	= 1;
							}
						}
					}
					unset($total_val['currency_no']);
					$total_val['group_total']	= 1;
					$info[]						= $total_val;
					$i++;
				}
			}
			unset($total);
		}
//		print_r($info);
		$this->from	= $info;
		return $info;
	}
	//
	public function getTotalIndex($row,$list){
		if(empty($row)){
			return 0 ;
		}
		return $row.'|'.$list[$row];
	}
}
