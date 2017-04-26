 {ytt_table operate=false
	show=[
			["value"=>"profit_date","title"=>$lang.date,"link"=>["url"=>"StatProductProfit/index","link_id"=>["search_div"=>"2","from_date"=>"from_date","to_date"=>"to_date"]]],
			["value"=>"dml_befor_money","title"=>$lang.pre_storage_money],
			["value"=>"dml_in_stock_money","title"=>$lang.instock_money],
			["value"=>"dml_sale_money","title"=>$lang.sale_money],
			["value"=>"dml_adjust_money","title"=>$lang.special_money],
			["value"=>"dml_stock_money","title"=>$lang.final_storage_money],
			["value"=>"dml_profit_money","title"=>$lang.cross_money],
			["value"=>"dml_other_in_money","title"=>$lang.other_in_money],
			["value"=>"dml_other_out_money","title"=>$lang.other_out_money],
			["value"=>"dml_close_out_money","title"=>$lang.discount_money],
			["value"=>"dml_pure_profit_money","title"=>$lang.profit_money]
		]
	from=$list.list
} 