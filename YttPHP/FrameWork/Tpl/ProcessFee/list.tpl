{ytt_table
	show=[
            ["value"=>"w_name","title"=>L('belongs_warehouse'),"width"=>"20%"],
			["value"=>"process_fee_no","title"=>$lang.process_fee_no,"link"=>['url'=>'ProcessFee/view',"link_id"=>"id"]],
			["value"=>"process_fee_name","title"=>$lang.process_fee_name,"link"=>['url'=>'ProcessFee/view',"link_id"=>"id"]],
			["value"=>"dd_shipping_type","title"=>$lang.shipping_type, 'width'=>"5%"],
			["value"=>"dd_accord_type","title"=>$lang.type,"width"=>"5%"],
			["value"=>"edit_comments","title"=>$lang.comments]
		]
	listType='flow'
	flow="processfee"
	from=$list.list
	operate=$admin
}
