<?php
class DomesticShippingFeePublicModel extends RelationCommonModel{
    
    protected $tableName    =   "domestic_shipping_fee";
    
    public $id;
    
    protected $_link        =   array(
        "detail"    =>  array(
            "mapping_type"  =>  HAS_MANY,
            "foreign_key"   =>  "domestic_shipping_fee_id",
            "class_name"    =>  "DomesticShippingFeeDetail",
        )
    );
    
    protected $_validate    =   array(
        array("domestic_shipping_fee_no",'require','require',1),
        array("warehouse_id",'require','require',1),
		array("domestic_shipping_fee_no",'is_no',"valid_error",1),
		array("domestic_shipping_fee_no",'','unique',1,'unique'),
		array("domestic_shipping_fee_name",'require','require',1),
		array("domestic_shipping_fee_name",'',"unique",1,'unique'),//验证唯一
		array("transport_type",'require','require',self::EXISTS_VAILIDATE),
        array("","_validDetail","require",1,"validDetail"),
        array("","_validWeight","require",1,"callbacks")//每条记录起始重量大于上行结束重量
    );
    
    protected $_auto = array(
        array("create_time", "date", 1, "function", "Y-m-d H:i:s"),
        array("update_time", "date", 3, "function", "Y-m-d H:i:s"),
    );
    
    protected $_validDetail =   array(
        array("weight_begin",'require','require',1),//起始重量
        array("weight_begin",'double','double',1),//起始重量
        array("weight_end",'require','require',1),//结束重量
        array("weight_end",'double','double',1),//结束重量
        array('weight_end','weight_begin','weight_limit',1,'gt'),
        array("price",'require','require',1),
        array("price",'double','double',1),
//         array("step_price",'require','require',1),
        array("step_price",'double','double',2),
    );
    
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
//        foreach ($data['detail'] as $key=>$value){
//            if (isset($data['detail'][$key-1]['weight_end']) && $value['weight_begin']){
//                if ($data['detail'][$key-1]['weight_end']>$value['weight_begin']){
//                    $this->error[] =   array(
//                        "name"     =>  "detail[{$key}][weight_begin]",
//                        "value"    =>  L("weight_row_limit"),
//                    );
//                    $this->errorStatus =   2;
//                }
//            }
//        }
    }
    
    public function indexSql(){
        $count          =   $this->count("id");
        $info['from']   =   ' domestic_shipping_fee ';
        $info['where']  =   getWhere($_POST);
        $info['field']  =   ' id,warehouse_id,domestic_shipping_fee_no,domestic_shipping_fee_name,transport_type,comments,to_hide';
        $info['order']  =   ' update_time desc ';
        $info['limit']  =   getLimit($count);
        return ' select '.$info['field'].' from '.$info['from'].' where '.$info['where'].' order by '.$info['order'].$info['limit'];
    }
    
	public function edit(){
        return $this->getInfo();
	}
	
    public function getInfo(){
        $rs		= $this->join('pf left join warehouse w on pf.warehouse_id=w.id')->relation(true)->where('pf.id='.$this->id)->field('pf.*,w.currency_id')->find();
	    $data	= _formatListRelation($rs);
		return $data;
    }

    public function view(){
        return $this->getInfo();
	}
    
}