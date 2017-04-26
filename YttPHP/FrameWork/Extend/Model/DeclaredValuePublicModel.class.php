<?php

/**
 *
 * @category   	批量修改申报价值
 * @package  	Model
 * @author    	YYH
 * @version 	20141106
*/

class DeclaredValuePublicModel extends RelationCommonModel {
	/// 定义真实表名
	protected $tableName = 'declared_value';
	/// 定义索引字段
	public $id;
	/// 定义表关联
	protected $_link	 = array('detail' => 
									array(
										'mapping_type'	=> HAS_MANY,
										'foreign_key' 	=> 'declared_value_id',
										'class_name'	=> 'declared_value_detail',
									)
								);	
	/// 自动验证设置
	protected $_validate	 =	 array(
			array("",'_validDetail','require',1,'validDetail'),
			array('','validQuantity','',1,'callbacks'), 
		);
	/// 验证表单明细
	protected $_validDetail	 =	 array(
			array("product_id",'require','require',1),
			array("product_id","validProductId",'require',1,'callbacks'),
            array("declared_value","require",'require',1),
		);
		
	/// 自动填充
	protected $_auto = array(
							array("create_time", "date", 1, "function", "Y-m-d H:i:s"), // 创建时间	
							array("update_time", "date", 2, "function", "Y-m-d H:i:s"), // 更新时间					
						);
	
	public function validProductId(){
		$data['detail'] = is_array($this->Mdate)&&$this->Mdate ? $this->Mdate['detail'] : array();
        $product_id = array();
		foreach($data['detail'] as $key => $val){
			$product	= SOnly('product', $val['product_id']);
			if ($val['product_id'] && empty($product)) {
				$error['name']	= 'detail['.$key.'][product_id]';
				$error['value']	= L('product_not_exist');
				$this->error[]  = $error;
			}
            if (!empty($val['product_id'])) {
                if (in_array($val['product_id'], $product_id)) {
                    $error['name'] = 'detail[' . $key . '][product_id]';
                    $error['value'] = L('unique');
                    $this->error[] = $error;
                } else {
                    $product_id[] = $val['product_id'];
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
		return $this->getInfo($this->id);
	}
	
	/**
	 * 编辑调整明细
	 *
	 * @return  array
	 */
	public function edit(){
		return $this->getInfo($this->id);
	}
	
	/**
	 * 获取明细信息(用于查看/编辑)
	 *
	 * @param int $id
	 * @return array
	 */
	public  function getInfo($id) {		
		$rs			  = $this->find($id);
		if (data_permission_validation($rs) === false) {
			throw_json(L('data_right_error'));
			exit;
		}
		$rs['detail'] = M('DeclaredValueDetail')->field('b.*,c.product_no')->join('as b left join product as c on b.product_id=c.id')->where('declared_value_id='.$id)->select();
		return _formatListRelation($rs);
	}
	 
	/**
	 * 所有订单列表SQL
	 *
	 * @return  array
	 */
	function indexSql(){
        $count  = M('declared_value_detail')->join('as b left join product as c on b.product_id=c.id left join declared_value as a on a.id=b.declared_value_id ')->where(getWhere($_POST['detail']).' and a.factory_id='.  getUser('company_id'))->count();
        M('declared_value_detail')->setPage($count);
        $ids            = M('declared_value_detail')->field('b.id')->join('as b left join product as c on b.product_id=c.id left join declared_value as a on a.id=b.declared_value_id ')->where(getWhere($_POST['detail']).' and a.factory_id='.  getUser('company_id'))->order('id desc')->page()->selectIds();
        $info['from'] 	= 'declared_value a 
						   LEFT JOIN declared_value_detail b ON a.id = b.declared_value_id
						   LEFT JOIN product c		 ON b.product_id=c.id
                           LEFT JOIN user as u ON a.add_user=u.id';
		$info['group'] 	= ' group by b.id order by b.id desc';
		$info['where'] 	= ' where b.id in'.$ids.' and a.factory_id='.  getUser('company_id');
		$info['field'] 	= 'b.id AS id,
						   b.declared_value_id,
						   b.product_id AS product_id,
                           b.declared_value as declared_value,
                           a.create_time as create_time,
						   count(distinct b.product_id) as product_counts,
						   c.product_no AS product_no,
                           u.real_name as real_name';
		return  'select '.$info['field'].' from '.$info['from'].$info['where'].$info['group'];
	}
	
}