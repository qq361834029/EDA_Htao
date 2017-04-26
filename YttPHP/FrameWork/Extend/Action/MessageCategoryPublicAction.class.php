<?php
/**
 * 信息公布栏
 * @copyright   Copyright (c) 2006 - 2013 Top Union 展联软件友拓通
 * @category    信息类型列表
 * @package		Action
 * @author		lml
 * @version    2016-01-12
 */

class MessageCategoryPublicAction extends BasicCommonAction {
	protected $_cacheDd 	=  array('6');
	public $_asc 			=  true;  	//默认排序
	public $_sortBy 		=  'category_no';  //默认排序字段
	public $_default_post	=  array('query'=>array('to_hide'=>1));  //默认post值处理
	//自动编号
	public $_setauto_cache	= 'setauto_category_no';//编号对应超管配置中的值
	public $_auto_no_name	= 'category_no';		 //编号no
    
//	public function _autoIndex($temp_file=null) {
//		$this->action_name = ACTION_NAME;
//    	$model 			   = $this->getModel();
//		$list			   = $model->index();
//        $message_category         = S('');
//    	$this->list		   = $list;
//		$this->displayIndex($temp_file);
//	}

		///删除
	public function delete(){
	  ///还原特殊处理 mingxing
	  if ($_GET['restore']==1){
		  $this->restore();
	  }else{
			///获取当前Action名称
			$name = $this->getActionName();
			///获取当前模型
			$model 	= D($name);
			///当前主键
			$pk		=	$model->getPk ();
			$id 	= 	intval($_REQUEST[$pk]);
			$result=M('MessageCategory')->alias('a')->join('inner join message m on m.message_category_id = a.id')->where('a.id='.$id)->getField('a.id');
			if($result){
			   $this->error(L('delete_cannot_finish'));
			}
			if ($id>0) {
				$condition 	= $pk.'='.$id;
				$list	=	$model->where($condition)->setField('to_hide',2);
				$this->id	=	$id;
				///如果删除操作失败提示错误
				if ($list==false) {
					$this->error(L('data_right_del_error'));
				}
			}else{
				$this->error(L('_ERROR_'));
			}

	  }
	}
}