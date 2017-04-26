<form action="<!--{U url="User/update"}-->" method="POST" name="System_resetPsw" onsubmit="return $.validForm(this)">
<!--{if $reload_curr_pos}--> 
<div class="nav_bg"><div class="nav"><!--{$lang.current_position}-->：<font style="font-weight:bold"><!--{$reload_curr_pos}--></font></div>
	<div class="placebutton"><ul><li>
		<input type="submit"  class="mout_input" value="<!--{$lang.submit}-->" onclick="$.setSubmitValue(this)">
	</li><li>	
		<input type="reset" class="mout_input" value="<!--{$lang.reset}-->">
	</li>
	</div>
</div>		
<div class="fill_top" id="fill_top">
</div> 
<!--{else}-->
__SAVE__
<!--{/if}-->
__TS__
<input type="hidden" name="id" id="id" value="<!--{$rs.id}-->" />
<table cellspacing="0" cellpadding="0" class="add_table">
    <tbody>   
    <tr>
      <td class="width10"><!--{$lang.user_name}-->：</td>
       <td class="t_left"> 
       		<!--{$rs.user_name}-->  
       		<input type="hidden" name="user_name" id="user_name" value="<!--{$rs.user_name}-->" />   
      </td>
    </tr>
    <tr>
      <td><!--{$lang.user_new_password}-->：</td>
      	<td class="t_left"> 
     		<input type="password" name="user_password" id="user_password" value="" class="spc_input" />__*__
     	</td>
    </tr>
    <tr>
      <td><!--{$lang.user_confirm_password}-->：</td>
      <td class="t_left"> 
     		<input type="password" name="user_password_confirm" id="user_password_confirm" value="" class="spc_input" />__*__
     </td>
    </tr>
    </tbody>
  </table>  
  __TE__
</form>