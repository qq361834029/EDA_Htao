 {ytt_table 
	show=[
			["value"=>"factory_name","title"=>$lang.factory_name,"width"=>"22%"],
			["value"=>"fmd_paid_date","title"=>$lang.date,"width"=>"10%"],
			["value"=>"currency_no","title"=>$lang.currency,"width"=>"10%"],
			["value"=>"dml_should_paid","title"=>$lang.money,"width"=>"15%"],
			["value"=>"comments","title"=>$lang.comments]
		]
	sort=["paid_date"=>["sort_by"=>0,"sort_action"=>"index"]]
	listType='flow'
	from=$list.list
} 