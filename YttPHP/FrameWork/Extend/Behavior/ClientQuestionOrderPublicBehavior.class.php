<?php
class ClientQuestionOrderPublicBehavior extends Behavior {

	public function run(&$params){ 
		$Model	= D('ClientQuestionOrder');   
        $id     = $params['id'];
        $sys_pay_class  = C('QUESTION_SYS_PAY_CLASS');
		$_action	= $params['_action'] ? $params['_action'] : getTrueAction();
        if ($_action == 'delete') {
            $info = $Model->deleteOp($id);
            $sale_order_id  = M('question_order_del')->where('id='.$id)->getField('sale_order_id');
            if(!empty($sale_order_id)){
                $data['id']     = $sale_order_id;
                $data['is_question']    = 0;
                M('sale_order')->save($data);
            }
        } else {
            $info = $Model->_fund($params);
        }
    }
}