<form method="POST" action="{'EbayAccount/getEbayToken'|U}" onsubmit="return false">
{wz action="list,reset"}
<input type="hidden" name="id" value="{$rs.id}">
<input type="hidden" id="username" value="{$rs.user_id}">
<div class="add_box">
<table cellspacing="0" cellpadding="0" class="add_table">
	<tbody>   
		<tr>
			<td class="t_left"> 
				<a href="javascript:void(0);" onclick="getEbaySessionID('{C('EBAY_RUNAME')}');">{$lang.step_1}：{$lang.authorized_ebay_links}：</a>
				<input type="text" readonly id="SessionID" name="SessionID" value="" class="spc_input">
			</td>
		</tr>
		<tr>
			<td class="t_left"> 
			{$lang.step_2}：{$lang.click_agreed_authorization}
			</td>
		</tr>
		<tr>
			<td class="t_left"> 
				<a href="javascript:void(0);" onclick='getEbayToken();'>{$lang.step_3}：{$lang.click_get_authorization_code}：</a>
				<input type="text" id="token" name='token' readonly value="" class="spc_input">
				<input type="text" id="expiration_time" name='expiration_time' readonly value="" class="spc_input">
			</td>
		</tr>
	</tbody>
</table>  
</div>
</form>
<script type="text/javascript">
	// 获取SessionID
	function getEbaySessionID(RuName){
		var username = $("#username").val();
		$.ajax({
			type: "POST",
			url: APP + "/Ajax/getEbaySessionID",
			dataType: "json",
			data:"username="+username,
			cache: false,
			success: function(data){
				if(data!='false'){
					$("#SessionID").val(data.SessionID);
					window.open("https://signin.ebay.com/ws/eBayISAPI.dll?SignIn&RuName="+RuName+"&SessID="+data.SessionID);
				}
			}
		});
	}
	
	// 获取Token
	function getEbayToken(){
		var username   = $("#username").val();
		var session_id = $("#SessionID").val();	
		if(session_id){
			$.ajax({
				type: "POST",
				url: APP + "/Ajax/getEbayToken",
				dataType: "json",
				data:"SessionID="+session_id+"&UserName="+username,
				cache: false,
				success: function(data){
					if(data!='false'){
						$("#token").val(data.eBayAuthToken);
						$("#expiration_time").val(data.HardExpirationTime);
						alert('授权成功，请保存。');
					}else{
						alert('获取Token失败。请重新点击。或者联系客服人员！');
					}
				}
			});
		}
		
	}
</script>