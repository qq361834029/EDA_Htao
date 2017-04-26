{ytt_table
	tr_attr=["class"=>["is_default"=>[1=>"line_bzgreen"]]]
	show=[
		["value"=>"w_no","title"=>$lang.warehouse_no,"link"=>['url'=>'Warehouse/view',"link_id"=>['id'=>'id'], 'show'=>!$is_factory],"width"=>"10%"],
		["value"=>"w_name","title"=>$lang.warehouse_name,"link"=>['url'=>'Warehouse/view',"link_id"=>['id'=>'id'], 'show'=>!$is_factory],"width"=>"10%"],
		["value"=>"dd_is_use","title"=>$lang.is_use,"width"=>"5%", 'show'=>!$is_factory],
		["value"=>"edit_w_address","title"=>$lang.warehouse_address],
		
		["value"=>"area","title"=>$lang.warehouse_area,"width"=>"7%", 'show'=>!$is_factory],
		
		["value"=>"contact","title"=>$lang.contact,"width"=>"6%", 'show'=>!$is_factory],
		
		["value"=>"phone","title"=>$lang.phone,"width"=>"8%", 'show'=>!$is_factory],
		["value"=>"fax","title"=>$lang.fax_no,"width"=>"8%", 'show'=>!$is_factory],
		["value"=>"email","title"=>$lang.email,"width"=>"10%", 'show'=>!$is_factory]
	]
	operate=!$is_factory
	sort=["w_no"=>["sort_by"=>0,"sort_action"=>"index"],"w_name"=>["sort_by"=>0,"sort_action"=>"index"]]
	from=$list.list
}