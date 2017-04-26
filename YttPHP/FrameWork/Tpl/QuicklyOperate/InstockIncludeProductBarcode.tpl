<div class="table_autoshow" style="border-style:none!important; width: 780px!important;">
	<div class="note_right" style="margin:10px 30px 0 0;float: none !important;">
		<dl>
			<a href="javascript:;" onclick="javascript:PrintMytable($('#print_barcode_{$smarty.get.id}'), 900, 1040);"><dt><span class="icon icon-list-print"></span>{L('print')}</dt></a>
		</dl>
	</div>
	<div id="print_barcode_{$smarty.get.id}" class="width98">
		{assign var="row_num" value=0}
		{foreach from=$rs item=item}
			{assign var="row_num" value=$row_num+1}
			<ul style="clear: both;page-break-after:always;">
				{foreach from=$item item=pc_name name=pc_name}
				<li style="height: 282px !important; float: left; vertical-align: top;">
					<img width="250" src="{$smarty.const.BARCODE_PATH}{$smarty.get.module}/{$smarty.get.id}/{$pc_name}.{"BARCODE_PC_TYPE"|C}" />
				</li>
				{if $smarty.foreach.pc_name.iteration % 9 eq 0}
					</ul>
					{if !$smarty.foreach.pc_name.last}
						{assign var="row_num" value=$row_num+1}
						<ul style="clear: both;page-break-after:always;">
					{/if}
				{/if}
				{if $smarty.foreach.pc_name.last}
					</ul>
				{/if}				
				{/foreach}
		{/foreach}
	</div>
</div>
