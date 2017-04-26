<?php

/**
 * 入库
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category    采购
 * @package   Behavior
 * @author     jph
 * @version  2.1,2014-03-13
 */

class InstockPublicBehavior extends Behavior {
	
	public function run(&$params){
		$_action	= $params['_action'] ? $params['_action'] : getTrueAction();
        if($_action  =='update' || $_action   =='editStateUpdate'){
            $this->inQuantity();
        }
		T('Instock')->run($params,'setState');
	}
	/// 新入库 检验待入库单子是否保存
	protected function insert(&$params){
		
	}
    public function inQuantity() {
//        if ($_POST['instock_type'] != $_POST['old_instock_type'] && $_POST['instock_type'] <= C('CFG_INSTOCK_TYPE_INSTOCK_FOREIGN')) {
//            $quantity = 0;
//            if ($_POST['instock_type'] == C('CFG_INSTOCK_TYPE_INSTOCK_FOREIGN')) {
//                $quantity = '`quantity`';
//            }
//            $sql = 'UPDATE `instock_detail` SET `in_quantity`=' . $quantity . ' WHERE instock_id=' . intval($_POST['id']);
//            M('instock_detail')->query($sql);
//        }
    }

    /// 删除时检验 是否已审核
	protected function delete(&$params){
		$instock	= M('instock')->where('id='.intval($params['id']))->getField('instock_type,add_user');
		$instock_type	= key($instock);
		if(!D('Instock')->checkDelete($instock_type)){
			throw_json(L('error_is_audited_cant_del'));
		}elseif (M('instockDetail')->where('instock_id=' . intval($params['id']))->getField('sum(in_quantity)')){
			throw_json(L('error_have_inbound_cant_del'));
		}elseif ($instock[$instock_type] != getUser('id')) {
            if(MODULE_NAME == 'Api'){//add yyh API同卖家即可删除
                $factory_id = M('instock')->where('id='.  $params['id'])->getField('factory_id');
                if($factory_id != getUser('company_id')){
                    throw_json(L('error_is_own_cant_del'));
                }
            }else{
                throw_json(L('error_is_own_cant_del'));
            }
		}
	}

	/// 删除明细时验证，该产品是否已经有入库
	protected function deleteDetail(&$params){
		if ($params['id'] > 0) {
			$in_quantity = M('instock_detail')->where(array('id' => $params['id']))->getField('in_quantity');
			if ($in_quantity<>0) {
				throw_json(L('has_instock_cant_delete'));
			}
		}
	}

	/// 删除装箱明细时验证，该箱号下是否有产品明细
	protected function deleteBoxDetail(&$params){
		if ($params['id'] > 0) {
			$count = M('instock_detail')->where('box_id='.$params['id'])->count();
			if ($count>0) {
				throw_json(L('no_delete_box'));
			}
		}
	}	
	
	/// 编辑时检验 是否已审核
	protected function edit(&$params){
            $this->checkEdit($params);
	}	
        
	
	/// 编辑时检验 是否已审核
	protected function update(&$params){
            $this->checkEdit($params);
	}
        
    public function checkEdit(&$params) {
        if (getUser('role_type') == C('SELLER_ROLE_TYPE')) {//已审核发货，卖家用户不可编辑
            $instock_type = M('instock')->where('id=' . intval($params['id']))->getField('instock_type');
            if ($instock_type >= C('CFG_INSTOCK_TYPE_UNEDIT')) {
                throw_json(L('error_is_audited_cant_edit'));
            } elseif (M('instockDetail')->where('instock_id=' . intval($params['id']))->getField('sum(in_quantity)')) {
                throw_json(L('error_have_inbound_cant_edit'));
            }
        }
    }
}