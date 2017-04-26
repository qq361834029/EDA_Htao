{if C('PRODUCT_CLASS_LEVEL')==1}
<form action="{'ProductClass/insert'|U}" id="ProductClass1" method="POST" validity="productClassDistrict" onsubmit="return false">
<div class="table_autoshow" style="border-style:none!important;">
 <table cellspacing="0" cellpadding="0" width="100%">
    <tbody>
     <tr><th colspan="2" class="t_left">{$lang.title_1}</th></tr>
     <tr>
      <td class="width20">{$lang.class_no}：</td>
      <td class="t_left">
      <input type="text" name="class_no" id="class_no"  value="{$max_no}" {$is_auto_no}  >__*__
      </td>
    </tr>
    <tr>
      <td>{$lang.class_name_1}：</td>
      <td class="t_left">
      <input type="text" name="class_name" id="class_name" class="spc_input" >__*__
      <input type="hidden" name="class_level" value="1"　>
      <span id="success" class="success"></span>
      </td>
    </tr>
</tbody>
</table>
</div>
</form>  
{/if}
{if C('PRODUCT_CLASS_LEVEL')==2}
<form action="{'ProductClass/insert'|U}" method="POST" id="ProductClass2"  validity="productClassDistrict" name="Basic_addProductClass" onsubmit="return false">
<div class="table_autoshow" style="border-style:none!important;">
 <table cellspacing="0" cellpadding="0" width="100%">
    <tbody>
     <tr><th colspan="2" class="t_left">{$lang.title_2}</th></tr>
     <tr>
      <td class="width20">{$lang.class_name_1}：</td>
      <td class="t_left">
      <input type="hidden" name="parent_id" value=""><input id="parent_name" value="" url="{'/AutoComplete/productClass1'|U}" where="{"to_hide=1"|urlencode}" jqac itemto="dialog-quickly_add">__*__
      </td>
    </tr>
     <tr>
      <td class="width20">{$lang.class_no}：</td>
      <td class="t_left">
      <input type="text" name="class_no" id="class_no" value="{$max_no}"  {$is_auto_no} >__*__
      </td>
    </tr>
    <tr>
      <td>{$lang.class_name_2}：</td>
      <td class="t_left">
      <input type="text" name="class_name" id="class_name" class="spc_input" >__*__
      <input type="hidden" name="class_level" value="2">
      <span id="success" class="success"></span>
      </td>
    </tr>
</tbody>
</table> 
</div>
</form> 
{/if}
{if C('PRODUCT_CLASS_LEVEL')==3}
<form action="{'ProductClass/insert'|U}" method="POST" id="ProductClass3" validity="productClassDistrict" name="Basic_addProductClass" onsubmit="return false">
<div class="table_autoshow" style="border-style:none!important;">
 <table cellspacing="0" cellpadding="0" width="100%">
    <tbody>
     <tr><th colspan="2" class="t_left">{$lang.title_3}</th></tr>
     <tr>
      <td class="width20">{$lang.class_name_2}：</td>
      <td class="t_left">
      <input type="hidden" name="parent_id" value=""><input id="parent_name" value="" url="{'/AutoComplete/productClass2'|U}" where="{"to_hide=1"|urlencode}" jqac itemto="dialog-quickly_add">__*__
      </td>
    </tr> 
     <tr>
      <td class="width20">{$lang.class_no}：</td>
      <td class="t_left">
      <input type="text" name="class_no" id="class_no" value="{$max_no}" {$is_auto_no} >__*__
      </td>
    </tr>
    <tr>
      <td>{$lang.class_name_3}：</td>
      <td class="t_left">
      <input type="text" name="class_name" id="class_name" class="spc_input" >__*__
      <input type="hidden" name="class_level" value="3">
      <span id="success" class="success"></span>
      </td>
    </tr>
</tbody>
</table> 
</div>
</form> 

{/if}
{if C('PRODUCT_CLASS_LEVEL')==4}
<form action="{'ProductClass/insert'|U}" method="POST" id="ProductClass4" validity="productClassDistrict" name="Basic_addProductClass" onsubmit="return false">
<div class="table_autoshow" style="border-style:none!important;">
 <table cellspacing="0" cellpadding="0" width="100%">
    <tbody>
     <tr><th colspan="2" class="t_left">{$lang.title_4}</th></tr>
     <tr>
      <td class="width20">{$lang.class_name_3}：</td>
      <td class="t_left">
      <input type="hidden" name="parent_id" value=""><input id="parent_name" value="" url="{'/AutoComplete/productClass3'|U}" where="{"to_hide=1"|urlencode}" jqac itemto="dialog-quickly_add">__*__
      </td>
    </tr> 
     <tr>
      <td class="width20">{$lang.class_no}：</td>
      <td class="t_left">
      <input type="text" name="class_no" id="class_no" value="{$max_no}" {$is_auto_no} >__*__
      </td>
    </tr>
    <tr>
      <td>{$lang.class_name_4}：</td>
      <td class="t_left">
      <input type="text" name="class_name" id="class_name" class="spc_input" >__*__
      <input type="hidden" name="class_level" value="4">
      <span id="success" class="success"></span>
      </td>
    </tr>
</tbody>
</table> 
</div>
</form>  
{/if}