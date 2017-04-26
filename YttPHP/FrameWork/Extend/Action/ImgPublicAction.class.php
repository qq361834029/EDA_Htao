<?php

/**
 * ImgPublicAction
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category   显示图片action类
 * @package  	Action
 * @author    	jph
 * @version 	2.1,2016-02-17
 */
class ImgPublicAction extends Action {
	public $id		= 0;
	public $codes	= 'abcdefghjkmnpqrstuvwxyz23456789ABCDEFGHJKMNPQRSTUVWXYZ';

	public function __call($method, $args) {
		echo '<img src="'.U(MODULE_NAME.'/index',array('view' => 1, 'code'=>$method)).'">';
		exit;
	}

	public function get_code($id){
		return number_to_code($id, $this->codes);
	}

	/// 显示图片信息
    public function index() {
		$this->id	=  code_to_number(trim($_GET['code']), $this->codes);
		showImg($this->id);
    }
}

?>