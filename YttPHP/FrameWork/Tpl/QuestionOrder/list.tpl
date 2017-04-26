{if $login_user.role_type eq C('SELLER_ROLE_TYPE')}
	{assign var='tr_attr' value=['class'=>["is_self"=>[0=>"bg_return_sale_non-sellers"]]]}
{/if}
{ytt_table tr_attr=$tr_attr
	show=[
		["value"=>"question_sale_order","title"=>$lang.question_sale_order,"type"=>"question_sale_order","width"=>"10%"],
		["value"=>"client_name","title"=>$lang.clientname],
		["value"=>"add_order_date","title"=>$lang.add_order_date,"width"=>"7%"],
		["value"=>"fmd_finish_date","title"=>$lang.finish_date], 
		["value"=>"dd_question_order_state","title"=>$lang.state,"width"=>"4%",'span'=>['onclick'=>"$.autoShow(this,'QuestionOrder','state_log')"],
			'hidden'=>[
				['name'=>'object_id','id'=>'object_id','value'=>'id']
				  ]
		],
		["value"=>"dd_process_mode","title"=>$lang.treatment,"width"=>"6%",'span'=>['onclick'=>"$.autoShow(this,'QuestionOrder','mobile')","is_show_field"=>is_show_mobile],
			'hidden'=>[
				['name'=>'mobile','id'=>'mobile','value'=>'mobile']
				  ]
        ],
		["value"=>"dd_question_reason","title"=>$lang.question_reason,"width"=>"10%"],
		["value"=>"product_detail_info","title"=>$lang.return_product_detail_info,'type'=>'return_product_detail_info'],
        ["value"=>"express_name","title"=>$lang.express_way],
		["value"=>"track_no","title"=>$lang.track_no],
        ["value"=>"dml_proof_delivery_fee",'show'=>!in_array($login_user.role_id,explode(',',C('WAREHOUSE_OPERATIONS_OVERSEAS_ROLE_ID'))),"title"=>$lang.proof_delivery_fee],
        ["value"=>"dml_compensation_fee",'show'=>!in_array($login_user.role_id,explode(',',C('WAREHOUSE_OPERATIONS_OVERSEAS_ROLE_ID'))),"title"=>$lang.compensation_fee],
        ["value"=>"add_real_name","title"=>$lang.doc_staff]
    	]
	listType="flow"
	flow="sale"
	from=$list.list
    addTab=true
}