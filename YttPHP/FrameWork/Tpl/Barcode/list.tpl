{ytt_table 
	show=[
			["value"=>"barcode_no","title"=>$lang.barcode_no],
			["value"=>"product_no","title"=>$lang.product_no ,"link"=>['url'=>'Product/view',"link_id"=>['id'=>'p_id']]],
			["value"=>"product_name","title"=>$lang.product_name]
		]
	operate	=false	
	sort=["bank_name"=>["sort_by"=>0,"sort_action"=>"index"]]
	from=$list.list
}