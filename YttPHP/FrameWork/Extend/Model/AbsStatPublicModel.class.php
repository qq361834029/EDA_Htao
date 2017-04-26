<?php 
/**
 * 统计抽象类
 * @copyright   Copyright (c) 2006 - 2013 Top Union 展联软件友拓通
 * @category   	账目信息
 * @package  	Model
 * @author    	何剑波
 * @version 	2013-07-20
 */

class AbsStatPublicModel extends Model {
	
   public  $default_stock_in_where	=	' and relation_type<>11 ';
   public  $tableName 				= 'paid_detail';
///   public  $default_stock_out_where	=	' and unpack=1 ';
	  
	/**
	 * 增加备注的附属说明
	 *
	 * @param array $list
	 * @param string $list_key
	 * @return array
	 */
	public function objectTypeCommentSubsidiary(&$list,$list_key='object_type'){  
		if (!is_array($list)) {
			return $list;
		}
		$list['view'] = '';
		$fix = C('PAID_DETAIL_LANG');
		if (getUser('role_type') == C('SELLER_ROLE_TYPE')) {
			foreach (C('FAC_PAID_DETAIL_LANG') as $object_type => $object_name) {
				$fix[$object_type]	= $object_name;
			}
		}		
		$url = C('FLOW_URL');
		$list['comments_url']	= '';
		$list['view']			= '';
		$list['new_comments']	= $list['comments'];
		if (getUser('role_type') == C('SELLER_ROLE_TYPE')) {
			$list['comments']	= '';
		}
		///增加付款或者收款方式的显示
		if (in_array($list[$list_key],array(103,121,203,303,403,800,801,1002,1003,1004,0)) && MODULE_NAME!='EveryFundsDetail') {
			///付款方式
			$paid_type = C('PAID_TYPE');
			$list['comments']	= '  【'.$paid_type[$list['paid_type']].'】 '.$list['comments'];
		}
		if (in_array($list[$list_key],array(104,204,304,404))) {
		 	 $list['object_type_explain']	= L('close_out_comments');
		 	 $list['flow_no_explain']		= '';
		 	 $list['comments']				= '('.L('close_out_comments').')'.$list['comments'];
		 	 $list['comments_url']			= '';
		}else if(in_array($list[$list_key],array(121,122,120,130,220,320,221))) {
			if(in_array($list[$list_key],array(120,220,320,420)) && $list['pay_class_id']>0){
				$funds_related_doc_no		= C('FUNDS_RELATED_DOC_NO');
				$list['comments']			= '('.SOnly('pay_class', $list['pay_class_id'],'pay_class_name').'->'.$funds_related_doc_no[$list['relation_type']].':'.$list['account_no'].')'.$list['comments'];
			}else{
				$list['comments']			= '('.L($fix[$list[$list_key]]).':'.$list['account_no'].')'.$list['comments'];
			}			 
		 	 $list['object_type_explain']	= L($fix[$list[$list_key]]);
		 	 $list['flow_no_explain']		= $list['account_no'];
		 	 if($url[$list[$list_key]]){
				 $link_url	= $url[$list[$list_key]].$list['object_id'];
				 switch ($list[$list_key]){
					case 221:///装柜单	  		
						$list['comments_url']	= U($link_url.'/comp_id/'.$list['comp_id'].'/currency_id/'.$list['currency_id']);
						$list['view']			= L('view');
						break;
					case 220:///销售单（派送成本-》快递公司欠款）
					default:///销售单 
						$list['comments_url']	= U($link_url);
						$list['view']			= L('view');
						break;
				  }
			 }
		 }elseif(in_array($list[$list_key],array('Orders','LoadContainer','Instock','SaleOrder','Delivery','PreDelivery'))) {  
			  $list['comments_url']	= U($url[$list[$list_key]].$list['object_id']);
			  $list['view']			= L('view');
		 } elseif (in_array($list[$list_key],array(102,202,302,402,123,125,126,127,131))){//added by jp 20140526
			if ($list['relation_type'] > 0) {
				$funds_related_doc_no			= C('FUNDS_RELATED_DOC_NO');
				$list['comments']				= '('.SOnly('pay_class', $list['pay_class_id'],'pay_class_name').'->'.$funds_related_doc_no[$list['relation_type']].':'.$list['account_no'].')'.$list['comments'];
				$link_url	= $url[$list[$list_key]][$list['relation_type']].$list['object_id'];                
				$list['comments_url']			= U($link_url);
                if($list[$list_key]==123){
                    $link_url   = $list['object_id'];                    
                    $list['comments_url']			= U('ReturnSaleOrder/view',array('id'=>$link_url));
                }elseif(in_array($list[$list_key], array(125,126))){
                    $link_url   = $list['object_id'];                    
                    $list['comments_url']			= U('QuestionOrder/view',array('id'=>$link_url));
                }elseif($list[$list_key]==127){
                    $link_url   = $list['object_id'];                    
                    $list['comments_url']			= U('WarehouseAccount/view',array('id'=>$link_url));
                }elseif(in_array($list[$list_key], array(131))){
                    $link_url   = $list['object_id'];                    
                    $list['comments_url']			= U('PackBox/view',array('id'=>$link_url));
                }
				$url_arr						= @explode('/',  ltrim($link_url,'/'));
                if(!in_array($list[$list_key], array(123,125,126,131))){
                    $list['comments_url_title']	= title($url_arr[1],$url_arr[0]);
                }
			 } else {
				 $list['comments']				= '('.SOnly('pay_class', $list['pay_class_id'],'pay_class_name').')'.$list['comments'];
			 }
		 }elseif(in_array($list[$list_key],array(132)) && $list['pay_class_id']>0) {	//卖家应付款注意事项（款项类别+备注）
				$list['comments']			= '('.SOnly('pay_class', $list['pay_class_id'],'pay_class_name').')'.$list['comments'];
		}else{
		 	if (isset($fix[$list[$list_key]])){
		 		$list['object_type_explain']	= L($fix[$list[$list_key]]);
		 	 	$list['flow_no_explain']		= '';
				///其他支出、其他收入显示类别名称
				if(in_array($list[$list_key],array(800,801)) && $list['pay_class_id']>0){
					$pay_class = S('pay_class');
		 			$list['comments']			= '('.$pay_class[$list['pay_class_id']]['pay_class_name'].')'.$list['comments'];
				}else{
					$list['comments']			= '('.L($fix[$list[$list_key]]).')'.$list['comments'];
				}
			  	$list['comments_url']			= '';
		 	}
		 }	   
		return $list;
	}
	
	/**
	 * 默认的where条件
	 *
	 * @return array
	 */
	public function fundsField(){
		switch ($this->comp_type){
			case 1:
				$field	=	' , comp_id as factory_id ';
				break;
			case 2:
				$field	=	' , comp_id as logistics_id ';
				break;
			case 3:
				$field	=	' , comp_id as express_id ';
                break;
            case 4:
				$field	=	' , comp_id as w_id ';
				break;		
		} 
		if (in_array($this->comp_type,array(1,2,3,4)) && $this->indexTableName!=''){
			$field	.=	' ,paid_id as id ';	
		} 
		return $field;
	}
	
	/**
	 * 特殊处理过滤掉流程中没有的产品/或厂家
	 *
	 * @param string $key
	 * @return string
	 */
	public function profitDefaultWhere($profit_key){ 
		$profit_where	=	'';  
		$_POST['query']['factory_id']>0 && $where	=	' and factory_id='.intval($_POST['query']['factory_id']); 
		$in_date['date']['lt_in_date']		=	$_POST['to_date']?$_POST['to_date']:$_POST['from_date']; 
		$out_date['date']['lt_out_date']	=	$_POST['to_date']?$_POST['to_date']:$_POST['from_date']; 
		$in_where	=	' and '.getWhere($in_date);   
		$out_where	=	' and '.getWhere($in_date);    
		///特殊处理过滤掉流程中没有的产品 
		if (empty($_POST['query']['id']) || $_POST['query']['id']==0) { 
			if ($profit_key=='product_id'){
				$fix_key	=	'a.';
			}
///			$profit_where	=	' and '.$fix_key.'id in ( 
///				select '.$profit_key.' from (
///					select '.$profit_key.' 
///						from stock_in 
///						where quantity>0 '.$where.$in_where.' group by '.$profit_key.' 
///					union all 
///					select '.$profit_key.'
///						from stock_out 
///						where quantity>0 '.$where.$out_where.' group by '.$profit_key.' 
///					) as temp where 1 group by '.$profit_key.'
///				) ';  
			 $sql	=	'select DISTINCT('.$profit_key.') 
						from stock_in FORCE INDEX( PRIMARY )
						where quantity>0 '.$where.$in_where.$this->default_stock_in_where.'
					union  
					select DISTINCT('.$profit_key.')
						from stock_out FORCE INDEX( PRIMARY )
						where quantity>0 '.$where.$out_where; 
			$date_id		=	$this->query($sql);    
			$product_array	=	array();
			foreach ((array)$date_id as $key=>$row) {	$date_array[]	=	$row[$profit_key];		}   
			is_array($date_array)	&&	$profit_where	=	' and '.$fix_key.'id in (  '.join(',',$date_array).') ';  
		}
		return $profit_where;
	} 
	
	/**
	 * 利润计算方法  
		【期初库存金额】=（查询起始日之前（不含起始当天）的库存*上期存货成本）
		【进货总金额】=查询时间段的入库数量*入库单价+运费分摊金额+（查询时间段的通过期初库存单据增加的数量*单价）
			无发货流程时
		【销售总金额】=[（销售数量*销售单价）*（1-折扣%）]-[（退货数量（可用/不可用）*退货单价）*（1-折扣%）] 
			有发货流程时
		【销售总金额】=[（发货数量*发货单价）*（1-折扣%）]-[（退货数量（可用/不可用）*退货单价）*（1-折扣%）] 
		【调整总金额】=（调整增加数量*调整单价）+（调整减少数量*存货成本）+（盘盈数量*盈亏单价）+（盘亏数量*存货成本）+（退货可用数量*退货操作日时的系统当前进货平均单价）
		【期末库存金额】=期初库存金额+进货总金额-（销售数量*存货成本）+调整总金额 
		【毛利总金额】=销售总金额+期末库存金额-期初库存金额-进货总金额 
		
		【其它收入总金额】=其它收入中记入成本的收入总金额
		【其它支出总金额】=其它收入中记入成本的收入总金额
		【折让总金额】=销售单上的优惠总额+收付款作业中的平帐损失+（对帐金额-对帐前的应收或是应付款金额）
		【净利总金额】=毛利总金额+其它收入总金额-其它支出总金额-折让总金额 
	 * @param array $info
	 */
	public function profit($profit_key,$list,$date){      
		foreach ((array)$list['list'] as $key=>$row) { 
			$profit_array[$row[$profit_key]]	=	$row;
			$info[]								=	$row[$profit_key];
		}   
		unset($list);
		if (!is_array($info)) {
			return $info;
		}      
		$where	=	getWhere($date);   
		///期初 
		if (!empty($date['date']['from_in_date']) || !empty($date['date']['to_in_date'])) {  
			$ini		=	self::profitIni($info,$profit_key,$date,$where);  
		}
		///进货总金额
		$in_stock		=	self::profitInStock($info,$profit_key,$date,$where); 
		///销售总金额
		$sale			=	self::profitSale($info,$profit_key,$date,$where);	 
		///调整总金额
		$adjust_stock	=	self::profitAdjust($info,$profit_key,$date,$where);	 
		///销售成本
		$sale_basic		=	self::profitBaseSale($info,$profit_key,$date,$where);	
		///退货  
		$return_is_use_stock	=	self::profitReturnIsUse($info,$profit_key,$date,$where);	   
		
		$money_leng		=	C('money_length');  
		foreach ((array)$profit_array as $key=>$row) {
		 	///【期初库存金额】=（查询起始日之前（不含起始当天）的库存*上期存货成本）+（查询时间段的期初库存数量*期初单价）
			if (is_array($ini[$row[$profit_key]])) {  
		 		$row['befor_money']		=	$ini[$row[$profit_key]]['befor_money'];
		 		$row['dml_befor_money']	=	moneyFormat($row['befor_money'],0,$money_leng);
		 	}
		 	///【进货总金额】=查询时间段的入库数量*入库单价+运费分摊金额
		 	if (is_array($in_stock[$row[$profit_key]])) { 
		 		$row['in_stock_money']		=	$in_stock[$row[$profit_key]]['in_stock_money'];
		 		$row['dml_in_stock_money']	=	moneyFormat($row['in_stock_money'],0,$money_leng);
		 	} 
		 	///【销售总金额】=（销售数量*销售单价）-（退货数量（可用/不可用）*退货单价） 
		 	if (is_array($sale[$row[$profit_key]])) { 
		 		$row['sale_money']		=	$sale[$row[$profit_key]]['sale_money'];
		 		$row['dml_sale_money']	=	moneyFormat($row['sale_money'],0,$money_leng);
		 	} 
		 	///销售成本 
		 	if (is_array($sale_basic[$row[$profit_key]])) { 
		 		$row['sale_basic_money']	=	$sale_basic[$row[$profit_key]]['sale_basic_money']; 
		 	}   
		 	///【调整总金额】=（调整增加数量*调整单价）+（调整减少数量*存货成本）+（盘盈数量*盈亏单价）+（盘亏数量*存货成本）+（退货可用数量*退货操作日时的系统当前进货平均单价）
		 	if (is_array($adjust_stock[$row[$profit_key]])) { 
		 		$row['adjust_money']		=	$adjust_stock[$row[$profit_key]]['adjust_money'];
		 		$row['dml_adjust_money']	=	moneyFormat($row['adjust_money'],0,$money_leng);
		 	}    
		 	///（退货可用数量*退货操作日时的系统当前进货平均单价）
		 	if (is_array($return_is_use_stock[$row[$profit_key]])) { 
		 		$row['return_is_use_money']		=	$return_is_use_stock[$row[$profit_key]]['return_is_use_money']; 
		 	} 
		 	///【期末库存金额】=期初库存金额+进货总金额-（销售数量*存货成本）+调整总金额    
		 	$row['stock_money']		=	$row['befor_money']+$row['in_stock_money']-$row['sale_basic_money']+$row['adjust_money']+$row['return_is_use_money']; 
		 	$row['dml_stock_money']	=	moneyFormat($row['stock_money'],0,$money_leng);    
		 	///【毛利总金额】=销售总金额-销售成本 
		 	$row['profit_money']		=	$row['sale_money']+$row['stock_money']-$row['befor_money']-$row['in_stock_money'];
		 	$row['dml_profit_money']	=	moneyFormat($row['profit_money'],0,$money_leng);    
		 	$product[$key]	=	$row;  
		}     
		foreach ((array)$product as $key=>$row) { 
			 	unset($product[$key]['dd_'.$profit_key]);
		}  
		$return	=	_formatList($product);      
		return $return;
	} 
	
	
	/**
	 * 期初库存
	 *
	 * @param array $info
	 * @param string $profit_key
	 * @param array $date
	 * @return array
	 */
	private function profitIni($info,$profit_key,$date,$where=''){ 
		
			if ($date['date']['from_in_date'] && $date['date']['to_in_date']) {
				$befor_date['date']['ltt_in_date']			=	$date['date']['from_in_date'];  
				$befor_out_date['date']['ltt_out_date']		=	$date['date']['from_in_date'];   
				$befor_where			=	getWhere($befor_date);  
				$befor_out_where		=	getWhere($befor_out_date);    
			} else{ 
				$befor_out_date['date']['ltt_out_date']	=	empty($date['date']['to_in_date'])?$date['date']['from_in_date'] :$date['date']['to_in_date']; 
				$befor_date['date']['ltt_in_date']			=	empty($date['date']['to_in_date'])?$date['date']['from_in_date'] :$date['date']['to_in_date']; 
				$befor_where		=	getWhere($befor_date);  
				$befor_out_where	=	getWhere($befor_out_date);   
			}  		
			
			$sql = ' 	select '.$profit_key.',sum(money) as befor_money from (
										select relation_type,'.$profit_key.',color_id,size_id,quantity,capability,dozen,base_price,
										sum(quantity*capability*dozen*(base_price+base_delivery_price)) as money
										from stock_in FORCE INDEX(PRIMARY)
										where '.$befor_where.$this->default_stock_in_where.' and relation_type<>99 
										and relation_type>0 and '.$profit_key.' in ('.join(',',$info).') 
										group by '.$profit_key.'
										union all
										select out_relation_type as relation_type,'.$profit_key.',color_id,size_id,quantity,capability,dozen,out_base_price as base_price,
										sum(quantity*capability*dozen*(in_base_price+base_delivery_price)*-1) as money
										from stock_out FORCE INDEX(PRIMARY)
										where '.$befor_out_where.' and out_relation_type<>99 
										and out_relation_type>0 and '.$profit_key.' in ('.join(',',$info).')
										group by '.$profit_key.'
							) as temp 
						where 1 
						group by '.$profit_key.' ';   
			return $list	=	$this->getListWithSql($sql,$profit_key); 
	}
	
	/**
	 * 进货
	 *
	 * @param array $info
	 * @param string $profit_key
	 * @param array $date
	 * @param string $where
	 * @return array
	 */
	private function profitInStock($info,$profit_key,$date,$where){ 
		
		$sql = '  	select '.$profit_key.',sum(quantity*capability*dozen*(base_price+base_delivery_price)) as in_stock_money
						from stock_in force index(PRIMARY)
						where '.$where.$this->default_stock_in_where.' and relation_type in (2,8) and relation_type>0 and '.$profit_key.' in ('.join(',',$info).')
						group by '.$profit_key.' order by null ';   
		return $list	=	$this->getListWithSql($sql,$profit_key); 
	}
	 
	/**
	 * 销售
	 *
	 * @param array $info
	 * @param string $profit_key
	 * @param array $date
	 * @param string $where
	 * @return array
	 */
	private function profitSale($info,$profit_key,$date,$where){ 
		$befor_out_date['date']['from_out_date']			= $date['date']['from_in_date'];  
		$befor_out_date['date']['to_out_date']				= $date['date']['to_in_date'];  
		$return_date['date']['from_return_order_date']		= $date['date']['from_in_date'];  
		$return_date['date']['to_return_order_date']		= $date['date']['to_in_date'];  
		$befor_out_where									= getWhere($befor_out_date);  		
		$return_where										= getWhere($return_date);  		 
		$sql = ' 
			select '.$profit_key.',sum(money) as sale_money from (
							select '.$profit_key.',	sum(quantity*capability*dozen*base_flow_price*-1*discount) as money
							from stock_in FORCE INDEX(PRIMARY)
							where '.$where.$this->default_stock_in_where.' and relation_type =5 and relation_type>0 and '.$profit_key.' in ('.join(',',$info).') 
							group by '.$profit_key.'
							union all
							select '.$profit_key.',	sum(quantity*capability*dozen*out_base_price*discount) as money
							from stock_out FORCE INDEX(PRIMARY)
							where '.$befor_out_where.' and out_relation_type in (3,7) and out_relation_type>0 and '.$profit_key.' in ('.join(',',$info).')
							group by '.$profit_key.'
							union all
							select '.$profit_key.',	sum(quantity*capability*dozen*price_base_currency*discount*-1) as money
							from return_sale_order_detail as a left join return_sale_order as b on a.return_sale_order_id=b.id
							where '.$return_where.' and is_use=2  and '.$profit_key.' in ('.join(',',$info).')
							group by '.$profit_key.'
				) as temp 
			where 1 
			group by '.$profit_key.' ';   
			return $list	=	$this->getListWithSql($sql,$profit_key); 
	}
	
	/**
	 * 调整
	 *
	 * @param array $info
	 * @param string $profit_key
	 * @param array $date
	 * @param string $where
	 * @return array
	 */
	private function profitAdjust($info,$profit_key,$date,$where){  
		if (empty($date['date']['from_in_date']) && empty($date['date']['to_in_date'])){
				$befor_where= $befor_out_where=' 1 '; 
		}else{  
			$befor_out_date['date']['from_out_date']	=	$date['date']['from_in_date'];  
			$befor_out_date['date']['to_out_date']		=	$date['date']['to_in_date'];  
			$befor_out_where							=	getWhere($befor_out_date);    
		} 
		$sql = ' 
			select '.$profit_key.',sum(money) as adjust_money from (
							select relation_type,'.$profit_key.',color_id,size_id,quantity,capability,dozen,base_price,
							sum(quantity*capability*dozen*(base_price+base_delivery_price)) as money
							from stock_in FORCE INDEX(PRIMARY)
							where '.$where.$this->default_stock_in_where.' and relation_type in (4,9) and relation_type>0 and '.$profit_key.' in ('.join(',',$info).') 
							group by '.$profit_key.'
							union all
							select out_relation_type as relation_type,'.$profit_key.',color_id,size_id,quantity,capability,dozen,in_base_price as base_price,
							sum(quantity*capability*dozen*(in_base_price+base_delivery_price)*-1) as money
							from stock_out FORCE INDEX(PRIMARY)
							where '.$befor_out_where.' and out_relation_type in (4,9) and out_relation_type>0 and '.$profit_key.' in ('.join(',',$info).')
							group by '.$profit_key.'
				) as temp 
			where 1 
			group by '.$profit_key.'
		';    
		return $list	=	$this->getListWithSql($sql,$profit_key); 
	}
	
	/**
	 * 退货可用
	 *
	 * @param array $info
	 * @param string $profit_key
	 * @param array $date
	 * @param string $where
	 * @return array
	 */
	private function profitReturnIsUse($info,$profit_key,$date,$where){  
		if (empty($date['date']['from_in_date']) && empty($date['date']['to_in_date'])){
				$befor_where= $befor_out_where=' 1 '; 
		}else{  
			$befor_out_date['date']['from_out_date']	=	$date['date']['from_in_date'];  
			$befor_out_date['date']['to_out_date']		=	$date['date']['to_in_date'];  
			$befor_out_where							=	getWhere($befor_out_date);    
		} 
		$sql = '  
							select relation_type,'.$profit_key.',color_id,size_id,quantity,capability,dozen,base_price,
							sum(quantity*capability*dozen*(base_price+base_delivery_price)) as return_is_use_money
							from stock_in FORCE INDEX(PRIMARY)
							where '.$where.$this->default_stock_in_where.' and relation_type =5  and relation_type>0 and '.$profit_key.' in ('.join(',',$info).') 
							group by '.$profit_key.'
							 
		';    
		return $list	=	$this->getListWithSql($sql,$profit_key); 
	}
	
	/**
	 * 销售成本
	 * @param array $info
	 * @param string $profit_key
	 * @param array $date
	 * @param string $where
	 * @return array
	 */
	private function profitBaseSale($info,$profit_key,$date,$where){ 
		$out_date['date']['from_out_date']					=	$date['date']['from_in_date'];  
		$out_date['date']['to_out_date']					=	$date['date']['to_in_date'];  
		$out_where											=	getWhere($out_date);  
		///销售成本 
		$sql = '   	select out_relation_type as relation_type,'.$profit_key.',color_id,size_id,quantity,capability,dozen,in_base_price as base_price,
					sum(quantity*capability*dozen*(in_base_price+base_delivery_price)) as sale_basic_money
					from stock_out
					where '.$out_where.' and out_relation_type in (3,7) and out_relation_type>0 and '.$profit_key.' in ('.join(',',$info).')
					group by '.$profit_key.' ';  
		return $list	=	$this->getListWithSql($sql,$profit_key); 
	}
	
	/**
	 * 通过SQL返回数组
	 *
	 * @param string $sql
	 * @param string $profit_key,下标重新组合数组
	 * @return array
	 */
	public function getListWithSql($sql,$profit_key){ 
		$list = _formatList($this->db->query($sql));	   
		foreach ((array)$list['list'] as $key=>$row) { $info[$row[$profit_key]] = $row;}  
		unset($list);  
		return $info;
	}
	
	///初始化产品利润
	public function iniProfitInfo(){
		///初始化产品退货中的产品利润
		$this->iniProfitReturn();
	}
	
	/**
	 * 标示出欠款超过信用额度的行
	 *
	 * @param array $list
	 * @param array $info
	 * @return array
	 */
	function addRemindMoney(&$list,$info){
		$company_expand	=	S('company_expand');  
		$id_key			=	$info['id']?$info['id']:'comp_id';
		$money_key		=	$info['date']?$info['date']:'edml_total_comp_need_paid';
		if (is_array($list['list'])){
///			foreach ($list['list'] as $key => $value) { 
///				if ($value[$money_key]>$company_expand[$value[$id_key]]['remind_money'] && $company_expand[$value[$id_key]]['remind_money']>0){
///					$list['list'][$key]['tr_color']	=2;
///				}else{
///					$list['list'][$key]['tr_color']	=1;
///				}   
///			}
		} 
		return $list;
	}
	
	
	/**
	 * 统计不同币种的合计
	 *
	 * @param array $list
	 * @param array $totalFields 需要合计的字段
	 * @param int $type
	 * @param bool $have_currency_name 是否需要币种字段显示
	 * @return array
	 */
	public function getTotalCurrencyInfo(&$list,$totalFields=array(),$type=1,$have_currency_name=true){   
		if (is_array($list['list']) && is_array($totalFields)){ 
			$currencyArray	=	S('currency');  
			foreach ((array)$list['list'] as $key => $value) { 
				foreach ((array)$totalFields as $fieldkey => $fieldvalue) { 
					if(isset($value[$fieldvalue])){$info[$value['currency_id']][$fieldkey]	+=	$value[$fieldvalue]*$type;}
				} 
			}    
			if ($have_currency_name){
				foreach ((array)$info as $key => $value) {  
					foreach ((array)$value as $k => $v) {  
						$join[$k][]	=	$currencyArray[$key]['currency_no'].':'.moneyFormat($v,0,C('money_length')).' ';
					}	 
				} 
			}else {
				foreach ((array)$info as $key => $value) {  
					foreach ((array)$value as $k => $v) {  
						$join[$k][]	=	moneyFormat($v,0,C('money_length')).' ';
					}	 
				} 
			}
			 
			foreach ((array)$join as $key => $value) {  $list['total']['total_currency_info_'.$key]	=	join('<br>',$value);}  
		} 
		return $list; 
	}
	
	
	/**
	 * 销售单利润
	 *
	 * @param int $base_currency_id
	 * @param int $type 1 初始化 2修改单日汇率
	 */
	public function iniProfitSale($base_currency_id,$type=1){
		$model	=	M('SaleOrder');
		if ($base_currency_id>0 && $type==1) {  
			///需要转换到本位币的信息
			$sql	= ' 	select id,pr_money,base_rate,base_state,currency_id,date(order_date) as rate_date
								from sale_order
								where base_state=0 and currency_id<>'.$base_currency_id.' and pr_money<>0 ';
			$info 	= $model->query($sql); 
			$set_rate_type		=	C('set_rate_type')>0?C('set_rate_type'):1;
			$rate_function_name	=	'getTodayRate'.$set_rate_type;
			$rate_model	=	M('RateInfo');
			foreach ((array)$info as $key=>$row) {
				if ($row['currency_id']>0) {  
					$rate		=	$this->$rate_function_name($row['currency_id'],$base_currency_id,$row['rate_date'],$rate_model); 
					$model->where(' id in ( '.$row['id'].' )')->setField(array('base_state'=>1,'base_rate'=>$rate,'base_pr_money'=>$row['pr_money']*$rate));  
				}
			} 
		}elseif ($type==2){  
			$rate_info		= $base_currency_id; 
			///更新条件
			$where			= ' 1 and currency_id='.$rate_info['from_currency_id'].' 
								and pr_money<>0 '.self::_updateTodayProfitWhere('order_date',$rate_info['rate_date']);    
			$rate			= $rate_info['rate'];
			if ($rate==0) {	$rate =	1; } 
			$update		= ' update sale_order set base_state=1,base_rate='.$rate.',base_pr_money=pr_money*'.$rate.'  where '.$where;  
			$info 		= $model->execute($update);   
		} 
	}
	 
	/**
	 * 款项利润
	 *
	 * @param int $base_currency_id
	 * @param int $type
	 */
	public function iniProfitFund($base_currency_id,$type=1){
		$model	=	M('PaidDetail');
		if ($base_currency_id>0 && $type==1) {  
			///需要转换到本位币的信息
			$sql	=	' 	select id,money,account_money,currency_id,date(paid_date) as rate_date
								from paid_detail
								where base_state in (0) and currency_id<>'.$base_currency_id.'
			';
			$info 		= $model->query($sql);   
			$set_rate_type		=	C('set_rate_type')>0?C('set_rate_type'):1;
			$rate_function_name	=	'getTodayRate'.$set_rate_type;
			$rate_model			=	M('RateInfo');
			foreach ((array)$info as $key=>$row) {
				if ($row['currency_id']>0) {  
					$rate		=	$this->$rate_function_name($row['currency_id'],$base_currency_id,$row['rate_date'],$rate_model); 
					$model->where(' id='.$row['id'].'')
					->setField(array('base_state'=>1,'base_rate'=>$rate,'base_money'=>$row['money']*$rate,'base_account_money'=>$row['account_money']*$rate));  
				}
			} 
		}elseif ($type==2){
			$rate_info		= $base_currency_id;
			///更新条件
			$where			= ' 1 and currency_id='.$rate_info['from_currency_id'].' '.self::_updateTodayProfitWhere('paid_date',$rate_info['rate_date']); 
			$rate			= $rate_info['rate'];
			if ($rate==0) {
				$rate	=	1;
			} 
			$update		= ' update paid_detail set 
							base_state=1,
							base_rate='.$rate.',
							base_money=money*'.$rate.',
							base_account_money=account_money*'.$rate.' 
							where '.$where; 
			$info 		= $model->execute($update);    
		}
	}
	
	
	/**
	 * Enter description here...
	 *
	 * @param int $from_currency_id 非本位币
	 * @param int $to_currency_id 本位币
	 * @param string $date 必须中国格式
	 * @param object $model 
	 * @return int
	 */
	function getTodayRate1($from_currency_id,$to_currency_id,$date,$model){  
		$to_currency_id	=	$to_currency_id>0?$to_currency_id:C('currency');
		$model			=	M('FixedRate');
		$info			=	$model->where('from_currency_id='.$from_currency_id.' and to_currency_id='.$to_currency_id.'')->find(); 
		$model->getLastSql();
		if (is_array($info)) {
			return $info['rate'];
		}else{
			return 1;
		}  
	}
	
	/**
	 * 按月统计利润
	 *
	 * @param int $from_currency_id 非本位币
	 * @param int $to_currency_id 本位币
	 * @param string $date 必须中国格式
	 * @return array
	 */
	function getTodayRate2($from_currency_id,$to_currency_id,$date,&$model){   
		$to_currency_id	=	$to_currency_id>0?$to_currency_id:C('currency');
		$date		=	substr($date,0,8).'01';  
		$info		=	$model->where('from_currency_id='.$from_currency_id.' and to_currency_id='.$to_currency_id.' and rate_date=\''.$date.'\'')->find(); 
		if (is_array($info)) {
			$rate	=	$info['opened_y'];
		}else{
			$this->addRateError($from_currency_id,$to_currency_id,$date);
			$rate	=	$this->getTodayRate1($from_currency_id,$to_currency_id,$date,$model);
		} 
		return $rate;
	} 
	
	/**
	 * 按日期统计利润
	 *
	 * @param int $from_currency_id
	 * @param int $to_currency_id
	 * @param string $date
	 * @return array
	 */
	function getTodayRate3($from_currency_id,$to_currency_id,$date,$model){  
		$to_currency_id	=	$to_currency_id>0?$to_currency_id:C('currency');
		$model			=	M('RateInfo');
		$info			=	$model->where('from_currency_id='.$from_currency_id.' and to_currency_id='.$to_currency_id.' and rate_date=\''.$date.'\'')->find();
		if (is_array($info)) {
			$rate	=	$info['opened_y'];
		}else{
			$this->addRateError($from_currency_id,$to_currency_id,$date);
			$rate	=	$this->getTodayRate1($from_currency_id,$to_currency_id,$date,$model);
		} 
		return $rate;
	}
	
	/**
	 * 插入汇率异常信息
	 *
	 * @param int $from_currency_id
	 * @param int $to_currency_id
	 * @param string $date
	 * @return bool
	 */
	public function addRateError($from_currency_id,$to_currency_id,$date){
		$model		=	M('RateError');
		$where		=	'from_currency_id='.$from_currency_id.' and to_currency_id='.$to_currency_id.' and error_date=\''.$date.'\' ';
		$rate_error	=	$model->where($where)->find();  
		if (!is_array($rate_error)) {
				$insert	=	array(
											'from_currency_id'	=>$from_currency_id,
											'to_currency_id'	=>$to_currency_id,
											'error_date'		=>$date,); 
				$model->add($insert);
		}
		return true;
	}
	
	/**
	 * 销售单利润
	 *
	 * @param int $base_currency_id
	 * @param int $type 1 初始化 2修改单日汇率
	 */
	public function iniProfitReturn($base_currency_id,$type=1){
		 
		$model	=	M('ReturnSaleOrderDetail');
		if ($type==1) {   
			///需要转换到本位币的信息
			$sql	= ' 	select a.id,price,return_base_rate,currency_id,date(return_order_date) as rate_date
								from return_sale_order_detail as a left join return_sale_order as b on a.return_sale_order_id=b.id
								where is_use=2 and price_base_currency=0 ';
			$info 	= $model->query($sql);   
			$set_rate_type		=	C('set_rate_type')>0?C('set_rate_type'):1;
			$rate_function_name	=	'getTodayRate'.$set_rate_type;
			$rate_model			=	M('RateInfo');	
			foreach ((array)$info as $key=>$row) { 
				if ($row['currency_id']>0) {  
					$rate		=	$this->$rate_function_name($row['currency_id'],0,$row['rate_date'],$rate_model);  
					$model->where(' id in ( '.$row['id'].' )')
					->setField(array('return_base_rate'=>$rate,'price_base_currency'=>$row['price']*$rate));  
				}
			}
			 
		}elseif ($type==2){  
			$rate_info		= $base_currency_id; 
			///更新条件
			$where			= ' 1 and currency_id='.$rate_info['from_currency_id'].' 
								'.self::_updateTodayProfitWhere('return_order_date',$rate_info['rate_date']);    
			$rate			= $rate_info['rate'];
			if ($rate==0) {	$rate =	1; } 
			$update		= ' update return_sale_order_detail set 
				 return_base_rate='.$rate.',
				 price_base_currency=price*'.$rate.'
			 where return_sale_order_id in ( select id from return_sale_order where '.$where.' )';  
			$info 		= $model->execute($update);   
		} 
	}
	
	/**
	 * 更新流程中利润
	 *
	 * @param array $info
	 * @param int $type
	 */
	public function iniProfitStock($info,$type=2){
		  self::iniProfitStockIn($info,2);
		  self::iniProfitStockOut($info,2);
	}
	
	/**
	 *  更新stock_in的利润
	 *
	 * @param array $info
	 * @param int $type
	 */
	public function iniProfitStockIn($rate_info,$type=2){
		if ($type==2) { 
			$model		=	M('StockIn');
			$model_out	=	M('StockOut');
			$where		=	' 1 
								and currency_id='.$rate_info['from_currency_id'].' 
								and base_currency_id ='.$rate_info['to_currency_id'].' '.self::_updateTodayProfitWhere('in_date',$rate_info['rate_date']);
		 
			$rate	=	$rate_info['rate'];
			if ($rate==0) {
				$rate	=	1;
			}
			$sql	= ' 	select *
								from stock_in
								where '.$where;
			$info 	= $model->query($sql);   
			foreach ((array)$info as $key=>$row) {
				if ($row['currency_id']>0 && $row['stock_in_id']>0) {    
					$model->where('stock_in_id='.$row['stock_in_id'].'')->
					$model_out->where('stock_in_id='.$row['stock_in_id'])->setField('in_base_price',$row['account_money']*$rate/$row['rate']); 
				}
			}
			///运费
			$this->iniProfitStockInDelivery($rate_info,$type);
///			$update		= ' update stock_in set  
///							rate='.$rate.', 
///							base_price=price*'.$rate.' 
///							where '.$where; 
///			$info 		= $model->execute($update);     
		}
	}
	
	/**
	 *  更新stock_in的利润
	 *
	 * @param array $info
	 * @param int $type
	 */
	public function iniProfitStockInDelivery($rate_info,$type=2){
		if ($type==2) { 
			$model		=	M('StockIn');
			$model_out	=	M('StockOut');
			$where		=	' 1 
								and delivery_currency_id='.$rate_info['from_currency_id'].' 
								and base_currency_id ='.$rate_info['to_currency_id'].'  '.self::_updateTodayProfitWhere('in_date',$rate_info['rate_date']);
		 
			$rate	=	$rate_info['rate'];
			if ($rate==0) {
				$rate	=	1;
			}
			$sql	= ' 	select *
								from stock_in
								where '.$where;
			$info 	= $model->query($sql);   
			foreach ((array)$info as $key=>$row) {
				if ($row['delivery_currency_id']>0 && $row['stock_in_id']>0) {    
					$model->where('stock_in_id='.$row['stock_in_id'].'')
					->setField(array('delivery_rate'=>$rate,'base_delivery_price'=>$row['delivery_price']*$rate/$row['delivery_rate']));  
					$model_out->where('stock_in_id='.$row['stock_in_id'])->setField('base_delivery_price',$row['delivery_price']*$rate/$row['delivery_rate']); 
				}
			}   
		}
	}
	
	
	/**
	 * 更新stock_out的利润
	 *
	 * @param int $base_currency_id
	 * @param int $type
	 */
	public function iniProfitStockOut($rate_info,$type=2){
		if ($type==2) { 
			$model	= M('StockOut');
			$where	= ' 1 
			and out_currency_id='.$rate_info['from_currency_id'].' 
			and base_currency_id ='.$rate_info['to_currency_id'].' '.self::_updateTodayProfitWhere('out_date',$rate_info['rate_date']); 
			$rate	=	$rate_info['rate']; 
			if ($rate==0) {
				$rate	=	1;
			}
///			foreach ((array)$info as $key=>$row) {
///				if ($row['id']>0) {    
///					$model->where(' stock_out_id='.$row['id'].'')
///					->setField(array('rate','out_base_price'),array($rate,$row['out_base_price']*$rate/$row['rate']));   
///				}
///			}
			$update		= ' update stock_out set  
							rate='.$rate.', 
							out_base_price=out_price*'.$rate.' 
							where '.$where; 
			$info 		= $model->execute($update);  
			 
		}
	}
	
	
	/**
	 * 重新计算属于当天的汇率
	 *
	 * @param array $info
	 */
	function _updateTodayProfit($info){ 
		 ///更新销售单
		 self::iniProfitSale($info,2);
		 ///更新款项
		 self::iniProfitFund($info,2);
		 ///更新库存
		 self::iniProfitStock($info,2);
		 ///退货
		 self::iniProfitReturn($info,2);
	}
	 
	/**
	 * 增加记录本次Post
	 *
	 * @param array $info
	 */
	public function addSessionPost($info){
///		import( "@.ORG.Session" ); 
///		session
///    	$Session = 	new Session();   ///初始化分页对象    
    	session('post_'.MODULE_NAME.'_'.ACTION_NAME,$info); ///设置本地化Session癿值   
	}
	
	
}
?>