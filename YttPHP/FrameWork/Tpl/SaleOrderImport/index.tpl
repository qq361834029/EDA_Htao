<script type="text/javascript">	
$dom.find('#search_button_bg').remove();
</script>
{wz}
<form method="POST" action="{"SaleOrderImport/{$smarty.const.ACTION_NAME}"|U}" id="search_form">
__SEARCH_START__
{assign var="import_key" value="SaleOrderImport"}
{assign var="ECPP_import_key" value="ECPPSaleOrderImport"}
{assign var="PayPal_import_key" value="PayPalSaleOrderImport"}
<input type="hidden" id="flow" value="saleOrderImport">
{if $login_user.role_type==C('WAREHOUSE_ROLE_TYPE')}
<input type="hidden" id="warehouse_id" name="query[a.warehouse_id]" value="{$warehouse_id}">
{/if}
<table cellspacing="0" cellpadding="0" class="add_table">
<tbody>
	<tr>
		<td>
			<div class="basic_tb">  
			<ul> 
				<li>{$lang.download_import_template}：
					<a href="{$smarty.const.APP_EXCEL_PATH}/{$import_key}.xls">{$lang.download_template}</a>
				</li>
                <li>{$lang.download_ecpp_import_template}：
					<a href="{$smarty.const.APP_EXCEL_PATH}/{$ECPP_import_key}.xlsx">{$lang.download_template}</a>
				</li>
				<li>{$lang.download_paypal_import_template}：
					<a href="{$smarty.const.APP_EXCEL_PATH}/{$PayPal_import_key}.xls">{$lang.download_template}</a>
				</li>
				<li>{$lang.import_staff}：
					{$login_user.real_name}
				</li>
				<br/>
				<li>{$lang.select_file}：
					{upload tocken=$file_tocken sid=$sid type=14 allowTypes="xls,xlsx"}
				</li>
				<br/>
				<li>
					{$lang.sale_order_import}：
					<input type="radio" class="none" checked="check" value="2" name="{$import_key}_type" />
					<input type="button" sheet="0" id="{$import_key}_submit" onclick="submitImport('{$import_key}',this)" class="other" disabled="disabled" value="{$lang.import}" />
					<input type="hidden" id="file_name">
				</li>
                <br/>
				<li>
					ECPP{$lang.sale_order_import}：
					<input type="radio" class="none" checked="check" value="4" name="{$ECPP_import_key}_type" />
					<input type="button" sheet="0" id="{$ECPP_import_key}_submit" onclick="submitImport('{$ECPP_import_key}',this)" class="other" disabled="disabled" value="{$lang.import}" />
				</li>
				<br/>
				<li>
					{$lang.paypal_sale_order_import}：
					<input type="radio" class="none" checked="check" value="4" name="{$PayPal_import_key}_type" />
					<input type="button" sheet="0" id="{$PayPal_import_key}_submit" onclick="submitImport('{$PayPal_import_key}',this)" class="other" disabled="disabled" value="{$lang.import}" />
				</li>
			</ul>
			</div>
		</td>
	</tr>
	<!--tr>
		<td class="width50">{$lang.download_import_template}：</td>
		<td class="t_left">
		<a href="{$smarty.const.APP_EXCEL_PATH}/{$import_key}.xls">{$lang.download_template}</a>
		</td>
	</tr>
    	<tr>
		<td class="width50">{$lang.import_staff}：</td>
		<td class="t_left">
		{$login_user.real_name}
		</td>
	</tr>
	<tr>
		<td>{$lang.select_file}：</td>
		<td class="t_left">
			{upload tocken=$file_tocken sid=$sid type=14 allowTypes="xls,xlsx"}
		</td>
	</tr-->
</tbody>
</table>
__SEARCH_END__
</form>

<div id="print" class="width98">
</div>  