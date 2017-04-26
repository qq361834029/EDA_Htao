<div class="basic_tb">  
	<ul> 
		<li>{$lang.go_date}：
				{$rs.fmd_go_date}
		</li>		
		<li>
		{$lang.destination}：
				{$rs.w_name}
		</li>
		<li>
			<label>{$lang.track_no}：</label>
			{$rs.track_no}
		</li>
		<li>{$lang.go_date}：
				{$rs.fmd_go_date}
		</li>						
		<li>
		{$lang.logistics_no}：
				{$rs.container_no}
		</li>
		<li>{$lang.logistics}：
			{$rs.logistics_name}
		</li> 		
		<li>{$lang.belongs_seller}：
		  {$rs.factory_name}
		</li>    
		<li>
		{$lang.head_way}：
				{$rs.dd_head_way}
		</li>	
		<li id="container_type_obj" {if $rs.head_way neq 1}style="display: none;"{/if}>
		{$lang.container_type}：
				{$rs.dd_container_type}
		</li>			
		<li>
		{$lang.is_get}：
				{$rs.dd_is_get}
		</li>			
		<li id="get_address_obj" {if $rs.is_get neq 1}style="display: none;"{/if}>
		{$lang.get_address}：
				
				{$rs.edit_get_address}
		</li>			
		<li>{$lang.invoice_money}：
				{$rs.dml_invoice_money}
		</li>
		<li>{$lang.insured_amount}：
			{$rs.dml_insured_amount}
		</li>  
		<li>{$lang.arrive_date}：
				{$rs.fmd_arrive_date}
		</li>	
        <li>{$lang.real_arrive_date}:
            {$rs.fmd_real_arrive_date}
        </li>
		<li>{$lang.state}：
				{$rs.dd_instock_type}
		</li>
		{if $login_user.role_type!=C('SELLER_ROLE_TYPE')}
		<li>{$lang.storage_date}：
			{if $smarty.const.ACTION_NAME eq 'view'}
				{$rs.storage_date}
				<input type="hidden" name="storage_date" value="{$rs.storage_date}" class="spc_input" />
			{else}			
				<input type="text" name="storage_date" value="{$rs.storage_date}" class="Wdate spc_input" onClick="WdatePicker()"/>__*__
			{/if}
		</li>		
		{/if}	        
	</ul>
</div>  	