<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title></title>
        <link rel='stylesheet' type='text/css' href='__PUBLIC__/Css/admin.css'>
            <style>
                html{ overflow-x : hidden;}
				body{ width:100%;}
            </style>
            <base target="main" />
    </head>

    <body >
        <div id="menu" class="menu">
            <table class="list shadow" cellpadding=0 cellspacing=0 >
                <tr>
                    <td height='5' colspan=7 class="topTd" ></td>
                </tr>
                <tr class="row" >
                    <th class="tCenter space"><img SRC="__PUBLIC__/Images/Admin/home.gif" WIDTH="16" HEIGHT="16" BORDER="0" ALT="" align="absmiddle"> {if $smarty.get.title} {$smarty.get.title}{else}后台首页{/if} </th>
                </tr>
                {foreach item=item key=key from=$menu}
                                    <tr class="row " >
                                        <td><div style="margin:0px 5px"><img SRC="__PUBLIC__/Images/Admin/arrow.gif" WIDTH="9" HEIGHT="9" BORDER="0" align="absmiddle" ALT=""> <a href="__APP__/Admin/{$item['module']}" id="{$key}" target="main">{$item['title']}</a></div></td>
                                    </tr>
                    {/foreach}
                <tr>
                    <td height='5' colspan=7 class="bottomTd"></td>
                </tr>
            </table>
        </div>
        <script language="JavaScript">
            function refreshMainFrame(url){
                parent.main.document.location = url;
            }
            if (document.anchors[0]){
                refreshMainFrame(document.anchors[0].href);
            }
        </script>
    </body>
</html>