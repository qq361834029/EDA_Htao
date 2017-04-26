<?php 
/**
 * 导出数据信息到excel
 * @copyright   2011 展联软件友拓通
 * @category   	系统管理
 * @package  	Action 
 * @author    	何剑波
 * @version     2011-008－11
 */
class ExcelPublicAction extends Action {

    //插入
	function insert() { 
		if (isset($_GET['file'])){
			$file		= trim($_GET['file']); 
			$key		= trim($_GET['key']);		
			$in_type	= trim($_GET['in_type']);	
			$sheet		= isset($_GET['sheet']) ? intval($_GET['sheet']) : 0;//数据所处工作表下标，注从0开始
		}else{ 
			$key		= $file		= 'product';  
			$in_type	= 1;
			$show		=	true;
		} 
		//开启事务 
//		$this->openAffairs(); 
        $model = D('Excel'); 
		$model->startTrans(); 
		if ($in_type == 3) {//读取excel数据
			$rs = $model->readExcel($key,$key,$file,$sheet);
		} else {
			switch($key){
			    case 'PayPalSaleOrderImport'://新增速卖通     add by lxt 2015.07.22
                case 'ECPPSaleOrderImport':
				case 'SaleOrderImport':
					$rs = $model->saleOrderExcel($key,$key,$file,$in_type, $sheet);
					break;
				case 'ProductImport':
					$rs = $model->productExcel($key,$key,$file,$in_type, $sheet);
					break;
                case 'ProductCheckImport':
					$rs = $model->productCheckExcel($key,$key,$file,$in_type, $sheet);
					break;
				default:
					$rs = $model->derivedExcel($key,$key,$file,$in_type, $sheet);
					break;
				
			}
		}
		//如果错误回滚数据
		if (!in_array($rs['type'], array(3, 6))){  
			$model->rollback();		 	 	
		}else {
			$model->commit();
		}		
		if (!isset($_GET['file'])){
		 	echo '<pre>';
		 	echo print_r($rs);
		 	echo '<pre>';
		 	exit; 
		 }  
        return $rs;
	} 
	//插入后跳转
    public function _afterInsert() { 
    	 
    }
      
    //插入后跳转
    public function _afterInsertUrl() {  
  		$this->successUrl(3,'',$this->getPkValue()); 
    }
    
    
}
?>