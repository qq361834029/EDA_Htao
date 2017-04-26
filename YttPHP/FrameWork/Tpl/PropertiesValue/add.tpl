<form action="{'PropertiesValue/insert'|U}" method="POST" name="Basic_addPropertiesValue" onsubmit="return false">
{wz action="save,list,reset"}
<div class="add_box">
 <table cellspacing="0" cellpadding="0" class="add_table">
<tr><th colspan="2">{$lang.title_1}</th></tr>
<tbody>
     <tr>
      <td class="width15">{$lang.pv_no}：</td>
      <td class="t_left"><input type="text" name="pv_no" value="{$max_no}" {$is_auto_no} >__*__
      </td>
    </tr>
    <tr>
      <td>{$lang.pv_name}：</td>
      <td class="t_left">
      <input type="text" name="pv_name" class="spc_input" >__*__（{'SYSTEM_LANG.cn'|C}）
      </td>
    </tr>
     <tr>
      <td>{$lang.pv_name}：</td>
      <td class="t_left">
      <input type="text" name="pv_name_de" class="spc_input" >__*__（{'SYSTEM_LANG.de'|C}）
      </td>
    </tr>
    <tr><th colspan="2">{$lang.title_2}</th></tr>
    <tr>
    <td>{$lang.p_name}：</td>
    <td class="t_left">
    {if in_array($smarty.const.LANG_SET,C('LONG_LANG_TPL'))}{assign var="lang_set" value="_de"}{/if}
    {checkbox name="properties[]" table="properties" key="id" field="properties_name`$lang_set`" where="properties_type>1 and to_hide=1" onclick="setMaxLength()"}
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






