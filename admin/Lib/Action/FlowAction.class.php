<?php

class FlowAction extends CommonAction {
    
	// 流程配置
    public function flow() {
       $this->assign('menu',D('Admin')->getNode());
       $this->display();
    }
    // 更新项目可用模块
    public function updateNode(){
    	D('Admin')->saveNode();
    	redirect('flow',2,'保存成功，2秒后跳转');
    }
    
    
    
    
}