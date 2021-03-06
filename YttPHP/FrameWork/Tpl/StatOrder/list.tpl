{ytt_table operate=false
	show=[
			["value"=>"order_no","title"=>$lang.order_no,"width"=>"150px"],
			["value"=>"factory_name","title"=>$lang.factory,"width"=>"200px"],
			["value"=>"order_date","title"=>$lang.order_date,"width"=>"120px",'td'=>['class'=>'t_center']],
			["value"=>"product_no","title"=>$lang.product_no,"width"=>"120px"],
			["value"=>"product_name","title"=>$lang.product_name,"width"=>"120px"],
			["value"=>"color_name","title"=>$lang.color,"type"=>"flow_color","width"=>"60px"],
			["value"=>"size_name","title"=>$lang.size,"type"=>"flow_size","width"=>"60px"],
			["value"=>"dml_quantity","title"=>$lang.order_total_qn,"width"=>"120px"],
			["value"=>"dml_load_quantity","title"=>$lang.load_total_qn,"width"=>"120px"],
			["value"=>"dml_sum_instock_quantity","title"=>$lang.in_total_qn,"width"=>"120px"],
			["value"=>"fmd_expect_date","title"=>$lang.expect_date,"width"=>"100px"],
			["value"=>"fmd_load_date","title"=>$lang.load_date,"width"=>"100px"],
			["value"=>"fmd_delivery_date","title"=>$lang.delivery_date,"width"=>"100px"],
			["value"=>"fmd_expect_arrive_date","title"=>$lang.expect_arrive_date,"width"=>"100px"],
			["value"=>"fmd_real_arrive_date","title"=>$lang.real_arrive_date,"width"=>"100px"],
			["value"=>"diff_load_days","title"=>$lang.load_diff_day,"width"=>"100px",'td'=>['class'=>'t_right']],
			["value"=>"dml_diff_load_quantity","title"=>$lang.load_diff_qn,"width"=>"100px"],
			["value"=>"load_percent","title"=>$lang.load_delivery_rate,"width"=>"100px",'td'=>['class'=>'t_right']],
			["value"=>"diff_instock_days","title"=>$lang.in_diff_day,"width"=>"100px",'td'=>['class'=>'t_right']],
			["value"=>"dml_diff_instock_quantity","title"=>$lang.in_diff_qn,"width"=>"100px"],
			["value"=>"instock_percent","title"=>$lang.in_delivery_rate,'td'=>['class'=>'t_right']]
		]
	listType='flow'
	flow="order"
	from=$list.list
	table_attr='id="index" class="list" border=0 style="width:2000px!important;"'
}
