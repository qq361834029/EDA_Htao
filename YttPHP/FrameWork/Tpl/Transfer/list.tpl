{ytt_table 
	show=[
			["value"=>"transfer_no","title"=>$lang.transfer_no,"link"=>["link_id"=>"transfer_id"]],
			["value"=>"fmd_transfer_date","title"=>$lang.transfer_date],
			["value"=>"dml_total_quantity","title"=>$lang.index_sum_quantity,'type'=>'flow_storage_format'],
			["value"=>"dml_sum_quantity","title"=>$lang.transfer_total]
		]
	listType='flow'
	flow="transfer"
	from=$list.list
}

