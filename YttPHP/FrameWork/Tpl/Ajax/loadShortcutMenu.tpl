<div class="top_right_arrow">  
<img src="__PUBLIC__/Images/Default/arrow_down.png" id="sdfjasdlfasdf">
</div>
<div class="top_right">
<ul class="fast">
{foreach item=item from=$short_menu.short}
<li><a onclick="javascript:addTab('{"`$item.model`/`$item.action`"|U}','{$item.menu_name}');$('#shortMenuHide').hide();">
	<div class="box1"><div class="cc"><span class="arrow_icontop">&nbsp;</span><span>{$item.menu_name}</span></div></div>
</a></li>
{/foreach}
</ul>
</div>

<div id="shortMenuHide" class="none">
<ul class="shortcutmenu">
{foreach item=item from=$short_menu.hidden}
<li><a onclick="javascript:addTab('{"`$item.model`/`$item.action`"|U}','{$item.menu_name}');$('#shortMenuHide').hide();">
	<span class="arrow_icontop">&nbsp;</span><span>{$item.menu_name}</span>
</a></li>
{/foreach}
</ul>
</div>