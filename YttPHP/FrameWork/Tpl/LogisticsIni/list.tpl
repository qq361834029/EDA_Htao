 {ytt_table 
	show=[
			["value"=>"logistics_name","title"=>$lang.logistics_name,"width"=>"18%"],
			["value"=>"fmd_paid_date","title"=>$lang.date,"width"=>"15%"],
			["value"=>"currency_no","title"=>$lang.currency,"width"=>"15%"],
			["value"=>"dml_should_paid","title"=>$lang.money,"width"=>"15%"],
			["value"=>"comments","title"=>$lang.comments]
		]
	sort=["paid_date"=>["sort_by"=>0,"sort_action"=>"index"]]
	listType='flow'
	from=$list.list
} 