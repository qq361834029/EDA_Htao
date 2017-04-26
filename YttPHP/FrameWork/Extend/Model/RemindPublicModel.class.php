<?php
/**
 * 提醒信息Model类
 * @copyright   Copyright (c) 2006 - 2013 Top Union 展联软件友拓通
 * @category   	提示信息
 * @package  	Model
 * @author    	何剑波
 * @version 	2.1,2013-07-22
 */

class RemindPublicModel extends Model {
	protected $tableName = 'currency';
	/// 自动填充字段
	protected $limit			=	50;
	private $remind_right	=	'';
	protected $remind_info	=	array(
		'todayInstock'		=>array('right'=>'instock_index'),
		'todaySale'			=>array('right'=>'saleorder_index'),
		'todayAdvance'		=>array('right'=>'saleorder_index,clientfunds_index'),
		'todayArrearage'	=>array('right'=>'saleorder_index,clientfunds_index'),
		'todayClient'		=>array('right'=>'stat_clientmoneystat'),
		'todayFactory'		=>array('right'=>'stat_factorymoneystat'),
		'todayLogistics'	=>array('right'=>'stat_logisticmoneystat'),
		'orderList'			=>array('right'=>'orders_index','view'=>'Orders/view','view_value'=>'id:id','list'=>'Orders/alistUnfinishOrder'),
		'instockList'		=>array('right'=>'instock_index','view'=>'LoadContainer/view','list'=>'Instock/waitInstock'),
		'preDeliveryList'	=>array('right'=>'predelivery_wait','view'=>'PreDelivery/viewSale','list'=>'PreDelivery/waitPreDelivery'),
		'deliveryList'		=>array('right'=>'delivery_wait','view'=>'PreDelivery/view','list'=>'Delivery/waitDelivery'),
		'clientList'		=>array('right'=>'saleorder_index,clientfunds_index','view'=>'SaleOrder/view','list'=>'SaleOrder/alistUnfinish'),
		'factoryList'		=>array('right'=>'instock_index,factoryfunds_index','view'=>'Instock/view','view_value'=>'id:id,factory_id:comp_id','list'=>'Instock/index'),
		'logisticsList'		=>array('right'=>'instock_index,logisticsfunds_index','view'=>'Instock/view','view_value'=>'id:id','list'=>'Instock/index'),
		'invoiceList'		=>array('right'=>'bankbill_index','view'=>'BankBill/view','list'=>'BankBill/index'),
		'auditList'			=>array('right'=>'audit_index','view'=>'Audit/view','list'=>'Audit/index'),
		'auditFactoryList'	=>array('right'=>'factory_index','view'=>'Factory/view','list'=>'Factory/index'),//added by jp 20140310

		'transferList'      =>array('right'=>'out_batch_index','view'=>'OutBatch/view','list'=>'OutBatch/index'),//added by yyh 20150924
		'returnStorageOutList'  =>array('right'=>'return_sale_order_storage_index','view'=>'ReturnSaleOrderStorage/view','list'=>'ReturnSaleOrderStorage/index'),//added by yyh 20150924

		'rechargeList'      =>array('right'=>'clientstat_index','view'=>'ClientStat/view','list'=>'ClientStat/index'),//added by lml 20151228

		'messageUnread'      =>array('right'=>'message_index','view'=>'Message/view','list'=>'Message/index'),//added by lml 20160115

		'todayWithoutSigned'=>array('right'=>'returnsaleorder_index','view'=>'ReturnSaleOrder/view','list'=>'ReturnSaleOrder/index'),//add by lxt 2015.09.24
		'abnormalReturn'    =>array('right'=>'returnsaleorder_index','view'=>'ReturnSaleOrder/view','list'=>'ReturnSaleOrder/index'),
	    'waitForFactory'    =>array('right'=>'returnsaleorderstorage_index','view'=>'ReturnSaleOrderStorage/view','list'=>'ReturnSaleOrderStorage/index'),
	    'signedWithoutStorage'=>array('right'=>'returnsaleorder_index','view'=>'ReturnSaleOrder/view','list'=>'ReturnSaleOrder/index'),
		);
	//数量为产品数量的提醒  (方法名=>total数组对应的字段)        add by lxt 2015.09.24
	protected $total_info  =   array(
	    'todayWithoutSigned'   =>  'quantity',
	    'abnormalReturn'       =>  'quantity',
	    'waitForFactory'       =>  'quantity',
	    'signedWithoutStorage' =>  'quantity',
	);

	/**
	 * 	入库数量【箱】
		入库金额
	 *
	 */
	public function todayInstock(){
		///权限验证
		if (self::checkRights(__FUNCTION__)===false){ return ; }
			$sql	=	'SELECT b.currency_id,sum(quantity*capability*dozen*price) AS price,sum(quantity) AS quantity
			FROM instock a LEFT JOIN instock_detail b ON a.id = b.instock_id
			WHERE 1 and real_arrive_date=CURDATE() and b.currency_id is not null
			GROUP BY b.currency_id   ';
			$list = _formatList($this->db->query($sql));
			if (is_array($list['list'])){
				foreach ((array)$list['list'] as $key=>$row) {
					$note	.=	' '.$row['currency_no'].':'.$row['dml_price'];
				}
				$return['note']		=	$note;
				$return['quantity']	=	$list['total']['quantity'];
			}else{
				$return['note']		=	0;
				$return['quantity']	=	0;
			}
			return $return;
	}

	/**
	 * 	入库数量【箱】
		入库金额
	 *
	 */
	public function todaySale(){
		///权限验证
		if (self::checkRights(__FUNCTION__)===false){ return ; }

		$sql	=	'
		select  currency_id,sum(price) as price,sum(quantity) as quantity
		from
		(
			SELECT a.currency_id,sum(quantity*capability*dozen*price*discount) AS price,sum(quantity) AS quantity
			FROM sale_order a LEFT JOIN sale_order_detail b ON a.id = b.sale_order_id
			WHERE 1 and order_date_format=CURDATE() and a.currency_id is not null
			GROUP BY a.currency_id
			union all
			SELECT a.currency_id,sum(pr_money*-1) AS price,0 AS quantity
			FROM sale_order as a
			WHERE 1 and order_date_format=CURDATE() and a.currency_id is not null and pr_money<>0
			GROUP BY a.currency_id
		) as newtables
		where 1
		group by currency_id
		';
		$list = _formatList($this->db->query($sql));
		if (is_array($list['list'])){
			foreach ((array)$list['list'] as $key=>$row) {
				$note	.=	' '.$row['currency_no'].':'.$row['dml_price'];
			}
			$return['note']		=	$note;
			$return['quantity']	=	$list['total']['dml_quantity'];
		}else{
			$return['note']		=	0;
			$return['quantity']	=	0;
		}
		return $return;
	}

	/**
	 * 	收款金额
	 *
	 */
	public function todayAdvance(){
		///权限验证
		if (self::checkRights(__FUNCTION__)===false){ return ; }

		$sql	=	'SELECT currency_id,sum(income_type*should_paid) AS money
		FROM client_paid_detail
		WHERE 1 and paid_date=CURDATE() and currency_id is not null and income_type=1 and object_type not in (122,104)
		GROUP BY currency_id    ';
		///and object_type not in (122,104)过滤掉折扣的信息~！
		$list = _formatList($this->db->query($sql));
		if (is_array($list['list'])){
			foreach ((array)$list['list'] as $key=>$row) {
				$note	.=	' '.$row['currency_no'].':'.$row['dml_money'];
			}
		}else{
			$note	=	0;
		}

		$return['note']		=	$note;
		return $return;
	}

	/**
	 * 	今日欠款金额
	 *
	 */
	public function todayArrearage(){
		///权限验证
		if (self::checkRights(__FUNCTION__)===false){ return ; }

		$sql	=	'SELECT currency_id,sum(income_type*should_paid*-1) AS money
		FROM client_paid_detail
		WHERE 1 and paid_date=CURDATE() and currency_id is not null
		GROUP BY currency_id    ';
		$list = _formatList($this->db->query($sql));
		if (is_array($list['list'])){
			foreach ((array)$list['list'] as $key=>$row) {
				$note	.=	' '.$row['currency_no'].':'.$row['dml_money'];
			}
			$return['note']		=	$note;
		}else{
			$return['note']		=	0;
		}
		return $return;
	}

	/**
	 * 	今日应收款总金额
	 *
	 */
	public function todayClient(){
		///权限验证
		if (self::checkRights(__FUNCTION__)===false){ return ; }
		$sql	=	'select currency_id,sum((need_paid)*income_type*-1) as money
				from client_paid_detail
				where currency_id is not null and is_close=0 and need_paid!=0
				group by currency_id  having(sum((should_paid)*income_type*-1)!=0)
				order by currency_id';
		///date(paid_date)=CURDATE() and
		$list = _formatList($this->db->query($sql));
		if (is_array($list['list'])){
			foreach ((array)$list['list'] as $key=>$row) {
				$note	.=	' '.$row['currency_no'].':'.$row['dml_money'];
			}
			$return['note']		=	$note;
		}else{
			$return['note']		=	0;
		}
		return $return;
	}

	/**
	 * 	今日应付款总金额
	 *
	 */
	public function todayFactory(){
		///权限验证
		if (self::checkRights(__FUNCTION__)===false){ return ; }

		$sql	=	'select currency_id,-sum(need_paid*income_type) as money
				from factory_paid_detail
				where   1  and is_close=0 and need_paid!=0
				group by currency_id having sum(need_paid*income_type) !=0
				order by currency_id ';
		///and date(paid_date)=CURDATE()
		$list = _formatList($this->db->query($sql));
		if (is_array($list['list'])){
			foreach ((array)$list['list'] as $key=>$row) {
				$note	.=	' '.$row['currency_no'].':'.$row['dml_money'];
			}
			$return['note']		=	$note;
		}else{
			$return['note']		=	0;
		}
		return $return;
	}

	/**
	 * 	今日应付款总金额
	 *
	 */
	public function todayLogistics(){
		///权限验证
		if (self::checkRights(__FUNCTION__)===false){ return ; }
		$sql	=	'select currency_id,-sum(need_paid*income_type) as money
				from logistics_paid_detail
				where   1  and is_close=0 and need_paid!=0
				group by currency_id having sum(need_paid*income_type) !=0
				order by currency_id ';
		///and date(paid_date)=CURDATE()
		$list = _formatList($this->db->query($sql));
		if (is_array($list['list'])){
			foreach ((array)$list['list'] as $key=>$row) {
				$note	.=	' '.$row['currency_no'].':'.$row['dml_money'];
			}
			$return['note']		=	$note;
		}else{
			$return['note']		=	0;
		}
		return $return;
	}


	/**
	 * 订货单
	 *
	 * @param int $dept_id
	 * @return array
	 */
	public function orderList() {
		///权限验证
		if (self::checkRights(__FUNCTION__)===false){ return ; }
		$sql	=	'SELECT a.id,factory_id,order_date,expect_date,sum(quantity) as quantity
						FROM orders a INNER JOIN order_details b ON a.id = b.orders_id
						WHERE 1 and order_state in (0,1)
						 and expect_date<=DATE_ADD(CURDATE(),INTERVAL '.C('REMIND_VALUE_ORDER').' DAY)
						group by a.id
						LIMIT '.$this->limit;
		///and expect_date>=CURDATE()
		$today 			= formatDate(date('Y-m-d'));
		$to_date 		= formatDate(date("Y-m-d",mktime(0, 0, 0, date("m"), date("d")+C('REMIND_VALUE_ORDER'),   date("Y"))));
///		$list_link		= ('/spacedate2_from_expect_date/'.$today.'/spacedate2_to_expect_date/'.$to_date);
		$list_link		= ('/sp_date_lt_expect_date/'.$to_date.'/');
		$list = _formatList($this->db->query($sql));
		$list =	self::addLink(__FUNCTION__,$list,$list_link);
		return $list;
	}

	/**
	 * 入库提醒
	 *
	 * @param int $dept_id
	 * @return array
	 */
	public function instockList() {
		///权限验证
		if (self::checkRights(__FUNCTION__)===false){ return ; }
			$sql	=	'SELECT a.id AS id,a.load_container_no AS load_container_no,a.container_no AS container_no,a.logistics_id AS logistics_id, a.delivery_date AS delivery_date,a.expect_arrive_date AS expect_arrive_date,sum(quantity) AS quantity
			FROM load_container a LEFT JOIN load_container_details b ON a.id = b.load_container_id
			WHERE 1 and load_state=1
			 and expect_arrive_date<=DATE_ADD(CURDATE(),INTERVAL '.C('REMIND_VALUE_INSTOCK').' DAY)
			GROUP BY a.id
			ORDER BY a.load_container_no desc,a.container_no desc
			LIMIT '.$this->limit;
		///and expect_arrive_date>=CURDATE() and
		$today 			= formatDate(date('Y-m-d'));
		$to_date 		= formatDate(date("Y-m-d",mktime(0, 0, 0, date("m"), date("d")+C('REMIND_VALUE_INSTOCK'),date("Y"))));
///		$list_link		= ('/spacedate_from_expect_arrive_date/'.$today.'/spacedate_to_expect_arrive_date/'.$to_date); <br>
		$list_link		= ('/sp_date_lt_expect_arrive_date/'.$to_date.'');
		$list = _formatList($this->db->query($sql));
		$list =	self::addLink(__FUNCTION__,$list,$list_link);
		return $list;
	}


	/**
	 * 待配货提醒
	 *
	 * @param int $dept_id
	 * @return array
	 */
	public function preDeliveryList() {
		///权限验证
		if (self::checkRights(__FUNCTION__)===false){ return ; }
		$sql	=	'SELECT a.id AS id,a.sale_order_no AS sale_order_no,a.client_id AS client_id,a.basic_id AS basic_id,a.currency_id AS currency_id,a.order_date_format AS order_date,a.expect_shipping_date AS expect_shipping_date, sum(quantity) AS sum_quantity
		FROM sale_order a INNER JOIN sale_order_detail b ON a.id = b.sale_order_id
		WHERE 1 and sale_order_state=1
		 and expect_shipping_date<=DATE_ADD(CURDATE(),INTERVAL '.C('REMIND_VALUE_PREDELIVERY').' DAY)
		GROUP BY a.id
		ORDER BY a.sale_order_no desc
		LIMIT '.$this->limit;
		///and expect_shipping_date>=CURDATE()
		$today 			= formatDate(date('Y-m-d'));
		$to_date 		= formatDate(date("Y-m-d",mktime(0, 0, 0, date("m"), date("d")+C('REMIND_VALUE_PREDELIVERY'),date("Y"))));
///		$list_link		= ('/spacedate_from_expect_shipping_date/'.$today.'/spacedate_to_expect_shipping_date/'.$to_date);
		$list_link		= ('/sp_date_lt_expect_shipping_date/'.$to_date);
		$list = _formatList($this->db->query($sql));
		$list =	self::addLink(__FUNCTION__,$list,$list_link);
		return $list;
	}

	/**
	 * 待发货提醒
	 *
	 * @param int $dept_id
	 * @return array
	 */
	public function deliveryList() {
		///权限验证
		if (self::checkRights(__FUNCTION__)===false){ return ; }

		if (C('delivery.relation_predelivery')==1){///开启配货
			$sql	=	'SELECT a.id AS id,a.sale_order_no AS sale_order_no,date(a.order_date) AS order_date,a.client_id AS client_id,a.basic_id AS basic_id,a.id AS sale_order_id,a.sale_order_no AS orders_no,date(a.order_date) AS order_date ,a.expect_shipping_date as expect_shipping_date
		FROM sale_order as a
		WHERE 1 and a.sale_order_state=2
		 and expect_shipping_date<=DATE_ADD(CURDATE(),INTERVAL '.C('REMIND_VALUE_DELIVERY').' DAY)
		GROUP BY a.id
		ORDER BY a.sale_order_no desc
		LIMIT '.$this->limit;
		}else{
			$sql	=	'SELECT a.id AS id,a.sale_order_no AS sale_order_no,date(a.order_date) AS order_date,a.client_id AS client_id,a.basic_id AS basic_id,a.id AS sale_order_id,a.sale_order_no AS orders_no,date(a.order_date) AS order_date ,a.expect_shipping_date as expect_shipping_date
		FROM sale_order as a
		WHERE 1 and a.sale_order_state=1
		 and expect_shipping_date<=DATE_ADD(CURDATE(),INTERVAL '.C('REMIND_VALUE_DELIVERY').' DAY)
		GROUP BY a.id
		ORDER BY a.sale_order_no desc
		LIMIT '.$this->limit;
		}

///		$sql	=	'SELECT a.id AS id,a.pre_delivery_no AS pre_delivery_no,date(a.pre_delivery_date) AS pre_delivery_date,a.client_id AS client_id,a.basic_id AS basic_id,a.sale_order_id AS sale_order_id,a.orders_no AS orders_no,sum(b.quantity) AS quantity,date(c.order_date) AS order_date ,c.expect_shipping_date as expect_shipping_date
///		FROM pre_delivery a INNER JOIN pre_delivery_detail b ON a.id = b.pre_delivery_id LEFT JOIN sale_order c ON a.sale_order_id = c.id
///		WHERE 1 and sale_order_state=1
///		 and expect_shipping_date<=DATE_ADD(CURDATE(),INTERVAL '.C('REMIND_VALUE_DELIVERY').' DAY)
///		GROUP BY a.id
///		ORDER BY a.pre_delivery_no desc
///		LIMIT '.$this->limit;
		///and expect_shipping_date>=CURDATE()
		$today 			= formatDate(date('Y-m-d'));
		$to_date 		= formatDate(date("Y-m-d",mktime(0, 0, 0, date("m"), date("d")+C('REMIND_VALUE_DELIVERY'),date("Y"))));
///		$list_link		= ('/spacedate_from_expect_shipping_date/'.$today.'/spacedate_to_expect_shipping_date/'.$to_date);
		$list_link		= ('/sp_date_lt_expect_shipping_date/'.$to_date);
		$list = _formatList($this->db->query($sql));
		$list =	self::addLink(__FUNCTION__,$list,$list_link);
		return $list;
	}

	/**
	 * 客户待收款提醒
	 *
	 * @param int $dept_id
	 * @return array
	 */
	public function clientList() {
		///权限验证
		if (self::checkRights(__FUNCTION__)===false){ return ; }
		$sql	=	'SELECT  a.object_id as id,a.*,b.remind_day,DATE_ADD(paid_date,INTERVAL b.remind_day DAY) as remind_date,paid_date
		FROM client_paid_detail a LEFT JOIN company b ON a.comp_id = b.id and b.comp_type in (1,4) and b.to_hide=1
		WHERE 1   and object_type =120 and is_close=0 and need_paid>0
		and DATE_ADD(paid_date,INTERVAL '.C('REMIND_VALUE_CLIENT').' DAY)<= CURDATE()
		ORDER BY a.paid_date desc
		LIMIT '.$this->limit;
		$today 			= formatDate(date('Y-m-d'));
		$date			= new Date();
		$list_link		= ('/sp_date_lt_order_date/'.$date->dateAdd(-C('REMIND_VALUE_CLIENT')));
		$list = _formatList($this->db->query($sql));
		$list =	self::addLink(__FUNCTION__,$list,$list_link);
		return $list;
	}

	/**
	 * 厂家待付款提醒
	 *
	 * @param int $dept_id
	 * @return array
	 */
	public function factoryList() {
		///权限验证
		if (self::checkRights(__FUNCTION__)===false){ return ; }
		$sql	=	'SELECT  a.object_id as id,a.*,b.remind_day,DATE_ADD(paid_date,INTERVAL b.remind_day DAY) as remind_date,paid_date
		FROM factory_paid_detail a LEFT JOIN company b ON a.comp_id = b.id and b.comp_type=1 and b.to_hide=1
		WHERE 1  and object_type =220 and is_close=0 and need_paid>0
		and DATE_ADD(paid_date,INTERVAL '.C('REMIND_VALUE_FACTORY').' DAY)<=CURDATE()
		ORDER BY a.paid_date desc
		LIMIT '.$this->limit;
		$today 			= formatDate(date('Y-m-d'));
		$date			= new Date();
		$list_link		= ('/sp_date_lt_real_arrive_date/'.$date->dateAdd(-C('REMIND_VALUE_FACTORY')));
		$list = _formatList($this->db->query($sql));
		$list =	self::addLink(__FUNCTION__,$list,$list_link);
		return $list;
	}

	/**
	 * 物流待付款提醒
	 *
	 * @param int $dept_id
	 * @return array
	 */
	public function logisticsList() {
		///权限验证
		if (self::checkRights(__FUNCTION__)===false){ return ; }
		$sql	=	'SELECT  a.object_id as id,a.*,b.remind_day,DATE_ADD(paid_date,INTERVAL b.remind_day DAY) as remind_date,paid_date
		FROM logistics_paid_detail a LEFT JOIN company b ON a.comp_id = b.id and b.comp_type=2 and b.to_hide=1
		WHERE 1   and object_type =320 and is_close=0 and need_paid>0
		and DATE_ADD(paid_date,INTERVAL '.C('REMIND_VALUE_LOGISTICS').' DAY)<=CURDATE()
		ORDER BY a.paid_date desc
		LIMIT '.$this->limit;
		$today 			= formatDate(date('Y-m-d'));
		$date			= new Date();
		$list_link		= ('/sp_date_lt_real_arrive_date/'.$date->dateAdd(-C('REMIND_VALUE_LOGISTICS')));
		$list = _formatList($this->db->query($sql));
		$list =	self::addLink(__FUNCTION__,$list,$list_link);

		return $list;
	}

	/**
	 * 票据到期提醒
	 *
	 * @param int $dept_id
	 * @return array
	 */
	public function invoiceList() {
		 ///权限验证
		if (self::checkRights(__FUNCTION__)===false){ return ; }
		$sql	=	'SELECT id,bank_date,money,bill_no,due_date
		FROM `bank_center`
		WHERE 1 and bank_object_type=4 and paid_type=2 and to_hide=1 and state =1 and due_date is not null and due_date<>"0000-00-00"
		and due_date<=DATE_ADD(CURDATE(),INTERVAL '.C('REMIND_VALUE_INVOICE').' DAY)
		ORDER BY due_date asc
		LIMIT '.$this->limit;
		///and bank_date>=CURDATE()
		$today 			= formatDate(date('Y-m-d'));
		$to_date 		= formatDate(date("Y-m-d",mktime(0, 0, 0, date("m"), date("d")+C('REMIND_VALUE_INVOICE'),date("Y"))));
///		$list_link		= ('/spacedate2_from_due_date/'.$today.'/spacedate2_to_due_date/'.$to_date);
		$list_link		= ('/sp_date_lt_due_date/'.$to_date);
		$list = _formatList($this->db->query($sql));
		$list =	self::addLink(__FUNCTION__,$list,$list_link.'/sp_query_state/1');
		return $list;
	}

	/**
	 * 待审核提醒
	 *
	 * @param int $dept_id
	 * @return array
	 */
	public function auditList() {
		return true;
		///权限验证
		if (self::checkRights(__FUNCTION__)===false){ return ; }

		$doc_type	= $this->getDocType(getRegistry('CHECK_RIGHT_RESULT'));
		$where	=	' 1 ';
		if (!IS_ADMIN && !SUPER_ADMIN){	/// 普通用户需限制单据类型
			$where.= ' and doc_type in ('.implode(',', array_keys($doc_type)).')';
		}

		$sql	=	'SELECT a.id AS id,a.doc_id AS doc_id,a.doc_no AS doc_no,a.doc_type AS doc_type,a.doc_date AS doc_date,a.add_user AS add_user,a.edit_user AS edit_user, IFNULL(audit_state,1) AS audit_state
		FROM audit a LEFT JOIN audit_detail b ON a.id = b.audit_id and b.expire=0
		WHERE '.$where.' and (audit_state is null or audit_state=1)
		GROUP BY a.id
		ORDER BY a.doc_type ASC,a.doc_no asc
		LIMIT '.$this->limit;
		$list = _formatList($this->db->query($sql));
		$list =	self::addLink(__FUNCTION__,$list);
		$doc_type	= $this->getDocType(getRegistry('CHECK_RIGHT_RESULT'));
		$type_link	=	array(
								1=>'Orders/view/id/',
								2=>'LoadContainer/view/id/',
								3=>'SaleOrder/view/id/',
								4=>'PreDelivery/view/id/',
								);
		foreach ($list['list'] as $key => $value_list) {
			$list['list'][$key]['link']			=	U($type_link[$value_list['doc_type']].$value_list['doc_id']);
			$list['list'][$key]['dd_doc_type']	=	$doc_type[$value_list['doc_type']];
		}
		return $list;
	}

		/// 生成单号数据
	protected function getDocType() {
		$doc_type = C('AUDIT_TYPE_MODEL');
		if (IS_ADMIN || SUPER_ADMIN) {/// 超管或管理员
			foreach ($doc_type as $k => $type) {
				if (C('AUDITOR_'.strtoupper($type))) { /// 配置中是否开启
					$new_doc_type[$k] = L('doc_'.strtolower($type));
				}
			}
		} else { /// 普通用户
			foreach ($doc_type as $k => $type) {
				if (C('AUDITOR_'.strtoupper($type))) { /// 配置中是否开启及是否有权限
					$rights =  A('Rights')->checkRights($type,'audit');
					$rights['data_right'] && $new_doc_type[$k] = L('doc_'.strtolower($type));
				}
			}
		}
		return $new_doc_type;
	}

	/**
	 * 增加查看/更多的链接地址
	 *
	 * @param string $name
	 * @param array $list
	 * @return array
	 */
	public function addLink($name,&$list,$list_link=null){
		$remind	=	$this->remind_info;
		if (isset($remind[$name]['view_value'])){
				$linkFields	=	explode(',',$remind[$name]['view_value']);
				foreach ((array)$linkFields as $keya=>$rowa) {
					$field[]	=	explode(':',$rowa);
				}
		}
		$model_split	=	explode(',',$remind[$name]['view']);
		$model			=	explode('/',$model_split[0]);
		///查看链接
		foreach ((array)$list['list'] as $key=>$row) {
			if (is_array($field)){
				foreach ((array)$field as $keyb=>$rowb) {
					$join[]	=	'/'.$rowb[0].'/'.$row[$rowb[1]];
				}
			}else{
				$join[]	=	'/id/'.$row['id'];
			}
			$list['list'][$key]['link']	=	U($remind[$name]['view'].join('',$join));
			unset($join);
		}
		///更多链接
		if (isset($remind[$name]['list_value'])){
				$linkFields	=	explode(',',$remind[$name]['list_value']);
				foreach ((array)$linkFields as $keya=>$rowa) {
					$field	=	explode(':',$rowa);
					$join[]	=	'/'.$field[0].'/'.$row[$field[1]];
				}
		}
		if (is_array($join)){
			$list['total']['more_link']		=	U('/'.$remind[$name]['list'].join('/',$join).$list_link);
		}else{
			$list['total']['more_link']		=	U('/'.$remind[$name]['list'].$list_link);
		}
		///title的名称
		$list['total']['link_name']			=	title('view',ucfirst($model[0]));
		$list['total']['more_link_name']	=	title($model[1],ucfirst($model[0]));
		return $list;
	}

	/**
	 * 权限验证
	 *
	 * @param string $name
	 * @return bool
	 */
	public function checkRights($name){
		return true;
		if (SUPER_ADMIN) { /// 超管
			$this->remind_right	=	S(APP_NAME."_ALL_RIGHTS_AD");
    	} else if (IS_ADMIN){
    		$this->remind_right	=	S(APP_NAME."_ALL_RIGHTS_AD");
    	} else { /// 非超管
    		$role_right	=	S(APP_NAME."_ALL_RIGHTS_".ROLE_ID);
    		$this->remind_right	=	$role_right['rights'];
    	}
		$remind	=	$this->remind_info;
		if (isset($remind[$name]['right'])){
			$rights		=	explode(',',$remind[$name]['right']);
			$check_true	=	false;
			$all_rights	=	array_flip($this->remind_right);
			foreach ((array)$rights as $key=>$row) {
				if (isset($all_rights[$row])){
					$check_true	=	true;
					break;
				}
			}
			return $check_true;
		}else{
			return true;
		}
	}

	/**
	 * 需求修改后，对数据进行重新整合
	 *
	 * @param array $info
	 */
	public function resetData($info) {
		$list = array();
		$total_info    =   $this->total_info;
		foreach ((array)$info as $key => $value) {
			$total	= count($value['list']);
            //数量为出库批次中小包退货数量之和 added by yyh 20150924
            if($key == 'transfer'){
                foreach($value['list'] as $v){
                    $out_batch_id[$v['id']] = $v['id'];
                }
                $out_batch_id[] = 0;
                $total			= M('out_batch_detail')
								->join(' a left join pack_box_detail b on a.pack_box_id=b.pack_box_id
									left join return_sale_order_storage_detail c on b.return_sale_order_id=c.return_sale_order_id')
								->where('a.out_batch_id in ('.  implode(',', $out_batch_id).')')
								->field('sum(c.quantity) as sum_quantity')
								->getField('sum_quantity');
            }

            //数量为退货入库数量之和 added by yyh 20150924
            if($key == 'returnStorageOut'){
                foreach($value['list'] as $v){
                    $return_storage_id[$v['id']] = $v['id'];
                }
                $return_storage_id[]	= 0;
                $total					= M('return_sale_order_storage_detail')
										->where('return_sale_order_storage_id in ('.  implode(',', $return_storage_id).')')
										->field('sum(quantity) as sum_quantity')
										->getField('sum_quantity');
            }
			//提醒数量要求为产品数量        add by lxt 2015.09.24
			if (isset($total_info[$key])){
			    $total =   $value['total'][$total_info[$key]] ? $value['total'][$total_info[$key]] : $total;
			}
			if ($total > 0) {
				$list[$key] = array(
						'caption' 		=> L($key.'_remind'),
						'total' 		=> $total,
						'link_url'		=> $value['total']['more_link'],
						'link_title'	=> L($key.'_remind'),
				);
			}
		}
		return $list;
	}


	/**
	 * 卖家待审核提醒
	 * @author jp 20140310
	 * @param int $dept_id
	 * @return array
	 */
	public function auditFactoryList() {
		///权限验证
		if (self::checkRights(__FUNCTION__)===false){ return ; }
		$to_hide	= 2;//1正常， 2作废/待审核
		$comp_type	= 1;//1卖家，2物流公司， 3其他往来单位
		$sql	=	'SELECT id FROM company WHERE to_hide='.$to_hide.' and comp_type='.$comp_type;
		$list_link		= ('/to_hide/' . $to_hide);
		$list = _formatList($this->db->query($sql));
		$list =	self::addLink(__FUNCTION__,$list,$list_link);
		return $list;
	}

	/**
	 * 交接提醒
	 * @author yyh 20150924
	 * @return array
	 */
	public function transferList() {
		///权限验证
		if (self::checkRights(__FUNCTION__)===false){ return ; }
        $before_create_time = workDaysDate(time(),10);
		$sql	=	'SELECT a.id FROM out_batch a
                    left join out_batch_detail b on b.out_batch_id=a.id
                    left join pack_box c on b.pack_box_id=c.id
                    where c.is_aliexpress='.C('SELECT_YES').' and date(a.create_time)<="'.$before_create_time.'" and a.is_associate_with='.C('NO_ASSOCIATE_WITH');
		$list = _formatList($this->db->query($sql));
		$list_link		= ('/to_create_time/'.$before_create_time.'/is_associate_with/'.C('NO_ASSOCIATE_WITH'));
		$list =	self::addLink(__FUNCTION__,$list,$list_link);
		return $list;
	}

	/**
	 * 退货出库提醒
	 * @author yyh 20150924
	 * @return array
	 */
	public function returnStorageOutList() {
		///权限验证
		if (self::checkRights(__FUNCTION__)===false){ return ; }
        $before_create_time = workDaysDate(time(),10);
		$sql	=	'SELECT distinct a.id FROM return_sale_order_storage a
                    left join return_sale_order c on a.return_sale_order_id=c.id
                    left join state_log b on c.id=b.object_id and b.object_type='.array_search('ReturnSaleOrder', C('STATE_OBJECT_TYPE')).' and b.state_id='.C('RETURN_FOR_DELIVERY').'
                    where c.factory_id='.C('CAINIAO_FACTORY_ID').' and date(b.create_time)<="'.$before_create_time.'" and c.return_sale_order_state in ('.C('RETURN_SALE_ORDER_STATE_NO_OUT').')';
		$list = _formatList($this->db->query($sql));
		$list_link		= ('/to_create_time/'.$before_create_time.'/is_out_batch/'.C('NO_OUT_BATCH'));
		$list =	self::addLink(__FUNCTION__,$list,$list_link);
		return $list;
	}

	//当日待签收提醒          add by lxt 2015.09.24
	public function todayWithoutSigned(){
	    ///权限验证
	    if (self::checkRights(__FUNCTION__)===false){ return ; }

	    $sql   =   'select b.id,sum(a.quantity) as quantity from return_sale_order_detail a left join return_sale_order b on b.id=a.return_sale_order_id
	                where b.return_sale_order_state='.C('RETURN_SALE_ORDER_STATE_WAIT_RETURN_WAREHOUSE').' and b.factory_id='.C('CAINIAO_FACTORY_ID').' and b.return_order_date=curdate() group by b.id';

	    $list  =   _formatList($this->db->query($sql));

	    $list_link =   ('/return_sale_order_state/'.C('RETURN_SALE_ORDER_STATE_WAIT_RETURN_WAREHOUSE').'/factory_id/'.C('CAINIAO_FACTORY_ID').'/return_order_date/'.date('Y-m-d'));

	    $list  =   self::addLink(__FUNCTION__, $list,$list_link);

	    return $list;
	}

	//签收异常提醒       add by lxt 2015.09.24
	public function abnormalReturn(){
	    ///权限验证
	    if (self::checkRights(__FUNCTION__)===false){ return ; }

	    $sql   =   'select b.id,sum(a.quantity) as quantity from return_sale_order_detail a left join return_sale_order b on b.id=a.return_sale_order_id
	                where b.return_sale_order_state='.C('REFUSE').' and b.factory_id='.C('CAINIAO_FACTORY_ID').' group by b.id';

	    $list  =   _formatList($this->db->query($sql));

	    $list_link =   ('/return_sale_order_state/'.C('REFUSE').'/factory_id/'.C('CAINIAO_FACTORY_ID'));

	    $list  =   self::addLink(__FUNCTION__, $list,$list_link);

	    return $list;
	}

	//待卖家处理意见提醒        add by lxt 2015.09.24
	public function waitForFactory(){
	    ///权限验证
	    if (self::checkRights(__FUNCTION__)===false){ return ; }

	    $sql   =   'select a.id,sum(b.quantity) as quantity from return_sale_order_storage a left join return_sale_order_storage_detail b on a.id=b.return_sale_order_storage_id
	                left join return_sale_order c on c.id=a.return_sale_order_id where c.factory_id='.C('CAINIAO_FACTORY_ID').' and a.only_pic=1 group by a.id';

	    $list  =   _formatList($this->db->query($sql));

	    $list_link =   ('/only_pic/1/factory_id/'.C('CAINIAO_FACTORY_ID'));

	    $list  =   self::addLink(__FUNCTION__, $list,$list_link);

	    return $list;
	}

	//充值提醒        add by lml 2015.12.28
	public function rechargeList($company_id=null){
	    ///权限验证
	    if (self::checkRights(__FUNCTION__)===false){ return ; }
		
		$client_currency      = C('CLIENT_CURRENCY') ? M('Currency')->where('id in (' . C('CLIENT_CURRENCY') . ')')->getField('id, lower(currency_no) as currency_no') : array();

        $money = 'round(need_paid, ' . C('MONEY_LENGTH') . ')*income_type*-1';
        $where = 'is_close=0';
        if (getUser('role_type')==C('SELLER_ROLE_TYPE')) {
            $where .= ' and comp_id='.intval(getUser('company_id'));
        }
        !empty($company_id) && $where .= ' and comp_id='.$company_id;
        $having = 'having(total_need_paid!=0)';
        $sql_field 		= 'select sum('.$money.') as total_need_paid '.D('AbsStat')->fundsField().', currency_id,comp_id
                        from client_paid_detail
                        where '.$where.'';
        $sql_group		= ' group by comp_id,currency_id,basic_id '.$having.'
                                order by comp_id,currency_id,basic_id,paid_id asc ';
        $sql			= $sql_field.$sql_group;
        $list=$this->db->query($sql);
        if($company_id>0){
            return $list;
        }
        foreach((array)$list as $val){
            $comp_id[]      = $val['comp_id'];		    
        }
		if($comp_id){
		$comp_id=array_unique($comp_id);
		$arr=array();
		$factory_data = M('company')->where('comp_type=1 and id in ('.implode(',', $comp_id).')')->order('id')->getField('id,warning_balance_rmb,warning_balance_euro,warning_balance_usd,warning_balance_gbp,warning_balance_hkd,warning_balance_aed');
		foreach($list as $key=>&$temp_row ){
			if(isset($factory_data[$temp_row['comp_id']])){
				if($temp_row['total_need_paid']> -$factory_data[$temp_row['comp_id']]['warning_balance_'.$client_currency[$temp_row['currency_id']]]){
					$arr[$key][]=$temp_row['total_need_paid'];
				}
			}			
		}
		unset($temp_row);
		$list=_formatList($arr);
		}else {
			return ;
		}
	    $list_link =   ('/flag/1');
	    $list  =   self::addLink(__FUNCTION__, $list,$list_link);
	    return $list;
	}

	//未读消息提醒
	public function messageUnread(){
		  ///权限验证
	    if (self::checkRights(__FUNCTION__)===false){ return ; }

		$user_type = getUser('user_type');

		$where ='  is_announced=1 and  FIND_IN_SET('.$user_type.',user_type)';
 
		$sql='SELECT m.id  FROM `message`  m
				left join message_state_log l on l.message_id=m.id and l.user_id='.getUser('user_id').' where '.$where.' and l.message_id is null ';

	    $list  =   _formatList($this->db->query($sql));

	    $list_link =   ('/is_read/2/');

	    $list  =   self::addLink(__FUNCTION__, $list,$list_link);
	    return $list;

	}

	//签收未上架提醒（入库提醒）        add by lxt 2015.09.24
	public function signedWithoutStorage(){
	    ///权限验证
	    if (self::checkRights(__FUNCTION__)===false){ return ; }

	    $check_date    =   workDaysDate(time(), 2);

	    $sql   =   'select b.id,sum(a.quantity) as quantity from return_sale_order_detail a left join return_sale_order b on b.id=a.return_sale_order_id
	                where b.return_sale_order_state='.C('SIGNED').' and b.factory_id='.C('CAINIAO_FACTORY_ID').' and return_order_date<="'.$check_date.'" group by b.id';

	    $list  =   _formatList($this->db->query($sql));

	    $list_link =   ('/return_sale_order_state/'.C('SIGNED').'/factory_id/'.C('CAINIAO_FACTORY_ID').'/lt_return_order_date/'.$check_date);

	    $list  =   self::addLink(__FUNCTION__, $list,$list_link);

	    return $list;
	}

}
?>