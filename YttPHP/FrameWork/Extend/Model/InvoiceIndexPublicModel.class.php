<?php

/**
 * 发票系统
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category    基本信息
 * @package   Model
 * @author     何剑波
 * @version  2.1,2012-07-22
 */

class InvoiceIndexPublicModel extends CommonModel {
	protected $tableName = 'invoice_holiday';
	
	 /// 获取菜单
	 public function getInvoice($menu){
//	 	echo '<pre>';print_r($menu);exit;
    	$i			= 1;
    	$node_id	= array('1'=>array('1','3','Instock','sub'=>array('491','197')),'2'=>array('2','3','SaleOrder','sub'=>array('495','203')),
    						'3'=>array('4','3','InvoiceStorage','sub'=>array('205','206')),'4'=>array('218','7','sub'=>array('204','199')),
    						'5'=>array('7','3','Instock','sub'=> array('product_from,482,212,92,309','product_from,196,212,92'
    									,'factory_from,531,213,11,261','factory_from,201,213,11'
    									,'client_from,534,213,62,252','client_from,202,213,62'
    									,'company_from,218,214,75')));
    	///不需要转换语言包数组
    	$node_lang	= array('206','482','196','531','201','534','202');
    	foreach ((array)$node_id as $k=>$v){
				$node[$i]['id']		= $node_id[$i][0];
				if($v['sub']){
					foreach ((array)$v['sub'] as $kk=>$vv){
						!in_array($vv,$node_lang) && L('module_'.$menu[$node_id[$i][1]]['sub'][$vv]['module'],L('module_'.$node_id[$i][2]));
						if(strpos($vv,',')){
							$str	= explode(',',$vv);
							$menu[$node_id[$i][1]]['sub'][$str[1]] 	&& $menu[$node_id[$i][1]]['sub'][$str[1]]['group_id']	= $node_id[$i][0];
						}else{
							$menu[$node_id[$i][1]]['sub'][$vv]['group_id']	= $node_id[$i][0];
						}
						if($node_id[$i][0]=='218'){
							 $menu[$node_id[$i][1]]['sub']['218']['sub'][$vv] && $node[$i]['sub'][$vv]		= $menu[$node_id[$i][1]]['sub']['218']['sub'][$vv];
						}else{
							if(strpos($vv,',')){
								$str	= explode(',',$vv);
								if(C('invoice.'.$str[0])==1){
									 $menu[$node_id[$i][0]]['sub'][$str[2]]['sub'][$str[3]]['module'] 
									 	&& $menu[$node_id[$i][0]]['sub'][$str[2]]['sub'][$str[3]]['ico_link']['href']	=  $menu[$node_id[$i][0]]['sub'][$str[2]]['sub'][$str[3]]['module'].'/add';
									 ($str[4] &&$menu[$node_id[$i][0]]['sub'][$str[2]]['sub'][$str[3]]['ico_link'])	
									 	&& $node[$i]['sub'][$str[4]]	= $menu[$node_id[$i][0]]['sub'][$str[2]]['sub'][$str[3]]['ico_link'];
									 $menu[$node_id[$i][0]]['sub'][$str[2]]['sub'][$str[3]]	
									 	&& $node[$i]['sub'][$str[3]]	= $menu[$node_id[$i][0]]['sub'][$str[2]]['sub'][$str[3]];
								}else{
									if($str[0]=='company_from'){
										$menu[$node_id[$i][0]]['sub'][$str[1]]	&& $node[$i]['sub'][$str[0]]	= $menu[$node_id[$i][0]]['sub'][$str[1]]['sub']['198'];
									}else
							 			$menu[$node_id[$i][1]]['sub'][$str[1]]	&& $node[$i]['sub'][$str[1]]	= $menu[$node_id[$i][1]]['sub'][$str[1]];
								}
							}else{
								$menu[$node_id[$i][1]]['sub'][$vv]	&& $node[$i]['sub'][$vv]			= $menu[$node_id[$i][1]]['sub'][$vv];
							}
						}
					}
				}
				$i++;
    	}
    	return $node;
    }
}