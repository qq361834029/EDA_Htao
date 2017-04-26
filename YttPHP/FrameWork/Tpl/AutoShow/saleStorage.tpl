<table cellspacing="0" cellpadding="0"  align="center" class="product_table">
    <tbody>    
    <tr>
      <td colspan="2" style="font-size:14px;text-align:left;height:30px;border-bottom:1px #CCCCCC dashed;">{$lang.product_no}：{$rs.product_no}&nbsp;&nbsp;&nbsp;&nbsp;{$lang.custom_barcode}：{$rs.custom_barcode}&nbsp;&nbsp;&nbsp;&nbsp;{$lang.product_name}：{$rs.product_name}</p></td>

    </tr>
    <tr>
        <td colspan="2" class="t_left"><div class="blue tbold" style="widht:110px; padding-right:5px;float:left;">▼{$lang.sale_storage}</div>{if C("loadContainer.sale_storage")==1}<div class="storage_title"></div>{$lang.onroad_storage}{/if}</td>
      </tr>
      {if $storage}
     <tr>
      <td  colspan="2" class="t_left">
			<table id="index" class="add_table_autoshow" border=0>
				<thead><tr>
				{if $login_user.role_type != C('WAREHOUSE_ROLE_TYPE')}<th width="">{$lang.warehouse_name}</th>{/if}
				{if 'storage_color'|C}<th width="">{$lang.color_name}</th>{/if}
				{if 'storage_size'|C}<th width="">{$lang.size_name}</th>{/if}
				<th width="">{$lang.quantity}</th>
				{if 'storage_format'|C>=2}<th width="">{$lang.capability}</th>{/if}
				{if 'storage_format'|C>=3}<th width="">{$lang.dozen}</th>{/if}
				{if 'storage_format'|C>1}<th width="">{$lang.sum_quantity}</th>{/if}
				{if 'storage_mantissa'|C}<th width="">{$lang.mantissa_2}</th>{/if}
				</tr>
				</thead>
				<tbody>
				{foreach item=item from=$storage.list}
				<tr {if $item.lc_state==2}class="line_bzyellow"{/if}>
				{if $login_user.role_type != C('WAREHOUSE_ROLE_TYPE')}<td width="">{$item.w_name}</td>{/if}
				{if 'storage_color'|C}<td width="" {if $item.color_name==''}class="b_top_load"{/if}>{$item.color_name}</td>{/if}
				{if 'storage_size'|C}<td width="" {if $item.size_name==''}class="b_top_load"{/if}>{$item.size_name}</td>{/if}
				<td width="">{$item.dml_quantity}</td>
				{if 'storage_format'|C>=2}<td width="">{$item.dml_capability}</td>{/if}
				{if 'storage_format'|C>=3}<td width="">{$item.dml_dozen}</td>{/if}
				{if 'storage_format'|C>1}<td width="">{$item.dml_sale_storage}</td>{/if}
				{if 'storage_mantissa'|C}<td width="" class="t_center">{if $item.mantissa==2}√{/if}</td>{/if}
				</tr>
				{/foreach}
				</tbody>
				<tfoot>
				<tr><td class="t_right tred" colspan="10">{$lang.row_total}：{$storage.total.dml_quantity}（{$lang.quantity}）</td></tr>
				</tfoot>
			</table>
      </td>
    </tr>  
     {else}
	    <tr>
        <td colspan="2" class="t_center">&nbsp;</td>
      </tr>
      {/if} 
    {if C('PRODUCT_COLOR')==1 && C('PRODUCT_SIZE')==1 && C('PRODUCT_FIT')==1}
     <tr><th colspan="2" style="padding:0px!important;font-weight:bold;">▼{$lang.fit}</th></tr>
    <tr>
     <td  colspan="2" class="t_left">
     {html_fit class="fit" value="`$rs.fit`" readonly="true"}
     </td></tr> 
     {/if}
     
{if $rs.pics}
<tr>
<td>{$lang.product_pics}：</td>
<td class="t_left">{showFiles from=$rs.pics}
</td>
</tr>
{/if}
{if in_array($smarty.const.LANG_SET,C('LONG_LANG_TPL'))}
{assign var="properties_name" value="properties_name_de"}
{else}
{assign var="properties_name" value="properties_name"}
{/if}
    {foreach key=key item=item from=$rs.detail}
    <tr>
      <td>{$item.$properties_name}：</td>
      <td class="t_left">
      {$item.properties_value}
      </td>
    </tr>
    {/foreach}
     <tr>
      <td valign="top" class="width15">{$lang.comments}：</td>
      <td class="t_left"><p class="line_24">{$rs.comments}</p></td>
    </tr>
    <tr>
      <td valign="top" class="width15">{$lang.volume_weight_detail}：</td>
      <td class="t_left"><p class="line_24">{$rs.s_unit_volume_weight}</p></td>
    </tr>
    </tbody>
  </table>
