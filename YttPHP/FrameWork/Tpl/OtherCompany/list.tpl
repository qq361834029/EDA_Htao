{ytt_table
	show=[
		["value"=>"comp_no","title"=>L('factory_no'),"link"=>['url'=>'OtherCompany/view',"link_id"=>['id'=>'id']],"width"=>"13%"],
		["value"=>"comp_name","title"=>L('factory_name'),"link"=>['url'=>'OtherCompany/view',"link_id"=>['id'=>'id']],"width"=>"13%"],
		["value"=>"contact","title"=>L('contact'),"width"=>"10%"],
		["value"=>"mobile","title"=>L('mobile'),"width"=>"10%"],
		["value"=>"email","title"=>L('email'),"width"=>"20%"],
		["value"=>"country_name","title"=>L('factory_country'),"width"=>"10%"],
		["value"=>"city_name","title"=>L('factory_city'),"width"=>"10%"]
	]
	sort=["comp_no"=>["sort_by"=>0,"sort_action"=>"index"],"comp_name"=>["sort_by"=>0,"sort_action"=>"index"]]
	from=$list.list
}