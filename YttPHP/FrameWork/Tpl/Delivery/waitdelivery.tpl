{ytt_table
	show=[
			
			["value"=>"pre_delivery_no","title"=>$lang.pre_delivery_no,"link"=>["url"=>"PreDelivery/view","link_id"=>"id"]],
			["value"=>"orders_no","title"=>$lang.sale_no,"link"=>["url"=>"SaleOrder/view","link_id"=>['id'=>"sale_order_id"]]],
			["value"=>"client_name","title"=>$lang.client_name,'link'=>['url'=>'Client/view','link_id'=>['id'=>'client_id']]],
			["value"=>"fmd_order_date","title"=>$lang.sale_date],  
			["value"=>"product_qn","title"=>$lang.product_qn],
			["value"=>"dml_sum_qua","title"=>$lang.index_sum_quantity,'type'=>'flow_storage_format'],
			["value"=>"dml_sum_quantity","title"=>$lang.sum_quantity],  
			["value"=>"dml_delivery_qn","title"=>$lang.delivery_qn],
			["value"=>"fmd_expect_shipping_date","title"=>$lang.expect_shipping_date] 
			 
		]
	operate_show=[
		["role"=>'insert','class'=>'icon icon-list-edit','url'=>'Delivery/add']
	]	
	listType='flow'
	flow="delivery"
	from=$list.list
}
