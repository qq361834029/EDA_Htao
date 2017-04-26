<div class="popHead"><div class="hTitle">{$lang.today_statistics}</div><div class="hClose">&nbsp;</div></div>
<div class="popBody" style="border-left:#90ACBA 1px solid;border-right:#90ACBA 1px solid;width:238px;">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  {if $rs.today_instock}
    <tr>
    <td class="tbold" width=110 style="border-bottom:1px #CCCCCC dashed;">{$lang.today_storage_quantity}：</td>
    <td align="right" style="border-bottom:1px #CCCCCC dashed;"><a href="javascript:;" title="{$lang.today_statistics}" url="{$rs.today_instock_url}"  onclick="addTab('{$rs.today_instock_url}','{$lang.today_statistics}',1); "><span class="t_right_red">{$rs.today_instock.quantity}</span></a></td>
    </tr>
    {/if}
    {if $rs.today_sale}
    <tr>
    <td class="tbold" style="border-bottom:1px #CCCCCC dashed;">{$lang.sell_quantity}：</td>
    <td align="right" style="border-bottom:1px #CCCCCC dashed;"><a href="javascript:;" title="{$lang.today_statistics}" url="{$rs.today_sale_url}"  onclick="addTab('{$rs.today_sale_url}','{$lang.today_statistics}',1); "><span class="t_right_red">{$rs.today_sale.quantity}</span></a></td>
    </tr>
    <tr>
    <td class="tbold" style="border-bottom:1px #CCCCCC dashed;">{$lang.sell_money}：</td>
    <td align="right" style="border-bottom:1px #CCCCCC dashed;"><a href="javascript:;" title="{$lang.today_statistics}" url="{$rs.today_sale_url}"  onclick="addTab('{$rs.today_sale_url}','{$lang.today_statistics}',1); "><span class="t_right_red">{$rs.today_sale.note}</a></td>
    </tr>
    {/if}
    {if $rs.today_advance}
    <tr>
    <td class="tbold" style="border-bottom:1px #CCCCCC dashed;">{$lang.gather_money}：</td>
    <td align="right" style="border-bottom:1px #CCCCCC dashed;"><a href="javascript:;" title="{$lang.today_statistics}" url="{$rs.today_advance_url}"  onclick="addTab('{$rs.today_advance_url}','{$lang.today_statistics}',1); "><span class="t_right_red">{$rs.today_advance.note}</span></a></td>
    </tr> 
    {/if}
    {if $rs.today_arrearage}
    <tr>
    <td class="tbold" style="border-bottom:1px #CCCCCC dashed;">{$lang.arrearage_money}：</td>
    <td align="right" style="border-bottom:1px #CCCCCC dashed;"><a href="javascript:;" title="{$lang.today_statistics}" url="{$rs.today_arrearage_url}"  onclick="addTab('{$rs.today_arrearage_url}','{$lang.today_statistics}',1); "><span class="t_right_red">{$rs.today_arrearage.note}</span></a></td>
    </tr>
    {/if}
    {if $rs.today_client}
    <tr>
    <td class="tbold" style="border-bottom:1px #CCCCCC dashed;">{$lang.client}{$lang.answer_money}：</td>
    <td align="right"  style="border-bottom:1px #CCCCCC dashed;"><a href="javascript:;" title="{$lang.today_statistics}" url="{$rs.today_client_url}"  onclick="addTab('{$rs.today_client_url}','{$lang.today_statistics}',1); "><span class="t_right_red">{$rs.today_client.note}</span></a></td>
    </tr>
    {/if}
</table>
</div>