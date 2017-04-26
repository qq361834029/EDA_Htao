<?php  
/**
 * DHL 请求队列列表
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category   	基本信息
 * @package  	Action
 * @author    	jph
 * @version 	2.1,2016-05-25
 */
class GlsPublicAction extends CommonAction {
	protected $_default_where 	=  '';  	///默认查询条件=>例子$_default_where	=  'parent_id<>0';  
	protected $_default_post 	=  array(); ///默认post条件=>例子protected $_default_post	=  array('query'=>array('to_hide'=>1));
	protected $track_no 		=  '';

	public function __construct() {
		parent::__construct();
	}

	public function requestPrint($sale_order_id, $w_id){
		$model	= D('Gls');
		$send	= false;
		if ($sale_order_id > 0) {
			$ip		= C('GLS_IP_'.$w_id);
			$port	= C('GLS_PORT_'.$w_id);
			$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
			if ($socket < 0) {
				$socket_info	.= "socket_create() failed: reason: " . socket_strerror($socket) . "<br />";
			}else {
				$socket_info	.= "OK.<br />";
			}
			$socket_info	.= "Try to connect '$ip':'$port'...<br />";
			$result = socket_connect($socket, $ip, $port);
			if ($result < 0) {
				$socket_info	.= "socket_connect() failed.<br />Reason: ($result) " . socket_strerror($result) . "<br />";
			}else {
				$socket_info	.= "connection succeeded<br />";
			}
			$in	= $model->getRequestData($sale_order_id);
			$out = '';

			if(!socket_write($socket, $in, strlen($in))) {
				$socket_info	.= "socket_write() failed: reason: " . socket_strerror($socket) . "<br />";
			}else {
				$socket_info	.= "Sending successful:<br><font color='red'>$in</font><br />";
				$send	= true;
			}
//			$socket_info	.= '<br />';
//			while($out = socket_read($socket, 8192)) {
//				$socket_info	.= "Received successfully:<br>".$out."<br />";
//			}
//          echo $socket_info;
			$socket_info	.= "Close SOCKET...<br />";
			socket_close($socket);
			$socket_info	.= "Close successfully<br />";
//			return	$socket_info;
			return $send;
		}
	}

	public function requestDelete($list,$w_id){
		$send	= false;
		$ip		= C('GLS_IP_'.$w_id);
		$port	= C('GLS_PORT_'.$w_id);
		$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
		if ($socket < 0) {
			$socket_info	.= "socket_create() failed: reason: " . socket_strerror($socket) . "<br />";
		}else {
			$socket_info	.= "OK.<br />";
		}
		$socket_info	.= "Try to connect '$ip':'$port'...<br />";
		$result = socket_connect($socket, $ip, $port);
		if ($result < 0) {
			$socket_info	.= "socket_connect() failed.<br />Reason: ($result) " . socket_strerror($result) . "<br />";
		}else {
			$socket_info	.= "connection succeeded<br />";
		}
		foreach ($list as $val){
			$in	.= '\\\\\\\\\\GLS\\\\\\\\\\T000:'.$val.'|/////GLS/////';
		}
		$out = '';

		if(!socket_write($socket, $in, strlen($in))) {
			$socket_info	.= "socket_write() failed: reason: " . socket_strerror($socket) . "<br />";
		}else {
			$socket_info	.= "Sending successful:<br><font color='red'>$in</font><br />";
			$send	= true;
		}
		$socket_info	.= '<br />';
		while($out = socket_read($socket, 8192)) {
			$socket_info	.= "Received successfully:<br>".$out."<br />";
		}
//			echo $socket_info;
		$socket_info	.= "Close SOCKET...<br />";
		socket_close($socket);
		$socket_info	.= "Close successfully<br />";
		if($send){
			return $send;
		}else{
			return $socket_info;
		}
	}
}
?>