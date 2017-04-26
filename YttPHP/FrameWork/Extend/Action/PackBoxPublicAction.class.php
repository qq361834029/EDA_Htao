<?php 

/**
 * 国内运单
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category   	装箱单
 * @package  	Action
 * @author    	YYH
 * @version 	2.1,2015-05-06
*/

class PackBoxPublicAction extends RelationCommonAction {
	
	public function __construct() { 
    	parent::__construct();
	}
    public function _after_insert() {
        $this->generateBarcode();
        parent::_after_insert();
    }
    public function _after_update() {
        $this->generateBarcode();
        parent::_after_update();
    }

    public function _autoIndex($temp_file=null) {
		$this->action_name = ACTION_NAME;
    	$model 			   = $this->getModel();
		$list			   = $model->index();
        foreach($list['list'] as &$value){
            
            //内件数量
            $value['quantity'] = M('pack_box_detail')->where('pack_box_id='.$value['id'])->count();
            //本页装箱的退货单ID
            $pack_box_id[$value['id']]   = $value['id'];
            
        }
        unset($value);
        if(!empty($pack_box_id)){
            //大包重量
            $weight = D('PackBox')->getPackBoxWeight($pack_box_id);
            $is_out_batch   = $this->isOutBatch($pack_box_id);
            $is_abnormal    = $this->isAbnormal($pack_box_id);
            foreach($list['list'] as &$val){
                $val['weight']      = $weight[$val['id']];
                $val['is_update']   = $val['is_del']      = in_array($val['id'], $is_out_batch) ? 0 : 1;
                if($val['is_update'] == 0){
                    $val['is_update']   = in_array($val['id'],$is_abnormal) ? 1 : 0;
                }
            }
            unset($val);
        }
        $list   = _formatList($list['list']);
        if(empty($_POST['record_check_token'])){
            $record_check_token = time().rand(1000,9999);
        }else{
			$S	= S($_POST['record_check_token']);
            foreach($list['list'] as &$v){
                if(in_array($v['id'],$S)){
                    $v['is_check']  = true;
                }
            }
            $record_check_token = $_POST['record_check_token'];
        }
        $this->assign('record_check_token',$record_check_token);
    	$this->list		   = _formatList($list['list']);
		$this->displayIndex($temp_file);
	}
    public function isAbnormal($pack_box_id){
        $pack_box_id[]  = 0;
        return M('pack_box_detail')->where('pack_box_id in ('.  implode(',', $pack_box_id).') and parcel_state<>0')->getField('pack_box_id',true);

    }

    //是否已经出库
    public function isOutBatch($pack_box_id){
        $pack_box_id[]  = 0;
        return M('out_batch_detail')->where('pack_box_id in ('.  implode(',', $pack_box_id).')')->getField('pack_box_id',true);
    }

    public function generateBarcode(){
		$model 	= 'PackBox';
        $code   = M($model)->where('id='.$this->id)->getField('pack_box_no');
		$path			= BARCODE_PATH . ucfirst($model);
        $barcode_config	= array(
							'w'	=> 240,
							'h'	=> 80,
                            'thickness'    =>  40,
						);
        createBarcodeImg($code, $path,$barcode_config);
	}
    public function packBoxLabel($info){
        return '<div>
                    <div style="font-family:Arial,sans-serif;float: left;color: #000;font-size:11pt; font-weight:bolder;line-height: 20pt;">
                        FROM:EDA ES WH<br />
                        TO:COE HK WH<br />
                        <br />
                        大包单号:'.$info['pack_box_no'].'<br />
                        大包条码：<br />
                        <img width="240pt" src="'.BARCODE_PATH . 'PackBox/' . $info['pack_box_no'] . '.' . C('BARCODE_PC_TYPE').'?'.time().'"><br />
                        内件数量：'.count($info['detail']).' 个<br />
                        整袋重量：'.$info['weight'].' kg<br />
                    </div>
                    </div>';
        
    }
}
?>