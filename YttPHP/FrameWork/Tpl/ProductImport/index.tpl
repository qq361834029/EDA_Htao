<script type="text/javascript">	
$dom.find('#search_button_bg').remove();
</script>
{wz}
<form method="POST" action="{"ProductImport/{$smarty.const.ACTION_NAME}"|U}" id="search_form">
__SEARCH_START__
{assign var="import_key" value="ProductImport"}
<input type="hidden" id="flow" value="productImport">
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
				<li>{$lang.import_staff}：
					{$login_user.real_name}
				</li>
				<br/>
				<li>{$lang.select_file}：
					{upload tocken=$file_tocken sid=$sid type=17 allowTypes="xls,xlsx"}
				</li>
				<br/>
				<li>
					{$lang.sale_order_import}：
					<input type="radio" class="none" checked="check" value="1" name="{$import_key}_type" />
					<input type="button" sheet="0" id="{$import_key}_submit" onclick="submitImport('{$import_key}',this)" class="other" disabled="disabled" value="{$lang.import}" />
					<input type="hidden" id="file_name">
				</li>
			</ul>
			</div>
		</td>
	</tr>
</tbody>
</table>
__SEARCH_END__
</form>

<div id="print" class="width98">
</div>  