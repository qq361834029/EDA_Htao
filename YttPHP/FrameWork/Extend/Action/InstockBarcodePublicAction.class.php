<?php

class InstockBarcodePublicAction extends Action {
    private $result         = false;
    private $timer          = '';
    private $is_complete    = '';
    private $id             = '';
    private $box_id         = '';
    private $quantity       = '';
    private $is_timer       = true;//true非定时触发 false定时触发
    public function __construct() {
        $this->timer    = C('TIMER_TYPE');
        $this->is_complete  = C('IS_COMPLETE');
    }
    public function regenerateInstockBoxBarcode($id=''){
        $this->id   = $id>0 ? $id : $_GET['id'];
        $model  = M('timer');
        $this->box_id   = M('InstockBox')->where('instock_id='.$this->id)->getField('id',TRUE);
        $this->box_id   = $model->where('type='.$this->timer['InstockBox'].' and is_complete in ('.$this->is_complete['pending'].','.$this->is_complete['failed'].') and object_id in ('.implode(',', $this->box_id).')')->getField('object_id',true);
        $this->quantity = count($this->box_id);
        $this->box_id = array_slice($this->box_id,0,500);
        if(!empty($this->box_id)){
            $model->where('type='.$this->timer['InstockBox'].' and object_id in ('.  implode(',', $this->box_id).')')->save(array('is_complete'=>$this->is_complete['processing']));
            foreach($this->box_id as $value){
                A('Instock')->generateBoxBarcode($value);
            }
            $this->result      = true;
        }
    }
    public function InstockBoxBarcode(){
        C('SNAP_DISABLE_VERIFY',TRUE);
        $this->is_timer  = FALSE;
        $model  = M('timer');
        $this->box_id = $model->where('type='.$this->timer['InstockBox'].' and is_complete in ('.$this->is_complete['pending'].','.$this->is_complete['failed'].')')->order('insert_time')->limit('500')->getField('object_id',TRUE);
        if(!empty($this->box_id)){
            $model->where('type='.$this->timer['InstockBox'].' and object_id in ('.  implode(',', $this->box_id).')')->save(array('is_complete'=>$this->is_complete['processing']));
            foreach($this->box_id as $value){
                A('Instock')->generateBoxBarcode($value);
            }
            $this->result      = true;
        }else{
            $this->box_id     = 0;
        }
    }

    public function __destruct() {
        if($this->result){
            $data['is_complete']    = $this->is_complete['succeed'];
            $data['complete_time']  = date('Y-m-d H:i:s', time());
        }else{
            $data['is_complete']    = $this->is_complete['failed'];
            $data['complete_time']  = date('Y-m-d H:i:s', time());
        }
        if(!empty($this->box_id)){
            M('timer')->where('type='.$this->timer['InstockBox'].' and object_id in ('.implode(',', $this->box_id).') and is_complete !='.$this->is_complete['pending'])->save($data);
            $this->quantity -= 500;
            if($this->is_timer){
                if(!empty($this->box_id) && $this->quantity>0){
                    echo $this->quantity;
                    exit;
                }
            }else{
                 if($this->result){
                     header("Content-type: text/html; charset=utf-8"); 
                     echo 'instock box id in ('.implode(',', $this->box_id).') bar code generation success!';
                 }
            }
        }
    }
}
?>