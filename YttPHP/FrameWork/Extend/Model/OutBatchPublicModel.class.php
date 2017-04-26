<?php

/**
 * 库存调整管理
 * @copyright   Copyright (c) 2006 - 2013 Top Union 展联软件友拓通
 * @category   	库存调整
 * @package  	Model
 * @author    	何剑波
 * @version 	2.1,2012-07-22
*/

class OutBatchPublicModel extends RelationCommonModel {
	/// 定义真实表名
	protected $tableName = 'out_batch';
	/// 定义索引字段
	public $id;
	/// 定义表关联
	protected $_link	 = array('detail' => 
									array(
										'mapping_type'	=> HAS_MANY,
										'foreign_key' 	=> 'out_batch_id',
										'class_name'	=> 'out_batch_detail',
									)
								);	
	/// 自动验证设置
	protected $_validate	 =	 array(
			array("transport_start_date",'require',"require",self::EXISTS_VAILIDATE), 
			array("transport_type",'require',"require",self::EXISTS_VAILIDATE), 
			array("",'_validDetail','require',1,'validDetail'),
		);
	/// 验证表单明细
	protected $_validDetail	 =	 array(
			array("pack_box_id",'require',"require",1), //1为必须验证
			array("review_weight",'money',"gt_0_number",self::EXISTS_VAILIDATE), 
//			array("review_long",'money',"gt_0_number",self::EXISTS_VAILIDATE), 
//			array("review_wide",'money',"gt_0_number",self::EXISTS_VAILIDATE), 
//			array("review_high",'money',"gt_0_number",self::EXISTS_VAILIDATE), 
			array("review_cube",'money',"gt_0_number",self::EXISTS_VAILIDATE), 
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
        unset($rs['freight']);
		$rs['detail'] = M('out_batch_detail')
                ->join('obd left join pack_box pb on pb.id=obd.pack_box_id
                    left join pack_box_detail pbd on obd.pack_box_id=pbd.pack_box_id
                    left join package p on p.id=pb.package_id
                    ')
                ->where('out_batch_id='.$id)
                ->group('obd.id')
                ->field('pb.factory_id,obd.id,obd.pack_box_id,count(pbd.id) as quantity,pb.pack_box_no,review_weight, sum(parcel_state<>0) as has_abnormal,ifnull(obd.review_cube,p.cube_long*p.cube_wide*p.cube_high) as review_cube')
                ->select();
        $where['warehouse_id']      = $rs['warehouse_id'];
        $where['transport_type']    = $rs['transport_type'];
        //国内运费
        $domesticShippingFee    = M('DomesticShippingFee')->alias('dsf')->join('left join __DOMESTIC_SHIPPING_FEE_DETAIL__ dsfd on dsf.id=dsfd.domestic_shipping_fee_id')->where($where)->field('dsfd.*')->select();
        
        if(is_array($rs['detail'])&&$rs['detail']){
            foreach($rs['detail'] as $key=>$detail){
                $pack_box_id[$detail['pack_box_id']]    = $detail['pack_box_id'];
                $factory_arr[$detail['factory_id']]     = $detail['factory_id'];
            }
            //装箱单运费    
            $sys_pay_class  = C('OUT_BATCH_SYS_PAY_CLASS');
            $pack_box_fund  = M('PackBox')->join('a left join client_paid_detail cpd on cpd.object_id=a.id and cpd.object_type=131 and cpd.pay_class_id='.intval($sys_pay_class['domesticShippingFee']))
                        ->where('a.id in ('.  implode(',', $pack_box_id).')')->getField('a.id,cpd.should_paid');
            $discount   = getCompanyFactory($factory_arr,'domestic_freight');
            //清关/交接
            if($_GET['customs_clearance'] || $_GET['associate_with'] || ACTION_NAME == 'view'){
                $field  = $_GET['review_weight'] ? 'review_weight' :($_GET['associate_with'] ? 'associate_with_state' : 'customs_clearance_state');
                $state_id   = M('pack_box_detail')->where('pack_box_id in ('.  implode(',', $pack_box_id).')')->select();
                
                foreach($state_id as $state){
                    $detail_state[$state['pack_box_id']][]    = array($state['return_sale_order_id'],$state[$field]);
                }

                $state_name   = C(strtoupper($field));
                
                foreach($rs['detail'] as &$v){
                    //款项表中的费用
                    if($pack_box_fund[$v['pack_box_id']] > 0){
                        $v['freight']   = $pack_box_fund[$v['pack_box_id']];
                    }else{//预计运费
                        if($rs['transport_type'] == C('SEA_TRANSPORT')){//海运
                            $review = $v['review_cube'];
                        }else{//空运
                            $review = $v['review_weight'];
                        }
                        //预计国内运费
                        $v['freight']   = 0;
                        if(!empty($discount)){
                            if($discount[$v['factory_id']]['is_charge']==1){
                                foreach((array)$domesticShippingFee as $fee_value){
                                    if($fee_value['weight_begin'] <= $review && $fee_value['weight_end'] >= $review){
                                        $v['freight']   = $fee_value['price']+$fee_value['price']*$discount[$v['factory_id']]['percentage'];
                                        break;
                                    }
                                }
                            }
                        }
                    }
                    $cc_state   = array();
                    foreach($detail_state[$v['pack_box_id']] as $state_value){//明细中状态一致则显示一致的状态否则不显示
                        $cc_state[$state_value['1']]  = $state_value['1'];
                    }
                    if(count($cc_state)==1){
                        sort($cc_state);
                        $v[$field]   = $cc_state[0];
                        $v[$field.'_name']  = $state_name[$cc_state[0]];
                    }else{
                        $v['state'] = json_encode($detail_state[$v['pack_box_id']]);
                        if($_GET['associate_with']){
                            $v[$field]   = C('ASSOCIATE_WITH_ABNORMAL');
                            $v[$field.'_name']  = C('ASSOCIATE_WITH_STATE.'.C('ASSOCIATE_WITH_ABNORMAL'));
                        } 
                    }
                }
            }
            
            $weight = D('PackBox')->getPackBoxWeight($pack_box_id);
            
            foreach($rs['detail'] as &$value){
                $value['weight']    = $weight[$value['pack_box_id']];
                $value['url']       = U('PackBox/view/','id='.$value['pack_box_id']);
            }
		}
		$rs     = _formatListRelation($rs);
		return $rs;
	}
	 
	/**
	 * 所有订单列表SQL
	 *
	 * @return  array
	 */
	function indexSql(){ 
		$count 	= $this->exists('select 1 from out_batch_detail where out_batch_id=out_batch.id and '.getWhere($_POST['detail']).' and EXISTS(select 1 from pack_box where pack_box_id=pack_box.id and '.getWhere($_POST['pack_box']).')',$_POST['pack_box'])
                ->where(getWhere($_POST['main']))->count();
		$this->setPage($count);
		$ids	= $this->field('id')->exists('select 1 from out_batch_detail where out_batch_id=out_batch.id and '.getWhere($_POST['detail']).' and EXISTS(select 1 from pack_box where pack_box_id=pack_box.id and '.getWhere($_POST['pack_box']).')',$_POST['pack_box'])->where(getWhere($_POST['main']))->order('out_batch_no desc')->page()->selectIds();
		$info['from'] 	= 'out_batch a 
						   LEFT JOIN out_batch_detail b ON a.id = b.out_batch_id
                           LEFT JOIN pack_box c ON b.pack_box_id=c.id
                           LEFT JOIN pack_box_detail d ON d.pack_box_id=c.id';
		$info['group'] 	= ' group by a.id order by out_batch_no desc';
		$info['where'] 	= ' where a.id in'.$ids;
		$info['field'] 	= 'a.id AS id,
						   a.out_batch_no AS out_batch_no,
						   a.transport_start_date  AS transport_start_date,
                           a.transport_type AS transport_type,
                           a.is_associate_with AS is_associate_with,
                           a.is_customs_clearance AS is_customs_clearance,
                           a.is_review_weight AS is_review_weight,
                           sum(b.review_weight) AS review_weight,
                           count(c.id) AS quantity,
                           a.create_time AS create_time
                            ';
		return  'select '.$info['field'].' from '.$info['from'].$info['where'].$info['group'];
	}
	
    public function getOutBatchWeight($out_batch_id){
        $pack_box   = M('out_batch_detail')->where('out_batch_id in ('.implode(',', $out_batch_id).')')->getField('id,out_batch_id,pack_box_id');
        foreach($pack_box as $key=>$value){
            $pack_box_id[$value['pack_box_id']] = $value['pack_box_id'];
            $out_batch_detail[$value['out_batch_id']][] = $value['pack_box_id'];
        }
        $weight = D('PackBox')->getPackBoxWeight($pack_box_id);
        foreach($out_batch_detail as $out_batch_id=>$pack_box_arr){
            foreach($pack_box_arr as $pack_id){
                $out_batch_weight[$out_batch_id]    += $weight[$pack_id];
            }
        }
        return $out_batch_weight;
    }

	public function hasOutBoundAbnormal($id){
		return M('out_batch_detail')->alias('od')->join('inner join __PACK_BOX_DETAIL__ pd on pd.pack_box_id=od.pack_box_id')->where(array('od.out_batch_id' => $id, '_string' => 'parcel_state<>0'))->count() > 0 ? 1 : 0;
	}

	public function hasClearanceAbnormal($id){
		return M('out_batch_detail')->alias('od')->join('inner join __PACK_BOX_DETAIL__ pd on pd.pack_box_id=od.pack_box_id')->where(array('od.out_batch_id' => $id, '_string' => 'customs_clearance_state<>' . C('CUSTOMS_CLEARANCE_NORMAL')))->count() > 0 ? 1 : 0;
	}

    public function outBatchHasCaiNiaoDoc($out_batch_id){
		$where					= cainiao_return_sale_order_where('r', 'rd');
		$where['out_batch_id']	= array('in', $out_batch_id);
		$join					= array(
									'INNER JOIN __PACK_BOX_DETAIL__ pd on pd.`pack_box_id`=od.`pack_box_id`',
									'INNER JOIN __RETURN_SALE_ORDER__ r on pd.return_sale_order_id=r.id ',
									'INNER JOIN __RETURN_SALE_ORDER_DETAIL__ rd on rd.return_sale_order_id=r.id ',
								);
        return M('OutBatchDetail')->alias('od')->join($join)->where($where)->group('out_batch_id')->getField('out_batch_id', true);
    }
}