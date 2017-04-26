<form action="{'FixedRate/update'|U}" method="POST" onsubmit="return false;">
{wz action="save"}
<div id="print" class="width98">
<table id="index" class="list" border=0>
<thead>
<tr><th width="33%">{$lang.from_currency}</th><th width="33%">{$lang.to_currency}</th><th width="">{$lang.rate}</th></tr>
</thead>
<tbody>
{foreach item=item from=$list}
<tr>
<td>{$currency[$item.from_currency_id].currency_no}</td>
<td>{$currency[$item.to_currency_id].currency_no}</td>
<td><input type="text" name="rate[{$item.id}]" value="{$item.rate}"></td>
</tr>
{/foreach}
</tbody>
</table>
</div> 
</form> 