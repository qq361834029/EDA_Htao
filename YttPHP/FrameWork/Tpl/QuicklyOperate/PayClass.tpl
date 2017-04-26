<form method="POST" action="{'PayClass/insert'|U}" onsubmit="return false">
<div class="table_autoshow" style="border-style:none!important;">
<table cellspacing="0" cellpadding="0" width="100%">
		<tbody>
		<tr>
			<td class="width20">{$lang.pay_type}：</td>
			<td class="t_left">
			{if $type==1}
			<input type="hidden" name="pay_type" value="2"/>{$lang.income} 
			{else}
			<input type="hidden" name="pay_type" value="1"/>{$lang.outlay}
			{/if}</td>
		</tr>  
		<tr>
			<td>{if $type==1}{$lang.add_income}{else}{$lang.add_outlay}{/if}：</td>
			<td class="t_left">
				<input type="text" name="pay_class_name" id="pay_class_name" class="spc_input" >__*__
			</td>
		</tr>     				
		</tbody>
		</table>
</div>		
</form>
