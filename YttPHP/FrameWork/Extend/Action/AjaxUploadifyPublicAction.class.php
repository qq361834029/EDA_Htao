<?php
/**
 * 附件上传信息管理
 * @copyright   2011 展联软件友拓通
 * @category   	附件上传信息管理
 * @package  	Action
 * @version 	2011-03-23
 * @author    	何剑波
 */
class AjaxUploadifyPublicAction extends Action{
	
	public $_name_suffix	= '';
	
	public function __construct() {
		parent::__construct();
		if (isset($_GET['upload_control_name_suffix']) && !empty($_GET['upload_control_name_suffix'])) {//用于同一表单多个上传控件的支持
			$this->_name_suffix	= trim($_GET['upload_control_name_suffix']);
		}		
	}

	// 通过uploadidy上传附件
	public function uploads() {
		if(true === empty($_FILES)) {return ;}
		$file 				= $_FILES['file_upload'];
		$file['savename'] 	= getRands(15);
		$file_parts			= pathinfo($file['name']);
		$file_type 			= $file_parts['extension'];
		$file['type']		= $file_parts['extension'];
		$file_name 			= $file['savename'].'.'.$file_type;
		$cpation_name 		= $file['name'];

		$relation_type 		= $_POST['type' . $this->_name_suffix];
		$relation_id		= intval($_POST['id']);
		$tocken				= $_POST['tocken'];
		$flow_type			= $_POST['flow_type'];
//		$pic_name			= $file['name']; // 用户输入的图片名字
		$return_type		= $_POST['rdata' . $this->_name_suffix]; // 上传成功后返回的数据格式
		import("ORG.Util.UploadFile");
		$upload 			= new UploadFile();
		$upload->thumb 		= true;
		if(!empty($_POST['allowTypes' . $this->_name_suffix])){
			if($flow_type=='TrackOrder'){
				$express	= S('express');
				if($express){
					foreach($express as $k => $v){
						$e_d[$v['express_no']] = $k;
					}
				}
				$cpation_data	= explode('-',$cpation_name);
				if(count($cpation_data)==4&&array_key_exists($cpation_data[2],$e_d)&&$e_d[$cpation_data[2]]==C('EXPRESS_DHL_ID')){
					$upload->allowTypes = array('txt');//DHL
				}else{
					$upload->allowTypes = array('csv');//GLS
				}
			}else{
				$upload->allowTypes=$this->setAllowTypes($_POST['allowTypes' . $this->_name_suffix]);
			}
		}
		if (!$upload->uploadOne($file,getUploadPath($relation_type))) {
			$info['id']	= -1;
			$info['error']=$upload ->getErrorMsg();  
		    echo json_encode($info);                 
		} else {			
            $data = array(
					'file_url'		=> $file_name,
					'relation_id'	=> $relation_id,
					'relation_type'	=> $relation_type,
					'cpation_name'	=> $cpation_name,
					'tocken'		=> $tocken,
					'add_user'	    => getUser('id'),
					'insert_date'   => date('Y-m-d'),
                    'upload_date'   => date("Y-m-d H:i:s"),
//					'file_name'		=> $pic_name
			);                
			if($_GET['limit_number'] == 1){			//限制单张图片上传
				$galleryMap['tocken'] = $_POST['tocken'];
				$galleryMap['relation_type'] = $relation_type;
				$id = M('Gallery')->where($galleryMap)->getField('id');
				if(!empty($id)){
					$data['id'] = $id;
					M('Gallery')->save($data);
				}else{
					$id = M('Gallery')->add($data);
				}
			}else{
				$id = M('Gallery')->add($data);
			}

            $file_dir   = C('UPLOAD_DIR');
            if ($return_type=='json') {
				$array = array('id'=>$id,
								'file'			=> $file_dir[$relation_type].$file_name,
								'cpation_name'  => $cpation_name,
								'size'		    => round($file['size']/1024,2),
								'relation_type' => $relation_type,
								'file_url'		=> $file['savename'],
								'file_name'		=> $file_parts['filename'],
								'extension'		=> $file_type
				);
				if($relation_type==11){
					$array['url']   = U("TrackOrder/index");
					$array['title'] = L("trackNoList");
				}
				echo json_encode($array);
			}else {
				echo $id;
			}
		    
		}
	}
	
	/**
	 * 设置上传文件允许的类型
	 *
	 * @param string $info
	 * @return array
	 */
	public function setAllowTypes($info){
		$allowTypes	= @explode(',',$info);
		return $allowTypes;	
	}
	
	// 删除附件
	public function deletes(){
		$id = intval($_REQUEST['id']);
		if (empty($id)) return false;
		$rs = M('Gallery')->find($id);
		$path	= getUploadPath($rs['relation_type']);
		@unlink($path . $rs['file_url']);
		@unlink($path . 'small_'.$rs['file_url']);
		M('Gallery')->delete($id);
	}
	
	//通过名字删除图片
	public function deletesName(){ 
		$model	=	M('Gallery');
		$name = trim($_REQUEST['name']);
		if (empty($name)) return false;
		$rs = $model->where('tocken!="" and cpation_name=\''.$name.'\'')->find();
		$path	= getUploadPath($rs['relation_type']);
		@unlink($path . $rs['file_url']);
		@unlink($path . 'small_'.$rs['file_url']);
		$model->delete($rs['id']); 
	}
	
	
	// 通过uploadidy上传附件直接保存不入库
	public function upload() {
		if(true === empty($_FILES)) {return ;}
		$file 				= $_FILES['Filedata'];
		$file['savename'] 	= $_POST['fname'];
		$file_parts			= pathinfo($file['name']);
		$file_type 			= $file_parts['extension'];
		$file_name 			= $file['savename'].'.'.$file_type;
		$tocken				= $_POST['tocken'];
		$relation_type 		= $_POST['type' . $this->_name_suffix];
		import("ORG.Util.UploadFile");
		$upload 		= new UploadFile();
		$upload->uploadReplace 	= true;
		if (!$upload->uploadOne($file,getUploadPath($relation_type))) {   
		    echo $upload ->getErrorMsg();                  
		} else {
			echo $file['savename'];
		}
	}
}?>