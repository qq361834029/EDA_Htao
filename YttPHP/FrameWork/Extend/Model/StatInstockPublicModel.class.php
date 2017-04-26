<?php
/**
 * 入库查询统计列表	
 * @copyright   2012 展联软件友拓通
 * @category   	入库查询统计列表
 * @package  	Model 
 * @author 		何剑波
 * @version  	2.1
 */
class StatInstockPublicModel extends RelationCommonModel{

	/// 定义真实表名
	protected $tableName = 'instock';
	/// 定义表关联
	protected $_link	 = array('detail' => 
									array(
										'mapping_type'	=> HAS_MANY,
										'foreign_key' 	=> 'instock_id',
										'class_name'	=> 'InstockDetail',
									)
								);	
	/**
	 * 入库查询统计
	 *
	 * @return  array
	 */
	function indexSql(){ 
		return $this->getStocktakeListSql(); 
	}
	
	/**
	 * 查看入库查询统计明细
	 *
	 */
	function view(){
		return $this->getInfo();
	}
	
	/**
	 * 获取明细
	 * @return array
	 */
	private function getInfo(){
		$count 	= $this->exists('select 1 from instock_detail where instock_id=instock.id and '.getWhere($_POST['detail']))->where(getWhere($_POST['main']))->count();
		$this->setPage($count);
		$ids	= $this->field('id')->exists('select 1 from instock_detail where instock_id=instock.id and '.getWhere($_POST['detail']))->where(getWhere($_POST['main']))->order('instock_no desc')->page()->selectIds();
		$sql	=	' 
					select a.instock_no,a.real_arrive_date,a.id as main_id,sum(quantity*capability*dozen) as quantity,b.factory_id,b.product_id
					from instock a, instock_detail b   force index(PRI)
		 			where  quantity>0 and a.id=b.instock_id and '._search_array(_getSpecialUrl($_GET)).' and a.id in '.$ids.'
		 			group by  a.id
					order by a.instock_no asc';  
		$rs['detail']		= $this->db->query($sql); 
		if (false === $rs || $rs == null) { // 记录不存在或没权限查看该记录
			halt(L('data_right_error'));
		} 
		$rs = _formatListRelation($rs);
		return $rs;
	}
	
	
	/**
	 * 入库查询统计列表
	 *
	 * @return array
	 */
	private function getStocktakeListSql(){ 
		$info['from'] 	= 'instock a, instock_detail b FORCE INDEX(PRIMARY)';
		$info['extend'] = 'where '._search(_search_array(_getSpecialUrl($_GET))).' and product_id>0 and quantity>0 and a.id=b.instock_id group by factory_id,product_id 
						  order by factory_id asc,product_id';
		$info['field'] 	= 'a.id,factory_id,product_id,sum(quantity*capability*dozen) as quantity';
		$sql_count		= 'select count(distinct factory_id,product_id) as count '.' from '.$info['from'].' where a.id=b.instock_id and product_id>0 and '._search(_search_array(_getSpecialUrl($_GET))); 
		$list			= $this->cache()->query($sql_count);
		$this->setPage($list[0]['count']);
		return 'select '.$info['field'].' from '.$info['from'].' '.$info['extend']._limit(_page($list[0]['count']));
	}
	
	/**
	 * 计算总合计
	 * @return array
	 */
	public function getListTotal(){
		$sql	= 'select sum(quantity*capability*dozen) as quantity 
				   from instock a, instock_detail b  force index(PRI)
				   where '._search(_search_array(_getSpecialUrl($_GET))).' and quantity>0 and product_id>0 and a.id=b.instock_id 
				   order by factory_id asc,product_id asc';
		$total	= $this->cache()->query($sql);
		return _formatList($total);
	}
	
}