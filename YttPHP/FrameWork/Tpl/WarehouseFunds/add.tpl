<form action="{'WarehouseFunds/add'|U}" method="POST" onsubmit="return false">
{wz action="save,reset"}
<div class="add_box">
  <table cellspacing="0" cellpadding="0" class="add_table">
    <tbody> 
    <tr>    
        
          <input type="hidden" name="step" id="step" value="1" >
          <input type="hidden" name="basic_id" id="basic_id" value="{C(DEFAULT_BASIC_ID)}" class="spc_input" > 
          <input type="hidden" name="comp_type" id="comp_type" value="{$comp_type}" >
        {if $login_user.role_type != C('WAREHOUSE_ROLE_TYPE')}
        <td class="width10">{$lang.warehouse_name}：</td>
        <td class="t_left">
          <input type="hidden" name="comp_id" id="comp_id" >
          <input type="text" name="warehouse_name" id='warehouse_name' url="{'AutoComplete/warehouse'|U}" jqac>__*__
        </td>
        {else}
            <input type="hidden" name="comp_id" id="comp_id" value="{$login_user.company_id}" >
        {/if}
    </tr>  
    {currency data=C('FACTORY_CURRENCY') name="currency_id" id="currency_id" value=$rs.currency_id type='tr' title=$lang.currency_name require="1" }  
    </tbody>
  </table> 
</div>
</form>
<div id="print"></div>