<?php

/**
 * 出发票
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category    发票
 * @package   Action
 * @author     何剑波
 * @version  2.1,2012-07-22
 */

class InvoiceOutPublicAction extends RelationCommonAction {
	
	public function add(){
		$id	=	intval($_GET['id']);	
		if ($id > 0) {	
			//根据销售和入库单开发票
			$name 		= $this->getActionName();
			$model 		= D($name);  
			$this->rs	= $model->getRelationInfo($id,$_GET['invoice_type']);
		}
	}
}