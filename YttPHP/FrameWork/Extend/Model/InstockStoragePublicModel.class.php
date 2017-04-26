<?php

/**
 * 库存调整管理
 * @copyright   Copyright (c) 2006 - 2013 Top Union 展联软件友拓通
 * @category   	库存调整
 * @package  	Model
 * @author    	何剑波
 * @version 	2.1,2012-07-22
*/

class InstockStoragePublicModel extends RelationCommonModel {
	/// 定义真实表名
	protected $tableName = 'instock_storage';
	/// 定义索引字段
	public $id;
	/// 定义表关联
	protected $_link	 = array(
        'detail' => array(
            'mapping_type' => HAS_MANY,
            'foreign_key' => 'instock_storage_id',
            'class_name' => 'InstockStorageDetail',
        ),
    );	
	/// 自动验证设置
	protected $_validate	 =	 array(
            array("storage_date","require","require",0),
			array("",'_validDetail','require',1,'validDetail'),
		);
	/// 验证表单明细
	protected $_validDetail	 =	 array(
			array("location_id",'pst_integer','require',1), 			
			array("in_quantity",'pst_integer','pst_integer',1),
		);
		
	/// 自动填充
    protected $_auto = array(
        array("create_time", "date", 1, "function", "Y-m-d H:i:s"), // 创建时间	
        array("update_time", "date", 2, "function", "Y-m-d H:i:s"), // 更新时间
    );

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
    public function getInfo($id) {
        $rs		= $this->getMainInfo(false);
        if (empty($rs)) { // 记录不存在或没权限查看该记录
            throw_json(L('data_right_error'));
        }
		$this->getRelation($rs); //获取关联数据 装箱明细及产品明细
		if ($rs['detail']) {
			foreach($rs['detail'] as $val){
				$location_id[$val['location_id']]				= $val['location_id'];
				$instock_detail_id[$val['instock_detail_id']]	= $val['instock_detail_id'];
                $this_in_quantity                               += $val['in_quantity'];
			}
			$product_list	= M('instock_detail')->where(array('instock_id' => $rs['instock_id'], 'id' => array('in', $instock_detail_id)))->select();
            $product		= resetArrayIndex($product_list, 'id');
            foreach ($product as &$product_value){
				$all_accepting_quantity        += $product_value['accepting_quantity'];
                $all_in_quantity        += $product_value['in_quantity'];
                $all_product_quantity   += $product_value['quantity'];
                $product_value['instock_detail_id'] = $product_value['id'];
            }
			$location_no	= getLocationNo($location_id);
			foreach($rs['detail'] as $key=>$val){
				$detail_id								= $val['instock_detail_id'];
				$product[$detail_id]['new_quantity']	= $val['in_quantity'];
				$product[$detail_id]['warehouse_id']	= $val['warehouse_id'];
				$product[$detail_id]['location_id']		= $val['location_id'];
				$product[$detail_id]['location_no']		= $location_no[$val['location_id']];
                $product[$detail_id]['id']              = $val['id'];
                $product[$detail_id]['instock_detail_id']   = $product[$detail_id]['instock_detail_id'];
				$rs['product'][]						= $product[$detail_id];
				$box_id[$product[$detail_id]['box_id']]	= $product[$detail_id]['box_id'];
			}
			$box_no			= M('instock_box')->where(array('instock_id' => $rs['instock_id'], 'id' => array('in', $box_id)))->getField('id,box_no');
			foreach ($rs['product'] as &$product) {
				$product['box_no'] = $box_no[$product['box_id']];
			}
		}
        $rs['this_in_quantity']       = $this_in_quantity;//本次入库合计
        $rs['all_in_quantity']        = $all_in_quantity;//已入库合计
        $rs['all_product_quantity']   = $all_product_quantity;//总数量合计
		$rs['all_accepting_quantity'] = $all_accepting_quantity;//总验收数量
		$info	= _formatListRelation($rs, array('product'));
        return $info;
    }
    public function getMainInfo($format	= true){
		$where		= 'a.id=' . (int)$this->id . getWarehouseWhere() . getBelongsWhere('b');
		$model		= D('InstockStorage');
		$rs			= $model->field('*,a.id as id,a.lock_version as lock_version,a.create_time as create_time,a.add_user as add_user')->join(' a left join instock b on a.instock_id = b.id')->where($where)->find();
		return $format ? _formatArray($rs) : $rs;
	}
    public function getInfoInstock($id) {
        $rs = $this->getInstockMainInfo($id,false);
        if (false === $rs || $rs == null) { // 记录不存在或没权限查看该记录
            throw_json(L('data_right_error'));
        }        
        $rs['box']      = M('instock_box')->where('instock_id='.$id)->select();
        $rs['product']  = M('instock_detail')->where('instock_id='.$id.' and in_quantity<quantity')->select();
        $info			= _formatListRelation($rs, array('box', 'product'));
        if ($info['product']) {
            foreach ($info['product'] as &$product) {
                $product['box_no']			= $info['box'][$product['box_id']]['box_no'];
                $product['warehouse_id']	= $info['warehouse_id'];
				$all_accepting_quantity		+= $product['accepting_quantity'];
                $all_in_quantity			+= $product['in_quantity'];
                $all_product_quantity		+= $product['quantity'];
            }
        }
        $info['all_in_quantity']        = $all_in_quantity;//已入库合计
        $info['all_product_quantity']   = $all_product_quantity;//总数量合计
		$info['all_accepting_quantity'] = $all_accepting_quantity;//总验收数量
        return $info;
    }
    public function getInstockMainInfo($id,$format	= true){
		$where		= 'id=' . (int)$id . getWarehouseWhere();
		$rs			= D('Instock')->where($where)->find();
		return $format ? _formatArray($rs) : $rs;
	}

    /**
	 * 所有订单列表SQL
	 *
	 * @return  array
	 */
	function indexSql(){        
        $userInfo	=	getUser();
        if($userInfo['role_type']==C('WAREHOUSE_ROLE_TYPE')){
            $_POST['detail']['query']['warehouse_id']    =  $userInfo['company_id'];
        }
        $count      = $this->exists('select 1 from instock_storage_detail inner join product on product.id=instock_storage_detail.product_id where instock_storage_id =instock_storage.id and '.getWhere($_POST['detail']),$_POST['detail'])->join('left join instock on  instock_storage.instock_id=instock.id')->where(getWhere($_POST['main']))->count();
        $this->setPage($count);
		$ids	= $this->field('instock_storage.id')->exists('select 1 from instock_storage_detail inner join product on product.id=instock_storage_detail.product_id where instock_storage_id=instock_storage.id and '.getWhere($_POST['detail']),$_POST['detail'])->join('left join instock on  instock_storage.instock_id=instock.id')->where(getWhere($_POST['main']))->order('storage_no desc')->page()->selectIds();
        $info['from'] 	= 'instock_storage a 
						   LEFT JOIN instock_storage_detail b ON a.id = b.instock_storage_id
						   LEFT JOIN product c      ON b.product_id=c.id
                           LEFT JOIN instock d      ON d.id=a.instock_id';
		$info['group'] 	= ' group by a.id order by storage_no desc';
		$info['where'] 	= ' where a.id in'.$ids.getWarehouseWhere('','d.warehouse_id');
		$info['field'] 	= '*,a.id as id,d.id as instock_id';
		return  'select '.$info['field'].' from '.$info['from'].$info['where'].$info['group'];
	}
}