{ytt_table 
	show=[
			["value"=>"factory_name","title"=>$lang.factory_name, 'width'=>'12%',"link"=>["url"=>"Factory/view","link_id"=>['id'=>"factory_id"]], 'show'=>$login_user.role_type != C('SELLER_ROLE_TYPE')],
			["value"=>"w_name","title"=>$lang.warehouse_name, 'width'=>'7%', 'show'=>$login_user.role_type != C('WAREHOUSE_ROLE_TYPE')],
            ["value"=>"fmd_recharge_date","title"=>$lang.recharge_date, 'width'=>'10%'],		
			["value"=>"dml_money","title"=>$lang.recharge_money, 'width'=>'9%'],
			["value"=>"dd_confirm_state","title"=>$lang.state, 'width'=>'6%','span'=>['onclick'=>"$.autoShow(this,'Recharge','state_log')"],
				'hidden'=>[
					['name'=>'object_id','id'=>'object_id','value'=>'id']
					  ]
			],	
			["value"=>"opened_y","title"=>$lang.rate, 'width'=>'7%'],
			["value"=>"dml_money_to","title"=>$lang.money_to, 'width'=>'7%'],
			["value"=>"dml_confirm_money","title"=>$lang.confirm_money, 'width'=>'10%'],
			["value"=>"fmd_cpation_name","title"=>$lang.payment_document, 'width'=>'8%',"link"=>["file_url"=>"file_link"]],
			["value"=>"comments","title"=>$lang.comment]
			
		]
	listType='flow'
	from=$list.list
	addTab=true
}