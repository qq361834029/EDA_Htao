<?php

/**
 * 库存调整管理
 * @copyright   Copyright (c) 2006 - 2013 Top Union 展联软件友拓通
 * @category   	库存调整
 * @package  	Model
 * @author    	何剑波
 * @version 	2.1,2012-07-22
*/

class WarehouseFeePublicModel extends RelationCommonModel {
	/// 定义真实表名
	protected $tableName = 'warehouse_fee';
	/// 定义索引字段
	public $id;
	/// 定义表关联
	protected $_link	 = array('detail' => 
									array(
										'mapping_type'	=> HAS_MANY,
										'foreign_key' 	=> 'warehouse_fee_id',
										'class_name'	=> 'warehouse_fee_detail',
									)
								);
	/// 自动验证设置
	protected $_validate	 =	 array(
			array("warehouse_fee_no",'require',"require",self::EXISTS_VAILIDATE), 
            array("warehouse_fee_no",'','unique',self::EXISTS_VAILIDATE,'unique'),
			array("warehouse_fee_name",'require',"require",self::EXISTS_VAILIDATE),
			array("",'_validDetail','require',self::MUST_VALIDATE,'validDetail'),
		);
	/// 验证表单明细
	protected $_validDetail	 =	 array(
            array("free_days",'z_integer',"z_integer",self::VALUE_VAILIDATE),
//            array("end_days",'z_integer',"z_integer",self::VALUE_VAILIDATE),
//            array("end_days",'start_days','end_days_egt_start_days',self::VALUE_VAILIDATE,'egt'),
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
		$rs             = $this->find($id);
        $warehouse_id   = M('Warehouse')->field('id,w_name,currency_id')->where('to_hide=1 and is_use=1')->formatFindAll(array('key'=>'id'));
		if(getUser('role_type')==C('SELLER_ROLE_TYPE')){
			$percentage	= M('company_factory')->where('factory_id='.getUser('company_id'))->getField('warehouse_percentage');
			if($percentage>0){
				$percentage	= 1+$percentage/100;
				$field	= 'id,warehouse_id,warehouse_fee_id,free_days,first_quarter*'.$percentage.' as first_quarter,second_quarter*'.$percentage.' as third_quarter,'
						.$percentage.' as third_quarter,fourth_quarter*'.$percentage.' as fourth_quarter,over_year*'.$percentage.' as over_year';
			}
		}else{
			$field	= '*';
		}
		$warehouse_fee	= M('WarehouseFeeDetail')->field($field)->where('warehouse_fee_id='.$id)->formatFindAll(array('key'=>'warehouse_id'));
        //未设置的仓库默认为0
        $detail	= array('free_days'=>0, 'first_quarter'=>0, 'second_quarter'=>0, 'third_quarter'=>0, 'fourth_quarter'=>0, 'over_year'=>0);
        foreach($warehouse_id as $key=>$value){
            //未填设置为0
            if(!empty($warehouse_fee[$key])){
                $rs['detail'][$key]   = $warehouse_fee[$key];
            }else{
                $rs['detail'][$key]   = $detail;
				$rs['detail'][$key]['warehouse_id'] = $key;
            }
            $rs['detail'][$key]['w_name']	= $value['w_name'];
			$rs['detail'][$key]['currency_id']	= $value['currency_id'];
        }
		$rs['is_update']	= getUser('role_type')==C('SELLER_ROLE_TYPE') ? 0:1;
		$rs			  = _formatListRelation($rs);
		foreach ($rs['detail'] as $k=>$v){
			$rs['detail'][$k]['w_name']	.= str_replace(array('欧元'), array($v['currency_name']) ,L('EUR_CMB_day'));
		}
		$rs['detail']	= array_merge(array('0'=>''),$rs['detail']);
		unset($rs['detail'][0]);
		return $rs;
	}


    /**
	 * 所有订单列表SQL
	 *
	 * @return  array
	 */
	function indexSql(){ 
		
		$count 	= $this->exists('select 1 from warehouse_fee_detail where warehouse_fee_id=warehouse_fee.id and '.getWhere($_POST['detail']),$_POST['detail'])->where(getWhere($_POST['main']))->count();
		$this->setPage($count);
		$ids	= $this->field('id')->exists('select 1 from warehouse_fee_detail where warehouse_fee_id=warehouse_fee.id and '.getWhere($_POST['detail']),$_POST['detail'])->where(getWhere($_POST['main']))->order('warehouse_fee_no desc')->page()->selectIds();
		$info['from'] 	= 'warehouse_fee a 
						   LEFT JOIN warehouse_fee_detail b ON a.id = b.warehouse_fee_id';
		$info['group'] 	= ' group by a.id order by warehouse_fee_no desc';
		$info['where'] 	= ' where a.id in'.$ids;
		$info['field'] 	= 'a.id AS id,
						   a.warehouse_fee_no AS warehouse_fee_no,
						   a.warehouse_fee_name AS warehouse_fee_name,
                           a.add_user AS add_user';
		return  'select '.$info['field'].' from '.$info['from'].$info['where'].$info['group'];
	}

	/**
	 * 对仓储费信息格式化
	 *
	 * @return array
	 */
	public function setPost(){
		foreach ($_POST['detail'] as $key=>$value){
			if(empty($value['free_days']) && $value['first_quarter']==0 && $value['second_quarter']==0 && $value['third_quarter']==0 && $value['fourth_quarter']==0 && $value['over_year']==0){
				unset($_POST['detail'][$key]);
			}
		}
		parent::setPost();
	}
	
}