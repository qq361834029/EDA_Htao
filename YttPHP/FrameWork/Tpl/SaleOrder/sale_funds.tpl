<input type="hidden" id="pay_paid_type" name="pay_paid_type" 	value="1" >
<input type="hidden" id="pay_include" 	name="pay_include" 		value="pay_sale"> 
<div class="panes_sale">
	<div id="cash"> 
	<table width="100%"  border="0" cellspacing="0" cellpadding="0" class="pay_table">
    <tr>
	<td class="b_bottom b_left t_right b_top">
<ul class="tabs_sale">
	<li>
	<select name="user_type" class="" id="user_type" onchange="addPaidType($(this).val())" style="width:60px;"><option value="1" selected>{$lang.cash}</option><option value="2" >{$lang.pay_bill}</option><option value="3" >{$lang.pay_transfer}</option></select></li>
</ul>
</td>	
	<td class="b_bottom b_top t_right" width="121"><input type="text" id="pay_cash_money" name="pay_cash_money" onkeyup="$.dealWithPM('pay_cash_money');"></td>	
	<td class="b_bottom b_right b_top" width="57"><span class="icon icon-add-plus"onclick="addFund(this,'cash');"></span></td></tr>
   </table>
	</div>
	
	<div id="bill" style="display:none;"> 
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="pay_table">
    <tr>
    <td  class="b_bottom b_top">{$lang.bill_date}：</td>	
	<td  class="b_bottom b_top" width="104"><input type="text" id="pay_bill_bill_date" name="pay_bill_bill_date" class="Wdate date_input" onClick="WdatePicker()" style="width:90px;"/></td>
    <td  class="b_bottom b_left b_top">{$lang.bill_no}：</td>	
	<td  class="b_bottom b_top"><input type="text" id="pay_bill_bill_no" name="pay_bill_bill_no" class="date_input"></td>	
	<td  class="b_bottom t_right b_top"><ul class="tabs_sale">
	<li><select name="user_type" class="" id="user_type" onchange="addPaidType($(this).val())" style="width:60px;"><option value="1">{$lang.cash}</option><option value="2" selected>{$lang.pay_bill}</option><option value="3" >{$lang.pay_transfer}</option></select></li>
</ul></td>	
	<td class="b_bottom b_top t_right"  width="121"><input type="text" id="pay_bill_money" name="pay_bill_money"  onkeyup="$.dealWithPM('pay_bill_money');"></td>
	<td  class="b_bottom b_right b_top" width="57"><span class="icon icon-add-plus"onclick="addFund(this,'bill');"></span></td></tr>
</table>
	</div>
	 
	<div id="transfer" style="display:none;"> 
	<table width="100%" border="0" cellspacing="0" cellpadding="0"  class="pay_table">
    <tr><td class="b_bottom b_left b_top t_right">{$lang.pay_bank}：</td>	 
	<td class="b_bottom b_top" id="show_transfer_bank_info" width="140"><input type="hidden" id="pay_transfer_bank_id" name="pay_transfer_bank_id" onchange="getBankName(this);" class="w120"><input type="text" name="pay_transfer_bank_name" value="{$item.color_name}" url="{'AutoComplete/accountName'|U}" jqac class="w120"><input type="hidden" id="span_bank_name" class="w120"></td>
	 <td class="b_bottom t_right b_top" valign="middle" width="100">
	 <ul class="tabs_sale"><li><select name="user_type" class="" id="user_type" onchange="addPaidType($(this).val())" style="width:60px;"><option value="1">{$lang.cash}</option><option value="2" >{$lang.pay_bill}</option><option value="3" selected>{$lang.pay_transfer}</option></li>
</ul></td>	
	 <td class="b_bottom b_top t_right" width="121"><input type="text" id="pay_transfer_money" name="pay_transfer_money" onkeyup="$.dealWithPM('pay_transfer_money');"></td> 
	 
	 <td class="b_bottom b_right b_top"  width="57"><span class="icon icon-add-plus"onclick="addFund(this,'transfer');"></span></td></tr>
</table>
	</div>
	
</div>


