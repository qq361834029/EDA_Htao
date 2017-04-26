<?php
/**
 * 产品管理
 * @copyright   Copyright (c) 2006 - 2013 TOP UNION 展联软件友拓通
 * @category   	基本信息
 * @package  	Model
 * @author    	jph
 * @version 	2.1,2014-01-17
 */

class ProductPublicModel extends RelationCommonModel {
	/// 模型名与数据表名不一致，需要指定
	protected $tableName = 'product';
	/// 自动验证设置
	protected $_validate	 =	 array(
			array("product_no",'require','require',1),
			array("product_no,factory_id",'','unique',1,'unique'),
            array("product_no",'checkSku','keyword_filter',1,'callback'),
			array("product_name",'require','require',1),
			array("factory_id",'pst_integer','require',self::EXISTS_VAILIDATE),
			array("cube_long",'money',"double",2),
			array("cube_wide",'money',"double",2),
			array("cube_high",'money',"double",2),
			array("weight",'money',"double",2),
			array("warning_quantity",'z_integer',"z_integer",2),
			array("check_long",'money',"double",2),
			array("check_wide",'money',"double",2),
			array("check_high",'money',"double",2),
			array("check_weight",'money',"double",2),
            array('custom_barcode','','unique',self::EXISTS_VAILIDATE,'unique'),
            array('','validCustomBarcode','',1,'callbacks'),
		);
    public function validCustomBarcode($data){
        if(array_key_exists('custom_barcode',$data)){
			$factory_id = intval($data['factory_id']);
			if(!empty($data['factory_id'])){
				$custom_barcode  = isCustomBarcode($factory_id);
			}
            if($custom_barcode['is_custom_barcode'] == 1){
                if(preg_match('/^EDA[0-9]+$/', $data['custom_barcode'])){
					$error['name']	= 'custom_barcode';
                    $error['value']	= L('custom_barcode_no_eda');
					$this->error[]	= $error;
                }elseif(!preg_match('/^[0-9a-zA-Z_-]{6,19}$/', $data['custom_barcode'])){
                    $error['name']	= 'custom_barcode';
                    $error['value']	= L('custom_barcode_limit');
                    $this->error[]	= $error;
            	}
			}
    	}
    }
	
	protected function checkSku($data){
		foreach (explode(' ', $data) as $data_val) {
			$data_val	= trim($data_val);
			if ($data_val) {
				foreach ((array)S('sku_keywords') as $sku_val) {
					if ( strtolower($data_val) ==  strtolower($sku_val['sku_no'])) {
						return false;
					}
				}
			}
		}
		return true;
    }

        ///关联插入
	public $_link = array('product_detail' => array(
						  						'mapping_type'	=> HAS_MANY,
												'class_name'	=> 'product_detail',
												'foreign_key'	=> 'product_id',
						  				),
							'product_sku' => array(
						  						'mapping_type'	=> HAS_MANY,
												'class_name'	=> 'product_sku',
												'foreign_key'	=> 'product_id',
						  				),
							'product_extend' => array(
						  						'mapping_type'	=> HAS_ONE,
												'class_name'	=> 'ProductExtend',
												'foreign_key'	=> 'product_id',
						  				),
						);


	/**
	 * 整理POST数组 多选框值以字符串入库
	 *
	 * @param array $data
	 * @return array
	 */
	public function setPost($data) {
		if (empty($data))	$data	=	$_POST;
		$_validate	= array();
		if ($data['check_status'] == C('CHECK_STATUS_PASS')){
			$_validate[]	= array("check_long",'require',"require", self::MUST_VALIDATE);
			$_validate[]	= array("check_wide",'require',"require", self::MUST_VALIDATE);
			$_validate[]	= array("check_high",'require',"require", self::MUST_VALIDATE);
			$_validate[]	= array("check_weight",'require',"require", self::MUST_VALIDATE);
		}
		if (!in_array($data['from_type'], array( 'cainiao'))) {//API也必须验证'apiimport',
			$_validate[]	= array("cube_long",'require',"require", self::MUST_VALIDATE);
			$_validate[]	= array("cube_wide",'require',"require", self::MUST_VALIDATE);
			$_validate[]	= array("cube_high",'require',"require", self::MUST_VALIDATE);
			$_validate[]	= array("weight",'require',"require", self::MUST_VALIDATE);
		}
		$this->_validate	= array_merge($this->_validate, $_validate);
		foreach ($data['product_detail'] as &$value) {
			if (is_array($value['value'])) {
				$value['value'] = @implode(',',$value['value']);
			} elseif (!isset ($value['value'])){
				$value['value']	= '';
			}
		}
		foreach ($data['product_sku'] as $key => &$value) {
			if($value!=''){
				$data['sku'][$key]['sku']			= $value;
				$data['sku'][$key]['factory_id']	= $data['factory_id'];
			}
		}
		if(is_array($data['sku'])){
			$data['product_sku'] = $data['sku'];
		}else{
            unset($data['product_sku']);
		}
		if($this->_action == 'update'){
			D('ProductSku')->where('product_id='.$data['id'])->delete();
		}
		$data['product_no']	= trim($data['product_no']);
		return $data;
	}

	/**
	 * 取产品列表
	 */
	public function getIndexList(){
		if (isset($_REQUEST['_sort'])) {
			$order	= $_REQUEST['_sort']!=1?' ' . $_REQUEST['_order'] . ' desc':' ' . $_REQUEST['_order'];
		} else {
			$order	= ' id desc';
		}
		if($_POST['pics']==1) {
			$gallery_exists	= 'select 1 from gallery where relation_id=a.id and relation_type=1';
		}
		$count 	= $this->alias(' as a ')->exists($gallery_exists,$_POST['pics'])->where(getWhere($_POST['main']).$where)->count();
		$this->setPage($count);
		$ids	= $this->alias(' as a ')->field('id')->exists($gallery_exists,$_POST['pics'])->where(getWhere($_POST['main']).$where)->order($order)->page()->selectIds();
		$info['from'] 	= 'product a
						   left join product_detail b on(a.id=b.product_id and b.properties_id=2)
						   left join gallery c on(a.id=c.relation_id and c.relation_type=1)';
		$info['group'] 	= ' group by a.id order by '.$order;
		$info['where'] 	= ' where a.id in'.$ids.$where;
		$info['field'] 	= 'a.*,b.value as hs_code,cube_high*cube_wide*cube_long as cube,check_high*check_wide*check_long as check_cube';
		$sql =  'select '.$info['field'].' from '.$info['from'].$info['where'].$info['group'];
		$return_info = $this->query($sql);
        foreach($return_info as &$value){
			$cube					= $value['check_status'] == C('CHECK_STATUS_WAIT_CHECK') ? $value['cube'] : $value['check_cube'];
            $value['volume_weight']	= volume_weight_calculate(false, $cube, true);
        }
		$rs	= _formatList($return_info, $this->_default_format);
		_formatWeightCubeList($rs['list']);
		return $rs;
	}

	/**
	 * 取产品明细
	 *
	 * @param  $id 产品ID
	 * @param  string $type操作类型,edit修改，view查看，查看时需编译属性值
	 * @return array $rs
	 */
	public function getInfo($id,$type='edit') {
		$where				= 'id=' . (int)$id . getBelongsWhere();
		$main				= M('Product')->field('*,cube_high*cube_wide*cube_long as cube,check_high*check_wide*check_long as check_cube')->where($where)->find();
		if (false === $main || $main == null) { /// 记录不存在或没权限查看该记录
			halt(L('data_right_error'));
		}
        $rs					= $main;/// 取主表信息
        if($rs[check_status]==0){
            $rs['volume_weight']=volume_weight_calculate(false,$rs['cube_long']*$rs['cube_wide']*$rs['cube_high'],true);          
        }  else {
            $rs['volume_weight']=volume_weight_calculate(false,$rs['check_long']*$rs['check_wide']*$rs['check_high'],true);           
        } 
        $rs=_formatArray($rs);
		$properties			= $this->getProperties($id);

		!empty($properties) && $rs['detail'] = $properties;
		if ($type=='edit') {
			$rs['factory_readonly'] = false;
			if ($rs['factory_readonly']==false){
				$count = M('Storage')->where('product_id='.$id)->count();
				if ($count>0) {
					$rs['factory_readonly'] = true;
				}
			}
		}      
		_formatWeightCube($rs);
		$model		=	D('Gallery');
		$rs['pics'] = $model->getAry($id,1);
		$rs['product_sku'] = M('ProductSku')->where('product_id='.$id)->getField('sku',true);
		$rs['edml_weight'] =  str_replace('.00','',$rs['edml_weight']);
		$rs['s_unit_weight'] =  str_replace('.00','',$rs['s_unit_weight']);
		$rs['edml_check_weight'] =  str_replace('.00','',$rs['edml_check_weight']);
		$rs['s_unit_check_weight'] =  str_replace('.00','',$rs['s_unit_check_weight']);              
        $rs['s_unit_volume_weight'] =  str_replace('.00','',$rs['s_unit_volume_weight']);
		return $rs;
	}

	/**
	 * 获取汇率currency_from='EUR' and currency_to='RMB'
	 *
	 * @return double
	 */
	public function getRate(){
		$rate = M('RateInfo')->where("currency_from='EUR' and currency_to='RMB' and rate_date='".date('Y-m-d')."'")->getField('opened_y');
		return $rate;
	}

	/**
	 * 获取权限
	 *
	 * @return unknown
	 */
	public function getRole(){
		return ;
		$role = UserAction::getAuthInfo();
		$company_id = M('User')->where('id='.$role['user_id'])->getField('company_id');
		if ($role['user_type']==2) {
			$country = M('Company')->where('id='.$company_id)->find();
			$id = M('District')->where("district_name='中国' and parent_id=0")->getField('id');
			if ($country['country_id']==$id && $country['detail_type']) {
				if ($country['detail_type']==1) {
					return 1;
				}elseif ($country['detail_type']==2){
					return 2;
				}else return 3;
			}elseif ($country['country_id']==$id || $country['detail_type']){
				if ($country['country_id']==$id) {
					return 4;
				}elseif ($country['detail_type']==1) {
					return 5;
				}elseif ($country['detail_type']==2){
					return 6;
				}else return 7;
			}
		}else{ ///(IS_ADMIN || SUPER_ADMIN)
			return 8;
		}
	}

	/**
	 * 根据产品ID取产品属性信息
	 *
	 * @param int $product_id
	 * @return array
	 */
	public function getProperties($product_id) {
		$detail				= M('ProductDetail')->where('product_id='.$product_id)->formatFindAll(array('key'=>'properties_id'));/// 取明细信息
		/// 取在用的产品属性信息
		$role_type_where	= (IS_ADMIN || SUPER_ADMIN || (ROLE_TYPE ==1)) ? " " : " and role_type in (1,".ROLE_TYPE.")";
		$properties			= M('Properties')->field('id as properties_id,properties_no,properties_name,properties_name_de,properties_type')->where('to_hide=1'.$role_type_where)->formatFindAll(array('key'=>'properties_id'));
		$pv_name			= 'pv_name' . (LANG_SET=='de' ? '_de' : '') . ' as pv_name';
		$_cache_proper		= M('PropertiesValue')->field('id,' . $pv_name)->formatFindAll(array('key'=>'id'));

		foreach ($properties as $id => &$var) {
			$var['product_id'] 	= $detail[$id]['product_id'];
			$var['value'] 		= $detail[$id]['value'];
			switch ($var['properties_type']) {
				case 1:/// 自定义输入
					$var['properties_value'] = $var['value'];
				break;
				case 2:/// 单选框
					$var['properties_value'] = $_cache_proper[$var['value']]['pv_name'];
				break;
				case 3:/// 多选框
					$temp = @explode(',',$var['value']);
					foreach ((array)$temp as $properties_value_id) {
						$v_ary[] = $_cache_proper[$properties_value_id]['pv_name'];
					}
					$var['properties_value'] = implode('，',$v_ary);
				break;
				case 4:/// 多行文本框
					$var['properties_value'] = specDeConvertStr($var['value']);
				break;
			}
		}
		return $properties;
	}

	/**
	 * api新增/修改产品update
	 * @author jph 20150706
	 * @return array
	 */
	public function import(){
		if ($this->_action == 'update') {
			$id = $this->relation(true)->save();
		} else {
            static $product_no      = array();
            static $custom_barcode  = array();
            $is_custom_barcode  = M('company_factory')->where('factory_id='.$this->data['factory_id'])->getField('is_custom_barcode');
			if(in_array($this->data['product_no'], $product_no)){
				$error[]    = L('product_no').':'.L('unique');
			}
			if((in_array($this->data['custom_barcode'], $custom_barcode) && $is_custom_barcode==1)){
				$error[]    = L('custom_barcode').':'.L('unique');
			}
			if ($error) {
                $this->error_type	= 1;
                $this->addError($error);
                return false;
			}
            $product_no[$this->data['product_no']]		= $this->data['product_no'];
			$custom_barcode[$this->data['custom_barcode']]  = $this->data['custom_barcode'];
            $id = $this->relation(true)->add();
		}
		if (false === $id) {
			$this->error_type	=	2;
			return false;
		}
		$_POST['id']	= $id;
		$this->_afterModel($_POST);
		$this->execTags($_POST);
		A('Product')->checkCacheDd($id);
		$this->id	=	$id;
		return $this->id;
	}
}