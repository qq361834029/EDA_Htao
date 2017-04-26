<form method="POST" action="{'Recharge/insert'|U}" onsubmit="return false">
{wz action="save,list,reset"}
<div class="add_box">
<table cellspacing="0" cellpadding="0" class="add_table">
    <tbody>
	{if $login_user.role_type != C('SELLER_ROLE_TYPE')}
    <tr>
      <td>{$lang.belongs_seller}：</td>
      <td class="t_left">
      <input type="hidden" name="factory_id" id="factory_id" value="{$fac_id}">
	  <input id="factory_name" value="{$fac_name}" url="{'/AutoComplete/factory'|U}" jqac>__*__
      </td>
    </tr>    
	{else}
		<input type="hidden" name="factory_id" id="factory_id" value="{$fac_id}">
	{/if}
    {if $login_user.role_type != C('WAREHOUSE_ROLE_TYPE')}
        <tr>
            <td>{$lang.warehouse_name}：</td>
            <td class="t_left">
                <input value="" type="hidden" name="warehouse_id">
                <input value="" name="warehouse_name_use" type='text' url="{'/AutoComplete/warehouseNameUse'|U}" jqac>__*__
            </td>
        </tr>
        {else}
            <input value="{$warehouse_id}" type="hidden" name="warehouse_id">
    {/if}
     <tr>
      <td class="width10">{$lang.recharge_date}：</td>
      <td class="t_left">
		<input type="text" name="recharge_date" value="" class="Wdate spc_input" onClick="WdatePicker({if 'digital_format'|C==eur}{literal}{dateFmt:'dd/MM/yy'}{/literal}{else}{literal}{dateFmt:'yyyy-MM-dd'}{/literal}{/if})" />__*__
      </td>
    </tr>
    <tr>
      <td>{$lang.currency_name}：</td>
      <td class="t_left">
		  {currency data=C('COMPANY_CURRENCY') name="currency_id" onchange="getBankByCurrency(this)"}__*__
      </td>
    </tr>
    <tr>
      <td>{$lang.bank_name}：</td>
      <td class="t_left">
		<input type="hidden" name="bank_id" class="spc_input" >
		<input type="text" name="account_name" url="{'/AutoComplete/bank'|U}" jqac>__*__
      </td>
    </tr>	
    <tr>
      <td>{$lang.recharge_money}：</td>
      <td class="t_left"><input type="text" name="money" class="spc_input" >__*__
      </td>
    </tr>
	<tr>
		<td>{$lang.payment_document}：</td>
		<td class="t_left">
			{upload tocken=$file_tocken sid=$sid type=34 limit_number=1 allowTypes="pdf,bmp,jpg,jpeg,png,gif"}
		</td>
	</tr>
    <tr>
      <td valign="top">{$lang.comment}：</td>
      <td class="t_left"><textarea name="comments"></textarea></td>
    </tr>
    </tbody>
  </table> 
</div>
</form>
