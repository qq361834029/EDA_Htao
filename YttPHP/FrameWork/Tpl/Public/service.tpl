{literal}
<style type="text/css">
body {
	padding:0;
	font-size:12px;
	font-family:宋体,serif,Tahoma, Helvetica, sans-serif;
	margin:0 auto;
	color:#000000;
	background-color:#FBFCFE;
	font-weight: normal;
	width: 100%
}

div,table,select,input, button,legend,textarea,form,p,h1,h2,h3,h4,h5,fieldset{padding:0; margin:0;}
ul,li,ol,dl,dt,dd{padding:0; margin:0; list-style:none;}
.clear_both{clear:both;}
.t_left{ text-align:left !important;}
.service{clear:both; margin:0 auto;}

.servicetable{
	margin:0px auto; 	
	border-collapse: collapse;
	width:630px;	
	white-space: nowrap;
}
	
.servicetable td {
	word-wrap:break-word;	
	height:26px; 
	light-height:26px;
	text-align:right;
	}

.serviceWindow{
	margin-left:auto; 
	margin-right:auto; 
	margin-top:50px;
	width:700px;
	font-size:14px;
	height:440px;
	border:#2F96D1 1px solid;
	background:#FFFFFF;
	color:#3B3B3B;
	filter:progid:DXImageTransform.Microsoft.Shadow(color=#DCDCDE,direction=120,strength=4);
	-moz-box-shadow: 2px 2px 10px #909090;
	-webkit-box-shadow: 2px 2px 10px #909090;
    }
	
.serviceWindow .Head{
	height:58px;
	line-height:58px;
	width:640px;
	margin:15px 15px 0px 5px;
	font-weight:bold;
	font-size:14px;
	background: #F9F9F9 url(__PUBLIC__/Images/Default/service_bg.jpg) 50% 50% repeat-x; 
	}
	
.serviceWindow .title{
	width:560;
	height:28px;
	line-height:28px;
	text-align:left!important;
	color:#2F96D1;
	font-weight:bold;
	margin:5px 30px;
	text-align: center;
	font-size:14px;
	font-weight:bold;
	background: #F9F9F9 url(__PUBLIC__/Images/Default/service_line.jpg) 50% 50% repeat-x;
	}
	
.tred14{
    padding-left:30px; 
	height:32px; 
	line-height:32px; 
	font-weight:bold;}

.tzhiri{
	padding-left:15px; 
	height:28px; 
	line-height:28px; 
	}


.urgencyetable{
	margin:0px auto; 	
	border-collapse: collapse;
	line-height:26px;
	width:210px;
}
	
.urgencytable td {
	word-wrap:break-word;
	padding-left:2px;
	height:26px; 
	line-height:26px;
	}

</style>
{/literal}
<div class="service">
<div class="serviceWindow">
    <div class="Head">
        <div style="padding-left:65px;">{$lang.contact_us}</div>
    </div>
    <div class="title">{$lang.service_contact}</div>
	<div>
	<table width="630" border="0" cellspacing="0" cellpadding="0"  class="servicetable">
       <tr>
	       <td>{$lang.service_name}：</td>
	       <td class="t_left" colspan="3"><strong>{$rs.service_name}</strong></td>
       <tr>        
       <tr>
          <td width="200">{$lang.service_phone}：</td>
           <td class="t_left" width="150">{$rs.phone}</td>
           <td width="80">{$lang.qq}：</td>
           <td width="200" class="t_left">{$rs.qq}</td>
         </tr>
       <tr>
            <td>{$lang.service_mobile}：</td>
            <td class="t_left">{$rs.mobile}</td>
            <td>{$lang.skype}：</td>
	        <td class="t_left">{$rs.skype}</td>
           </tr>
       <tr>
	       <td>{$lang.zb_phone}：</td>
	       <td class="t_left">{$rs.zb_phone}</td>
	       <td>{$lang.msn}：</td>
	       <td class="t_left">{$rs.msn}</td>
       </tr>
       <tr>
	        <td>{$lang.email}：</td>
            <td class="t_left" colspan="3">{$rs.email}</td>
        </tr>
       <tr>
	       <td>{$lang.ytt_adder}：</td>
	       <td class="t_left" colspan="3">{$rs.address}</td>
       </tr>
    </table>	
	 </div>
	 
	  <div class="clear_both"></div>
	 
    <div class="title">{$lang.jj_contact}</div>
	<div  class="tred14" style="padding-left:32px; width:600px; line-height:26px;">
	<font color="#FF2A00">{$lang.service_noet}</font></div><br />
<div style="padding-left:18px; height:140px;">
	<table width="663" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
  {if $rs.contact1_name && $rs.contact1_phone && $rs.contact1_msn}
    <td width="220"  align="center">
	<table border="0" cellspacing="0" cellpadding="0" class="urgencyetable">
       <tr><td width="72" align="right">{$lang.contact}：</td><td align="left">{$rs.contact1_name}</td></tr>
       <tr><td align="right">{$lang.phone}：</td><td align="left">{$rs.contact1_phone}</td></tr>
       <tr><td align="right">{$lang.msn}：</td><td align="left">{$rs.contact1_msn}</td></tr>
    </table>
    </td>
    {/if}
    {if $rs.contact2_name && $rs.contact2_phone && $rs.contact2_msn}
    <td width="1" bgcolor="#CCCCCC"></td>
    <td width="220"  align="center">
	  <table  border="0" cellspacing="0" cellpadding="0" class="urgencyetable">
       <tr><td width="72" align="right">{$lang.contact}：</td><td align="left">{$rs.contact2_name}</td></tr>
       <tr><td align="right">{$lang.phone}：</td><td align="left">{$rs.contact2_phone}</td></tr>
       <tr><td align="right">{$lang.msn}：</td><td align="left">{$rs.contact2_msn}</td></tr>
    </table></td>
    {/if}
    {if $rs.contact3_name && $rs.contact3_phone && $rs.contact3_msn}
    <td width="1" bgcolor="#CCCCCC"></td>
	 <td width="220"  align="center"> 
	   <table  border="0" cellspacing="0" cellpadding="0" class="urgencyetable">
       <tr><td width="72" align="right">{$lang.contact}：</td><td align="left">{$rs.contact3_name}</td></tr>
       <tr><td align="right">{$lang.phone}：</td><td align="left">{$rs.contact3_phone}</td></tr>
       <tr><td align="right">{$lang.msn}：</td><td align="left">{$rs.contact3_msn}</td></tr>
    </table></td>
    {/if}
  </tr>
</table>  
</div>
