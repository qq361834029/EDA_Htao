{include file="Admin/header.tpl"}
<script type="text/javascript">
function selectAll(obj,id){
	if(obj.checked){
		$("#"+id).find("input[type=checkbox]").attr('checked',true);
	}else{
		$("#"+id).find("input[type=checkbox]").attr('checked',false);
	}
	
}
function selectParent(id) {
	var selected = $("#"+id).find("input[id^='sub_'][type='checkbox'][checked!='false']").length;
	if(selected>0){
		$("#parent_"+id).attr('checked',true);
	}else{
		$("#parent_"+id).attr('checked',false);
	}
	
}
</script>

<div class="title"> 确定项目中哪些模块可用，勾选后在角色管理中可见。</div>
<form method="POST" action="{'Admin/updateNode'|U}">
<div class="div_main">  
    {foreach key=key item=item from=$menu}
	    <div class="div_role_operate" id="{$item.id}">
	        <div class="div_role_span">{$item.title}<input id="parent_{$item.id}" type="checkbox" onclick="selectAll(this,'{$item.id}')" {if $item.status==1}checked{/if}></div>
		    {foreach item=row key=sub_caption from=$item.sub}
		    <ul class="role_add">
		        <li>{$row.title} <input name="flow[{$row.id}]" id="sub_{$row.id}" type="checkbox" value="1" onclick="selectParent({$item.id})" {if $row.status==1}checked{/if}></li>
		    </ul>
			{/foreach}
		</div>
	{/foreach}
	</div>
	<div style="width:600px;padding:20px;">
	<div class="impBtn fLeft"><input type="submit" value="保存" class="save imgButton"></div>
	<div class="impBtn fRig"><input type="reset" class="reset imgButton" value="清空" ></div>
	</div>
</form>
{include file="Admin/footer.tpl"}