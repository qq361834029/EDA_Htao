<?php 
/**
 * 入库导入异常管理
 * @copyright   Copyright (c) 2006 - 2013 TOP UNION 展联软件友拓通
 * @category   	入库信息
 * @package  	Model
 * @author    	jph
 * @version 	2.1,2014-01-08
 */

class InstockAbnormalPublicModel extends FileListPublicModel {
	/// 定义真实表名
	public $tableName = 'file_detail';//必须	
	public $import_key = 'InstockImport';//必须	
	///关联插入	 
	public $_link = array();//必须	
	/// 自动验证设置
	protected $_validate	 =	 array(
			array("warehouse_id",'require',"require",1),//仓库
			array("quantity",'z_integer','z_integer',1),//数量
			array("state",'require','require',1),//处理状态
		);		
	public function __construct($name = '', $tablePrefix = '', $connection = '') {
		parent::__construct($name, $tablePrefix, $connection);
		if ($_POST['state'] == C('CFG_IMPORT_PROCESSED_STATE')){
			$_validate = array(
				array("location_id",'require','require',1),//库位
				array("barcode_no",'require','require',1),//库位
				array("box_id",'require','require',1),//箱号ID
				array("box_no",'require','require',1),//箱号
				array("product_id",'require','require',1),//产品ID
				array("product_no",'require','require',1),//产品号	
				array("",'validInfo','require',1,'callbacks'),//验证基本信息
			);
			$this->_validate	= array_merge($this->_validate, $_validate);
		}
	}
	
	
	///验证基本信息
	public function validInfo(&$data){
		$error					= false;
		$instock_detail_model	= M('InstockDetail');
		$location_model			= M('Location');
		$error_info				= array(
									1 => array('name'=>'product_id', 'value'=>L('require')),
									2 => array('name'=>'barcode_no', 'value'=>L('require')),
									3 => array('name'=>'box_id', 'value'=>L('require')),
									4 => array('name'=>'location_id', 'value'=>L('record_not_exist_in_warehouse')),
									5 => array('name'=>'box_id', 'value'=>L('record_not_exist_in_instock')),
									6 => array('name'=>'product_id', 'value'=>L('record_not_exist_in_instock')),
								);	
		
		if(intval($data['product_id']) <= 0) {
			$error	= true;
			//产品不存在
			$this->error[]	= $error_info[1];
		}
		$data['location_id']	= intval($data['location_id']);
		if($data['location_id'] <= 0 && empty($data['barcode_no'])) {
			$error	= true;
			//条形码为空
			$this->error[]	= $error_info[2];
		} elseif ($data['location_id'] > 0  && empty ($data['barcode_no'])) {
			$data['barcode_no']	= $location_model->where("id=" . (int)$data['location_id'])->getField('barcode_no');
		}
		
		if(intval($data['box_id']) <= 0) {
			$error	= true;
			//箱号为空
			$this->error[]	= $error_info[3];
		}		
		
		if (intval($data['product_id']) > 0 && !empty($data['barcode_no']) && intval($data['box_id']) > 0){
			$where	= "warehouse_id=" . $data['warehouse_id'];
			if ($data['location_id'] <= 0) {
				$data['location_id']	= $location_model->where($where . " and barcode_no='" . $data['barcode_no'] . "'")->getField('id', true);
				if (!is_array($data['location_id']) || count($data['location_id']) > 1) {
					$error	= true;
					//库位编号不存在于当前仓库中
					$this->error[]	= $error_info[4];				
				} else {
					$data['location_id']	= array_pop($data['location_id']);
				}				
			}
			$data['location_id']	= intval($data['location_id']);
			$where	.= ' and detail.box_id = ' . (int)$data['box_id'];
			if ($instock_detail_model->join('detail left join instock main on main.id=detail.instock_id')->where($where)->count() <= 0) {
				$error	= true;
				//箱号不存在于发货单记录中
				$this->error[]	= $error_info[5];
				//产品不存在于发货单记录中
				$this->error[]	= $error_info[6];
			} else {	
				$where	.= ' and detail.product_id = ' . (int)$data['product_id'];
				if ($instock_detail_model->join('detail left join instock main on main.id=detail.instock_id')->where($where)->count() <= 0) {
					$error	= true;
					//产品不存在于发货单记录中
					$this->error[]	= $error_info[6];	
				}
			}
		}
        $this->vdata['location_id']	= $data['location_id'];
		$this->vdata['barcode_no']	= $data['barcode_no'];
		return $error;
	}

	///验证基本信息
	public function importValidDetail(&$details, $warehouse_id,$error_product=null){
		$box_id		= array();
		$product_id	= array();
		foreach ($details as &$detail) {
			if($warehouse_id > 0 && intval($detail['product_id']) > 0 && intval($detail['location_id']) > 0 && intval($detail['box_id']) > 0) {
				$box_id[$detail['box_id']]			= $detail['box_id'];
				$product_id[$detail['product_id']]	= $detail['product_id'];
				$detail['state']					= C('CFG_IMPORT_SUCCESS_STATE');
			} else {
				$detail['state']					= C('CFG_IMPORT_FAILED_STATE');
			}
		}
		unset($detail);
		if (count($box_id) > 0) {
			$join			= 'detail inner join __INSTOCK__ main on main.id=detail.instock_id';
			$where			= array(
								'main.warehouse_id'	=> $warehouse_id,
								'detail.box_id'		=> array('in', $box_id),
								'detail.product_id'	=> array('in', $product_id),
							);
			$instockDetail	= M('InstockDetail')->field('detail.box_id,detail.product_id')->join($join)->where($where)->select();
			$instockBox		= array();
			foreach ($instockDetail as $val) {
				$instockBox[$val['box_id']][$val['product_id']]	= true;
			}
			foreach ($details as &$detail) {
				if ($detail['state'] == C('CFG_IMPORT_SUCCESS_STATE') && $instockBox[$detail['box_id']][$detail['product_id']] !== true) {
					$detail['state']	= C('CFG_IMPORT_FAILED_STATE');
				}
			}
			unset($detail);
		}
        //判断错误的产品ID是否属于对应的卖家
        if(!empty($error_product)){
            $product_for_factory    = M('product')->where('id in ('.  implode(',', $error_product).')')->getField('id',true);
            if(!empty($product_for_factory)){
                foreach($details as $key=>&$val){
                    //add yyh 20151211当条码误填为ID时异常中显示产品ID  
                    $val['product_id']  = $error_product[$key];
                }
            }
        }
	}
}