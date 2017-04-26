{ytt_table 
	show=[
			["value"=>"profitandloss_no","title"=>$lang.profitandloss_no,"link"=>["link_id"=>"profitandloss_id","title"=>"查看盈亏单"]],
			["value"=>"profitandloss_date","title"=>$lang.profitandloss_date],
			["value"=>"w_name","title"=>$lang.warehouse],
			["value"=>"dml_total_quantity","title"=>$lang.index_sum_quantity,'type'=>'flow_loss_quantity'],
			["value"=>"dml_sum_quantity","title"=>$lang.sum_quantity]
		]
	operate_show=[
		["role"=>'RightExtra','class'=>'icon icon-stat-profit','url'=>'Profitandloss/rightExtra'],
		["role"=>'delete','class'=>'icon icon-list-del','url'=>'Profitandloss/delete','onclick'=>'$.cancel(this)']
	]
	listType='flow'
	flow="profitandloss"
	from=$list.list
}
