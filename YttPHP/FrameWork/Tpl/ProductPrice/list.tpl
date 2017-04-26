{ytt_table 
	show=[
			["value"=>"product_no","title"=>$lang.product_no,"link"=>['url'=>'Product/view',"link_id"=>['id'=>'id']]],
			["value"=>"product_name","title"=>$lang.product_name,"link"=>['url'=>'Product/view',"link_id"=>['id'=>'id']]],
			["value"=>"class_name","title"=>$lang.class_name],
			["value"=>"dml_wholesale_price","title"=>$lang.wholesale_price,'type'=>'multi_client','input'=>['id'=>'wholesale_price','fn'=>'setProductPrice',"param"=>['this','id']]],
			["value"=>"dml_sale_price","title"=>$lang.sale_price,'input'=>['id'=>'sale_price','fn'=>'setProductPrice',"param"=>['this','id']]],
			["value"=>"dml_retail_price","title"=>$lang.retail_price,'type'=>'multi_client','input'=>['id'=>'retail_price','fn'=>'setProductPrice',"param"=>['this','id']]]
		]
	sort=["product_no"=>["sort_by"=>0,"sort_action"=>"index"]]
	from=$list.list
}
<script>
var success_msg = '<span class="word_green">{$lang.success}</span>';
var error_msg = '<span class="word_red">{$lang.oper_error}</span>';
{literal}
function setProductPrice(obj,id){
	var price_value	= $(obj).val();
	var price_type	= $(obj).attr("id");
	//window.console.log(price_value,price_type);
	var msg_td = $(obj).parent().next();
	$.ajax({
		type: "POST",
		url: APP + "/Ajax/setProductPrice",
		dataType: "json",
		data:"type="+price_type+"&id="+id+"&price="+price_value,
		cache: false,
		success: function(result){
			if(result == 1){
				msg_td.html(success_msg);
			}else{
				msg_td.html(error_msg);
			}
		}
	});
}
</script>
{/literal}