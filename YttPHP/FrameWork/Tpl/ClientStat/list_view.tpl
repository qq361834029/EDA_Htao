<div class="woaicss_title width98 none">  
        <ul>
		{if $showtype!=4 && $smarty.request.from_paid_date=='' && $smarty.request.to_paid_date==''}  
			{if !$smarty.request.paid_date}
				{if C('UNPAID_ARREARAGE_DETAILS')==1 || C('UNPAID_ARREARAGE_DETAILS')==3}
					<li><a href="javascript:;" {if $smarty.request.type==1 && $smarty.request.for_type==1} class="woaicss_click" {/if}  onclick="addTab('{$link1}/for_type/1','{$lang.unpaid_arrearage_details_fordate}',1); "><span class="white_word">{$lang.unpaid_arrearage_details_fordate}</span></a></li>
				{/if} 
				{if C('UNPAID_ARREARAGE_DETAILS')==2 || C('UNPAID_ARREARAGE_DETAILS')==3}
					<li><a href="javascript:;" {if $smarty.request.type==1 && $smarty.request.for_type==2} class="woaicss_click" {/if}  onclick="addTab('{$link1}/for_type/2/show_type/not_page','{$lang.unpaid_arrearage_details_fortype}',1); "><span class="white_word">{$lang.unpaid_arrearage_details_fortype}</span></a></li>
				{/if}
			{/if}
			{if C('ALL_ARREARAGE_DETAIL')==1 || C('ALL_ARREARAGE_DETAIL')==3}
				<li><a href="javascript:;" {if $smarty.request.type==3 && $smarty.request.for_type==1} class="woaicss_click" {/if} onclick="addTab('{$link3}/for_type/1','{$lang.all_arrearage_detail_fordate}',1); "><span class="white_word">{$lang.all_arrearage_detail_fordate}</span></a></li>
			{/if}
			{if C('ALL_ARREARAGE_DETAIL')==2 || C('ALL_ARREARAGE_DETAIL')==3}
				<li><a href="javascript:;" {if $smarty.request.type==3 && $smarty.request.for_type==2} class="woaicss_click" {/if} onclick="addTab('{$link3}/for_type/2','{$lang.all_arrearage_detail_fortype}',1); "><span class="white_word">{$lang.all_arrearage_detail_fortype}</span></a></li>
			{/if}
			{if C('ARREARAGE_DETAILS_AFCLOSEOUT')==1 || C('ARREARAGE_DETAILS_AFCLOSEOUT')==3}
				<li><a href="javascript:;" {if $smarty.request.type==2 && $smarty.request.for_type==1} class="woaicss_click" {/if} onclick="addTab('{$link2}/for_type/1','{$lang.arrearage_details_afcloseout_fordate}',1); "><span class="white_word">{$lang.arrearage_details_afcloseout_fordate}</span></a></li>
			{/if}
			{if C('ARREARAGE_DETAILS_AFCLOSEOUT')==2 || C('ARREARAGE_DETAILS_AFCLOSEOUT')==3}
				<li><a href="javascript:;" {if $smarty.request.type==2 && $smarty.request.for_type==2} class="woaicss_click" {/if} onclick="addTab('{$link2}/for_type/2','{$lang.arrearage_details_afcloseout_fortype}',1); "><span class="white_word">{$lang.arrearage_details_afcloseout_fortype}</span></a></li>
			{/if}
		{/if}
    	</ul>
 </div>
{if $smarty.request.for_type==2}
	{if $smarty.request.type>1}
	{include file="ClientStat/detailForType`$smarty.request.type`.tpl"}
	{else} 
	{include file="ClientStat/detailForType.tpl"}
	{/if}
{else}
	{if $smarty.request.type>1}
		{include file="ClientStat/detail`$smarty.request.type`.tpl"}
	{else} 
		{include file="ClientStat/detail.tpl"}
	{/if}
{/if}