{ytt_table 
	show=[
			["value"=>"stocktake_no","title"=>$lang.stocktake_no,"link"=>["link_id"=>"stocktake_id","title"=>"查看盘点单"]],
			["value"=>"stocktake_date","title"=>$lang.stocktake_date],
			["value"=>"w_name","title"=>$lang.warehouse],
			["value"=>"sum_quantity","title"=>$lang.index_sum_quantity,'type'=>'flow_storage_format'],
			["value"=>"sun_capability","title"=>$lang.sum_quantity]
		]
	operate_show=[
		["role"=>'update','class'=>'icon icon-list-edit','url'=>'Stocktake/edit'],
		["role"=>'delete','class'=>'icon icon-list-del','url'=>'Stocktake/delete','onclick'=>'$.cancel(this)'],
		["role"=>'insert','class'=>'icon icon-stat-profit','url'=>'Profitandloss/add','link_id'=>['w_id'=>'warehouse_id','id'=>'id'],"module_name"=>'Profitandloss',"title"=>"生成盈亏单"]
	]
	listType='flow'
	flow="stocktake"
	from=$list.list
}
