{wz}
<form method="POST" action="{"StatClientDeal/index"|U}" id="search_form"> 
__SEARCH_START__
	<dl>  				
		<dt>
            <label>{$lang.client_name}：</label>
            <input type="hidden" name="client_id" >
            <input type="text" name="temp[client_name]" url="{'AutoComplete/client'|U}" jqac >
        </dt>				
		<dt>
			<label>{$lang.stop_date}：</label>
			<input type="text" name="to_order_date"  class="Wdate spc_input" onClick="WdatePicker()"/>
		</dt>  
		<dt>
			<label>{$lang.deal_days}：</label>
			<input type="text" name="undeal_days" class="spc_input"/>
		</dt> 		
		<dt>
			<label>			
			<input type="checkbox" name="never_deal" id="never_deal" value="1" > {$lang.show_never_deal}
			</label>		
		</dt>  							
			</ul> 
 __SEARCH_END__   
</form> 
{note}
<div id="print" class="width98">
{include file="StatClientDeal/list.tpl"}
</div>