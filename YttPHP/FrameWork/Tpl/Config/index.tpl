<form action="{'Config/index'|U}" method="POST"  onsubmit="return false">
<input type="hidden" name="config_type" value="config">
{wz action="save,reset"}
<div class="add_box">
<table cellspacing="0" border="0" cellpadding="0" class="add_table" >
    <tbody>
    <tr>
        <th colspan="4">{$lang.dhl_shipper_info}</th>
    </tr>
    <tr>
        <td width="20%">{$lang.basic_name}1：</td>
        <td width="30%" class="t_left">
            <input class="spc_input" name="dhl_shipper_name1" value="{C('DHL_SHIPPER_NAME1')}" />__*__
        </td>
        <td width="20%">{$lang.basic_name}2：</td>
        <td class="t_left">
            <input class="spc_input" name="dhl_shipper_name2" value="{C('DHL_SHIPPER_NAME2')}" />
        </td>
    </tr>
    <tr>
        <td width="20%">{$lang.street_name}：</td>
        <td width="30%" class="t_left">
            <input class="spc_input" name="dhl_shipper_streetname" value="{C('DHL_SHIPPER_STREETNAME')}" />__*__
        </td>
        <td width="20%">{$lang.house_number}：</td>
        <td class="t_left">
            <input class="spc_input" name="dhl_shipper_streetnumber" value="{C('DHL_SHIPPER_STREETNUMBER')}" />__*__
        </td>
    </tr>
    <tr>
        <td width="20%">{$lang.postcode}：</td>
        <td width="30%" class="t_left">
            <input class="spc_input" name="dhl_shipper_post_code" value="{C('DHL_SHIPPER_POST_CODE')}" />__*__
        </td>
        <td width="20%">{$lang.city}：</td>
        <td class="t_left">
            <input class="spc_input" name="dhl_shipper_city" value="{C('DHL_SHIPPER_CITY')}" />__*__
        </td>
    </tr>
    <tr>
        <td width="20%">{$lang.country_name}：</td>
        <td width="30%" class="t_left">
            <input type="hidden" name="dhl_shipper_country_id" value="{C('DHL_SHIPPER_COUNTRY_ID')}" />
            <input url="{'AutoComplete/country'|U}" value="{Sonly('country', C('DHL_SHIPPER_COUNTRY_ID'), 'full_country_name')}" jqac />__*__
        </td>
        <td width="20%">{$lang.contact}：</td>
        <td class="t_left">
            <input class="spc_input" name="dhl_shipper_contact" value="{C('DHL_SHIPPER_CONTACT')}" />
        </td>
    </tr>
    <tr>
        <td width="20%">{$lang.phone}：</td>
        <td width="30%" class="t_left">
            <input class="spc_input" name="dhl_shipper_phone" value="{C('DHL_SHIPPER_PHONE')}" />
        </td>
        <td width="20%">{$lang.email}：</td>
        <td class="t_left">
            <input class="spc_input" name="dhl_shipper_email" value="{C('DHL_SHIPPER_EMAIL')}" />
        </td>
    </tr>
    <tr>
        <td width="20%">{$lang.fax}：</td>
        <td width="30%" class="t_left">
            <input class="spc_input" name="dhl_shipper_fax" value="{C('DHL_SHIPPER_FAX')}" />
        </td>
        <td width="20%">{$lang.mobile}：</td>
        <td class="t_left">
            <input class="spc_input" name="dhl_shipper_mobile" value="{C('DHL_SHIPPER_MOBILE')}" />
        </td>
    </tr>
    <tr>
        <th colspan="4">{$lang.dhl_request_time_limit}</th>
    </tr>
    <tr>
        <td width="20%">{$lang.dhl_request_time_limit_day}：</td>
        <td class="t_left" colspan="3">
            {html_select_time time=['dhl_limit_day_start_Hour' => C('DHL_LIMIT_DAY_START_HOUR'), 'dhl_limit_day_start_Minute' => C('DHL_LIMIT_DAY_START_MINUTE')] minute_interval=5 display_seconds=false field_separator=' : ' prefix='dhl_limit_day_start_' style="width: 40px;"} -
            {html_select_time time=['dhl_limit_day_end_Hour' => C('DHL_LIMIT_DAY_END_HOUR'), 'dhl_limit_day_end_Minute' => C('DHL_LIMIT_DAY_END_MINUTE')] minute_interval=5 display_seconds=false field_separator=' : ' prefix='dhl_limit_day_end_' style="width: 40px;"}
        </td>
    </tr>
    <tr>
        <td width="20%">{$lang.dhl_request_time_limit_week}：</td>
        <td class="t_left" colspan="3">
            {html_select_week name='dhl_limit_week_start' value=C('DHL_LIMIT_WEEK_START') style="width: 60px;"} {html_select_time time=['dhl_limit_week_start_Hour' => C('DHL_LIMIT_WEEK_START_HOUR'), 'dhl_limit_week_start_Minute' => C('DHL_LIMIT_WEEK_START_MINUTE')] minute_interval=5 display_seconds=false field_separator=' : ' prefix='dhl_limit_week_start_' style="width: 40px;"} -
            {html_select_week name='dhl_limit_week_end' value=C('DHL_LIMIT_WEEK_END') style="width: 60px;"} {html_select_time time=['dhl_limit_week_end_Hour' => C('DHL_LIMIT_WEEK_END_HOUR'), 'dhl_limit_week_end_Minute' => C('DHL_LIMIT_WEEK_END_MINUTE')] minute_interval=5 display_seconds=false field_separator=' : ' prefix='dhl_limit_week_end_' style="width: 40px;"}
        </td>
    </tr>
    <tr>
        <th colspan="4">{$lang.correos_shipper_info}</th>
    </tr>
    <tr>
        <td width="20%">{$lang.basic_name}：</td>
        <td width="30%" class="t_left">
            <input class="spc_input" name="correos_shipper_name" value="{C('CORREOS_SHIPPER_NAME')}" />__*__
        </td>
        <td width="20%">{$lang.city}：</td>
        <td class="t_left">
            <input class="spc_input" name="correos_shipper_city" value="{C('CORREOS_SHIPPER_CITY')}" />__*__
        </td>
    </tr>
    <tr>
        <td width="20%">{$lang.postcode}：</td>
        <td width="30%" class="t_left">
            <input class="spc_input" name="correos_shipper_post_code" value="{C('CORREOS_SHIPPER_POST_CODE')}" />__*__
        </td>
        <td width="20%">{$lang.street_name}：</td>
        <td width="30%" class="t_left">
            <input class="spc_input" name="correos_shipper_streetname" value="{C('CORREOS_SHIPPER_STREETNAME')}" />__*__
        </td>
    </tr>
    <tr>
        <td width="20%">{$lang.house_number}：</td>
        <td class="t_left">
            <input class="spc_input" name="correos_shipper_streetnumber" value="{C('CORREOS_SHIPPER_STREETNUMBER')}" />
        </td>
        <td width="20%">{$lang.province}：</td>
        <td class="t_left">
            <input class="spc_input" name="correos_shipper_province" value="{C('CORREOS_SHIPPER_PROVINCE')}" />
        </td>
    </tr>
    <tr>
        <td width="20%">{$lang.contact}：</td>
        <td class="t_left">
            <input class="spc_input" name="correos_shipper_contact" value="{C('CORREOS_SHIPPER_CONTACT')}" />
        </td>
        <td width="20%">{$lang.email}：</td>
        <td class="t_left">
            <input class="spc_input" name="correos_shipper_email" value="{C('CORREOS_SHIPPER_EMAIL')}" />
        </td>
    </tr>
    <tr>
        <td width="20%">{$lang.phone}：</td>
        <td width="30%" class="t_left">
            <input class="spc_input" name="correos_shipper_phone" value="{C('CORREOS_SHIPPER_PHONE')}" />
        </td>
        <td width="20%">{$lang.mobile}：</td>
        <td class="t_left">
            <input class="spc_input" name="correos_shipper_mobile" value="{C('CORREOS_SHIPPER_MOBILE')}" />
        </td>
    </tr>
    <tr>
        <th colspan="4">{$lang.correos_request_time_limit}</th>
    </tr>
    <tr>
        <td width="20%">{$lang.correos_request_time_limit_day}：</td>
        <td class="t_left" colspan="3">
            {html_select_time time=['correos_limit_day_start_Hour' => C('CORREOS_LIMIT_DAY_START_HOUR'), 'correos_limit_day_start_Minute' => C('CORREOS_LIMIT_DAY_START_MINUTE')] minute_interval=5 display_seconds=false field_separator=' : ' prefix='correos_limit_day_start_' style="width: 40px;"} -
            {html_select_time time=['correos_limit_day_end_Hour' => C('CORREOS_LIMIT_DAY_END_HOUR'), 'correos_limit_day_end_Minute' => C('CORREOS_LIMIT_DAY_END_MINUTE')] minute_interval=5 display_seconds=false field_separator=' : ' prefix='correos_limit_day_end_' style="width: 40px;"}
        </td>
    </tr>
    <tr>
        <td width="20%">{$lang.correos_request_time_limit_week}：</td>
        <td class="t_left" colspan="3">
            {html_select_week name='correos_limit_week_start' value=C('CORREOS_LIMIT_WEEK_START') style="width: 60px;"} {html_select_time time=['correos_limit_week_start_Hour' => C('CORREOS_LIMIT_WEEK_START_HOUR'), 'correos_limit_week_start_Minute' => C('CORREOS_LIMIT_WEEK_START_MINUTE')] minute_interval=5 display_seconds=false field_separator=' : ' prefix='correos_limit_week_start_' style="width: 40px;"} -
            {html_select_week name='correos_limit_week_end' value=C('CORREOS_LIMIT_WEEK_END') style="width: 60px;"} {html_select_time time=['correos_limit_week_end_Hour' => C('CORREOS_LIMIT_WEEK_END_HOUR'), 'correos_limit_week_end_Minute' => C('CORREOS_LIMIT_WEEK_END_MINUTE')] minute_interval=5 display_seconds=false field_separator=' : ' prefix='correos_limit_week_end_' style="width: 40px;"}
        </td>
    </tr>
    {foreach from=$gls_config key=w_id item=item}
        {include file="Config/gls_config.tpl"}
    {/foreach}
    </tbody>
  </table>
    </div>
  </form>
