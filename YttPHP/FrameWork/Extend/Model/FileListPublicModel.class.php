<?php

/**
 * 文件列表类
 * @copyright   Copyright (c) 2006 - 2013 TOP UNION 展联软件友拓通
 * @category    基本信息
 * @package		Model
 * @author     jph
 * @version  2.1,2014-03-27
 */

class FileListPublicModel extends RelationCommonModel {
	
	public $_file_type;// 1 入库导入，2 拣货导出，3 拣货导入	
	
	/// 定义真实表名
	public $tableName = 'file_list';
	
	public $import_key = '';
		
	///关联插入	 
	public $_link = array(
							'detail' => array(
										'mapping_type'	=> HAS_MANY,												
										'class_name'	=> 'file_detail',
										'foreign_key'	=> 'file_id', 
                                        'after_insert'  => 'detailAfterInsert',//明细新增后续操作
						  				),
							'relation_detail' => array(
										'mapping_type'	=> HAS_MANY,												
										'class_name'	=> 'file_relation_detail',
										'foreign_key'	=> 'object_id', 
						  				)			
						);	
	
	/// 自动验证设置
	protected $_validate	 =	 array(
			array("file_upload",'file_name','import_file_not_exist',1, 'ifcheck','',''),
			array("warehouse_id",'require','require',1),	
		);	
	
	/// 自动填充
	protected $_auto	 = array(
								array("file_list_date", "date", 1, "function", "Y-m-d H:i:s"), // 导入时间	
								array("create_time", "date", 1, "function", "Y-m-d H:i:s"), // 创建时间	
								array("update_time", "date", 2, "function", "Y-m-d H:i:s"), // 更新时间					
							);	
	
	public function __construct($name = '', $tablePrefix = '', $connection = '') {
		parent::__construct($name, $tablePrefix, $connection);
		$this->import_key				= !empty($this->import_key) ? $this->import_key : MODULE_NAME;
		$this->_file_type		= array_search($this->import_key,C('CFG_FILE_TYPE'));
	}

	public function setPost() {
		$info	= parent::setPost();
		$info['file_type']	= $this->_file_type;
		return $info;
	}
	
	/**
	 * 前置操作
	 *
	 * @param array $info
	 * @return array
	 */
	public function _beforeModel(&$info){ 
		if (ACTION_NAME == 'insert') {
			if (MODULE_NAME == 'InstockImport') { 
                $rs = S($_POST['s_key']);
            }else{
                $rs = D('Excel')->readExcel($info['import_key'], $info['import_key'], $info['file_name'], $info['sheet']);
            }
			if ($rs['type'] != 3) {//导入数据出错				
				$this->error		= $rs['msg'];
				$this->errorStatus	= 0;
				return false; 				
			}
			$this->setInsertInfo($info);
			$result	= $this->setInsertDetail($rs['detail']);
			if ($result !== true) {
				$this->error		= $result;
				$this->errorStatus	= 0;
				return false;
			}
			$_POST['detail']		= $rs['detail'];
			if (in_array($this->_module, array('PickingImport'))){//新拣货导入验证实际库存
				$_POST['_module']	= $this->_module;
				$_POST['_action']	= $this->_action;
				B('CheckStorage', array_merge($_GET,$_POST),true);
			}		
			$this->data['detail']	= $rs['detail'];
			unset($rs);
		}
		return true;
	} 	
	
	public function setInsertInfo(&$info){
	}
	
	
	public function setInsertDetail(&$detail){
        return true;
	}	


	///列表
	public function indexSql(){  
		$where = getWhere($_POST) . ' and file_type=' . $this->_file_type;
		$count 	= $this->where($where)->count();
		$this->setPage($count);
		$ids	= $this->field('id')->where($where)->order('file_list_no desc')->page()->selectIds();
		$info['from'] 	= 'file_list';
		$info['order'] 	= ' order by file_list_no desc';
		$info['where'] 	= ' where id in'.$ids;
		$info['field'] 	= "*";
		return	'select '.$info['field'].' from '.$info['from'].$info['where'].$info['order'];
	}
	
	/**
	 * 列表
	 *
	 * @param string $action_name
	 * @return array
	 */
	public function index($action_name){ 
		$action_name	= $action_name?$action_name:ACTION_NAME;
		$sql			= $action_name.'Sql';  
		$_sql			= $this->$sql(); 
		$_formatListKey	= ACTION_NAME.'_'.MODULE_NAME.'_'.__CLASS__.'_'.__FUNCTION__; 
		$rs				= _formatList($this->query($_sql),$_formatListKey, 1, 'id');//注：以id为键名不可改，PickingImportPublicAction有需要用到
		$path	= getUploadPath(10);
		if ($rs['list']) {
			$this->setIndexList($rs['list']);
			foreach ($rs['list'] as &$v) {
				$v['file_url']	= $path . MODULE_NAME . '/' . $v['file_name'] . ( in_array(MODULE_NAME, array('Picking')) ? '.csv' : '.xls').'?'.time();
			}
		}
		return $rs;
	}	
	
	function setIndexList(&$list) {
		return $list;
	}
	
	
	///异常导入列表
	public function abnormalListSql(){  
		$_POST['main']['query']['file_type']	= $this->_file_type;
		$where = getWhere($_POST['main']);
		if (empty($_POST['search_form'])) {
			$_POST['detail']['query']['state']	= C('CFG_IMPORT_FAILED_STATE');//默认只显示待处理
		}
		$_POST['detail']['greaterthan']['state']	= C('CFG_IMPORT_SUCCESS_STATE');//大于
		$detail_where	= getWhere($_POST['detail']);
		$exists_sql	= 'select 1 from file_list where id=file_detail.file_id and '.$where;
		$count 	= $this->table('file_detail')->exists($exists_sql,$_POST['main'])->where($detail_where)->count();
		$this->setPage($count);
		$ids	= $this->table('file_detail')->field('id')->exists($exists_sql,$_POST['main'])->where($detail_where)->order('id desc')->page()->selectIds();
		$info['from'] 	= 'file_list a left join file_detail b on(a.id=b.file_id)';
		$info['order'] 	= ' order by a.file_list_no desc';
		$info['where'] 	= ' where b.id in'.$ids;
		$info['field'] 	= 'a.file_list_no, a.warehouse_id,b.*,b.edit_user as add_user, b.state as import_state';
		return	'select '.$info['field'].' from '.$info['from'].$info['where'].$info['order'];		
	}	
	
	
	/// 编辑
	public function edit(){
		return $this->getInfoFileDetail($this->id);
	}	
	
	public function getInfoFileDetail($id){
		$rs = M('FileDetail')->field('a.file_list_no,a.file_type,a.file_list_date,a.warehouse_id,a.file_name,b.*')->join('b left join file_list a on a.id=b.file_id')->where('b.id=' . $id)->find();
		if ($rs['box_id'] > 0) {
			switch ($this->import_key) {
				case 'InstockImport'://入库导入异常处理
					$rs['box_no'] = M('InstockBox')->where("id='" . $rs['box_id'] . "'")->getField('box_no');
					break;			
				default:
					break;
			}
		}
		$info	= _formatArray($rs);
		return $info;
	}	
	
	
	public function getInfo(){
		$rs = $this->getMainInfo(false);  
		if (false === $rs || $rs == null) { // 记录不存在或没权限查看该记录
			halt(L('data_right_error'));
		}		
		$this->getRelation($rs);
		$info	= _formatListRelation($rs);	
		return $info;
	}	
	
	///获取待装柜明细
	public function getMainInfo($format	= true){
		$rs = $this->find($this->id);
		if ($rs) {
			$model	=	D('Gallery'); 
			$rs['pics'] = $model->getAry($this->id,2);	
		}
		return $format ? _formatArray($rs) : $rs;
	}	
	
	public function updateErrorProductInfo($id){
		if ($id <= 0) {
			return false;
		}
		$rs	= M('FileDetail')->field('count(DISTINCT product_id) as product_count,sum(quantity) as quantity,count(DISTINCT if(state=' . C('CFG_IMPORT_FAILED_STATE') . ',product_id,null)) as product_error_count,sum(if(state=' . C('CFG_IMPORT_FAILED_STATE') . ',quantity,0)) as error_quantity')->where('file_id=' . (int)$id)->find();
		M()->execute('update file_list set ' . getStrFromArr($rs,',',array('`',null,'`=')) . ' where id=' . (int)$id);
		return $rs;
	}
	
	
	public function updateErrorProductInfoByDetailId($id){
		$file_id	= M('FileDetail')->where('id=' . (int)$id)->getField('file_id');
		return $this->updateErrorProductInfo($file_id);;
	}	
}