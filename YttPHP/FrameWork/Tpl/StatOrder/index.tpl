<script type="text/javascript">
$(document).ready(function(){
	var $tab_head_height = 32; //每个标签的高度
	var $tab_head_width = 116; //每个标签的宽度
	var $top_distance = 188; //标签栏与页面顶部的距离
	var ch = document.documentElement.clientHeight; //当前浏览器显示区的高度
	var cw = document.documentElement.clientWidth; //当前浏览器显示区的宽度
	var rows = Math.floor($("#tabs").tabs("length")*$tab_head_width / cw) + 1; //标签的行数
	var f_h = document.documentElement.clientHeight-$top_distance-rows*$tab_head_height;	//数据显示区的高度
	
  $(".statorder_height").css('height',f_h);
  $("div").removeClass("ui-tabs-panel"); //去除ui-tabs-panel纵向滚动条
});
</script>

<style type="text/css">
div .ui-tabs-panel { overflow-y:hidden;}
</style>

{wz}
<form method="POST" action="{"StatOrder/{$smarty.const.ACTION_NAME}"|U}" id="search_form">
__SEARCH_START__
		<dl>
		   		<dt>
					<label >{$lang.order_no}：</label>
					<input type="text" name="like[order_no]" url="{'/AutoComplete/orderNo'|U}" jqac>
            	</dt>
				<dt>
					<label>{$lang.factory}：</label>
					<input type='hidden' name="query[factory_id]">
             		<input type='text' url="{'/AutoComplete/factory'|U}" jqac>
            	</dt>    
            	<dt>
					<label>{$lang.product_no}：</label>
					<input type='hidden' name="query[product_id]">
             		<input type='text' url="{'/AutoComplete/product'|U}" jqac>
            	</dt>          			  
            	<dt>
					<label>{$lang.from_date}：</label>
						<input type="text" name="date[from_order_date]" class="Wdate spc_input_data" onClick="WdatePicker()"/>
						<label>{$lang.to_date}</label>
						<input type="text" name="date[to_order_date]" class="Wdate spc_input_data" onClick="WdatePicker()"/>
            	</dt>    
		</dl>	
		<input type="hidden" name="date_key" value="2">
__SEARCH_END__
</form>
{note}
<div id="print" class="width99 statorder_height" style="max-width:2500px;margin-left:12px;overflow-y:scroll;overflow-x:scroll;">
{include file="StatOrder/list.tpl"}
</div> 

