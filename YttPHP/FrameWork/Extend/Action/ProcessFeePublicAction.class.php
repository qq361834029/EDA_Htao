<?php 

/**
 * 处理费用管理
 * @copyright   Copyright (c) 2006 - 2013 Top Union 展联软件友拓通
 * @category   	派送管理
 * @package  	Action
 * @author    	jph
 * @version 	2.1,2014-05-28
*/

class ProcessFeePublicAction extends RelationCommonAction {

    //旧数据处理
//     public function dataHandler(){
//         $model  =   $this->getModel();
//         $data   =   $model->select();
//         $model->startTrans();
//         if (count($data) > 0){
//             foreach ($data as $value){
//                 $row['process_fee_id']  =   $value['id'];
//                 $row['weight_begin']    =   $value['weight_begin'];
//                 $row['weight_end']      =   $value['weight_end'];
//                 $row['price']           =   $value['price'];
//                 $row['step_price']      =   $value['step_price'];
//                 $row['max_price']       =   $value['max_price'];
//                 if (!M("ProcessFeeDetail")->add($row)){
//                     $model->rollback();
//                     echo "NO";
//                 }                
//             }
//         }
//         $model->commit();
//         echo "OK";
//     }
//     ///直接物理删除
//     public function delete(){ 
// 		///获取当前Action名称
// 		$name = $this->getActionName();
// 		///获取当前模型
// 		$model 	= D($name);   
// 		///当前主键
// 		$pk		=	$model->getPk ();
// 		$id 	= 	intval($_REQUEST[$pk]);
// 		if ($id>0) { 
// 			$condition 	= $pk.'='.$id; 
// 			$list	=	$model->where($condition)->delete();
// 			///如果删除操作失败提示错误
// 			if ($list==false) {
// 				$this->error(L('data_right_del_error'));
// 			}
// 		}else{
// 			$this->error(L('_ERROR_'));
// 		} 
//     }	
}
?>