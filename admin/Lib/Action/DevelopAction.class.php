<?php

class DevelopAction extends CommonAction {

	// 字典管理
	public function dd(){
		$this->dd = M('Dd')->order('id asc')->select();
		$this->display();
	}
	
	// 开发配置下菜单管理
    public function node(){
    	if ($_GET['id']>0) {
    		$where = ' (parent_id='.$_GET['id'].')';
    	}else{
    		$where = 'group_id=0 and level=1';
    	}
    	$this->node = M('Node')->where($where)->order('sort asc')->select();
    	$this->display();
    }
    public function addnode(){
		$this->display();
	}
    // 开发配置下编辑节点信息
    public function editnode(){
    	$rs = M('Node')->find($_GET['id']);
    	if ($rs['parent_id'] && $temp = M('Node')->find($rs['parent_id'])) {
    		$rs['parent_title'] = $temp['title'];
    		unset($temp);
    	}
    	if ($rs['group_id'] && $temp = M('Node')->find($rs['group_id'])) {
    		$rs['group_title'] = $temp['title'];
    	}
    	$this->rs =$rs;
    	$this->display();
    }
    
    // 开发配置下保存节点信息
    public function saveNode(){
    	$model = M('Node');
    	$model->create($_POST);
		if($_POST['id']){
    		$rs	= $model->save();
		}else{
			$rs	= $model->add($_POST); 
		}
        $msg    = $rs!==false ? '保存成功，2秒后跳转' : '保存失败，2秒后跳转';
    	header("location:".__URL__."/node", $msg);
    }    
    
    // 开发配置下删除节点信息
    public function deletenode(){
    	M('Node')->delete($_GET['id']);
    	header("location:".__URL__."/node");
    }
	
	
    // 开发配置下编辑节点信息
	/**
	 * 删除节点（包括子节点）
	 * @author jph 20131230
	 */
    public function delNode(){
    	$rs = $this->delAllNode($_GET['id']);
        $msg    = $rs!==false ? '删除成功，2秒后跳转' : '删除失败，2秒后跳转';
    	header("location:".__URL__."/node", $msg);
    }	
	
	/**
	 * 递归删除节点
	 * @author jph 20131230
	 */	
	public function delAllNode($id) {
		$model	= M('Node');
		$result		= $model->delete($id);
		if ($result) {
			$childNode	= $model->where('parent_id=' . $id)->getField('id', true);
			foreach ((array)$childNode as $child_id) {
				$this->delAllNode($child_id);
			}
		}
		return $result;
	}
}