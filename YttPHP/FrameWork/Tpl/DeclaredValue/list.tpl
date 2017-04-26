{ytt_table 
	show=[  
            ["value"=>"create_time","title"=>$lang.doc_date],
			["value"=>"product_no","title"=>$lang.product_no],
            ["value"=>"product_name","title"=>$lang.product_name],
			["value"=>"declared_value","title"=>$lang.declared_value],
            ["value"=>"real_name","title"=>$lang.doc_staff]
		]
	listType='flow'
    operate=false
	flow="declaredValue"
	from=$list.list
}

