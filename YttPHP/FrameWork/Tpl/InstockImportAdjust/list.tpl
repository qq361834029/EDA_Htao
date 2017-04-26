{ytt_table 
	show=[
			["value"=>"adjust_no","title"=>$lang.adjust_no,"link"=>["link_id"=>"instockImportAdjust_id"]],
            ["value"=>"instock_no","title"=>$lang.delivery_no],
			["value"=>"dml_total_quantity","title"=>$lang.common_adjust_quantity],
            ["value"=>"add_real_name","title"=>$lang.operate_person],
			["value"=>"comments","title"=>$lang.comments] 
		]
	listType='flow'
	flow="instockimportadjust"
	from=$list.list
}

