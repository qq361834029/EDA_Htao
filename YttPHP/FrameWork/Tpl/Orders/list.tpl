{ytt_table tr_attr=['class'=>["order_state"=>["4"=>"manual_finished","2"=>"manual_finished"]]] 
	show=[
			["value"=>"order_no","title"=>$lang.order_no,"link"=>["link_id"=>"orders_id"]],
			["value"=>"factory_name","title"=>$lang.factory_name,'link'=>['url'=>'Factory/view','link_id'=>['id'=>'factory_id']]],
			["value"=>"product_qn","title"=>$lang.product_qn],
			["value"=>"fmd_order_date","title"=>$lang.order_date],
			["value"=>"fmd_expect_date","title"=>$lang.expect_date],
			["value"=>"dml_sum_capability","title"=>$lang.index_sum_quantity,'type'=>'flow_storage_format'],
			["value"=>"dml_sun_quantity","title"=>$lang.sum_quantity,"font_class"=>["load_state"=>["1"=>"red"]]],
			["value"=>"dml_money","title"=>$lang.total_money],
			["value"=>"dml_load_capability","title"=>$lang.load_quantity,'flow'=>'loadContainer','type'=>'flow_storage_format'],
			["value"=>"dml_load_quantity","title"=>$lang.load_sum_quantity,"span"=>["url"=>"Orders/setOrderFinished","dialogId"=>"orderFinished","onclick"=>"$.showDialog(this)"],"font_class"=>["load_state"=>["1"=>"red"]]]
		]
	listType='flow'
	flow="order"
	from=$list.list
}
