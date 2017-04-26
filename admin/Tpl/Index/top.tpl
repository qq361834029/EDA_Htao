<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>『友拓通－管理平台』</title>
<link rel='stylesheet' type='text/css' href='__PUBLIC__/Css/admin.css'>
<base target="main" />
<style type="text/css">
body{ width:100%;}
</style>
</head>
<body>
<!-- 头部区域 -->
<div id="header" class="header">
<div class="headTitle" style="margin:8pt 10pt"> 管理平台 </div>
	<!-- 功能导航区 -->
	<div class="topmenu">
<ul>
<li><span><a href="#" onClick="sethighlight(0); parent.menu.location='__URL__/menu/title/后台首页';parent.main.location='__URL__/main/';return false;">后台首页</a></span></li>
{foreach item=tag key=key from=$nodeGroupList}
<li><span><a href="#" onClick="sethighlight({counter}); parent.menu.location='__URL__/menu/tag/{$key}/title/{$tag}';return false;">{$tag}</a></span></li>
{/foreach}
<li><span><a href="#" onClick="parent.main.location='__APP__/Other/updateCache/';return false;" >更新全部缓存</a></span></li>
</ul>
</div>
	<div class="nav">
	<a href="__APP__/Public/logout" target="_top"><img SRC="__PUBLIC__/Images/Admin/error.gif" WIDTH="20" HEIGHT="20" BORDER="0" ALT="" align="absmiddle"> 退 出</a></div>
</div>
<script>
function sethighlight(n) {
	var lis = document.getElementsByTagName('span');
	for(var i = 0; i < lis.length; i++) {
		lis[i].className = '';
	}
	lis[n].className = 'current';
}
sethighlight(0);
</script>
</body>
</html>