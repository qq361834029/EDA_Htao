<div id="footpanel" invoice=1><ul id="mainpanel">
<li>
<div class="bottom_blue fr"><div class="bottomcontent">
	<div id="shToolbar" class="fl arrow_icon arrow_right"></div>
	<div class="user">{$lang.curr_user_name}：{$login_user.user_name}</div>
	
	<div class="menu_nav">
	<ul>
	
	<li id="toolbar_lang">
		<a href="javascript:;">{$lang.curr_lang}+</a>
		<div class="subpanel">
		<h3><span> &ndash; </span>{$lang.select_lang}</h3>
		<ul style="border: 1px solid #2C6A9E;width:128px;">
			{foreach C('SYSTEM_LANG') key=l_key item=l_item}
				<li><a href="?l={$l_key}">{$lang[$l_key]}</a></li>
			{/foreach}
	    </ul>
	    </div>
	</li>
	<li><a href="javascript:;" onclick="loadTab()"><span class="icon icon-refresh"></span>{$lang.title_refresh}</a></li>
	<li><a href="javascript:;" id="close_all" onclick="window.location.reload();"><span class="icon icon-list-del"></span>{$lang.title_close_all}</a></li>
	
	<li id="toolbar_help"><a href="javascript:void(0)"><span class="icon icon-help"></span>{$lang.title_help}+</a>
		<div class="subpanel">
		<h3 ><span> &ndash; </span>{$lang.title_help}</h3>
		<ul style="border: 1px solid #2C6A9E;width:128px;">
		{if $super_admin}<li><a href="{'/Admin'|U}" target="_blank">后台管理</a></li>{/if}
		   
		   <li><a href="javascript:void(0)" onclick="getManual();">{$lang.title_help}</a></li>
		   <li><a href="javascript:void(0)" onclick="addTab('{"Public/service"|U}','{$lang.service}')">{$lang.title_customer}</a></li>
		   
		   <li><a href="javascript:void(0)" onclick="addTab('{"User/editPsw"|U}','{$lang.edit_psw}',1)">{$lang.edit_psw}</a></li>
		   <li><a href="__PUBLIC__/Data/install_lodop32.exe" target="_blank">{$lang.title_print_32}</a></li>
		   <li><a href="__PUBLIC__/Data/install_lodop64.exe" target="_blank">{$lang.title_print_64}</a></li>
	       <li><a href="javascript:void(0)" onclick="addTab('{"User/setFormat"|U}','{$lang.setformat}',1)">{$lang.setformat}</a></li>
	    </ul>
	    </div>
	</li>
	<li><a href='{"Public/logout"|U}' target="_top" class="b_right">{$lang.title_logout}</a></li>
	</ul>
	</div>
	

</div></div>
</li>

</ul>
</div>

<div id="toolbarProduct" class="toolbar_product"></div>
<div class="statisticsWindow" id="toolbarTodayRemind"></div>
