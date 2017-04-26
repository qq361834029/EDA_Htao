<form action="{'Message/update'|U}" method="POST" name="Basic_addMessage" onsubmit="return false">
{wz action="save,save_announce,reset"}
<div class="add_box">
 <table cellspacing="0" cellpadding="0" class="add_table">
<tbody >
	<tr>
    <input type="hidden" name="id" id="id" value="{$rs.id}"/>
    </tr>
    <tr>
      <td>{$lang.category_name}：</td>
      <td class="t_left">
		<input type="hidden" name="message_category_id" id="message_category_id" value="{$rs.message_category_id}" >
        <input type="text" name="temp[category_name]"  value="{$rs.category_name}" url="{'/AutoComplete/categoryId'|U}" jqac>__*__
      </td>
    </tr>
	 <tr>
      <td>{$lang.message_title}：</td>
      <td class="t_left">
      <input type="text" name="message_title"  value="{$rs.message_title}" class="spc_input" >__*__
      </td>
    </tr>
	 <tr>
	  <td valign="top" class="t_right" width="20%">{$lang.message_content}：</td>
		<td class="t_left" valign="top" width="80%">
		<textarea id="message_content" name="message_content"  class="textarea_height80">{$rs.message_content}</textarea>
		</td>
    </tr>
	{if $is_admin}
	<td>{$lang.user_type}：</td>
		<td class="t_left">
		   <input type="checkbox" name="user_type[1]" id='1'  value="1" {if in_array('1',$rs.user_type)} checked='true'{/if}>{$lang.company}
		   <input type="checkbox" name="user_type[2]" id='2'  value="2" {if in_array('2',$rs.user_type)} checked='true'{/if}> {$lang.seller}
		   <input type="checkbox" name="user_type[3]" id='3'  value="3" {if in_array('3',$rs.user_type)} checked='true'{/if}> {$lang.seller_staff}
		   <input type="checkbox" name="user_type[4]" id='4'  value="4" {if in_array('4',$rs.user_type)} checked='true'{/if}> {$lang.partner}
		   <input type="checkbox" name="user_type[5]" id='5'  value="5" {if in_array('5',$rs.user_type)} checked='true'{/if}> {$lang.warehouse}
		</td>
    </tr>
	{/if}
    <tr>
        <td>{$lang.upload_file}：</td>
        <td class="t_left">{upload tocken=$file_tocken sid=$sid type=29 allowTypes="all"}</td>
        <input type="hidden" id="file_name" name="file_name">
        <input type="hidden" name="sheet" value="0">
        <input type="hidden" name="import_key" value="{$import_key}">
    </tr>
    <tr>
        <td></td>
        <td class="t_left">
        {foreach $rs.gallery as $val}
            <div id="file_view_{$val.id}">
                <a href={$val.file_url} target="_blank">{$val.cpation_name}</a>
                <a onclick="$.deleteFile({$val.id})" href="javascript:;">
                    <img border="0" src="__PUBLIC__/Images/Default/close_gray.png">
                </a>
            </div>
        {/foreach}
        </td>
    </tr>
    </tbody>
  </table>
</div>
</form>
 