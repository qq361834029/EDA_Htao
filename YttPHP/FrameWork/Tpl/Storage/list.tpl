{ytt_table
	show=[
			["value"=>"product_id","title"=>$lang.product_id,"total_title"=>"title"],
			["value"=>"product_no","title"=>$lang.product_no,"autoshow"=>["module"=>"Storage","field"=>"product_id"]],
			["value"=>"product_name","title"=>$lang.product_name],
			["value"=>"factory_name","title"=>$lang.belongs_seller, "show"=>!$is_factory],
			["value"=>"dml_real_quantity","title"=>$lang.real_storage,"autoshow"=>["module"=>$is_return_sold,"field"=>"product_id"],"total_title"=>"real_quantity"],
			["value"=>"dml_reserve_quantity","title"=>$lang.reserve_storage,"total_title"=>"reserve_quantity"],
			["value"=>"dml_sale_quantity","title"=>$lang.sale_storage,"show"=>$is_return_sold=='RealStorage',"total_title"=>"sale_quantity"],
			["value"=>"dml_onroad_quantity","title"=>$lang.onroad_storage,"total_title"=>"onroad_quantity"]
		]
	flow="storage"
	operate=false
	from=$list.list
    page_total=$list.total.currency_id_sum
    all_total=$list.all_total
}