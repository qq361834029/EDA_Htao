 {ytt_table 
	show=[
            ["value"=>"logistics_name","title"=>$lang.logistics_name,"link"=>["url"=>"LogisticsFunds/view","link_id"=>['id'=>"id"]],"width"=>"20%","total_title"=>"title"],
			["value"=>"w_name","title"=>$lang.warehouse_name,"width"=>"10%",'show'=>$login_user.role_type != C('WAREHOUSE_ROLE_TYPE')], 
			["value"=>"dd_paid_type","title"=>$lang.paid_type,"width"=>"8%"],
			["value"=>"fmd_paid_date","title"=>$lang.date,"width"=>"10%"], 
			["value"=>"befor_currency_no","title"=>$lang.befor_currency_name,"width"=>"9%","total_title"=>"currency"],
			["value"=>"dml_befor_money","title"=>$lang.befor_money,"type"=>"flow_client_currency","width"=>"10%","total_title"=>"dml_befor_money"],  
            ["value"=>"currency_no","title"=>$lang.currency,"width"=>"9%"],
            ["value"=>"dml_money","title"=>$lang.money,"width"=>"10%","total_title"=>"dml_money"], 
            ["value"=>"dml_account_money","title"=>$lang.account_money,"width"=>"10%","total_title"=>"dml_account_money"],
			["value"=>"comments","title"=>$lang.comments,"width"=>"10%"]
		]
	sort=["paid_date"=>["sort_by"=>0,"sort_action"=>"index"]]
	listType='flow'
	from=$list.list
    all_total=$total_money.list
} 