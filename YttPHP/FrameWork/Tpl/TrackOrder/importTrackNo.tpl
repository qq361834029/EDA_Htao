<script type="text/javascript">	
$dom.find('#search_button_bg').remove();
</script>
{wz}
<form method="POST" action="{"TrackOrder/{$smarty.const.ACTION_NAME}"|U}" id="search_form">
<input type="hidden" id="flow" value="importTrackNo">
__SEARCH_START__
{if $login_user.role_type==C('WAREHOUSE_ROLE_TYPE')}
<input type="hidden" id="warehouse_id" name="query[a.warehouse_id]" value="{$warehouse_id}">
{/if}
<input type="hidden" id="file_name">
<input type="hidden" name="flow_type" value="">
<table cellspacing="0" cellpadding="0" class="add_table">
<tbody>
    	<tr>
		<td class="width50">{$lang.import_staff}：</td>
		<td class="t_left">
		{$login_user.real_name}
		</td>
	</tr>
	<tr>
		<td>{$lang.select_file}：</td>
		<td class="t_left">
			{upload tocken=$file_tocken sid=$sid type=11 allowTypes="csv,txt"}
		</td>
	</tr>
</tbody>
</table>
__SEARCH_END__
</form>

<div id="print" class="width98">
</div>  