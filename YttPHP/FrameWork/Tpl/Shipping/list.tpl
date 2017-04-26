{ytt_table
	show=[
			["value"=>"express_no","title"=>$lang.shipping_no,"link"=>['url'=>'Shipping/view',"link_id"=>"id"]],
			["value"=>"express_name","title"=>$lang.shipping_name,"link"=>['url'=>'Shipping/view',"link_id"=>"id"]],
			["value"=>"dd_shipping_type","title"=>$lang.shipping_type, 'width'=>"6%"],
			["value"=>"express_date","title"=>$lang.express_date],
			["value"=>"comp_name","title"=>$lang.express],
			["value"=>"w_name","title"=>$lang.warehouse_name],
			["value"=>"dd_status","title"=>$lang.is_enable, 'show'=>!$is_factory],
			["value"=>"edit_comments","title"=>$lang.comments, 'show'=>!$is_factory]
		]
	operate=!$is_factory
	listType='flow'
	flow="shipping"
	from=$list.list
}
