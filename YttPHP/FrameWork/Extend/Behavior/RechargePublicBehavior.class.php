<?php
/**
 * 卖家充值
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category   	设置信息
 * @package  	Action
 * @author    	jph
 * @version 	2.1,2014-08-14
 */
class RechargePublicBehavior extends Behavior {
	
	public function run(&$params){
		$Model	= D('ClientRecharge');   
		if (ACTION_NAME=='confirm'){
			if ($params['confirm_state'] == 1) {
				$info		= $Model->_fund($params); 
			} else {
				$id			= $params['id']; 
				$info		= $Model->deleteOp($id); 
				$params['confirm_state'] = 1;	//防止报单据错误
			}
            T('Recharge')->run($params,'setState');
		} 	
		if (ACTION_NAME=='editConfirm'){
			$info		= $Model->_fund($params); 
            T('Recharge')->run($params,'setState');
		}
	}
	
	/**
	 * 已确认充值不可删除
	 * @param type $params
	 */
	public function delete(&$params){
		$this->checkPermission($params);
		if (M('Recharge')->where('id=' . $params['id'])->getField('confirm_state') == C('CONFIRM_STATE_CONFIRMED')) {
			throw_json(L('error_is_confirmed_cant_del'));
		}
	}
	
	
	/**
	 * 编辑充值确认
	 * @param type $params
	 */
	public function editConfirm(&$params){
		$this->checkPermission($params);
		if ($params['confirm_state'] == 1) {
			throw_json(L('_RECORD_HAS_UPDATE_'));
		}
		$params['module_name']	= 'ClientRecharge';
		$params['method_name']	= 'insert';
		$model					= D($params['module_name']);
		//新增款项验证
		$funds	= D('ClientRecharge')->rechargeFunds($params);
		$params	= array_merge($params, $funds);
		tag($params['module_name'] . '^' . $params['method_name'], $params);
	}
	
	
	/**
	 * 充值确认
	 * @param type $params
	 */
	public function confirm(&$params){
		$this->checkPermission($params);
		if ($params['confirm_state'] == M('Recharge')->where('id=' . $params['id'])->getField('confirm_state')) {
			throw_json(L('_RECORD_HAS_UPDATE_'));
		}
		$params['module_name']	= 'ClientRecharge';
		$params['method_name']	= $params['confirm_state'] == 1 ? 'insert' : 'delete';
		$model					= D($params['module_name']);
		if ($params['confirm_state'] == 1) {//新增款项验证
			$funds	= D('ClientRecharge')->rechargeFunds($params);
		} else {//删除款项验证
			$funds	= $model->fundInfo($params['id']);
		}
		$params	= array_merge($params, $funds);
		tag($params['module_name'] . '^' . $params['method_name'], $params);
	}

	public function checkPermission($params){
		if (data_permission_validation(M('Recharge')->find($params['id'])) === false) {
			throw_json(L('data_right_error'));
		}
	}
}