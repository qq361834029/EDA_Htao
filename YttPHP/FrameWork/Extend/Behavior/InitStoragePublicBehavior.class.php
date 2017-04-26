<?php
class InitStoragePublicBehavior extends Behavior {
	
	private $storage_attr = array();
	
	public function run(&$params){}
	
	public function insert($params){
		$this->checkSam($params);
	}
	
	public function update($params){
		$this->checkSam($params);
	}
	
	public  function checkSam($params,$type=false){
		$this->setSpec();
		$error = array();
		foreach ($params['detail'] as $value) {
			if (empty($value['product_id'])) {continue;}
			$value['warehouse_id'] = $params['warehouse_id'];
			if ($value['id']>0) {
				$count = M('InitStorageDetail')->join('init_storage on(init_storage.id=init_storage_detail.init_storage_id)')->where($this->getSpecWhere($value).' and init_storage_detail.id!='.$value['id'])->count();
			}else {
				$count = M('InitStorageDetail')->join('init_storage on(init_storage.id=init_storage_detail.init_storage_id)')->where($this->getSpecWhere($value))->count();
			}
			if ($count>0) {
				$error[] = L('product_no').'“'.SOnly('product', $value['product_id'], 'product_no').'”'.L('re_check');
			}
		}
		if($type=='true'){
			if($count>0){
				return false;
			}
		}else{
			!empty($error) && throw_json($error);
		}
	}
	/**
	 * 根据配置信息获取库存更新属性
	 *
	 */
	private function setSpec(){
		static $storage_attr;
		if($storage_attr) {
			return ;
		}else {
			$storage_attr = array('warehouse_id','product_id');
			if (C('storage_format')>=2) {
				$storage_attr[] = 'capability';
			}
			if (C('storage_format')>=3) {
				$storage_attr[] = 'dozen';
			}
			if (C('storage_color')) {
				$storage_attr[] = 'color_id';
			}
			if (C('storage_size')) {
				$storage_attr[] = 'size_id';
			}
			if (C('storage_mantissa')) {
				$storage_attr[] = 'mantissa';
			}
			$this->storage_attr = $storage_attr;
		}
	}
	
	/**
	 * 根据规格生成查询条件
	 * @param  array
	 * @param  int  1实际库存 2可销售库存
	 */
	private function getSpecWhere($value){
		$where = array();
		foreach ($this->storage_attr as $spec_field) {
			$where[] = $spec_field.'='.$value[$spec_field];
		}
		return implode(' and ',$where);
	}
	
	
}