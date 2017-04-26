<form action="{'ClientFunds/add'|U}" method="POST" onsubmit="return false">
{wz action="save,reset"}
<div class="add_box">
  <table cellspacing="0" cellpadding="0" class="add_table">
    <tbody> 
    <tr>
      <td class="width10">{$lang.factory_name}：</td>
      <td class="t_left">
      	<input type="hidden" name="step" id="step" value="1" >
      	<input type="hidden" name="comp_type" id="comp_type" value="{$comp_type}" >
      	<input type="hidden" name="comp_id" id="comp_id" >
      	<input type="text" name="client_name" id='client_name' url="{'AutoComplete/Factory'|U}" jqac>__*__
      </td>
    </tr> 
    {if $login_user.role_type != C('WAREHOUSE_ROLE_TYPE')}
        <tr>
            <td>{$lang.warehouse_name}：</td>
            <td class="t_left">
                <input value="" type="hidden" name="warehouse_id">
                <input value="" name="warehouse_name_use" type='text' url="{'/AutoComplete/warehouseNameUse'|U}" jqac>__*__
            </td>
        </tr>
        {else}
            <input value="{$login_user.company_id}" type="hidden" name="warehouse_id">
    {/if}
    {company  type="tr" title=$lang.basic_name
	hidden=['name'=>'basic_id','id'=>'basic_id']
	name='basic_name' require=""
	}
    {currency data=C('CLIENT_CURRENCY') name="currency_id" id="currency_id" value=$rs.currency_id type='tr' title=$lang.currency_name require="1" }  
    </tbody>
  </table> 
</div>
</form>
<div id="print"></div>
