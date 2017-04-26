{literal}
<script>
function setOrderDetailstate(obj){
		var url = $(obj).attr("url");   
		if(!url){
			$( "#dialog-error" ).dialog({height: 140,modal: true});
			return false;
		}
		$( "#dialog:ui-dialog" ).dialog( "destroy" );
		$( "#dialog-confirm" ).dialog({
			resizable: false,
			height:140,
			//modal: true,
			buttons: {
			"是": function() {
				$( this ).dialog( "close" );
				$.ajax({
					type: "POST",
					url: url,
					dataType: "json",
					cache: false,
					async: false,
					success: function(result){
						$("#orderFinished").remove();
						success(result);
					}
				});
			},
			"否": function() {
				$( this ).dialog( "close" );
			}
			}
		});
}  
</script>
{/literal}

<form action="{'Orders/update'|U}" method="POST" onsubmit="return false">
<input type="hidden" name="id" value="{$rs.id}">
<div class="add_box">
<table cellspacing="0" cellpadding="0"  class="add_table">
    	<tbody>  
    		<tr>
    			<th>
    			<div class="titleth">
    				<div class="titlefl">{$lang.order_basic} {$rs.order_no}</div>
    			</div></th>
    		</tr> 
    	   <tr><td>
    	    
{detail_table flow='order' from=$rs.detail op_show=['setOrderFinished'] action=['setOrderFinished'] barcode=false
	thead=[$lang.product_no,$lang.product_name,'flow_config',$lang.orders_price,$lang.orders_allprice,'action_load_quantity','action_load_sum_quantity','action_quantity_diff','action_state']}
<tr index="{$index}" class="{$none}">
<input type="hidden" name="detail[{$index}][id]" value="{$item.id}">
	{td id="span_product" class="t_left" view="product_no" width="8%"}
		{$item.product_no} 
	{/td}
	{td id="span_product_name" view="product_name" class="t_left"}
		{$item.product_name}
	{/td}
	{td type="flow_color" view="color_name" width="8%"}
		{$item.color_name}
	{/td}
	{td type="flow_size" view="size_no" width="8%"}
		{$item.size_no}
	{/td}
	{td type="flow_quantity" view="edml_quantity" tfoot_value="{$rs.detail_total.dml_quantity}" width="6%" class="t_right"}
		{$item.edml_quantity}
	{/td}
	{td type="flow_capability" view="edml_capability" width="6%" class="t_right"}
		{$item.edml_capability} 
	{/td}
	{td type="flow_dozen" view="dml_dozen" width="6%" class="t_right"}
		{$item.dml_dozen} 
	{/td}
	{td  type="flow_row_total" view="dml_sum_quantity" tfoot_value="{$rs.detail_total.dml_sum_quantity}" class="t_right"}
		{$item.dml_sum_quantity}
	{/td}
	{td view="edml_price" width="6%" class="t_right"}
		{$item.dml_price} 
	{/td}
	{td tfoot_value="{$rs.detail_total.dml_money}" class="t_right"}
		{$item.dml_money}
	{/td}
	{td width="6%" type="flow_load_quantity" class="t_right"}
		{$item.dml_load_capability|default:0}
	{/td}
	{td width="6%" tfoot_value="{$rs.detail_total.dml_load_quantity}" class="t_right"}
		{$item.dml_load_quantity|default:0}
	{/td}
	{td width="6%"  tfoot_value="{$rs.detail_total.dml_diff_quantity}" class="t_right"}
		{$item.dml_diff_quantity}
	{/td}
	{td width="6%"}
		{$item.dd_detail_state}
	{/td}
	{detail_operation 
		span=[
			['class'=>'icon icon-list-hand','url'=>'/Orders/setFinishDetailState/type/1','link_id'=>['id'=>'id','orders_id'=>'orders_id'],'onclick'=>'setOrderDetailstate(this)','title'=>$lang.manual_finished,'show'=>['detail_state'=>[1,2]]],
			['class'=>'icon icon-list-returnhand','url'=>'/Orders/setFinishDetailState/type/2','link_id'=>['id'=>'id','orders_id'=>'orders_id'],'onclick'=>'setOrderDetailstate(this)','title'=>$lang.un_manual_finished,'show'=>['detail_state'=>[4]]]
		]
	}
</tr>
{/detail_table}    	  
    	   </td></tr> 
			 </table>
    		</td></tr>
    	</tbody> 
    </table> 
</div>
</form> 

