{ytt_table
	show=[
            ["value"=>"w_name","title"=>L('belongs_warehouse'),"width"=>"20%"],
			["value"=>"domestic_shipping_fee_no","title"=>$lang.shipping_fee_no,"link"=>['url'=>'DomesticShippingFee/view',"link_id"=>"id"]],
			["value"=>"domestic_shipping_fee_name","title"=>$lang.shipping_fee_name,"link"=>['url'=>'DomesticShippingFee/view',"link_id"=>"id"]],
			["value"=>"dd_transport_type","title"=>$lang.transport_type, 'width'=>"10%"],
			["value"=>"edit_comments","title"=>$lang.comments]
		]
	listType='basic'
	flow="processfee"
	from=$list.list
	operate=$admin
}
