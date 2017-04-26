<?php

class SystemAction extends CommonAction {
    
	// 公共配置
	public function common(){
		$this->assign('client_currency',explode(',',$this->rs['client_currency']));
		$this->assign('factory_currency',explode(',',$this->rs['factory_currency']));
		$this->assign('company_currency',explode(',',$this->rs['company_currency']));
		$this->display();
	}
}