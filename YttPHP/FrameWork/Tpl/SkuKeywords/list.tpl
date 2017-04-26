{ytt_table 
	show=[
			["value"=>"id","title"=>$lang.id,"link"=>['url'=>'SkuKeywords/view',"link_id"=>['id'=>'id']]],
			["value"=>"product_no","title"=>$lang.product_no,"link"=>['url'=>'SkuKeywords/view',"link_id"=>['id'=>'id']]]
		]
	sort=["id"=>["sort_by"=>0, "sort_action"=>"index"],"product_no"=>["sort_by"=>0,"sort_action"=>"index"]]
	from=$list.list
}