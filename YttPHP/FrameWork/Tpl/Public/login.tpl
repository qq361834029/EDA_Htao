<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>{$lang.login_title}</title>
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
.login {	
	width:464px;
	height:360px;
	margin-left:32%;
	margin-top:10%;	
	background:url("__PUBLIC__/Images/Login/login_bg_new.jpg");	
}
a:link    {color: #0086D2; text-decoration: underline;}
a:hover   {color: #FF0000; text-decoration: underline;}
a:active  {color: #0086D2; text-decoration: underline;}
a:visited  {color: #0086D2; text-decoration: underline;}
.font_red{ padding:0px 5px; color:#FF0000 !important;} /* 星号(*)样式 */
-->
</style>
<script type="text/javascript" src="__PUBLIC__/Js/base.js"></script>
<script type="text/javascript" src="__PUBLIC__/Js/common.js"></script>
<script type="text/javascript" src="__PUBLIC__/Js/jquery.js"></script>
<script type="text/javascript" src="__PUBLIC__/Js/jquery.form.js"></script>
<script>  
window.opener=null;
function checkEpass(){ 
	try{
		var ePass_rights;
		ePass_rights = new ActiveXObject("FT_ND_SC.ePsM8SC.1");
		//打开社别
		ePass_rights.OpenDevice(1,"");
		// 获取usbkey中的data数据
		ePass_rights.OpenFile(0,3);
		var fileLen 	= ePass_rights.GetFileInfo(0,3,3,0);
		var epass_data = ePass_rights.Read(0,0,0,fileLen);
		//获取KEY的硬件序列号，其内容是唯一的
		ePassSN = ePass_rights.GetStrProperty(7,0,0);  
		if(ePassSN!=''){$("#epass_no").val(ePassSN)	}
		if(epass_data!=''){	$("#epass_data").val(epass_data)}
	}catch(error){
	
	}	 
} 
function login(result){
	
	if(result.status==1){
		window.location = '__APP__';
	}else{
		showMessage(result.info,'tips');
	}
}
$(document).ready(function(){
	$("form").sendForm({"dataType":"json","success":login});
})
</script>
{/literal}
</head>
<body onLoad="document.loginForm.user_name.focus()">
<form name='loginForm' id="loginForm" method="POST" action="{'Public/checkLogin'|U}" onsubmit="checkEpass();">
<div class="login">
  <table width="100%" border="0" cellspacing="0" cellpadding="0" {if $smarty.const.LANG_SET == 'it'}style="margin-left: 22px;"{/if}>
    <tr>
      <td width="36%" height="113">&nbsp;</td>
      <td width="64%" valign="bottom"><span class="title">{$lang.login_title}</span></td>
    </tr>
    <tr>
      <td height="10"></td>
      <td></td>
    </tr>
    <tr>
      <td height="30" align="right">{$lang.email}：</td>
      <td>
          <input type="text" name="user_name" id="user_name" autocomplete="off">      </td>
    </tr>
    <tr>
      <td height="30" align="right">{$lang.user_pwd}：</td>
      <td><input type="password" name="password" id="password"></td>
    </tr>
    {captcha type="tr" title=$lang.captcha}	  
    <tr>
      <td height="30" align="right">&nbsp;</td>
      <td><a href="{"/Public/forgotPassword"|U}" title="{$lang.forgot_password}">{$lang.forgot_password}</a></td>
    </tr>	  
    <tr>
      <td height="51">&nbsp;</td>
      <td>
        <input name="button" 		type="submit" class="button" value="{$lang.login}" />
        <input name="epass_data" 	type="hidden" id="epass_data" 	value="" />
        <input name="epass_no" 		type="hidden" id="epass_no" 	value="" />
        <input name="sdf" type="reset" class="button" id="button" value="{$lang.reset}" /> 
		&nbsp;<a href="{"/Public/register"|U}" title="{$lang.register}">{$lang.register}</a>
	  </td>
    </tr>
    <tr>
      <td height="25">&nbsp;</td>
      <td style="position:relative; left:-50px;"><div id='tips'></div></td>
    </tr>
  </table>
</div>
</form>
</body>
</html>