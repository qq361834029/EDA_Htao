<?php

/**
 * 产品类别对应的product_class_info中的管理
 * @copyright   2011 展联软件友拓通
 * @category   	基本信息
 * @package  	Behavior 
 */
 
class ProductClassInfoPublicBehavior extends Behavior {
	
	// 行为扩展的执行入口必须是run
    public function run(&$params){ 
    	if ($params['id']>0){
    		$product_id	=	intval($params['id']);
    		$product	=	M('product');
    		$Pinfo		=	$product->find($product_id); 
    		$model		=	D('product_class_info'); 
    		$model->where('product_id='.$product_id)->delete(); // 删除id为X的数据
    		$last_class_id	=	$Pinfo['product_class_id'];
    		if ($last_class_id>0){
    			$class_info					=	$this->getProductClassInfo($last_class_id); 
    			$class_info['product_id']	=	$product_id;  
    			$model->add($class_info);  
    		} 
    	} 
    }
    
    /**
     * 获取当前配置的产品类别
     *
     * @param int $product_class_id
     * @return array
     */
    public  function getProductClassInfo($product_class_id) {
		$info = array();
		$model	=	D('ProductClass'); 
		if (C('PRODUCT_CLASS_LEVEL')==1) {
			$info['class_1'] = $product_class_id;
		}elseif (C('PRODUCT_CLASS_LEVEL')==2) {
			$info['class_2'] = $product_class_id;
			$temp = $model->field('parent_id')->find($product_class_id); 
			$info['class_1'] = $temp['parent_id'];
		}elseif (C('PRODUCT_CLASS_LEVEL')==3) {
			$info['class_3'] = $product_class_id;
			$temp = $model->field('parent_id')->find($product_class_id);
			$info['class_2'] = $temp['parent_id'];
			$temp = $model->field('parent_id')->find($temp['parent_id']);
			$info['class_1'] = $temp['parent_id'];
		}elseif (C('PRODUCT_CLASS_LEVEL')==4) {
			$info['class_4'] = $product_class_id;
			$temp = $model->field('parent_id')->find($product_class_id); 
			$info['class_3'] = $temp['parent_id'];
			$temp = $model->field('parent_id')->find($temp['parent_id']);
			$info['class_2'] = $temp['parent_id'];
			$temp = $model->field('parent_id')->find($temp['parent_id']);
			$info['class_1'] = $temp['parent_id'];
		}
		return $info;
	}
    
}