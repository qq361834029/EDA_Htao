{ytt_table 
	show=[
			["value"=>"file_list_no","title"=>$lang.instock_no,"link"=>["file_url"=>'file_url']],
			["value"=>"instock_list","title"=>$lang.delivery_no, 'td'=>['class'=>'t_center']],
			["value"=>"w_name","title"=>$lang.warehouse_name],
			["value"=>"fmd_create_time","title"=>$lang.doc_date],
			["value"=>"add_real_name","title"=>$lang.doc_staff],
			["value"=>"dml_product_count","title"=>$lang.product_count],
			["value"=>"dml_quantity","title"=>$lang.product_sum_quantity],
			["value"=>"dml_product_error_count","title"=>$lang.product_error_count],
			["value"=>"dml_error_quantity","title"=>$lang.error_quantity],
			["value"=>"edit_comments","title"=>$lang.comments]
		]
	listType='flow'
	from=$list.list
}