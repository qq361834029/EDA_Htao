{include file="InvoiceIndex/header.tpl"}
<div class="fiexd_header">
	<div class="menu">
	{foreach item=menu1 from=$menu}
	<ul>
		<li class="white"><a href="javascript:;" class="white"><span style="color:#ffffff;">{$lang["node_`$menu1.id`"]}</span></a>
			<ul>
			{foreach item=menu2 from=$menu1.sub}
				{if $menu2.sub}
					<li><span class="span_w134"><a href="javascript:;" url="{$menu2.href|U}" title="{$menu2.id|title}" class="white">{$menu2.id|title}</a></span><span class="second_arrow fr"><a href="javascript:;">&nbsp;</a></span>
						<ul>
						{foreach item=menu3 from=$menu2.sub}
						{if $menu3.ico_link}
						<li><span class="span_w134"><a href="javascript:;" url="{$menu3.href|U}" title="{$menu3.id|title}" class="white">{$menu3.id|title}</a></span>
						<span class="menu_add fr"><a href="javascript:;" url="{$menu3.module|cat:'/add'|U}" title="{$menu3.ico_link.id|title}">&nbsp;</a></span>
						</li>
						{else}
						<li><a href="javascript:;" url="{$menu3.href|U}" title="{$menu3.id|title}">{$menu3.id|title}</a></li>
						{/if}
						{/foreach}
						</ul>
					</li>
				{else}
					<li><a href="javascript:;" url="{$menu2.href|U}" title="{$menu2.id|title}">{$menu2.id|title}</a></li>
				{/if}
			{/foreach}
			</ul>
		</li>
	</ul>
	{/foreach}
	</div>
	<div id="shortcutMenu" class="shortcutMenu"></div>
</div>
<div id="tabs">
	<ul><li><a href="#ui_tabs-1">{$lang.sys_index}</a></li></ul>
	<div id="ui_tabs-1" style="width:100%;float:left;overflow-y:hidden;">
		<div style="height:750px;background:url('__PUBLIC__/Images/Default/index_bg.gif')" class="index_bg">
			<p class="t_center" style="padding-top:80px;"><img src="__PUBLIC__/Images/Default/index_tu.jpg"></p>
		</div>
	</div>
</div>
<div class="fiexd_footer">{include file="InvoiceIndex/toolbar.tpl"}</div>
{include file="Public/footer.tpl"}