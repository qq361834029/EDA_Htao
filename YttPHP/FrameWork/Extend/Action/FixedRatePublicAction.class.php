<?php 
/**
 * 固定汇率
 * @copyright   2011 展联软件友拓通
 * @category   	基本信息
 * @package  	Action
 * @author    	何剑波
 * @version     2011-03-23
 */
class FixedRatePublicAction extends CommonAction {
     	
	public function index(){
		$this->currency	=	S('currency');
		//当前使用的币种
		$used_currency 	=	M('currency')->where('is_delete=1')->select(); 
		foreach ((array)$used_currency as $key=>$row) {	$currency[]	=	$row['id'];	} 
		$model 	= 	M();   
		$sql	=	'select * from fixed_rate 
			where from_currency_id in ('.join(',',$currency).') and to_currency_id in ('.join(',',$currency).') and from_currency_id!=to_currency_id 
			order by from_currency_id,to_currency_id'; 
		//格式化+获取列表信息 
		$this->list	=	$model->query($sql);    
		$this->display();
	}
	 //修改保存
	public function update() {  
		//当前模型
		$model 	= 	M('FixedRate'); 
		//主表ID 
 		foreach ($_POST['rate'] as $id => $rate) {
 			$data	=	array('id'=>$id,'rate'=>$rate);  
 			$model->save($data);
 		}
 		$this->success();
	}
}
?>