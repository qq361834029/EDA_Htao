<?php

/**
 * 入库单导入
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category    入库
 * @package   Behavior
 * @author     jph
 * @version  2.1,2014-04-03
 */

class FileListPublicBehavior extends Behavior {
	
	public $_file_type;// 1 入库导入，2 拣货导出，3 拣货导入	
	
	public $import_key = '';
	
	public function __construct($name = '', $tablePrefix = '', $connection = '') {
		parent::__construct($name, $tablePrefix, $connection);
		$this->import_key		= !empty($this->import_key) ? $this->import_key : MODULE_NAME;
		$this->_file_type		= array_search($this->import_key,C('CFG_FILE_TYPE'));
	}	

	public function run(&$params){ 
		switch (ACTION_NAME) {
			case 'update'://异常处理
				$rs	= D('FileList')->updateErrorProductInfoByDetailId($params['id']);//更新产品sku数，总数量，错误sku数，错误总数量
				if ($params['state'] == C('CFG_IMPORT_PROCESSED_STATE')) {//状态为已处理
					$this->updateFollowProcess($params);
				}
				break;
			case 'insert'://导入/导出
				$rs	= D('FileList')->updateErrorProductInfo($params['id']);//更新产品sku数，总数量，错误sku数，错误总数量
				if (MODULE_NAME == 'PickingImport') {
					$picking_no = M('file_list')->where(array('id'=>$params['relation_id']))->getField('file_list_no');
					$saleOrderCache = S('picking:saleOrder:'.$picking_no);
					$productCache = S('picking:product:'.$picking_no);
					//拣货导出已全分配完，绑定为不可拣货导入
					if(empty($saleOrderCache) && empty($productCache)){
						M('FileList')->save(array('id'=>$params['relation_id'],'relation_id'=>$params['relation_id']));		
					}
				}
				if ($rs['quantity'] > $rs['error_quantity']) {
					$this->insertFollowProcess($params);
				}
				break;
			case 'delete'://导入/导出
				$this->deleteFollowProcess($params);
				break;				
			default:
				if (!empty($params['method_name'])) {
					$method_name	= $params['method_name'];
					if (method_exists($this, $method_name)) {
						$this->$method_name($params);
					}
				}
				break;
		}
	}
	
	/// 新增验证
	protected function insert(&$params){

	}
	/// 删除时检验
	protected function delete(&$params){

	}
	
	/// 编辑时检验 是否已处理
	protected function edit(&$params){
		$state	= M('FileDetail')->where('id='.intval($params['id']))->getField('state');
		if($state != C('CFG_IMPORT_FAILED_STATE')){
			throw_json(L('error_is_processed_cant_edit'));
		}	
	}
	
	/// 更新时时检验
	protected function update(&$params){

	}	
	
	public function updateFollowProcess(&$params) {

	}
	
	public function insertFollowProcess(&$params) {

	}	
	
	public function deleteFollowProcess(&$params) {

	}	
	
}