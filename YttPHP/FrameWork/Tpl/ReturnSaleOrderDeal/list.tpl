{if $login_user.role_type eq C('SELLER_ROLE_TYPE')}
	{assign var='tr_attr' value=['class'=>["is_self"=>[0=>"bg_return_sale_non-sellers"]]]}
{/if}
{ytt_table tr_attr=$tr_attr
	show=[
		["value"=>"return_sale_order_no","title"=>$lang.return_sale_order_no,"link"=>['url'=>'ReturnSaleOrder/view',"link_id"=>['id'=>'return_sale_order_id']]],
		["value"=>"sale_order_no","title"=>$lang.deal_no,"link"=>['url'=>'SaleOrder/view',"link_id"=>['id'=>'sale_order_id']]],
		["value"=>"order_no","title"=>$lang.orderno],  
		["value"=>"factory_name","title"=>$lang.belongs_seller, 'show'=>$login_user.role_type != C('SELLER_ROLE_TYPE'),"link"=>['url'=>'Factory/view',"link_id"=>['id'=>'factory_id']]],
		["value"=>"client_name","title"=>$lang.clientname],
		["value"=>"fmd_return_order_date","title"=>$lang.return_sale_date], 
		["value"=>"w_name","title"=>$lang.return_storage_warehouse],
		["value"=>"order_type_name","title"=>$lang.order_type],
		["value"=>"dd_return_process_status","title"=>$lang.process_state,'span'=>['onclick'=>"$.autoShow(this,'ReturnSaleOrder','state_log')"],
			'hidden'=>[
				['name'=>'object_id','id'=>'object_id','value'=>'return_sale_order_id']
				  ]
		],
		["value"=>"dd_return_process_mode","title"=>$lang.treatment],
		["value"=>"product_detail_info","title"=>$lang.return_product_detail_storage_info,'type'=>'return_storage_product_detail_info',"width"=>"30%"],
    	["value"=>"dml_return_process_fee","title"=>$lang.return_process_fee]
    	]
	listType="flow"
	flow="sale"
	from=$list.list
    addTab=true
}