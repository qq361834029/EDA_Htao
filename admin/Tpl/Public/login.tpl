<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>后台管理登录</title>
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
	height:323px;
	margin-left:32%;
	margin-top:10%;	
	background:url("__PUBLIC__/Images/Login/login_bg.jpg");	
}
-->
</style>
<script type="text/javascript" src="__PUBLIC__/Js/base.js"></script>
<script type="text/javascript" src="__PUBLIC__/Js/common.js"></script>
<script type="text/javascript" src="__PUBLIC__/Js/jquery.js"></script>
<script type="text/javascript" src="__PUBLIC__/Js/jquery.form.js"></script>
<script>  
window.opener=null;
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
<form name='loginForm' id="loginForm" method="POST" action="{'Public/checkLogin'|U}">
<div class="login">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td width="36%" height="113">&nbsp;</td>
      <td width="64%" valign="bottom"><span class="title">后台管理登陆</span></td>
    </tr>
    <tr>
      <td height="10"></td>
      <td></td>
    </tr>
    <tr>
      <td height="30" align="right">登录名：</td>
      <td>
          <input type="text" name="user_name" id="user_name" autocomplete="off">      </td>
    </tr>
    <tr>
      <td height="30" align="right">密码：</td>
      <td><input type="password" name="password" id="password"></td>
    </tr>
    <tr>
      <td height="51">&nbsp;</td>
      <td>
        <input name="button" type="submit" class="button" value="登录" />
        <input name="sdf" type="reset" class="button" id="button" value="重置" />      </td>
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