<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html>
<head>
<title>页面提示</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv='Refresh' content='{$waitSecond};URL={$jumpUrl}'>
<style>
html, body{ margin:0; padding:0; border:0 none;font:14px Tahoma,Verdana;line-height:150%;background:white}
a{ text-decoration:none; color:#174B73; border-bottom:1px dashed gray}
a:hover{ color:#F60; border-bottom:1px dashed gray}
div.message{ margin:10% auto 0px auto;clear:both;padding:5px;border:1px solid silver; text-align:center; width:45%}
span.wait{ color:blue;font-weight:bold}
span.error{ color:red;font-weight:bold}
span.success{ color:blue;font-weight:bold}
div.msg{ margin:20px 0px}
</style>
<script type="text/javascript">
var timer	= window.setInterval("Countdown()", 1000);
function Countdown(){
	var s = document.getElementById('wiatetime');
	if (s && s.innerHTML > 1) {
		s.innerHTML = s.innerHTML * 1 - 1;
	} else {
		document.getElementById('tip') . innerHTML	= "正在跳转中...";
		clearInterval(timer);
	}
}
</script>
</head>
<body>
<div class="message">
	<div class="msg">
	{if isset($message)}
		<span class="success">{$msgTitle}{$message}</span>
	{else}
		<span class="error">{$msgTitle}{$error}</span>
	{/if}
	</div>
	<div class="tip" id="tip">
	{if isset($closeWin)}
		页面将在 <span id="wiatetime" class="wait">{$waitSecond}</span> 秒后自动关闭，如果不想等待请点击 <a href="{$jumpUrl}">这里</a> 关闭
	{else}
		页面将在 <span id="wiatetime" class="wait">{$waitSecond}</span> 秒后自动跳转，如果不想等待请点击 <a href="{$jumpUrl}">这里</a> 跳转
	{/if}
	</div>
</div>
</body>
</html>