<form action="{'LoadContainer/update'|U}" method="POST" onsubmit="return false">
<input type="hidden" name="id" value="{$rs.id}">
{wz}
<div class="add_box">
<table cellspacing="0" cellpadding="0"  class="add_table" width="99%">
    	<tbody>  
    		<tr>
    			<th>
    			<div class="titleth">
    				<div class="titlefl">{$lang.load_container_basic}</div>
    				<div class="afr">{$lang.load_container_no}：{$rs.load_container_no}</div>
    			</div></th>
    		</tr>
    		<tr><td>
    		<div class="basic_tb">  
    		<ul> 
    		<li>{$lang.container_no}：{$rs.container_no}</li>
    <li>{$lang.trans_comp}：{$rs.logistics_name}</li>
   <li>{$lang.load_date}：{$rs.fmd_load_date}</li>
    <li>{$lang.delivery_date}：{$rs.fmd_delivery_date}</li>
     <li>{$lang.expect_arrive_date}：{$rs.fmd_expect_arrive_date}</li>
    		</ul>
    		</div>
    		</td></tr>
    		<tr>
    			<th >{$lang.load_container_detail}</th>
    		</tr>
    	   <tr><td>
			{include file="LoadContainer/detail.tpl"}
			</td></tr>
	
    		<tr><td class="pad_top_10">
    			<table width="100%" cellspacing="0" cellpadding="0" border="0">
					<tr>
					<td width="15%" class="t_right" valign="top">{$lang.comments}：</td>
					<td width="35%" valign="top" class="t_left">{$rs.edit_comments}</td>
					<td>
					{include file="LoadContainer/factoryTotal.tpl"}
				</td>
				</tr>
			 </table>
    		</td></tr>
    	</tbody> 
    </table>
    {staff add_user="`$rs.add_real_name`" create="`$rs.fmd_create_time`" id="`$rs.add_user`"}
</div>
</form> 

