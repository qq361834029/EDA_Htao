 <form action="{'Message/insert'|U}" method="POST" name="Basic_addMessage" onsubmit="return false">
{wz action="save,save_announce,reset"}
<input type="hidden" name="file_tocken" value="{$file_tocken}">
<div class="add_box">
 <table cellspacing="0" cellpadding="0" class="add_table">
<tbody>
    <tr>
      <td>{$lang.category_name}：</td>
      <td class="t_left">
		<input type="hidden" name="message_category_id" id="message_category_id" >
        <input type="text" name="temp[category_name]"   url="{'/AutoComplete/categoryId'|U}" jqac>__*__
      </td>
    </tr>
	 <tr>
      <td>{$lang.message_title}：</td>
      <td class="t_left">
      <input type="text" name="message_title" class="spc_input" >__*__
      </td>
    </tr>
	<tr>
	  <td valign="top" class="t_right" width="20%"    >{$lang.message_content}：</td>
		<td class="t_left" valign="top" width="80%">
		<textarea id="message_content" name="message_content" style="height:350px;" class="textarea_height80"></textarea>
		</td>
    </tr>
	 <tr>
      <td>{$lang.user_type}：</td>	  
		<td class="t_left">
		   <input type="checkbox" name="user_type[1]" value="1">{$lang.company}
		   <input type="checkbox" name="user_type[2]" value="2"> {$lang.seller}
		   <input type="checkbox" name="user_type[3]" value="3"> {$lang.seller_staff}
		   <input type="checkbox" name="user_type[4]" value="4"> {$lang.partner}
		   <input type="checkbox" name="user_type[5]" value="5"> {$lang.warehouse}
		</td>
    </tr>
    <tr>
        <td>{$lang.upload_file}：</td>
        <td class="t_left">{upload tocken=$file_tocken sid=$sid type=29 allowTypes="all"}</td>
        <input type="hidden" id="file_name" name="file_name">
        <input type="hidden" name="sheet" value="0">
        <input type="hidden" name="import_key" value="{$import_key}">
    </tr>
    </tbody>
  </table>
</div>
</form>

