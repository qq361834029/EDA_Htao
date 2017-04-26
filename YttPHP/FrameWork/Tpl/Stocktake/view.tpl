<form action="{'Stocktake/insert'|U}" method="POST" onsubmit="return false">
{wz}
<div class="add_box">
<table cellspacing="0" cellpadding="0"  class="add_table" width="99%">
    	<tbody>  
    		<tr>
    			<th>
    			<div class="titleth">
    				<div class="titlefl">{$lang.stocktake_basic}</div>
    				<div class="afr">{$lang.stocktake_no}：{$rs.stocktake_no}</div>
    			</div></th>
    		</tr>
    		<tr><td>
    		<div class="basic_tb">  
    		<ul> 
    		<li class="w320">
	    		{$lang.stocktake_employee}：{$rs.employee_name}
    		</li>
			{warehouse type="li" title=$lang.warehouse hidden=["name"=>"warehouse_id",'value'=>$rs.warehouse_id]  name="warehouse_name" view="true" value=$rs.w_name}
    		<li>{$lang.stocktake_date}：{$rs.stocktake_date}</li>
    		</ul>
    		</div>
    		</td></tr> 		
    		<tr>
    			<th >{$lang.stocktake_detail}</th>
    		</tr>
    	   <tr><td>{include file="Stocktake/detail.tpl"}</td></tr>
	
    		<tr><td class="pad_top_10">
    			<table width="100%" cellspacing="0" cellpadding="0" border="0">
					<tr>
					<td width="20%" class="t_right" valign="top">{$lang.comments}：</td>
					<td valign="top" class="t_left">{$rs.comments}</td>
					</tr>
			 </table>
    		</td></tr>
    	</tbody> 
    </table>
    {staff add_user="`$rs.add_real_name`" create="`$rs.fmd_create_time`" id="`$rs.add_user`"}
</div>
</form> 

