{ytt_table from=$list.list
	show=[
			['title'=>$lang.client_name,'value'=>'client_name'],
			['title'=>$lang.deal_order_date,'value'=>'fmd_order_date'],
			['title'=>$lang.deal_days,'value'=>'undeal_days','td'=>['class'=>'t_right']]	
		]
	operate=false
}