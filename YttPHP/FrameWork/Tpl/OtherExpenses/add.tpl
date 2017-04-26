<form action="{'OtherExpenses/insert'|U}" method="POST" onsubmit="return false">
{wz action="save,list,reset"}
<div class="add_box">
<input type="hidden" name="comp_type" id="comp_type" value="{$comp_type}" class="spc_input" > 
<input type="hidden" name="paid_type" id="paid_type" value="1" class="spc_input" > 
 <table cellspacing="0" cellpadding="0" class="add_table">
<tr><th colspan="2">{$lang.client_info}</th></tr>
<tbody> 
	{company  type="tr" title=$lang.basic_name
	hidden=['name'=>'basic_id','id'=>'basic_id']
	name='basic_name' onchange='getProductNo()' require=""
	} 
    <tr>
      <td>{$lang.outlay_class}：</td>
      <td class="t_left">
      <input type="hidden" name="pay_class_id" id="pay_class_id" value="{$smarty.post.query.pay_class_id}" >
            	<input type="text" name="oulay_name" id='oulay_name' url="{'AutoComplete/OutLay'|U}" jqac>__*__
            	{quicklyAdd module="PayClass" lang="add_outlay" type=2}
            	
      </td>
    </tr>
     <tr>
      <td>{$lang.is_cost}：</td>
      <td class="t_left">
      <input type="radio" name="is_cost" id="is_cost" value="1" checked>{$lang.yes}
	      	<input type="radio" name="is_cost" id="is_cost" value="2" >{$lang.no}__*__
      </td>
    </tr>
    <tr><th colspan="2">{$lang.outlay_info}</th></tr>
    <tr>
		    <td colspan="2" class="t_left">
		    <div class="other_income">{include file="Accounts/other_funds.tpl"}</div></td>
		</tr>
    </tbody>
  </table>
</div>
</form>   






