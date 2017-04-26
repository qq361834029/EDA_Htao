<table cellspacing="0" cellpadding="0" class="table_autoshow">
    <tbody>
    <tr><th colspan="2">→{$lang.basic_title}</th></tr>
    <tr>
      <td class="width20">{$lang.product_no}：</td>
      <td class="t_left">{$rs.product_no}</td>
    </tr>
	<tr>
      <td class="width20">{$lang.custom_barcode}：</td>
      <td class="t_left">{$rs.custom_barcode}</td>
    </tr>
    <tr>
      <td>{$lang.product_name}：</td>
      <td class="t_left">{$rs.product_name}</td>
    </tr>
	{if $login_user.role_type != C('SELLER_ROLE_TYPE')}	
    <tr>
      <td>{$lang.factory_name}：</td>
      <td class="t_left">{$rs.factory_name}</td>
    </tr>
	{/if}
<tr><th colspan="2">→{$lang.propre_title}</th></tr>
<tr>
<td>{$lang.cube}：</td>
<td class="t_left">{$rs.s_unit_cube}</td>
</tr>
<tr>
<td>{$lang.weight}：</td>
<td class="t_left">{$rs.s_unit_weight}
</td>
</tr>
<tr>
<td>{$lang.check_cube}：</td>
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
      <td valign="top">{$lang.comments}：</td>
      <td class="t_left"><p class="line_24">{$rs.comments}</p></td>
    </tr>
    </tbody>
  </table>
