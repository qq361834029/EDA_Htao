<form action="{"User/updateFormat"|U}" method="POST">
{wz action="save"}
<div class="add_box">
<input type="hidden" name="id" id="id" value="{$rs.id}" />
<table cellspacing="0" cellpadding="0" class="add_table">
    <tbody>   
    <tr>
      <td class="width10">{$lang.user_name}：</td>
       <td class="t_left"> {$login_user.user_name}  
      </td>
    </tr>
    <tr>
      <td>{$lang.digital_format}：</td>
      	<td class="t_left"> 
     		 <input type="radio" name="digital_format" value="eur" {if $rs.digital_format=='eur'}checked{/if}>
          {$lang.europe}
          <input type="radio" name="digital_format" value="zh" {if $rs.digital_format=='zh'}checked{/if}>
          {$lang.china}__*__
     	</td>
    </tr>
    </tbody>
  </table>  
</div>
</form>
