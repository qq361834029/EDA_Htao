<?php
define('IS_DISABLED', false);//是否禁用api测试功能
if (IS_DISABLED !== false) {
	exit;
}
define('DEFAULT_SHOW_DEBUG', true);//默认：是否显示开发调试模式选项
$action_list	= array(
					'TRANSIT_WAREHOUSE_ORDER_NOTICE'				=> '申请退货',
					'TRANSIT_WAREHOUSE_MAILNO_NOTICE'				=> '快递单号',
					'TRANSIT_WAREHOUSE_INNER_CHECK_DECISION'		=> '确认退货',
					'TRANSIT_WAREHOUSE_ORDER_NOTICE_XML'			=> '申请退货XML',
					'TRANSIT_WAREHOUSE_MAILNO_NOTICE_XML'			=> '快递单号XML',
					'TRANSIT_WAREHOUSE_INNER_CHECK_DECISION_XML'	=> '确认退货XML',
					'CreateItem'									=> '新增产品',
					'CreateReceivingOrder'							=> '新增发货',
					'GENERATING_SIGNATURE'							=> '生成签名',
				);
define('ACTION', trim(isset($_POST['action']) && array_key_exists($_POST['action'], $action_list) ? $_POST['action'] : 'TRANSIT_WAREHOUSE_ORDER_NOTICE'));
define('THINK_PATH', '../YttPHP/FrameWork/');
define('SHOW_DEBUG', DEFAULT_SHOW_DEBUG === false ? (isset($_GET['show_debug']) && intval($_GET['show_debug']) > 0 ? true : false) : true);//是否显示开发调试模式选项
define('DEBUG', intval(isset($_POST['debug']) ? $_POST['debug'] : (isset($_GET['show_debug']) ? $_GET['debug'] : 0)));
require(THINK_PATH . 'Common/common.php');
require(THINK_PATH . 'Common/functions.php');
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
define('API_URL', URL .  'CaiNiao/');

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
	showDebugHtml();
	showActionHtml();
	showTokenHtml();
	showXmlHtml();
	showResponseHtml($response);
	showSubmitHtml();
	echo '</table>';	
}
//开发调试模式
function showDebugHtml(){
	if (SHOW_DEBUG === true) {
		echo '<tr id="debug_tr">'
				. '<td' . FIRST_TD_STYLE . '>开发调试模式：</td>'
				. '<td><select name="debug">';
		$debug_list	= array(
							0	=> '否',	
							1	=> '是',
						);
		foreach ($debug_list as $value=>$name) {
			echo '<option value="' . $value . '" ' . (DEBUG == $value ? 'selected' : '') . '>' . $name . '</option>';	
		}
		echo	'</td>'
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
//密    钥
function showTokenHtml(){
	echo '<tr id="token_tr">'
			. '<td' . FIRST_TD_STYLE . '>密    钥：</td>'
			. '<td><input type="text" name="key" style="width: 300px;" maxlength=32 value="' . (isset($_POST['key']) ? $_POST['key'] : '') . '"/></td>'
			. '<td ' . ERR_TD_STYLE . '>' . (isset($_POST['err']['key']) ? $_POST['err']['key'] : '') . '&nbsp;</td>'
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
			. '<td colspan="3"><input type="submit" name="submit" value="提交" />&nbsp;&nbsp;<input type="reset" value="重置" /></td>'
		. '</tr>';	
}
//JS
function showScriptHtml(){
	echo	'<script type="text/javascript">
				function changeAction(){
					' . (SHOW_DEBUG === true ? 'document.getElementById("debug_tr").style.display	= "";' : '') . '
				}
				changeAction();
			</script>';	
}

function getXml(){
	$eventTime	= date('Y-m-d H:i:s');
	if (ACTION == 'GENERATING_SIGNATURE' || substr(ACTION, -4) == '_XML') {
		$xml	= str_replace('&', '&amp;', stripslashes($_POST['xml']));
	} elseif(in_array(ACTION, array('CreateItem', 'CreateReceivingOrder'))) {
		$xml	= '<request><event><eventHeader><eventType>' . ACTION . '</eventType><eventTime>' . $eventTime . '</eventTime><eventSource>4PX</eventSource><eventTarget>Tran_Store_1643484</eventTarget></eventHeader><eventBody>' . $_POST['xml'] . '</eventBody></event></request>';
	} else {
		$xml	= '<request><logisticsEvent><eventHeader><eventType>' . ACTION . '</eventType><eventTime>' . $eventTime . '</eventTime><eventSource>CAINIAO</eventSource><eventTarget>Tran_Store_1643484</eventTarget></eventHeader><eventBody><logisticsDetails><logisticsDetail>' . $_POST['xml'] . '</logisticsDetail></logisticsDetails></eventBody></logisticsEvent></request>';
	}

	return $xml;
}
function validData(){
	$err	= true;
	if (ACTION == '') {
		$err	= false;
		$_POST['err']['api']	= '请填写接口!';
	}
	if (empty($_POST['key'])) {
		$err	= false;
		$_POST['err']['key']	= '请填写密钥!';
	}
	if (empty($_POST['xml'])) {
		$err	= false;
		$_POST['err']['xml']	= '请填写XML内容!';
	}		
	return $err;
}
function processXml(){
	$response	= '';
	if ($_POST && validData() === true){
		$url			= API_URL;
		$xml			= getXml();
		if (ACTION == 'GENERATING_SIGNATURE') {
			$response	= cainiao_get_data_digest($xml, $_POST['key']);
		} else {
			$post_data		= array(
								'logistics_interface'	=> $xml,
								'logistic_provider_id'	=> 'Tran_Store_1643484',
								'msg_type'				=> str_replace('_XML', '', ACTION),
								'data_digest'			=> cainiao_get_data_digest(str_replace('&', '&amp;', htmlspecialchars_decode(stripslashes($xml))), $_POST['key']),
								'msg_id'				=> time(),
								'debug'					=> DEBUG,
							);
			$ch				= curl_init(); //初始化
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);	//获取内容不直接输出
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
			$response		= curl_exec($ch);
			curl_errno($ch) && $response	= curl_errno($ch);
			curl_close($ch);
		}
	}
	showForm($response);
}
processXml();
?>
