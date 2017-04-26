<?php
/**
 * 总利润	
 * @copyright   2012 展联软件友拓通
 * @category   	基本信息
 * @package  	Model 
 * @author 		何剑波
 * @version 	2.1
 */
class StatProfitPublicModel extends AbsStatPublicModel {
	/// 列表
	public function index() {    
		 
		///初始化利润
		$this->iniProfit();  
		///查询条件
		$profit_date =	$_POST['profit_user']==1?'month':'year'; 
		///年份
		$year		 =	$_POST['profit_year']; 
		if ($year>0) {	 
/*			if ($_POST['profit_user']!=1) {
				$where_stock_in		=	'and '.$profit_date.'(in_date)='.$year.'';
				$where_stock_out	=	'and '.$profit_date.'(out_date)='.$year.'';
				$where_paid_detail	=	'and '.$profit_date.'(paid_date)='.$year.'';
			} lee 120104更新的BUG增加按年查询 */
			$where_stock_in		=	'and year(in_date)='.$year.''.$this->default_stock_in_where; 
			$where_stock_out	=	'and year(out_date)='.$year;
			$where_paid_detail	=	'and year(paid_date)='.$year.'';
			
			$sql_ini = ' 
						select date as profit_date,0 as befor_money,0 as in_stock_money,0 as sale_money,0 as stock_money,0 as profit_money,0 as adjust_money,0 as sale_basic_money,
						0 as other_in_money,0 as other_out_money,0 as close_out_money,0 as pure_profit_money,0 as return_is_use_money
						from (
							select '.$profit_date.'(in_date) as date
							from stock_in 
							where 1 and in_date is not null '.$where_stock_in.'
							group by '.$profit_date.'(in_date)
							union all 
							select '.$profit_date.'(out_date) as date
							from stock_out 
							where 1 and out_date is not null '.$where_stock_out.'
							group by '.$profit_date.'(out_date)
							union all 
							select '.$profit_date.'(paid_date) as date
							from paid_detail 
							where to_hide=1 and object_type in (104,204,304,122,800,801,121,103,203,303,129,229,329) and paid_date is  not null '.$where_paid_detail.'
							group by '.$profit_date.'(paid_date)
							) as temp 
						where 1 and date>0 
						group by date
			';   
			$list 	= _formatList($this->db->query($sql_ini));	 
			$array	=	array(	'groupby'		=>$profit_date,
								'profit_key'	=>'profit_date',
								'year'			=>$year,);  
			$profit_info	=	$this->profit($array,$list); 		
		} 
		return $profit_info;
	}	
	 
	/**
	 * 利润计算方法
	 *
	 * 	【期初库存金额】=（查询起始日之前（不含起始当天）的库存*上期存货成本）+（查询时间段的期初库存数量*期初单价）
	    【进货总金额】=查询时间段的入库数量*入库单价+运费分摊金额
	    【销售总金额】=（销售数量*销售单价）-（退货数量（可用/不可用）*退货单价）
	    【期末库存金额】=期初库存金额+进货总金额-销售成本
		【销售成本】=（销售数量*存货成本）-（退货数量（可用/不可用）*退货操作日期时系统当前总的进货平均单价）
		【毛利总金额】=销售总金额-销售成本 
		
		【其它收入总金额】=其它收入中记入成本的收入总金额
		【其它支出总金额】=其它收入中记入成本的收入总金额
		【折让总金额】=销售单上的优惠总额+收付款作业中的平帐损失+（对帐金额-对帐前的应收或是应付款金额）
		【净利总金额】=毛利总金额+其它收入总金额-其它支出总金额-折让总金额
	 * @param array $list
	 * @param array $profit_key
	 * @param array $date
	 * @return array
	 */
	public function profit($profit_key,$list,$date=array()){    
		///总利润
		if (is_array($profit_key)) { 
			$all_profit_key	=	1; 
			$groupby		=	$profit_key['groupby']; 
			$groupby_key	=	$profit_key['year'];
			$profit_key		=	$profit_key['profit_key'];//最后
		} 
		foreach ((array)$list['list'] as $key=>$row) { 
			$profit_array[$row[$profit_key]]	=	$row;
			$info[]								=	$row[$profit_key];
		}   
		unset($list);
		if (!is_array($info)) {
			return $info;
		}     
		
		$out_date['date']['from_out_date']					=	$date['date']['from_in_date'];  
		$out_date['date']['to_out_date']					=	$date['date']['to_in_date'];  
		$out_where											=	getWhere($out_date); 
		$where	=	getWhere($date).$this->default_stock_in_where;  
		if (empty($date['date']['from_in_date']) && empty($date['date']['to_in_date'])){
			$ini_where = $sale_where =	$befor_where= $befor_out_where	= $sale_return_where	=	' 1 '; 
		}else{
			$sale_return_date['date']['from_return_order_date']	=	$date['date']['from_in_date'];  
			$sale_return_date['date']['to_return_order_date']	=	$date['date']['to_in_date'];  
			$sale_date['date']['from_order_date']				=	$date['date']['from_in_date'];  
			$sale_date['date']['to_order_date']					=	$date['date']['to_in_date'];  
			if ($date['date']['from_in_date'] && $date['date']['to_in_date']) {
				$dates['date']['ltt_in_date']				=	$date['date']['to_in_date'];  
				$befor_dates['date']['ltt_in_date']			=	$date['date']['from_in_date'];  
				$befor_out_dates['date']['ltt_out_date']	=	$date['date']['from_in_date'];   
				$ini_where				=	getWhere($dates);
				$befor_where			=	getWhere($befor_dates);  
				$befor_out_where		=	getWhere($befor_out_dates);   
				$sale_return_where		=	getWhere($sale_return_date);    
				$sale_where				=	getWhere($sale_date);    
			} else{
				$dates['date']['ltt_in_date']				=	empty($date['date']['to_in_date'])?$date['date']['from_in_date'] :$date['date']['to_in_date']; 
				$befor_out_date['date']['from_out_date']	=	empty($date['date']['to_in_date'])?$date['date']['from_in_date'] :$date['date']['to_in_date']; 
				$befor_date['date']['from_in_date']			=	empty($date['date']['to_in_date'])?$date['date']['from_in_date'] :$date['date']['to_in_date']; 
				$ini_where			=	getWhere($dates); 
				$befor_where		=	getWhere($befor_date);  
				$befor_out_where	=	getWhere($befor_out_date);  
				$sale_return_where	=	getWhere($sale_return_date);     
				$sale_where			=	getWhere($sale_date);     
			} 
		}
		$befor_where		.=	$this->default_stock_in_where;	
		 
		///期初 
		$sql_ini = ' 
		select '.$profit_key.',sum(money) as befor_money from (
						select '.$groupby.'(in_date) as '.$profit_key.',sum(quantity*capability*dozen*(base_delivery_price+base_price)) as money
						from stock_in
						where '.$befor_where.' and relation_type<>99 and relation_type>0 and year(in_date)<'.$groupby_key.'
						group by 1=1
						union all
						select '.$groupby.'(out_date) as '.$profit_key.',sum(quantity*capability*dozen*(base_delivery_price+in_base_price)*-1) as money
						from stock_out
						where '.$befor_out_where.' and out_relation_type<>99 and out_relation_type>0 and year(out_date)<'.$groupby_key.'
						group by 1=1
			) as temp 
		where 1 
		group by  1=1
		';    
		$ini_info = _formatList($this->db->query($sql_ini));	  
		///期初
		$ini['ini']	=	array(	'befor_money'=>$ini_info['list'][0]['befor_money'],
								'dml_befor_money'=>$ini_info['list'][0]['befor_money'],);  
		unset($ini_info);   
		 
		///进货总金额
		$sql_in_stock = '  	select '.$groupby.'(in_date) as '.$profit_key.' ,sum(quantity*capability*dozen*(base_price+base_delivery_price)) as in_stock_money
							from stock_in
							where '.$where.' and relation_type in (2,8) and relation_type>0 and '.$groupby.'(in_date) in ('.join(',',$info).') and year(in_date)='.$groupby_key.'
							group by '.$profit_key.' 
							
		';   
		$in_stock	=	$this->getListWithSql($sql_in_stock,$profit_key);  
	  	///销售总金额
		$sql_sale = ' 
			select '.$profit_key.',sum(money) as sale_money from (
				select '.$groupby.'(in_date) as '.$profit_key.',sum(quantity*capability*dozen*base_flow_price*-1*discount) as money
				from stock_in
				where '.$where.' and relation_type=5 and relation_type>0 and '.$groupby.'(in_date) in ('.join(',',$info).') and year(in_date)='.$groupby_key.'
				group by '.$groupby.'(in_date)
				union all
				select '.$groupby.'(out_date) as '.$profit_key.',sum(quantity*capability*dozen*out_base_price*discount) as money
				from stock_out
				where '.$befor_out_where.' and out_relation_type in (3,7) and out_relation_type>0 and '.$groupby.'(out_date) in ('.join(',',$info).') and year(out_date)='.$groupby_key.'
				group by '.$groupby.'(out_date)
				union all
				select '.$groupby.'(return_order_date) as '.$profit_key.' ,	sum(quantity*capability*dozen*price_base_currency*discount*-1) as money
				from return_sale_order_detail as a left join return_sale_order as b on a.return_sale_order_id=b.id
				where '.$sale_return_where.' and is_use=2  and '.$groupby.'(return_order_date) in ('.join(',',$info).') and year(return_order_date)='.$groupby_key.'
				group by '.$groupby.'(return_order_date)
				
				) as temp 
			where 1 
			group by '.$profit_key.'
			';   
		$sale	=	$this->getListWithSql($sql_sale,$profit_key);  
		 
		///调整总金额1装柜 2入库 3销售 4库存调整 5退换货 6调拨 7发货 8期初库存 9盈亏单
		$sql_adjust_stock = ' 
		select '.$profit_key.',sum(money) as adjust_money from (
				select '.$groupby.'(in_date) as '.$profit_key.',sum(quantity*capability*dozen*(base_delivery_price+base_price)) as money
				from stock_in
				where '.$befor_where.' and relation_type in (4,9) and relation_type>0 and '.$groupby.'(in_date) in ('.join(',',$info).') and year(in_date)='.$groupby_key.'
				group by '.$groupby.'(in_date)
				union all
				select '.$groupby.'(out_date) as '.$profit_key.',sum(quantity*capability*dozen*(in_base_price+base_delivery_price)*-1) as money
				from stock_out
				where '.$befor_out_where.' and out_relation_type in (4,9) and out_relation_type>0 and '.$groupby.'(out_date) in ('.join(',',$info).') and year(out_date)='.$groupby_key.'
						group by '.$groupby.'(out_date)
			) as temp 
		where 1 
		group by '.$profit_key.'
		';     
		$adjust_stock	=	$this->getListWithSql($sql_adjust_stock,$profit_key);
		
		///退货可用
		$sql_return_is_use_stock = '  
				select '.$groupby.'(in_date) as '.$profit_key.',sum(quantity*capability*dozen*(base_delivery_price+base_price)) as return_is_use_money
				from stock_in
				where '.$befor_where.' and relation_type=5 and relation_type>0 and '.$groupby.'(in_date) in ('.join(',',$info).') and year(in_date)='.$groupby_key.'
				group by '.$groupby.'(in_date)  
		';     
		$return_is_use_stock	=	$this->getListWithSql($sql_return_is_use_stock,$profit_key);
		 
		///销售成本 
		$sql_basic_sale = '   
			select '.$groupby.'(out_date) as '.$profit_key.',sum(quantity*capability*dozen*(in_base_price+base_delivery_price)) as sale_basic_money
			from stock_out
			where '.$out_where.' and out_relation_type in (3,7) and out_relation_type>0 and '.$groupby.'(out_date) in ('.join(',',$info).') and year(out_date)='.$groupby_key.'
			group by '.$groupby.'(out_date) 
		';    
		$sale_basic	=	$this->getListWithSql($sql_basic_sale,$profit_key); 
		///【其它收入总金额】=其它收入中记入成本的收入总金额
		$sql_other_out_money = '   
			select '.$groupby.'(paid_date) as '.$profit_key.',sum(base_money) as other_out_money
			from paid_detail
			where object_type=800 and to_hide=1 and is_cost=1 
				and '.$groupby.'(paid_date) in ('.join(',',$info).') and year(paid_date)='.$groupby_key.' and year(paid_date)='.$groupby_key.'
			group by '.$groupby.'(paid_date)  
		'; 
		$other_out_money	=	$this->getListWithSql($sql_other_out_money,$profit_key); 
		 
		///【其它支出总金额】=其它收入中记入成本的收入总金额
		$sql_other_in_money = '   
				select '.$groupby.'(paid_date) as '.$profit_key.',sum(base_money) as other_in_money
				from paid_detail
				where object_type=801 and to_hide=1 and is_cost=1 and '.$groupby.'(paid_date) in ('.join(',',$info).')  and year(paid_date)='.$groupby_key.'
				group by '.$groupby.'(paid_date)  
		';  
	 	$other_in_money	=	$this->getListWithSql($sql_other_in_money,$profit_key); 
		///平账损失
		$sql_close_out = ' 
		select '.$profit_key.',sum(money) as close_out_money from (
						select '.$groupby.'(order_date) as '.$profit_key.',sum(base_pr_money) as money
						from sale_order
						where '.$sale_where.' and '.$groupby.'(order_date) in ('.join(',',$info).') and year(order_date)='.$groupby_key.' and year(order_date)='.$groupby_key.'
						group by '.$groupby.'(order_date)
						union all
						select '.$groupby.'(paid_date) as '.$profit_key.',sum(if(object_type>199,(base_money+base_account_money)*-1,(base_money+base_account_money))) as money
						from paid_detail
						where '.$befor_out_where.' and object_type in (104,204,304,122) and '.$groupby.'(paid_date) in ('.join(',',$info).') and year(paid_date)='.$groupby_key.'
						group by '.$groupby.'(paid_date)
						union all
						select '.$groupby.'(paid_date) as '.$profit_key.',sum(if(object_type>199,base_account_money*-1,base_account_money)) as money
						from paid_detail
						where '.$befor_out_where.' and object_type in (121,103,203,303) and '.$groupby.'(paid_date) in ('.join(',',$info).') and year(paid_date)='.$groupby_key.'
						group by '.$groupby.'(paid_date)
			) as temp 
		where 1 
		group by '.$profit_key.' ';       
		$close_out	=	$this->getListWithSql($sql_close_out,$profit_key); 
		///金额格式
		$money_leng	=	C('money_length');   
		
		foreach ((array)$profit_array as $key=>$row) {
		 	///【期初库存金额】=（查询起始日之前（不含起始当天）的库存*上期存货成本）+（查询时间段的期初库存数量*期初单价） 
	 		$row['befor_money']		=	$ini['ini']['befor_money'];
	 		$row['dml_befor_money']	=	moneyFormat($row['befor_money'],0,$money_leng);
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
		 	///调整金额 
		 	if (is_array($adjust_stock[$row[$profit_key]])) { 
		 		$row['adjust_money']		=	$adjust_stock[$row[$profit_key]]['adjust_money'];
		 		$row['dml_adjust_money']	=	moneyFormat($row['adjust_money'],0,$money_leng);
		 	} 
		 	///退货可用 
		 	if (is_array($return_is_use_stock[$row[$profit_key]])) { 
		 		$row['return_is_use_money']		=	$return_is_use_stock[$row[$profit_key]]['return_is_use_money']; 
		 	}  
		 	 
		 	///其他支出 
		 	if (is_array($other_out_money[$row[$profit_key]])) { 
		 		$row['other_out_money']		=	$other_out_money[$row[$profit_key]]['other_out_money'];
		 		$row['dml_other_out_money']	=	moneyFormat($row['other_out_money'],0,$money_leng);
		 	}  
		 	///其他收入 
		 	if (is_array($other_in_money[$row[$profit_key]])) { 
		 		$row['other_in_money']		=	$other_in_money[$row[$profit_key]]['other_in_money'];
		 		$row['dml_other_in_money']	=	moneyFormat($row['other_in_money'],0,$money_leng);
		 	}  
		 	///【折让总金额】=销售单上的优惠总额+收付款作业中的平帐损失+（对帐金额-对帐前的应收或是应付款金额）
		 	if (is_array($close_out[$row[$profit_key]])) {   
		 		$row['close_out_money']		=	$close_out[$row[$profit_key]]['close_out_money']; 
		 		$row['dml_close_out_money']	=	moneyFormat($row['close_out_money'],0,$money_leng);
		 	}    
		 	///【期末库存金额】=期初库存金额+进货总金额-（销售数量*存货成本）+调整总金额 +（退货可用数量*退货成本）
		 	$ini['ini']['befor_money']	=	$row['stock_money']		=	$row['befor_money']+$row['in_stock_money']-$row['sale_basic_money']+$row['adjust_money']+$row['return_is_use_money'];  
		 	$row['dml_stock_money']	=	moneyFormat($row['stock_money'],0,$money_leng);    
		 	///【毛利总金额】   
		 	$row['profit_money']			=	$row['sale_money']+$row['stock_money']-$row['befor_money']-$row['in_stock_money'];
		 	$row['dml_profit_money']		=	moneyFormat($row['profit_money'],0,$money_leng);    
		 	///【净利总金额】
		 	$row['pure_profit_money']		=	$row['profit_money']+$row['other_in_money']-$row['other_out_money']-$row['close_out_money'];
		 	$row['dml_pure_profit_money']	=	moneyFormat($row['pure_profit_money'],0,$money_leng);  
		 	///查看连接的日期区间处理
		 	if ($groupby=='year') {//按年
		 		$from_date	=$groupby_key.'-01-01';
		 		$to_date	=$groupby_key.'-12-31';
		 	}else{///按月
		 		if ($key>9) {
		 			$from_date	=$groupby_key.'-'.$key.'-01';
		 			$to_date	=$groupby_key.'-'.$key.'-31';
		 		}else{
		 			$from_date	=$groupby_key.'-0'.$key.'-01';
		 			$to_date	=$groupby_key.'-0'.$key.'-31';
		 		} 
		 	} 
//		 	$row['link']			=	U('Stat/productStat/search_div/2/from_date/'.$from_date.'/to_date/'.$to_date);
		 	$row['from_date']		= $from_date;
		 	$row['to_date']			= $to_date;
		 	$product[$key]			=	$row; 
		}    
		//filter array(过滤数组)
		foreach ((array)$product as $key=>$row) { 
			 	unset($product[$key]['dd_'.$profit_key]);
		}   
		///显示前的处理
		$return	=	_formatList($product);
		return $return;
	} 
	
	/**
	 * 初始化利润
	 * 1.销售单优惠金额
	 * 2.款项中未兑换本位币的金额
	 *
	 */
	public function iniProfit(){
		///本位币
		$base_currency_id	=	 C('currency');
		///销售单
		$this->iniProfitSale($base_currency_id);
		///款项
		$this->iniProfitFund($base_currency_id);
		///初始化退货利润
		$this->iniProfitReturn();
	}
}