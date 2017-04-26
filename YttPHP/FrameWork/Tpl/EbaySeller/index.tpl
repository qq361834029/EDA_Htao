<script type="text/javascript">	
$dom.find('#ac_search').html('{L('synchrodata')}');
</script>
{wz}
<form method="POST" action="{"EbaySeller/ajaxOldSale"|U}" id="search_form">
__SEARCH_START__
<input type="hidden" id="rand" name="rand" value="{$rand}">
	<dl>
		<dt>
			<label>{$lang.ebay_account}：</label>
			<input value="" type="hidden" name="site_id">
			<input type="text" name="user_id" class="spc_input ac_input" url="{'AutoComplete/ebaySite'|U}" jqac />	
		</dt>
		<dt style='padding-left:20px'>
			<label>{$lang.lately}：</label>
			<input type="text" name="from_time" value="" class="spc_input" style="width:70px;">&nbsp;&nbsp;&nbsp;
			<select name='time_type' class="spc_input" style="width:70px;">
				<option label="{$lang.minutes}" value="minutes">{$lang.minutes}</option>
				<option label="{$lang.hours}" value="hours" selected="selected">{$lang.hours}</option>
				<option label="{$lang.day}" value="day">{$lang.day}</option>
			</select>&nbsp;{$lang.sale_order}
		</dt>
	</dl>
	<br><br>
	<dl>
		<dt> 
			<label >ItemID：</label>
			<input type="text" name="ItemID" value="" class="spc_input" style="width:70px;">
		</dt>
		<dt> 
			<label >TransactionID：</label>
			<input type="text" name="TransactionID" value="" class="spc_input" style="width:70px;">
		</dt>
	</dl>
	<input type="hidden" name="date_key" value="2">
    __SEARCH_END__
</form>
<div id="print" class="width98">

</div> 