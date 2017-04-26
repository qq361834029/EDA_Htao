{ytt_table
	show=[
			["value"=>"return_service_no","title"=>$lang.return_service_no,"link"=>['url'=>'ReturnService/view',"link_id"=>"id"]],
			["value"=>"return_service_name","title"=>$lang.return_service_name,"link"=>['url'=>'ReturnService/view',"link_id"=>"id"]],
			["value"=>"comments","title"=>$lang.comment, 'show'=>!$is_factory]
		]
	operate=!$is_factory
	listType='flow'
	flow="return_service"
	from=$list.list
}
