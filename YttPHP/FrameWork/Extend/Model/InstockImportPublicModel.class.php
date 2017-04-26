<?php 
/**
 * 入库导入管理
 * @copyright   Copyright (c) 2006 - 2013 TOP UNION 展联软件友拓通
 * @category   	入库信息
 * @package  	Model
 * @author    	jph
 * @version 	2.1,2014-03-31
 */

class InstockImportPublicModel extends FileListPublicModel {
	
	public function setIndexList(&$list) {
		$ids	= array_keys($list);
		$relation_details	= M('FileRelationDetail')->field('object_id as file_id,b.id as instock_id, b.instock_no')->join('a left join instock b on b.id=a.relation_id')->where('object_id in (' . implode(',', $ids)  . ') and file_type=' . $this->_file_type)->order('b.instock_no desc')->select();
		if ($relation_details) {
			foreach ($relation_details as $detail) {
				$instock_list	= isset($list[$detail['file_id']]['instock_list']) ? explode('<br />', $list[$detail['file_id']]['instock_list']) : array();
				$instock_list[]	= '<a href="javascript:;" onclick="addTab(\'' . U('/Instock/view/id/' . $detail['instock_id']) .  '\',\'' . title('view', 'Instock') .  '\'); ">' . $detail['instock_no'] . '</a>';
				$list[$detail['file_id']]['instock_list']	= implode('<br />', $instock_list);
			}
		}	
		unset($relation_details);
		return $list;
	}	
    public function setInsertDetail(&$detail) {
        $all_box_id = array();
        foreach ($detail as $value) {
			if (intval($value['box_id']) > 0) {
				$all_box_id[] = intval($value['box_id']);
			}
			if ($value['quantity'] < 0) {
				return 'Quantity: ' . L('pst_integer');
			}
        }
        if (empty($all_box_id)) {
            return L('no_instock_id');
        }
        $all_instock_id = M('instock_box')->join('b left join instock a on a.id=b.instock_id')->where('b.id in (\'' . implode('\',\'', $all_box_id) . '\')')->group('b.instock_id')->getField('a.instock_no,b.instock_id');
        if (empty($all_instock_id)) {
            return L('no_instock_id');
        }
        $allow_instock_id = M('instock_storage')->where('instock_id in (\'' . implode('\',\'', $all_instock_id).'\')')->getField('instock_id', true);
        foreach ($all_instock_id as $key => $value) {
            if (in_array($value, $allow_instock_id)) {
                $instock_no_arr[] = L('delivery_no') . $key . L('no_instock_import');
            }
        }
        if (!empty($instock_no_arr)) {
            return implode('<br>', $instock_no_arr);
        }
        return true;
    }
    public function indexSql(){  
		$where = getWhere($_POST) . ' and a.file_type=' . $this->_file_type;
		$count 	= $this->join('as a left join file_relation_detail as b on b.object_id=a.id')->where($where)->count();
		$this->setPage($count);
		$ids	= $this->field('a.id')->join('as a left join file_relation_detail as b on b.object_id=a.id')->where($where)->order('a.file_list_no desc')->page()->selectIds();
		$info['from'] 	= 'file_list';
		$info['order'] 	= ' order by file_list_no desc';
		$info['where'] 	= ' where id in'.$ids;
		$info['field'] 	= "*";
		return	'select '.$info['field'].' from '.$info['from'].$info['where'].$info['order'];
	}
}