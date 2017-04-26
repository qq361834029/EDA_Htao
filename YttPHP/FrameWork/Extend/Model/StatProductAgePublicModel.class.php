<?php
/**
 * 产品库龄	
 * @copyright   2012 展联软件友拓通
 * @category   	基本信息
 * @package  	Model 
 * @author 		何剑波
 * @version 	2.1
 */
class StatProductAgePublicModel extends RelationCommonModel{

	/// 定义真实表名
	protected $tableName = 'stock_in';
	///定义表关联
/*	protected $_link	 = array('detail' => 
									array(
										'mapping_type'	=> HAS_MANY,
										'foreign_key' 	=> 'instock_id',
										'class_name'	=> 'InstockDetail',
									)
								);	*/
	/// 自动验证设置
	protected $_validate	 =	 array(
			array("",'validSearch','require',1,'callbacks'), 	
	);
	/// 验证明细
	public $searchValid	=		array( 
		array("product_id",'require',"require",1,'id'=>'query[product_id]'),
		array("lt_in_date",'require',"require",1,'id'=>'date[lt_in_date]'),
		array("a",'require',"require",1,'id'=>'age[a]'),
		array("a",'pst_integer',"pst_integer",2,'id'=>'age[a]'),
		array("b","a","err_day",2,'gt','id'=>'age[b]'),	
		array("b",'pst_integer',"pst_integer",2,'id'=>'age[b]'),
		array("c","b","err_day",2,'gt','id'=>'age[c]'),	
		array("c",'pst_integer',"pst_integer",2,'id'=>'age[c]'),
		array("d","c","err_day",2,'gt','id'=>'age[d]'),
		array("d",'pst_integer',"pst_integer",2,'id'=>'age[d]'),
	);	
	
	
	/**
	 * 列表搜索验证
	 *
	 * @param array $data
	 * @return bool
	 */
	public function validSearch($data){   
		$name	=	'searchValid';
		foreach ((array)$data as $k=>$v){
			foreach ((array)$v as $kk=>$vv){
				$list[$kk]	= $vv;
			}
		}
		return $this->_validSubmit($list,$name);     
	}

	/**
	 * 列表
	 * @return array
	 */
	public function index(){
		//重新组合POST来的信息 
		$info	= $this->setPost();
		//模型验证 
		if ($this->autoValidation($info)) {	 
			$age			= $this->getAge();
			$age && $source = $this->getProduct($age);
			return $source;
		} else {     
			$this->error_type	=	1;
			return false; 
		} 
	}

	/// 获取库龄
	public function getAge(){
		$age = array();
		foreach ($_POST['age'] as $key => $value) {
			if(!empty($value)) {
				$age[$key] = $value;
				$last_age = $value;
			}
		}
		$last_age && $age['last'] = $last_age;
		return $age;
	}

	/**
	 * 获取产品库龄
	 *
	 * @param array $age
	 * @return array
	 */
	private function getProduct($age){
		$title['product_no']	= L('product_no');
		$title['product_name']	= L('product_name');
		$last_age 				= $age['last'];
		$title['last_age']		= L('lt').$last_age.L('day');
		unset($age['last']);
		$prev_age = 0;
		foreach ((array)$age as $index => $tit_age) {
			if ($index=='a') {
				$title['age_'.$index] = '1-'.$tit_age.L('day');
			}else {
				$title['age_'.$index] = ($prev_age+1).'-'.$tit_age.L('day');
			}
			$prev_age = $tit_age;
		}
		$end_date 		= $_POST['date']['lt_in_date'];
		$sql_count		= 'select count(distinct(product_id)) as count from stock_in where  '._search().' and balance>0'; 
		$list			= $this->query($sql_count);
		if($list[0]['count']>0){
			$_limit			= _page($list[0]['count']);
			$sql_limit		= 'select product_id from stock_in where '._search().' and balance>0 group by product_id limit '.$_limit['firstRow'].','.$_limit['listRows'];
			$temp_limit		= $this->db->query($sql_limit);
			foreach ((array)$temp_limit as $k=>$v){
				$ids[]	= $v['product_id'];
			}
			$where		= '';
			if($ids){
				$where	= ' and product_id in('.@implode(',',$ids).')';
			}
			$sql 			= 'select *,datediff(\''.formatDate($end_date).'\',date(in_date)) as age from stock_in where '._search().' and balance>0'.$where;
			$temp 			= $this->db->query($sql);
			$list 			= array();
			foreach ($temp as &$value) {
				$list[$value['product_id']]['product_id'] = $value['product_id'];
				foreach ($age as $key => $sdfsdf) {
					if ($value['age'] <= $sdfsdf) {
						$list[$value['product_id']]['age_'.$key] += $value['balance']*$value['capability']*$value['dozen'];
						$value['balance'] = 0;
					}else {
						$list[$value['product_id']]['age_'.$key] += 0;
					}
				}
				$list[$value['product_id']]['last_age'] += $value['balance']*$value['capability']*$value['dozen']*$value['pieces'];
			}
			$list = _formatList($list);
			$list['title'] = $title;
			$list['list']  = list_sort_by($list['list'],'product_no');
		}
		return $list;
	}
}