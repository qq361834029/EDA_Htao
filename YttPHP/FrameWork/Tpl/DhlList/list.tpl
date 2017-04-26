 {ytt_table 
	show=[
			["value"=>"id","title"=>$lang.id,"width"=>"10%", 'td'=>['class'=>'t_right']],
			["value"=>"object_no","title"=>$lang.deal_no,"width"=>"16%","link"=>["url"=>"SaleOrder/view","link_id"=>['id'=>"object_id"]]],
			["value"=>"dd_express_api_request_type","title"=>$lang.request_type,"width"=>"16%", 'td'=>['class'=>'t_center']],
			["value"=>"dd_express_api_request_status","title"=>$lang.request_status,"width"=>"16%", 'td'=>['class'=>'t_center'],'span'=>['onclick'=>"$.autoShow(this,'{$smarty.const.MODULE_NAME}', 'state_log')"],
				'hidden'=>[
					['name'=>'dhl_list_id','id'=>'object_id','value'=>'id']
				]
			],
			["value"=>"fmd_create_time","title"=>$lang.create_time,"width"=>"16%"],
			["value"=>"fmd_last_request_time","title"=>$lang.last_request_time,"width"=>"16%"]
		]
	from=$list.list
	operate=$smarty.const.ACTION_NAME != 'index'
	operate_show=[
		["role"=>'request','class'=>'icon icon-list-hand','url'=>"{$smarty.const.MODULE_NAME}/request", 'link_id' => ['dhl_list_id' => 'id', 'request_type'=>'express_api_request_type'], 'onclick' => '$.cancel(this)']
	]
} 