{include file="header.tpl"}
<div class="title"> 客服相关信息，可任何修改。</div>
<form method="POST" action="{'Other/saveService'|U}">
<table cellspacing="0" cellpadding="0" class="add_table" width="98%">
    <tbody>
    <tr><th colspan="4">客服联系人信息</th></tr>
     <tr>
      <td class="width10">客户专员：</td>
      <td class="t_left width30"><input type="text" name="service_name" value="{$rs.service_name}" class="spc_input" ></td>
      <td class="width10">直线电话：</td>
      <td class="t_left"><input type="text" name="mobile" value="{$rs.mobile}" class="spc_input" ></td>
    </tr>
     <tr>
      <td>E-mail：</td>
      <td class="t_left"><input type="text" name="email" value="{$rs.email}" class="spc_input" ></td>
      <td>座 机：</td>
      <td class="t_left"><input type="text" name="phone" value="{$rs.phone}" class="spc_input" ></td>
    </tr>
     <tr>
      <td>QQ：</td>
      <td class="t_left"><input type="text" name="qq" value="{$rs.qq}" class="spc_input" ></td>
      <td>Skype：</td>
      <td class="t_left"><input type="text" name="skype" value="{$rs.skype}" class="spc_input" ></td>
    </tr>
    <tr>
      <td>MSN：</td>
      <td class="t_left"><input type="text" name="msn" value="{$rs.msn}" class="spc_input" ></td>
      <td>值班电话：</td>
      <td class="t_left"><input type="text" name="zb_phone" value="{$rs.zb_phone}" class="spc_input" ></td>
    </tr>
     <tr>
      <td>公司地址：</td>
      <td colspan="3" class="t_left"><input type="text" name="address" value="{$rs.address}" class="spc_input" ></td>
    </tr>
    <tr><th colspan="4">紧急联系人一</th></tr>
     <tr>
      <td>联系人：</td>
      <td class="t_left"><input type="text" name="contact1_name" value="{$rs.contact1_name}" class="spc_input" ></td>
      <td>联系电话：</td>
      <td class="t_left"><input type="text" name="contact1_phone" value="{$rs.contact1_phone}" class="spc_input" ></td>
    </tr>
    <tr>
      <td>MSN：</td>
      <td class="t_left"><input type="text" name="contact1_msn" value="{$rs.contact1_msn}" class="spc_input" ></td>
      <td>&nbsp;</td>
      <td class="t_left">&nbsp;</td>
    </tr>
   	 <tr><th colspan="4">紧急联系人二</th></tr>
     <tr>
      <td>联系人：</td>
      <td class="t_left"><input type="text" name="contact2_name" value="{$rs.contact2_name}" class="spc_input" ></td>
      <td>联系电话：</td>
      <td class="t_left"><input type="text" name="contact2_phone" value="{$rs.contact2_phone}" class="spc_input" ></td>
    </tr>
    <tr>
      <td>MSN：</td>
      <td class="t_left"><input type="text" name="contact2_msn" value="{$rs.contact2_msn}" class="spc_input" ></td>
      <td>&nbsp;</td>
      <td class="t_left">&nbsp;</td>
    </tr>
     <tr><th colspan="4">紧急联系人三</th></tr>
     <tr>
      <td>联系人：</td>
      <td class="t_left"><input type="text" name="contact3_name" value="{$rs.contact3_name}" class="spc_input" ></td>
      <td>联系电话：</td>
      <td class="t_left"><input type="text" name="contact3_phone" value="{$rs.contact3_phone}" class="spc_input" ></td>
    </tr>
    <tr>
      <td>MSN：</td>
      <td class="t_left"><input type="text" name="contact3_msn" value="{$rs.contact3_msn}" class="spc_input" ></td>
      <td>&nbsp;</td>
      <td class="t_left">&nbsp;</td>
    </tr>
     <tr>
	<td colspan="2">
	<div class="impBtn fLeft"><input type="submit" value="保存" class="save imgButton"></div>
	<div class="impBtn fRig"><input type="reset" class="reset imgButton" value="清空" ></div>
	</td>
</tr>
    </tbody>
  </table> 
</form>

