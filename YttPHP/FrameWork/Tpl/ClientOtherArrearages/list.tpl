 {ytt_table 
	show=[
			["value"=>"fmd_paid_date","title"=>$lang.funds_date,"width"=>"6%","total_title"=>"title"],
			["value"=>"factory_name","title"=>$lang.factory_name,"width"=>"8%", 'show' => !$is_factory],
            ["value"=>"w_name","title"=>$lang.warehouse_name,"width"=>"10%",'show'=>$login_user.role_type != C('WAREHOUSE_ROLE_TYPE')], 
			["value"=>"pay_class_name","title"=>$lang.funds_class,"width"=>"10%"],
			["value"=>"currency_no","title"=>$lang.funds_currency,"width"=>"4%","total_title"=>"currency"],
			["value"=>"account_no","title"=>$lang.relation_doc_no,"width"=>"14%","link"=>["link_type"=>"relation_type","url"=>[1=>"Instock/view",2=>"SaleOrder/view",3=>"ReturnSaleOrder/view",4=>"Product/view"],"link_id"=>['id'=>"object_id"]]],
			["value"=>"dd_billing_type","title"=>$lang.billing_type,"width"=>"4%"],
			["value"=>"dml_quantity","title"=>$lang.quantity,"width"=>"5%", 'value_field'=>['field'=>[C('BILLING_TYPE_CUBE')=>'dml_cube', C('BILLING_TYPE_WEIGHT')=> 'dml_weight'],'type'=>'billing_type']],
			["value"=>"dml_price","title"=>$lang.price_per_unit,"width"=>"6%"],
			["value"=>"dml_owed_money","title"=>$lang.owed_money,"width"=>"8%","total_title"=>"dml_owed_money"],
			["value"=>"dml_discount_money","title"=>$lang.account_money,"width"=>"8%","total_title"=>"dml_discount_money"],
			["value"=>"dml_should_paid","title"=>$lang.receivable_money,"width"=>"8%","total_title"=>"dml_should_paid"],
			["value"=>"comments","title"=>$lang.comments]
		]
	operate=!$is_factory
	sort=["paid_date"=>["sort_by"=>0,"sort_action"=>"index"]]
	listType='flow'
	from=$list.list
    addTab=true
    all_total=$total_money.list
} 