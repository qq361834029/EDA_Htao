{wz is_update=$rs.is_update}
<div id="print">
<div class="add_box">
 <table cellspacing="0" cellpadding="0" class="add_table">
<tbody>
<tr>
      <td class="width15">{$lang.category_name}：</td>
      <td class="t_left">{$rs.category_name}</td>
</tr>
<tr>
      <td class="width15">{$lang.message_title}：</td>
      <td class="t_left">{$rs.message_title}</td>
</tr>
<tr>
      <td class="width15" valign="top">{$lang.message_content}：</td>
	  <td class="t_left" valign="top" width="80%">
	 <textarea id="message_content" name="message_content"  style="height:350px;" class="textarea_height80 disabled"  readonly="">{$rs.message_content}</textarea>
	  </td>
</tr>
{if $is_admin}
<tr>
      <td class="width15">{$lang.user_type}：</td>
      <td class="t_left">{$rs.dd_user_type}</td>
</tr>
{/if}
<tr>
    <td>{$lang.download_file}：</td>
    <td class="t_left">
    {foreach $rs.gallery as $val}
        <a href={$val.file_url} target="_blank">{$val.cpation_name}</a>
    {/foreach}
    </td>
</tr>
</tbody>
</table>
</div>
