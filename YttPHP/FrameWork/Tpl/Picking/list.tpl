{ytt_table 
	show=[
			["value"=>"file_list_no","title"=>$lang.picking_no,"link"=>["file_url"=>'file_url']],
			["value"=>"sale_order_list","title"=>$lang.deal_no, 'td'=>['class'=>'t_center'], "show"=>false],
			["value"=>"relation_no","title"=>$lang.picking_import_no, 'td'=>['class'=>'t_center']],
			["value"=>"w_name","title"=>$lang.warehouse_name],
			["value"=>"fmd_create_time","title"=>$lang.doc_date],
			["value"=>"add_real_name","title"=>$lang.doc_staff],
			["value"=>"dml_product_count","title"=>$lang.product_count],
			["value"=>"dml_quantity","title"=>$lang.product_sum_quantity],
			["value"=>"edit_comments","title"=>$lang.comments] 
		]
	listType='flow'
	from=$list.list
}