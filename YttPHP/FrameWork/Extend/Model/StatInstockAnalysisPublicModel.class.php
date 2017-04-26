<?php
/**
 * 进货数量价格分析	
 * @copyright   Copyright (c) 2006 - 2013 TOP UNION 展联软件友拓通
 * @category   	基本信息
 * @package  	Model 
 * @author 		何剑波
 * @version 	2.1
 */
class StatInstockAnalysisPublicModel extends RelationCommonModel{

	
	/// 定义真实表名
	protected $tableName = 'instock';
	/// 自动验证设置
	protected $_validate	 =	 array(
			array("",'validSearch','require',1,'callbacks'), 	
	);
	/// 必填验证
	public $searchValid	=		array( 
		array("from_real_arrive_date",'require',"require",1,'id'=>'date[from_real_arrive_date]'),
		array("to_real_arrive_date",'require',"require",1,'id'=>'date[to_real_arrive_date]'),
	);	
	
	
	/**
	 * 列表搜索验证
	 *
	 * @param array $data
	 * @return bool
	 */
	public function validSearch($data){   
		$name	=	'searchValid';
		foreach ((array)$data as $k=>$v){
			if(is_array($v)){
				foreach ((array)$v as $k2=>$vv){
					foreach ((array)$vv as $kk=>$vvv){
						$list[$kk]	= $vvv;
					}
				}
			}
		}
		return $this->_validSubmit($list,$name);     
	}
	/**
	 * 列表
	 * @return array
	 */
	public function index(){
		//重新组合POST来的信息 
		$info	= $this->setPost();
		//模型验证 
		if ($this->autoValidation($info)) {	 
			$list	= $this->instockAnalysis();
			return $list;
		} else {     
			$this->error_type	=	1; 
			return false; 
		} 
	}
	
	
	/**
	 * 获取链接URL
	 *
	 * @return string URL
	 */
	public function getUrl() {
		// 生成URL链接				
		$url_param 		.= $_POST['detail']['query']['b.product_id'] ? '/sp_detail_query_b__product_id/'.$_POST['detail']['query']['b.product_id'] : '';		
		$url_param		.= $_POST['detail2']['query']['class_1'] ? '/sp_detail2_query_class_1/'.$_POST['detail2']['query']['class_1'] : '';	
		$url_param		.= $_POST['detail2']['query']['class_2'] ? '/sp_detail2_query_class_2/'.$_POST['detail2']['query']['class_2'] : '';
		$url_param		.= $_POST['detail2']['query']['class_3'] ? '/sp_detail2_query_class_3/'.$_POST['detail2']['query']['class_3'] : '';	
		$url_param		.= $_POST['detail2']['query']['class_4'] ? '/sp_detail2_query_class_4/'.$_POST['detail2']['query']['class_4'] : '';									 
		return $url_param;
	}

	///进货数量价格分析
	private  function instockAnalysis() {
		$info	= $this->getDate();
		$list	= M('instock_detail')->field('real_arrive_date,b.currency_id, sum(quantity*capability*dozen) as quantity, sum(quantity*capability*dozen*price)  as sum_price')
						->join(' as b inner join instock as a on a.id=b.instock_id')
						->where(getWhere($_POST['main']).' and '.getWhere($_POST['detail']))
						->exists('select 1 from product_class_info where '.getWhere($_POST['detail2']),$_POST['detail2'])
						->group('a.id,b.currency_id')
						->select();
		//计算日期
		$dates = cacuDate($_POST['main']['date']['from_real_arrive_date'], $_POST['main']['date']['to_real_arrive_date'], $_POST['compare_type']);
		$_POST['compare_type']==1? $date_key = 'Y' : ($_POST['compare_type'] == 2 ? $date_key = 'Y-m' : $date_key = 'Y-m-d');			
		if (is_array($dates)) {					
			foreach ($list as $s_list) {
				$c_date = date($date_key, strtotime($s_list['real_arrive_date']));		
					$data[$s_list['currency_id']][$c_date]['sum_quantity'] 	+= $s_list['quantity'];
					$data[$s_list['currency_id']][$c_date]['sum_price'] 	+= $s_list['sum_price'];	
			}
		}			
		unset($list);
		
		$currency_array	= S('currency');
		$url_param 		= $this->getUrl();
		foreach ((array)$data as $c =>  $temp) {			
			foreach ($dates as $date) {
				$show_date = $date;
				if ($date_key == 'Y-m') {			
					if (C('DIGITAL_FORMAT') == 'eur') {
						$show_date 			= formatDate($show_date.'-01', 'outdate');
						$show_date 			= substr($show_date, 3);	
					}				
					$f_cp_date = substr(formatDate($_POST['main']['date']['from_real_arrive_date']),0,7);		
					$t_cp_date = substr(formatDate($_POST['main']['date']['to_real_arrive_date']),0,7);						
					$from_real_arrive_date 	= $f_cp_date == $show_date ? formatDate($_POST['main']['date']['from_real_arrive_date']) : $date.'-01';
					$to_real_arrive_date	= $t_cp_date == $show_date ? formatDate($_POST['main']['date']['to_real_arrive_date']) : $date.'-'.date('t', strtotime($from_real_arrive_date));					
				} else if ($date_key == 'Y-m-d') {
					if (C('DIGITAL_FORMAT') == 'eur') {
						$show_date 			= formatDate($show_date, 'outdate');
//						$show_date 			= substr($show_date, 0, 5);	
					} else {
//						$show_date 			= substr($show_date, 5);
					}					
					$from_real_arrive_date	= formatDate($date);
					$to_real_arrive_date	= formatDate($date);
				} else {
					$from_real_arrive_date	= formatDate($_POST['main']['date']['from_real_arrive_date'] ? $_POST['main']['date']['from_real_arrive_date'] : $date.'-01-01');
					$to_real_arrive_date	= formatDate($_POST['main']['date']['to_real_arrive_date'] ? $_POST['main']['date']['to_real_arrive_date'] : $date.'-12-'.date('t', strtotime($date.'-12-01')));
				}
				if ($temp[$date]) {
					$list['list'][$show_date][] = array(/*'real_arrive_date'	=> $show_date,*/
								'currency_id'			=> $c,
								'sum_quantity'			=> $temp[$date]['sum_quantity'],
								'avg_price'				=> number_format($temp[$date]['sum_price']/$temp[$date]['sum_quantity'],C('PRICE_LENGTH')),	
								'var_url'				=> '/StatInstockAnalysis/view/compare_type/'.$_POST['compare_type'].'/sp_main_date_from_real_arrive_date/'.$from_real_arrive_date.'/sp_detail_query_b__currency_id/'.$c.$url_param.'/sp_main_date_to_real_arrive_date/'.$to_real_arrive_date
								);
				} else {
					if($list['list'][$show_date]){
						$list['list'][$show_date][] = array(/*'real_arrive_date'	=> $show_date,*/
									'currency_id'			=> $c,
									'sum_quantity'			=> 0,
									'avg_price'				=> 0,
									'var_url'				=> ''	
									);
					}
				}
				$currency[]	= $currency_array[$c]['currency_no'];
			}				
		}
//		$list 				= _formatList($list);	
		$list['currency']	= @array_unique($currency);
		$list['page']		= $info['page'];
		return $list;
	}	
	
	///进货数量价格分析(明细)
	public function instockAnalysisDetail() { 
		$compare_type	= $_GET['compare_type'];
		$where			= $this->_getSpecialUrl($_GET);
		$sql = ' 
					select  count(*) as count,sum(quantity*capability*dozen) as quantity
					from instock_detail b inner join  instock a on a.id=b.instock_id 				 
				 	where  '.getWhere($where['main']).' and '.getWhere($where['detail']).'
					and exists(select 1 from product_class_info where '.getWhere($where['detail2']).')';
		$count 	= $this->cache()->query($sql);	
		if (!$count[0]['count']) return ;
		$ids	= $this->field('id')
					->exists('select 1 from instock_detail b where b.instock_id=instock.id and '.getWhere($where['detail']).
							' and exists(select 1 from product_class_info c where b.product_id=c.product_id and '.getWhere($where['detail2']).')',$where['detail'])
					->where(getWhere($where['main']))->order('instock_no desc')->page()->selectIds();
		// 取列表信息	
		$sql = 'select 
				 product_id,a.instock_no,b.currency_id,a.id,
				 sum(quantity*capability*dozen) as quantity, 
				 sum(quantity*capability*dozen*price)/sum(quantity*capability*dozen) as avg_price
				 from instock a inner join instock_detail b on b.instock_id=a.id
				 where exists(select 1 from product_class_info c where b.product_id=c.product_id and '.getWhere($where['detail2']).')
				 and '.getWhere($where['detail']).' and a.id in '.$ids.' group by b.instock_id,b.product_id order by null';
		$list 								= $this->cache()->query($sql._limit(_page($count[0]['count'])));	
		$list 								= _formatList($list);		
		$list['total']['all_quantity']	 	= moneyFormat($count[0]['quantity'], 0, 0);
		$title_date							= ($compare_type == 1) ? substr($_GET['sp_main_date_from_real_arrive_date'],0,4) : 
					  						  (($compare_type == 2) ? substr($_GET['sp_main_date_from_real_arrive_date'],0,7) :
					   						  formatDate($_GET['sp_main_date_from_real_arrive_date'], 'outdate')) ;		
		if (C('DIGITAL_FORMAT') == 'eur' && $compare_type ==2) {
			$title_date 					= formatDate($title_date.'-01', 'outdate');
			$title_date 					= substr($title_date, 3);	
		}		
		$list['total']['title']				= '"'.$title_date.'""'.$list['list'][0]['currency_no'].'"'.L('stat_instock_detail_2');	
		return $list;
	}
	
	function _getSpecialUrl($get){
		foreach ($get as $key => $value) {
			if(substr($key,0,3) == 'sp_')
			{
				$array	=	explode('_',$key);
				if (count($array)>2){
					$name	=	str_replace($array[0].'_'.$array[1].'_'.$array[2].'_','',$key);
					if (strpos($name,'__')) {
						$name	= str_replace('__','.',$name);
					}
					$info[$array[1]][$array[2]][$name]	= $value ;
				}
			}
		}
		return	$info;
	}
	
	/**
	 * 计算总合计
	 * @return array
	 */
	public function getListTotal(){
		$sql	= 'select 
					 sum(quantity*capability*dozen) as quantity
					 from instock a inner join  instock_detail b on a.id=b.instock_id 
					 left join product_class_info c on(b.product_id=c.product_id) 			 
				 where  '._search_array(_getSpecialUrl($_GET)).
				' group by 1=1';
		$total	= $this->cache()->query($sql);
		return _formatList($total);
	}
	/// 计算分页日期区间
	public function getDate(){
		$compare_type	= $_REQUEST['compare_type'];
		if($compare_type==2){
			$date_format= '%Y-%m';
		}elseif($compare_type==3){
			$date_format= '%Y-%m-%d';
		}else{
			$date_format= '%Y';
		}
		$sql	= "select date_format(real_arrive_date,'".$date_format."') order_date from instock_detail   
					b inner join instock a on a.id=b.instock_id
					where ".getWhere($_POST['main']).' and '.getWhere($_POST['detail'])." 
					and exists(select 1 from product_class_info where ".getWhere($_POST['detail2']).")
					group by date_format(real_arrive_date,'".$date_format."') order by null";
		$info	= getAnalysisDate($sql);
		
		$_POST['main']['date']['from_real_arrive_date']	= $info['from_order_date'];
		$_POST['main']['date']['to_real_arrive_date']	= $info['to_order_date'];
//		echo '<pre>';print_r($info);
		return $info;
	}
}