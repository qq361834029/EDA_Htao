<?php
class QuestionOrderPublicBehavior extends Behavior {
	
	public function run(&$params){
        $data['id']     = $params['sale_order_id'];
        $data['is_question']    = ACTION_NAME == 'delete' ? 0 : 1;
        if(ACTION_NAME != 'update'){
            M('sale_order')->save($data);
        }
//        if(ACTION_NAME == 'update' || ACTION_NAME == 'delete'){
//            if(getUser('role_type')!=C('WAREHOUSE_ROLE_TYPE')){
//                if(empty($params['question_reason']) || $params['question_reason'] != C('DAMAGED_OR_LESS')){
//                    $relation_type[]  = C('QUESTION_IMAGE');
//                }
//            }
//            if(getUser('role_type')!=C('SELLER_ROLE_TYPE')){
//                if(empty($params['process_mode']) || $params['process_mode'] < C('UPLOADED_PROOF')){
//                    $relation_type[]  = C('TRANSACTION_PROOF');
//                }
//            }
//            if(!empty($relation_type)){
//                $this->deleteGallery($params,$relation_type);
//            }
//        }
        //添加到状态日志
        T('QuestionOrder')->run($params,'setState');
	}
    
    /**
     * @name 问题订单删除上传文件
     * @author added by yyh 20150425
     * @param array $params
     */
    public function deleteGallery($params,$relation_type){
        $where['relation_type'] = array('in',$relation_type);
        $where['relation_id']   = $params['id'];
        M('Gallery')->where($where)->delete();
    }
}