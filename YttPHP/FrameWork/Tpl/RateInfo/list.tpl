{ytt_table
	serial=true
	show=[
		["value"=>"rate_date","title"=>L('date')],
		["value"=>"currency_from","title"=>L('from_currency'),"width"=>"15%"],
		["value"=>"currency_to","title"=>L('to_currency')],
		["value"=>"opened_y","title"=>L('rate')]
	]
	sort=["comp_no"=>["sort_by"=>0,"sort_action"=>"index"],"comp_name"=>["sort_by"=>0,"sort_name"=>"index"]]
	from=$list.list
} 