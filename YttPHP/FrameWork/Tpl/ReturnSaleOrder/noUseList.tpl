{ytt_table
	show=[
			["value"=>"product_no","title"=>$lang.product_no,'link'=>['url'=>'Product/view','link_id'=>['id'=>'product_id']]],
			["value"=>"product_name","title"=>$lang.product_name,'link'=>['url'=>'Product/view','link_id'=>['id'=>'product_id']]],
			["value"=>"color_name","title"=>$lang.color_name,'type'=>'flow_color'],
			["value"=>"size_name","title"=>$lang.size_name,'type'=>'flow_size'],
			["value"=>"dml_sun_quantity","title"=>$lang.product_qn]
		]
	listType="flow"
	flow="sale"
	from=$list.list
	operate=false
}