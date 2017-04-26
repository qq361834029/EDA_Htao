<div class="initialdata_explain">{$lang.guide_title_4}</div>
<div class="initialdate_height"> 
<!--库存开始-->	
{if $rights.initstorage.add || $admin_auth_key}
<div class="basic_title">{$lang.guide_inventory}</div>
<div class="databox">
    <div class="tb">
        <div class="r1" style="border-bottom:1px #CECECE solid;"></div>
        <div class="r2"></div>
        <div class="r3"></div>
    </div>
<div class="initialdatacontent">
<div class="initialdata_icon">
	<ul> 
		{if $rights.initstorage.add || $admin_auth_key}
		<li class="pad_left_10"><a href="javascript:;" onclick="addTab('{"InitStorage/add"|U}','{"guide_add_inventory"|L}',1); "><img src="__PUBLIC__/Images/Guide/newstock.gif" width="32" height="32" /><br />{$lang.guide_add_inventory}</a></li>
		{/if}
	</ul>
</div>


</div>
<div class="tb">
        <div class="r3"></div>
        <div class="r2"></div>
        <div class="r1" style="border-top:1px #CECECE solid;"></div>
    </div>
</div>
{/if}
<!--公司信息结束-->	
<div class="clear_both"></div>


<!--款项开始-->	
{if $rights.factoryini.add || $rights.logisticsini.add || $rights.clientini.add || $rights.bankini.add || $rights.comcashini.add || $admin_auth_key}
<div class="basic_title">{$lang.guide_funds}</div>
<div class="databox">
    <div class="tb">
        <div class="r1" style="border-bottom:1px #CECECE solid;"></div>
        <div class="r2"></div>
        <div class="r3"></div>
    </div>
<div class="initialdatacontent">
<div class="initialdata_icon">
	<ul> 
		{if $rights.factoryini.add || $admin_auth_key}
		<li><a href="javascript:;" onclick="addTab('{"FactoryIni/add"|U}','{"guide_add_fac_funds"|L}',1); "><img src="__PUBLIC__/Images/Guide/venderdue.gif" width="32" height="32" /><br />{$lang.guide_add_fac_funds}</a></li>
		{/if}
		{if $rights.logisticsini.add || $admin_auth_key}
		<li><a href="javascript:;" onclick="addTab('{"LogisticsIni/add"|U}','{"guide_add_log_funds"|L}',1); "><img src="__PUBLIC__/Images/Guide/logisticsdue.gif" width="32" height="32" /><br />{$lang.guide_add_log_funds}</a></li>
		{/if}
		{if $rights.clientini.add || $admin_auth_key}
		<li><a href="javascript:;" onclick="addTab('{"ClientIni/add"|U}','{"guide_add_client_funds"|L}',1); "><img src="__PUBLIC__/Images/Guide/clientar.gif" width="32" height="32" /><br />{$lang.guide_add_client_funds}</a></li>
		{/if}
		{if $rights.bankini.add || $admin_auth_key}
		<li><a href="javascript:;" onclick="addTab('{"BankIni/add"|U}','{"guide_add_bank_funds"|L}',1); "><img src="__PUBLIC__/Images/Guide/bankdeposit.gif" width="32" height="32" /><br />{$lang.guide_add_bank_funds}</a></li>
		{/if}
		<!--
		{if $rights.comcashini.add}
		<li><a href="javascript:;" onclick="addTab('{"ComcashIni/add"|U}','{"guide_add_cash_funds"|L}',1); " ><img src="__PUBLIC__/Images/Guide/money.gif" width="32" height="32" /><br />{$lang.guide_add_cash_funds}</a></li>
		{/if}
		-->
</ul>
</div>  
</div>
<div class="tb">
        <div class="r3"></div>
        <div class="r2"></div>
        <div class="r1" style="border-top:1px #CECECE solid;"></div>
    </div>
</div>
<!--产品信息结束-->	
{/if}
<div class="clear_both"></div>


<!--固定汇率-->	
{if $rights.fixedrate || $admin_auth_key}
<div class="basic_title">{$lang.rate}</div>
<div class="databox">
    <div class="tb">
        <div class="r1" style="border-bottom:1px #CECECE solid;"></div>
        <div class="r2"></div>
        <div class="r3"></div>
    </div>
<div class="initialdatacontent">
<div class="initialdata_icon">
	<ul> 
		{if $rights.fixedrate || $admin_auth_key}
		<li class="pad_left_10"><a href="javascript:;" onclick="addTab('{"FixedRate/index"|U}','{"fixedrate"|L}',1); "><img src="__PUBLIC__/Images/Guide/chart_bar.png" width="32" height="32" /><br />{$lang.fixedrate}</a></li>
		{/if}
	</ul>
</div>
</div>
<div class="tb">
        <div class="r3"></div>
        <div class="r2"></div>
        <div class="r1" style="border-top:1px #CECECE solid;"></div>
    </div>
</div>
{/if}
<!--公司信息结束-->	
<div class="clear_both"></div>

</div>
