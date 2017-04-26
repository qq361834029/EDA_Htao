{include file="Admin/header.tpl"}
<div class="title"> 公共配置，修改后系统可正确运行，无须处理任何数据记录。</div>
<form method="POST" action="{'Admin/save'|U}">
<table cellpadding=3 cellspacing=3 >
<tr>
	<td class="tRight" >启用URL加密：</td>
	<td class="tLeft" ><input type="radio" name="url_encode" value="1" {if url_encode|C==1}checked{/if}>是<input type="radio" name="url_encode" value="2" {if url_encode|C==2}checked{/if}>否</td>
</tr>
<tr>
	<td class="tRight" >多个公司：</td>
	<td class="tLeft" ><input type="radio" name="show_many_basic" value="1" {if show_many_basic|C==1}checked{/if}>是<input type="radio" name="show_many_basic" value="2" {if show_many_basic|C==2}checked{/if}>否</td>
</tr>
<tr>
       <td class="tRight">客户交易币种：</td>
		<td class="tLeft">
		 <input type="checkbox" name="client_currency[]" id="" value="1" {if 1|in_array:$client_currency}checked{/if}>&nbsp;RMB&nbsp;&nbsp;<input type="checkbox" name="client_currency[]" id="" value="2"  {if 2|in_array:$client_currency}checked{/if}>&nbsp;EURO&nbsp;&nbsp;<input type="checkbox" name="client_currency[]" id="" value="3"  {if 3|in_array:$client_currency}checked{/if}>&nbsp;USD&nbsp;&nbsp;<input type="checkbox" name="client_currency[]" id="" value="4"  {if 4|in_array:$client_currency}checked{/if}>&nbsp;GBP&nbsp;&nbsp;<input type="checkbox" name="client_currency[]" id="" value="5"  {if 5|in_array:$client_currency}checked{/if} >&nbsp;HKD&nbsp;&nbsp;<input type="checkbox" name="client_currency[]" id="" value="6"  {if 6|in_array:$client_currency}checked{/if}>&nbsp;AED&nbsp;&nbsp;
		</td>
	</tr>
    <tr>
       <td class="tRight">厂家交易币种：</td>
		<td colspan="5" class="t_left">
		<input type="checkbox" name="factory_currency[]" id="" value="1" {if 1|in_array:$factory_currency}checked{/if}>&nbsp;RMB&nbsp;&nbsp;<input type="checkbox" name="factory_currency[]" id="" value="2"  {if 2|in_array:$factory_currency}checked{/if}>&nbsp;EURO&nbsp;&nbsp;<input type="checkbox" name="factory_currency[]" id="" value="3"  {if 3|in_array:$factory_currency}checked{/if}>&nbsp;USD&nbsp;&nbsp;<input type="checkbox" name="factory_currency[]" id="" value="4"  {if 4|in_array:$factory_currency}checked{/if}>&nbsp;GBP&nbsp;&nbsp;<input type="checkbox" name="factory_currency[]" id="" value="5"  {if 5|in_array:$factory_currency}checked{/if} >&nbsp;HKD&nbsp;&nbsp;<input type="checkbox" name="factory_currency[]" id="" value="6"  {if 6|in_array:$factory_currency}checked{/if}>&nbsp;AED
		</td>
	</tr>
	<tr>
       <td class="tRight">物流公司交易币种：</td>
		<td colspan="5" class="t_left">
		<input type="checkbox" name="logistics_currency[]" id="" value="1" {if 1|in_array:$logistics_currency}checked{/if}>&nbsp;RMB&nbsp;&nbsp;<input type="checkbox" name="logistics_currency[]" id="" value="2"  {if 2|in_array:$logistics_currency}checked{/if}>&nbsp;EURO&nbsp;&nbsp;<input type="checkbox" name="logistics_currency[]" id="" value="3"  {if 3|in_array:$logistics_currency}checked{/if}>&nbsp;USD&nbsp;&nbsp;<input type="checkbox" name="logistics_currency[]" id="" value="4"  {if 4|in_array:$logistics_currency}checked{/if}>&nbsp;GBP&nbsp;&nbsp;<input type="checkbox" name="logistics_currency[]" id="" value="5"  {if 5|in_array:$logistics_currency}checked{/if} >&nbsp;HKD&nbsp;&nbsp;<input type="checkbox" name="logistics_currency[]" id="" value="6"  {if 6|in_array:$logistics_currency}checked{/if}>&nbsp;AED
		</td>
	</tr>
	<tr>
       <td class="tRight">本公司交易币种：</td>
		<td colspan="5" class="t_left">
		<input type="checkbox" name="company_currency[]" id="" value="1" {if 1|in_array:$company_currency}checked{/if}>&nbsp;RMB&nbsp;&nbsp;<input type="checkbox" name="company_currency[]" id="" value="2"  {if 2|in_array:$company_currency}checked{/if}>&nbsp;EURO&nbsp;&nbsp;<input type="checkbox" name="company_currency[]" id="" value="3"  {if 3|in_array:$company_currency}checked{/if}>&nbsp;USD&nbsp;&nbsp;<input type="checkbox" name="company_currency[]" id="" value="4"  {if 4|in_array:$company_currency}checked{/if}>&nbsp;GBP&nbsp;&nbsp;<input type="checkbox" name="company_currency[]" id="" value="5"  {if 5|in_array:$company_currency}checked{/if} >&nbsp;HKD&nbsp;&nbsp;<input type="checkbox" name="company_currency[]" id="" value="6"  {if 6|in_array:$company_currency}checked{/if}>&nbsp;AED
		</td>
	</tr>
 <tr>
	<td colspan="2">
	<input type="hidden" name="type" value="common">
	<div class="impBtn fLeft"><input type="submit" value="保存" class="save imgButton"></div>
	<div class="impBtn fRig"><input type="reset" class="reset imgButton" value="清空" ></div>
	</td>
</tr>
</table>
</form>
{include file="Admin/footer.tpl"}
