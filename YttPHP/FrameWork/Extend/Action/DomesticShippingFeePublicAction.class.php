<?php
class DomesticShippingFeePublicAction extends RelationCommonAction{
    
    
    public function delete() {
    	///还原特殊处理 mingxing 
    	if ($_GET['restore']==1){
    		$this->restore();
    	}else{ 
			///获取当前Action名称
			$name = $this->getActionName();
	 		///获取当前模型
			$model 	= D($name);  
			$pk		= $model->getPk (); 
	    	$id 	= intval($_REQUEST[$pk]); 
	    	$condition	=	'id='.$id;
	    	$this->id = $id;
	    	$list	=	$model->where($condition)->setField('to_hide',2);   
			if (false === $list) {
				$this->error ( L('DELETE_FAILED') );
			}
		}
	}
	
	///还原
    public function restore($id=null){
    	///获取当前Action名称
	 	$name = $this->getActionName();
 		///获取当前模型
		$model 	= D($name);   
		///当前主键
		$pk		=	$model->getPk();
		$id 	= 	$id ? intval($id) : intval($_REQUEST[$pk]);
		$this->id = $id;
		if ($id>0) { 
			///更新条件
			$condition 	= $pk.'='.$id; 
			///执行条件语句
			$list		= $model->where( $condition )->setField('to_hide',1);    
			///如果产品还原失败提示失败
			if ($list==false) { 
				$this->error(L('_ERROR_'));
			}			
		}else{ 
			$this->error(L('_ERROR_'));
		} 
    }  
}