<div class="basic_tb">  
	<ul>
		<input type="hidden" name="id"  id="instock_id"  value="{$rs.id}">
		<li>{$lang.delivery_date}：
				<input type="hidden" name="delivery_date" value="{$rs.fmd_delivery_date}" />{$rs.fmd_delivery_date}
		</li>		
		<li>
		{$lang.destination}：
				<input type="hidden" name="warehouse_id" value="{$rs.warehouse_id}">{$rs.w_name}
		</li>
		<li>
			<label>{$lang.track_no}：</label>
			<input value="{$rs.track_no}" type='hidden' name="track_no" />{$rs.track_no}
		</li>
		<li>{$lang.go_date}：
				<input type="hidden" name="go_date" value="{$rs.fmd_go_date}" />{$rs.fmd_go_date}
		</li>						
		<li>
		{$lang.logistics_no}：
				<input type="hidden" name="container_no" value="{$rs.container_no}" class="spc_input" >{$rs.container_no}
		</li>
		<li>{$lang.logistics}：
			<input type="hidden" name="logistics_id" value="{$rs.logistics_id}">{$rs.logistics_name}
		</li> 		
		<li>{$lang.belongs_seller}：
		  <input type="hidden" name="factory_id" id="factory_id" onchange="" value="{$rs.factory_id}">{$rs.factory_name}
		</li>    
		<li>
		{$lang.head_way}：
				<input type="hidden" name="head_way" value="{$rs.head_way}" />{$rs.dd_head_way}
		</li>	
		<li id="container_type_obj" {if $rs.head_way neq 1}style="display: none;"{/if}>
		{$lang.container_type}：
				<input type="hidden" {if $rs.head_way eq 1}name="container_type"{/if} value="{$rs.container_type}" />
				{$rs.dd_container_type}
		</li>			
		<li>
		{$lang.is_get}：
				<input type="hidden" name="is_get" value="{$rs.is_get}" />{$rs.dd_is_get}
		</li>			
		<li id="get_address_obj" {if $rs.is_get neq 1}style="display: none;"{/if}>
		{$lang.get_address}：
				<input type="hidden" {if $rs.is_get eq 1}name="get_address"{/if} value="{$rs.edit_get_address}" />
				{$rs.edit_get_address}
		</li>			
		<li>{$lang.invoice_money}：
				<input type="hidden" name="invoice_money" value="{$rs.edml_invoice_money}" class="spc_input" />{$rs.dml_invoice_money}
		</li>
		<li>{$lang.insured_amount}：
			<input type="hidden" name="insured_amount" value="{$rs.edml_insured_amount}" class="spc_input" />{$rs.dml_insured_amount}
		</li>  
		<li>{$lang.arrive_date}：
			{if $smarty.const.ACTION_NAME eq 'view'}
				{$rs.fmd_arrive_date}
				<input type="hidden" name="arrive_date" value="{$rs.fmd_arrive_date}" class="spc_input" />
			{else}
				<input type="text" name="arrive_date" value="{$rs.fmd_arrive_date}" class="Wdate spc_input" onClick="WdatePicker()"/>
			{/if}
		</li>	
		{if $login_user.role_type!=C('SELLER_ROLE_TYPE')}
		<li style="margin: 0 45px 0 55px;">{$lang.real_arrive_date}：
			{if $smarty.const.ACTION_NAME eq 'view'}
				{$rs.fmd_real_arrive_date}
				<input type="hidden" name="real_arrive_date" value="{$rs.fmd_real_arrive_date}" class="spc_input" />
			{else}			
				<input type="text" name="real_arrive_date" value="{$rs.fmd_real_arrive_date}" class="Wdate spc_input" onClick="WdatePicker()"/>
			{/if}
		</li>			
		{/if}		
		<li>{$lang.state}：
			{if $smarty.const.ACTION_NAME eq 'view'}
				{$rs.dd_instock_type}
				<input type="hidden" name="instock_type" value="{$rs.instock_type}" class="spc_input" />
			{else}	
				{select data=C('CFG_INSTOCK_TYPE') name="instock_type" id='instock_type' value=$rs.instock_type combobox='' empty=true }__*__
			{/if}			
		</li>  	
		{if $smarty.const.ACTION_NAME neq 'view'}
		<li>{$lang.comment}：
			<input type="text" name="state_log_comments" id='state_log_comments' class="spc_input">
		</li> 		
		{/if}
	</ul>
</div>  	