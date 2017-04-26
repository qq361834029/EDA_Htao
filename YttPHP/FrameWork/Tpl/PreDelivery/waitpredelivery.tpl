{ytt_table
	show=[ 
			["value"=>"sale_order_no","title"=>$lang.sale_no,"link"=>["url"=>"SaleOrder/view","link_id"=>"id","title"=>"查看"]],
			["value"=>"client_name","title"=>$lang.client_name,'link'=>['url'=>'Client/view','link_id'=>['id'=>'client_id']]], 
			["value"=>"product_qn","title"=>$lang.product_qn],
			["value"=>"dml_sum_qua","title"=>$lang.index_sum_quantity,'type'=>'flow_storage_format'],
			["value"=>"dml_sum_quantity","title"=>$lang.sum_quantity],
			["value"=>"fmd_order_date","title"=>$lang.sale_date],
			["value"=>"fmd_expect_shipping_date","title"=>$lang.expect_shipping_date] 
		]
	operate_show=[
		["role"=>'insert','class'=>'icon icon-list-edit','url'=>'PreDelivery/add',title=>'配货']
	]
	listType='flow'
	flow="preDelivery"
	from=$list.list
}
