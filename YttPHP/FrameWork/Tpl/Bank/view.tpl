{wz is_update=$admin==true}
<div class="add_box">
<table cellspacing="0" cellpadding="0" class="add_table">
    <tbody>
     <tr>
      <td class="width10">{$lang.pay_bank}：</td>
      <td class="t_left">{$rs.account_name}</td>
    </tr>
    <tr>
      <td>{$lang.bank_name}：</td>
      <td class="t_left">{$rs.bank_name}</td>
    </tr>
    <tr>
      <td>{$lang.currency_name}：</td>
      <td class="t_left">{$rs.currency_no}</td>
    </tr>
    <tr>
      <td>{$lang.account}：</td>
      <td class="t_left">{$rs.account}</td>
    </tr>
     <tr>
      <td>{$lang.address}：</td>
      <td class="t_left">{$rs.address}</td>
    </tr>
    <tr>
      <td>{$lang.account_holder}：</td>
      <td class="t_left">{$rs.contact}</td>
    </tr>
     <tr>
      <td>{$lang.swift}：</td>
      <td class="t_left">{$rs.swift_code}</td>
    </tr>
    <tr>
      <td>{$lang.phone}：</td>
      <td class="t_left">{$rs.phone}</td>
    </tr>
    <tr>
      <td valign="top">{$lang.comment}：</td>
      <td class="t_left">{$rs.comments}
      </td>
    </tr>
    </tbody>
  </table> 
</div>
