<tr index="gls_config_{$w_id}">
    <th colspan="4">
        {$lang.gls_shipper_info}{if $item.w_name}({$item.w_name}){/if}
        <span class="icon icon-add-plus" style="display: inline-table!important;" onclick="$.addGlsConfig(this)" title="{$lang.add}{$lang.gls_shipper_info}"></span>
    </th>
</tr>
<tr>
    <td width="20%">{$lang.warehouse_name}：</td>
    <td class="t_left">
        <input value="{$item.w_id}" type="hidden" id="w_id" name="gls[{$w_id}][w_id]">
        <input value="{$item.w_name}" name="gls[{$w_id}][warehouse_name]" type='text' url="{'/AutoComplete/warehouseNameUse'|U}" jqac>
    </td>
</tr>
<tr>
    <td width="20%">ip：</td>
    <td class="t_left">
        <input class="spc_input" name="gls[{$w_id}][ip]" value="{$item.ip}" />__*__
    </td>
    <td width="20%">port：</td>
    <td class="t_left">
        <input class="spc_input" name="gls[{$w_id}][port]" value="{$item.port}" />__*__
    </td>
</tr>
<tr>
    <td width="20%">{$lang.gls_user_account}：</td>
    <td class="t_left">
        <input class="spc_input" name="gls[{$w_id}][user_account]" value="{$item.user_account}" />__*__
    </td>
    <td width="20%">{$lang.gls_receive_station_code}：</td>
    <td class="t_left">
        <input class="spc_input" name="gls[{$w_id}][receive_station_code]" value="{$item.receive_station_code}" />__*__
    </td>
</tr>
<tr>
    <td width="20%">{$lang.gls_contact_id}：</td>
    <td width="30%" class="t_left">
        <input class="spc_input" name="gls[{$w_id}][contact_id]" value="{$item.contact_id}" />__*__
    </td>
    <td width="20%">{$lang.gls_customer_id}：</td>
    <td class="t_left">
        <input class="spc_input" name="gls[{$w_id}][customer_id]" value="{$item.customer_id}" />__*__
    </td>
</tr>
<tr>
    <td width="20%">{$lang.consigner}1：</td>
    <td width="30%" class="t_left">
        <input class="spc_input" name="gls[{$w_id}][shipper_name]" value="{$item.shipper_name}" />__*__
    </td>
    <td width="20%">{$lang.consigner}2：</td>
    <td class="t_left">
        <input class="spc_input" name="gls[{$w_id}][shipper_name2]" value="{$item.shipper_name2}" />
    </td>
</tr>
<tr>
    <td width="20%">{$lang.consigner}3：</td>
    <td width="30%" class="t_left">
        <input class="spc_input" name="gls[{$w_id}][shipper_name3]" value="{$item.shipper_name3}" />
    </td>
    <td width="20%">{$lang.address}：</td>
    <td width="30%" class="t_left">
        <input class="spc_input" name="gls[{$w_id}][shipper_address]" value="{$item.shipper_address}" />__*__
    </td>
</tr>
<tr>
    <td width="20%">{$lang.country_no}：</td>
    <td class="t_left">
        <input class="spc_input" name="gls[{$w_id}][shipper_country_code]" value="{$item.shipper_country_code}" />__*__
    </td>
    <td width="20%">{$lang.postcode}：</td>
    <td class="t_left">
        <input class="spc_input" name="gls[{$w_id}][shipper_postcode]" value="{$item.shipper_postcode}" />__*__
    </td>
</tr>
<tr>
    <td width="20%">{$lang.city_name}：</td>
    <td class="t_left">
        <input class="spc_input" name="gls[{$w_id}][shipper_city]" value="{$item.shipper_city}" />__*__
    </td>
</tr>
<tr>
    <td width="20%">{$lang.track_no_interval}追踪单号生成区间：</td>
    <td class="t_left" colspan="3">
        <input class="spc_input" name="gls[{$w_id}][package_no_start]" value="{$item.package_no_start}"/>-
        <input class="spc_input" name="gls[{$w_id}][package_no_end]" value="{$item.package_no_end}"/>__*__
    </td>
</tr>