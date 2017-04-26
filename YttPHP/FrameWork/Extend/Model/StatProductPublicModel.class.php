<?php

/**
 * 产品详细信息
 * @copyright   Copyright (c) 2006 - 2013 Top Union 展联软件友拓通
 * @category    统计
 * @package   Model
 * @author   何剑波
 * @version  2.1,2012-07-22
 */

class StatProductPublicModel extends RelationCommonModel  {
	
	protected $tableName='product';
	
	public function __construct(){
		parent::__construct();
		import('ORG.Util.Page');
	}
	
	
	/**
	 * 取查看产品时的明细信息
	 * @param int $id 产品ID
	 * @return array
	 */
	public  function getBasicInfo($id) {
		$where		= 'id=' . $id . getBelongsWhere();
		$rs 		= M('Product')->field('*,cube_long*cube_high*cube_wide cube,check_high*check_wide*check_long as check_cube')->where($where)->find();// 取主表信息
		if (!$rs) {
			throw_json(L('data_right_error'));
		}
		$detail 	= M('ProductDetail')->where('product_id='.$id)->formatFindAll(array('key'=>'properties_id'));// 取明细信息
		// 产品图片信息
		$rs['pics'] = D('Gallery')->getAry($id,1);		

		// 取在用的产品属性信息
		$userInfo	= getUser();
		$role_type	= (int)$userInfo['role_type'];
		$role_type_where = ($role_type ==1||$_SESSION[C('ADMIN_AUTH_KEY')]==true) ? " " : " and role_type in (1,".$role_type.")";
		if(LANG_SET=='cn'){
			$properties_name = 'properties_name';
			$pv_name = 'pv_name';
		}else {
			$properties_name = 'properties_name_de as properties_name';
			$pv_name = 'pv_name_de as pv_name';
		}
		$properties 	= M('Properties')->field('id as properties_id,properties_no,'.$properties_name.',properties_type')->where('to_hide=1'.$role_type_where)->formatFindAll(array('key'=>'properties_id'));
		$_cache_proper 	= M('PropertiesValue')->field('id,'.$pv_name)->formatFindAll(array('key'=>'id'));
		foreach ($properties as $_id => &$var) {
			$var['product_id'] 	= $detail[$_id]['product_id'];
			$var['value'] 		= $detail[$_id]['value'];
			switch ($var['properties_type']) {
				case 1:// 自定义输入
					$var['properties_value'] = $var['value'];
				break;
				case 2:// 单选框
					$var['properties_value'] = $_cache_proper[$var['value']]['pv_name'];
				break;
				case 3:// 多选框
					if (strpos($var['value'],',')) {
						$temp = @explode(',',$var['value']);
						foreach ((array)$temp as $properties_value_id) {
							$v_ary[] = $_cache_proper[$properties_value_id]['pv_name'];
						}
						$var['properties_value'] = implode('，',$v_ary);
					} else {
						$var['properties_value'] = $_cache_proper[$var['value']]['pv_name'];
					}
				break;
			}
		}
		!empty($properties) && $rs['detail'] = $properties;
		// 取颜色信息
		if (C('product_color')==1) {
			$temp = M('ProductColor')->where('product_id='.$id)->field('color_id')->select();
			if (!empty($temp)) {
				$dd_color = S('color');
				foreach ($temp as $value) {
					$rs['color'][] = $dd_color[$value['color_id']]['color_name'];
				}
				$rs['color'] = implode('，',$rs['color']);
			}
		}
		// 取尺码信息
		if (C('product_size')==1) {
			$temp = M('ProductSize')->where('product_id='.$id)->field('size_id')->select();
			if (!empty($temp)) {
				$dd_size = S('size');
				foreach ($temp as $value) {
					$rs['size'][] = $dd_size[$value['size_id']]['size_name'];
				}
				$rs['size'] = implode('，',$rs['size']);
			}
		}		
		return _formatWeightCube(_formatArray($rs));
	}
	
	/// 获取经营异动信息
	public function getRunInfo($id) {
        $warehouse_id   = $this->getNoReturnSold();
        $no_sale_warehouse  = $warehouse_id;
        $get_no_sale_where   = $no_sale_warehouse;
        $is_able        = L('able');
        //退货不可再销售仓库
        if(getUser('role_type')==C('WAREHOUSE_ROLE_TYPE')){
            //不可销售仓库登录时不用过滤不可销售仓库
            if(in_array(getUser('company_id'), $warehouse_id)){
                $warehouse_id   = array(0);
                $is_able    = L('unable');
            }
            $relation_warehouse_id   = $this->relationWarehouse();
            if(count($relation_warehouse_id)==1 && in_array($relation_warehouse_id[0],$no_sale_warehouse)){
                $get_no_sale_where  = $relation_warehouse_id;
            }
			$out_warehouse_where = 'out_warehouse_id in ('.implode(',',$relation_warehouse_id).')'; 
            $where  = 'a.warehouse_id in ('.implode(',',$relation_warehouse_id).')'; 
        }else{
			$out_warehouse_where = 1;
            $where  = '1';
        }
		// 获取在途总数量
		$sql        = ' select sum(if(quantity>in_quantity,quantity-in_quantity,0)) as onroad_qn
                    from instock_detail as b 
                    left join instock as a on a.id=b.instock_id
                    where '.$where.' and b.product_id='.$id.' and a.instock_type not in (' . C('NO_ONROAD_STATE') . ')  group by b.product_id';
        $onroad_qn	= $this->db->query($sql);
        //获取头程入库数量
//        $sql        = 'select sum(instock_storage_qn) as instock_storage_qn from (
//            select sum(in_quantity) as instock_storage_qn
//                    from instock_storage_detail
//                    where product_id='.$id.' group by product_id
//                    union all 
//                    select sum(b.quantity) as instock_storage_qn
//                    from file_list as a left join file_detail b on a.id=b.file_id
//                    where a.file_type=' . array_search('InstockImport', C('CFG_FILE_TYPE')).' and b.state in ('.C('CFG_IMPORT_SUCCESS_STATE').','.C('CFG_IMPORT_PROCESSED_STATE').') and product_id='.$id.'
//                    ) as tmp';
        $sql        = 'select count(a.id) as count,sum(in_quantity) as instock_storage_qn from instock a
                    inner join instock_detail b on a.id=b.instock_id
                    where  '.$where.' and b.product_id='.$id.'
                    group by b.product_id';
        $instock_storage_qn = $this->db->query($sql);
        //库存调整数量
		$sql 		= "select 
						abs(sum(if(a.quantity>0,a.quantity,0)))  as adjust_add,
					   	abs(sum(if(a.quantity<0,a.quantity,0)))  as adjust_sub
						from adjust b inner join adjust_detail a on  b.id=a.adjust_id 
						where ".$where." and product_id=".$id." and warehouse_id not in (".  implode(',', $warehouse_id).") group by product_id";		
		$adjust 	= $this->db->query($sql);
        //销售数量
        $sql        = "select -sum(quantity) as sale_order_qn
                        from storage_log a
                        where ".$where." and product_id=".$id." and relation_type=3
                        group by product_id";
		$sale_order = $this->db->query($sql);
        //发货数量
        $sql        = 'select sum(c.real_quantity) as out_stock_qn 
                       from file_relation_detail b
                       left join sale_order a on b.relation_id=a.id
                       inner join sale_order_detail c on a.id=c.sale_order_id
                       where '.$where.' and c.product_id='.$id.'  and c.real_quantity>0  and a.sale_order_state='.C('SHIPPED').' and file_type='.array_search('PickingImport',C('CFG_FILE_TYPE')).'
                       group by c.product_id';
//        $sql        = "select sum(real_quantity) as out_stock_qn 
//                        from sale_order_detail b 
//                        left join sale_order a on b.sale_order_id=a.id
//                        where ".$where." and product_id=".$id.' and sale_order_state='.C('SHIPPED').'
//                        group by product_id';
        $out_stock_qn   = $this->db->query($sql);
        
		// 退货数量	
        $sql        = "select sum(a.quantity) as return_qn
                        from return_sale_order as b
                        left join return_sale_order_detail as a on b.id=a.return_sale_order_id
						where  ".$where." and a.product_id=".$id." group by a.product_id"; 
        $return_quantity 		= $this->db->query($sql);
        //可销售库存
        $sql        = "select sum(quantity) as sale_storage_qn  from sale_storage as a where  ".$where." and product_id=".$id."  and warehouse_id not in (".  implode(',', $no_sale_warehouse).") group by product_id";
        $sale_storage           = $this->db->query($sql);	
        //实际库存数量
        $sql        = "select sum(quantity) as real_storage_qn  from storage as a where  ".$where." and product_id=".$id."  and warehouse_id not in (".  implode(',', $warehouse_id).") group by product_id";
//        dre($sql);
        $real_storage           = $this->db->query($sql);
        //拣货完成
        $sql        = 'select sum(a.quantity) as picking_qn 
                       from file_relation_detail b
                       inner join sale_order_detail a on a.sale_order_id=b.relation_id
                       where '.$where.' and a.product_id='.$id.' and file_type='.array_search('PickingImport',C('CFG_FILE_TYPE')).'
                       group by a.product_id';
		$picking                = $this->db->query($sql);
        //退货入库数量(可用) edit by yyh 20151222过滤丢弃数量
        $sql        = 'select sum(a.quantity-a.drop_quantity) as can_sale_qn from return_sale_order_storage_detail as a
                        where  '.$where.' and product_id='.$id.' and a.warehouse_id not in ('.  implode(',', $no_sale_warehouse).')
                        group by product_id';
        $return_can_sold 		= $this->db->query($sql);
        //退货入库数量(不可用)edit by yyh 20151222过滤丢弃数量
        $sql        = "select sum(a.quantity-a.drop_quantity) as no_sale_qn from return_sale_order_storage_detail as a
                        where  ".$where." and product_id=".$id." and a.warehouse_id in (".  implode(',', $get_no_sale_where).") 
                        group by product_id";
        $return_no_sold         = $this->db->query($sql);
        //(旧)拣货重新上架数量
        $sql        = 'select -sum(quantity) as old_backshelves_qn 
                        from storage_log as a
                        where '.$where.' and product_id='.$id.' and relation_type=14 group by product_id';
        $old_backshelves    = $this->db->query($sql);
        //拣货重新上架数量
        $sql        = 'select sum(b.undeal_quantity) as undeal_qn 
                      from file_detail b
                      left join file_list a on b.file_id=a.id
                      where '.$where.' and b.product_id='.$id.' and a.file_type='.array_search('PickingImport',C('CFG_FILE_TYPE')).'
                      group by b.product_id';
        //已重新上架数量
        $sql        = 'select sum(a.quantity) as backshelves_qn from storage_log as a 
                    where  '.$where.' and a.product_id='.$id.' and a.relation_type='.C('STORAGE_LOG_UNDEAL_QUANTITY_TYPE');
        $backshelves   = $this->db->query($sql);
        
        //已出库待收取(可用) add yyh 20151010
        $sql        = 'select sum(a.quantity) as out_batch_can_sold_qn from out_batch d 
                    left join out_batch_detail b on d.id=b.out_batch_id
                    left join pack_box_detail c on c.pack_box_id=b.pack_box_id
                    left join return_sale_order_storage_detail a on c.return_sale_order_id=a.return_sale_order_id
                    where  '.$where.' and a.product_id='.$id.' and a.warehouse_id not in ('.  implode(',', $no_sale_warehouse).')
                    group by a.product_id';
        $out_batch_can_sold  = $this->db->query($sql);
        //已出库待收取(不可用) add yyh 20151010
        $sql        = 'select sum(a.quantity) as out_batch_no_sold_qn from out_batch d 
                    left join out_batch_detail b on d.id=b.out_batch_id
                    left join pack_box_detail c on c.pack_box_id=b.pack_box_id
                    left join return_sale_order_storage_detail a on c.return_sale_order_id=a.return_sale_order_id
                    where  '.$where.' and a.product_id='.$id.' and a.warehouse_id in ('.  implode(',', $get_no_sale_where).')
                    group by a.product_id';
        $out_batch_no_sold   = $this->db->query($sql);
        //丢弃数量 add yyh 20151010
        $sql        = 'SELECT sum(e.drop_quantity) as down_and_destory_qn from return_sale_order b
                        left join return_sale_order_detail a on b.id=a.return_sale_order_id
                        left join return_sale_order_detail_service c on a.id=c.return_sale_order_detail_id
                        left join return_service_detail d on c.service_detail_id=d.id
                        left join return_sale_order_storage_detail e on e.return_sale_order_id = a.return_sale_order_id and a.product_id = e.product_id
                        where '.$where.' and a.product_id='.$id.' and b.return_sale_order_state='.C('RETURN_SALE_ORDER_STATE_DROPPED').' and d.return_service_id='.C('DOWN_AND_DESTORY');
        $down_and_destory   = $this->db->query($sql);
        //未重新上架
        $sql    = 'SELECT sum(b.undeal_quantity) as unbackshelves_qn FROM `file_list` as a
                    left join file_detail b on a.id=b.file_id
                    WHERE '.$where.' and b.product_id='.$id.' and  b.undeal_quantity >0 AND b.state IN ( 101, 103 )';
        $unbackshelves  = $this->db->query($sql);
		//获取移仓数量
		//增加
		$sql    = 'SELECT sum(quantity) as shift_warehouse_add FROM `shift_warehouse_detail` 
				    WHERE product_id='.$id.' and  out_warehouse_id in ('.implode(',', $get_no_sale_where).') and '.$out_warehouse_where.' and in_warehouse_id  not in ('.  implode(',', $get_no_sale_where).')' ;
		$shift_warehouse_add  = $this->db->query($sql);
		//减少
		$sql    = 'SELECT sum(quantity) as shift_warehouse_sub FROM `shift_warehouse_detail` 
				    WHERE product_id='.$id.' and  out_warehouse_id not in ('.implode(',', $get_no_sale_where).') and '.$out_warehouse_where.' and in_warehouse_id  in ('.  implode(',', $get_no_sale_where).')' ;
		$shift_warehouse_sub  = $this->db->query($sql);
        //退货不可销售运回国内 add yyh 20151010
        $undeal_quantity        = $this->db->query($sql);
        //入库
		$list['onroad_qn']          = floatval($onroad_qn[0]['onroad_qn']);                     //在途数量
		$list['instock_storage_qn'] = floatval($instock_storage_qn[0]['instock_storage_qn']);   //头程入库
		$list['return_qn']          = floatval($return_quantity[0]['return_qn']);               //退货数量
		$list['adjust_add']         = floatval($adjust[0]['adjust_add']);                       //仓库调整（增加）
		$list['can_sale_qn']        = floatval($return_can_sold[0]['can_sale_qn']);             //退货可再销售数量
		$list['no_sale_qn']         = floatval($return_no_sold[0]['no_sale_qn']);               //退货不可再销售数量
        $list['backshelves_qn']     = floatval($backshelves[0]['backshelves_qn']);              //重新上架数量
    	$list['shift_warehouse_add']    = floatval($shift_warehouse_add[0]['shift_warehouse_add']);    //移仓（增加）
    
		//出库
        $list['old_backshelves_qn']    = floatval($old_backshelves[0]['old_backshelves_qn']);      //重新上架数量(旧)
		$list['sale_order_qn']		= floatval($sale_order[0]['sale_order_qn']);                //销售订单
        $list['out_stock_qn']       = floatval($out_stock_qn[0]['out_stock_qn']);               //订单出库
        $list['picking_qn']         = floatval($picking[0]['picking_qn']);                      //拣货未发货数量
		$list['adjust_sub']         = floatval($adjust[0]['adjust_sub']);                       //仓库调整（减少）
		$list['out_batch_can_sold_qn']  = floatval($out_batch_can_sold[0]['out_batch_can_sold_qn']);    //已出库待收取(可用)
		$list['out_batch_no_sold_qn']   = floatval($out_batch_no_sold[0]['out_batch_no_sold_qn']);  //已出库待收取(不可用)
        $list['unbackshelves_qn']       = floatval($unbackshelves[0]['unbackshelves_qn']);          //未重新上架数量
        $list['down_and_destory_qn']    = floatval($down_and_destory[0]['down_and_destory_qn']);    //丢弃数量
		$list['shift_warehouse_sub']    = floatval($shift_warehouse_sub[0]['shift_warehouse_sub']);    //移仓（减少）
//20150911 改成加实际库存
        
//        $list['undeal_qn']          = floatval($undeal_quantity[0]['undeal_qn']);               //拣货未分配数量
        //合计 
        $list['sale_storage']       = floatval($sale_storage[0]['sale_storage_qn']);            //可销售库存
        $list['real_storage']       = floatval($real_storage[0]['real_storage_qn']);            //实际库存
        $list['id']                 = $id;
        $list['is_able']            = $is_able;
		return $list;
	}
	
    //退货不可再销售仓库
    public function getNoReturnSold(){
        $warehouse_id   = M('warehouse')->where('is_return_sold='.C('NO_RETURN_SOLD'))->getField('id',TRUE);
        $warehouse_id[] = 0;
        return $warehouse_id;
    }
    //仓库帐号登录退货不可再销售关联仓库
    public function relationWarehouse(){
        if(getUser('role_type')==C('WAREHOUSE_ROLE_TYPE')){
            $is_return_sold = M('warehouse')->where('id='.getUser('company_id'))->getField('is_return_sold');
            if($is_return_sold == C('CAN_RETURN_SOLD')){
                $warehouse_id   = M('warehouse')->where('relation_warehouse_id='.getUser('company_id'))->getField('id',TRUE);
                $warehouse_id[] = getUser('company_id');
                return $warehouse_id;
            }else{
                return array(getUser('company_id'));
            }
        }
    }
    /// 取库存信息
	public function getStorageInfo($id) {
        $sql            = 'select a.product_id as product_id,sum(quantity) as quantity from sale_storage as a
        left join product as p on a.product_id = p.id
        left join warehouse as w on a.warehouse_id=w.id
        where a.product_id='.$id.' and w.is_return_sold='.C('CAN_RETURN_SOLD').' group by a.product_id';	
		$sale_storage 	= _formatList($this->db->query($sql));
		// 取实际库存
		$sql 			= ' select *,sum(quantity) quantity
							from storage
                            left join warehouse as w on storage.warehouse_id=w.id
                            where product_id='.$id.' and w.is_return_sold='.C('CAN_RETURN_SOLD').' group by warehouse_id having(sum(quantity)) <> 0							';
		$storage 		= _formatList($this->db->query($sql));	
		return array('sale_storage' => $sale_storage, 'storage' => $storage, 'title' => $title);
	}
	
	/// 获取明细数据
	public function getDetail() {
		$product	= SOnly('product', intval($_GET['id']));
		if ($_GET['type']) {
			$fun	= 'get'.ucfirst(trim($_GET['type']));
			$list = $this->$fun(intval($_GET['id']));
			$list['product']	= $product;
			return $list;
		}
	}
	//在途库存
    public function getOnroad($id){
        if(getUser('role_type')==C('WAREHOUSE_ROLE_TYPE')){
            $relation_warehouse_id   = $this->relationWarehouse();
            $where  = ' and a.warehouse_id in ('.implode(',', $relation_warehouse_id).')';
        }
		$sql = 'select count(*) as count, sum(quantity) as deliver_qn, sum(in_quantity) as storage_qn,sum(quantity-in_quantity) as no_storage_qn
					from instock a inner join instock_detail b on a.id=b.instock_id 
					where b.product_id='.$id.$where.'  and instock_type not in (' . C('NO_ONROAD_STATE') . ') 
					group by a.id';
		$count 	= M()->cache()->query($sql);
		$count	= reset($count);
		if (!$count) return ;
		$p 		= new Page($count['count']);
		$page 	= $p->show();
		// 分页信息
		$limit 	= ' limit '.$p->firstRow . ','.$p->listRows;
		// 取入库数量
		$sql = 'select instock_no, sum(quantity) as deliver_qn, sum(in_quantity) as storage_qn,sum(if(quantity>in_quantity,quantity-in_quantity,0)) as no_storage_qn,a.id AS instock_id, a.id AS m_id
				from instock a inner join instock_detail b on a.id=b.instock_id 
				where  b.product_id='.$id.$where.'  and instock_type not in (' . C('NO_ONROAD_STATE') . ')  group by a.id
				order by a.instock_no '.$limit;
		$list = $this->db->query($sql);
		$list 							= _formatList($list);
		foreach($list['list'] as $key=>$val){
            $list['total']['dml_sum_deliver_qn']	+= $val['deliver_qn'];
            $list['total']['dml_sum_storage_qn']	+= $val['storage_qn'];
            $list['total']['dml_sum_no_storage_qn'] += $val['no_storage_qn'];
		}
		$list['total']['dml_sum_deliver_qn']	= moneyFormat($list['total']['dml_sum_deliver_qn'],0,0);
		$list['total']['dml_sum_storage_qn']	= moneyFormat($list['total']['dml_sum_storage_qn'],0,0);
		$list['total']['dml_sum_no_storage_qn'] = moneyFormat($list['total']['dml_sum_no_storage_qn'],0,0);
		$list['total']['all_deliver_qn']        = moneyFormat($count['deliver_qn'], 0, 0);
        $list['total']['all_storage_qn']        = moneyFormat($count['storage_qn'], 0, 0);
        $list['total']['all_no_storage_qn']     = moneyFormat($count['no_storage_qn'], 0, 0);
		$list['page']					= $page;
		return $list;
    }
    /// 重新上架数量
    public function getBackshelves($id){
        if(getUser('role_type')==C('WAREHOUSE_ROLE_TYPE')){
            $relation_warehouse_id   = $this->relationWarehouse();
            $where  = ' and a.warehouse_id in ('.implode(',', $relation_warehouse_id).')';
        }
        if(intval($_GET['is_old']) == 2){
            $symbol = '-';
            $relation_type  = 14;
        }else{
            $relation_type  = C('STORAGE_LOG_UNDEAL_QUANTITY_TYPE');
        }
        $sql        = 'select count(distinct(main_id)) as count,'.$symbol.'sum(quantity) as quantity 
                        from storage_log as a
                        where product_id='.$id.$where.' and relation_type='.$relation_type.' group by product_id';
        $count 	= M()->cache()->query($sql);
		$count	= reset($count);		
		if (!$count) return ;
		$p 		= new Page($count['count']);
		$page 	= $p->show();
		// 分页信息
		$limit 	= ' limit '.$p->firstRow . ','.$p->listRows;
        $sql        = 'select b.file_name,file_list_no,file_list_date,'.$symbol.'sum(a.quantity) as quantity
                        from storage_log as a
                        left join file_list b on a.main_id=b.id
                        where product_id='.$id.$where.' and relation_type='.$relation_type.' group by a.main_id';
        $list= $this->db->query($sql);		
		$list 									= _formatList($list);
		foreach ($list['list'] as &$value) {
			$value['view_url'] 					= U('/Undeal/view/id/'.$value['m_id']);
            $value['file_name']                 = getUploadPath(16)  . $value['file_name'] . '.xls';
			$list['total']['sum_qn']			+= $value['quantity'];
		}
		$list['total']['product_no']			= $list['list'][0]['product_no'];	
		$list['total']['product_name']			= $list['list'][0]['product_name'];	
		$list['total']['all_sum_qn']			= moneyFormat($count['quantity'],0,0);
		$list['page']							= $page;
		return $list;
    }
        /// 未分配数量
    public function getUndeal($id){
        if(getUser('role_type')==C('WAREHOUSE_ROLE_TYPE')){
            $relation_warehouse_id   = $this->relationWarehouse();
            $where  = ' and a.warehouse_id in ('.implode(',', $relation_warehouse_id).')';
        }
        $sql        = 'select count(a.id) as count,sum(b.undeal_quantity) as quantity 
                    from file_detail b
                    left join file_list a on b.file_id=a.id
                    where b.product_id='.$id.$where.' and a.file_type='.array_search('PickingImport',C('CFG_FILE_TYPE')).' and b.undeal_quantity>0
                    group by b.product_id';
        $count 	= M()->cache()->query($sql);
		$count	= reset($count);		
		if (!$count) return ;
		$p 		= new Page($count['count']);
		$page 	= $p->show();
		// 分页信息
		$limit 	= ' limit '.$p->firstRow . ','.$p->listRows;
        $sql        = 'select a.file_name,a.file_list_no,a.file_list_date,sum(b.undeal_quantity) as quantity
                        from file_detail b
                        left join file_list a on b.file_id=a.id
                        where b.product_id='.$id.$where.' and a.file_type='.array_search('PickingImport',C('CFG_FILE_TYPE')).' and b.undeal_quantity>0
                        group by a.id';
        $list= $this->db->query($sql);		
		$list 									= _formatList($list);
		foreach ($list['list'] as &$value) {
			$value['view_url'] 					= U('/Undeal/view/id/'.$value['m_id']);
            $value['file_name']                 = $path . MODULE_NAME . '/' . $value['file_name'] . '.xls';
			$list['total']['sum_qn']			+= $value['quantity'];
		}
		$list['total']['product_no']			= $list['list'][0]['product_no'];	
		$list['total']['product_name']			= $list['list'][0]['product_name'];	
		$list['total']['all_sum_qn']			= moneyFormat($count['quantity'],0,0);
		$list['page']							= $page;
        
		return $list;
    }

    /// 订货明细
	public function getOrder($id) {
	
		$sql = "select count(*) as count,sum(unload_quantity) as unload_quantity, sum(money) as money,sum(quantity) quantity,sum(sum_qn) sum_qn,
					sum(load_capability) load_capability,sum(load_quantity) load_quantity from (
					select sum(quantity*capability*dozen-load_quantity) as unload_quantity,sum(quantity*capability*dozen * price) as money,sum(quantity) sum_qn,
					sum(quantity*capability*dozen) quantity,sum(load_capability) load_capability,sum(load_quantity) load_quantity
					from orders a inner join order_details b on a.id=b.orders_id 
					where b.product_id=".$id." 
					group by a.id
				) as temp group by 1=1";
		$count 	= M()->cache()->query($sql);
		$count	= reset($count);		
		if (!$count) return ;
		$p 		= new Page($count['count']);
		$page 	= $p->show();
		// 分页信息
		$limit 	= ' limit '.$p->firstRow . ','.$p->listRows;
		$sql = "select *,a.id as m_id,sum(quantity*capability*dozen) as sum_qn,sum(quantity*capability*dozen*price) as money,sum(quantity) quantity,
				sum(load_quantity) as load_quantity,sum(quantity*capability*dozen-load_quantity) as unload_quantity,sum(load_capability) load_capability
				from orders a inner join order_details b on a.id=b.orders_id where b.product_id=".$id.' 
				group by a.id order by a.order_no '.$limit;
		$list= $this->db->query($sql);		
		$list 									= _formatList($list);
		foreach ($list['list'] as &$value) {
			unset($value['create_time'],$value['update_time'],$value['audit_date']);
			$value['view_url'] 					= U('/Orders/view/id/'.$value['m_id']);
			$list['total']['sum_qn']			+= $value['sum_qn'];
			$list['total']['load_capability']	+= $value['load_capability'];
		}
		$list['total']['dml_load_capability']	= moneyFormat($list['total']['load_capability'],0,0);
		$list['total']['dml_sum_qn']			= moneyFormat($list['total']['sum_qn'],0,0);
		$list['total']['product_no']			= $list['list'][0]['product_no'];	
		$list['total']['product_name']			= $list['list'][0]['product_name'];	
		$list['total']['all_quantity']			= moneyFormat($count['quantity'],0,0);
		$list['total']['all_sum_qn']			= moneyFormat($count['sum_qn'],0,0);
		$list['total']['all_load_capability']	= moneyFormat($count['load_capability'],0,0);
		$list['total']['all_load_quantity']		= moneyFormat($count['load_quantity'],0,0);
		$list['total']['all_unload_quantity']  	= moneyFormat($count['unload_quantity'], 0, 0);
		$list['total']['all_money']  			= moneyFormat($count['money'], 0, C('MONEY_LENGTH'));
		$list['page']							= $page;
		
		return $list;
	}
	
	/// 装柜明细
	public function getLoad($id) {
		$sql = "select count(*) as count,sum(quantity) as quantity,sum(money) as money,sum(sum_qn) sum_qn from (
					select sum(quantity*capability*dozen) as quantity,sum(quantity) sum_qn,
					sum(quantity*capability*dozen*price) as money
					from load_container a inner join load_container_details b on a.id=b.load_container_id 
					where a.load_state=1 and b.product_id=".$id." 
					group by a.id 
				) as temp group by 1=1";
		$count 	= M()->cache()->query($sql);
		if (!$count) return ;
		$p 		= new Page($count[0]['count']);
		$page 	= $p->show();
		// 分页信息
		$limit 	= ' limit '.$p->firstRow . ','.$p->listRows;
		$sql = "select *,a.id as m_id,sum(quantity*capability*dozen) as quantity,sum(quantity) sum_qn,
				sum(quantity*capability*dozen*price) as money
				from load_container a inner join load_container_details b on a.id=b.load_container_id
				where a.load_state=1 and b.product_id=".$id.' 
				group by a.id order by a.load_container_no '.$limit;
		$list= $this->db->query($sql);		
		// 取入库数量
		$sql = "select sum(quantity*capability*dozen) as quantity,load_container_id
				from instock a inner join instock_detail b on a.id=b.instock_id 
				where b.product_id=".$id." group by load_container_id";
		$tmp	 = $this->db->query($sql);
		foreach((array)$tmp as $val){
			$instock[$val['load_container_id']]	= $val['quantity'];
		}
		$instock_all = array_sum((array)$instock);
		foreach ($list as &$value) {
			unset($value['create_time'],$value['update_time'],$value['audit_date']);
			$value['view_url'] 					= U('/LoadContainer/view/id/'.$value['m_id']);
			$total['sum_qn']					+= $value['sum_qn'];
		}
		$total									= _formatArray($total);		
		$list 									= _formatList($list);
		$list['total']['product_no']			= $list['list'][0]['product_no'];	
		$list['total']['product_name']			= $list['list'][0]['product_name'];
		$list['total']['all_money']  			= moneyFormat($count[0]['money'], 0, C('MONEY_LENGTH'));
		$list['total']['all_quantity']			= moneyFormat($count[0]['quantity'],0,0);
		$list['total']['all_sum_qn']			= moneyFormat($count[0]['sum_qn'],0,0);
		$list['total']							= array_merge($list['total'],$total);
		$list['page']							= $page;
		return $list;
	}
	
	/// 进货明细
	public function getInstock($id) {
//		$sql = 'select sum(count) as count,sum(quantity) as quantity from (
//					select count(distinct(c.id)) as count,sum(in_quantity) as quantity
//					from instock_storage a 
//                    inner join instock_storage_detail b on a.id=b.instock_storage_id 
//                    left join instock c on a.instock_id=c.id
//					where b.product_id='.$id.' 
//                    union all
//                    select count(distinct(d.id)) as count,sum(b.quantity) as quantity from file_list a 
//                    left join file_detail b on a.id=b.file_id 
//                    left join file_relation_detail c on a.id=c.object_id
//                    left join instock d on d.id=c.relation_id
//                    where a.file_type=' . array_search('InstockImport', C('CFG_FILE_TYPE')).' and b.state in ('.C('CFG_IMPORT_SUCCESS_STATE').','.C('CFG_IMPORT_PROCESSED_STATE').') and product_id='.$id.'
//				) as temp';
        if(getUser('role_type')==C('WAREHOUSE_ROLE_TYPE')){
            $relation_warehouse_id   = $this->relationWarehouse();
            $where  = ' and a.warehouse_id in ('.implode(',', $relation_warehouse_id).')';
        }
        $sql    = 'select count(a.id) as count,sum(in_quantity) as quantity from instock a
                    inner join instock_detail b on a.id=b.instock_id
                    where b.product_id='.$id.$where.'
                    group by b.product_id';
		$count 	= M()->cache()->query($sql);
		$count	= reset($count);		
		if (!$count) return ;
		$p 		= new Page($count['count']);
		$page 	= $p->show();
		// 分页信息
		$limit 	= ' limit '.$p->firstRow . ','.$p->listRows;		
		// 入库列表
//		$sql = 'select instock_no,box_no,real_arrive_date,instock_id, quantity as quantity,type from (
//            select d.instock_no as instock_no,e.box_no as box_no,d.real_arrive_date,d.id as instock_id,a.id as m_id, sum(b.in_quantity) as quantity ,1 as type
//				from instock_storage a inner join instock_storage_detail b on a.id=b.instock_storage_id 
//                left join instock d on d.id=a.instock_id
//                left join instock_detail c on b.instock_detail_id=c.id
//                left join instock_box e on e.id=c.box_id
//				where b.product_id='.$id.' group by a.id
//                union all 
//                select d.instock_no as instock_no,c.box_no as box_no,d.real_arrive_date,d.id as instock_id,d.id as m_id, sum(b.quantity) as quantity ,2 as type
//                from file_list a
//                left join file_detail b on a.id=b.file_id
//                left join instock_box c on c.id=b.box_id
//                left join instock d on c.instock_id=d.id
//                where a.file_type=' . array_search('InstockImport', C('CFG_FILE_TYPE')).' and b.state in ('.C('CFG_IMPORT_SUCCESS_STATE').','.C('CFG_IMPORT_PROCESSED_STATE').') and product_id='.$id.'
//				) as tmp order by instock_id '.$limit;
		$sql    = 'select sum(in_quantity) as quantity,a.instock_no,c.box_no,a.real_arrive_date,a.id as instock_id
                    from instock a
                    left join instock_detail b on a.id=b.instock_id
                    left join instock_box c on b.box_id=c.id
                    where b.product_id='.$id.$where.' and b.in_quantity>0
                    group by a.id';
		$list	 = $this->db->query($sql);
		foreach ($list as $key=>$value) {
            $list[$key]['view_url']             = U('/LoadContainer/view/id/'.$value['m_id']);
			$total['sum_qn']					+= $value['quantity'];
            if(empty($value['instock_id'])){
                unset($list[$key]);
            }
		}
		$total									= _formatArray($total);		
		$list 									= _formatList($list);
		$list['total']['product_no']			= $list['list'][0]['product_no'];	
		$list['total']['product_name']			= $list['list'][0]['product_name'];
		$list['total']['all_quantity']			= moneyFormat($count['quantity'],0,0);
		$list['total']							= array_merge($list['total'],$total);
		$list['page']							= $page;
		return $list;
	}
	
	/// 销售明细
	public function getSale($id) {
        switch ($_GET['out_stock']){
//            case 1://发货
//                $field  = 'real_quantity';
//                $where  = ' and sale_order_state='.C('SHIPPED').' and real_quantity>0';
//                break;
//            case 2://拣货完成
//                $field  = 'quantity';
//                $where  = ' and sale_order_state='.C('SALE_ORDER_STATE_PICKED');
//                break;
            default ://销售数量
                $field  = '-sum(quantity)';
//                $where  = ' and sale_order_state<>'.C('SALEORDER_OBSOLETE');
                
        }
        if(getUser('role_type')==C('WAREHOUSE_ROLE_TYPE')){
            $relation_warehouse_id   = $this->relationWarehouse();
            $where_warehouse    = ' and a.warehouse_id in ('.implode(',', $relation_warehouse_id).')';
        }
//		$sql = 'select count(*) as count,sum('.$field.') as quantity
//            from sale_order a
//            left join sale_order_detail b on a.id=b.sale_order_id
//            where b.product_id='.$id.$where.$where_warehouse.'
//            group by b.product_id';
        $sql        = "select count(distinct(main_id)) as count,-sum(quantity) as quantity
                from storage_log a
                where product_id=".$id.$where_warehouse." and relation_type=3
                group by product_id";
		$count 	= M()->cache()->query($sql);			
		$count	= reset($count);
		if (!$count) return ;		
		$p 		= new Page($count['count']);
		$page 	= $p->show();
		// 分页信息
		$limit 	= ' limit '.$p->firstRow . ','.$p->listRows;		
//		$sql	= 'select a.id as sale_order_id,sale_order_no,order_date,sum('.$field.') as quantity,c.comp_name as comp_name
//                from sale_order a
//                left join sale_order_detail b on a.id=b.sale_order_id
//                left join client c on a.client_id=c.id
//                where b.product_id='.$id.$where.$where_warehouse.'
//                group by a.id'.$limit;
        $sql    = "select a.id as sale_order_id,sale_order_no,order_date,".$field." as quantity,c.comp_name as comp_name
                    from storage_log b
                    inner join sale_order a on b.main_id=a.id
                    inner join client c on a.client_id=c.id
                    where product_id=".$id.$where_warehouse." and relation_type=3
                    group by a.id".$limit;
		$list = $this->db->query($sql);	
		foreach ($list as &$value) {	
			$value['view_url'] 			= U('/ReturnSaleOrder/view/id/'.$value['m_id']);
			$total['sum_qn']			+= $value['quantity'];
		}	
		$list 							= _formatList($list);
		$list['total']					= array_merge($list['total'],_formatArray($total));
		$list['total']['product_no']	= $list['list'][0]['product_no'];	
		$list['total']['product_name']	= $list['list'][0]['product_name'];	
        
		$list['total']['all_sum_qn']        = moneyFormat($count['quantity'],0,0);
		$list['page']                       = $page;
        return $list;
	}
    
    
    public function getOutStock($id){
        if(getUser('role_type')==C('WAREHOUSE_ROLE_TYPE')){
            $relation_warehouse_id   = $this->relationWarehouse();
            $where      = ' and b.warehouse_id in ('.implode(',', $relation_warehouse_id).')';
        }
        switch ($_GET['out_type']){
            case 1: 
                $quantity   = 'c.real_quantity';
                $is_out  = ' and b.sale_order_state='.C('SHIPPED').' and c.real_quantity>0';
                break;
            case 2:
            default :
                $quantity   = 'c.quantity';
                $is_out  = '';
                break;
        }
        $sql = 'select count(distinct(b.id)) as count,sum('.$quantity.') as quantity 
                from file_relation_detail a
                left join sale_order b on a.relation_id=b.id
                inner join sale_order_detail c on b.id=c.sale_order_id
                where c.product_id='.$id.$where.$is_out.' and a.file_type='.array_search('PickingImport',C('CFG_FILE_TYPE')).'
                group by c.product_id';
		$count 	= M()->cache()->query($sql);
		$count	= reset($count);
		if (!$count) return ;		
		$p 		= new Page($count['count']);
		$page 	= $p->show();
		// 分页信息
		$limit 	= ' limit '.$p->firstRow . ','.$p->listRows;		
		$sql	= 'select b.id as sale_order_id,sum('.$quantity.') as quantity,b.sale_order_no,b.order_date,d.comp_name as comp_name 
                       from file_relation_detail a
                       left join sale_order b on a.relation_id=b.id
                       inner join sale_order_detail c on b.id=c.sale_order_id
                       left join client d on b.client_id=d.id
                       where c.product_id='.$id.$where.$is_out.' and a.file_type='.array_search('PickingImport',C('CFG_FILE_TYPE')).'
                       group by b.id'.$limit;
		$list = $this->db->query($sql);	
		foreach ($list as &$value) {	
			$value['view_url'] 			= U('/ReturnSaleOrder/view/id/'.$value['m_id']);
			$total['sum_qn']			+= $value['quantity'];
		}	
		$list 							= _formatList($list);
		$list['total']					= array_merge($list['total'],_formatArray($total));
		$list['total']['product_no']	= $list['list'][0]['product_no'];	
		$list['total']['product_name']	= $list['list'][0]['product_name'];	
        
		$list['total']['all_sum_qn']        = moneyFormat($count['quantity'],0,0);
		$list['page']                       = $page;
        return $list;  
    }

        /// 发货明细
	public function getDelivery($id) {
		$sql = "select count(*) as count,sum(quantity) as quantity,sum(money) as money,sum(sum_qn) sum_qn from (
					select sum(quantity*capability*dozen) as quantity,sum(quantity) sum_qn,
					sum(quantity*capability*dozen*price*discount) as money
					from delivery a inner join delivery_detail b on a.id=b.delivery_id 					
					where b.product_id=".$id." 
					group by a.id 
				) as temp group by 1=1";
		$count 	= M()->cache()->query($sql);			
		$count	= reset($count);
		if (!$count) return ;
		$p 		= new Page($count['count']);
		$page 	= $p->show();
		// 分页信息
		$limit 	= ' limit '.$p->firstRow . ','.$p->listRows;		
		$sql	= "select a.*,b.*,c.currency_id,a.id as m_id,sum(quantity*capability*dozen) as quantity,sum(quantity) sum_qn,
					sum(quantity*capability*dozen*price*discount) as money, 
					sum(quantity*capability*dozen*price*discount)/sum(quantity*capability*dozen) as avg_price
					from delivery a inner join delivery_detail b on a.id=b.delivery_id 
					left join sale_order c on  c.id=b.sale_order_id
					where b.product_id=".$id." 
					group by a.id 
					order by a.delivery_no ".$limit;
		$list = $this->db->query($sql);
		foreach ($list as &$value) {
			unset($value['create_time'],$value['update_time']);
			$value['view_url'] 			= U('/Delivery/view/id/'.$value['m_id']);
			$curr_money[$value['currency_id']] += $value['money'];	
			$total['sum_qn']			+= $value['sum_qn'];				
		}	
		$list 							= _formatList($list);
		$list['total']					= array_merge($list['total'],_formatArray($total));
		$list['total']['product_no']	= $list['list'][0]['product_no'];	
		$list['total']['product_name']	= $list['list'][0]['product_name'];	
		// 总合计
		$sql	= " select sum(quantity*capability*dozen*price*discount) as money, currency_id ,sum(quantity) sum_qn
					from delivery a inner join delivery_detail b on a.id=b.delivery_id 
					left join sale_order c on  c.id=b.sale_order_id
					where b.product_id=".$id." 
					group by currency_id ";
		$total	= $this->db->query($sql);	
		$currency	= S('currency');
		foreach ($total as $t_list) {
			$all_money.=$currency[$t_list['currency_id']]['currency_no'].'：'.moneyFormat($t_list['money'], 0, C('MONEY_LENGTH')).'<br>';			
		}
		foreach ($curr_money as $k => $m) {
			$total_money.=$currency[$k]['currency_no'].'：'.moneyFormat($m, 0, C('MONEY_LENGTH')).'<br>';			
		}
		$list['total']['all_sum_qn']	= moneyFormat($count['sum_qn'],0,0);
		$list['total']['all_quantity']  = moneyFormat($count['quantity'], 0, 0);
		$list['total']['all_money']  	= $all_money;
		$list['total']['total_money']  	= $total_money;
		$list['page']					= $page;
		return $list;
	}
	
	/// 退货数量
	public function getReturn($id) {
        if(getUser('role_type')==C('WAREHOUSE_ROLE_TYPE')){
            $relation_warehouse_id   = $this->relationWarehouse();
            $where    = ' and b.warehouse_id in ('.implode(',', $relation_warehouse_id).')';
        }
        //分页合计和数量总合计
        $sql = 'select count(a.id) as count,sum(b.quantity) sum_qn,sum(if(isnull(c.quantity),0,c.quantity)) as sum_storage_qn
            from  return_sale_order a 
            left join  return_sale_order_detail b on a.id=b.return_sale_order_id  
            left join return_sale_order_storage_detail c on a.id=c.return_sale_order_id and b.product_id=c.product_id
            where b.product_id='.$id.$where.
            ' group by b.product_id ';
		$count 	= M()->cache()->query($sql);
		$count	= reset($count);
		if (!$count) {
			return ;
		}
		$p 		= new Page($count['count']);
		$page 	= $p->show();
		// 分页信息
		$limit 	= ' limit '.$p->firstRow . ','.$p->listRows;		
		$sql	= 'select a.id as return_sale_order_id,return_sale_order_no,sum(b.quantity) as quantity,return_order_date,if(isnull(c.quantity),0,c.quantity) as storage_qn
                from  return_sale_order a 
                left join return_sale_order_detail b on a.id=b.return_sale_order_id 
                left join return_sale_order_storage_detail c on a.id=c.return_sale_order_id and b.product_id=c.product_id
                where b.product_id='.$id.$where.
                ' group by a.id  '.$limit;
		$list = $this->db->query($sql);
		foreach ($list as &$value) {	
            $value['no_storage_qn']     = $value['quantity'] - $value['storage_qn'];
			$value['view_url'] 			= U('/ReturnSaleOrder/view/id/'.$value['m_id']);
			$total['sum_qn']			+= $value['quantity'];
			$total['sum_storage_qn']    += $value['storage_qn'];
			$total['sum_no_storage_qn'] += $value['no_storage_qn'];
		}	
		$list 							= _formatList($list);
		$list['total']					= array_merge($list['total'],_formatArray($total));
		$list['total']['product_no']	= $list['list'][0]['product_no'];	
		$list['total']['product_name']	= $list['list'][0]['product_name'];	
        
		$list['total']['all_sum_qn']        = moneyFormat($count['sum_qn'],0,0);
        $list['total']['all_storage_qn']	= moneyFormat($count['sum_storage_qn'],0,0);
        $list['total']['all_no_storage_qn']	= moneyFormat($count['sum_qn']-$count['sum_storage_qn'],0,0);
		$list['page']                       = $page;
		return $list;
	}
    	/// 发货明细
	public function getReturnStorage($id) {
        if(getUser('role_type')==C('WAREHOUSE_ROLE_TYPE')){
            $relation_warehouse_id   = $this->relationWarehouse();
            $where    = ' and a.warehouse_id in ('.implode(',', $relation_warehouse_id).')';
        }
        $is_sold    = $_GET['is_sold'] == C('CAN_RETURN_SOLD') ? ' not in ' : ' in ';
        $warehouse_id   = $this->getNoReturnSold();
        $warehouse_id[] = 0;
//        $sql    = 'select count(a.id) as count,sum(c.quantity) as sum_qn
//                        from return_sale_order as a
//                        left join return_sale_order_detail as b on a.id=b.return_sale_order_id
//                        left join return_sale_order_storage_detail as c on a.id=c.return_sale_order_id
//						where b.product_id='.$id.$where.' and a.warehouse_id '.$is_sold.' ('.  implode(',', $warehouse_id).')
//                    group by b.product_id';
        $sql        = 'select count(distinct(return_sale_order_id)) as count,sum(a.quantity-a.drop_quantity) as sum_qn
                    from return_sale_order_storage_detail as a
                    where (quantity-drop_quantity)>0 and product_id='.$id.$where.' and a.warehouse_id '.$is_sold.' ('.  implode(',', $warehouse_id).')
                    group by product_id';
        $count 	= M()->cache()->query($sql);
		$count	= reset($count);
		if (!$count) {
			return ;
		}
		$p 		= new Page($count['count']);
		$page 	= $p->show();
        // 分页信息
		$limit 	= ' limit '.$p->firstRow . ','.$p->listRows;		
//        $sql    = 'select a.id as return_sale_order_id,return_sale_order_no,sum(c.quantity) as quantity,return_order_date
//                from return_sale_order as a
//                left join return_sale_order_detail as b on a.id=b.return_sale_order_id
//                left join return_sale_order_storage_detail as c on a.id=c.return_sale_order_id
//                where b.product_id='.$id.$where.' and c.warehouse_id '.$is_sold.' ('.  implode(',', $warehouse_id).') and c.quantity>0
//            group by a.id';
        $sql        = "select a.return_sale_order_id as return_sale_order_id,b.return_sale_order_no,sum(a.quantity-a.drop_quantity) as quantity,b.return_order_date
                    from return_sale_order_storage_detail as a
                    left join return_sale_order as b on a.return_sale_order_id = b.id
                    where (quantity-drop_quantity)>0 and product_id=".$id.$where." and a.warehouse_id ".$is_sold." (".  implode(',', $warehouse_id).") and a.quantity>0
                    group by a.return_sale_order_id";
        $list = $this->db->query($sql);
		foreach ($list as &$value) {	
            $value['no_storage_qn']     = $value['quantity'] - $value['storage_qn'];
			$value['view_url'] 			= U('/ReturnSaleOrder/view/id/'.$value['m_id']);
			$total['sum_qn']			+= $value['quantity'];
		}	
		$list 							= _formatList($list);
		$list['total']					= array_merge($list['total'],_formatArray($total));
		$list['total']['product_no']	= $list['list'][0]['product_no'];	
		$list['total']['product_name']	= $list['list'][0]['product_name'];	
        
		$list['total']['all_sum_qn']        = moneyFormat($count['sum_qn'],0,0);
		$list['page']                       = $page;
		return $list;
    }
	
	/// 期初明细
	public function getInit($id) {				
		$sql	= "select *,a.id as m_id,sum(quantity*capability*dozen) as quantity,sum(quantity) sum_qn,
					sum(quantity*capability*dozen*price) as money, 
					sum(quantity*capability*dozen*price)/sum(quantity*capability*dozen) as avg_price
					from  init_storage a inner join  init_storage_detail b on a.id=b.init_storage_id 
					where b.product_id=".$id."
					group by a.id 
					order by a.id ";
		$list = $this->db->query($sql);
		foreach ($list as &$value) {			
			$value['view_url'] 			= U('/InitStorage/view/id/'.$value['m_id']);
			$total['sum_qn']			+= $value['sum_qn'];			
		}	
		$total							= _formatArray($total);
		$list 							= _formatList($list);		
		$list['total']['product_no']	= $list['list'][0]['product_no'];	
		$list['total']['product_name']	= $list['list'][0]['product_name'];	
		$list['total']					= array_merge($list['total'],$total);		
		$list['page']					= '';
		return $list;
	}
	
	/// 调整明细
	public function getAdjust($id) {	
        $warehouse_id  = $this->getNoReturnSold();
        if(getUser('role_type')==C('WAREHOUSE_ROLE_TYPE')){
            $relation_warehouse_id   = $this->relationWarehouse();
            $where_warehouse    = ' and b.warehouse_id in ('.implode(',', $relation_warehouse_id).')';
        }
		if ($_GET['add'] ==1) {
			$where 		=' and b.quantity >0';
		}else {
			$where 		=' and b.quantity <0';
		}
        
		$sql = 'select count(a.id) as count,sum(b.quantity) as sum_qn 
                from adjust a
                left join adjust_detail b on a.id=b.adjust_id
                where b.product_id='.$id.$where.$where_warehouse.' and warehouse_id not in ('.  implode(',', $warehouse_id).')
                group by b.product_id';		
		$count 	= M()->cache()->query($sql);
		$count	= reset($count);			
		if (!$count) {
			$list['total']['title'] = $title;
			return ;
		}
		$p 		= new Page($count['count']);
		$page 	= $p->show();
		// 分页信息
		$limit 	= ' limit '.$p->firstRow . ','.$p->listRows;		
		$sql = 'select a.id as m_id,adjust_no,sum(b.quantity) as quantity,adjust_date 
                from adjust a
                left join adjust_detail b on a.id=b.adjust_id
                where b.product_id='.$id.$where.$where_warehouse.' and warehouse_id not in ('.  implode(',', $warehouse_id).')
                group by a.id';		
		$list = $this->db->query($sql);
		foreach ($list as &$value) {	
            $value['no_storage_qn']     = $value['quantity'] - $value['storage_qn'];
			$value['view_url'] 			= U('Adjust/view/id/'.$value['m_id']);
			$total['sum_qn']			+= $value['quantity'];
		}	
		$list 							= _formatList($list);
		$list['total']					= array_merge($list['total'],_formatArray($total));
		$list['total']['product_no']	= $list['list'][0]['product_no'];	
		$list['total']['product_name']	= $list['list'][0]['product_name'];	
        
		$list['total']['all_sum_qn']        = moneyFormat($count['sum_qn'],0,0);
		$list['page']                       = $page;
		return $list;
	}
	
	/// 移仓明细
	public function getShiftWarehouse($id) {	
        $warehouse_id  = $this->getNoReturnSold();
		if(getUser('role_type')==C('WAREHOUSE_ROLE_TYPE')){
			$out_warehouse_where = 'out_warehouse_id='.getUser('company_id');
		}else{
			$out_warehouse_where = 1;
		}
		if ($_GET['add'] ==1) {
			$where = ' and out_warehouse_id in ('.implode(',',$warehouse_id).') and '.$out_warehouse_where.' and in_warehouse_id  not in ('.  implode(',',$warehouse_id).')' ;
		}else {
			$where = ' and out_warehouse_id not in ('.implode(',',$warehouse_id).') and '.$out_warehouse_where.' and in_warehouse_id in ('.  implode(',',$warehouse_id).')' ;
		}
		$sql = 'select count(a.id) as count,sum(b.quantity) as sum_qn 
                from shift_warehouse a
                left join shift_warehouse_detail b on a.id=b.shift_warehouse_id
                where b.product_id='.$id.$where.'group by b.product_id';		
		$count 	= M()->cache()->query($sql);
		$count	= reset($count);			
		if (!$count) {
			$list['total']['title'] = $title;
			return ;
		}
		$p 		= new Page($count['count']);
		$page 	= $p->show();
		// 分页信息
		$limit 	= ' limit '.$p->firstRow . ','.$p->listRows;		
		$sql = 'select a.id as m_id,shift_warehouse_no,sum(b.quantity) as quantity,shift_warehouse_date AS fmd_shift_warehouse_date 
                from shift_warehouse a
                left join shift_warehouse_detail b on a.id=b.shift_warehouse_id
                where b.product_id='.$id.$where.'group by a.id';		
		$list = $this->db->query($sql);
		foreach ($list as &$value) {	
            $value['no_storage_qn']     = $value['quantity'] - $value['storage_qn'];
			$value['view_url'] 			= U('ShiftWarehouse/view/id/'.$value['m_id']);
			$total['sum_qn']			+= $value['quantity'];
		}	
		$list 							= _formatList($list);
		$list['total']					= array_merge($list['total'],_formatArray($total));
		$list['total']['product_no']	= $list['list'][0]['product_no'];	
		$list['total']['product_name']	= $list['list'][0]['product_name'];	
        
		$list['total']['all_sum_qn']        = moneyFormat($count['sum_qn'],0,0);
		$list['page']                       = $page;
		return $list;
	}
	
	/// 进货单价走势
	public function getPriceForChart($id,$type = 'instock') {
		$from_date 	= date('Y-m-d', mktime(0,0,0,date('m')-2,'01',date('Y')));
		$to_date   	= date('Y-m-d', mktime(0,0,0,date('m'),date('t'),date('Y')));		
		if ($type == 'sale') { // 销售单价
			if (C('FLOW.DELIVERY')) { // 有发货流程
				$sql		= " select *,a.currency_id as in_currency_id,
							sum(if(a.sale_order_state=3, c.quantity*c.capability*c.dozen*c.pieces, b.quantity*b.capability*b.dozen*b.pieces)) as sum_quantity,
							sum(if(a.sale_order_state=3, c.quantity*c.capability*c.dozen*c.pieces*c.price*c.discount, b.quantity*b.capability*b.dozen*b.pieces*b.price*b.discount)) as money							
							from sale_order a inner join sale_order_detail b on a.id=b.sale_order_id
							left join delivery_detail c on b.id=c.sale_order_detail_id
							where order_date>='".$from_date."' and order_date<='".$to_date."'
							and b.product_id=".$id." and (a.sale_order_state=1 or (a.sale_order_state=3 and c.id >0))
							group by a.id";
			} else {	// 无发货流程
				$sql		= " select *,a.currency_id as in_currency_id,
							sum(quantity*capability*dozen*pieces) as sum_quantity,
							sum(quantity*capability*dozen*pieces*price*discount) as money
							from sale_order a inner join sale_order_detail b on a.id=b.sale_order_id
							where order_date>='".$from_date."' and order_date<='".$to_date."'
							and b.product_id=".$id."
							group by a.id";
			}			
		} else {
			$sql		= " select *,b.currency_id as in_currency_id,
							(quantity*capability*dozen*pieces) as sum_quantity,
							(quantity*capability*dozen*pieces*price) as money
						  	from instock a inner join instock_detail b on a.id=b.instock_id
							where real_arrive_date>='".$from_date."' and real_arrive_date<='".$to_date."'
							and b.product_id=".$id;	
		}	
		$rs				= $this->db->query($sql);		
		$date_format 	= C('DIGITAL_FORMAT') == 'eur' ? 'm/Y' : 'Y-m';
		$show_date		= array(0 => date($date_format, mktime(0,0,0,date('m')-2,'01',date('Y'))),
								1 => date($date_format, mktime(0,0,0,date('m')-1,'01',date('Y'))),
								2 => date($date_format, time()));
		foreach ((array)$rs as $list) {				
			$date = date($date_format, $type == 'sale' ? strtotime($list['order_date']) : strtotime($list['real_arrive_date']));
			$new[$list['in_currency_id']][$date]['sum_quantity'] += $list['sum_quantity'];
			$new[$list['in_currency_id']][$date]['sum_price'] 	 += $list['money'];
		}			
		unset($list);		
		foreach ($show_date as $date) { // 日期
			$temp['instock_date'] = $date;
			foreach ((array)$new as $c => $d_list) { // 币种
				$avg_price = 0;
				foreach ($d_list as $d=> $m_list) { // 单价
					if ($d == $date) {
						$avg_price =  money_format($m_list['sum_price']/$m_list['sum_quantity'], C('PRICE_LENGTH'));
					}						
				}
				$temp['currency_id']	= $c;
				$temp['avg_price']		= $avg_price;	
				$list[] = $temp;			
			}			
		}							
		return _formatList($list);		
	}
	/// 调整明细
	public function getOutBatch($id) {	
        $warehouse_id  = $this->getNoReturnSold();
        if(getUser('role_type')==C('WAREHOUSE_ROLE_TYPE')){
            $relation_warehouse_id   = $this->relationWarehouse();
            $where_warehouse    = ' and a.warehouse_id in ('.implode(',', $relation_warehouse_id).')';
        }
		if ((int)$_GET['sold'] ==1) {
			$where 		=' and a.warehouse_id not in ('.  implode(',', $warehouse_id).')';
		}else {
			$where 		=' and a.warehouse_id in ('.  implode(',', $warehouse_id).')';
		}
        
		$sql = 'select count(distinct c.id) as count,sum(a.quantity) as sum_qn 
                from out_batch c
                left join out_batch_detail d on c.id=d.out_batch_id
                left join pack_box_detail b on d.pack_box_id=b.pack_box_id
                left join return_sale_order_storage_detail a on b.return_sale_order_id=a.return_sale_order_id
                where a.product_id='.$id.$where.$where_warehouse.'
                group by a.product_id';		
		$count 	= M()->cache()->query($sql);
		$count	= reset($count);
		if (!$count) {
			$list['total']['title'] = $title;
			return ;
		}
		$p 		= new Page($count['count']);
		$page 	= $p->show();
		// 分页信息
		$limit 	= ' limit '.$p->firstRow . ','.$p->listRows;		
		$sql = 'select c.id as m_id,out_batch_no,sum(a.quantity) as quantity,transport_start_date 
                from out_batch c
                left join out_batch_detail d on c.id=d.out_batch_id
                left join pack_box_detail b on d.pack_box_id=b.pack_box_id
                left join return_sale_order_storage_detail a on b.return_sale_order_id=a.return_sale_order_id
                where a.product_id='.$id.$where.$where_warehouse.'
                group by c.id';
		$list = $this->db->query($sql);
		foreach ($list as &$value) {
			$value['view_url'] 			= U('OutBatch/view/id/'.$value['m_id']);
			$total['sum_qn']			+= $value['quantity'];
		}	
		$list 							= _formatList($list);
		$list['total']					= array_merge($list['total'],_formatArray($total));
		$list['total']['product_no']	= $list['list'][0]['product_no'];	
		$list['total']['product_name']	= $list['list'][0]['product_name'];	
        
		$list['total']['all_sum_qn']        = moneyFormat($count['sum_qn'],0,0);
		$list['page']                       = $page;
		return $list;
	}

    /// 丢弃数量
	public function getDropped($id) {	
        if(getUser('role_type')==C('WAREHOUSE_ROLE_TYPE')){
            $relation_warehouse_id   = $this->relationWarehouse();
            $where_warehouse    = ' and a.warehouse_id in ('.implode(',', $relation_warehouse_id).')';
        }
        $sql    = 'SELECT count(distinct b.id) as count,sum(e.drop_quantity) as sum_qn from return_sale_order b
                    left join return_sale_order_detail a on b.id=a.return_sale_order_id
                    left join return_sale_order_detail_service c on a.id=c.return_sale_order_detail_id
                    left join return_service_detail d on c.service_detail_id=d.id
                    left join return_sale_order_storage_detail e on e.return_sale_order_id = a.return_sale_order_id and a.product_id = e.product_id
                    where a.product_id='.$id.$where_warehouse.' and b.return_sale_order_state='.C('RETURN_SALE_ORDER_STATE_DROPPED').' and d.return_service_id='.C('DOWN_AND_DESTORY').' and e.quantity>0 group by a.product_id';//
		$count 	= M()->cache()->query($sql);
		$count	= reset($count);
		if (!$count) {
			$list['total']['title'] = $title;
			return ;
		}
		$p 		= new Page($count['count']);
		$page 	= $p->show();
		// 分页信息
		$limit 	= ' limit '.$p->firstRow . ','.$p->listRows;		
        $sql    = 'SELECT b.id as m_id,b.return_sale_order_no,sum(e.drop_quantity) as quantity,returned_date from return_sale_order b
                    left join return_sale_order_detail a on b.id=a.return_sale_order_id
                    left join return_sale_order_detail_service c on a.id=c.return_sale_order_detail_id
                    left join return_service_detail d on c.service_detail_id=d.id
                    left join return_sale_order_storage_detail e on e.return_sale_order_id = a.return_sale_order_id and a.product_id = e.product_id
                    where a.product_id='.$id.$where_warehouse.' and b.return_sale_order_state='.C('RETURN_SALE_ORDER_STATE_DROPPED').' and d.return_service_id='.C('DOWN_AND_DESTORY').' and e.quantity>0';

		$list = $this->db->query($sql);
		foreach ($list as &$value) {
			$value['view_url'] 			= U('ReturnSaleOrder/view/id/'.$value['m_id']);
			$total['sum_qn']			+= $value['quantity'];
		}	
		$list 							= _formatList($list);
		$list['total']					= array_merge($list['total'],_formatArray($total));
		$list['total']['product_no']	= $list['list'][0]['product_no'];	
		$list['total']['product_name']	= $list['list'][0]['product_name'];	
        
		$list['total']['all_sum_qn']        = moneyFormat($count['sum_qn'],0,0);
		$list['page']                       = $page;
		return $list;
	}
}