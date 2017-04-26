<form method="POST" action="{'Bank/insert'|U}" onsubmit="return false">
{wz action="save,list,reset"}
<div class="add_box">
<table cellspacing="0" cellpadding="0" class="add_table">
    <tbody>
     <tr>
      <td class="width10">{$lang.pay_bank}：</td>
      <td class="t_left"><input type="text" name="account_name" class="spc_input" >__*__
      </td>
    </tr>
    <tr>
      <td>{$lang.bank_name}：</td>
      <td class="t_left">
      <input type="text" name="bank_name" class="spc_input" >__*__
      </td>
    </tr>
    <tr>
      <td>{$lang.currency_name}：</td>
      <td class="t_left">{currency data=C('COMPANY_CURRENCY') name="currency_id"}__*__({$lang.currency_note})
      </td>
    </tr>
    <tr>
      <td>{$lang.account}：</td>
      <td class="t_left"><input type="text" name="account" class="spc_input" >__*__
      </td>
    </tr>
     <tr>
      <td>{$lang.address}：</td>
      <td class="t_left"><input type="text" name="address" class="spc_input" >
      </td>
    </tr>
    <tr>
      <td>{$lang.account_holder}：</td>
      <td class="t_left"><input type="text" name="contact" class="spc_input" >__*__
      </td>
    </tr>
     <tr>
      <td>{$lang.swift}：</td>
      <td class="t_left"><input type="text" name="swift_code" class="spc_input" maxlength="100" >
      </td>
    </tr>
    <tr>
      <td>{$lang.phone}：</td>
      <td class="t_left"><input type="text" name="phone" class="spc_input" >
      </td>
    </tr>
    <tr>
      <td valign="top">{$lang.comment}：</td>
      <td class="t_left"><textarea name="comments"></textarea>
      </td>
    </tr>
    </tbody>
  </table> 
</div>
</form>
