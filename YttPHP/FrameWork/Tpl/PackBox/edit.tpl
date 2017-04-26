<form action="{'PackBox/update'|U}" method="POST" onsubmit="return false">
<input type="hidden" name="id" value="{$rs.id}">
{wz action="save,list,reset"}
<div class="add_box">
<table cellspacing="0" cellpadding="0"  class="add_table" width="99%">
    	<tbody>  
    		<tr>
    			<th>
                    <div class="titleth">
                        <div class="titlefl">{$lang.pack_box_basic}<input type="hidden" id="flow" value="packBox"></div>
						<div class="afr">{$lang.pack_box_no}：{$rs.pack_box_no}</div>
                    </div>
                </th>
    		</tr>
    		<tr>
                <td>
                    <div class="basic_tb">  
                        {if !$rs.is_out_batch}
                            <li>
                                {$lang.pack_date}：<input type="text" name="pack_date" value="{$rs.pack_date}" class="Wdate spc_input" onClick="WdatePicker()"/>__*__	
                            </li>
                            {else}
                            <li>
                                {$lang.pack_date}：{$rs.pack_date}
                            </li>
                        {/if}
                        <li>
                            {$lang.warehouse}：
                            <input type="hidden" id="warehouse_id" name="warehouse_id" value="{$rs.warehouse_id}" >
                            {$rs.w_name}
                        </li>
                        {if !$rs.is_out_batch}
                            <li>
                                {$lang.package}：
                                <input type="hidden" id="package_id" name="package_id" value="{$rs.package_id}" >
                                <input type="text" name="temp[package_name]" value="{$rs.package_name}" where="warehouse_id={$rs.warehouse_id}" url="{'AutoComplete/packageNameUse'|U}" jqac />__*__
                            </li>
                            {else}
                            <li>
                                {$lang.package}：{$rs.package_name}
                            </li>
                        {/if}
                        <li>
                            {$lang.is_aliexpress}：
                            {$rs.dd_is_aliexpress}
                        </li>
                        <li>
                            <input type="hidden" id="factory_id" name="factory_id" value="{$rs.factory_id}" >
                            {$lang.factory_name}：
                            {$rs.factory_name}
                        </li>
                    </div>
                </td>
            </tr>
		<tr>
			<th colspan="4">
				{$lang.pack_box_detail}
			</th>
		</tr>
        {if !$rs.is_out_batch}
            <tr>
                <td>
                    <div class="basic_tb">  
                        <li>
                            {$lang.return_logistics_no}
                            <input value="" name="select_return_logistics_no" id="select_return_logistics_no" type='text' class="spc_input">
                        </li>
                        <li>
                            {$lang.return_track_no}
                            <input value="" name="select_return_track_no" id="select_return_track_no"  type='text' class="spc_input">
                        </li>
                        <li class="t_left">
                            <button type="button" onclick="addReturnToDetail()" class="other">{$lang.add}  </button>
                        </li>
                    </div>
                </td>
            </tr>
        {/if}
        <tr><td>{include file="PackBox/detail.tpl"}</td></tr>
{*        <tr>
            <td class="pad_top_10">
                <table width="100%" cellspacing="0" cellpadding="0" border="0">
                    <tr>
                        <td width="20%" class="t_right" valign="top">{$lang.comments}：</td>
                        <td width="80%" valign="top" class="t_left"><textarea id="receive_addr" class="textarea_height80" name="comments">{$rs.comments}</textarea></td>
                    </tr>
                </table>
    		</td>
        </tr>*}
    	</tbody> 
    </table>
    {staff add_user="`$rs.add_real_name`" create="`$rs.fmd_create_time`" id="`$rs.add_user`"}
</div>
</form> 

