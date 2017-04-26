<?php
/**
 * 信息公布栏
 * @copyright   Copyright (c) 2006 - 2013 Top Union 展联软件友拓通
 * @category    信息列表
 * @package		Action
 * @author		lml
 * @version    2016-01-12
 */

class MessagePublicAction extends RelationCommonAction {
	public function __construct() {
    	parent::__construct();
		$this->assign('sid',session_id());
		$this->assign('file_tocken',md5(time()));
	}

	public function _initialize() {
		parent::_initialize();
        if(!$_SESSION[C('ADMIN_AUTH_KEY')]){
            $this->assign('is_admin',false);
        }else{
            $this->assign('is_admin',true);
        }
	}
 
	public function update() {
		$this->id	=	intval($_POST['id']);
		if ($this->id > 0) {
			$model		= $this->getModel();
			if(!empty($_POST['user_type'])){
				$_POST['user_type']=implode(',', $_POST['user_type']);
		    }else{
				$this->error(L('type_missing'));
			}
			if($_POST['submit_type']==5){
				$_POST['is_announced']=C('HAVE_ANNOUNCED');
			}
			if ($model->relationUpdate()===false){
				if ($model->error_type==1){
					$this->error ( $model->getError(),$model->errorStatus);
				}else{
					$this->error (L('_ERROR_'));
				}
			}
		} else {
			$this->error(L('_ERROR_ACTION_'));
		}
	}


	/// 新增
	public function insert($type='') {		 
		///获取当前Action名称
		$name = $this->getActionName();
 		///获取当前模型
		$model 	= D($name);
		///重新组合POST来的信息
		$info	= $model->setPost($_POST);		 
		if(!empty($info['user_type'])){
			$info['user_type']=implode(',', $info['user_type']);
		}else{
			 $this->error(L('type_missing'));
		}
		if($info['submit_type']==5){
			$info['is_announced'] = C('HAVE_ANNOUNCED');
		}
		///模型验证		
		if ($model->create($info)) {
			$id = $model->relation(true)->add();
			if (false === $id) {
				$this->error (L('_ADD_FAILED'));
			}
			$this->checkCacheDd($id);
			$this->id	=	$id;
			$model->addMessageStateLog($this->id);
			if (!empty($_POST['file_tocken'])) {
				D('Gallery')->update($this->id, $_POST['file_tocken']);
			}
		} else {
			if ($model->error_type==1){
				$this->error ( $model->getError(),$model->errorStatus);
			}else{
				$this->error (L('_ERROR_'));
			}
		}
	}
    
    ///查看列表
	public function index($mark) {
		if ($_REQUEST) {
			///获取当前Action名称
			$name = $this->getActionName();
			///获取当前模型
			$model 	= D($name);
			///格式化+获取列表信息
			$list	=	$model->getIndex();
			foreach($list['list'] as &$val){
				if(empty($val['user_type']) || $val['user_type']== NULL){
					$val['dd_user_type']=L('all');
				}
                $val['is_del']  = $val['is_update']   = $val['is_announced']==2 ? 1 : 0;
			}
			unset($val);
			$this->assign('list',$list);
		}
		$this->displayIndex();
	}
	

}