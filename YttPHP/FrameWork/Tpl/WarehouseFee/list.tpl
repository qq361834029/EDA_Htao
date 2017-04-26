{ytt_table 
	show=[
			["value"=>"warehouse_fee_no","title"=>$lang.code,"link"=>['url'=>'WarehouseFee/view',"link_id"=>['id'=>'id']]],
			["value"=>"warehouse_fee_name","title"=>$lang.name]
		]
	operate=!$is_factory
	listType='flow'
	flow="warehouse_fee"
	from=$list.list
}

