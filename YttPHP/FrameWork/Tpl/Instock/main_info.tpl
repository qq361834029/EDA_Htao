<div class="basic_tb">  
	<ul> 
		<li>{$lang.delivery_date}：
				<input type="text" name="delivery_date" value="{$rs.fmd_delivery_date|default:$this_day}" class="Wdate spc_input" onClick="WdatePicker()"/>__*__
		</li>		
		<li>
		{$lang.destination}：
		{if $login_user.role_type == C('SELLER_ROLE_TYPE')}
			<input type="hidden" name="warehouse_id" value="{$rs.warehouse_id}">
			<input name="temp[w_name]" url="{'AutoComplete/saleWarehouse'|U}" value="{$rs.w_name}" jqac />__*__	
			
		{elseif $w_id > 0}
			<input type="hidden" name="warehouse_id" value="{$rs.warehouse_id|default:$w_id}">
			<input name="temp[w_name]" url="{'AutoComplete/saleWarehouse'|U}" value="{$rs.w_name|default:$w_name}" disabled="disabled" class="spc_input disabled" />__*__	
		{else}
			<input type="hidden" name="warehouse_id" value="{$rs.warehouse_id|default:$w_id}">
			<input name="temp[w_name]" url="{'AutoComplete/saleWarehouse'|U}" value="{$rs.w_name|default:$w_name}" class="spc_input" jqac />__*__				
		{/if}				
		</li>
		<li>
			<label>{$lang.track_no}：</label>
			<input value="{$rs.track_no}" type='text' name="track_no" class="spc_input">
		</li>
		<li>{$lang.go_date}：
				<input type="text" name="go_date" value="{$rs.fmd_go_date|default:$this_day}" class="Wdate spc_input" onClick="WdatePicker()"/>__*__
		</li>		
		<li>
		{$lang.logistics_no}：
				<input type="text" name="container_no" value="{$rs.container_no}" class="spc_input" >__*__
		</li>
		<li>{$lang.logistics}：
			<input type="hidden" name="logistics_id" value="{$rs.logistics_id}">
				<input name="temp[trans_comp]" value="{$rs.logistics_name}" url="{'AutoComplete/logistics'|U}" jqac />{if C("instock.instock_logistics_funds")==1}__*__{/if}
		</li> 		
		{if $login_user.role_type != C('SELLER_ROLE_TYPE')}
		<li>{$lang.belongs_seller}：
		  <input type="hidden" name="factory_id" id="factory_id" onchange="{if $rs}setFacProduct(this){/if}" value="{$rs.factory_id}">
		  <input id="factory_name" name="temp[factory_name]" value="{$rs.factory_name}" url="{'/AutoComplete/factoryEmail'|U}" jqac>__*__
		</li>    
		{else}
			<input type="hidden" name="factory_id" id="factory_id" value="{$rs.factory_id|default:$fac_id}">
		{/if}	
		<li>
		{if $rs}
			{assign var="head_way" value=$rs.head_way}
		{else}
			{assign var="head_way" value=1}
		{/if}
		{$lang.head_way}：
				{radio data=C('TRANSPORT_TYPE') name="head_way" id="head_way" value="{$rs.head_way}" initvalue=$head_way onclick="changeDisplayStatus(this.value, 'container_type', true);limitColor();"}
		</li>		
		<li id="container_type_obj" {if $head_way neq 1}style="display: none;"{/if}>
		{$lang.container_type}：
			{if $head_way eq 1}{assign var="container_type" value="container_type"}{/if}
			{select data=C('CFG_CONTAINER_TYPE') empty=true id="container_type" name="$container_type" combobox="" value="{$rs.container_type}"}__*__
		</li>		
		{if $rs}
			{assign var="is_get" value=$rs.is_get}
		{else}
			{assign var="is_get" value=2}
		{/if}		
		<li>
		{$lang.is_get}：
				{radio data=C('IS_GET') name="is_get" value="{$rs.is_get}" initvalue=$is_get onclick="changeDisplayStatus(this.value, 'get_address')"}
		</li>			
		<li id="get_address_obj" {if $is_get neq 1}style="display: none;"{/if}>
		{$lang.get_address}：
		<input type="text" id="get_address" value="{$rs.edit_get_address}"  {if $is_get eq 1}name="get_address"{/if} class="spc_input" >__*__
		</li>			
		<li>{$lang.invoice_money}：
				<input type="text" name="invoice_money" value="{$rs.edml_invoice_money}" class="spc_input" />
		</li>
		<li>{$lang.insured_amount}：
			<input type="text" name="insured_amount" value="{$rs.edml_insured_amount}" class="spc_input" />
		</li>  
		<li>{$lang.arrive_date}：
				<input type="text" name="arrive_date" value="{$rs.fmd_arrive_date}" class="Wdate spc_input" onClick="WdatePicker()"/>
		</li>			
	</ul>
</div>  	