<form action="{'PropertiesValue/update'|U}" method="POST" name="Basic_addPropertiesValue" onsubmit="return false">
{wz action="save,list,reset"}
<div class="add_box">
 <input type="hidden" name="id" value="{$rs.id}">
<input type="hidden" name="lock_version" id="lock_version" value="{$rs.lock_version}">
<table cellspacing="0" cellpadding="0" class="add_table">
<tbody>
	<tr><th colspan="2">{$lang.title_1}</th></tr>
     <tr>
      <td class="width15">{$lang.pv_no}：</td>
      <td class="t_left"><input type="text" name="pv_no" value="{$rs.pv_no}" {$is_auto_no} >__*__
      </td>
    </tr>
    <tr>
      <td>{$lang.pv_name}：</td>
      <td class="t_left">
      <input type="text" name="pv_name" value="{$rs.pv_name}" class="spc_input" >__*__（{'SYSTEM_LANG.cn'|C}）
      </td>
    </tr>
    <tr>
      <td>{$lang.pv_name}：</td>
      <td class="t_left">
      <input type="text" name="pv_name_de" value="{$rs.pv_name_de}" class="spc_input" >__*__（{'SYSTEM_LANG.de'|C}）
      </td>
    </tr>
    <tr><th colspan="2">{$lang.title_2}</th></tr>
    <tr>
    <td>{$lang.p_name}：</td>
    <td class="t_left">
    {checkbox name="properties[]" value="`$rs.properties_id`" table="properties" key="id" field="properties_name" where="properties_type>1 and to_hide=1" onclick="setMaxLength()"}
    <input type="hidden" id="max_length" name="max_length" value="0">
    </td>
    </tr>
    </tbody>
  </table>
</div>
</form>  
<script>
function setMaxLength(){
	var min_length = 0;
	$(":checkbox[checked=true]").each(function(){
		var length = $(this).attr('barlength');
		if(length==undefined) return true;
		if(min_length==0){
			min_length = length;
		}else{
			if(length<=min_length){
				min_length = length;
			}
		}
	})
	$("#max_length").val(min_length);
}
</script> 


