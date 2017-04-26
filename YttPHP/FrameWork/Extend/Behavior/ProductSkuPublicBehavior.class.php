<?php
/**
 * 外部SKU
 * @copyright   Copyright (c) 2006 - 2014 Top Union 展联软件友拓通
 * @category    外部SKU
 * @package		Behavior
 * @author		hjb
 * @version		2.1,2014-09-29
 */

class ProductSkuPublicBehavior extends Behavior {

	public function run(&$params){
		
	}
	
	/// 插入验证
	protected function insert(&$params){
		$this->checkRepeatSku($params);
	}

	/// 修改验证
	protected function update(&$params){
		$this->checkRepeatSku($params);
	}

	/// 验证同一个外部在相同卖家下只能存在一个
	protected function checkRepeatSku(&$params){
		if($params['product_sku'] && $params['factory_id'] > 0){
			$params['product_sku'] = array_filter($params['product_sku']);
			$unique_arr = array_unique($params['product_sku']);
			// 获取重复数据的数组  
			$repeat_arr = array_diff_assoc($params['product_sku'],$unique_arr);

			///如果是修改产品还要排除掉原来自身的SKU
			if($params['id']){
				$where = ' and product_id!='.$params['id'];
			}
			$model	=	M('ProductSku');
            if(!empty($unique_arr)){
                $repeat_arr2	=	$model->where('factory_id='.$params['factory_id'].' and sku in (\''.implode('\',\'',$unique_arr).'\')'.$where)->getField('sku',true);    
            }
            if(count($repeat_arr2)>0 && count($repeat_arr)>0){
				$repeat_arr = array_unique(array_merge($repeat_arr,$repeat_arr2));
			}elseif(count($repeat_arr)>0){
				$repeat_arr = $repeat_arr;
			}elseif(count($repeat_arr2)>0){
				$repeat_arr = $repeat_arr2;
			}
			if (count($repeat_arr)>0) {
				throw_json(L('check_repeat_sku').implode(',',$repeat_arr));
			}
		}
	}
}