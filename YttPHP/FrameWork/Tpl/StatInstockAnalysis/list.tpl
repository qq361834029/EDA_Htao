{if $list.list}
<table border="0" cellspacing="0" cellpadding="0" class="list">
  <tr>
    <th rowspan="2" class="slant_title_bg" valign="top">
	<div style="text-indent:60px;">币种</div>
	<div>数量和单价</div>
	<div class="t_left pad_left_10">日期</div></th>
	{foreach from=$list.currency item=currency}
    	<th colspan="2" class="slant_title">{$currency}</th>
    {/foreach}
  </tr>
  <tr>
  	{foreach from=$list.currency item=currency}
	    <th>数量</th>
	    <th>单价</th>
    {/foreach}
 </tr>
  {foreach from=$list.list key=key item=item}
	  <tr>
		<td>{$key}</td>
	  	{foreach from=$item item=info}
	  		{if $info.sum_quantity>0}
			    <td class="t_right"><a href="javascript:;" onclick="addTab('{"`$info.var_url`"|U}','{"view"|title:"Instock"}',1)">{$info.sum_quantity}</a></td>
			{else}
				<td class="t_right">{$info.sum_quantity}</td>
			{/if}
			    <td class="t_right">{$info.avg_price}</td>
			
	  	{/foreach}
	  </tr>
  {/foreach}
</table>
{/if}