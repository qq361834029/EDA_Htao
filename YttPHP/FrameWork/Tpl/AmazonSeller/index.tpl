<script type="text/javascript">	
$dom.find('#ac_search').html('{L('synchrodata')}');
</script>
{wz}
<table cellspacing="0" cellpadding="0" class="add_table">
<tbody>
	<tr><th>{$lang.byorderdate}</th></tr>
</tbody>
</table>
<form method="POST" action="{"AmazonSeller/getOrders"|U}" id="search_form">
__SEARCH_START__
<input type="hidden" id="rand" name="rand" value="{$rand}">
	<dl style="height:180px;">
		<dt>
			<label>{$lang.amazon_account}：</label>
			<input value="" type="hidden" name="site_id">
			<input type="text" name="user_id" class="spc_input ac_input" url="{'AutoComplete/amazonUser'|U}" jqac />	
		</dt>
		<dt style='padding-left:20px'>
			<label>{$lang.sale_date}：</label>
			<input type="text" id='date_from' name="date_from" 
			{literal} 
onClick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})"
{/literal} class="Wdate"  readonly='true' value="">
			&nbsp;&nbsp;{$lang.to_date}&nbsp;&nbsp;
			<input type="text" id='date_to' name="date_to" 
			{literal} 
onClick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})"
{/literal} class="Wdate"  readonly='true' value="">&nbsp;{$lang.sale_order}
		</dt>
        {if !in_array($smarty.const.LANG_SET,C('LONG_LANG_TPL'))}
        <dt>
        </dt> 
        {/if}
        <dt> 
        <label style="padding-left:25px;float: left">{$lang.order_no}：</label>
			<textarea style="height:100px;width:220px" id="ItemID" name="ItemID"></textarea>
			<br>
			{$lang.byorderno_comment}
		</dt>
	</dl>
	<input type="hidden" name="date_key" value="2">
__SEARCH_END__
</form>

<div id="print" class="width98">

</div>