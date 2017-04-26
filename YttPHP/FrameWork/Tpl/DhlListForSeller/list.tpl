{if $login_user.role_type == C('SELLER_ROLE_TYPE')}
{ytt_table 
	show=[
			["value"=>"object_no","title"=>$lang.deal_no,"width"=>"12%","link"=>["url"=>"SaleOrder/view","link_id"=>['id'=>"object_id"]]],
			["value"=>"status_code","title"=>$lang.status_code,"width"=>"9%", 'td'=>['class'=>'t_center']],
			["value"=>"status_message","title"=>$lang.status_message,"width"=>"18%", 'td'=>['class'=>'t_center']],
			["value"=>"deal_status_code","title"=>$lang.process_status_code,"width"=>"9%", 'td'=>['class'=>'t_center']],
			["value"=>"deal_status_message","title"=>$lang.process_status_message,"width"=>"46%"]
		]
	from=$list.list
	operate=false
}
{else}
{ytt_table
	show=[
			["value"=>"factory_name","title"=>$lang.factory_name,"width"=>"10%", 'td'=>['class'=>'t_right']],
			["value"=>"object_no","title"=>$lang.deal_no,"width"=>"12%","link"=>["url"=>"SaleOrder/view","link_id"=>['id'=>"object_id"]]],
			["value"=>"status_code","title"=>$lang.status_code,"width"=>"9%", 'td'=>['class'=>'t_center']],
			["value"=>"status_message","title"=>$lang.status_message,"width"=>"18%", 'td'=>['class'=>'t_center']],
			["value"=>"deal_status_code","title"=>$lang.process_status_code,"width"=>"9%", 'td'=>['class'=>'t_center']],
			["value"=>"deal_status_message","title"=>$lang.process_status_message,"width"=>"46%"]
		]
	from=$list.list
	operate=false
}
{/if}