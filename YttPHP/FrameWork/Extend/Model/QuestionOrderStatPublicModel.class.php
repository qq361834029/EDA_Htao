<?php
/**
 * 问题订单统计表
 * @author lxt 2015.06.09
 * 
 */
class QuestionOrderStatPublicModel extends RelationCommonModel{
    /// 定义真实表名
    protected $tableName = 'question_order';

	/**
	 * 列表
	 *
	 * @param string $action_name
	 * @return array
	 */
	public function index($action_name){
		$_POST['period']	= (empty($_POST['period']))?1:$_POST['period'];
		$question_order_period	= C('QUESTION_ORDER_PERIOD');
		$q_period	= ' and add_order_date>="'.date('Y-m-d', strtotime($question_order_period[$_POST['period']])).'"';
		$s_period	= ' and count_date>="'.date('Y-m-d', strtotime($question_order_period[$_POST['period']])).'"';
		$where  = getWhere($_POST).getBelongsWhere().getWarehouseWhere();
		$question	= $this->field('express_id, count(id) as question')->where($where.$q_period)->group('express_id')->formatFindAll(array('key'=>'express_id'));
		foreach($question as $v){
			$express_ids[]	= $v['express_id'];
		}
		if($express_ids){
			$sale_order	= M('SaleOrderCount')->field('express_id,sum(count_num) as sale')->where($where.$s_period.' and express_id in ('. implode(',', $express_ids) .')')->group('express_id')->formatFindAll(array('key'=>'express_id'));
		}
		foreach ($question as $key=>$val){
			$question[$key]['ship_id']	= $key;
			$question[$key]['sale']		= $sale_order[$key]['sale'];
			$question[$key]['rate']		= $val['question']/$sale_order[$key]['sale']*100;
		}
		//排序
		$sort = array(
			'direction' => 'SORT_DESC', //排序顺序标志 SORT_DESC 降序；SORT_ASC 升序
			'field'     => 'rate',       //排序字段
		);
		$arrSort = array();
		foreach($question AS $uniqid => $row){
			foreach($row AS $key=>$value){
				$arrSort[$key][$uniqid] = $value;
			}
		}
		if($sort['direction']){
			array_multisort($arrSort[$sort['field']], constant($sort['direction']), $question);
		}
		$_formatListKey	= ACTION_NAME.'_'.MODULE_NAME.'_'.__CLASS__.'_'.__FUNCTION__;
		return _formatList($question,$_formatListKey);
	}
    public function indexSql(){
        $where  =   getWhere($_POST).getBelongsWhere().getWarehouseWhere();
        $count  =   $this->where($where.' and sale_order_state in('.C('ADD_QUESTION_ORDER_AUTOSEARCH').')')->count("distinct express_id");
        //统计
        $info['order']  =   ' order by rate desc';
        $info['where']  =   ' 1 ';
        $info['field']  =   ' sale,question,ship_id,(question/sale)*100 as rate ';
        $info['from']   =   ' (select count(express_id) as sale,sum(is_question) as question,express_id as ship_id from sale_order where 
                              sale_order_state in ('.C('ADD_QUESTION_ORDER_AUTOSEARCH').') and '.$where.' group by express_id) as tmp ';
        //分页
        $info['limit']  =   getLimit($count);
        return ' select '.$info['field'].' from '.$info['from'].' where '.$info['where'].$info['order'].$info['limit'];
    }
    
    public function view(){
        return $this->getInfoQuestionOrderStat($this->id);
    }
    
    public function getInfoQuestionOrderStat($id){
        $question_order_period	= C('QUESTION_ORDER_PERIOD');
		$q_period	= ' and add_order_date>="'.date('Y-m-d', strtotime($question_order_period[$_GET['period']])).'"';
		$s_period	= ' and count_date>="'.date('Y-m-d', strtotime($question_order_period[$_GET['period']])).'"';
		$where		= 'express_id='.$id.getBelongsWhere().getWarehouseWhere();
		////总信息
		$main	= $this->field('count(id) as question,express_id as ship_id')->where($where.$q_period)->find();
		$main['sale']	= M('SaleOrderCount')->where($where.$s_period)->getField('sum(count_num) as sale');
        $main['rate']   =   round(($main['question']/$main['sale'])*100,2)."%";
        //详细信息
		$detail	= $this->field('question_reason,count(id) as question')->where($where.$q_period)->group('question_reason')->select();
        //计算各原因占比
        foreach ($detail as $key => &$value){
            if (isset($value['question_reason'])){
                $rate                    =   ($value['question']/$main['question'])*100;
                $value['question_rate']  =   round($rate,2)."%";
            }else{
                unset($detail[$key]);//过滤无问题订单
            }
        }
        $result['main']     =   _formatArray($main);
        $result['detail']   =   _formatList($detail,null,0,null,'','original');
        return $result;        
    }
    
}