<link rel="stylesheet" type="text/css" href="__PUBLIC__/Css/layer.css" />
<form action="{'Shipping/insert'|U}" method="POST" onsubmit="return false">
{wz action="save,list,reset"}
<div class="add_box" {if in_array($smarty.const.LANG_SET,C('LONG_LANG_TPL'))}style="overflow:auto;"{/if}>
<table cellspacing="0" cellpadding="0"  class="add_table" width="99%">
    	<tbody>  
    		<tr>
    			<th>
    			<div class="titleth">
    				<div class="titlefl">{$lang.basic_info}</div>
    			</div>
				</th>
    		</tr>
    		<tr><td>
    		<div class="basic_tb">  
    		<ul> 
    		<li>
    		{$lang.shipping_no}：
			<input type="text" name="express_no" id='express_no' class="spc_input" />__*__
			</li>
    		<li>
    		{$lang.shipping_name}：
			<input type="text" name="express_name" id='express_name' class="spc_input" />__*__
			</li>	
			<li>
			{$lang.shipping_type}：
			{select data=C('SHIPPING_TYPE') name="shipping_type" empty=true combobox=1}__*__
			</li>
			<li>
			{$lang.is_enable}：
			{radio data=C('IS_ENABLE') name="status" initvalue="1"}
			</li>
    		<li>{$lang.express_date}：<input type="text" name="express_date" value="" class="spc_input"/> __*__</li>
    		<li>
    		{$lang.express}：
			<input type="hidden" name="company_id" id="company_id" >
			<input name="temp[comp_name]" url="{'/AutoComplete/expressName'|U}" jqac>__*__
			</li>
    		<li>
    		{$lang.warehouse_name}：
			<input type="hidden" name="warehouse_id" id="warehouse_id" onchange="showWCurrency(this,'{$lang.currency}：');">
			<input id="w_name" name="temp[w_name]" url="{'/AutoComplete/warehouseName'|U}" jqac>__*__
			</li>
            <li>
			{$lang.is_enable_volume}：
			{radio data=C('IS_ENABLE') name="calculation" initvalue="2"}
			</li>
            <li>
			{$lang.whether_api_enabled}：
			{radio data=C('IS_ENABLE') name="enable_api" initvalue="2"}
			</li>
            <li>
			{$lang.is_enable_print}：
			{radio data=C('IS_ENABLE') name="enable_print" initvalue="1"}
			</li>
            <li id="show_w_currency" style="display: none">
			</li>		
    		</ul>
    		</div>
    		</td></tr> 		
    		<tr>
    			<th >{$lang.detail_info}</th>
    		</tr>
    	   <tr><td>{include file="Shipping/detail.tpl"}</td></tr>
	
    		<tr><td class="pad_top_10">
    			<table width="100%" cellspacing="0" cellpadding="0" border="0">
					<tr>
					<td width="20%" class="t_right" valign="top">{$lang.comments}：</td>
					<td valign="top" class="t_left" width="80%">
					<textarea id="receive_addr" class="textarea_height80" name="comments"></textarea></td>
					</tr>
			 </table>
    		</td></tr>
    	</tbody> 
    </table>
    {staff}
</div>
</form> 

<script type="text/javascript">
function selectCountry(obj){
	var data = {$country};
	$(obj).mulitselector({
		title:lang['basic']['select_country'],
		data:data,
		autosearch: '<input type="hidden" name="auto_country_id" id="auto_country_id">'+
			    '<input type="text" id="auto_country" name="auto_country" class="w150" url="{'AutoComplete/country'|U}" jqac>',
		splitchar:";",
		callback: ""
	});
}
</script>