<?php 
/**
 * 固定汇率
 * @copyright   2011 展联软件友拓通
 * @category   	基本信息
 * @package  	Action
 * @author    	何剑波
 * @version     2011-03-23
 */
class RateErrorPublicAction extends BasicCommonAction {
     
	protected $_default_post	=  array('query'=>array('state'=>1));  //默认post值处理
	public $_sortBy				= 'error_date';

	public function delete(){
		if (D('RateError')->setState($_GET['id'])) {
			$this->success(L('success'));
		}else {
			$this->error();
		}
	}
}
?>