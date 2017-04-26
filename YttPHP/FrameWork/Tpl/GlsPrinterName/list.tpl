{ytt_table 
	show=[
			["value"=>"mac_address","title"=>$lang.mac_address,"link"=>['url'=>'GlsPrinterName/view',"link_id"=>['id'=>'id']]],
			["value"=>"printer_name","title"=>$lang.printer_name,"link"=>['url'=>'GlsPrinterName/view',"link_id"=>['id'=>'id']]]
		]
	sort=["mac_address"=>["sort_by"=>0, "sort_action"=>"index"]]
	from=$list.list
	listType='flow'
}