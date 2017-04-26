{ytt_table 
	show=[
			["value"=>"waybill_no","title"=>$lang.waybill_no,"link"=>['url'=>'DomesticWaybill/view',"link_id"=>"id"]],
            ["value"=>"warehouse_no","title"=>$lang.warehouse_no],
			["value"=>"product_counts","title"=>$lang.product_count],
			["value"=>"dml_total_quantity","title"=>$lang.product_sum_quantity],
            ["value"=>"add_real_name","title"=>$lang.operate_person]
		]
	listType='flow'
	flow="domestic_waybill"
	from=$list.list
}

