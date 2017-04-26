<?php 

/**
 * 退换货管理
 * @copyright   Copyright (c) 2006 - 2013 TOP UNION 展联软件友拓通
 * @category    基本信息
 * @package		Model
 * @author		何剑波
 * @version  2.1,2012-07-22
 */

class ReturnSaleOrderPublicModel extends RelationCommonModel {
	/// 定义真实表名
	protected $tableName = 'return_sale_order';
	/// 定义表关联
	protected $_link	 = array('detail' => 
									array(
										'mapping_type'	=> HAS_MANY,
										'foreign_key' 	=> 'return_sale_order_id',
										'class_name'	=> 'ReturnSaleOrderDetail',
								),
								'service' => 
									array(
										'mapping_type'	=> HAS_MANY,
										'foreign_key' 	=> 'return_sale_order_id',
										'class_name'	=> 'ReturnSaleOrderDetailService',
								),
								'addition' =>
									array(
										'mapping_type'	=> HAS_ONE,
										'foreign_key' 	=> 'return_sale_order_id',
										'class_name'	=> 'ReturnSaleOrderAddition',
									),
								'factory_addition' =>
									array(
										'mapping_type'	=> HAS_ONE,
										'foreign_key' 	=> 'return_sale_order_id',
										'class_name'	=> 'ReturnSaleOrderFactoryAddition',
									),
	);
	/// 自动验证设置
	protected $_validate	 =	 array(
            array("return_logistics_no",'','unique',2,'unique'),
			array("warehouse_id",'pst_integer','require', self::MUST_VALIDATE),
			array("return_sale_order_state",'pst_integer','require', self::MUST_VALIDATE),
			array("return_order_date",'require','require', self::MUST_VALIDATE),
            array('factory_id','require','require', 0),
			array("",'validAddition','require',1,'callbacks'),
//            array("",'validPack','require',1,'callbacks'),
            array("",'validReturnDate','require',1,'callbacks'),
			array("",'_validDetail','require',1,'validDetail'),
	        array("",'validExtra','require',1,'callbacks'),//验证退货物流单号，运单号        add by lxt 2015.08.28
	        array("",'validState','require',1,'callbacks'),//特殊验证状态        add by lxt 2015.08.28
	);
	protected $_validDetail	 =	 array(
			array("quantity",'z_integer','z_integer',1), 
            array('location_id','require','coexistence',1,'ifcheck2', '', 'location_no'),//location_no存在时location_id不能为空
	);	
    /// 自动填充
	protected $_auto = array(
		array("update_time", "date", 3, "function", "Y-m-d H:i:s"), // 更新时间
	);
	
	protected $_validRelated	 =	 array(
			array("sale_order_id",'pst_integer','require',0),
			array("sale_order_no",'require','require',1),
	);
	
	protected $_validRelatedDetail	 =	 array(
			array("sale_order_number",'z_integer','z_integer',1), 
			array("quantity",'sale_order_number','return_quantity_chk',1,'elt'), 
	);	
	protected $_validNotRelated	 =	 array(
        
	);
	
	protected $_validNotRelatedDetail	 =	 array(
	);		
	
	///地址明细验证规则
	protected $_validAddition	 =	 array(
			array("consignee",'require','require',1),
			array("country_name",'require','require',1),
			array("country_id",'require','require',1),
			array('email','email','valid_email',2),	//邮箱格式
	);
	
	///地址明细验证
	public function validAddition($data){
		$valid		= '_validAddition';
        if(!empty($data['client_id'])){
			if ($data['from_type'] != 'cainiao') {
				$vasd = array(
							array("post_code",'require','require',1),
							array("address",'require','require',1),
							array("city_name",'require','require',1),
						);
				$this->mergeProperty('_validAddition', $vasd);
			}
            return $this->_moduleValidationChild($this,$data, 'addition', $valid); 
        }
	}

    public function validPack($data){
        if (in_array($data['return_reason'], C('CHECK_PACK_RETURN_REASON'))) {
            $sub_pack = array(
                array("outer_pack", 'require', "require", 0),
                array("within_pack", 'require', "require", 0),
            );
            if ($data['outer_pack']==C('CHANGE_PACK')) {
                $sub_pack[] = array("outer_pack_id", 'pst_integer', "require", 0);
            }
            if ($data['within_pack']==C('CHANGE_PACK')) {
                $sub_pack[] = array("within_pack_id", 'pst_integer', "require", 0);
            }
            return $this->_validSubmit($data, $sub_pack);
        }
    }
    public function validReturnDate($data){
        if(in_array($data['return_sale_order_state'], array(C('PROCESS_COMPLETE'),C('DROPPED')))){
            $sub_returned_date = array(
                array("returned_date", 'require', "require", 0),
            );
            return $this->_validSubmit($data, $sub_returned_date);
        }
    }
    //验证退货物流单号和运单号      add by lxt 2015.08.28
    public function validExtra($data){
        //签收或者拒收
        if (in_array($data['return_sale_order_state'], array(C('SIGNED'),C('REFUSE')))){
            //退货物流单号
            if ($data['factory_id']==C('CAINIAO_FACTORY_ID') || $data['factory_id2']==C('CAINIAO_FACTORY_ID')){
                $return_logistics_no    =   array(
                    array('return_logistics_no','require','require',1)
                );
                return $this->_validSubmit($data,$return_logistics_no);
            }
            //拒收时必须填写原因
            if ($data['return_sale_order_state']==C('REFUSE')){
                $refuse_reason  =   array(
                    array("refuse_reason",'require',"require",1),
                );
                return $this->_validSubmit($data,$refuse_reason);
            }
        }
    }
    //特殊状态验证        add by lxt 2015.08.28
    public function validState($data){
        //退货状态为已丢弃
        if (is_array($data['service']) && $data['return_sale_order_state']==C('DROPPED')){
            foreach ($data['service'] as $value){
                $service_detail_id[]   =   $value[C('RETURN_SERVICE_DETAIL_ID')];
            }
            if (count($service_detail_id)>0){
                //判断退货服务中是否有编码为M
                $where      =   array('id'=>array('in',$service_detail_id),'return_service_id'=>C('DOWN_AND_DESTORY'));
                $service    =   M('ReturnServiceDetail')->where($where)->count();
                if (!$service){
                    $this->error[]      =   array('name'=>'return_sale_order_state','value'=>L('drop_with_error_service'));
                    $this->error_type   =   2;
                }
            }
        }
    }

    public function setPost(){
		//退货是否关联销售单 added by jp 20141112 start
		$_POST['is_related_sale_order']	= !isset($_POST['is_related_sale_order']) || !in_array($_POST['is_related_sale_order'], array_keys(C('WHETHER_RELATED_DEAL_NO'))) ? C('IS_RELATED_SALE_ORDER') : intval($_POST['is_related_sale_order']);		
		$validate						= array();
		$validDetail					= array();
		if ($_POST['is_related_sale_order'] == C('IS_RELATED_SALE_ORDER')){
			$validate		= $this->_validRelated;
			$validDetail	= $this->_validRelatedDetail;
		} else{
			$validate		= $this->_validNotRelated;
			$validDetail	= $this->_validNotRelatedDetail;
		}
		if ($_POST['from_type'] != 'cainiao') {
			$validDetail[]	= array("product_id",'pst_integer','require',1);
			$this->addProperty('_auto', array("create_time", "date", 1, "function", "Y-m-d H:i:s"));// 创建时间
		} else {
			$validate[]	= array("return_logistics_no",'','unique',1,'unique');
			if (CAINIAO_API_NAME == 'AddReturnOrderTrackNo') {//菜鸟 快递单号接口 退货跟踪单号必填
				$validate[]	= array("return_track_no",'require','require',1);
			}
		}
		$this->mergeProperty('_validate', $validate);
		$this->mergeProperty('_validDetail', $validDetail);
		//退货是否关联销售单 added by jp 20141112 end
		$this->addProperty('_validate', array('return_reason','array_key_exists','require', self::EXISTS_VAILIDATE, 'function', self::MODEL_BOTH, array(C('RETURN_REASON'))));
		$info	= $_POST;
		foreach ($info['detail'] as &$v) {
			$v['warehouse_id']	= $info['warehouse_id'];
		}
		if (!in_array($_POST['from_type'], array('cainiao'))) {//菜鸟api此时明细可能还有未新增产品，故等后面新增完产品再处理
			$this->setReturnService($info);
		}
		$this->Mdate = $info;
		return $info; 
	}

	/**
	 * 设置退货服务明细及退货单号后缀
	 * @param array $info
	 */
	public function setReturnService(&$info) {
		$where		   = $this->_action == 'insert' ? 'where a.status=1 and b.is_return_service=1' : '';
		$ReturnService = M('ReturnService');
		$sql		   = ' select a.return_service_no,b.id as detail_id
						   from return_service a
						   left join return_service_detail b
						   on a.id=b.return_service_id
						   '.$where.'
						   order by a.return_service_no asc,b.item_number asc';
		$list		   = $ReturnService->query($sql);
		foreach((array)$list as $r_v){
			$r_d[$r_v['detail_id']] = $r_v['detail_id'];
		}
		$flag	= $info['is_related_sale_order'] == C('IS_RELATED_SALE_ORDER') && !in_array($info['from_type'], array('apiimport', 'cainiao'));
		foreach ((array)$info['detail'] as $k => $v) {
			$info['detail'][$k]['relation_id']	= $v['relation_id']	= $flag ? $v['relation_id'] : $k;
			 if(intval($v['product_id'])>0&&intval($v['quantity'])>0){
				$return_service					   = trim($v['return_service']);
				$return_service					   = json_decode(htmlspecialchars_decode(stripcslashes($return_service)),true);
				$array							   = array();
				if(is_array($return_service)&&$return_service){
					foreach($return_service as $key => $value){
						if(count($value)==3&&in_array(intval($value[0]),$r_d)&&intval($value[1])>0){
							//所有产品
							$product[$v['product_id']]	  = $v['product_id'];

							$array[C('RETURN_SERVICE_DETAIL_ID')]	= $value[0];
							$array[C('RETURN_SERVICE_QUANTITY')]	= $value[1];
							$array[C('RETURN_SERVICE_PRICE')]		= trim($value[2]);
							$array['relation_id']					= $v['relation_id'];
							$info['service'][]						= $array;
						}else{
							$error['name']			  = 'detail[' . $k . '][product_id]';
							$error['value']			  = L('select_one');
							$this->error[]			  = $error;
							$info['detail'][$k]['return_service'] = '';
						}
					}
				}elseif(getUser('role_type')!=C('WAREHOUSE_ROLE_TYPE')){
					$error['name']			   = 'detail[' . $k . '][product_id]';
					$error['value']			   = L('select_one');
					$this->error[]			   = $error;
					$info['detail'][$k]['return_service'] = '';
				}
			 }
		}
		$client_no   = ltrim(M('Client')->where('id=' . (int)$info['client_id'])->getField('comp_no'),0);
        if(empty($product)){
            foreach ($_POST['detail'] as $val){
                if($val['quantity']>0){
                    $product[$val['product_id']]  = $val['product_id'];
                }
            }
        }
        //如果不是拒收状态，清空拒收原因       add by lxt 2015.08.28
        if ($info['return_sale_order_state']!=C('REFUSE')){
            $info['refuse_reason']  =   0;
        }
		
		//在ReturnSaleOrderPublicBehavior里面为退货单号加上退货单id前缀 remark by jp 20140523
		if ($_POST['id'] > 0 && $_POST['id'] <= C('OLD_FORMAT_RETURN_SALE_ORDER_NO_MAX_ID')) {
			$info['return_sale_order_no'] = $client_no.'-'.implode('-',$product);
		} else {
			//在ReturnSaleOrderPublicBehavior里面生成退货单号，格式：退货服务编号+退货单id+卖家公司英文简称 edit by jp 20160622
			$info['return_sale_order_no'] = '';//$client_no.'-'.implode('-',$product);
		}
		
		
	}
 
	/// 查看
	public function view(){
		return $this->getInfoReturnSaleOrder($this->id);
	}
	/// 编辑
	public function edit(){
		return $this->getInfoReturnSaleOrder($this->id);
	}
	
	public function getInfoReturnSaleOrder($id){
		$id		= (int)$id;
		$where	= 'id=' . $id . getBelongsWhere();					
		$rs		= $this->where($where)->find();
		
		if (false === $rs || $rs == null) { /// 记录不存在或没权限查看该记录
			halt(L('data_right_error'));
		}			
		$sql = ' select a.*,    
				(a.quantity) as sum_quantity
				from return_sale_order_detail as a
				where a.return_sale_order_id='.$id.'
				group by a.id order by id';  
		$rs['detail'] = $this->db->query($sql);                   
		//卖家只能修改待处理的退货单
		$is_factory			= getUser('role_type')==C('SELLER_ROLE_TYPE') ? 1 : 0;
		$rs['is_update']	= $this->checkEdit($rs['id'], $rs['return_sale_order_state'], M('ReturnSaleOrderStorageDetail')->where(array('return_sale_order_id' => $rs['id']))->getField('sum(quantity) as quantity'));
        $location_id		= M('return_sale_order_storage_detail')->where('return_sale_order_id='.$id)->getField('product_id,location_id,quantity,return_sale_order_storage_id');
		$sql = 'select a.*, b.return_service_id
				from return_sale_order_detail_service as a inner join return_service_detail b on b.id=a.service_detail_id 
				where a.return_sale_order_id='.$id.'
				group by a.id order by id';  
		$rs['service'] = $this->db->query($sql); 
		
		//退货处理费,回邮费用       add by lxt 2015.08.14
		$sys_pay_class        =   C('SYS_PAY_CLASS');
		$fee                  =   M('PaidDetail')->where('object_id='.$id.' and object_type=123 and comp_type=1 and to_hide=1')->getField('pay_class_id,money');
		$fee[$sys_pay_class['returnProcessFee']]  &&  $rs['return_process_fee'] =   moneyFormat($fee[$sys_pay_class['returnProcessFee']],0,C('MONEY_LENGTH'));
		
		foreach((array)$rs['service'] as $k => $v){
			$service_key	= $v['return_sale_order_id'].'_'.$v['return_sale_order_detail_id'].'_'.$v['relation_id'];
			$price			= moneyFormat($v['price'],0,2,false);
			$service_data[$service_key][] = array(
								"0" => $v['service_detail_id'],
								"1" => $v['quantity'],
								"2" => $price
			);
			$return_service[$service_key][]	= array(
								'return_service_id'	=> $v['return_service_id'],
								'service_detail_id'	=> $v['service_detail_id'],
								'quantity'			=> $v['quantity'],
								'price'				=> $price,
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
			$rs['warehouse_id']								= $val['warehouse_id'];
			$rs['detail'][$key]['return_sale_order_state'] = $rs['return_sale_order_state'];
			$rs['detail'][$key]['is_factory']			   = $is_factory;
			$detail_key = $val['return_sale_order_id'].'_'.$val['id'].'_'.$val['relation_id'];
			if(array_key_exists($detail_key, $service_data)){ 
				$rs['detail'][$key]['return_service']      = json_encode($service_data[$detail_key]);
				$rs['detail'][$key]['return_service_info'] = $return_service[$detail_key];
			}
			$rs['detail'][$key]['no_show']				   = 0;
			if((ACTION_NAME=='view'||(ACTION_NAME=='edit'&&getUser('role_type')!=C('SELLER_ROLE_TYPE')))&&$val['quantity']==0 && ($val['is_related_sale_order'] == C('IS_RELATED_SALE_ORDER') || !in_array($rs['return_sale_order_state'], C('CAN_EDIT_SERVICE')))){
				$rs['detail'][$key]['no_show']			   = 1; 
			}

            if(!empty($location_id)) {
                $rs['detail'][$key]['location_id']         = $location_id[$val['product_id']]['location_id'];
                $rs['detail'][$key]['location_no']         = getLocationNo($location_id[$val['product_id']]['location_id']);
                $rs['detail'][$key]['in_quantity']         = $location_id[$val['product_id']]['quantity'];
                $rs['detail'][$key]['return_sale_order_storage_id']     = $location_id[$val['product_id']]['return_sale_order_storage_id'];
            }
            //产品id
            if ($val['product_id']){
                $product_id[]   =   $val['product_id'];
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
			$return_service	= $this->getReturnService($id);
		    $product_info	= M('Product')->where(array('id'=>array('in',$product_id)))->getField('id,check_status,check_weight,check_long,check_wide,check_high,weight,cube_high,cube_long,cube_wide');
			foreach ($rs['detail'] as &$temp_row){
		        if (isset($product_info[$temp_row['product_id']])){
		            $temp_row['check_status'] =   $product_info[$temp_row['product_id']]['check_status'];
		            $temp_row['weight']       =   $temp_row['check_status']==1?$product_info[$temp_row['product_id']]['check_weight']:$product_info[$temp_row['product_id']]['weight'];
		            $temp_row['cube_long']    =   $temp_row['check_status']==1?$product_info[$temp_row['product_id']]['check_long']:$product_info[$temp_row['product_id']]['cube_long'];
		            $temp_row['cube_high']    =   $temp_row['check_status']==1?$product_info[$temp_row['product_id']]['check_high']:$product_info[$temp_row['product_id']]['cube_high'];
		            $temp_row['cube_wide']    =   $temp_row['check_status']==1?$product_info[$temp_row['product_id']]['check_wide']:$product_info[$temp_row['product_id']]['cube_wide'];
		        }
				if(isset($return_service[$temp_row['id']])){
					$temp_row['return_service_no'] =   $return_service[$temp_row['id']]['return_service_no'];
				}
		    }
		}
		$addition						= M('return_sale_order_addition')->where('return_sale_order_id='.$id)->find();
		$rs['addition']					= _formatArray($addition);
		$factory_addition				= M('return_sale_order_factory_addition')->where('return_sale_order_id='.$id)->find();
		$rs['factory_addition']			= _formatArray($factory_addition);
		$rs								= _formatListRelation($rs);
		if (count($product_id)>0){
			$url	= M('ProductExtend')->where(array('product_id' => array('in', $product_id)))->getField('product_id, url');
			if ($url) {
				foreach ($rs['detail'] as &$temp_row){
					if(!empty($url[$temp_row['product_id']])){
						$temp_row['product_name']	= '<a href="' . $url[$temp_row['product_id']] . '" target="_blank">' . $temp_row['product_name'] . '</a>';
					}
				}
			}
		}
        $rs['currency_no']				= SOnly('currency', $rs['w_currency_id'],'currency_no');
		$model							= D('Gallery');
		$rs['pics']						= $model->getAry($id,22);
		$return_sale_order_storage_id	= M('ReturnSaleOrderStorage')->where(array('return_sale_order_id' => $id))->getField('id');
		if ($return_sale_order_storage_id > 0) {
			$return_sale_order_storage_pics	= $model->getAry($return_sale_order_storage_id, 27);
			if (empty($rs['pics'])) {
				$rs['pics']	= $return_sale_order_storage_pics;
			} elseif (!empty ($return_sale_order_storage_pics)) {
				$rs['pics']	= array_merge($rs['pics'], $return_sale_order_storage_pics);
			}
		}
        $rs['outer_pack_name']   = SOnly('package',$rs['outer_pack_id'], 'package_name');
        $rs['within_pack_name']   = SOnly('package',$rs['within_pack_id'], 'package_name');
		return $rs;
	}
	
	public function indexSql(){ 
		return $this->getReturnSaleOrderListSql(); 
	}
	
	protected function getReturnSaleOrderListSql($where=null){
	    //如果是通过入库提醒跳转的，10天前的单子要红色背景     add by lxt 2015.09.24
	    if ($_POST['main']['date']['lt_return_order_date']){
	        $ten_days  =   workDaysDate(time(), 10);
	        $bg_tag    =   'if(a.return_order_date<="'.$ten_days.'",1,0) as is_danger,';
	    }
		$where && $where = ' and '.$where;
		$order					= 'update_time desc';
		$exists_detail_sql		= 'select 1 from return_sale_order_detail inner join product on product.id=return_sale_order_detail.product_id where return_sale_order_id=return_sale_order.id and '.getWhere($_POST['return_sale_order_detail']);
		$exists_sale_sql		= 'select 1 from sale_order where sale_order.id=return_sale_order.sale_order_id and '.getWhere($_POST['sale_order']);
		$exists_client_sql		= 'select 1 from client where client.id=return_sale_order.client_id and '.getWhere($_POST['client']);
		$exists_addition_sql	= 'select 1 from return_sale_order_addition where return_sale_order_addition.return_sale_order_id=return_sale_order.id and '.getWhere($_POST['return_sale_order_addition']);
		$exists_user_sql        = 'select 1 from user where user.id=return_sale_order.add_user and '.  getWhere($_POST['user']);
        $where					= getWhere($_POST['main']).$where;
		$count					= $this
								->exists($exists_detail_sql, $_POST['return_sale_order_detail'])
								->exists($exists_sale_sql, $_POST['sale_order'])
								->exists($exists_client_sql, $_POST['client'])
								->exists($exists_addition_sql, $_POST['return_sale_order_addition']) 
                                ->exists($exists_user_sql,$_POST['user'])
								->where($where)
								->order($order)
								->count();
		$this->setPage($count);
		$ids					= $this->field('id')
								->exists($exists_detail_sql, $_POST['return_sale_order_detail'])
								->exists($exists_sale_sql, $_POST['sale_order'])
								->exists($exists_client_sql, $_POST['client'])
								->exists($exists_addition_sql, $_POST['return_sale_order_addition']) 
                                ->exists($exists_user_sql,$_POST['user'])
								->where($where)
								->order($order)
								->page()
								->selectIds();
		$info['from']	= ' return_sale_order a 
							left join return_sale_order_detail b on(a.id=b.return_sale_order_id) 
							left join sale_order c on(a.sale_order_id=c.id) 
							left join return_sale_order_addition f on(f.return_sale_order_id=a.id)
							left join client d on d.id=a.client_id
                            left join return_sale_order_storage e on a.id=e.return_sale_order_id';		
		$info['where']	= ' where a.id in '.$ids;
		$info['group']	= ' group by a.id order by a.update_time desc';
		$info['field']	= ' '.$bg_tag.'a.return_order_no,c.express_id as ship_id,a.returned_date,a.client_id,d.comp_name as client_name,d.comp_no as client_no,d.email as comp_email,a.order_no,c.order_type,f.consignee,
							group_concat(distinct b.product_id) as p_ids,
							a.id,a.return_sale_order_no,a.return_order_no,a.factory_id,a.sale_order_id,a.sale_order_no,a.return_sale_order_state,
							a.return_order_date,if(a.add_user=' . getUser('id') . ',1,0) as is_self,a.return_reason,
							count(distinct b.product_id) as product_qn,a.add_user,e.id as return_sale_order_storage_id';
		return  'select '.$info['field'].' from '.$info['from'].$info['where'].$info['group']; 
	}
	
	/**
	 * 退货
	 * @return unknown
	 */
	public function alistReturnOrderSql(){
		return $this->getReturnSaleOrderListSql('return_sale_order_type=1');
	}
	///换货
	public function alistSaleOrderSql(){
		return $this->getReturnSaleOrderListSql('return_sale_order_type=2');
	}
	
	/**
	 * 按仓库统计各个状态的退货产品数量
	 * @author jph 20140804
	 * @return array
	 */
	public function getReturnSaleOrderStat(){
		if (getUser('role_type')==C('SELLER_ROLE_TYPE')) {
			$_POST['main']['query']['factory_id']   = intval(getUser('company_id'));
		}		
		$where	= _search_array($_POST['main']) . ' and '. _search_array($_POST['return_sale_order_detail']);
		$count 	= $this->alias('main')->join('__RETURN_SALE_ORDER_DETAIL__ detail on main.id=detail.return_sale_order_id')->where($where)->count('distinct warehouse_id');
		$this->setPage($count);		
		$fields	= 'warehouse_id,sum(detail.quantity) as state_sum';
		foreach (C('RETURN_SALE_ORDER_STATE') as $state=>$state_name) {
			$fields	.= ',sum((main.return_sale_order_state=' . $state . ')*detail.quantity) as state_sum_' . $state . ', ' . $state . ' as state_' . $state;
		}
		$rs	= _formatList($this->field($fields)->alias('main')->join('__RETURN_SALE_ORDER_DETAIL__ detail on main.id=detail.return_sale_order_id')->group('warehouse_id')->where($where)->page()->select(), MODULE_NAME . '_' . ACTION_NAME);
        return $rs;
	}	
    public function _beforeModel($info) {
        if($info['check_repeat']==0){
            if ($info['is_related_sale_order'] == 0) {//不关联订单重复验证条件：相同仓库，相同卖家，相同客户，相同SKU，相同数量   20150326 add yhh 相同订单号 
                $id_arr     = M('ReturnSaleOrder')->where(' factory_id=' . (int)$info['factory_id'] . ' and client_id=' . (int)$info['client_id'].' and order_no="'.trim($info['order_no']).'"')->getField('id',TRUE);
                $is_repeat  = $this->checkProductQuantity($id_arr,$info);
                return $is_repeat;
            }
        }
        return true;
    }
    /**
     * @author yyh 20150202 检查退货单明细是否重复
     * @param type $id
     * @return boolean
     */
    public function checkProductQuantity($id,$info){
        if(!empty($id)){
            foreach($info['detail'] as $value){
                if($value['product_id']>0 && $value['quantity']>0){
					$warehouse_id	= $value['warehouse_id'] ? $value['warehouse_id'] : $info['warehouse_id'];
                    $id     = M('return_sale_order_detail')->where(' warehouse_id='.$warehouse_id.' and return_sale_order_id in ('.implode(',', $id).') and product_id='.$value['product_id'].' and quantity='.$value['quantity'])->group('return_sale_order_id')->getField('return_sale_order_id',TRUE);
                    if(empty($id)){
                        return TRUE;
                    }
                }
            }
            $this->error        = L('repeat_return_orders');
            $this->errorStatus  = 3;
            return FALSE;
        }else{
            return TRUE;
        }
    }

    public function updateReturnStateById($all_return_id, $return_type = 0, $state_log_comments = null){
		$return_type <= 0 && $return_type	= C('RETURN_SHELVES');
		is_null($state_log_comments) && $state_log_comments = title(ACTION_NAME, MODULE_NAME);
		is_array($all_return_id) && $all_return_id	= implode(',', $all_return_id);
        C('LOCK_ON', false);
		if ($return_type == C('RETURN_SHELVES') && $all_return_id) {
            //当前状态为已上架的退货单
            $shelves_return_id_arr      = (array)M('ReturnSaleOrder')->where('id in ('.$all_return_id.') and return_sale_order_state='.C('RETURN_SHELVES'))->getField('id',TRUE);
            //符合更新为已上架的退货单
            $full_return_id_arr         = (array)M('ReturnSaleOrderStorageDetail')->where('return_sale_order_id in ('.$all_return_id.') and quantity>0')->group('return_sale_order_id')->getField('return_sale_order_id',TRUE);
			//不符合更新为上架状态的退货单
            $un_full_return_id_arr  =  array_diff(explode(',', $all_return_id), $full_return_id_arr);
            //需要还原状态的退货单
            $restore_return_id_arr = array_intersect($shelves_return_id_arr, $un_full_return_id_arr);
            if ($restore_return_id_arr) {
                $returnModel	= M('ReturnSaleOrder');
                $returnStatus	= T('ReturnSaleOrder');
				$params			= array(C('LOCK_NAME')=>array('exp', C('LOCK_NAME') . '+1'), 'state_module_name'=>'ReturnSaleOrder', 'return_sale_order_state'=>C('RETURN_SHELVES'), 'state_log_comments'=> $state_log_comments);
                foreach ($restore_return_id_arr as $return_id){
                    $state_log				= M('state_log')->where('object_type=' . (int)array_search('ReturnSaleOrder',C('STATE_OBJECT_TYPE')) . ' and object_id=' . $return_id)->order('id desc')->getField('state_id', true);
                    foreach($state_log as $value){
                        if(in_array($value, C('DELETE_RETURN_STATE'))){
                            $state  = $value;
                            break;
                        }
                    }
                    $state=empty($state)?C('RETURN_SALE_ORDER_STATE_PENDING'):$state;
                    $params['return_sale_order_state']  = $state;
                    $params['id']			= $return_id;
                    $returnModel->setField($params);//更新状态
                    $returnStatus->run($params,'setState');//记录状态日志
                }
            }
            $return_id_arr = array_diff($full_return_id_arr, $shelves_return_id_arr);  
        } else {
			$return_id_arr		= explode(',', $all_return_id);
		}
		if ($return_id_arr) {
			$params             = array(C('LOCK_NAME')=>array('exp', C('LOCK_NAME') . '+1'), 'state_module_name'=>'ReturnSaleOrder', 'return_sale_order_state'=>$return_type, 'state_log_comments'=> $state_log_comments);
			$returnModel        = M('ReturnSaleOrder');
			$returnStatus       = T('ReturnSaleOrder');
			foreach ($return_id_arr as $return_id){
				$params['id']   = $return_id;
				$returnModel->setField($params);//更新状态
				$returnStatus->run($params,'setState');//记录状态日志
			}        
		}
	}

	public function checkEdit($id, $state = null, $is_storaged) {
		if (is_null($state)) {
			$state	= $this->where('id='.intval($id))->getField('return_sale_order_state');
		}
		$is_edit      =   1;
		$is_warehouse =   getUser('role_type')==C('WAREHOUSE_ROLE_TYPE');
		$is_factory   =   getUser('role_type')==C('SELLER_ROLE_TYPE');
		$is_cainiao   =   getUser('company_id')==C('CAINIAO_FACTORY_ID');
//		//已入库     add by lxt 2015.08.31
//		$is_storaged= M('ReturnSaleOrderStorageDetail')->where('return_sale_order_id='.$id)->getField('sum(quantity)');
		//退货单状态变更是因为入库操作的，并且已有入库单的也不能编辑       edit by lxt 2015.08.31
		if(($is_factory && !in_array($state, explode(',',C('SELLER_CAN_EDIT_RETURN_STATE')))) || $is_storaged>0){//edit yyh 20151015 || (!$is_factory && in_array($state, explode(',', C('STORAGE_SHOW_STATE'))) && $is_storaged)处理完成可修改服务费用
			$is_edit = 0;
		}
        //added yyh 20151116
        if(!$is_warehouse && in_array($state,array(C('PROCESS_COMPLETE')))){
            $is_edit    = 1;
        }
		//非速卖通卖家，在处理完成状态下可以编辑     add by lxt 2015.11.13
// 		if ($state==C('PROCESS_COMPLETE') && !$is_cainiao){
// 		    $is_edit  =   1;
// 		}
        //非卖家在处理完成和退货已上架可编辑 add by yyh 20151216
        if(!$is_factory && in_array($state, C('WAREHOUSE_ROLE_CAN_EDIT'))){
            $is_edit    = 1;
        }
		return $is_edit;
	}

	public function checkDelete($id, $state = null) {
		if (is_null($state)) {
			$state	= $this->where('id='.intval($id))->getField('return_sale_order_state');
		}
		$is_del		= 1;
		$is_factory	= getUser('role_type')==C('SELLER_ROLE_TYPE');
		if(($is_factory && !in_array($state, explode(',',C('SELLER_CAN_EDIT_RETURN_STATE')))) || (!$is_factory && !in_array($state,explode(',', C('RETURN_CAN_DELETE'))))){
			$is_del = 0;
		}
        if($_SESSION[C('SUPER_ADMIN_AUTH_KEY')] && $state == C('PROCESS_COMPLETE')){//后台可删除处理完成的退货单
            $is_del		= 1;
        }
		return $is_del;
	}
	
	/**
	 * 导入EXCEL关联insert
	 *
	 * @return array
	 */
	public function importInsert(){
		$info					= $this->data;
		$this->_brf();
		unset($this->data['referer'],$this->data['error_message']);
		$info['check_repeat']	= 1;//不验证重复性
		if($this->_beforeModel($info) == false){
			$this->error_type	= 1;
			return false;
		}
		$id						= $this->relation(true)->add();
		if (false === $id) {
			$this->error_type	=	2;
			return false;
		}
		$this->id				=	$id;
		empty($info) ? $_POST['id'] = $id : $info['id'] = $id;
		$this->_afterModel($info);
		//订单导入新增状态日志
        $info['state_module_name']  = 'ReturnSaleOrder';
        $info['state_log_comments'] = L('module_ReturnSaleOrder') . (LANG_SET != 'cn' ? ' ' : '') . L('import');
		$this->execTags($info);
		return $this->id;
	}

	public function  importUpdate() {
		$info					= $this->data;
		$this->_brf();
		unset($this->data['referer'],$this->data['error_message']);
		$this->id				=	$info['id'];
		$info['check_repeat']	= 1;//不验证重复性
		if($this->_beforeModel($info) == false){
			$this->error_type	= 1;
			return false;
		}
		$r						= $this->relation(true)->save();
		if (false === $r) {
			$this->error_type	=	2;
			return false;
		}
		$this->_afterModel($info);
		$this->execTags($info);
		return $this->id;
	 }

	/**
	 * 获取退货单信息（用于api接口）
	 * @author jph 20150729
	 * @param mixed $ids
	 * @return array
	 */
	public function apiGetReturnOrderList($ids){
		$DocInfoList	= C('API_GET_DATA_TYPE') == 'Simple' ?  $this->ReturnOrderSimpleList($ids) : $this->ReturnOrderAllList($ids);
		return $DocInfoList;
	}

	/**
	 * 获取退货单基本信息列表
	 * @author jph 20150729
	 * @param mixed $ids
	 * @return array
	 */
	public function ReturnOrderSimpleList($ids){
		if (!is_array($ids)) {
			$ids	= explode(',', $ids);
		}
		if (empty($ids)) {
			return array();
		}
		$rs		= $this->where(array('id' => array('in', $ids)))->order('return_order_no desc')->getField('id,id,return_sale_order_no,return_order_no,return_sale_order_state');
		$storage_info   =   M('ReturnSaleOrderStorageDetail')->where('return_sale_order_id in('.implode(',',$ids).')')->group('return_sale_order_id')->getField('return_sale_order_id,sum(quantity) as quantity');
		foreach ($rs as &$value){
			$value['is_edit']	= $this->checkEdit($value['id'], $value['return_sale_order_state'], $storage_info[$value['id']]['quantity']) == 0 ? 2 : 1;
			$value['is_delete']	= $this->checkDelete($value['id'], $value['return_sale_order_state']) == 0 ? 2 : 1;
		}
		return $rs;
	}

	/**
	 * 获取退货单基本信息列表
	 * @author jph 20150729
	 * @param mixed $ids
	 * @return array
	 */
	public function ReturnOrderAllList($ids){
		if (!is_array($ids)) {
			$ids	= explode(',', $ids);
		}
		if (empty($ids)) {
			return array();
		}
		$funds_class		= array(
									'returnFee',
									'returnAdditionalFee',
								);
		$sys_pay_class		= C('SYS_PAY_CLASS');
		$funds_left_join	= '';
		$funds_fields		= '';
		foreach ($funds_class as $class) {
			$funds_left_join	.= ' left join client_paid_detail ' . $class . ' on ' . $class . '.object_id=a.id and ' . $class . '.object_type=123 and ' . $class . '.pay_class_id=' . intval($sys_pay_class[$class]) . ' ';
			$field_name			 = strtolower(preg_replace('/([A-Z])/', '_\1', $class));
			$funds_fields		.= ', ' . $class . '.should_paid as ' . $field_name . ', ' . $class . '.paid_id as ' . $field_name . '_paid_id';
		}
		$sql				= 'select a.id,a.return_reason,a.return_sale_order_state,a.is_related_sale_order,a.return_order_date,a.return_track_no,a.return_logistics_no,
								a.return_sale_order_no, a.return_order_no,a.order_no,a.client_id,b.comp_name as client_name,
								s.sale_order_no, s.track_no, s.order_date,
								c.email,c.fax,c.tax_no,c.city_name,c.country_id,c.country_name,
								c.consignee,c.mobile,c.post_code,c.company_name,c.address,c.address2,c.transmit_name
								' . $funds_fields . '
								from return_sale_order a
								left join client b on b.id=a.client_id
								left join sale_order s on a.is_related_sale_order=' . C('IS_RELATED_SALE_ORDER') . ' and s.id=a.sale_order_id
								INNER JOIN return_sale_order_addition c ON a.id = c.return_sale_order_id
								' .  $funds_left_join . '
								where a.id in(\'' . implode("', '", (array)$ids) . '\') ' . '
								group by a.id
								order by a.return_order_no desc';
		$rs					= _formatList($this->db->query($sql), null, 0);
		//退货单产品明细
		$details			= _formatList(M('ReturnSaleOrderDetail')
											->field('sod.return_sale_order_id as return_sale_id,sod.id,sod.product_id,p.product_no,sod.quantity,sod.sale_order_number,sod.warehouse_id')
											->join('sod left join product p on p.id=sod.product_id')
											->where('sod.return_sale_order_id in (' . implode(',', $ids) . ')')
											->select(), null, 0, array('return_sale_id'));
		//退货单退货服务明细
		$service_details	= _formatList(M('ReturnSaleOrderDetailService')
											->field('rsod.return_sale_order_detail_id as return_sale_detail_id,rsod.service_detail_id,rs.return_service_no,rsd.item_number,rsod.quantity,rsod.price')
											->join('rsod left join __RETURN_SERVICE_DETAIL__ rsd on rsd.id=rsod.service_detail_id left join __RETURN_SERVICE__ rs on rs.id=rsd.return_service_id')
											->where('rsod.return_sale_order_id in (' . implode(',', $ids) . ')')
											->select(), null, 0, array('return_sale_detail_id'));
		//
		$storage_info   =   M('ReturnSaleOrderStorageDetail')->where('return_sale_order_id in('.implode(',',$ids).')')->group('return_sale_order_id')->getField('return_sale_order_id,sum(quantity) as quantity');
		foreach ($rs['list'] as &$value){
			$end_detail						= end($details['list'][$value['id']]);
			$value['warehouse_id']			= $end_detail['warehouse_id'];
			$value['w_name']				= $end_detail['w_name'];
			$value['w_no']					= $end_detail['w_no'];
			$value['is_edit']				= $this->checkEdit($value['id'], $value['return_sale_order_state'], $storage_info[$value['id']]['quantity']) == 0 ? 2 : 1;
			$value['is_delete']				= $this->checkDelete($value['id'], $value['return_sale_order_state']) == 0 ? 2 : 1;
			$value['detail']				= $details['list'][$value['id']];
			foreach ($value['detail'] as &$val){
				$val['return_service']	= $service_details['list'][$val['id']];
			}
		}
		return $rs['list'];
	}
	
	public function getReturnService($id){
		$info['table'] 			= 'return_sale_order_detail_service s
								   INNER JOIN  return_sale_order_detail d   ON d.id=s.return_sale_order_detail_id
								   left join  return_service_detail rs ON s.service_detail_id = rs.id
								   left join return_service r on r.id=rs.return_service_id';
		$info['where'] 			= 's.return_sale_order_id='.$id;
		$info['group'] 			= 's.return_sale_order_detail_id';
		$info['field'] 			= 'group_concat(distinct r.return_service_no) as return_service_no,s.return_sale_order_detail_id as id,service_detail_id';
		$sql	= 'select '.$info['field'].' from '.$info['table'].' where '.$info['where'].' group by '.$info['group'];
		$arr    = M()->query($sql);
		if(empty($arr)){//edit by yyh 20151117管理员退货服务允许为空
			return '';
		}
		foreach($arr as &$val){
			  $result[$val['id']]	= $val;			   
		}
		return  $result;

	}			 
}