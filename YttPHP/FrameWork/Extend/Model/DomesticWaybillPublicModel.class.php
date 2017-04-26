<?php

/**
 * 库存调整管理
 * @copyright   Copyright (c) 2006 - 2013 Top Union 展联软件友拓通
 * @category   	库存调整
 * @package  	Model
 * @author    	何剑波
 * @version 	2.1,2012-07-22
*/

class DomesticWaybillPublicModel extends RelationCommonModel {
	/// 定义真实表名
	protected $tableName = 'domestic_waybill';
	/// 定义索引字段
	public $id;
	/// 定义表关联
	protected $_link	 = array('detail' => 
									array(
										'mapping_type'	=> HAS_MANY,
										'foreign_key' 	=> 'waybill_id',
										'class_name'	=> 'DomesticWaybillDetail',
									)
								);	
	/// 自动验证设置
	protected $_validate	 =	 array(
			array("waybill_date",'require',"require",1), //1为必须验证
			array("",'_validDetail','require',1,'validDetail'),
			array('','validQuantity','',1,'callbacks'), 
		);
	/// 验证表单明细
	protected $_validDetail	 =	 array(
            array("product_id",'require','require',1), 
			array("location_id",'require','require',1), 
            array("quantity",'pst_integer','pst_integer',1), 
		);	
    protected $_validRelatedDetail	 =	 array(
			array("quantity",'storage_quantity','shipped_quantity_chk',1,'elt'), 
	);	
	/// 自动填充
	protected $_auto = array(
							array("create_time", "date", 1, "function", "Y-m-d H:i:s"), // 创建时间	
							array("update_time", "date", 2, "function", "Y-m-d H:i:s"), // 更新时间					
						);
    
    
    public function setPost() {
        if(ACTION_NAME  == 'insert'){
            $this->mergeProperty('_validDetail', $this->_validRelatedDetail);
        }
        parent::setPost();
    }
                        /**
	 * 查看调整明细
	 *
	 * @return  array
	 */
	public function view(){ 
		return $this->getInfo($this->id);
	}
	
	/**
	 * 编辑调整明细
	 *
	 * @return  array
	 */
	public function edit(){
		return $this->getInfo($this->id);
	}
	
	/**
	 * 获取明细信息(用于查看/编辑)
	 *
	 * @param int $id
	 * @return array
	 */
	public  function getInfo($id) {		
		$rs			  = $this->find($id);
		$rs['detail'] = M('DomesticWaybillDetail')->field('*,quantity AS sum_quantity')->where('waybill_id='.$id)->select();
		if(is_array($rs['detail'])&&$rs['detail']){
			foreach ($rs['detail'] as $row){
				if (!empty($row['location_id'])) {
					$location_id[] = $row['location_id'];
				}
			}
			$location = M('location');
			$sql	  = 'SELECT id,barcode_no,warehouse_id
					     FROM location
						 WHERE id in ('.implode(',',$location_id).')';
			//echo $sql;exit;
			$data	  = $location->query($sql);
			foreach ((array)$data as $val){
				$barcode_no_data[$val['id']] = $val['barcode_no']; 
			}
			foreach($rs['detail'] as &$val){
				if(array_key_exists($val['location_id'],$barcode_no_data)){
					$val['barcode_no'] = $barcode_no_data[$val['location_id']]; 
				}else{
					$val['barcode_no'] = ''; 
				}
			}
		}
		$rs			  = _formatListRelation($rs);
		return $rs;
	}
	 
	/**
	 * 所有订单列表SQL
	 *
	 * @return  array
	 */
	function indexSql(){ 
        if(getUser('role_type')==C('WAREHOUSE_ROLE_TYPE')){
            $warehouse_id   = M('warehouse')->where('is_return_sold='.C('NO_RETURN_SOLD').' and relation_warehouse_id='.getUser('company_id'))->getField('id',true);
            $warehouse_id[] = getUser('company_id');
            $_POST['detail']['in']['warehouse_id']    = $warehouse_id;
        }
        $where['warehouse']    = getAllWarehouseWhere();
		$count 	= $this->exists('select 1 from domestic_waybill_detail inner join product on product.id=domestic_waybill_detail.product_id where waybill_id=domestic_waybill.id and '.getWhere($_POST['detail']),$_POST['detail'])->where(getWhere($_POST['main']))->count();
        $this->setPage($count);
		$ids	= $this->field('id')->exists('select 1 from domestic_waybill_detail inner join product on product.id=domestic_waybill_detail.product_id where waybill_id=domestic_waybill.id and '.getWhere($_POST['detail']),$_POST['detail'])->where(getWhere($_POST['main']))->order('waybill_no desc')->page()->selectIds();
		
        $info['from'] 	= 'domestic_waybill a 
						   LEFT JOIN domestic_waybill_detail b ON a.id = b.waybill_id
						   LEFT JOIN product c		 ON b.product_id=c.id';
		$info['group'] 	= ' group by a.id order by waybill_no desc';
		$info['where'] 	= ' where a.id in'.$ids;
		$info['field'] 	= 'a.id AS id,
						   a.waybill_no AS waybill_no,
						   a.waybill_date AS awaybill_date,
						   b.waybill_id,
						   b.product_id AS product_id,
						   count(distinct b.product_id) as product_counts,
						   b.location_id AS location_id,
						   b.quantity AS quantity,  
						   sum(quantity) AS sum_quantity,
						   sum(quantity) AS total_quantity,
						   c.product_no AS product_no,
                           a.add_user AS add_user,
                           GROUP_CONCAT(distinct b.warehouse_id) as warehouse_id';
		return  'select '.$info['field'].' from '.$info['from'].$info['where'].$info['group'];
	}
	
}