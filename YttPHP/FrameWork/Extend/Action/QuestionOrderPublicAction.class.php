<?php 

/**
 * 退换货管理
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category    销售
 * @package   Action
 * @author     何剑波
 * @version  2.1,2012-07-22
 */

class QuestionOrderPublicAction extends RelationCommonAction {

	public function __construct(){
		parent::__construct(); 
		$this->assign('sid',session_id());
		$this->assign('file_tocken',md5(time()));
        if($_POST['process_mode'] != C('HAS_COMPENSATION')){
            unset($_POST['compensation_date']);
        }
        $_POST['user']['like']['if(real_name="",user_name,real_name)'] = $_POST['user']['like']['real_name'];
        unset($_POST['user']['like']['real_name']);
	}
    
    public function _after_insert() {
        $info['id']	=	$this->id; 
		if(!empty($_POST['file_tocken'])){
//            if($_POST['question_reason'] != C('DAMAGED_OR_LESS')){//原因不是包裹破损时不能上传图片
//                $relation_type[]  = C('QUESTION_IMAGE');
//            }
//            if($_POST['process_mode'] != C('UPLOADED_PROOF')){
//                $relation_type[]  = C('TRANSACTION_PROOF');
//            }
//            $relation_type[]    = 0;
//            $where  = ' and relation_type not in ('.  implode(',', $relation_type).')';
			D('Gallery')->update($this->id,$_POST['file_tocken']);//更新产品图片关联信息
		}
        parent::_after_insert();
    }
    public function _before_index(){
        getOutPutRand();
    }

    public function _autoIndex($temp_file=null) { 
		$this->action_name = ACTION_NAME;
    	$model			   = $this->getModel(); 
    	$list			   = $model->index();  
		if($list['list']){
			$table_str_start = '<table frame=void width="100%" border="0" cellspacing="0" cellpadding="0"><tbody>';
			$table_str_end   = '</tbody></table>';
            foreach((array)$list['list'] as $val){
				$sale_order_id[$val['sale_order_id']] = $val['sale_order_id'];
                $question_order_id[]    = $val['id'];
			}
			//取订单明细产品数量
			if($sale_order_id){
				$sale_order_detail  = M('sale_order_detail');
				$sql	 = 'SELECT sale_order_id,product_id,quantity
							FROM sale_order_detail
							WHERE sale_order_id in ('.implode(',',$sale_order_id).')';
				$info	 = $sale_order_detail->query($sql);
				$q_data	 = array();
				foreach((array)$info as $q_v){
					$q_data[$q_v['sale_order_id'].'_'.$q_v['product_id']] += $q_v['quantity'];
				}	 
			}
            $relation_id = 'relation_type ='.C('INVOICE_FILE').' and relation_id in (' . implode(',', $question_order_id) . ')';
			$gallery_list = M('gallery')->where($relation_id)->getField('relation_id', true);
			foreach($list['list'] as &$val){
                //追踪单号加网址
				if(!empty($val['web_url'])&&!empty($val['track_no'])){
					$track_no			= $val['courier_id'] == C('EXPRESS_IT-GLS_ID') ? preg_replace('/^R2/','',$val['track_no']) : $val['track_no'];
					$val['track_no']	= '<a href="'.$val['web_url'].$track_no.'" target="_blank">'.$val['track_no'].'</a>';
				}
                $val['w_name']  = SOnly('warehouse', $val['warehouse_id'],'w_name');
				$val['product_detail_info'] = '';
				if($val['p_ids']){		
					$tmp = explode(',',$val['p_ids']); 
					foreach((array)$tmp as $v){
						$p_info	= SOnly('product',$v);
						if($p_info){
							$tmp_p_key = $val['sale_order_id'].'_'.$v;
							$val['product_detail_info'] .= '<tr>'.
								'<td class="t_center" width="10%" style="border:0px">'.$v.'</td>'.
								'<td class="t_center" width="30%" style="border:0px">'.$p_info['product_no'].'</td>'.
								'<td class="t_center" width="30%" style="border:0px">'.$p_info['product_name'].'</td>'.
								'<td class="t_center" width="10%" style="border:0px">'.$q_data[$tmp_p_key].'</td>'.	  
								'</tr>';
						}
					} 
				}
				$val['product_detail_info']&&$val['product_detail_info']=$table_str_start.$val['product_detail_info'].$table_str_end;
                //已上传发票则加上小蓝旗标识
                if (in_array($val['id'], $gallery_list)) {
//                    $val['question_order_no'] .="<img src='" . __PUBLIC__ . "/Images/Default/red_flag.gif' style='width:17px;height:16px;'>";
                    $val['question_order_no'] .= '<span class="qizi qizi-blue" style="float:right;"></span>';
                }
                if($val['process_mode'] == C('PROVIDE_CLIENT_MOBILE') && trim($val['mobile']) != ''){
                    $val['is_show_mobile']  = true;
                }
                //问题单号/处理单号/订单单号  同列 added yyh 20150914
                $val['question_sale_order'] = '<a href="javascript:;" onclick="addTab(\''.U('QuestionOrder/view/','id='.$val['id']).'\',\''.L('view').L('question_order').'\',1); ">'.$val['question_order_no'].'</a></br>
                                            <a href="javascript:;" onclick="addTab(\''.U('SaleOrder/view/','id='.$val['sale_order_id']).'\',\''.L('view').L('module_Order').'\',1); ">'.$val['sale_order_no'].'</a></br>
                                            <a href="javascript:;" onclick="addTab(\''.U('SaleOrder/view/','id='.$val['sale_order_id']).'\',\''.L('view').L('module_Order').'\',1); ">'.$val['order_no'].'</a></br>';
            }
		}
		$this->list	= $list;
		$this->displayIndex($temp_file);
	}  
    
}