{wz}
<div id="print">
<div class="add_box">
<table cellspacing="0" cellpadding="0" class="add_table">
    <tbody>
    <tr><th colspan="2">{$lang.basic_title}</th></tr>
    <tr>
      <td class="width15">{$lang.id}：</td>
      <td class="t_left">{$rs.id}</td>
    </tr>	
    <tr>
      <td class="width15">{$lang.product_no}：</td>
      <td class="t_left">{$rs.product_no}</td>
    </tr>
    <tr>
      <td>{$lang.product_name}：</td>
      <td class="t_left">{$rs.product_name}</td>
    </tr>
	{if $login_user.role_type != C('SELLER_ROLE_TYPE')}
    <tr>
      <td>{$lang.belongs_seller}：</td>
      <td class="t_left">{$rs.factory_name}</td>
    </tr>
	{/if}
    <tr>
      <td>{$lang.custom_barcode}：</td>
      <td class="t_left">
          {$rs.custom_barcode}
      </td>
    </tr>
    <tr><th colspan="2">{$lang.propre_title}</th></tr>
<tr>
<td>{$lang.product_size}：</td>
<td class="t_left">{$rs.s_unit_cube}</td>
</tr>
<tr>
<td>{$lang.weight}：</td>
<td class="t_left">{$rs.s_unit_weight}
</td>
</tr>
<tr>
<td>{$lang.volume_weight}：</td>
<td class="t_left">{$rs.s_unit_volume_weight}
</td>
</tr>
<tr>
<td>{$lang.storage_remind}：</td>
<td class="t_left">
{$rs.warning_quantity}
</td>
</tr>
<tr>
<td>{$lang.check_product_size}：</td>
<td class="t_left">{$rs.s_unit_check_cube}</td>
</tr>
<tr>
<td>{$lang.check_weight}：</td>
<td class="t_left">{$rs.s_unit_check_weight}
</td>
</tr>
<tr>
<td>{$lang.check_status}：</td>
<td class="t_left">{$rs.dd_check_status}
</td>


</tr>
{if $login_user.role_type != C('SELLER_ROLE_TYPE')}
<tr>
<td valign="top">{$lang.check_comments}：</td>
<td class="t_left">{$rs.edit_check_comments}
</td>
</tr>
{/if}
{if C('PRODUCT_COLOR')==1 && C('PRODUCT_SIZE')==1 && C('PRODUCT_FIT')==1}
<tr>
<td>{$lang.fit}：</td>
<td class="t_left">
<div class="product_width">{html_fit class="fit" value="`$rs.fit`" readonly="true"}</div>
</td>
</tr>
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
      <td valign="top">{$lang.import_sku}：</td>
      <td class="t_left">
      {$rs.product_sku.0}&nbsp;
      {$rs.product_sku.1}&nbsp;
      {$rs.product_sku.2}&nbsp;
      {$rs.product_sku.3}&nbsp;
      {$rs.product_sku.4}&nbsp;
      </td>
    </tr>
     <tr>
      <td valign="top">{$lang.comments}：</td>
      <td class="t_left"><p class="line_24">{$rs.view_comments}</p></td>
    </tr>
    </tbody>
  </table>
  </div> 
