<?php 
/**
 * 产品类别
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category   	基本信息
 * @package  	Model
 * @author    	何剑波
 * @version 	2.1,2012-07-22
 */

class ProductClassViewPublicModel extends ViewModel {
	/// 模型名与数据表名不一致，需要指定
	protected $tableName = 'product_class';
  
	/// 默认模型
	public $viewFields = array('a'=>array('id'=>'id','class_name'=>'class_name','parent_id'=>'parent_id','class_no'=>'class_no','class_level'=>'class_level','to_hide'=>'a_to_hide','to_hide'=>'to_hide','_as' =>'a','_table'=>'product_class'));

	/// 定义视图模型 二级类别
	public  $viewFields2 = array(
		'a' => array('id'=>'id','class_name'=>'class_name','class_no'=>'class_no','class_level'=>'class_level','to_hide'=>'a_to_hide','to_hide'=>'to_hide','_as' =>'a','_type'=>'LEFT','_table'=>'product_class','_main'=>1),
		'b' => array('_as' => 'b','_table'=>'product_class','_on'=>'a.id = b.parent_id')
	);
	
	/// 定义视图模型 三级类别
	public  $viewFields3 = array(
		'a' => array('id'=>'id','class_name'=>'class_name','class_no'=>'class_no','class_level'=>'class_level','to_hide'=>'a_to_hide','to_hide'=>'to_hide','_as' =>'a','_type'=>'LEFT','_table'=>'product_class','_main'=>1),
		'b' => array('_as' => 'b','_type'=>'LEFT','_table'=>'product_class','_on'=>'a.id = b.parent_id'),
		'c' => array('_as' => 'c','_table'=>'product_class','_on'=>'b.id = c.parent_id')
	);
	
	/// 定义视图模型 四级类别
	public  $viewFields4 = array(
		'a' => array('id'=>'id','class_name'=>'class_name','class_no'=>'class_no','class_level'=>'class_level','to_hide'=>'a_to_hide','to_hide'=>'to_hide','_as' =>'a','_type'=>'LEFT','_table'=>'product_class','_main'=>1),
		'b' => array('_as' => 'b','_type'=>'LEFT','_table'=>'product_class','_on'=>'a.id = b.parent_id'),
		'c' => array('_as' => 'c','_type'=>'LEFT','_table'=>'product_class','_on'=>'b.id = c.parent_id'),
		'd' => array('_as' => 'd','_table'=>'product_class','_on'=>'c.id = d.parent_id'),
	);
	
	/// 展开二级明细
	public  $expend2 = array(
		'b' => array('id'=>'id','class_name'=>'class_name','class_no'=>'class_no','class_level'=>'class_level','to_hide'=>'to_hide','_as' =>'b','_type'=>'LEFT','_table'=>'product_class','_main'=>1),
		'c' => array('_as' => 'c','_type'=>'LEFT','_table'=>'product_class','_on'=>'b.id = c.parent_id'),
		'd' => array('_as' => 'd','_table'=>'product_class','_on'=>'c.id = d.parent_id'),
	);
	
	/// 展开三级明细
	public  $expend3 = array(
		'c' => array('id'=>'id','class_name'=>'class_name','class_no'=>'class_no','class_level'=>'class_level','to_hide'=>'to_hide','_as' =>'c','_type'=>'LEFT','_table'=>'product_class','_main'=>1),
		'd' => array('_as' => 'd','_type'=>'LEFT','_table'=>'product_class','_on'=>'c.id = d.parent_id'),
	);
	
	/// 展开三级明细
	public  $expend4 = array(
		'd' => array('id'=>'id','class_name'=>'class_name','class_no'=>'class_no','to_hide'=>'to_hide','_as' =>'d','_table'=>'product_class')
	);

	/// AUTOCOMPLETE使用的模型
	public  $autocomplete = array(
		'a' => array('id'=>'a_id','class_name'=>'a_class_name','_as' =>'a','_type'=>'LEFT','_table'=>'product_class','_main'=>1),
		'b' => array('id'=>'b_id','class_name'=>'b_class_name','a.class_name'=>'b_before_field','_as' => 'b','_type'=>'LEFT','_table'=>'product_class','_on'=>'a.id = b.parent_id and b.to_hide=1 and b.class_level=2'),
		'c' => array('id'=>'c_id','class_name'=>'c_class_name','concat_ws(\'->\',a.class_name,b.class_name)'=>'c_before_field','_as' => 'c','_type'=>'LEFT','_table'=>'product_class','_on'=>'b.id = c.parent_id and c.to_hide=1 and c.class_level=3'),
		'd' => array('id'=>'d_id','class_name'=>'d_class_name','concat_ws(\'->\',a.class_name,b.class_name,c.class_name)'=>'d_before_field','_as' => 'd','_table'=>'product_class','_on'=>'c.id = d.parent_id and d.to_hide=1 and d.class_level=4'),
	);	
		
	/**
	 * 获取类别列表
	 * 
	 * @return array
	 */
	public function getIndex(){
		if (C('PRODUCT_CLASS_LEVEL')==1) {
			$this->viewFields = $this->viewFields;
		}elseif (C('PRODUCT_CLASS_LEVEL')==2) {
			$this->viewFields = $this->viewFields2;
		}elseif (C('PRODUCT_CLASS_LEVEL')==3) {
			$this->viewFields = $this->viewFields3;
		}elseif (C('PRODUCT_CLASS_LEVEL')==4) {
			$this->viewFields = $this->viewFields4;
		} 
		return $opert	= array('where'=>_search('a.class_level=1 and '.$this->getClassWhere()),'sortBy'=>'a.class_no','group'=>'a.id');
		 
	}
	
	/**
	 * 获取to_hide字段搜索条件
	 * 
	 * @return string
	 */
	private function getClassWhere(){
		$level	 = C('PRODUCT_CLASS_LEVEL');
		$to_hide = intval($_POST['stohide']);
		if ($to_hide==-2) { return 1; }
		if ($level==1) {
			$where .= '(a.to_hide='.$to_hide.')';
		}elseif ($level==2) {
			$where .= '(a.to_hide='.$to_hide.' or b.to_hide='.$to_hide.')';
		}elseif ($level==3) {
			$where .= '(a.to_hide='.$to_hide.' or b.to_hide='.$to_hide.' or c.to_hide='.$to_hide.')';
		}elseif ($level==4) {
			$where .= '(a.to_hide='.$to_hide.' or b.to_hide='.$to_hide.' or c.to_hide='.$to_hide.' or d.to_hide='.$to_hide.')';
		}
		return $where;
	}
	
	
	/**
	 * 获取展开明细列表数据
	 * 
	 * @param int $class_id
	 * @param int $class_level
	 * @return array
	 */
	public function getExpandProductClassList($id,$class_level){
		$class_level = intval($class_level+1);
		$to_hide = intval($_POST['stohide']);
		if ($class_level==2) {
			$this->viewFields 		= $this->expend2;
			$where 					= 'b.parent_id='.$id;
			$to_hide>0 && $where   .= ' and (b.to_hide='.$to_hide.' or c.to_hide='.$to_hide.' or d.to_hide='.$to_hide.')'; 
			$group					= 'b.id';
			$sort					= 'b.class_no';
		}elseif ($class_level==3) {
			$this->viewFields 		= $this->expend3;
			$where 					= 'c.parent_id='.$id;
			$to_hide>0 && $where   .= ' and (c.to_hide='.$to_hide.' or d.to_hide='.$to_hide.')'; 
			$group					= 'c.id';
			$sort					= 'c.class_no';
		}elseif ($class_level==4) {
			$this->viewFields 		= $this->expend4;
			$where 					= 'd.parent_id='.$id;
			$to_hide>0 && $where   .= ' and d.to_hide='.$to_hide; 
			$group					= 'd.id';
			$sort					= 'd.class_no';
		}
		$model	= M('ProductClass');
		$opert	= array('where'=>_search($where),'sortBy'=>$sort,'group'=>$group);
		$where	= 'parent_id='.$id;
		$list	= $model->where($where)->group('id')->select(); 
		$list 	= _formatList($list);
		return $list;
	} 	
} 