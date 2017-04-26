{wz is_update=$rs.is_update}
<div class="add_box">
<table cellspacing="0" cellpadding="0"  class="add_table" width="99%">
    <input type="hidden" name="step" value="2">
    	<tbody>  
    		<tr>
    			<th>
                    <div class="titleth">
                        <div class="titlefl">{$lang.warehouse_account_basic}<input type="hidden" id="flow" value="warehouse_account"></div>
                    </div>
                </th>
    		</tr>
    		<tr>
			<td>
	    		<div class="basic_tb">  
	    		<ul> 
                    <li>
                        {$lang.balance_date}：
                        <input type="hidden" name="account_date" value="{$rs.account_date}" class="Wdate spc_input"/>	
                        {$rs.account_date}
                    </li>
                    <li id="li_factory">
                        {$lang.belongs_seller}：
                        <input type="hidden" name="factory_id" id="factory_id" value="{$rs.factory_id}">
                        {$rs.factory_name}
                    </li>
                    <li id="li_warehouse">
                        {$lang.belongs_warehouse}：
                        <input id="warehouse_id" type="hidden" name="warehouse_id" value="{$rs.warehouse_id}" class="valid-required">
                        {$rs.w_name}
                    </li>	
                    <li id="show_w_currency">{$lang.currency}:{$rs.currency_no}</li>
                </ul>
			</div>
			</td>
		</tr>
        <tr>
            <th>
                <div class="titleth">
                    <div class="titlefl">{$lang.warehouse_account_detail}</div>
                </div>
            </th>
        </tr>
        <tr>
            <div>
                {include file="WarehouseAccount/account_list.tpl"}
            </div>
        </tr>
    	</tbody> 
    </table>
</div>