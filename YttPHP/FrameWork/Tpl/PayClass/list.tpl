{ytt_table 
	show=[
			["value"=>"pay_class_name","title"=>$lang.pay_class_name],
			["value"=>"dd_pay_type","title"=>$lang.pay_type]
		]
	sort=["pay_class_name"=>["sort_by"=>0,"sort_action"=>"index"]]
	from=$list.list
}