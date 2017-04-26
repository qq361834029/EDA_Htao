<?php
class InstockStoragePublicBehavior extends Behavior {
    public function run(&$params){
		$_action	= $params['_action'] ? $params['_action'] : getTrueAction();
        if ($_action == 'delete') {
            $instock_id = M('instock_storage_del')->where('id='.$params['id'])->getField('instock_id');
        } else {
            $instock_id	= $params['instock_id'];
        }        
		//更新发货明细入库数量
		$sql	= 'UPDATE instock_detail a
					LEFT JOIN (
						SELECT instock_detail_id, sum(in_quantity) AS in_quantity
						FROM instock_storage i
						inner join instock_storage_detail d
						on i.id=d.instock_storage_id
						WHERE i.instock_id=' . $instock_id . '
						GROUP BY instock_detail_id
					)tmp
					ON a.id = tmp.instock_detail_id
					SET a.in_quantity = tmp.in_quantity
					WHERE instock_id=' . $instock_id;
		M()->execute($sql);
        D('Instock')->updateInstockStateById($instock_id);
    }
	public function insert(){        
        $this->insertCheckStorage($_POST['instock_id']);
    }

    public function update(){
         $this->updateCheckStorage();
    }
    public function add(){
         $this->insertCheckStorage($_GET['id']);
    }

    public function insertCheckStorage($instock_id) {
        if ($instock_id > 0) {
            if (M('InstockDetail')->where('quantity-in_quantity>0 and instock_id=' . $instock_id)->count() == 0){
                throw_json(L('_PRODUCT_NULL_'));
            }
            if (M('file_relation_detail')->where('relation_id=' . (int)$instock_id.' and file_type='.array_search('InstockImport', C('CFG_FILE_TYPE')))->count() > 0) {//是否已经入库导入
                throw_json(L('imported_no_storage'));
            }
        } else {
            throw_json(L('_RECORD_NULL_'));
        }
    }
    
    public function updateCheckStorage() {
        $instock_storage    = M('instock_storage')->where('id='.$_POST['id'])->find();
        if(!empty($instock_storage)){
            if (!empty($_POST['instock_id'])) {//是否已经入库导入
//                if (empty($object_id)) {
//                    $detail = array();
//                    foreach ($_POST['detail'] as $value) {
//                        if (empty($detail[$value['instock_detail_id']])) {
//                            $detail[$value['instock_detail_id']] = $value;
//                        } else {
//                            $detail[$value['instock_detail_id']]['in_quantity'] += $value['in_quantity'];
//                        }
//                    }
//                    foreach ($detail as $val) {//入库数量限制
//                        if (!empty($val['instock_detail_id'])) {
//                            $diff_quantity = M('instock_detail')->where('id=' . intval($val['instock_detail_id']))->getField('(quantity-in_quantity) as diff_quantity');
//                            if ($val['in_quantity'] - $val['old_quantity'] > $diff_quantity) {
//                                throw_json(L('too_much_storage'));
//                            }
//                        }
//                    }
//                }
            }
        }else{
            throw_json(L('_RECORD_NULL_'));
        }
    }
}
