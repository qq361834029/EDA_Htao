<?php

/**
 * 买家信息管理
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category    基本信息
 * @package   Model
 * @author     jph
 * @version  2.1,2012-07-22
 */

class ClientPublicModel extends CommonModel {
	
	/// 模型名与数据表名不一致，需要指定
	protected $tableName = 'client';
	
	/// 自动验证设置
	protected $_validate	 =	 array(
		array("detail_type",'require',"require",0),
		array("comp_name",'require',"require",1),
		//array('comp_type',array(1,4),'comp_type_error',2,'between'),	
		array("factory_id",'require','require',0),
		array("consignee",'require','require',1),
		//array("address2",'require','require',1),
		array("country_id",'require','require',1),
		array("country_name",'require','require',1),
		array('email','email','valid_email',2),	//邮箱格式
//		array("",'validImport','',1,'callbacks'),
		array("",'validExtra','require',1,'callbacks'),
	);

	public function validImport($data){
		if (!in_array($data['from_type'], array('import', 'apiimport', 'cainiao'))) {
			$vasd = array(array("comp_no",'require',"require",1),
							array("comp_no",'is_no',"valid_error",1),  
							array("comp_no",'',"unique",1,'unique',3)//验证唯一
			);
		}
		return $this->_validSubmit($data,$vasd);
	}

    public function validExtra($data){
		if ($data['from_type'] != 'cainiao') {
			$vasd = array(
						array("post_code",'require','require',1),
						array("address",'require','require',1),
						array("city_name",'require','require',1),
                        array("city_name",'not_number','valid_city',2),
					);
		}
		return $this->_validSubmit($data,$vasd);
    }

	public function view(){
		return $this->getInfo($this->id);
	}

	public function edit(){
		return $this->getInfo($this->id);
	}

	public function getInfo($id){
		$where						= 'id=' . (int)$id . getBelongsWhere();
		$rs							= $this->where($where)->find();  
		$rs['full_country_name']	= SOnly('country',$rs['country_id'],'full_country_name');
		$rs['abbr_district_name']	= SOnly('country',$rs['country_id'],'abbr_district_name');
		return $rs;
	}

	public function externalSaveClient($data){
		$data['comp_no'] = $comp_no	= getModuleMaxNo('Client');
		$rs = $this->create($data);
		if (false===$rs) {    
			return false;
		}
		//保存成功
		$client_id = $this->add();
		if ($client_id!==false) {
			return $client_id;  
		} else {  
			return false;
		} 
	}
		
}