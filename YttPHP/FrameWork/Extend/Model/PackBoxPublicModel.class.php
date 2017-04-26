<?php

/**
 * 库存调整管理
 * @copyright   Copyright (c) 2006 - 2013 Top Union 展联软件友拓通
 * @category   	装箱单
 * @package  	Model
 * @author    	YYH
 * @version 	2.1,2012-07-22
*/

class PackBoxPublicModel extends RelationCommonModel {
	/// 定义真实表名
	protected $tableName = 'pack_box';
	/// 定义索引字段
	public $id;
	/// 定义表关联
	protected $_link	 = array('detail' => 
									array(
										'mapping_type'	=> HAS_MANY,
										'foreign_key' 	=> 'pack_box_id',
										'class_name'	=> 'PackBoxDetail',
									)
								);	
	/// 自动验证设置
	protected $_validate	 =	 array(
			array("is_aliexpress",'require',"require",self::EXISTS_VAILIDATE), 
			array("pack_date",'require',"require",self::EXISTS_VAILIDATE), //1为必须验证
			array("warehouse_id",'require',"require",self::MUST_VALIDATE), //1为必须验证
			array("package_id",'require',"require",self::EXISTS_VAILIDATE), //1为必须验证
			array("factory_id",'require',"require",self::EXISTS_VAILIDATE), //1为必须验证
			array("",'_validDetail','require',1,'validDetail'),
		);
	/// 验证表单明细
	protected $_validDetail	 =	 array(
        array('return_sale_order_id','require',"require",self::MUST_VALIDATE), //1为必须验证
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
	public  function getInfo($id) {		
		$rs			  = $this->find($id);
		$rs['detail'] = M('PackBoxDetail')->where('pack_box_id='.$id)->select();
        //获取小包重量
        foreach($rs['detail'] as $detail){
            $return_id[$detail['return_sale_order_id']] = $detail['return_sale_order_id'];
        }
        
        $weight = $this->getReturnWeight($return_id);
        $return_info    = M('return_sale_order')->where('id in ('.implode(',', $return_id).')')->getField('id,return_track_no,return_logistics_no');
        foreach($rs['detail'] as &$value){
            $value['url']           = U('ReturnSaleOrder/view/','id='.$value['return_sale_order_id']);
            $value['weight']        = $weight[$value['return_sale_order_id']];
            $value['return_track_no']    = $return_info[$value['return_sale_order_id']]['return_track_no'];
            $value['return_logistics_no']    = $return_info[$value['return_sale_order_id']]['return_logistics_no'];
        }
        
//        $count  = M('out_batch_detail')->where('pack_box_id='.$rs['id'])->count();
//        $rs['is_update']    = $count > 0 ? 0 : 1;
        $rs['is_update']    = 0;
        $rs['is_out_batch'] = $this->isOutBatch($id);
        //装箱单运费    
        $sys_pay_class  = C('OUT_BATCH_SYS_PAY_CLASS');
        $rs['freight']  = M('PackBox')->join('a left join client_paid_detail cpd on cpd.object_id=a.id and cpd.object_type=131 and cpd.pay_class_id='.intval($sys_pay_class['domesticShippingFee']))
                    ->where('a.id='.$id)->getField('cpd.should_paid');
		$rs     = _formatListRelation($rs);
		return $rs;
	}
    public function isOutBatch($id){
        $count  = M('out_batch_detail')->where('pack_box_id='.$id)->count();
        return ($count > 0) ? true : false;
    }
    public function isAbnormal($id){
        $count  = M('pack_box_detail')->where('pack_box_id in ('.$id.') and parcel_state<>0')->count();
        return ($count > 0) ? false : true;
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
		$count 	= $this->exists('select 1 from pack_box_detail  where pack_box_id=pack_box.id and '.getWhere($_POST['detail']),$_POST['detail'])->where(getWhere($_POST['main']))->count();
        $this->setPage($count);
		$ids	= $this->field('id')->exists('select 1 from pack_box_detail where pack_box_id=pack_box.id and '.getWhere($_POST['detail']),$_POST['detail'])->where(getWhere($_POST['main']))->order('pack_box_no desc')->page()->selectIds();
		
        $info['from'] 	= 'pack_box a 
						   LEFT JOIN pack_box_detail b ON a.id = b.pack_box_id';
		$info['group'] 	= ' group by a.id order by pack_box_no desc';
		$info['where'] 	= ' where a.id in'.$ids;
		$info['field'] 	= 'a.id AS id,
						   a.pack_box_no AS pack_box_no,
						   a.pack_date AS pack_date,
                           a.package_id AS package_id,
						   b.return_sale_order_id as return_sale_order_id,
                           a.warehouse_id AS warehouse_id';
		return  'select '.$info['field'].' from '.$info['from'].$info['where'].$info['group'];
	}
    /*
     * 获取小包重量
     * 
     * @param array $return_sale_order_id
     * @return array
     */
    public function getReturnWeight($return_sale_order_id){
        if(is_array($return_sale_order_id)){
            $return_sale_order_id   = implode(',', $return_sale_order_id);
        }
        $prodcut_weight = M('return_sale_order_storage_detail')
                ->join('rd left join product p on rd.product_id=p.id')
                ->where('rd.return_sale_order_id in ('.$return_sale_order_id.')')
                ->group('rd.return_sale_order_id')
                ->field('rd.return_sale_order_id as id,sum(if(p.check_status=1,p.check_weight,p.weight)*quantity) as weight')
                ->getField('id,weight');
            //退货单包装重量
        $package_weight = M('return_sale_order_storage')
                ->join('rs left join package po on outer_pack_id>0 and po.id=rs.outer_pack_id
                        left join package pw on within_pack_id>0 and pw.id=rs.within_pack_id')
                ->where('rs.return_sale_order_id in ('.$return_sale_order_id.')')
                ->field('rs.return_sale_order_id as id,(ifnull(po.weight,0)*rs.outer_pack_quantity+ifnull(pw.weight,0)*rs.within_pack_quantity) as weight')
                ->getField('id,weight');
        foreach($prodcut_weight as $key=>$value){
            $weight[$key]   = $value+$package_weight[$key];
        }
        return  $weight;
    }
    public function getPackBoxWeight($pack_box_id){
        //退货单产品重量
        $pack_box_product_weight  = M('pack_box_detail')
                ->join(' pbd left join return_sale_order_storage_detail rd on pbd.return_sale_order_id= rd.return_sale_order_id
                    left join product p on rd.product_id=p.id')
                ->where('pbd.pack_box_id in ('.implode(',', $pack_box_id).')')
                ->field('pbd.pack_box_id as id,sum(if(p.check_status=1,p.check_weight,p.weight)*quantity) as weight')
                ->group('pbd.pack_box_id')
                ->cache(true)
                ->getField('id,weight');
        //包装重量
        $pack_box_package_weight  = M('pack_box')
        ->join('pb left join pack_box_detail pbd on pb.id=pbd.pack_box_id 
                left join return_sale_order_storage rs on pbd.return_sale_order_id= rs.return_sale_order_id
                left join package pp on pb.package_id=pp.id
                left join package po on rs.outer_pack_id>0 and po.id=rs.outer_pack_id 
                left join package pw on rs.within_pack_id>0 and pw.id=rs.within_pack_id
                ')
        ->where('pbd.pack_box_id in ('.implode(',', $pack_box_id).')')
        ->field('pbd.pack_box_id as id,(ifnull(po.weight,0)*rs.outer_pack_quantity+ifnull(pw.weight,0)*rs.within_pack_quantity+pp.weight) as weight')
        ->group('pbd.pack_box_id')
        ->cache(true)
        ->getField('id,weight');
        foreach($pack_box_product_weight as $key=>$value){
            $weight[$key]   = $value+$pack_box_package_weight[$key];
        }
        return  $weight;
    }
	
}