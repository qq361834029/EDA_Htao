<?php 

/**
 * 发货入库
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category   	发货入库
 * @package  	Action
 * @author    	yyh
 * @version 	20141119
*/

class InstockStoragePublicAction extends RelationCommonAction {
	
	public function __construct() { 
    	parent::__construct(); 
        $userInfo	=	getUser();
        if(isset($_GET['id'])){
            $w_id   = M('instock')->where('id='.$_GET['id'])->getField('warehouse_id');
        }
        $this->assign('w_id',$w_id);
        $this->assign('sid',session_id());
		$this->assign('file_tocken',md5(time()));
	}
	public function _autoIndex($temp_file=null) { 
		$this->action_name = ACTION_NAME;
    	$model 			   = $this->getModel();
		$list			   = _formatArray($model->index());
    	$this->list		   = $list;
		$this->displayIndex($temp_file);
	}
    public function add(){
		$id	=	intval($_GET['id']);	 
		if ($id> 0) {
            $model =$this->getModel();
            $model->setId($id);
            $rs = $model->getInfoInstock($id);
            foreach($rs['product'] as &$val){
                $val['instock_detail_id']   = $val['id'];
                unset($val['id']);
            }
            $this->rs = $rs;
        } else {
			$this->error(L('_ERROR_ACTION_'));
        }
    }
    public function _after_add() {
        if (!empty($this->rs['product'])) {
            $temp_file = empty($this->_Member) ? ACTION_NAME : $this->_Member . ACTION_NAME;
            $this->display($temp_file);
        }else{
            $this->redirect("Instock/index");
        }
    }
}
?>