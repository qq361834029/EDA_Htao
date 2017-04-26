<form action="{'Profitandloss/insert'|U}" method="POST" onsubmit="return false">
{wz action="list,reset"}
<div class="add_box">
<table cellspacing="0" cellpadding="0"  class="add_table" width="99%">
    	<tbody>  
    		<tr>
    			<th>
    			<div class="titleth">
    				<div class="titlefl">{$lang.profitandloss_basic}</div>
    			</div></th>
    		</tr>
    		<tr><td>
    		<div class="basic_tb">  
    		<ul> 
	    		<li class="w320">
		    		{$lang.profitandloss_date}：
		    		<input type="hidden" name="currency_id" id="currency_id" value="{C('CURRENCY')}">
		    		<span>{$this_day}</span>
	    		</li>
				{warehouse type="li" title="仓库" hidden=["name"=>"warehouse_id","value"=>$smarty.get.w_id]  name="warehouse_name" view=true value=$w_name}
			<li>
				{$lang.stocktake_type}：
				{radio data=C('STOCKTAKE_TYPE') name="profitandloss_type"}
			</li>
			</ul>
    		</div>
    		</td></tr> 		
    		<tr>
    			<th >{$lang.stocktake_detail}</th>
    		</tr>
    	   	<tr>
	    	   <td>
	    	   {detail_table flow='Prefitandloss' from=$rs action=['add'] op_show=['add'] thead=[$lang.stocktake_no] tfoot=false}
		    	   <tr index="{$index}" class="{$none}">
						{td  width="50%" class="t_center"}
							{if $index>0}
								<input type="hidden" value="{$item.id}" name="stocktake_id[]">
							{/if}
							{$item.stocktake_no}
						{/td}
						{detail_operation 
							span=[
									['class'=>'icon icon-list-view',"onclick"=>"addTab('{"/Stocktake/view/id/`$item.id`"|U}','{"view"|title:"Stocktake"}',1)",'title'=>'查看']
								]
						}
					</tr>
				{/detail_table}
	    	   </td>
	    	</tr>
    		<tr><td class="pad_top_10">
    			<table width="100%" cellspacing="0" cellpadding="0" border="0">
					<tr>
					<td width="20%" class="t_right" valign="top">{$lang.comments}：</td>
					<td valign="top" class="t_left"><textarea id="receive_addr" class="textarea_height80" name="comments"></textarea></td>
					</tr>
			 </table>
    		</td></tr>
    	</tbody> 
    </table>
    {staff}
</div>
</form> 

