 {ytt_table 
	show=[
            ["value"=>"fmd_paid_date","title"=>$lang.funds_date],
			["value"=>"w_name","title"=>$lang.warehouse_name,'show'=>$login_user.role_type != C('WAREHOUSE_ROLE_TYPE')], 
			["value"=>"currency_no","title"=>$lang.funds_currency],
            ["value"=>"pay_class_name","title"=>$lang.funds_class],
            ["value"=>"account_no","title"=>$lang.relation_doc_no,"link"=>["link_type"=>"relation_type","url"=>[1=>"Instock/view",2=>"SaleOrder/view",3=>"ReturnSaleOrder/view",4=>"Product/view"],"link_id"=>['id'=>"object_id"]]],
			["value"=>"dd_billing_type","title"=>$lang.billing_type],
			["value"=>"dml_price","title"=>$lang.price_per_unit],
			["value"=>"dml_owed_money","title"=>$lang.owed_money],
			["value"=>"dml_discount_money","title"=>$lang.account_money],
			["value"=>"dml_should_paid","title"=>$lang.need_paid_money],
			["value"=>"comments","title"=>$lang.comments]
		]
	sort=["paid_date"=>["sort_by"=>0,"sort_action"=>"index"]]
	listType='flow'
	from=$list.list
} 