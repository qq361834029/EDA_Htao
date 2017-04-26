<link rel="stylesheet" type="text/css" href="__PUBLIC__/Css/layer.css" />
<form action="{'Shipping/update'|U}" method="POST" onsubmit="return false">
<input type="hidden" name="id" value="{$rs.id}">
<input type="hidden" id='flow' value="shipping">
{wz action="save,list,reset"}
<div class="add_box" {if in_array($smarty.const.LANG_SET,C('LONG_LANG_TPL'))} style="overflow:auto;"{/if}>
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
    		<li>{$lang.shipping_no}：
				<input type="text" name="express_no" value="{$rs.express_no}" class="spc_input" id='express_no' />__*__
			</li>				
    		<li>{$lang.shipping_name}：
				<input type="text" name="express_name" value="{$rs.express_name}" class="spc_input" id='express_name' />__*__
			</li>
			<li>
			{$lang.shipping_type}：
			{select data=C('SHIPPING_TYPE') name="shipping_type" value="{$rs.shipping_type}" empty=true combobox=1}__*__
			</li>
            <li>
			{$lang.is_enable}：
			{radio data=C('IS_ENABLE') name="status" initvalue="1" value="{$rs.status}"}
			</li>	
    		<li>{$lang.express_date}：<input type="text" name="express_date" value="{$rs.express_date}" class="spc_input"/> __*__</li>
    		<li>
    		{$lang.express}：
			<input type="hidden" name="company_id" id="company_id" value="{$rs.company_id}">
			<input name="temp[comp_name]" value="{$rs.comp_name}" url="{'/AutoComplete/expressName'|U}" jqac>__*__
			</li>
    		<li>
    		{$lang.warehouse_name}：
			<input type="hidden" name="warehouse_id" id="warehouse_id" value="{$rs.warehouse_id}" onchange="showWCurrency(this,'{$lang.currency}：');">
			<input id="w_name" name="temp[w_name]" url="{'/AutoComplete/warehouseName'|U}" value="{$rs.w_name}" jqac>__*__
			</li>	
            <li>
			{$lang.is_enable_volume}：
			{radio data=C('IS_ENABLE') name="calculation" value="{$rs.calculation}"}
			</li>
            <li>
			{$lang.whether_api_enabled}：
			{radio data=C('IS_ENABLE') name="enable_api" value="{$rs.enable_api}"}
			</li>
            <li>
			{$lang.is_enable_print}：
			{radio data=C('IS_ENABLE') name="enable_print" value="{$rs.enable_print}"}
			</li>
            <li id="show_w_currency">
                {$lang.currency}：{$rs.currency_no}
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
					<td valign="top" class="t_left" width="80%"><textarea id="receive_addr" class="textarea_height80" name="comments">{$rs.edit_comments}</textarea></td>
					</tr>
			 </table>
    		</td></tr>
    	</tbody> 
    </table>
    {staff add_user="`$rs.add_real_name`" create="`$rs.fmd_create_time`" id="`$rs.add_user`"}
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