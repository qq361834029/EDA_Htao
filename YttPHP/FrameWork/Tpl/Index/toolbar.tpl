<div id="footpanel"><ul id="mainpanel">
<li>
<div class="bottom_blue fr"><div class="bottomcontent">
	<div id="shToolbar" class="fl arrow_icon arrow_right"></div>
	<div class="user">{$lang.curr_user_name}：{$login_user.user_name}</div>
	{if C('remind_today_stat')==1}
	<div class="today"><a href="javascript:;" id="toolbar_stat" url="{'Ajax/todayRemind'|U}"><img src="__PUBLIC__/Images/Default/icon_tj.png" /></a></div>
	{/if}
	<div class="menu_nav">
	<ul>
	{if $login_user.user_type eq 2}
		<li><a href="javascript:;" id="toolbar_stat" url="{'Ajax/statSellerBalance'|U}">{$lang.select_balance}</a></li>
	{/if}
	<li id="toolbar_remind"><a href="javascript:;" url="{'Ajax/getRemind'|U}" stateurl="{'Ajax/getRemindState'|U}"></a>
		<div class="subpanel"><h3><span> &ndash; </span>{$lang.remind_info}</h3><ul style="border: 1px solid #2C6A9E;width:128px;"></ul></div>
	</li>
	<li id="toolbar_lang">
		<a href="javascript:;">{$lang.curr_lang}+</a>
		<div class="subpanel">
		<h3><span> &ndash; </span>{$lang.select_lang}</h3>
		<ul style="border: 1px solid #2C6A9E;width:128px;">
			{foreach from=C('SYSTEM_LANG') key=l_key item=l_item}
				<li><a href="?l={$l_key}">{$l_item}</a></li>
			{/foreach}
	    </ul>
	    </div>
	</li>
	{if $login_user.user_type eq 2}
	<li><a href="javascript:void(0)" onclick="addTab('{"/Factory/setting/id/`$login_user.company_id`"|U}','{$lang.company_setting}',1)">{$lang.company_setting}</a></li>
	{/if}
	<li><a href="javascript:;" onclick="loadTab()"><span class="icon icon-refresh"></span>{$lang.title_refresh}</a></li>
	<li><a href="javascript:;" id="close_all" onclick="window.location.reload();"><span class="icon icon-list-del"></span>{$lang.title_close_all}</a></li>
	<li id="toolbar_help"><a href="javascript:void(0)"><span class="icon icon-help"></span>{$lang.title_help}+</a>
		<div class="subpanel">
		<h3 ><span> &ndash; </span>{$lang.title_help}</h3>
		<ul style="border: 1px solid #2C6A9E;width:128px;">
		{if $super_admin}<li><a href="./admin.php" target="_blank">后台管理</a></li>{/if}
		<!--li><a href="__APP_ROOT__/invoice.php" target="_blank">发票系统</a></li-->
		   <li><a href="javascript:void(0)"  onclick="setIndex()">{$lang.setindex}</a></li>
		   <li><a href="javascript:;" onclick="addTab('{"Public/shortMenu"|U}','{$lang.title_key}')">{$lang.title_key}</a></li>
		   <li><a href="javascript:void(0)" onclick="getManual();">{$lang.title_help}</a></li>
		   <li><a href="javascript:void(0)" onclick="addTab('{"Public/service"|U}','{$lang.service}')">{$lang.title_customer}</a></li>
		   {if C('SHOW_GUIDE')==1}
		   <li><a href="javascript:void(0)"  onclick="guide();">{$lang.title_wizard}</a></li>
		   {/if}
		   <li><a href="javascript:void(0)" onclick="addTab('{"User/editPsw"|U}','{$lang.edit_psw}',1)">{$lang.edit_psw}</a></li>
		   <li><a href="__PUBLIC__/Data/install_lodop32.exe" target="_blank">{$lang.title_print_32}</a></li>
		   <li><a href="__PUBLIC__/Data/install_lodop64.exe" target="_blank">{$lang.title_print_64}</a></li>
		   {if $super_admin || $login_user.user_type eq 2}
		   <li><a href="__PUBLIC__/Data/Eda_Warehousing_Sellers_Operating_Manual.pdf" target="_blank">{$lang.sellers_operating_manual}</a></li>
		   <li><a href="__PUBLIC__/Data/EA_Account_Binding_Instructions.pdf" target="_blank">{$lang.ea_account_binding_instructions}</a></li>
		   <li><a href="__PUBLIC__/Data/Eda_Warehousing_API_Documentation.pdf" target="_blank">{$lang.api_documentation}</a></li>
		   {/if}
	       <li><a href="javascript:void(0)" onclick="addTab('{"User/setFormat"|U}','{$lang.setformat}',1)">{$lang.setformat}</a></li>
	    </ul>
	    </div>
	</li>
	<li><a href='{"Public/logout"|U}' target="_top" class="b_right">{$lang.title_logout}</a></li>
	</ul>
	</div>
	<div class="search">
	<div><input type="text" id="toolbar_product_input" value="{$lang.input_pno}" onfocus="javascript:if(this.value=='{$lang.input_pno}'){ this.value='';}" onkeyup="$.showToolsBarProduct(this)"></span>
	<div class="zoom none"><img id="toolbar_product_search" src="__PUBLIC__/Images/Default/icon_search.png" onclick="javascript:$.getProductInfo('{$lang.p_detail_info}',this);"></div>
	</div>

</div></div>
</li>

</ul>
</div>

<div id="toolbarProduct" class="toolbar_product"></div>
<div class="statisticsWindow" id="toolbarTodayRemind"></div>