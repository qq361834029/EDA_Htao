<?php

/**
 * 入库列表类
 * @copyright   Copyright (c) 2006 - 2013 TOP UNION 展联软件友拓通
 * @category    基本信息
 * @package		Model
 * @author     jph
 * @version  2.1,2014-03-07
 */

class InstockPublicModel extends RelationCommonModel {
	
	/// 定义真实表名
	protected $tableName = 'instock';
								
	/// 自动验证设置
	protected $_validate	 =	 array(
			array("delivery_date",'require','require',1),//交货日期
			array("warehouse_id",'require',"require",1),//目的地
			array("go_date",'require','require',1),//发货日期
			array("container_no",'require','require',1),//物流编号
			array("instock_type",'require','require',0),//状态
			array("get_address",'require','require',0),//取货地址
			array("container_type",'require','require',0),//装柜规格
            array("container_no,factory_id",'','unique',1,'unique'),//物流编号唯一验证
			array('invoice_money','currency','valid_money',2),//发票金额
			array('insured_amount','currency','valid_money',2),//保价金额
		
			array('factory_id','require','require',1),//卖家
			array("",'validDetail','require',1,'callbacks'),//验证明细
		);	
        
        //装箱明细验证
	protected $_validBoxDetail	 =	 array(
			array("box_no",'require','require',1),
			array("cube_long",'require',"require",1), 	
			array("cube_wide",'require',"require",1), 	
			array("cube_high",'require',"require",1), 	
			array("weight",'require',"require",1),
			array("cube_long",'double',"double",1), 	
			array("cube_wide",'double',"double",1), 	
			array("cube_high",'double',"double",1), 	
			array("weight",'double',"double",1), 
		);	
	
	//产品明细验证
	protected $_validProductDetail	 =	 array(
			array("product_id",'require','product_not_exist',1),
			array("quantity",'pst_integer','pst_integer',1),		  
			array("check_long",'require',"require",0), 	
			array("check_wide",'require',"require",0), 	
			array("check_high",'require',"require",0), 	
			array("check_weight",'require',"require",0),
			array("check_long",'double',"double",0), 	
			array("check_wide",'double',"double",0), 	
			array("check_high",'double',"double",0), 	
			array("check_weight",'double',"double",0), 
		);		

	protected $_link	 = array(
								'box' => array(
											'mapping_type'	=> HAS_MANY,
											'foreign_key' 	=> 'instock_id',
											'class_name'	=> 'InstockBox',
											'mapping_fields'=> '*,cube_long*cube_wide*cube_high as cube,check_long*check_wide*check_high as check_cube',
											'_link'			=> array(
																'product' => array(
																		   'foreign_field' 	=> 'box_no',
																		   'foreign_key' 	=> 'box_id',
																	   )
											),
										),
								 'product' => array(
											'mapping_type'	=> HAS_MANY,
											'foreign_key' 	=> 'instock_id',
											'class_name'	=> 'InstockDetail',
											'mapping_fields'=> '*,(in_quantity - accepting_quantity) as diff_quantity',
										)
								);			
	/// 自动填充
	protected $_auto	 = array(
								array("create_time", "date", 1, "function", "Y-m-d H:i:s"), // 创建时间	
								array("update_time", "date", 2, "function", "Y-m-d H:i:s"), // 更新时间					
							);	
	//明细规格验证字段
	protected $_validFields	= array(
									'product'	=> array('warn_field'=>'product_id','box_id'),//产品明细中箱号+产品唯一
									'box'		=> array('warn_field'=>'box_no'),//装箱明细中箱号唯一性
								);

    protected function _initialize() {
		parent::_initialize();
		if (in_array($_POST['from_type'], array('apiimport', 'cainiao')) || getUser('role_type') != C('SELLER_ROLE_TYPE')) {
			$this->_detailKey	= array("box",'product');
		} else {
			$this->_detailKey	= $_POST['step'] == 2 ? array('product') : array('box');
		}
        if(in_array($_POST['from_type'], array('apiimport', 'cainiao'))){
            $this->_validate[]  = array('head_way',array(1,2),'head_way_1or2',2,'in');//头程运输方式
            $this->_validate[]  = array('is_get',array(1,2),'require',2,'in');//是否取货
            if(!empty($_POST['logistics_id'])){
                $this->_validate[]  = array("logistics_id",'pst_integer',"show_list_type_1", self::MUST_VALIDATE);//物流公司是否存在
            }
            if($_POST['head_way'] == 1){//海运需要验证规格
                $this->_validate[]  = array("container_type",C('CFG_CONTAINER_TYPE_BETWEEN'),"require", self::MUST_VALIDATE, 'in');
            }
            if($_POST['is_get'] == 1){//取货时地址必填
                $this->_validate[]  = array("get_address",'require','require',self::MUST_VALIDATE);//取货地址
            }
            
            $this->_validate[]  = array('delivery_date', 'checkDateFormat', 'time_format_error', 1,'callback', 1);
            $this->_validate[]  = array('go_date', 'checkDateFormat', 'time_format_error', 1,'callback', 1);
			if($_POST['arrive_date']){
				$this->_validate[]  = array('arrive_date', 'checkDateFormat', 'time_format_error', 1,'callback', 1);
			}
        }
		$this->set_real_arrive_date_vasd($this->_validate);
	}
    public function checkDateFormat($data){
        if( (validateDate($data,'Y-m-d') || validateDate($data,'d/m/Y')) && checkdateDate($data) ){//中国时间//欧洲时间
            return TRUE;
        }else{
            return FALSE;
        }
    }
	
	public function validDetail($data){
		$result	= true;
		if (!in_array($_POST['from_type'], array('apiimport', 'cainiao'))) {
			$this->_validProductDetail[]	= array("box_id",'require','require',1);
		}

		foreach ((array)$this->_detailKey as $detailKey) {
			$this->_vaild	= '_valid' . ucfirst($detailKey) . 'Detail';
			if ($this->_moduleValidationDetail($this,$data, $detailKey,$this->_vaild) === false) {
				$result	= false;
			}
			if ($this->validDetailUnique($data, $detailKey) === false) {//明细规格验证
				$result	= false;
			}
		}
		return $result;
	}

	public function validDetailUnique($data, $detailKey) {
		$result			= true;
		$spec			= array();
		$detail			= $data[$detailKey];
		$valid_fields	= $this->_validFields[$detailKey];
		foreach($detail as $key=>$val){
			$detail_spec	= array();
			foreach ($valid_fields as $field){
				if(empty($val[$field])){
					continue 2;
				}
				$detail_spec[]	= $val[$field];
			}
			$detail_spec_str = implode('_', $detail_spec);
			if(in_array($detail_spec_str,$spec)){
				$error['name']	= $detailKey . '['.$key.'][' . $valid_fields['warn_field'] . ']';//警告字段
				$error['value']	= L('unique');
				$this->error[]	= $error;
				$result			= false;
			}else{
				$spec[]	= $detail_spec_str;
			}
		}
		return $result;
	}
	
	private function set_real_arrive_date_vasd(&$vasd){
        //此提示在行为验证前导致API提示不准确
		if (in_array($_POST['instock_type'], array(C('CFG_INSTOCK_TYPE_ARRIVE_WARE'),C('CFG_INSTOCK_TYPE_WARE_CHECK_FOREIGN'),C('CFG_INSTOCK_TYPE_INSTOCK_FOREIGN'),C('CFG_INSTOCK_TYPE_DELIVERY_IN'))) && $_POST['from_type'] != 'apiimport') {
            $vasd[]	= array("real_arrive_date",'require','require',1);//实际达到日期
		}		
	}

	//added 20140919 yyh 验证实际到达日期
	public function editStateUpdateValid($data){
        $vasd = array(array("instock_type",'require','require',0));
		$this->set_real_arrive_date_vasd($vasd);
		unset($this->_validate);
		$this->_validate = $vasd;
		return $this->_validSubmit($data,$vasd);
	}
	
	/// 查看
	public function view(){ 
		return $this->getInfoInstock($this->id);
	}
	
	/// 编辑
	public function edit(){
		return $this->getInfoInstock($this->id);
	}
	
	///列表
	public function indexSql(){  
		return $this->getInstockListSql(_search_array(_getSpecialUrl($_GET))); 
	}
	
	/**
	 * 取列表
	 * @param string $where
	 * @return array
	 */
	public function getInstockListSql($where=null){
		$where = getWhere($_POST['main']);
		$detail_where	= getWhere($_POST['detail']);
		if($_POST['detail'] && trim($detail_where) !== '1'){
			$count 	= $this->exists('select 1 from instock_detail i_d left join product p on i_d.product_id=p.id where i_d.instock_id=instock.id and '.$detail_where,$_POST['detail'])->where($where)->count();
			$this->setPage($count);
			$ids	= $this->field('id')->exists('select 1 from instock_detail i_d left join product p on i_d.product_id=p.id where i_d.instock_id=instock.id and '.$detail_where,$_POST['detail'])->where($where)->order('instock_no desc')->page()->selectIds();
		}else{
			$count 	= $this->where($where)->count();
			$this->setPage($count);
			$ids	= $this->field('id')->where($where)->order('instock_no desc')->page()->selectIds();
		}
		$info['from'] 	= 'instock a left join instock_detail b on(a.id=b.instock_id)';
		$info['group'] 	= ' group by a.id order by instock_no desc';
		$info['where'] 	= ' where a.id in'.$ids;
		$info['field'] 	= 'a.*,a.id as instock_id,count(distinct b.product_id) as product_qn, sum(b.quantity) as sum_qn';
		return	'select '.$info['field'].' from '.$info['from'].$info['where'].$info['group'];
	}
	
	/**
	 * 获取入库单信息
	 * @param int $id
	 * @return array
	 */
	public function getInfoInstock($id,$sign){
		if($sign==1){
			$rs = $this->getMainInfo(false,$sign,$id);
		}else{
			$rs = $this->getMainInfo(false);
		}
		if (false === $rs || $rs == null) { // 记录不存在或没权限查看该记录
			halt(L('data_right_error'));
		}
		$ext_mapping_fields	= ', ' . $rs['instock_type'] . ' as instock_type';
		if (!isset($this->_link['box']['mapping_fields'])) {
			$this->_link['box']['mapping_fields']	= '*';
		}
		if (!isset($this->_link['box']['mapping_fields'])) {
			$this->_link['product']['mapping_fields']	= '*';
		}		
		$this->_link['box']['mapping_fields']	.= $ext_mapping_fields;
		$this->_link['product']['mapping_fields']	.= $ext_mapping_fields;		
		$this->getRelation($rs);//获取关联数据 装箱明细及产品明细
        if ($rs['product']) {           
            $this->getProductInfo($rs['product'],'product_id');
        }
		$info	= _formatListRelation($rs, array('product','box'));	
		_formatWeightCubeList($info['box']);
        _formatWeightCubeList($info['product']);
		if ($info['product']) {
			foreach ($info['product'] as &$product) {
				$product['box_no']	= $info['box'][$product['box_id']]['box_no'];
			}
		}
		return $info;
	}
	
	///获取待装柜明细
	public function getMainInfo($format	= true,$sign,$id){		 
		$stuff=($sign==1) ? (int)$id :(int)$this->id;
		$where		= 'id=' .$stuff. getBelongsWhere();	 
		$rs			= $this->where($where)->find();
		if ($rs) {
			$model	=	D('Gallery'); 
			$rs['pics'] = $model->getAry($stuff,2);
		}
		return $format ? _formatArray($rs) : $rs;
	}
	
	public function getBoxNo($id = null){
		if ($id <= 0) {
			$id	= $this->id;
		}
		return M('instockBox')->where('instock_id=' . (int)$id)->getField('id,box_no');
	}
	
	//发货单所有产品入库量与发货量完全一致时，状态自动更新为“商品上架（国外）”
	public function updateInstockStateById($all_instock_id, $instock_type = 0, $state_log_comments = null){
		$instock_type <= 0 && $instock_type	= C('CFG_INSTOCK_TYPE_INSTOCK_FOREIGN');
		is_null($state_log_comments) && $state_log_comments = title(ACTION_NAME, MODULE_NAME);
		is_array($all_instock_id) && $all_instock_id	= implode(',', $all_instock_id);
		if ($instock_type == C('CFG_INSTOCK_TYPE_INSTOCK_FOREIGN') && $all_instock_id) {
            //当前状态为商品上架的发货单
            $foreigned_instock_id_arr = (array)M('Instock')->where('id in (' . $all_instock_id . ') and instock_type='.C('CFG_INSTOCK_TYPE_INSTOCK_FOREIGN'))->getField('id',true);
            //符合更新为商品上架状态的发货单
            $full_instock_id_arr    = (array)M('InstockDetail')->where('instock_id in (' . $all_instock_id . ')')->group('instock_id')->having('sum(if(quantity<=in_quantity,0,1))=0')->getField('instock_id',true);
			//不符合更新为商品上架状态的发货单
            $un_full_instock_id_arr = array_diff(explode(',', $all_instock_id), $full_instock_id_arr);
            //需要还原状态的发货单
            $restore_instock_id_arr = array_intersect($foreigned_instock_id_arr, $un_full_instock_id_arr);
            if ($restore_instock_id_arr) {
				$modelStateLog		= M('state_log');
				$where				= array(
										'object_id'		=> array('in', $restore_instock_id_arr),
										'object_type'	=> array_search('Instock',C('STATE_OBJECT_TYPE'))
									);
				$last_child_sql		= $modelStateLog->where($where)->order('id desc')->field('id, object_id')->buildSql();
				$last_state_sql		= 'select id from ' . $last_child_sql . ' tmp group by object_id';
				$last_state			= M()->query($last_state_sql);
				$last_state_id		= array();
				foreach ($last_state as $state) {
					$last_state_id[]	= $state['id'];
				}
				$where['id']		= array('not in', $last_state_id);
				$penul_child_sql	= $modelStateLog->where($where)->order('id desc')->field('id, object_id, state_id')->buildSql();
				$penul_state_sql	= 'select object_id, state_id from ' . $penul_child_sql . ' tmp group by object_id';
				$penul_state		= M()->query($penul_state_sql);
				$penul_state_id		= array();
				foreach ($penul_state as $state) {
					$penul_state_id[$state['object_id']]	= $state['state_id'];
				}
				$updateStatus= array();
				$updateAllStatus= array();
				foreach ($restore_instock_id_arr as $instock_id){
					$type							= $penul_state_id[$instock_id] ? $penul_state_id[$instock_id] : C('CFG_INSTOCK_TYPE_WAIT_AUDIT');
					$updateStatus[$type][]			= $instock_id;
					$updateAllStatus[$instock_id]	= $type;
                }
				//批量更新状态
				$instockModel	= M('Instock');
				$update			= array(
					C('LOCK_NAME')	=> array('exp', C('LOCK_NAME') . '+1'),
                    'update_time'   => date('Y-m-d H:i:s'),
				);
				foreach ($updateStatus as $type => $ids) {
					$update['instock_type']	= $type;
					$instockModel->where(array('id' => array('in', $ids)))->setField($update);
				}
				//记录状态日志
				$params			= array(
									'id'					=> $restore_instock_id_arr,
									'state_module_name'		=> 'Instock',
									'instock_type'			=> $updateAllStatus,
									'state_log_comments'	=> $state_log_comments
								);
				T('Instock')->run($params,'setState');
            }
            //可以更新为商品上架的发货单
            $instock_id_arr = array_diff($full_instock_id_arr, $foreigned_instock_id_arr);  
        } else {
			$instock_id_arr		= explode(',', $all_instock_id);
		}
		if ($instock_id_arr) {
			//批量更新状态
			$update			= array(
				'instock_type'	=> $instock_type,
				C('LOCK_NAME')	=> array('exp', C('LOCK_NAME') . '+1'),
                'update_time'   => date('Y-m-d H:i:s'),
			);
			M('Instock')->where(array('id' => array('in', $instock_id_arr)))->setField($update);
			//记录状态日志
			$params			= array(
								'id'					=> $instock_id_arr,
								'state_module_name'		=> 'Instock',
								'instock_type'			=> $instock_type,
								'state_log_comments'	=> $state_log_comments
							);
			T('Instock')->run($params,'setState');
		}
	}

	/**
	 * 导入EXCEL关联insert
	 *
	 * @return array
	 */
	public function importInsert(){
        static $container_no    = array();
		$info	= $this->data;
		$this->_brf();
		unset($this->data['referer'],$this->data['error_message']);
		if($this->_beforeModel($info) == false){
			$this->error_type	= 1;
			return false;
		}
        if(in_array($this->data['container_no'], $container_no)){
            $error[]    = L('logistics_no').':'.L('unique');
			$this->error_type	= 1;
            $this->addError($error);
            return false;
        }else{
            $container_no[$this->data['container_no']]  = $this->data['container_no'];
            $where['factory_id']        = $this->data['factory_id'];
            $where['container_no']      = $this->data['container_no'];
            $exist  = $this->where($where)->find();
            if(empty($exist)){
                $id = $this->relation(true)->add();
            }else{
                $error[]    = L('logistics_no').':'.L('unique');
                $this->error_type	= 1;
                $this->addError($error);
                return false;
            }
        }
		if (false === $id) {
			$this->error_type	=	2;
			return false;
		}
		$this->id	=	$id;
		empty($info) ? $_POST['id'] = $id : $info['id'] = $id;
		$this->_afterModel($info);
		//订单导入新增状态日志
        $info['state_module_name']  = 'Instock';
        $info['state_log_comments'] = L('module_Instock') . (LANG_SET != 'cn' ? ' ' : '') . L('import');
        $info['instock_type']		= C('CFG_INSTOCK_TYPE_WAIT_AUDIT');
		$this->execTags($info);
		A('Instock')->addTimer($this->id);
		return $this->id;
	}
    
	/**
	 * 获取发货单信息（用于api接口）
	 * @author yyh 20151012
	 * @param mixed $ids
	 * @return array
	 */
	public function apiGetShippingList($ids){
		$DocInfoList	= C('API_GET_DATA_TYPE') == 'Simple' ?  $this->ShippingSimpleList($ids) : $this->ShippingAllList($ids);
		return $DocInfoList;
	}
    /**
	 * 获取发货单基本信息列表
	 * @author yyh 20151012
	 * @param mixed $ids
	 * @return array
	 */
	public function ShippingSimpleList($ids){
		if (!is_array($ids)) {
			$ids	= explode(',', $ids);
		}
		if (empty($ids)) {
			return array();
		}
		$rs		= $this->where(array('id' => array('in', $ids)))->order('instock_no desc')->getField('id,id,instock_no,instock_type');
		foreach ($rs as &$value){
			$value['is_edit']	= 1;
			$value['is_delete']	= $this->checkDelete($value['instock_type']) == 0 ? 2 : 1;
		}
		return $rs;
	}

	/**
	 * 获取发货单基本信息列表
	 * @author yyh 20151012
	 * @param mixed $ids
	 * @return array
	 */
	public function ShippingAllList($ids){
		if (!is_array($ids)) {
			$ids	= explode(',', $ids);
		}
		if (empty($ids)) {
			return array();
		}
        
		$rs					= _formatList(M('instock')
                                            ->field('get_address,instock_type,instock_no,id as instock_id,go_date as instock_date,delivery_date,warehouse_id,track_no,head_way as transport_type,container_type,is_get,invoice_money,insured_amount,arrive_date,container_no,logistics_id,factory_id as client_id')
                                            ->where('id in ('.  implode(',', $ids).')')
                                            ->select(), null, 0);
		//发货单产品明细
		$details			= _formatList(M('instock_detail')
											->field('d.instock_id,b.box_no,p.product_no,d.quantity,d.declared_value')
											->join('d left join product p on p.id=d.product_id 
                                                    left join instock_box b on d.box_id=b.id ')
											->where('d.instock_id in (' . implode(',', $ids) . ')')
											->select(), null, 0, array('instock_id'));
		//发货单退货服务明细
		$box_details        = _formatList(M('instock_box')
											->field('id as box_id,instock_id,box_no,cube_high,cube_wide,cube_long,weight,comments')
											->where('instock_id in (' . implode(',', $ids) . ')')
											->select(), null, 0, array('instock_id'));
        foreach($rs['list'] as $v){
            $warehouse_id_arr[] = $v['warehouse_id'];
        }
        if(!empty($warehouse_id_arr)){
            $warehouse          = M('warehouse')->where('id in ('.  implode(',', $warehouse_id_arr).') and is_use=1 and to_hide=1 and is_return_sold='.C('CAN_RETURN_SOLD'))->getField('id,country_id');
        }
        foreach ($rs['list'] as &$value){
			$value['is_edit']				= 1;//1.YES 2.NO
			$value['is_delete']				= $this->checkDelete($value['instock_type']) == 0 ? 2 : 1;
			$value['detail']				= $details['list'][$value['instock_id']];
			$value['box']                   = $box_details['list'][$value['instock_id']];
            $value['warehouse_country']     = SOnly('country', $warehouse[$value['warehouse_id']],'abbr_district_name');
		}
		return $rs['list'];
	}
	
    /**
	 * 判断发货单是否可删除
	 * @author yyh 20151013
	 * @param mixed $id
	 * @return array
	 */
	public function checkDelete($state){
        return ($state >= C('CFG_INSTOCK_TYPE_UNEDIT')) ? 0 : 1;
    }

	/**
	 * 获取发货入库单信息（用于api接口）
	 * @author yyh 20151012
	 * @param mixed $ids
	 * @return array
	 */
	public function apiGetStockInList($ids){
		$DocInfoList	= $this->StockInAllList($ids);
		return $DocInfoList;
	}


	/**
	 * 获取发货入库单基本信息列表
	 * @author yyh 20151012
	 * @param mixed $ids
	 * @return array
	 */
	public function StockInAllList($ids){
		if (!is_array($ids)) {
			$ids	= explode(',', $ids);
		}
		if (empty($ids)) {
			return array();
		}
		$rs	= _formatList(M('instock')->field('id as instock_id,instock_no')
				->where(array('id' => array('in', $ids)))
				->select(), null, 0);
		if ($rs['list']) {
			$storage_date	= M('InstockStorage')->where(array('instock_id' => array('in', $ids)))->group('instock_id')->getField('instock_id,max(storage_date) as storage_date');
			$import_date	= M('FileRelationDetail')->alias('frd')->join('inner join __FILE_LIST__ f on f.id=frd.object_id')->where(array('frd.relation_id' => array('in', $ids), 'frd.file_type' => array_search('InstockImport', C('CFG_FILE_TYPE'))))->group('frd.relation_id')->getField('frd.relation_id, max(f.create_time) as create_time');
			//发货单产品明细
			$join		= array(
				'left join __INSTOCK_BOX__ b on d.box_id=b.id',
				'left join __PRODUCT__ p on p.id=d.product_id',
			);
			$details	= _formatList(M('InstockDetail')->alias('d')->join($join)
										->field('d.instock_id,b.box_no,p.product_no,sum(in_quantity) as quantity')
										->where(array('d.instock_id' => array('in', $ids)))
										->group('d.instock_id,d.product_id')
										->select(), null, 0, array('instock_id'));
			foreach ($rs['list'] as &$value){
				$value['detail']	= $details['list'][$value['instock_id']];
				if (isset($storage_date[$value['instock_id']])) {
					$value['storage_date']	= $storage_date[$value['instock_id']];
				} elseif (isset ($import_date[$value['instock_id']])) {
					$value['storage_date']	= date('Y-m-d', strtotime($import_date[$value['instock_id']]));
				}
			}
		}
		return $rs['list'];
	}

	/**
	 * 导入EXCEL关联insert
	 *
	 * @return array
	 */
	public function importUpdate(){
		$info	= $this->data;
		$this->_brf();
		$this->id	= $info['id'];
		unset($this->data['referer'],$this->data['error_message']);
		if($this->_beforeModel($info) == false){
			$this->error_type	= 1;
			return false;
		}

		$rs = $this->relation(true)->save();
		if (false === $rs) {
			$this->error_type	=	2;
			return false;
		}
		$this->_afterModel($info);
		$this->execTags($info);
		A('Instock')->addTimer($this->id);
		return $this->id;
	}
    /**
	 * 获取产品的详细信息
	 *
	 * @return array
	 */
	public function getProductInfo(&$info,$field,$factory_id=false){
        $ids			= array();
        foreach ($info as $value){
            $ids[$value[$field]]  = $value[$field];
        } 
        $where[$field]            = array('in', $ids);
        if($factory_id){
            $where['factory_id']  = $factory_id;
        } 
        $fields			= 'id as product_id,product_no,if(check_status=1,check_weight,0) as check_weight,if(check_status=1,check_high,0) as check_high,if(check_status=1,check_long,0) as check_long,if(check_status=1,check_wide,0) as check_wide,if(check_status=1,check_high*check_long*check_wide,0) as check_cube';
        $product_no	    = resetArrayIndex(M('Product')->field($fields)->where($where)->select(),$field);				
        if ($product_no) {
			foreach ($info as &$val){
                $product_info   =$product_no[$val[$field]];  
                $val	        = array_merge($val, $product_info); 
		    }	
		}
    }
}