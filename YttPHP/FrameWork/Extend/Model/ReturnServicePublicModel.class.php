<?php

class ReturnServicePublicModel extends RelationCommonModel {
	
	/// 定义真实表名
	protected $tableName = 'return_service';
	
	/// 定义表关联
	protected $_link	 = array('detail' => 
									array(
										'mapping_type'	=> HAS_MANY,
										'foreign_key' 	=> 'return_service_id',
										'class_name'	=> 'return_service_detail',
									)
								);	
	/// 自动验证设置
	protected $_validate	 =	 array(
			array("return_service_no",'require','require',1),
			array("return_service_no",'is_no',"valid_error",1), 
			array("return_service_no",'','unique',1,'unique'),
			array("return_service_name",'require','require',1),
			array("",'_validDetail','require',1,'validDetail'),
		);
		
	/// 验证表单明细
	protected $_validDetail	 =	 array(
			array("item_number",'require','require',1),
			array("item_number",'is_no',"valid_error",1), 
			array("item_name",'require','require',1),
	);		
		
	/// 自动填充
	protected $_auto = array(
		array("create_time", "date", 1, "function", "Y-m-d H:i:s"),
		array("update_time", "date", 2, "function", "Y-m-d H:i:s"),					
	);	
	
	public function setPost(){ 
		$info			    =	$_POST;
		$return_service		=	array();
		$check				=	array('item_number','item_name');
		foreach ((array)$info['detail'] as $key=>$value){ //循环验证明细  
			if ($value['item_number']){ 
				$real_key	=	'';	
				foreach ((array)$check as $k => $v){ //循环验证明细  
					if (isset($value[$v])){
						$real_key  .=	'_'.strtolower($value[$v]);
					} 
				} 
				if (isset($return_service[$real_key])){
					$error['name']	= 'detail[' . $key . '][item_number]';
					$error['value']	= L('unique');
					$this->error[]	= $error;				
					continue;
				}
				$return_service[$real_key] = 2;
			}
		}   		
		return $_POST;
	}


	/// 查看
	public function view(){
		return $this->getInfo($this->id);
	}
	
	/// 编辑
	public function edit(){
		return $this->getInfo($this->id);
	}
	
	/// 取信息
	public function getInfo($id){
		$rs		= $this->find($id);  
		$sql	=	'select * from return_service_detail where return_service_id='.$id;  
		if (false === $rs || $rs == null) { // 记录不存在或没权限查看该记录
			halt(L('data_right_error'));
		} 
		$rs['detail']		= $this->db->query($sql);
		$data				= _formatListRelation($rs);
		$data['is_update']	= getUser('role_type')==C('SELLER_ROLE_TYPE') ? 0:1;
		return $data;
	}
		 
	/**
	 * 所有派送方式列表SQL
	 *
	 * @return  array
	 */
	public function indexSql(){  
		$count 	= $this->exists('select 1 from return_service_detail where return_service_id=return_service.id and '.getWhere($_POST['detail']),$_POST['detail'])->where(getWhere($_POST['main']))->count();
		$this->setPage($count);
		$ids	= $this->field('id')->exists('select 1 from return_service_detail where return_service_id=return_service.id and '.getWhere($_POST['detail']),$_POST['detail'])->where(getWhere($_POST['main']))->order('return_service_no asc')->page()->selectIds();
		
		$info['from'] 	= ' return_service a left join return_service_detail b on(a.id=b.return_service_id) ';
		$info['group'] 	= ' group by a.id order by return_service_no asc';
		$info['where'] 	= ' where a.id in'.$ids;
		$info['field'] 	= ' a.id,a.return_service_no,a.return_service_name,a.comments';
		return  'select '.$info['field'].' from '.$info['from'].$info['where'].$info['group']; 
	}
}