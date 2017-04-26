<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>{$lang.register_title}</title>
{literal}
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
	background-color: #5e9fd4;
}
input{ width:140px;}

body,td,th {
	font-size: 14px;
}
a:link    {color: #0086D2; text-decoration: underline;}
a:hover   {color: #FF0000; text-decoration: underline;}
a:active  {color: #0086D2; text-decoration: underline;}
a:visited  {color: #0086D2; text-decoration: underline;}
.title{
	font-size:16px;
	font-weight:bold;
}
.button{
	width:65px;
	height:27px;		
	background:url("__PUBLIC__/Images/Login/login_button.jpg");	
	margin:0px;
	border:0px;
	font-size:14px;
	color:#FFFFFF;
}
.register {	
	width:464px;
	height:423px;
	margin-left:32%;
	/*margin-top:10%;*/
	background:url("__PUBLIC__/Images/Login/register_bg.jpg");	
}
.font_red{ padding:0px 5px; color:#FF0000 !important;} /* 星号(*)样式 */
/*表单验证样式*/
.validity-tooltip {
    z-index:10;  
	position: absolute;
	display:block;
    cursor:pointer;
    border-radius:5px;
    height:22px;
    line-height:22px;
    padding:0 20px;
	color:#000000;
	font-weight: normal;
    border-style:solid;
    background-color:#FFCFC6;
	border:1px solid #EB5439;
    }
 
.validity-tooltip:hover {border-color:#FF0000;}
.validity-tooltip .validity-tooltip-outer, .validity-tooltip .validity-tooltip-inner {
    position: absolute; 
    width:0; 
    height:0; 
    border-right-width: 0;
    background:none;
    bottom:auto;
    z-index:1; }
 
.validity-tooltip .validity-tooltip-outer {	
    color:#EB5439;
    border-style:solid;
    border-top: 0px solid transparent; 
    border-bottom: 10px solid transparent;
    border-right-width:16px;
    border-right-style:solid;
    border-right-color:inherit;
    border-left-width:0px;
    top:23px;
    left:10px;}
-->
</style>
<script type="text/javascript" src="__PUBLIC__/Js/base.js"></script>
<script type="text/javascript" src="__PUBLIC__/Js/common.js"></script>
<script type="text/javascript" src="__PUBLIC__/Js/jquery.js"></script>
<script type="text/javascript" src="__PUBLIC__/Js/jquery.form.js"></script>
<script>  
window.opener=null; 
function registerSuccess(result){
	if(result.status==1){
		window.location = '__APP__';
	}else if(result.status==2){
		//validity(result.info,$("form"), '.register',-125,-20);
		validity(result.info,$("form"), '.register',0,-20);
	}else if(result.status==3){
		window.location = '__APP__'+'/Public/registerSuccess';
	}else{
		showMessage(result.info,'tips');
	}
}
$(document).ready(function(){
	$("form").sendForm({"dataType":"json","success":registerSuccess});
})


$.removeLoading = function() {
}

</script>
{/literal}
</head>
<body onLoad="document.registerForm.email.focus()">
<form name='registerForm' id="registerForm" method="POST" action="{'Public/insertFactory'|U}" onsubmit="return false">
<input type="hidden" name="comp_type" value="1">	
<input type="hidden" name="merger" value="0">		
<input type="hidden" name="freight_strategy" value="1">	
<input type="hidden" name="user_type" value="0" />
<input type="hidden" name="use_usbkey" value="0" />
<input type="hidden" name="role_id" value="{C('SELLER_ROLE_ID')}" />
<div class="register">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td width="36%" height="113">&nbsp;</td>
      <td width="64%" valign="bottom"><span class="title">{$lang.register_title}</span></td>
    </tr>
    <tr>
      <td height="10"></td>
      <td></td>
    </tr>
    <tr>
      <td height="30" align="right">{$lang.email}：</td>
      <td>
          <input type="text" name="email" id="email" autocomplete="off">__*__      </td>
    </tr>
    <tr>
      <td height="30" align="right">{$lang.full_name}：</td>
      <td>
          <input type="text" name="comp_name" id="comp_name" autocomplete="off">__*__      </td>
    </tr>	
    <tr>
		<td height="30" align="right">{$lang.nick_name}：</td>
		<td>
			<input type="text" name="nick_name" id="nick_name" class="spc_input" autocomplete="off">__*__
		</td>
	</tr>  
    <tr>
      <td height="30" align="right">{$lang.tel}：</td>
      <td>
          <input type="text" name="mobile" id="mobile" autocomplete="off">__*__      </td>
    </tr>		  
    <tr>
      <td height="30" align="right">{$lang.user_pwd}：</td>
      <td><input type="password" name="user_password" id="user_password">__*__</td>
    </tr>
    <tr>
      <td height="30" align="right">{$lang.user_confirm_password}：</td>
      <td><input type="password" name="user_password_confirm" id="user_password_confirm">__*__</td>
    </tr>	
	{captcha type="tr" title=$lang.captcha}
    <tr>
      <td height="30">&nbsp;</td>
      <td>
        <input name="button" type="submit" class="button" value="{$lang.register}" />
        <input name="sdf" type="reset" class="button" id="button" value="{$lang.reset}" />     
		&nbsp;<a href="{"/Public/login"|U}" title="{$lang.login}">{$lang.login}</a>
	  </td>
    </tr>
    <tr>
      <td height="25">&nbsp;</td>
      <td><div id='tips'></div></td>
    </tr>
  </table>
</div>
</form>
</body>
</html>