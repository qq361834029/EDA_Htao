<link rel="stylesheet" href="__PUBLIC__/Css/invoice_print.css">
<div id="print" style="width:726px;" class="margin_left_10">
<!--  头部  -->
<table class="table_out"  cellspacing="0" cellpadding="0" border="0">
	<tr>
		<td valign="top">
			{include file="InvoicePrint/head.tpl"}
		</td>
	</tr>
</table>
<!--  头部结束 -->
<div class="pad_top_10"></div>

<!--  发票产品明细 -->
{include file='InvoicePrint/content.tpl'}

<!-- 发票产品明细结束 -->
<div style="height:40px;"></div>
<!-- IVA值 -->
<table width="726" cellspacing="0" cellpadding="0" border="0" style="margin:0 auto;">
	<tbody>
  		<tr>
    		<td width="52%" valign="top" style="padding-right:30px;">
    			{include file="InvoicePrint/iva.tpl"}
			</td>
    		<td valign="top">
    			{include file="InvoicePrint/iva_total.tpl"}
			</td>
  		</tr>
	</tbody>
</table>
<!-- IVA -->
<!-- 底部备注 -->
{include file='InvoicePrint/comments.tpl'}
<!-- 底部备注 -->
</div>

