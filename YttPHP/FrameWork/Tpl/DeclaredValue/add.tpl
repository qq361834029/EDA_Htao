<form action="{'DeclaredValue/insert'|U}" method="POST" onsubmit="return false">
{wz action="save,list,reset"}
<input type="hidden" name="from_type" value="DeclaredValue">
<div class="add_box">
<table cellspacing="0" cellpadding="0"  class="add_table" width="99%">
    	<tbody>  
		<tr>
			<th colspan="4">
				{$lang.modify_detail}
			</th>
		</tr>
    		   
    	   <tr><td>{include file="DeclaredValue/detail.tpl"}</td></tr>
    	</tbody> 
    </table>
    {staff}
</div>
</form> 

