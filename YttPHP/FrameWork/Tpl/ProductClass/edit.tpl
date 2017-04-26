{if $rs.class_level==1}
<form action="{'ProductClass/update'|U}" method="POST" name="Basic_addProductClass" onsubmit="">
{wz}
<div class="add_box">
<input type="hidden" name="id" value="{$rs.id}">
 <table cellspacing="0" cellpadding="0" class="add_table">
    <tbody>
     <tr><th colspan="2" class="t_left">{$lang.title_1}</th></tr>
     <tr>
      <td class="width10">{$lang.class_no}：</td>
      <td class="t_left">
      <input type="text" name="class_no" id="class_no" value="{$rs.class_no}" {$is_auto_no} >__*__
      </td>
    </tr>
    <tr>
      <td>{$lang.class_name_1}：</td>
      <td class="t_left">
      <input type="text" name="class_name" id="class_name" value="{$rs.class_name}" class="spc_input" >__*__
      <input type="hidden" name="class_level" value="1">
      <input type="submit" class="button_new"  value="{$lang.submit}">
      <span id="success" class="success"></span>
      </td>
    </tr>
</tbody>
</table> 
</div>
</form>  
{elseif $rs.class_level==2}
<form action="{'ProductClass/update'|U}" method="POST" name="Basic_addProductClass" onsubmit="">
{wz}
<div class="add_box">
<input type="hidden" name="id" value="{$rs.id}">
 <table cellspacing="0" cellpadding="0" class="add_table">
    <tbody>
     <tr><th colspan="2" class="t_left">{$lang.title_2}</th></tr>
     <tr>
      <td class="width10">{$lang.class_name_1}：</td>
      <td class="t_left">
      <input type="hidden" name="parent_id" value="{$rs.parent_id}" ><input id="parent_name" url="{'/AutoComplete/productClass1'|U}" where="{"to_hide=1"|urlencode}" value="{$rs.parent_name}" jqac>__*__
      </td>
    </tr>
     <tr>
      <td class="width10">{$lang.class_no}：</td>
      <td class="t_left">
      <input type="text" name="class_no" id="class_no" value="{$rs.class_no}" {$is_auto_no} >__*__
      </td>
    </tr>
    <tr>
      <td>{$lang.class_name_2}：</td>
      <td class="t_left">
      <input type="text" name="class_name" id="class_name" value="{$rs.class_name}" class="spc_input" >__*__
      <input type="hidden" name="class_level" value="2">
      <input type="submit" class="button_new"  value="{$lang.submit}">
      <span id="success" class="success"></span>
      </td>
    </tr>
</tbody>
</table> 
</div>
</form> 
{elseif $rs.class_level==3}

<form action="{'ProductClass/update'|U}" method="POST" name="Basic_addProductClass" onsubmit="">
{wz}
<div class="add_box">
<input type="hidden" name="id" value="{$rs.id}">
 <table cellspacing="0" cellpadding="0" class="add_table">
    <tbody>
     <tr><th colspan="2" class="t_left">{$lang.title_3}</th></tr>
     <tr>
      <td class="width10">{$lang.class_name_2}：</td>
      <td class="t_left">
      <input type="hidden" name="parent_id" value="{$rs.parent_id}" ><input id="parent_name" url="{'/AutoComplete/productClass2'|U}"  where="{"to_hide=1"|urlencode}" value="{$rs.parent_name}" jqac>__*__
      </td>
    </tr> 
     <tr>
      <td class="width10">{$lang.class_no}：</td>
      <td class="t_left">
      <input type="text" name="class_no" id="class_no" value="{$rs.class_no}" {$is_auto_no} >__*__
      </td>
    </tr>
    <tr>
      <td>{$lang.class_name_3}：</td>
      <td class="t_left">
      <input type="text" name="class_name" id="class_name" value="{$rs.class_name}" class="spc_input" >__*__
      <input type="hidden" name="class_level" value="3">
      <input type="submit" class="button_new"  value="{$lang.submit}">
      <span id="success" class="success"></span>
      </td>
    </tr>
</tbody>
</table> 
</div>
</form> 

{elseif $rs.class_level==4}
<form action="{'ProductClass/update'|U}" method="POST" name="Basic_addProductClass" onsubmit="">
{wz}
<div class="add_box">
<input type="hidden" name="id" value="{$rs.id}">
 <table cellspacing="0" cellpadding="0" class="add_table">
    <tbody>
     <tr><th colspan="2" class="t_left">{$lang.title_4}</th></tr>
     <tr>
      <td class="width10">{$lang.class_name_3}：</td>
      <td class="t_left">
      <input type="hidden" name="parent_id" value="{$rs.parent_id}" ><input id="parent_name" url="{'/AutoComplete/productClass3'|U}"  where="{"to_hide=1"|urlencode}" value="{$rs.parent_name}" jqac>__*__
      </td>
    </tr> 
     <tr>
      <td class="width10">{$lang.class_no}：</td>
      <td class="t_left">
      <input type="text" name="class_no" id="class_no" value="{$rs.class_no}" {$is_auto_no} >__*__
      </td>
    </tr>
    <tr>
      <td>{$lang.class_name_4}：</td>
      <td class="t_left">
      <input type="text" name="class_name" id="class_name" value="{$rs.class_name}" class="spc_input" >__*__
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

<script>
function saveProductClass(frm){
	return true;
	$(frm).find("#success").html('');
	if(true==$.validForm(frm)){
		var data = $(frm).serialize();
		$.post("_Ajax_/addClass",data,function(bool){
			$(frm).find("#class_no").val('');
			$(frm).find("#class_name").val('');
			$(frm).find("#parent_name").val('');
			$(frm).find("#parent_id").val('');
			$(frm).find("#success").html('{$lang.success}');
			setTimeout(location.reload(),1500)
		})
	}
	return false;
}
</script>  