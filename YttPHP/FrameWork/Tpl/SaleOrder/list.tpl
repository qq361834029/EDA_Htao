{ytt_table tr_attr=['class'=>["out_stock_type"=>["3"=>"tr_background-color","2"=>"tr_background-color"],"sale_order_state"=>["13"=>"tr_background-color-deleted"],"is_background"=>["1"=>"tr_background-color_ffd1a4"]]] 
show=[
		["value"=>"sale_order_no","title"=>$lang.deal_no,"link"=>["url"=>"SaleOrder/view","link_id"=>"id"],"class"=>["sale_order_state"=>[1=>"red","2"=>"green"]],"width"=>"10%"],
		["value"=>"order_no","title"=>$lang.orderno,"link"=>["url"=>"SaleOrder/view","link_id"=>"id"],"font_class"=>["order_state"=>[2=>"red","1"=>"green"]],"editCell"=>["link_id"=>"id"],"width"=>"15%"],
		["value"=>"factory_name","title"=>$lang.belongs_seller, 'show'=>$login_user.role_type != C('SELLER_ROLE_TYPE'),"link"=>['url'=>'Factory/view',"link_id"=>['id'=>'factory_id']],"width"=>"5%"],
		["value"=>"client_name","title"=>$lang.clientname,"width"=>"5%"],
		["value"=>"country_name","title"=>$lang.belongs_country,"width"=>"5%"],
		["value"=>"fmd_order_date","title"=>$lang.sale_date,"width"=>"5%"],
		["value"=>"fmd_go_date","title"=>$lang.out_stock_date,"width"=>"5%"],
		["value"=>"order_type_name","title"=>$lang.order_type,"width"=>"5%"],
		["value"=>"dd_sale_order_state","title"=>$lang.sale_order_state,"width"=>"5%",'span'=>['onclick'=>"$.autoShow(this,'SaleOrder','state_log')"],
			'hidden'=>[
				['name'=>'sale_order_id','id'=>'sale_order_id','value'=>'id'],
				['name'=>'factory_id','id'=>'factory_id','value'=>'factory_id'],
				['name'=>'merge_address','id'=>'merge_address','value'=>'merge_address'],
				['name'=>'post_code','id'=>'post_code','value'=>'post_code'],
				['name'=>'object_id','id'=>'object_id','value'=>'id']
				  ]
		],
		["value"=>"product_detail_info","title"=>$lang.simple_product_info,'type'=>'simple_product_info',"width"=>"20%"],
        ["value"=>"dml_weight","title"=>$lang.sale_order_weight,"width"=>"8%"],
		["value"=>"ship_name","title"=>$lang.express_way,"width"=>"5%"],
		["value"=>"dml_delivery_fee","title"=>$lang.delivery_costs,'show'=>!in_array($login_user.role_id,explode(',',C('WAREHOUSE_OPERATIONS_OVERSEAS_ROLE_ID'))),"width"=>"5%"],
		["value"=>"dml_process_fee","title"=>$lang.process_fee,'show'=>!in_array($login_user.role_id,explode(',',C('WAREHOUSE_OPERATIONS_OVERSEAS_ROLE_ID'))),"width"=>"5%"],
		["value"=>"dml_package_fee","title"=>$lang.package_fee,'show'=>!in_array($login_user.role_id,explode(',',C('WAREHOUSE_OPERATIONS_OVERSEAS_ROLE_ID'))),"width"=>"5%"],
		["value"=>"w_name","title"=>$lang.shipping_warehouse,"width"=>"5%"],
		["value"=>"track_no","title"=>$lang.track_no,"width"=>"10%"]
	]
listType='flow'
flow="sale"
from=$list.list
addTab=true
expand_operate_show=[
	["role"=>'deleteShipmentDD','class'=>'icon icon-list-hand', 'onclick' => '$.cancel(this)', 'show_field'=>'express_api_delete']
]
}