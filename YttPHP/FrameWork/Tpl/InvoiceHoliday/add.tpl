<form action="{"InvoiceHoliday/insert"|U}" method="POST">
{wz action="save,list,reset"}
<div class="add_box">
  <table cellspacing="0" cellpadding="0" class="add_table">
    <tbody>   
    <tr>
      <td class="width10">{$lang.date}：</td>
      <td class="t_left"><input type="text" name="holiday_date" id="holiday_date" class="Wdate" onClick="WdatePicker()">__*__
      </td>
    </tr>  
    <tr>
      <td>{$lang.type}：</td>
      <td class="t_left">
      {radio data=C('invoice_holiday_type') name='holiday_type' initvalue=1}__*__
      </td>
    </tr>       
    </tbody>
  </table> 
</div>
</form>