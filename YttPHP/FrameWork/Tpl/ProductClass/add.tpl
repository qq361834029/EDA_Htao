<input type="hidden" id="form_name" value="">
{wz}
<form action="{'ProductClass/insert'|U}" id="ProductClass1" method="POST" validity="productClassDistrict" onsubmit="setFormName('ProductClass1');return false">
<div class="add_box">
 <table cellspacing="0" cellpadding="0" class="add_table">
    <tbody>
     <tr><th colspan="2" class="t_left">{$lang.title_1}</th></tr>
     <tr>
      <td class="width10">{$lang.class_no}：</td>
      <td class="t_left">
      <input type="text" name="class_no" id="class_no"  value="{$max_no}" {$is_auto_no}  >__*__
      </td>
    </tr>
    <tr>
      <td>{$lang.class_name_1}：</td>
      <td class="t_left">
      <input type="text" name="class_name" id="class_name" class="spc_input" >__*__
      <input type="hidden" name="class_level" value="1">
      <input type="submit" class="button_new"  value="{$lang.submit}">
      <span id="success" class="success"></span>
      </td>
    </tr>
</tbody>
</table> 
</div>
</form>  
{if C('PRODUCT_CLASS_LEVEL')>=2}
<form action="{'ProductClass/insert'|U}" method="POST" id="ProductClass2"  validity="productClassDistrict" name="Basic_addProductClass" onsubmit="setFormName('ProductClass2');return false">
<div class="add_box">
 <table cellspacing="0" cellpadding="0" class="add_table">
    <tbody>
     <tr><th colspan="2" class="t_left">{$lang.title_2}</th></tr>
     <tr>
      <td class="width10">{$lang.class_name_1}：</td>
      <td class="t_left">
      <input type="hidden" name="parent_id" value=""><input id="parent_name" value="" url="{'/AutoComplete/productClass1'|U}" where="{"to_hide=1"|urlencode}" jqac>__*__
      </td>
    </tr>
     <tr>
      <td class="width10">{$lang.class_no}：</td>
      <td class="t_left">
      <input type="text" name="class_no" id="class_no"  value="{$max_no}" {$is_auto_no} >__*__
      </td>
    </tr>
    <tr>
      <td>{$lang.class_name_2}：</td>
      <td class="t_left">
      <input type="text" name="class_name" id="class_name" class="spc_input" >__*__
      <input type="hidden" name="class_level" value="2">
      <input type="submit" class="button_new"  value="{$lang.submit}">
      <span id="success" class="success"></span>
      </td>
    </tr>
</tbody>
</table> 
</div>
</form> 

{/if}
{if C('PRODUCT_CLASS_LEVEL')>=3}
<form action="{'ProductClass/insert'|U}" method="POST" id="ProductClass3" validity="productClassDistrict" name="Basic_addProductClass" onsubmit="setFormName('ProductClass3');return false">
<div class="add_box">
 <table cellspacing="0" cellpadding="0" class="add_table">
    <tbody>
     <tr><th colspan="2" class="t_left">{$lang.title_3}</th></tr>
     <tr>
      <td class="width10">{$lang.class_name_2}：</td>
      <td class="t_left">
      <input type="hidden" name="parent_id" value=""><input id="parent_name" value="" url="{'/AutoComplete/productClass2'|U}" where="{"to_hide=1"|urlencode}" jqac>__*__
      </td>
    </tr> 
     <tr>
      <td class="width10">{$lang.class_no}：</td>
      <td class="t_left">
      <input type="text" name="class_no" id="class_no" value="{$max_no}" {$is_auto_no} >__*__
      </td>
    </tr>
    <tr>
      <td>{$lang.class_name_3}：</td>
      <td class="t_left">
      <input type="text" name="class_name" id="class_name" class="spc_input" >__*__
      <input type="hidden" name="class_level" value="3">
      <input type="submit" class="button_new"  value="{$lang.submit}">
      <span id="success" class="success"></span>
      </td>
    </tr>
</tbody>
</table> 
</div>
</form> 

{/if}
{if C('PRODUCT_CLASS_LEVEL')>=4}
<form action="{'ProductClass/insert'|U}" method="POST" id="ProductClass4" validity="productClassDistrict" name="Basic_addProductClass" onsubmit="setFormName('ProductClass4');return false">
<div class="add_box">
 <table cellspacing="0" cellpadding="0" class="add_table">
    <tbody>
     <tr><th colspan="2" class="t_left">{$lang.title_4}</th></tr>
     <tr>
      <td class="width10">{$lang.class_name_3}：</td>
      <td class="t_left">
      <input type="hidden" name="parent_id" value=""><input id="parent_name" value="" url="{'/AutoComplete/productClass3'|U}" where="{"to_hide=1"|urlencode}" jqac>__*__
      </td>
    </tr> 
     <tr>
      <td class="width10">{$lang.class_no}：</td>
      <td class="t_left">
      <input type="text" name="class_no" id="class_no" value="{$max_no}" {$is_auto_no} >__*__
      </td>
    </tr>
    <tr>
      <td>{$lang.class_name_4}：</td>
      <td class="t_left">
      <input type="text" name="class_name" id="class_name" class="spc_input" >__*__
      <input type="hidden" name="class_level" value="4">
      <input type="submit" class="button_new"  value="{$lang.submit}">
      <span id="success" class="success"></span>
      </td>
    </tr>
</tbody>
</table> 
</div>
</form>  
{/if}