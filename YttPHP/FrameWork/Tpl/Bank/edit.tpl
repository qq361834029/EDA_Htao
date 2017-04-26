<form method="POST" action="{'Bank/update'|U}" onsubmit="return false">
<input type="hidden" name="id" value="{$rs.id}">
{wz action="save,list,reset"}
<div class="add_box">
<table cellspacing="0" cellpadding="0" class="add_table">
    <tbody>
     <tr>
      <td class="width10">{$lang.pay_bank}：</td>
      <td class="t_left"><input type="text" name="account_name" class="spc_input" value="{$rs.account_name}">__*__
      </td>
    </tr>
    <tr>
      <td>{$lang.bank_name}：</td>
      <td class="t_left">
      <input type="text" name="bank_name" class="spc_input" value="{$rs.bank_name}">__*__
      </td>
    </tr>
    <tr>
      <td>{$lang.currency_name}：</td>
      <td class="t_left"><input type="hidden" name="currency_id" value="{$rs.currency_id}">{$rs.currency_no}
      </td>
    </tr>
    <tr>
      <td>{$lang.account}：</td>
      <td class="t_left"><input type="text" name="account" value="{$rs.account}" class="spc_input" >__*__
      </td>
    </tr>
     <tr>
      <td>{$lang.address}：</td>
      <td class="t_left"><input type="text" name="address" value="{$rs.address}" class="spc_input" >
      </td>
    </tr>
    <tr>
      <td>{$lang.account_holder}：</td>
      <td class="t_left"><input type="text" name="contact" value="{$rs.contact}" class="spc_input" >__*__
      </td>
    </tr>
     <tr>
      <td>{$lang.swift}：</td>
      <td class="t_left"><input type="text" name="swift_code" value="{$rs.swift_code}" class="spc_input" >
      </td>
    </tr>
    <tr>
      <td>{$lang.phone}：</td>
      <td class="t_left"><input type="text" name="phone" value="{$rs.phone}" class="spc_input" >
      </td>
    </tr>
    <tr>
      <td valign="top">{$lang.comment}：</td>
      <td class="t_left"><textarea name="comments">{$rs.edit_comments}</textarea>
      </td>
    </tr>
    </tbody>
  </table> 
</div>
</form>
