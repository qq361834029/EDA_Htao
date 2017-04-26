{detail_table id='detail_post_section_table' flow='setPostSection' from=$rs.detail action=['setPostSection'] op_show=['setPostSection'] 
	warehouse=true
	thead=[$lang.post_code_english,$lang.post_code_begin,$lang.post_code_end] tfoot=false}
<tr index="{$index}" class="{$none}" class="t_left">
    {td view="english" class="t_left"}
        <input type="text" value="{$item.english}" id='english' name="detail[{$index}][english]">
	{/td}
	
	{td class="t_left" view="post_begin"}
        <input type="text" style="width:100px;" value="{$item.post_begin}" id='post_begin' name="detail[{$index}][post_begin]">
	{/td}

	{td class="t_left" view="weight"}
        <input type="text" style="width:100px;" value="{$item.post_end}" id='post_end' name="detail[{$index}][post_end]">
    {/td}
    
	{detail_operation}
</tr>
{/detail_table}