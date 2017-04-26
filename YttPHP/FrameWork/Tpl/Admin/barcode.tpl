{include file="Admin/header.tpl"}
<link rel="stylesheet" type="text/css" href="__PUBLIC__/Css/style.css" />
<script>
function deleteChechExchange(obj){
	var vo	=	$(obj).attr("checked");   
   	$dom.find("input[name^='is_exchange[']").attr("checked",false); 
	$(obj).attr("checked",vo);
}
</script>
<form id="form1" method="post" action="{'Admin/saveBarcode'|U}" name="System_barcode">
	<table cellspacing="0" cellpadding="0" class="add_table">
		<tbody>
		 	<tr><th colspan="6" class="t_left">条形码配置</th></tr>
			<tr> 
				<td class="width10">条形码长度：</td>
				<td class="t_left width30">
				 	<input type="text" size="1" name="barcode_length" maxlength="2" value="{$list.barcode_length}" class="spc_input">(最大20) 
				</td>    
				<td class="width10">是否空格隔开：</td>
				<td class="t_left">
				      	<input type="radio" name="is_comma" value="1" {if $list.is_comma==1} checked {/if}> 是
				        <input type="radio" name="is_comma" value="2" {if $list.is_comma==2} checked {/if}> 否
				</td> 
			</tr> 		
			<tr> 		
			 <td class="width10">国家代码</td>
			 <td class="t_left">
			 	<input type="text" size="1" name="country_no" value="{$list.country_no}" class="spc_input">
			 </td>
			</tr>  
			<tr><td colspan="6" class="t_left" style="color:Red; line-height:40px; padding-left:5px;">说明：条形码规则必需能确定产品的唯一性，设定保存后，不可任意修改。若需修改，请及时联系客服人员处理。</td></tr> 
			<tr><td colspan="6" class="t_left">
				{detail_table flow='order' from=$list.detail barcode=false op_show=['barcode'] tfoot=false
				thead=["属性","长度","长度是否可变"]}
				<tr index="{$index}" class="{$none}">	          
				<td class="t_center"> 
					<input type="hidden" name="detail[{$index}][right_id]" id="rights_id" value="{$item.key}" />  
					<input type="text"  class="w120" jqac name="rights_name" id="rights_name" value="{$info[$item.key]}" url="{'/AutoComplete/addBarcode'|U}">
				</td> 
				<td id="right_no" class="t_center"><input type="text" name="detail[{$index}][len]" value="{$item.value}"/></td> 
				<td id="right_no" class="t_center">
					<input type="checkbox" name="detail[{$index}][is_exchange]" {if $item.is_exchange==1}checked {/if} value="1" onclick="deleteChechExchange(this);" />{$lang.yes}
				</td> 
				{detail_operation }
				</tr>    
				{/detail_table} 
			</td></tr> 
			 <tr>
				<td colspan="2">
				<input type="hidden" name="type_key" value="1">
				<input type="hidden" name="type" value="barcode_rules">
				<div class="impBtn fLeft"><input type="submit" value="保存" class="save imgButton"></div>
				<div class="impBtn fRig"><input type="reset" class="reset imgButton" value="清空" ></div>
				</td>
			</tr>
		</tbody>
	</table>  
</form>
{include file="Admin/footer.tpl"}