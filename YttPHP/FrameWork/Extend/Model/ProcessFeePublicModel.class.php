<?php

/**
 * 处理费用管理
 * @author    	lxt
*/

class ProcessFeePublicModel extends RelationCommonModel {
	
	/// 定义真实表名
	protected $tableName = 'process_fee';
	
	public $id =   '';
	
	//关联
	protected $_link   =   array(
	    'detail'   =>  array(
	        'mapping_type' =>  HAS_MANY,
	        'foreign_key'  =>  'process_fee_id',
	        'class_name'   =>  'ProcessFeeDetail'
	    )
	);
	
	/// 自动验证设置
	protected $_validate	 =	 array(
			array("process_fee_no",'require','require',1),
			array("order_type",'require','require',1),
            array("warehouse_id",'require','require',1),
			array("process_fee_no",'is_no',"valid_error",1), 
			array("process_fee_no",'','unique',1,'unique'),
			array("process_fee_name",'require','require',1),
			array("process_fee_name",'',"unique",1,'unique'),//验证唯一  
			array("shipping_type",'require','require',1),
            array("","_validDetail","require",1,"validDetail"),
	        array("","_validAccordType","require",1,"callbacks"),//按数量需验证增加数量费用和封顶费用
	        array("","_validWeight","require",1,"callbacks")//每条记录起始重量大于上行结束重量
	);	
    
	//按重量验证，明细表
	protected $_validDetail    =   array(
	    array("weight_begin",'require','require',1),//起始重量
	    array("weight_begin",'double','double',1),//起始重量
	    array("weight_end",'require','require',1),//结束重量
	    array("weight_end",'double','double',1),//结束重量
	    array('weight_end','weight_begin','weight_limit',1,'gt'),
	    array("price",'require','require',1),
	    array("price",'double','double',1),
	);
	
	//按数量
	protected $_validAccordQuantity    =   array(
	    array("step_price",'require','require',1),
	    array("step_price",'double','double',1),
	    array("max_price",'require','require',1),
	    array("max_price",'double','double',1),
	);
		
	/// 自动填充
	protected $_auto = array(
		array("create_time", "date", 1, "function", "Y-m-d H:i:s"),
		array("update_time", "date", 3, "function", "Y-m-d H:i:s"),
	);
	
	//按类型验证数据
	public function _validAccordType($data){
	    //按数量要增加验证规则
	    if ($data['accord_type']==1){
	        $this->_validSubmitDetail($data,$this->_validAccordQuantity);
	    }
	}
	
	//循环验证每条明细的起始重量必须大于上一条的结束重量 
	public function _validWeight($data){
        //add by yyh 20151015 明细重量区间可不连贯
        foreach($data['detail'] as $key=>$val){
            if(isset($detail[$val['weight_begin']]) && !empty($val['weight_begin'])){
                    $this->error[] =   array(
	                    "name"     =>  "detail[{$key}][weight_begin]",
	                    "value"    =>  L("weight_row_limit"),
	                );
	                $this->errorStatus =   2;
            }else{
                $val['key'] = $key;
                $detail[$val['weight_begin']] = $val;
            }
        }
        ksort($detail);
        $detail = array_values($detail);
	    foreach ($detail as $key=>$value){
            if(!empty($detail[$key-1]['weight_end']) || !empty($detail[$key-1]['weight_begin'])){
                if (isset($detail[$key-1]['weight_end']) && $value['weight_begin']){
                    if ($detail[$key-1]['weight_end']>=$value['weight_begin']){
                        $this->error[] =   array(
                            "name"     =>  "detail[{$value['key']}][weight_begin]",
                            "value"    =>  L("weight_row_limit"),
                        );
                        $this->errorStatus =   2;
                    }
                }
            }
	    }
//	    foreach ($data['detail'] as $key=>$value){
//	        if (isset($data['detail'][$key-1]['weight_end']) && $value['weight_begin']){
//	            if ($data['detail'][$key-1]['weight_end']>$value['weight_begin']){
//	                $this->error[] =   array(
//	                    "name"     =>  "detail[{$key}][weight_begin]",
//	                    "value"    =>  L("weight_row_limit"),
//	                );
//	                $this->errorStatus =   2;
//	            }
//	        }
//	    }
	}
	
	public function indexSql(){
	    $count          =   $this->count("id");
	    $info['from']   =   ' process_fee ';
	    $info['where']  =   getWhere($_POST);
	    $info['field']  =   ' * ';
	    $info['order']  =   ' update_time desc ';
	    $info['limit']  =   getLimit($count);
	    return ' select '.$info['field'].' from '.$info['from'].' where '.$info['where'].' order by '.$info['order'].$info['limit'];
	}
	
	public function edit(){
        return $this->getInfo();
	}
	
    public function getInfo(){
        $rs = $this->join('pf left join warehouse w on pf.warehouse_id=w.id')->relation(true)->where('pf.id='.$this->id)->field('pf.*,w.currency_id')->select();
	    return _formatListRelation($rs[0]);
    }

    public function view(){
        return $this->getInfo();
	}
	
}