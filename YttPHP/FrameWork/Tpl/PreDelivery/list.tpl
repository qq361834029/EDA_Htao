{ytt_table
	show=[
			["value"=>"orders_no","title"=>$lang.sale_no,"link"=>["url"=>"SaleOrder/view","link_id"=>['id'=>"sale_order_id"],"title"=>"查看订单"]],
			["value"=>"pre_delivery_no","title"=>$lang.pre_delivery_no,"link"=>["url"=>"PreDelivery/view","link_id"=>"id","title"=>"查看订单123"]],
			["value"=>"client_name","title"=>$lang.client_name,'link'=>['url'=>'Client/view','link_id'=>['id'=>'client_id']]],
			["value"=>"product_qn","title"=>$lang.product_qn],
			["value"=>"dml_sum_qua","title"=>$lang.index_sum_quantity,'type'=>'flow_storage_format'],
			["value"=>"dml_sum_quantity","title"=>$lang.sum_quantity],
			["value"=>"fmd_expect_shipping_date","title"=>$lang.expect_shipping_date], 
			["value"=>"fmd_pre_delivery_date","title"=>$lang.pre_delivery_date]
		] 
	listType='flow'
	flow="preDelivery"
	from=$list.list
}
