{ytt_table
	show=[
			["value"=>"factory_name","title"=>$lang.factory_name,"width"=>"10%", 'td'=>['class'=>'t_right'], 'show'=>$login_user.role_type != C('SELLER_ROLE_TYPE')],
			["value"=>"object_no","title"=>$lang.deal_no,"width"=>"12%","link"=>["url"=>"SaleOrder/view","link_id"=>['id'=>"object_id"]]],
			["value"=>"status_code","title"=>$lang.status_code,"width"=>"9%", 'td'=>['class'=>'t_center']],
			["value"=>"edit_status_message","title"=>$lang.status_message]
		]
	from=$list.list
	operate=false
}