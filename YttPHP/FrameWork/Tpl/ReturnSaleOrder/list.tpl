{if $login_user.role_type eq C('SELLER_ROLE_TYPE')}
	{assign var='tr_attr' value=['class'=>["is_self"=>[0=>"bg_return_sale_non-sellers"],["is_danger"=>[1=>"tr_background-color-out_stock"]]]]}
{else}
    {assign var='tr_attr' value=['class'=>['is_danger'=>[1=>"tr_background-color-out_stock"]]]}
{/if}
{ytt_table tr_attr=$tr_attr
	show=[
		["value"=>"return_sale_order_no","title"=>$lang.return_sale_order_no,"link"=>['url'=>'ReturnSaleOrder/view',"link_id"=>"id"],"width"=>"10%"],
		["value"=>"return_order_no","title"=>$lang.return_order_no,"link"=>['url'=>'ReturnSaleOrder/view',"link_id"=>"id"],"width"=>"10%"],
		["value"=>"sale_order_no","title"=>$lang.deal_no,"link"=>['url'=>'SaleOrder/view',"link_id"=>['id'=>'sale_order_id']],"width"=>"10%"],
		["value"=>"order_no","title"=>$lang.orderno],  
		["value"=>"factory_name","title"=>$lang.belongs_seller, 'show'=>$login_user.role_type != C('SELLER_ROLE_TYPE'),"link"=>['url'=>'Factory/view',"link_id"=>['id'=>'factory_id']],"width"=>"10%"],
		["value"=>"client_name","title"=>$lang.clientname,"width"=>"10%"],
		["value"=>"fmd_return_order_date","title"=>$lang.return_sale_date,"width"=>"10%"], 
		["value"=>"fmd_returned_date","title"=>$lang.returned_date,"width"=>"10%"],
		["value"=>"order_type_name","title"=>$lang.order_type,"width"=>"10%"],
		["value"=>"ship_name","title"=>$lang.express_way,"width"=>"10%"],
		["value"=>"dd_return_sale_order_state","title"=>$lang.return_sale_order_state,'span'=>['onclick'=>"$.autoShow(this,'ReturnSaleOrder','state_log')"],
			'hidden'=>[
				['name'=>'object_id','id'=>'object_id','value'=>'id']
				  ],"width"=>"10%"
		],
		["value"=>"dd_return_reason","title"=>$lang.return_reason,"width"=>"10%"],
		["value"=>"product_detail_info","title"=>$lang.return_product_detail_info,'type'=>'return_product_detail_info',"width"=>"10%"],
		["value"=>"add_real_name","title"=>$lang.doc_staff,"width"=>"10%"],
        ["value"=>"return_service_price","title"=>$lang.additional_fee,'show'=>!in_array($login_user.role_id,explode(',',C('WAREHOUSE_OPERATIONS_OVERSEAS_ROLE_ID'))),"width"=>"10%"]
    	]
	listType="flow"
	flow="sale"
	from=$list.list
    addTab=true
}