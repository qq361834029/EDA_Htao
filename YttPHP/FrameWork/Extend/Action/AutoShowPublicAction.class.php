<?php
/**
 * autoshow类
 * @copyright   2011 展联软件友拓通
 * @category   	通用
 * @package  	Action 
 * @version 	2011-03-25
 * @author 		何剑波
 */
class AutoShowPublicAction extends CommonAction {

	public function _initialize(){
		parent::_initialize();
		C('SHOW_PAGE_TRACE',false);
	}

	/// 构造函数
	public function __destruct(){
		exit;
	}


	/// autoshow
	public function index(){
		/// 不同的流程显示不同的内容
		$id     = intval($_POST['id']);
		$module = $_POST['module'];
		$type   = $_POST['type'];
		if($type == 'state_log'){
			addLang($module);
			switch ($module) {
				case 'DhlList':
					addLang('Dhl');
					$this->getDhlRequestStatus($id);
					$tpl_name = 'dhlRequestStatus';
					break;
				case 'CorreosList':
					addLang('Correos');
					$this->getCorreosRequestStatus($id);
					$tpl_name = 'correosRequestStatus';
					break;
				default:
					$this->getStateLog($id,$module);					
					$tpl_name = 'showStateLog';
					$this->dd_update_field_name	= 'dd_' . array_search($module,C('STATE_OBJECT_FIELD'));
					break;
			}
		}else{
			addLang('Product');
			switch ($module) {
				case 'UndealQuantity'://拣货导入未分配数量
					$this->getUndealQuantity($id);
					$tpl_name = 'undealQuantity';
					break;				
				case 'SaleOrderShipping'://新建订单
					$this->getShippingInfo($id);
					$tpl_name = 'saleOrderShipping';
					break;
				case 'SaleOrder':
				case 'SaleStorage':
                    $is_return_sold = ' and w.is_return_sold='.C('CAN_RETURN_SOLD');
                case 'ReturnSaleOrder':
					$this->storage = _formatList(D('StorageShow')->getProductSaleStorage($id,$is_return_sold));
					$tpl_name = 'saleStorage';
					break;
				case 'PreDelivery':
				case 'Delivery':
				case 'Stocktake':
				case 'Profitandloss':
				case 'RealStorage'://库存列表
                    $where  = ' and w.is_return_sold='.C('CAN_RETURN_SOLD');
                case 'ReturnStorage':
                    if(empty($where)){
                        $where  = ' and w.is_return_sold='.C('NO_RETURN_SOLD');
                    }
                case 'ReturnRealStorage':
				case 'Adjust'://库存调整
                case 'ShiftWarehouse':
					if (!C('STORAGE_ZERO')) {$where .= ' and (quantity!=0 or picking_quantity!=0)';}
					$userInfo	= getUser();
					switch ($userInfo['role_type']) {
						case C('SELLER_ROLE_TYPE'):
							$storage_attr	= array('warehouse_id', 'product_id');
							$groupByKey		= 'warehouse_id';
                            $join           = ' s left join warehouse w on w.id=s.warehouse_id';
							$expand			= array();		
							$this->is_factory	= true;
							break;
						case C('WAREHOUSE_ROLE_TYPE'):
                            $warehouse_id   = M('warehouse')->where('relation_warehouse_id='.intval($userInfo['company_id']))->getField('id',true);
                            $warehouse_id[] = intval($userInfo['company_id']);
							$where			.= ' and s.warehouse_id in (' . implode(',', $warehouse_id).')';
							$this->is_warehouser	= true;
						default :
							$storage_attr	= array('s.warehouse_id', 's.location_id', 's.product_id');
							$extend_field	= ', l.barcode_no';
							$join			= 's left join location l on l.id=s.location_id 
                                               left join warehouse w on w.id=s.warehouse_id';
							$groupByKey		= array('warehouse_id');
							$expand			= array('sum_group_by'=>array('warehouse_id'));							
							break;
					}
					$str_field = implode(',',$storage_attr);
					$rs	= M('Storage')->field($str_field . ',sum(quantity) as real_storage, sum(picking_quantity) as picking_quantity' . $extend_field)->join($join)->where('product_id='.$id.$where)->group($str_field)->order($str_field)->select();

                    $this->storage = _formatList($rs, null, 1, $groupByKey, $expand);
					$tpl_name = 'realStorage';
					break;
                    case 'QuestionOrder':
                        $this->assign('mobile',$_POST['id']);
                        $tpl_name = 'mobile';
                        break;
                    case 'WarehouseFee':
                        $this->getWarehouseFeeInfo($id);
                        $tpl_name = 'warehouse_fee';
                        break;
					case 'Recharge':	//注意事项
                        $this->getComments("Recharge",$id,"confirm_comments");
                        $tpl_name = 'comments';
                        break;
				default:
					$tpl_name = 'product';
					break;
			}
		}
		if (in_array($tpl_name, array('saleStorage', 'realStorage', 'product'))) {
			$this->getProductInfo($id);
		}
		$this->display($tpl_name);
	}
	
	protected function getComments($table,$id,$field = 'comments'){
        $comments = M($table)->where(array('id'=>$id))->getField($field);
        $this->tpl_action_name	= 'view';
		$this->assign ('comments',$comments);
    }
	
    protected function getWarehouseFeeInfo($id){
        $vo = D('WarehouseFee')->getInfo($id,'view');
        $this->tpl_action_name	= 'view';
		$this->assign ('rs',$vo);
    }

    protected function getProductInfo($id){
		$vo = D('Product')->getInfo($id,'view');
		$this->assign ('rs',$vo);
		$this->assign ('dd_color',S('color'));
		$this->assign ('dd_size',S('size'));
		$temp 	= S('currency');
		$cur	= array('in'=>$temp[1],'out'=>$temp[C('CURRENCY')]);
		$this->assign('cur',$cur);
	}
	
	protected function getStateLog($id,$module){
		$object_type = array_search($module,C('STATE_OBJECT_TYPE'));
		$list	     = _addFlowLink(_formatList(M('state_log')->field('object_id,state_id as ' . array_search($module,C('STATE_OBJECT_FIELD')) . ',user_id,create_time as paid_date,comments as log_comments')->where('object_id='.$id.' and object_type='.$object_type)->order('id desc')->select()));
		$this->assign ('list',$list);
	}

	protected function getShippingInfo($id){
		$rs = D('Shipping')->getInfo($id); 
        foreach($rs['detail'] as &$detail){
            $detail['weight_begin']=rtrim(rtrim($detail['weight_begin'],'0'),'.');
            $detail['weight_end']=rtrim(rtrim($detail['weight_end'],'0'),'.');
          }
		//pr($rs['detail'],'',1);
		$this->assign ('shipping',$rs['detail']);
	}
	
	/**
	 * 拣货导入未分配数量
	 * @param int $id
	 */
	protected function getUndealQuantity($id){
		$list = M('FileDetail')->field('fd.product_id, fd.product_id as p_id,fd.undeal_quantity,fd.location_id,l.barcode_no')->join('fd left join location l on fd.location_id=l.id')->where('fd.file_id=' . (int)$id . ' and fd.undeal_quantity>0 and fd.state!=' . C('CFG_IMPORT_FAILED_STATE'))->select(); 
        if(empty($list)){
            $list   = M('storage_log')->field('lg.product_id, lg.product_id as p_id,lg.quantity as undeal_quantity,lg.location_id,l.barcode_no')->join('lg left join location l on lg.location_id=l.id')->where('lg.relation_type='.C('STORAGE_LOG_UNDEAL_QUANTITY_TYPE').' and lg.main_id='.(int)$id)->select();
        }
        $this->assign ('list', _formatList($list));
	}

	protected function getDhlRequestStatus($id) {
		$field	= 'log.id, log.request_time, log.return_time, log.request_type, log.request_status as log_request_status, log.status_code as log_status_code, log.status_message as log_status_message, '
				. 'detail.shipmentNumber, detail.Labelurl, detail.request_status, detail.status_code, detail.status_message';
		$join	= 'INNER JOIN __DHL_LOG__ log on log.id=detail.dhl_log_id';
		$where	= array(
			'dhl_list_id'	=> $id,
		);
		$list	= M('DhlLogDetail')->alias('detail')->field($field)->join($join)->where($where)->order('log.id desc')->limit(10)->select();
		$this->assign ('list', _formatList($list));
	}


	protected function getCorreosRequestStatus($id) {
		$field	= 'id, request_time, return_time, request_type, '
				. 'shipmentNumber, Labelurl, request_status, status_code, status_message';
		$where	= array(
			'correos_list_id'	=> $id,
		);
		$list	= M('CorreosLog')->field($field)->where($where)->order('id desc')->limit(10)->select();
		$this->assign ('list', _formatList($list));
	}
}
?>