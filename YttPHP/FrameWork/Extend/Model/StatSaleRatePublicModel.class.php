<?php

/**
 * 自定义销售查询
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category    统计
 * @package   Model
 * @author     何剑波
 * @version  2.1,2012-07-22
 */

class StatSaleRatePublicModel extends CommonModel {
	protected $tableName = 'sale_order';
	/**
	 * 自定义销售查询
	 * @return 查询结果集
	 */
	public function getSaleRate() {		
		import("ORG.Util.Page"); 
		// 销售 & 进货		
		$product_where 	=  $_POST['query']['e.product_id'] ? ' and product_id='.$_POST['query']['e.product_id'] : '';
		$sale_where		=  $_POST['query']['e.product_id'] ? ' and e.product_id='.$_POST['query']['e.product_id'] : '';
		$in_date		= $_POST['date']['to_in_date'] ? $_POST['date']['to_in_date'] : $_POST['date']['from_in_date'];	
		if ($in_date) { // 进货的日期条件(进货数量是截止日期)
			$instock_where	= ' and date(real_arrive_date) <=\''.formatDate($in_date).'\'';
			$adjust_where	= ' and date(adjust_date) <=\''.formatDate($in_date).'\'';
			$init_where		= ' and date(init_storage_date) <=\''.formatDate($in_date).'\'';
			$prof_where		= ' and date(profitandloss_date) <=\''.formatDate($in_date).'\'';
			$return_where	= ' and date(return_order_date) =\''.formatDate($in_date).'\'';			
		}			
		if ($_POST['date']['to_in_date'] && $_POST['date']['from_in_date']) { // 销售和退换货的是区间
			$from_date 		= formatDate($_POST['date']['from_in_date']);
			$to_date		= formatDate($_POST['date']['to_in_date']);				
			$return_where	= ' and date(return_order_date) >=\''.$from_date.'\' and date(return_order_date)<=\''.$to_date.'\'';
			$sale_where		.= ' and date(order_date) >=\''.$from_date.'\' and date(order_date)<=\''.$to_date.'\'';
		} else if($in_date) {
			$sale_where		.= ' and date(order_date) =\''.formatDate($in_date).'\'';
		}
					
		$_POST['query']['e_product_id']	= $_POST['query']['e.product_id'];
		$sql = " select count(1) as count from (				 
					select product_id					 
					from instock inner join instock_detail on instock.id= instock_id 
					where 1 ".$product_where.$instock_where."
					group by product_id  
					union
					select product_id 						 
					from adjust inner join adjust_detail on adjust.id= adjust_id  
					where 1 ".$product_where.$adjust_where."
					group by product_id 
					union
					select product_id			 
					from init_storage inner join init_storage_detail on init_storage.id= init_storage_id
					where 1 ".$product_where.$init_where."
					group by product_id   
					union
					select product_id					 
					from profitandloss inner join profitandloss_detail on profitandloss.id= profitandloss_id
					where `state`=2 ".$product_where.$prof_where."
					group by product_id 				 						
				) as temp";
		$count 	= M()->cache()->query($sql);
		if (!$count) return ;
		$p 		= new Page($count[0]['count']);
		$page 	= $p->show();
		// 分页信息
		$limit 	= ' limit '.$p->firstRow . ','.$p->listRows;
		if (C('sale.relation_sale_follow_up')==2) {
			$sql = ' select out_quantity as out_quantity,in_quantity,a.product_id,out_quantity/in_quantity as percent 
					from (
						select product_id,sum(in_quantity) as in_quantity from (
							select product_id,sum(quantity*capability*dozen) as in_quantity 						 
							from instock inner join instock_detail on instock.id= instock_id
							where 1 '.$product_where.$instock_where.' 
							group by product_id   
							union all
							select product_id,sum(quantity*capability*dozen) as in_quantity 						 
							from adjust inner join adjust_detail on adjust.id= adjust_id  
							where 1 '.$product_where.$adjust_where.' 
							group by product_id 
							union all
							select product_id,sum(quantity*capability*dozen) as in_quantity 						 
							from init_storage inner join init_storage_detail on init_storage.id= init_storage_id
							where 1 '.$product_where.$init_where.' 
							group by product_id   
							union all
							select product_id,sum((stocktake_quantity-storage_quantity)*capability*dozen) as in_quantity 						 
							from profitandloss inner join profitandloss_detail on profitandloss.id= profitandloss_id
							where `state`=2  '.$product_where.$prof_where.' 
							group by product_id 
				 ) as tmp group by product_id					 	
					 ) as  a 
					 left join 
					 (
					 	select product_id ,sum(quantity) as out_quantity from (	
							select product_id,sum(quantity*capability*dozen) as quantity				 
					 		from sale_order f inner join sale_order_detail e on f.id=e.sale_order_id 
					 		where 1 '.$sale_where.' group by  product_id
					 		union all
					 		select c.product_id,-sum(c.quantity*c.capability*c.dozen) as quantity 
					 		 from  return_sale_order t inner join  return_sale_order_detail c on t.id=c.return_sale_order_id
					 		 where 1 '.$product_where.$return_where.' group by c.product_id	
					 	) as p group by product_id
					 ) as b 
					 on a.product_id=b.product_id
					 order by percent desc '.$limit;		
		} else {				
			$sql = ' select out_quantity as out_quantity,in_quantity,a.product_id,out_quantity/in_quantity as percent 
					from (
						select  product_id,sum(in_quantity) as in_quantity  from (
							select product_id,sum(quantity*capability*dozen) as in_quantity 						 
							from instock inner join instock_detail on instock.id= instock_id 
							where 1 '.$product_where.$instock_where.' 
							group by product_id   
							union all
							select product_id,sum(quantity*capability*dozen) as in_quantity 						 
							from adjust inner join adjust_detail on adjust.id= adjust_id  
							where 1 '.$product_where.$adjust_where.' 
							group by product_id 
							union all
							select product_id,sum(quantity*capability*dozen) as in_quantity 						 
							from init_storage inner join init_storage_detail on init_storage.id= init_storage_id
							where 1 '.$product_where.$init_where.' 
							group by product_id   
							union all
							select product_id,sum((stocktake_quantity-storage_quantity)*capability*dozen) as in_quantity 						 
							from profitandloss inner join profitandloss_detail on profitandloss.id= profitandloss_id
							where `state`=2  '.$product_where.$prof_where.' 
							group by product_id 
				 ) as tmp group by product_id			 	
					 ) as  a 
					 left join 
					 (	
					  select product_id ,sum(quantity) as out_quantity from (				  
						select e.product_id,
					 	sum(if(f.sale_order_state =3, 
					 		  g.quantity*g.capability*g.dozen,
					 		  e.quantity*e.capability*e.dozen)) as quantity	
					 	from sale_order f inner join sale_order_detail e on f.id=e.sale_order_id 				 	
					 	left join delivery_detail g on g.sale_order_detail_id=e.id	and f.sale_order_state=3					 					 	
					 	where 1'.$sale_where.' group by e.product_id 	
					 	union all
					 	select c.product_id,-sum(c.quantity*c.capability*c.dozen) as quantity 
					 	from  return_sale_order t inner join  return_sale_order_detail c on t.id=c.return_sale_order_id
					 	where 1 '.$product_where.$return_where.' group by c.product_id					 	
					  ) as p group by product_id		 	
					 ) as b 
					 on a.product_id=b.product_id
					 order by percent desc '.$limit;		
		}		
		$list = $this->db->query($sql);		
		foreach ($list as &$value) {
			$value['dml_percent'] = moneyFormat($value['percent']*100, 0, 2).'%';
		}
		$list	= _formatList($list);	
		$list['page'] = $page;			
		return $list;
	}
}