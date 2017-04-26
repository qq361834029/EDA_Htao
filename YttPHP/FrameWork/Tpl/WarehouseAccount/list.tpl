{ytt_table 
	show=[
			["value"=>"account_date","title"=>$lang.date,"link"=>['url'=>'WarehouseAccount/view',"link_id"=>['id'=>'id']]],
			["value"=>"factory_name","title"=>$lang.belongs_seller, 'show'=>$login_user.role_type != C('SELLER_ROLE_TYPE'),"link"=>['url'=>'Factory/view',"link_id"=>['id'=>'factory_id']]],
            ["value"=>"w_name","title"=>$lang.belongs_warehouse,"td"=>["class"=>"t_center"]],
			["value"=>"dml_free_stock_quantity","title"=>$lang.free_stock_quantity],
			["value"=>"free_stock_cube","title"=>$lang.free_stock_cube,"td"=>["class"=>"t_right"]],
			["value"=>"quarter","title"=>$lang.quarter,"td"=>["class"=>"t_right"]],
			["value"=>"dml_quarter_stock_quantity","title"=>$lang.year_stock_quantity],
			["value"=>"quarter_stock_cube","title"=>$lang.year_stock_cube,"td"=>["class"=>"t_right"]],
			["value"=>"dml_quarter_warehouse_account","title"=>$lang.year_warehouse_account],
			["value"=>"dml_year_stock_quantity","title"=>$lang.over_year_stock_quantity],
			["value"=>"year_stock_cube","title"=>$lang.over_year_stock_cube,"td"=>["class"=>"t_right"]],
			["value"=>"dml_year_warehouse_account","title"=>$lang.over_year_warehouse_account],
			["value"=>"dml_stock_quantity","title"=>$lang.total_stock_quantity],
			["value"=>"stock_cube","title"=>$lang.total_stock_cube,"td"=>["class"=>"t_right"]],
			["value"=>"dml_warehouse_account_fee","title"=>$lang.warehouse_fee]
		]
	operate=false
	listType='flow'
	flow="warehouse_account"
	from=$list.list
}

