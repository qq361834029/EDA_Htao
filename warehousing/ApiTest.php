<?php
define('IS_DISABLED', false);//是否禁用api测试功能
if (IS_DISABLED !== false) {
	exit;
}
define('DEFAULT_SHOW_DEBUG', true);//默认：是否显示开发调试模式选项
$action_list	= array(
					'AddOrder'				=> '新增销售单',
					'ModifyOrder'			=> '修改销售单',
					'DeleteOrder'			=> '删除销售单',
					'GetOrder'				=> '获取销售单',
					'GetOrderList'			=> '获取销售单列表',
					'GetStorageList'		=> '获取库存列表',
					'AddProduct'			=> '新增产品',
					'ModifyProduct'			=> '修改产品',
					'DeleteProduct'			=> '删除产品',
					'GetProductList'		=> '获取产品列表',
					'AddShipping'			=> '新增发货',
					'ModifyShipping'		=> '修改发货',
					'DeleteShipping'		=> '删除发货',
					'GetShippingList'		=> '获取发货列表',
					'GetStockInList'		=> '获取发货入库列表',
					'AddReturnOrder'		=> '新增退货',
					'DeleteReturnOrder'		=> '删除退货',
					'GetReturnOrderList'	=> '获取退货列表',
					'GetShippingMethodsList'	=> '获取派送方式列表',
					'UnCompress'				=> '解压XML',
				);
$pageActionList	= array('GetOrderList', 'GetStorageList', 'GetProductList', 'GetShippingList', 'GetReturnOrderList','GetStockInList');
define('ACTION', trim(isset($_POST['action']) && array_key_exists($_POST['action'], $action_list) ? $_POST['action'] : 'AddOrder'));
define('THINK_PATH', '../YttPHP/FrameWork/');
define('SHOW_DEBUG', DEFAULT_SHOW_DEBUG === false ? (isset($_GET['show_debug']) && intval($_GET['show_debug']) > 0 ? true : false) : true);//是否显示开发调试模式选项
define('DEBUG', intval(isset($_POST['debug']) ? $_POST['debug'] : (isset($_GET['show_debug']) ? $_GET['debug'] : 0)));
define('INTACT', $intact	= isset($_POST['intact']) && $_POST['intact'] == 1 ? 1 : 0);
require(THINK_PATH . 'Common/functions_extend.php');
/**
 * 获取当前页面完整URL地址
 */
function get_url() {
    $sys_protocal = isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '443' ? 'https://' : 'http://';
    $php_self = $_SERVER['PHP_SELF'] ? $_SERVER['PHP_SELF'] : $_SERVER['SCRIPT_NAME'];
    $path_info = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '';
    $relate_url = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : $php_self.(isset($_SERVER['QUERY_STRING']) ? '?'.$_SERVER['QUERY_STRING'] : $path_info);
    return $sys_protocal.(isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '').$relate_url;
}
define('URL', dirname(get_url()) . '/');//项目地址
define('API_URL', URL .  'Api/' . ACTION);

function showForm($response = ''){
	header('Content-Type:text/html;charset=utf-8');
	echo '<html>';
	echo '<head>';
	echo '<title>' . getActionName() . '</title>';
	echo '</head>';
	echo '<body>';
	echo '<div width="80%" style="margin-left: 10%;">';
	echo '<form action="" method="POST">';
	showTableHtml($response);
	echo '</form>';
	echo '</div>';
	showScriptHtml();	
	echo '</body>';
	echo '</html>';
}

function getActionName(){
	global $action_list;
	return $action_list[ACTION];
}
function showTableHtml($response){
	echo '<table border=1 width="80%" style="margin-top: 20px;">';	
	define('ERR_TD_STYLE', !empty($_POST['err']) ? ' style="color: red;" ' : ' style="display:none;" ');
	define('FIRST_TD_STYLE', ' style="vertical-align:top; text-align:right; width: 165px; font-size: 14pt;" ');
	showIntactHtml();
	showDebugHtml();
	showActionHtml();
	showTokenHtml();
	showUserHtml();
	showXmlHeaderHtml();
	showXmlHtml();
	showSubmitHtml();
	showResponseHtml($response);
	echo '</table>';	
}
//开发调试模式
function showDebugHtml(){
	if (SHOW_DEBUG === true) {
		echo '<tr id="debug_tr">'
				. '<td' . FIRST_TD_STYLE . '>开发调试模式：</td>'
				. '<td>'
					. '<input type="radio" name="debug"  value="0"' . (DEBUG != 1 ? 'checked' : '') . '/>否&nbsp;&nbsp;'
					. '<input type="radio" name="debug"  value="1"' . (DEBUG == 1 ? 'checked' : '') . '/>是'
				. '</td>'
				. '<td ' . ERR_TD_STYLE . '>&nbsp;</td>'
			. '</tr>';
	}
}
//请求接口
function showActionHtml(){
	global $action_list;
	echo '<tr>'
			. '<td' . FIRST_TD_STYLE . '>请求接口：</td>'
			. '<td>'
			. '<select name="action" id="action" onchange="changeAction()">';
	foreach ($action_list as $action=>$action_name) {
		echo '<option value="' . $action . '" ' . (ACTION == $action ? 'selected' : '') . '>' . $action_name . '</option>';	
	}
	echo	'</select>'
			. '</td>'
			. '<td ' . ERR_TD_STYLE . '>' . (isset($_POST['err']['api']) ? $_POST['err']['api'] : '') . '&nbsp;</td>'
		. '</tr>';
}
//是否完整XML
function showIntactHtml(){
	echo '<tr id="intact_tr">'
			. '<td' . FIRST_TD_STYLE . '>是否完整XML：</td>'
			. '<td>'
			. '<input type="radio" name="intact" onchange="changeIntact()"  value="0"' . (INTACT != 1 ? 'checked' : '') . '/>否&nbsp;&nbsp;'
			. '<input type="radio" name="intact" onchange="changeIntact()"  value="1"' . (INTACT == 1 ? 'checked' : '') . '/>是'
			. '</td>'
			. '<td ' . ERR_TD_STYLE . '>&nbsp;</td>'
		. '</tr>';
}
//授 权 码
function showTokenHtml(){
	echo '<tr id="token_tr">'
			. '<td' . FIRST_TD_STYLE . '>授 权 码：</td>'
			. '<td><input type="text" name="auth" style="width: 300px;" maxlength=32 value="' . (isset($_POST['auth']) ? $_POST['auth'] : '') . '"/></td>'
			. '<td ' . ERR_TD_STYLE . '>' . (isset($_POST['err']['token']) ? $_POST['err']['token'] : '') . '&nbsp;</td>'
		. '</tr>';
}
//卖家信息
function showUserHtml(){
	echo '<tr id="user_tr">'
			. '<td' . FIRST_TD_STYLE . '>E-mail：</td>'
			. '<td><input type="text" name="user" style="width: 300px;" value="' . (isset($_POST['user']) ? $_POST['user'] : '') . '"/></td>'
			. '<td ' . ERR_TD_STYLE . '>' . (isset($_POST['err']['user']) ? $_POST['err']['user'] : '') . '&nbsp;</td>'
		. '</tr>';
}
//请求XML内容头部
function showXmlHeaderHtml(){
	echo '<tr id="xml_header_tr">'
			. '<td' . FIRST_TD_STYLE . '>请求XML内容头部：</td>'
			. '<td><textarea name="xml_header" style="width: 100%" rows="2">' . (isset($_POST['xml_header']) ? $_POST['xml_header'] : '') . '</textarea></td>'
			. '<td ' . ERR_TD_STYLE . '>&nbsp;</td>'
		. '</tr>';	
}
//请求XML内容
function showXmlHtml(){
	echo '<tr>'
			. '<td' . FIRST_TD_STYLE . '>请求XML内容：</td>'
			. '<td><textarea name="xml" style="width: 100%" rows="10">' . (isset($_POST['xml']) ? $_POST['xml'] : '') . '</textarea></td>'
			. '<td ' . ERR_TD_STYLE . '>' . (isset($_POST['err']['xml']) ? $_POST['err']['xml'] : '') . '&nbsp;</td>'
		. '</tr>';	
}
//返回XML内容
function showResponseHtml($response){
	echo '<tr>'
			. '<td' . FIRST_TD_STYLE . '>返回XML内容：</td>'
			. '<td><textarea style="width: 100%" rows="20">' .$response . '</textarea></td>'
			. '<td ' . ERR_TD_STYLE . '>&nbsp;</td>'
		. '</tr>';	
}
//提交按钮
function showSubmitHtml(){
	echo '<tr>'
			. '<td colspan="3" style="text-align: center;"><input type="submit" name="submit" value="提交" />&nbsp;&nbsp;<input type="reset" value="重置" /></td>'
		. '</tr>';	
}
//JS
function showScriptHtml(){
	global $pageActionList;
	echo	'<script type="text/javascript">
				function changeAction(){
					var obj	= document.getElementById("action");
					var intact	= getIntact();
					if (intact != 1) {
						' . (SHOW_DEBUG === true ? 'document.getElementById("debug_tr").style.display	= "";' : '') . '
						document.getElementById("token_tr").style.display	= "";
						document.getElementById("user_tr").style.display	= "";
					}
					document.getElementById("xml_header_tr").style.display	= "none";
					switch(obj.options[obj.selectedIndex].value) {
						case "UnCompress":
							' . (SHOW_DEBUG === true ? 'document.getElementById("debug_tr").style.display	= "none";' : '') . '						
							document.getElementById("token_tr").style.display	= "none";
							document.getElementById("user_tr").style.display	= "none";
							break;';
	foreach ($pageActionList as $pageAction){
	echo	'			
						case "' . $pageAction . '":';
	}
	echo	'
							if (intact != 1) {
								document.getElementById("xml_header_tr").style.display	= "";
							}
							break;
					}
				}
				changeAction();
				function getIntact(){
					var obj	= document.getElementsByName("intact");
					for(var i in obj) {
						if(obj[i].checked){
							intact	= obj[i].value;
							break;
						}
					}
					return intact;
				}
				function changeIntact(){
					var intact	= getIntact();
					if (intact == 1) {
						document.getElementById("debug_tr").style.display		= "none";
						document.getElementById("user_tr").style.display		= "none";
						document.getElementById("xml_header_tr").style.display	= "none";
					} else {
						document.getElementById("debug_tr").style.display		= "";
						changeAction();
					}
				}
				changeIntact();
			</script>';	
}

function getXml(){
	global $pageActionList;
	if (INTACT == 1) {
		$xml	.= $_POST['xml'];
	} else {
		$xml	= '<?xml version="1.0" encoding="UTF-8"?>';
		$xml	.= '<' . ACTION . '>';
		$xml	.= '<Debug>' . DEBUG . '</Debug>';
		$xml	.= '<User>' . $_POST['user'] . '</User>';
		$xml	.= '<RequestTime>' . date('Y-m-d H:i:s') . '</RequestTime>';
		if (in_array(ACTION, $pageActionList)) {
			$xml	.= $_POST['xml_header'];
		}
		$xml	.= '<' . ACTION . 'Request>' . $_POST['xml'] . '</' . ACTION . 'Request>';
		$xml	.= '</' . ACTION . '>';
	}
	return $xml;
}
function validData(){
	$err	= true;
	if (ACTION == '') {
		$err	= false;
		$_POST['err']['api']	= '请填写接口!';
	}
	if (ACTION != 'UnCompress') {
		if (empty($_POST['auth'])) {
			$err	= false;
			$_POST['err']['token']	= '请填写授权码!';
		}
		if (empty($_POST['user']) && INTACT != 1) {
			$err	= false;
			$_POST['err']['user']	= '请填写E-mail!';
		}
	}
	if (!in_array(ACTION, array('GetStorageList', 'GetProductList','GetStockInList')) && empty($_POST['xml'])) {
		$err	= false;
		$_POST['err']['xml']	= '请填写XML内容!';
	}		
	return $err;
}
function processXml(){
	$response	= '';
	if ($_POST && validData() === true){
		if (ACTION == 'UnCompress') {
			$response	= stringCompress($_POST['xml'], 'decode');
		} else {
			$xml			= trim(getXml());
			$auth			= trim($_POST['auth']);
			$data_digest	= md5(substr($auth, 0, 16) . $xml . substr($auth, 16, 16));
			$url			= API_URL . '/DataDigest/' . $data_digest;
			$header[]		= "Content-type: text/xml";//定义content-type为xml
			$ch				= curl_init(); //初始化
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
			$response = curl_exec($ch);
			curl_errno($ch) && $response	= '请求失败[errno=' . curl_errno($ch) . ']';
			curl_close($ch);
		}
	}
	showForm($response);
}
processXml();
