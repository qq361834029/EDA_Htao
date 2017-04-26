<div style="height:50px;"></div>
<div style="width:726px;margin:0 auto;">
	<div class="title02">
	{if $rs.relation_id>0}
	remarque：{$rs.relation.relation_no}  {$rs.relation.fmd_relation_date}
	{/if}
	</div>
	<div class="title03">
		{if $smarty.const.MODULE_NAME=='InvoiceIn'}
			{'invoice.in_comments'|C|stripcslashes|nl2br}
		{else}
			{'invoice.out_comments'|C|stripcslashes|nl2br}
		{/if}
	</div>
</div>