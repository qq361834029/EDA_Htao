<?php 
/**
 * 拣货单导入管理
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category   	拣货
 * @package  	Action
 * @author    	jph
 * @version 	2.1,2014-04-15
 */

class PickingPublicAction extends FileListPublicAction {
	
	/**
	 * 重新生成导出文件
	 * (拣货导出时，如果产品sku缓存读取不正常导出文件数据会出错，本函数供更新缓存后重新生成导出文件)
	 * 
	 */
	public function regenerateFile(){
		$id	= (int)$_GET['id'];
		if ($id <= 0) {
			$result	= null;
		} else {
			$result	= $this->generateFile($id);
		}
		switch (true) {
			case is_null($result):
				$this->error (L('_ERROR_ACTION_'));
				break;
			case $result:
				$this->success (L('_OPERATION_SUCCESS_'),1);
				break;
			default :
				$this->error (L('_OPERATION_FAIL_'));
				break;
		}
	}
	
	/**
	 * 生成拣货导出文件
	 * @param int $id
	 * @return array|boolean|null
	 */
	public function generateFile($id){
		if ($id <= 0) {
			return null;
		}
		$file_list_no	= M('FileList')->where(array('id'=>$id, 'file_type' => array_search('Picking',C('CFG_FILE_TYPE'))))->getField('file_list_no');
		if ($file_list_no) {
            //更新主表文件名
            D('Picking')->where('id='.$id)->setField('file_name', $file_list_no);            
			//保存excel
			$file_name		= $file_list_no.'.csv';
			$detail			= _formatList(M('FileDetail')->alias('fd')->field('fd.*,l.path_sort,l.layer_no,l.col_no,l.box_no')->join('__LOCATION__ l on fd.location_id=l.id')->where(array('file_id' => $id))->order('path_sort,layer_no,col_no,box_no')->select(), null, 0);
			$info			= $detail['list'];
			$rowNum			= 0;
			foreach ($info as &$row) {
				$row['no']	= ++$rowNum;
			}
			$need_array		= array('barcode_no', 'custom_barcode', 'product_no', 'quantity'/*, 'no'*/);
			$tran_array		= array();
			$relation_type	= 15;
			$path			= getUploadPath($relation_type).$file_name;
			$head			= array('Location', 'P_ID', 'SKU', 'Plan Q'/*, 'No.'*/);
			if (tranCsv($info,$need_array,$tran_array,$path,$head)){
                $where = array(
                    'relation_id'	=> $id,
                    'relation_type'	=> $relation_type,
                );
                $count  = M('Gallery')->where($where)->count();
                //记录相册
                if($count<=0){
                    $data = array(
                                'file_url'		=> $file_list_no,
                                'relation_id'	=> $id,
                                'relation_type'	=> $relation_type,
                                'cpation_name'	=> $file_name,
                                'tocken'		=> '',
                                'add_user'	    => getUser('id'),
                                'insert_date'   => date('Y-m-d'),
                    );
                    M('Gallery')->add($data);	
                }
                return true;
			} else {
				return false;
			}
		} else {
			return null;
		}
	}
        
	public function _after_insert(){ 
            $this->generateFile($this->id);    
            parent::_after_insert();
	}        
}
