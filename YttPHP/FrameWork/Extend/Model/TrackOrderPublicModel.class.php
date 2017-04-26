<?php 

class TrackOrderPublicModel extends RelationCommonModel {
	/// 定义真实表名
	protected $tableName = 'gallery';
	public $indexCountPk = 'id'; 
	/// 定义表关联
	protected $_link	 = array('detail' =>
									array(
										'mapping_type'	=> HAS_MANY,
										'foreign_key' 	=> 'gallery_id',
										'class_name'	=> 'GalleryRelation',
									),
								);
	/**
	 * 所有追踪订单列表
	 *
	 * @return  array
	 */
	function index(){  
		$sql		 = ACTION_NAME.'Sql';
		$_sql		 = $this->$sql();
		if (!empty($_sql['count'])){
			$_limit	 = _page($_sql['count']);	
		}
		$list		 = $this->indexList($_limit,$_sql['sql']);
		if (ACTION_NAME == 'exportSaleOrderList' && $list['list']) {
			$gallery_id	= array();
			foreach ($list['list'] as $value){
				$gallery_id[]	= $value['id'];
			}
			$complex_where['s.sale_order_state']	= array('neq', C('SALE_ORDER_STATE_EXPORTING'));
			if(getUser('role_type')==C('WAREHOUSE_ROLE_TYPE')){
				$complex_where['_complex']	= array(
					's.sale_order_state'	=> array('eq', C('SALE_ORDER_STATE_EXPORTING')),
					's.warehouse_id'		=> array('neq', getUser('company_id')),
				);
				$complex_where['_logic']	= 'or';
			}
			$where		= array(
				'gallery_id'	=> array('in', $gallery_id),
				'_complex'		=> $complex_where,
			);
			$join		= 'INNER JOIN __SALE_ORDER__ s on s.id=r.relation_id';
			$not_del	= M('GalleryRelation')->alias('r')->join($join)->where($where)->group('gallery_id')->getField('gallery_id', true);
			if ($not_del) {
				foreach ($list['list'] as $key=>$value){
					if(in_array($value['id'], $not_del)){
						$list['list'][$key]['is_del']  = 0;
					}
				}
			}
		}
		return $list;
	}
	
	/**
	 * 组合追踪订单列表的SQL语句
	 *
	 * @param string $where
	 * @return array
	 */
	public function indexSql($whereArray=null){ 
        $info['field']	= 'id,file_url,relation_id,relation_type,cpation_name,insert_date,upload_date,add_user,is_first';
		$info['from']   = $this->tableName;
        $info['extend']	= ' WHERE  '._search().' and relation_type=11 order by id desc';
		$sql            = 'select '.$info['field'].' from '.$info['from'].' '.$info['extend']; 
		$count			=	0;
		$sql_count		= 'select count('.$this->indexCountPk.') as count '.' from '.$info['from'].' WHERE  '._search().' and relation_type=11';
		$list			= $this->query($sql_count);
		$count			= $list[0]['count'];
		$info['sql']	= $sql;
		$info['count']	= $count; 
		return $info;
	}
    public function exportSaleOrderListSql($whereArray=null){ 
        $info['field']	= 'id,file_url,relation_id,relation_type,cpation_name,insert_date,upload_date,add_user,is_first,comments';
		$info['from']   = $this->tableName;
        $info['extend']	= ' WHERE  '._search().' and relation_type='.C('TRACK_ORDER_RELATION_TYPE').' order by id desc';
		$sql            = 'select '.$info['field'].' from '.$info['from'].' '.$info['extend']; 
		$count			=	0;
		$sql_count		= 'select count('.$this->indexCountPk.') as count '.' from '.$info['from'].' WHERE  '._search().' and relation_type='.C('TRACK_ORDER_RELATION_TYPE').'';
		$list			= $this->query($sql_count);
		$count			= $list[0]['count'];
		$info['sql']	= $sql;
		$info['count']	= $count; 
		return $info;
	}

	/**
	 * 删除订货信息
	 *
	 * @param int $id
	 * @param string $module
	 */
	public  function relationDelete($id,$module=null) {
		$this->_brf();
		$this->id		= $id;
		$where			= array(
			'gallery_id'			=> $id,
			's.sale_order_state'	=> C('SALE_ORDER_STATE_EXPORTING'),
		);
		$sale_order_id  = M('GalleryRelation')->alias('r')->join('INNER JOIN __SALE_ORDER__ s on s.id=r.relation_id')->where($where)->getField('s.id', true);
		if(!empty($sale_order_id)){
			D('SaleOrder')->updateSaleOrderStateById($sale_order_id, C('SALE_ORDER_STATE_PENDING'), L('delete_exprot_order'));
		}
		//$relation = array('detail');
		// 删除操作
		$info = array('id'=>$id);
		$this->_beforeModel($info);

		$r = $this->relation(true)->delete($id);
		if (false === $r) {
			halt($this->getError());
		}

		$info['id']	=	$this->id;
		$module && $info['method_name'] = $module;
		$this->_afterModel($info,'delete');
		$this->execTags($info);
	}
}