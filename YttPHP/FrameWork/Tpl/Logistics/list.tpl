{ytt_table
	show=[
        ["value"=>"comp_no","title"=>$lang.code,"width"=>"10%"],
		["value"=>"comp_name","title"=>$lang.logistics_name,"link"=>['url'=>'Logistics/view',"link_id"=>['id'=>'id']],"width"=>"15%"],
		["value"=>"contact","title"=>$lang.contact,"width"=>"10%"],
		["value"=>"mobile","title"=>$lang.phone,"width"=>"10%"],
		["value"=>"email","title"=>$lang.email,"width"=>"15%"],
		["value"=>"merge_address","title"=>$lang.address],
		["value"=>"fax","title"=>$lang.fax_no,"width"=>"10%"],
		["value"=>"comments","title"=>$lang.comments]
	]
	sort=["comp_no"=>["sort_by"=>0,"sort_action"=>"index"],"comp_name"=>["sort_by"=>0,"sort_action"=>"index"]]
	from=$list.list
}