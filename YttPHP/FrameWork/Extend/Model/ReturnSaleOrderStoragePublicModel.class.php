<?php

/**
 * 库存调整管理
 * @copyright   Copyright (c) 2006 - 2013 Top Union 展联软件友拓通
 * @category   	库存调整
 * @package  	Model
 * @author    	何剑波
 * @version 	2.1,2012-07-22
*/

class ReturnSaleOrderStoragePublicModel extends RelationCommonModel {
	/// 定义真实表名
	protected $tableName = 'return_sale_order_storage';
	/// 定义索引字段
	public $id;
	/// 定义表关联
	protected $_link	 = array(
        'detail' => array(
            'mapping_type' => HAS_MANY,
            'foreign_key' => 'return_sale_order_storage_id',
            'class_name' => 'ReturnSaleOrderStorageDetail',
        ),
    );
	/// 自动验证设置
	protected $_validate	 =	 array(
            array("storage_date","require","require",0),
			array("",'_validDetail','require',1,'validDetail'),
            array("",'validPack','require',1,'callbacks'),
	        array("",'validReason','require',1,'callbacks'),//当入库异常时，异常原因必填      add by lxt 2015.08.30
			array("",'validPicture','require',1,'callbacks'),
		);
	/// 验证表单明细
	protected $_validDetail	 =	 array(
			array("location_id",'pst_integer','require',1), 	
            array("quantity",'return_sale_order_number','return_storage_quantity_chk',1,'elt'), 
			array("quantity",'z_integer','z_integer',0),
	        //产品明细验证       add by lxt 2015.08.31
    	    array("weight",'require',"require",0),
    	    array("cube_long",'money',"double",2),
    	    array("cube_wide",'money',"double",2),
    	    array("cube_high",'money',"double",2),
    	    array("weight",'money',"double",2),
		);
		
	/// 自动填充
    protected $_auto = array(
        array("create_time", "date", 1, "function", "Y-m-d H:i:s"), // 创建时间	
        array("update_time", "date", 3, "function", "Y-m-d H:i:s"), // 更新时间
    );

    /*
     * 包装验证
     */
    public function validPack($data){
        if ($data['outer_pack']==C('CHANGE_PACK') && !empty($data['id'])) {//需更换包装时
            $sub_pack[] = array("outer_pack_id", 'pst_integer', "require", 0);
            $sub_pack[] = array("outer_pack_quantity", 'pst_integer', "pst_integer", 0);
        }
        if ($data['within_pack']==C('CHANGE_PACK') && !empty($data['id'])) {
            $sub_pack[] = array("within_pack_id", 'pst_integer', "require", 0);
            $sub_pack[] = array("within_pack_quantity", 'pst_integer', "pst_integer", 0);
        }
        return $this->_validSubmit($data, $sub_pack);
    }

    //入库异常原因验证      add by lxt 2015.08.30
    public function validReason($data){
        if ($data['storage_abnormal']){
            $reason_valid   =   array(
                array('storage_abnormal_reason','require','require',1),
            );
            $this->_validSubmit($data,$reason_valid);
        }
    }

    /*
     * 退货服务含有拍照服务则必须上传附件
     */
    public function validPicture($data){
		if (cainiao_return_sale_order_id($data['return_sale_order_id']) > 0) {
			foreach ($data['service'] as $service) {
				if (in_array($service['service_detail_id'], array(C('PICTURE_GENERAL'), C('PICTURE_3C')))) {
					$where	= array(
								'relation_type' => $data['type'],
							);
					if ($data['id'] > 0) {
						$where['relation_id'] = $data['id'];
					} else {
						$where['tocken'] = $data['tocken'];
					}
					$count	= M('Gallery')->where($where)->count();
					if ($count <= 0) {
						$error	= array(
									array( 'name' => 'file_upload', 'value' => L('picture_service_not_picture'))
								);
						$this->addError($error);
					}
					break;
				}
			}
		}
    }

    /**
	 * 查看调整明细
	 *
	 * @return  array
	 */
	public function view(){ 
		return $this->getInfoReturnSaleOrderStorage($this->id);
	}
	
	/**
	 * 编辑调整明细
	 *
	 * @return  array
	 */
	public function edit(){
		return $this->getInfoReturnSaleOrderStorage($this->id);
	}
    /**
	 * 所有订单列表SQL
	 *
	 * @return  array
	 */
	public function indexSql(){ 
		return $this->getReturnSaleOrderListSql(); 
	}
	
	protected function getReturnSaleOrderListSql($where=null){
        if($_POST['sale_order']['query']['order_type']=="-2"){
            unset($_POST['sale_order']);
        }
        if($_POST['set_post']['query']['is_out_batch'] === C('NO_OUT_BATCH')){//added by 20150924 处理为出库
            $_POST['return_sale_order']['in']['return_sale_order_state'] = C('RETURN_SALE_ORDER_STATE_NO_OUT');
        }elseif($_POST['set_post']['query']['is_out_batch'] === C('YES_OUT_BATCH')){
            $_POST['return_sale_order']['in']['return_sale_order_state'] = C('RETURN_SALE_ORDER_STATE_IS_OUT');
        }else{
            $_POST['return_sale_order']['in']['return_sale_order_state'] = C('STORAGE_SHOW_STATE');
        }
        $_POST['return_sale_order_storage_detail']['morethan']['quantity']   = '1';
		$where && $where = ' and '.$where;
		$order					= 'a.update_time desc';
		$exists_detail_sql		= 'select 1 from return_sale_order_detail inner join product on product.id=return_sale_order_detail.product_id where return_sale_order_id=b.id and '.getWhere($_POST['return_sale_order_detail']);
		$exists_sale_sql		= 'select 1 from sale_order where sale_order.id=a.sale_order_id and '.getWhere($_POST['sale_order']);
		$exists_client_sql		= 'select 1 from client where client.id=b.client_id and '.getWhere($_POST['client']);
		$exists_addition_sql	= 'select 1 from return_sale_order_addition where return_sale_order_addition.return_sale_order_id=b.id and '.getWhere($_POST['return_sale_order_addition']);
        $exists_location_sql    = 'select 1 from return_sale_order_storage_detail inner join location on return_sale_order_storage_detail.location_id=location.id  where return_sale_order_storage_id=a.id and'.getWhere($_POST['return_sale_order_storage_detail']);
        $exists_return_sql      = 'select 1 from return_sale_order where return_sale_order.id=a.return_sale_order_id and '.getWhere($_POST['return_sale_order']);
        $exists_state_log_sql   = 'select 1 from state_log where state_log.object_id=a.return_sale_order_id and object_type='.array_search('ReturnSaleOrder', C('STATE_OBJECT_TYPE')).' and state_id='.C('RETURN_FOR_DELIVERY').' and '.  getWhere($_POST['state_log']);
        $where					= getWhere($_POST['main']).$where;//.' and return_sale_order_state in('.C('STORAGE_SHOW_STATE').')' RETURN_SHELVES    =>  STORAGE_SHOW_STATE      edit by lxt 2015.08.30
        $count					= $this
								->exists($exists_detail_sql, $_POST['return_sale_order_detail'])
								->exists($exists_sale_sql, $_POST['sale_order'])
								->exists($exists_client_sql, $_POST['client'])
								->exists($exists_addition_sql, $_POST['return_sale_order_addition']) 
                                ->exists($exists_location_sql, $_POST['return_sale_order_storage_detail'])
                                ->exists($exists_return_sql,$_POST['return_sale_order']) 
                                ->exists($exists_state_log_sql,$_POST['state_log'])
                                ->join('as a left join return_sale_order as b on a.return_sale_order_id=b.id')
								->where($where)
								->order($order)
								->count();
		$this->setPage($count);
		$ids					= $this->field('a.id')
								->exists($exists_detail_sql, $_POST['return_sale_order_detail'])
								->exists($exists_sale_sql, $_POST['sale_order'])
								->exists($exists_client_sql, $_POST['client'])
								->exists($exists_addition_sql, $_POST['return_sale_order_addition']) 
                                ->exists($exists_location_sql, $_POST['return_sale_order_storage_detail'])
                                ->exists($exists_return_sql,$_POST['return_sale_order']) 
                                ->exists($exists_state_log_sql,$_POST['state_log'])
                                ->join('as a left join return_sale_order as b on a.return_sale_order_id=b.id')
								->where($where)
								->order($order)
								->page()
								->selectIds();
		$info['from']	= ' return_sale_order_storage e 
                            left join return_sale_order_storage_detail g on e.id=g.return_sale_order_storage_id
                            left join return_sale_order a on a.id=e.return_sale_order_id
							left join return_sale_order_detail b on(a.id=b.return_sale_order_id) 
							left join sale_order c on(a.sale_order_id=c.id) 
							left join return_sale_order_addition f on(f.return_sale_order_id=a.id)
							left join client d on d.id=a.client_id';		
		$info['where']	= ' where e.id in '.$ids;
		$info['group']	= ' group by a.id order by e.update_time desc';
		$info['field']	= ' e.is_deal,a.client_id,d.comp_name as client_name,d.comp_no as client_no,d.email as comp_email,a.order_no,c.order_type,f.consignee,
							group_concat(distinct b.product_id) as p_ids,
							a.id as return_sale_order_id,a.return_sale_order_no,a.factory_id,a.sale_order_id,a.sale_order_no,a.return_sale_order_state,
							a.return_order_date,if(a.add_user=' . getUser('id') . ',1,0) as is_self,a.return_reason,
							count(distinct b.product_id) as product_qn,a.add_user,e.id';
		return  'select '.$info['field'].' from '.$info['from'].$info['where'].$info['group']; 
	}
    
    public function getExcelListId($data){
        if($data['sale_order']['query']['order_type']=="-2"){
            unset($data['sale_order']);
        }
        if($data['setdata']['query']['is_out_batch'] === C('NO_OUT_BATCH')){//added by 20150924 处理为出库
            $data['return_sale_order']['in']['return_sale_order_state'] = C('RETURN_SALE_ORDER_STATE_NO_OUT');
        }elseif($data['setdata']['query']['is_out_batch'] === C('YES_OUT_BATCH')){
            $data['return_sale_order']['in']['return_sale_order_state'] = C('RETURN_SALE_ORDER_STATE_IS_OUT');
        }else{
            $data['return_sale_order']['in']['return_sale_order_state'] = C('STORAGE_SHOW_STATE');
        }
		$where && $where = ' and '.$where;
		$order					= 'a.update_time desc';
		$exists_detail_sql		= 'select 1 from return_sale_order_detail inner join product on product.id=return_sale_order_detail.product_id where return_sale_order_id=b.id and '.getWhere($data['return_sale_order_detail']);
		$exists_sale_sql		= 'select 1 from sale_order where sale_order.id=a.sale_order_id and '.getWhere($data['sale_order']);
		$exists_client_sql		= 'select 1 from client where client.id=b.client_id and '.getWhere($data['client']);
		$exists_addition_sql	= 'select 1 from return_sale_order_addition where return_sale_order_addition.return_sale_order_id=b.id and '.getWhere($data['return_sale_order_addition']);
        $exists_location_sql    = 'select 1 from return_sale_order_storage_detail inner join location on return_sale_order_storage_detail.location_id=location.id  where return_sale_order_storage_id=a.id and'.getWhere($data['return_sale_order_storage_detail']);
        $exists_return_sql      = 'select 1 from return_sale_order where return_sale_order.id=a.return_sale_order_id and '.getWhere($data['return_sale_order']);
        $exists_state_log_sql   = 'select 1 from state_log where state_log.object_id=a.return_sale_order_id and object_type='.array_search('ReturnSaleOrder', C('STATE_OBJECT_TYPE')).' and state_id='.C('RETURN_FOR_DELIVERY').' and '.  getWhere($data['state_log']);
        $where					= getWhere($data['main']).$where;//.' and return_sale_order_state in('.C('STORAGE_SHOW_STATE').')' RETURN_SHELVES    =>  STORAGE_SHOW_STATE      edit by lxt 2015.08.30
		$ids					= $this->field('a.id')
								->exists($exists_detail_sql, $data['return_sale_order_detail'])
								->exists($exists_sale_sql, $data['sale_order'])
								->exists($exists_client_sql, $data['client'])
								->exists($exists_addition_sql, $data['return_sale_order_addition']) 
                                ->exists($exists_location_sql, $data['return_sale_order_storage_detail'])
                                ->exists($exists_return_sql,$data['return_sale_order']) 
                                ->exists($exists_state_log_sql,$data['state_log'])
                                ->join('as a left join return_sale_order as b on a.return_sale_order_id=b.id')
								->where($where)
								->order($order)
								->selectIds();
		return $ids; 
	}
    public function getExcelListSQL($ids){
        $info['from']	= ' return_sale_order_storage e 
                            left join return_sale_order_storage_detail g on e.id=g.return_sale_order_storage_id
                            left join return_sale_order a on a.id=e.return_sale_order_id
							left join return_sale_order_detail b on(a.id=b.return_sale_order_id) 
							left join sale_order c on(a.sale_order_id=c.id) 
							left join return_sale_order_addition f on(f.return_sale_order_id=a.id)
							left join client d on d.id=a.client_id';		
		$info['where']	= ' where e.id in '.$ids;
		$info['group']	= ' group by a.id order by e.update_time desc';
		$info['field']	= ' e.is_deal,a.client_id,d.comp_name as client_name,d.comp_no as client_no,d.email as comp_email,a.order_no,c.order_type,f.consignee,
							group_concat(distinct b.product_id) as p_ids,
							a.id as return_sale_order_id,a.return_sale_order_no,a.factory_id,a.sale_order_id,a.sale_order_no,a.return_sale_order_state,
							a.return_order_date,if(a.add_user=' . getUser('id') . ',1,0) as is_self,a.return_reason,
							count(distinct b.product_id) as product_qn,a.add_user,e.id';
		return  'select '.$info['field'].' from '.$info['from'].$info['where'].$info['group'];
    }

        public function returnStorageUpdate($params=NULL){
        $info = $this->getPostInfo($params);
        $this->_validDetail = '';
        if ($this->create($info)) {
            $this->id = $info['id'];
            $this->_beforeModel($info);
            $r = $this->relation(true)->save();
            if (false === $r) {
                $this->error_type = 2;
                return false;
            }
            $this->_afterModel($info);
        } else {
            $this->error_type = 1;
            return false;
        }
    }
    
    public function returnStorageInsert($params=NULL,$execTags=FALSE) { 
        $info           = $this->getPostInfo($params); 
        $this->_validDetail ='';
        if ($this->create($info)) {	 
			if($this->_beforeModel($info) == false){
				$this->error_type	= 1;
				return false;
			}
			$id = $this->relation(true)->add();   
			if (false === $id) {
				$this->error_type	=	2;
				return false; 
			}	 
			$this->id	=	$id;  
			empty($info) ? $_POST['id'] = $id : $info['id'] = $id; 
			$this->_afterModel($info); 
            if($execTags){
                $this->execTags($info);   
            }
		} else {     
			$this->error_type	=	1; 
			return false; 
		} 
    }
    
	public  function returnStorageDelete($id,$module=null) {
			$this->id = $id;
			$info = array('id'=>$id);
			$this->_beforeModel($info);
			$r = $this->relation(true)->delete($id); 
			if (false === $r) {
				halt($this->getError());
			}
			$info['id']	=	$this->id;
			$module && $info['method_name'] = $module;
            $this->_afterModel($info); 
            $this->_module  = 'ReturnSaleOrderStorage';
			$this->_action	= 'delete';
			$this->execTags($info); 
	}
    public function storageDelete($id){
			$this->id = $id;
			$info = array('id'=>$id);
			$this->_beforeModel($info);
			//丢弃数量也清空        edit by lxt 2015.09.02
			$r  = M('ReturnSaleOrderStorage')->execute('update return_sale_order_storage_detail set quantity = 0,drop_quantity=0 where return_sale_order_storage_id=' . $this->id);
            $return_pack  = M('ReturnSaleOrderStorage')->execute('update return_sale_order_storage set within_pack_quantity = 0,outer_pack_quantity=0  where id=' . $this->id);
			if (false === $r ||$return_pack===false) {
				halt($this->getError());
			}
			$info['id']	=	$this->id;
            $this->_afterModel($info,'delete'); 
			$this->execTags($info); 
    }
    
    public function getPostInfo($params){
        //退货单基本信息
        empty($params)  && $params=$_POST;
        $info['storage_date']           = $params['return_order_date'];
        $info['return_sale_order_id']   = empty($params['id'])? $params['return_sale_order_id']:$params['id'];
        $info['sale_order_id']          = $params['sale_order_id'];
        $info['warehouse_id']           = $params['warehouse_id'];
        $info['detail']                 = $params['detail'];
        $info['outer_pack']             = $params['outer_pack'];
        $info['outer_pack_id']          = $params['outer_pack_id'];
//        $info['outer_pack_quantity']    = $params['outer_pack_quantity'];
        $info['within_pack']            = $params['within_pack'];
        $info['within_pack_id']         = $params['within_pack_id'];
//        $info['within_pack_quantity']   = $params['within_pack_quantity'];
        if (MODULE_NAME=='ReturnSaleOrderStorage'){
            $info['outer_pack_quantity']    = $params['outer_pack_quantity'];
            $info['within_pack_quantity']   = $params['within_pack_quantity'];
        }
        
        //判断是否只有图片服务        add by lxt 2015.09.24
        if ($info['return_sale_order_id']){
            //图片服务
            $picture_service_id =   M('ReturnServiceDetail')->where('return_service_id='.C('PICTURE'))->getField('id',true);
            //该退货单的总服务数量
            $total_service      =   M('ReturnSaleOrderDetailService')->where('return_sale_order_id='.$info['return_sale_order_id'])->count();
            //该退货单的图片服务数量
            $pic_service        =   M('ReturnSaleOrderDetailService')->where('return_sale_order_id='.$info['return_sale_order_id'].' and service_detail_id in ('.join(',', $picture_service_id).')')->count();
            //如果二者相等，说明只有图片服务
            if ($total_service==$pic_service){
                $info['only_pic']   =   1;
            }else{
                $info['only_pic']   =   0;
            }
        }
        
        //退货单明细信息
        if(!empty($params['id'])){
            $storage_detail_id              = M('return_sale_order_storage_detail')->where('return_sale_order_id='.$params['id'])->getField('product_id,id');
            $detail_id                      = M('return_sale_order_detail')->where('return_sale_order_id='.$params['id'])->getField('product_id,id');
        }
        foreach($info['detail'] as $key=>$value){
            if(empty($value['product_id'])){
                unset($info['detail'][$key]);
            }else{
				if ($info['warehouse_id'] <= 0) {
					$info['warehouse_id']	= $value['warehouse_id'];
				}
                $info['detail'][$key]['sale_order_id']              = $params['sale_order_id'];                
                $info['detail'][$key]['return_sale_order_id']       = empty($params['id'])? $params['return_sale_order_id']:$params['id'];
                if(MODULE_NAME=='ReturnSaleOrderStorage'){
                    $info['detail'][$key]['quantity']                   = $params['detail'][$key]['quantity'];
                }else{
                    $info['detail'][$key]['quantity']                   = empty($params['storage'][$key]['in_quantity'])?0:$params['storage'][$key]['in_quantity'];
                }
                $info['detail'][$key]['location_id']                = empty($params['detail'][$key]['location_id'])?0:$params['detail'][$key]['location_id'];
                $location_id[$info['detail'][$key]['location_id']]  = $info['detail'][$key]['location_id'];
                if(empty($params['storage'][$key]['id']) && !empty($params['id'])){
                    $return_sale_order_storage_id   = M('return_sale_order_storage')->where('return_sale_order_id='.$params['id'])->getField('id');
                }
                $info['id']                                         = $return_sale_order_storage_id;
                $info['detail'][$key]['return_sale_order_number']   = $params['storage'][$key]['return_sale_order_number'];
                if(!empty($storage_detail_id)){
                    $info['detail'][$key]['id']                     = $storage_detail_id[$value['product_id']];
                }else{
                    unset($info['detail'][$key]['id']);
                }
            }
        }
        if(!empty($location_id)){
            $location           = M('location')->where('id in ('.  implode(',',$location_id).')')->getField('id,warehouse_id');//按实际库位存入不用仓库
            foreach ($info['detail'] as &$val){
                $val['warehouse_id']    = empty($location[$val['location_id']])?0:$location[$val['location_id']];
            }
        }
        return $info;
    }
    public function getInfoReturnSaleOrderStorage($return_sale_order_storage_id){
        $storage_info   = $this->where('id='.$return_sale_order_storage_id)->find();
        $id     = $storage_info['return_sale_order_id'];
        $where	= 'id=' . $id . getBelongsWhere();
		$rs		= M('return_sale_order')->where($where)->find();
		$rs['return_sale_order_id']			= $id;
        $rs['id']							= $return_sale_order_storage_id;
		$rs['return_sale_order_storage_id'] = $return_sale_order_storage_id;
		$rs['lock_version']					= $storage_info['lock_version'];;
        $rs['within_pack_quantity']         = $storage_info['within_pack_quantity'];
        $rs['outer_pack_quantity']          = $storage_info['outer_pack_quantity'];
		if (false === $rs || $rs == null) { /// 记录不存在或没权限查看该记录
			halt(L('data_right_error'));
		}
		$sql = ' select a.*,    
				(a.quantity) as sum_quantity
				from return_sale_order_detail as a
				where a.return_sale_order_id='.$id.'
				group by a.id order by id';  
		$rs['detail'] = M('return_sale_order')->db->query($sql);
		
		$model=D('ReturnSaleOrder');
		$return_service=$model->getReturnService($id);
		foreach ($rs['detail'] as &$temp_row){
			if(isset($return_service[$temp_row['id']])){
				$temp_row['return_service_no'] =   $return_service[$temp_row['id']]['return_service_no'];
			}
		}		
		//卖家只能修改待处理的退货单
		$is_factory        = 0;
		if(getUser('role_type')==C('SELLER_ROLE_TYPE')){
			$rs['is_update'] = in_array($rs['return_sale_order_state'], explode(',',C('SELLER_CAN_EDIT_RETURN_STATE'))) ? 1:0;
			$is_factory      = 1;
		} 
        $location_id    =   M('return_sale_order_storage_detail')->where('return_sale_order_id='.$id)->getField('id,product_id,location_id,quantity,return_sale_order_storage_id,sale_order_id,id');
        $sql = 'select a.*
				from return_sale_order_detail_service as a
				where a.return_sale_order_id='.$id.'
				group by a.id order by id';  
		$rs['service'] = M('return_sale_order')->db->query($sql); 
		
		//退货处理费       add by lxt 2015.08.14
		$sys_pay_class        =   C('SYS_PAY_CLASS');
		$fee                  =   M('PaidDetail')->where('object_id='.$id.' and object_type=123 and comp_type=1 and to_hide=1')->getField('pay_class_id,money');
		$fee[$sys_pay_class['returnProcessFee']]  &&  $rs['return_process_fee'] =   moneyFormat($fee[$sys_pay_class['returnProcessFee']],0,C('MONEY_LENGTH'));
		
		foreach((array)$rs['service'] as $k => $v){
			$service_key = $v['return_sale_order_id'].'_'.$v['return_sale_order_detail_id'].'_'.$v['relation_id'];
			$service_data[$service_key][] = array(
								"0" => $v['service_detail_id'],
								"1" => $v['quantity'],
								"2" => moneyFormat($v['price'],0,2,false)
			); 
			//服务明细id     add by lxt 2015.09.02
			$service_detail_id[]    =   $v['service_detail_id'];
		}
		//判断是否有图片服务       add by lxt 2015.09.02
		if (count($service_detail_id)>0){
		    $service_id   =   M('ReturnServiceDetail')->where('id in('.join(',',$service_detail_id).')')->getField('return_service_id',true);
		    if (in_array(C('PICTURE'), $service_id)){
		        $rs['is_picture'] =   true;
		    }
		}
		
		foreach((array)$rs['detail'] as $key => $val){
            if($val['quantity']<=0){
                unset($rs['detail'][$key]);
                continue;
            }
            //产品id
            if ($val['product_id']){
                $product_id[]   =   $val['product_id'];
            }
			$rs['warehouse_id']								= $val['warehouse_id'];
			$rs['detail'][$key]['return_sale_order_state'] = $rs['return_sale_order_state'];
			$rs['detail'][$key]['is_factory']			   = $is_factory;
			$detail_key = $val['return_sale_order_id'].'_'.$val['id'].'_'.$val['relation_id'];
			if(array_key_exists($detail_key, $service_data)){ 
				$rs['detail'][$key]['return_service']      = json_encode($service_data[$detail_key]);
			}
			$rs['detail'][$key]['no_show']				   = 0;
			if((ACTION_NAME=='view'||(ACTION_NAME=='edit'&&getUser('role_type')!=C('SELLER_ROLE_TYPE')))&&$val['quantity']==0){
				$rs['detail'][$key]['no_show']			   = 1; 
			} 
            if(!empty($location_id)) {
                foreach($location_id as $key_id=>$value){
                    if($rs['detail'][$key]['product_id'] == $value['product_id']){
                        $rs['detail'][$key]['location_id']          = $value['location_id'];
                        $rs['detail'][$key]['location_no']          = getLocationNo($value['location_id']);
                        $rs['detail'][$key]['in_quantity']          = $value['quantity'];
                        $rs['detail'][$key]['sale_order_id']        = $value['sale_order_id'];
                        $rs['detail'][$key]['return_sale_order_detail_id']     = $value['return_sale_order_detail_id'];
                        $rs['detail'][$key]['return_sale_order_storage_id']     = $value['return_sale_order_storage_id'];
                        $rs['detail'][$key]['id']                   = $value['id'];
                        unset($location_id[$key_id]);
                        break;
                    }
                }
            }
        }
		$client				= M('Client')->field('comp_name as client_name,comp_no as client_no,email as comp_email')->find($rs['client_id']);
		if($client){
			$rs				= array_merge($rs,$client);
		}		
		if ($rs['is_related_sale_order'] == C('IS_RELATED_SALE_ORDER')) {
			$sale_order		   = M('sale_order');
			$sale_order_data   = $sale_order->field('warehouse_id,client_id,order_date,order_no,track_no')->where('id='.$rs['sale_order_id'])->find();  
			if (!isset($sale_order_data) || empty($sale_order_data)) { /// 记录不存在或没权限查看该记录
				halt(L('data_right_error'));
			}
			$rs					= array_merge($rs,$sale_order_data);
		}
		//读取产品信息      add by lxt 2015.09.09
		if (count($product_id)>0){
		    $product_info =   M('Product')->where(array('id'=>array('in',$product_id)))->getField('id,check_status,check_weight,check_long,check_wide,check_high,weight,cube_high,cube_long,cube_wide,product_name,product_no,custom_barcode');
		    foreach ($rs['detail'] as &$temp_row){
		        if (isset($product_info[$temp_row['product_id']])){
		            $temp_row['check_status'] =   $product_info[$temp_row['product_id']]['check_status'];
					$temp_row['product_name'] =   $product_info[$temp_row['product_id']]['product_name'];
					$temp_row['product_no'] =   $product_info[$temp_row['product_id']]['product_no'];
					$temp_row['custom_barcode'] =   $product_info[$temp_row['product_id']]['custom_barcode'];
		            $temp_row['weight']       =   $temp_row['check_status']==1?$product_info[$temp_row['product_id']]['check_weight']:$product_info[$temp_row['product_id']]['weight'];
		            $temp_row['cube_long']    =   $temp_row['check_status']==1?$product_info[$temp_row['product_id']]['check_long']:$product_info[$temp_row['product_id']]['cube_long'];
		            $temp_row['cube_high']    =   $temp_row['check_status']==1?$product_info[$temp_row['product_id']]['check_high']:$product_info[$temp_row['product_id']]['cube_high'];
		            $temp_row['cube_wide']    =   $temp_row['check_status']==1?$product_info[$temp_row['product_id']]['check_wide']:$product_info[$temp_row['product_id']]['cube_wide'];
		        }
		    }
		}
		//入库是否异常        add by lxt 2015.08.31
		if ($storage_info['storage_abnormal_reason']){
		    $rs['storage_abnormal'] =   1;
		    $rs['storage_abnormal_reason']  =   $storage_info['storage_abnormal_reason'];
		}else{
		    $rs['storage_abnormal']   =   0;
		}
		$rs['is_hand']  =   $storage_info['is_hand'];
		$rs					= _formatListRelation($rs);
		//图片服务        add by lxt 2015.08.31
		$model		=	D('Gallery');
		$rs['pics'] = $model->getAry($return_sale_order_storage_id,27);
		//明细中产品信息st     add by lxt 2015.08.31
		foreach ($rs['detail'] as &$value){
		    $rs['detail_total']['total_weight']   +=  intval($value['in_quantity'])*intval($value['weight']);
		    $value['total_weight']    =   moneyFormat(intval($value['in_quantity'])*intval($value['weight']),0,C('CUBE_LENGTH'));
		    $value['cube_long']       =   moneyFormat($value['cube_long'],0,C('CUBE_LENGTH'));
		    $value['cube_wide']       =   moneyFormat($value['cube_wide'],0,C('CUBE_LENGTH'));
		    $value['cube_high']       =   moneyFormat($value['cube_high'],0,C('CUBE_LENGTH'));
		    $value['weight']          =   moneyFormat($value['weight'],0,C('CUBE_LENGTH'));
		}
		$rs['detail_total']['total_weight']   =   moneyFormat($rs['detail_total']['total_weight'],0,C('CUBE_LENGTH'));
		//明细中产品信息ed
		$rs['outer_pack_name']   = SOnly('package',$rs['outer_pack_id'], 'package_name');
        $rs['within_pack_name']   = SOnly('package',$rs['within_pack_id'], 'package_name');
        $rs['currency_no']  = SOnly('currency', $rs['w_currency_id'],'currency_no');
		return $rs;
    }
    //格式化数据     add by lxt 2015.09.02
    public function setPost(){
        //如果入库没有异常，清空入库异常原因
        !$_POST['storage_abnormal'] &&  $_POST['storage_abnormal_reason']   =   0;
        //只有处理操作需要特殊处理数据
        if (ACTION_NAME=='updateDeal'){
            //标记是否处理,用于取消编辑和删除按钮
            $_POST['is_deal']   =   1;
        }
        //用于标记是否只有图片服务
        $not_only_tag   =   0;
        //图片服务
        $picture_service_id =   M('ReturnServiceDetail')->where('return_service_id='.C('PICTURE'))->getField('id',true);
        //丢弃服务
        $drop_service   =   M('ReturnServiceDetail')->where('return_service_id='.C('DOWN_AND_DESTORY'))->getField('id',true);
        //如果明细中有丢弃服务，记录丢弃数量，便于做库存扣减和库存验证
        foreach ($_POST['detail'] as $key=>&$value){
            if (intval($value['product_id'])>0 && intval($value['quantity'])>0){
                $return_service =   $value['return_service'];
                $return_service =   json_decode(htmlspecialchars_decode(stripcslashes($return_service)),true);
                if ($return_service && is_array($return_service)){
                    foreach ($return_service as $k=>$row){
                        //只有处理操作需要特殊处理丢弃数量
                        if (ACTION_NAME=='updateDeal' && in_array($row[0], $drop_service)){
                            $value['drop_quantity'] +=   $row[1];
                        }
                        
                        //用于更新退货服务方式
                        if(count($row)==3 && intval($row[0])>0 && intval($row[1])>0){
                            //是否只有图片服务
                            if (!in_array($row[0],$picture_service_id)){
                                $not_only_tag   +=  1;
                            }
                            $array[C('RETURN_SERVICE_DETAIL_ID')]	= $row[0];
                            $array[C('RETURN_SERVICE_QUANTITY')]	= $row[1];
                            $array[C('RETURN_SERVICE_PRICE')]		= trim($row[2]);
                            $array['return_sale_order_id']          = $value['return_sale_order_id'];
                            $array['relation_id']					= $value['relation_id'];
                            $_POST['service'][]						= $array;
                        }
                    }
                    //丢弃数量不能超过实际入库数量
                    if ($value['drop_quantity']>$value['quantity']){
                        $this->error_type   =   2;
                        $this->error[]  =   array(
                            "name"  =>  "detail[{$key}][quantity]",
                            "value" =>  L('drop_over_storage'),
                        );
                    }
                }
            }
        }
        //是否只有图片服务
        if ($not_only_tag){
            $_POST['only_pic']  =   0;
        }else{
            $_POST['only_pic']  =   1;
        }
        $this->Mdate	=	$_POST;
        return $_POST;
    }
    //删除处理      add by lxt 2015.09.06
    public function deleteDeal($id){
        $this->_brf();
        $this->id = $id;
        $detail     =   M('ReturnSaleOrderStorageDetail');
        $deal_flag  =   $this->where('id='.$this->id)->setField(array('is_deal'=>0,'is_hand'=>0));
        $drop_flag  =   $detail->where('return_sale_order_storage_id='.$this->id)->setField('drop_quantity',0);
        if ($deal_flag===false || $drop_flag===false){
            throw_json(L('_ERROR_ACTION_'));
        }
        $info['id']	=	$this->id;
        $this->execTags($info);
    }                 
}