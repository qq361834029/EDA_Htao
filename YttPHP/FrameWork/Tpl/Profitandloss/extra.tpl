<form action="{'Profitandloss/update'|U}" method="POST" onsubmit="return false">
<input type="hidden" name="id" value="{$rs.id}">
{wz action="list,reset"}
<div class="add_box">
<table cellspacing="0" cellpadding="0"  class="add_table" width="99%">
    	<tbody>  
    		<tr>
    			<th>
    			<div class="titleth">
    				<div class="titlefl">{$lang.profitandloss_basic}</div>
    				<div class="afr">{$lang.profitandloss_no}：{$rs.profitandloss_no}</div>
    			</div></th>
    		</tr>
    		<tr><td>
    		<div class="basic_tb">  
    		<ul> 
    		<li class="w320">
	    		{$lang.profitandloss_no}：{$rs.profitandloss_no}
    		</li>
    		{warehouse type="li" title=$lang.warehouse hidden=["name"=>"warehouse_id","value"=>$rs.warehouse_id]  name="warehouse_name" view="true" value=$rs.w_name}
    		<li>
    		{$lang.profitandloss_date}：{$rs.profitandloss_date}
    		</li>
    		<li>
    			{$lang.stocktake_type}：
    			<input type="hidden" name="profitandloss_type" value="{$rs.profitandloss_type}">{$rs.dd_profitandloss_type}
    		</li>
    		<li>{$lang.currency}：{$rs.currency_no}</li>
    		<li></li>
    		</ul>
    		</div>
    		</td></tr> 		
    		<tr>
    			<th >{$lang.profitandloss_detail}</th>
    		</tr>
    	   <tr><td>{include file="Profitandloss/detail.tpl"}</td></tr>
	
    		<tr><td class="pad_top_10">
    			<table width="100%" cellspacing="0" cellpadding="0" border="0">
					<tr>
					<td width="20%" class="t_right" valign="top">注意事项：</td>
					<td valign="top" class="t_left">{$rs.edit_comments}</td>
					</tr>
			 </table>
    		</td></tr>
    	</tbody> 
    </table>
    {staff add_user="`$rs.add_real_name`" create="`$rs.fmd_create_time`" id="`$rs.add_user`"}
</div>
</form> 

