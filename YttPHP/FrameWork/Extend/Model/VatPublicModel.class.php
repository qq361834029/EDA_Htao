<?php

/**
 * VAT信息管理
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category    基本信息
 * @package   Model
 * @author     jph
 * @version  2.1,2012-07-22
 */

class VatPublicModel extends CommonModel {
	
	/// 模型名与数据表名不一致，需要指定
	protected $tableName = 'vat';
	
	/// 自动验证设置
	protected $_validate	 =	 array(
		array("factory_id",'pst_integer','require',1),
		array("country_id",'pst_integer','require',1),
		array("vat_no",'require','require',1),
		array("confirm_status",'require','require',0),
	);

	/// 自动填充
	protected $_auto = array(
		array("create_time", "date", 1, "function", "Y-m-d H:i:s"), // 创建时间
		array("update_time", "date", 2, "function", "Y-m-d H:i:s"), // 更新时间
	);

	public function view(){
		return $this->getInfo($this->id);
	}

	public function edit(){
		return $this->getInfo($this->id);
	}

	public function getInfo($id){
		$rs		= $this->where('id='.(int)$id)->find();
		if (false === $rs || $rs == null) { /// 记录不存在或没权限查看该记录
			halt(L('data_right_error'));
		}
		$rs['full_country_name']	= SOnly('country',$rs['country_id'],'full_country_name');
		$model		=	D('Gallery');
		$file_url = $model->getAry($id,C('VAT_FILE'));
		$path	= getUploadPath(C('VAT_FILE'));
		foreach($file_url as &$val){
            $val['file_url']      = $path . $val['file_url'];
        }
		$rs['vat_file']	= $file_url;
		return $rs;
	}

	/**
	 * VAT 仓库VAT限额
	 * @param int $w_id
	 */
	function warehouseDebtVat($factory_id,$w_id){
		$w_where .= (!empty($w_id))?' and warehouse_id in('.implode(',',$w_id).')':'';
		$client_vat	= M('Vat')->where('confirm_status=3'.' and factory_id='.$factory_id)->formatFindAll(array('key'=>'country_id'));//是否有VAT
		$warehouse_debt	= M('client_paid_detail')->field('warehouse_id,comp_id as factory_id,sum(round(should_paid, 2)*income_type*-1) AS total_should_paid')
			->where('is_close=0 and income_type=-1 and comp_id='.$factory_id.$w_where)->group('warehouse_id')->formatFindAll(array('key'=>'warehouse_id'));
		if(empty($warehouse_debt)){
			return ;
		}else if(!empty($w_id)){
			$w_ids	= $w_id;
		}else{
			foreach($warehouse_debt as $v){
				if(empty($w_id[$v['warehouse_id']])){
					$w_ids[$v['warehouse_id']]	= $v['warehouse_id'];
				}
			}
		}
		$vat_quota	= M('District')->join('d left join warehouse w on d.id=w.country_id')
			->field('d.id as country_id,w.id as w_id,w.w_name,no_vat_quota,no_vat_warning,has_other_vat_quota,has_other_vat_warning')
			->where('w.country_id>0 and w.id in('.implode(',', $w_ids).')')->select();//仓库国家是否限额
		foreach ($vat_quota as $v){
			$check_name	= ($client_vat && count($client_vat)>0)?'has_other_vat_':'no_vat_';
			$check_name	.= (empty($w_id))?'warning':'quota';
			$check_value= intval($v[$check_name]);
			if(empty($check_value) || isset($client_vat[$v['country_id']])){
				continue;
			}
			if(!isset($client_vat[$v['country_id']]) && $warehouse_debt[$v['w_id']]['total_should_paid']>=$check_value){
				$result[] = '[' . L('warehouse') . ']'.$v['w_name'];
			}
		}
		if(empty($result)){
			return ;
		}else{
			$str = empty($w_id)?L('no_vat_warning_error'):L('no_vat_quota_error');
			$factory_name	= (getUser('role_type')==C('SELLER_ROLE_TYPE'))?L('You'):  SOnly('factory', $factory_id,'factory_name');
			return sprintf(L('vat_error'), $factory_name, implode('、', $result), $str);
			
		}
	}
}