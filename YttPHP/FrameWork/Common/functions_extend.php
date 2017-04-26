<?php

/**

 * Think 标准模式公共函数库(3.0ytt开始增加的部分)
 * @category   Think
 * @package  Common
 * @author   liu21st <liu21st@gmail.com>
 * @version  $Id$
 */

	/**
	 * 格式化成欧洲金额(意大利)
	 *
	 * @param string $money
	 * @param int $flag 1 入库，0 输出
	 * @return string $length
	 * @return string $partition 分隔符 是否有分隔符
	 */
	function moneyFormat($money,$flag=0,$length=2,$partition=true){
		if (empty($length) || $length<=0 || is_array($length)){
			$length		=	0;
		}
		/// 通过$flag判断是入库还是输出，入库时所有数字转为000.00的格式，输出时所有数字转成000.000,00格式
		switch ($flag){
			case 0:
				///是否带分隔符
				if ($partition){
					///					if(C('digital_format')=='zh') {
					$money	= number_format($money, $length);
					///					} else {
					///						$money 	= number_format($money,$length, ',', '.');
					///					}
				}else{
					///					if(C('digital_format')=='zh') {
					$money	= number_format($money,$length,'.', '');
					///					} else {
					///						$money 	= number_format($money,$length,',', '');
					///					}
				}
				break;
			case 1:///入库操作
			/// 判断用户是哪种输入格式，如是欧洲金额格式则转换成中文格式
			$money = str_replace(',','.',$money);
			break;
			case 2:
				if (strpos($money,'.')){ $money = str_replace('.',',',$money);	}
				break;
		}

		return $money;
	}

	/**
	 *  对查询结果集进行排序
	 *
	 * @access    public
	 * @param     array     $list 查询结果
	 * @param     string    $field 排序的字段名
	 * @param     array     $sortby 排序类型
	 *            asc正向排序 desc逆向排序 nat自然排序
	 * @return    array
	 */
	function list_sort_by($list, $field, $sortby='asc') {
		if(is_array($list)){
			$refer = $resultSet = array();
			foreach ($list as $i => $data)
			$refer[$i] = &$data[$field];
			switch ($sortby) {
				case 'asc': /// 正向排序
				asort($refer);
				break;
				case 'desc':/// 逆向排序
				arsort($refer);
				break;
				case 'nat': /// 自然排序
				natcasesort($refer);
				break;
			}
			foreach ( $refer as $key=> $val)
			$resultSet[] = &$list[$key];
			return $resultSet;
		}
		return false;
	}

	/**
	 * 将提交的数据进行html格式编码
	 * @param string $str 处理的字符串
	 * @return string
	 */
	function specConvertStr ($str,$separator = '<br>') {
		if (!C('DB_CHARSET')) {C('DB_CHARSET','utf8');}
		$str = htmlspecialchars($str,ENT_COMPAT,C('DB_CHARSET'));
		$str =str_replace("\n",$separator,$str);
		return $str;
	}

	/**
	 * 将提交的数据进行反html格式编码
	 * @param string $str
	 * @return string
	 */
	function specDeConvertStr ($str) {
		if (!C('DB_CHARSET')) {C('DB_CHARSET','utf8');}
		$str = str_replace("<br>",'',$str);
		$str = html_entity_decode($str,ENT_COMPAT,C('DB_CHARSET'));
		return $str;
	}

	/**
	 * 格式化数组(单个)
		 * @access public
		 * @Author 何剑波
	 * @param array $info	数组
	 * @param array $options	给参格式化的内容

	 * @return string
	 */
	function _formatArray($info,$options=null){
		///判断格式化信息的有效性
		if (empty($info)) {		return $info;	}
		$list[0]	=	$info;
		$new_list	=	_formatList($list,$options,0); 	///格式化信息
		return $new_list['list'][0];
	}

	/**
	 * 格式化数组(单个+组合明细)
	 *
	 * @param array $info
	 * @param array $detailKey
	 * @param array $options
	 * @return array
	 */
	function _formatListRelation($info,$detailKey=array('detail'),$options=null, $sum_flag = 1){
		$list = _formatArray($info);
		if (is_array($detailKey)){
			foreach ((array)$detailKey as $key=>$value) {
				if (is_string($key)){}
				$detailList		= _formatList($list[$value],$options,$sum_flag,'id');
				$list[$value]	= $detailList['list'];
				$list[$value.'_total']	= $detailList['total'];
			}
		}
		return $list;
	}

	/**
	 * 格式化数组(单个+组合明细) 仅用于发票
	 * @see _formatListRelation
	 * @param array $info
	 * @param string $detailKey
	 * @param array $options
	 * @return array
	 */
	function _formatListRelationForInvoice($info,$detailKey=array('detail'),$options=null){
		$list	= _formatListRelation($info,$detailKey,$options);
		///厂家来源配置为 独立厂家
		if(C('invoice.factory_from')==2){
			unset($list['factory_name']);
			unset($list['factory_iva']);
			$list	= _formatDdForInvoice('factory_id',$list,S('invoice_factory'));
		}
		///客户来源配置为 独立客户
		if(C('invoice.client_from')==2){
			unset($list['client_name']);
			unset($list['client_iva']);
			$list	= _formatDdForInvoice('client_id',$list,S('invoice_client'));
		}
		///公司来源配置为 独立公司
		if(C('invoice.company_from')==2){
			unset($list['basic_name']);
			$list	= _formatDdForInvoice('basic_id',$list,S('invoice_basic'));
		}
		///计算IVA
		$iva	= $list['iva']/100;
		foreach($detailKey as $_val){
			$dd	= S('invoice_product');
			if(!is_array($list[$_val])){
				continue;
			}
			foreach($list[$_val] as &$val){
				///配置为独立产品
				if(C('invoice.product_from')==2){
					unset($val['product_no']);
					unset($val['product_name']);
					$val	= _formatDdForInvoice('product_id',$val,$dd);
				}
				$total_money += $val['quantity']*$val['price']*(1-$val['discount']*0.01);
			}
			$list[$_val.'_total']['iva_cost']	= $iva*$total_money;
			$list[$_val.'_total']['total_cost']= round($total_money,2)+round($iva*$total_money,2);

			$format_money	= array('iva_cost','total_cost');
			$dml_money_leng	= array('iva_cost'=>'money_length','total_cost'=>'money_length');
			_format_money($format_money,$list[$_val.'_total'],$dml_money_leng);
		}
		return $list;
	}
	/**
	 * 格式化列表 仅用于发票
	 * @see _formatList
	 * @param array $info
	 * @param array $options
	 * @param int $sum_flag 判断是否需要统计合计 1 统计 0不统计
	 * @param int $groupByKey 判断是否需要统计合计 1 统计 0不统计
	 * @param array $expand
	 * @return array
	 */
	function _formatListForInvoice($info,$options=null,$sum_flag=1,$groupByKey=null,$expand=array()){
		$info	= _formatList($info,$options,$sum_flag,$groupByKey,$expand);
		$cache_factory	= S('invoice_factory');
		$cache_client	= S('invoice_client');
		$cache_basic	= S('invoice_basic');
		$cache_product	= S('invoice_product');
		foreach($info['list'] as &$val){
			if(C('invoice.product_from')==2&&isset($val['product_id'])){
				unset($val['product_no']);
				unset($val['product_name']);
				$val	= _formatDdForInvoice('product_id',$val,$cache_product);
			}
			if(C('invoice.factory_from')==2&&isset($val['factory_id'])){
				unset($val['factory_name']);
				unset($val['factory_iva']);
				$val	= _formatDdForInvoice('factory_id',$val,$cache_factory);
			}
			if(C('invoice.client_from')==2&&isset($val['client_id'])){
				unset($val['client_name']);
				unset($val['client_iva']);
				$val	= _formatDdForInvoice('client_id',$val,$cache_client);
			}
			if(C('invoice.company_from')==2&&isset($val['basic_id'])){
				unset($val['basic_name']);
				$val	= _formatDdForInvoice('basic_id',$val,$cache_basic);
			}
			///		if(C('invoice.product_from')==2&&isset($val['product_id'])){
			///			$val	= _formatDdForInvoice('product_id',$val,$cache_product);
			///		}
		}
		return $info;

	}
	/**
	 * 发票格式化取缓存
	 * @param string $dd_id 缓存key
	 * @param array $list
	 * @param array $cache
	 * @return array
	 */
	function _formatDdForInvoice($dd_id,$list,$cache=array()){
		$info	= $cache[$list[$dd_id]];
		foreach($info as $key=>$val){
			$list[$key]	= $val;
		}
		return $list;
	}

	/**

	 * 格式化列表

	 * @access public
	 * @Author 何剑波

	 * @param array $info	需要格式化的数组
	 * @param array $options	给参格式化的内容
	 * @param int $sum_flag		判断是否需要统计合计 1 统计 0不统计
	 * @param int $groupByKey	判断是否需要统计合计 1 统计 0不统计
	 * @param int $expand	扩展字段 详见 _formatListExpand 方法
	 * 								$expand['sum_flag_key']		///合计的默认前缀
	 * 								$expand['unset_sum_key_fields']	///合计的默认前缀
	 * 								$expand['sum_group_by']	=	array('currency_id')	///根据不同币种或者对应的价进行合并 例如:currency_id 系统默认
	 *
	 *

	 * @return string
	 */
	function _formatList($info,$optionsKey=null,$sum_flag=1,$groupByKey=null,$expand=array(),$return_type='list'){
		G('ddFmtTime');
		if (empty($info)) {	return $info;}  ///判断格式化信息的有效性
		///初始化需要格式化的信息
		$expand['sum_group_by']	=	isset($expand['sum_group_by'])?$expand['sum_group_by']:array('currency_id');

		if(!empty($info))
		{
			$firstInfoArray	=	reset($info);
			///判断是否有记录第一次格式化的key的值 如果有直接读取内存中的 _format_first 历史的信息
			if ($optionsKey){
				///			echo '引用内存中的格式化信息';
				$_formatListCache	=	S('_formatList');
				if (empty($_formatListCache[$optionsKey])){
					///				echo '--本次第一次格式化,下次读取历史';
					$firstInfo						=	_format_first($firstInfoArray,$sum_flag);
					$info_cache_temp				=	$firstInfo['info_cache'];
					unset($firstInfo['info_cache']);
					$_formatListCache[$optionsKey]	=	$firstInfo;
					$firstInfo['info_cache']		=	$info_cache_temp;
					S('_formatList',$_formatListCache);
				}else{
					$firstInfo						=	$_formatListCache[$optionsKey];
					///获取最新的 DD 信息
					_format_first_cache($firstInfo);
				}
			}else {
				$firstInfo	=	_format_first($firstInfoArray,$sum_flag);
			}

			extract($firstInfo);
			if ($sum_flag){	$formatKey['count_product']=1; }///合计产品总数量

			///初始化内容
			$total_product 		= 0;	/// 产品总个数
			$total_product_temp = array();	/// 产品总个数记录缓存
			if (is_array($groupByKey)) {
				$groupByKey		= array_shift($groupByKey);
				$isMultiRecord	= true;
			} else {
				$isMultiRecord	= false;
			}

			foreach ($info as $key => $value) {
				/** 开始处理 数据的 转化 * */
				foreach ((array)$formatKey as $forKey => $forVal) {   /// 先循环判断 获取 这次数据中有没 需要转换的字段
					switch ($forKey){
						case 'count_product':
							if ($value['product_id']>0){ _format_count_product($value,$total_product_temp,$total_product); } /// 根据规格统计明细中的产品数量
							break;
						case 'date':
							///如果 有需要转换的 日期 字段
							_format_date($info_date,$value,$dateModel);
							break;
						case 'money':
							///格式化金额
							_format_money($info_money,$value,$info_money_dml_leng);
							break;
						case 'dd':
							///格式化DD
							_format_dd($value,$info_dd,$define_dd,$dd_split,$info_cache);
							break;
						case 'const':
							///如果 有需要转换的 字典 字段
							_format_const($info_const,$value,$info_cache,$info_const_relation);
							break;
						case 'sum':
							///合计字段
							_format_sum($value,$sum,$info_sum,$expand['sum_group_by']);
							break;
						case 'html':
							///格式化 备注等信息
							_format_html($info_html,$value);
							break;
					}
				}
				///按照$groupByKey的值给数组
				if (isset($value[$groupByKey])){
					if ($isMultiRecord === true) {
						$rs['list'][$value[$groupByKey]][]	= $value;
					} else {
						$rs['list'][$value[$groupByKey]]	= $value;
					}
				}elseif($return_type=='list'){
					$rs['list'][]	= $value;
				}else{
					$rs[$key] = $value;
				}
			} /// end for foreach ($info as $value)
		} /// end for if(!empty($info))
		///合计
		if ($sum_flag && is_array($sum)) {
			_format_total($info_sum,$sum,$rs,$total_product,$info_money_dml_leng,$expand['sum_group_by']);
		}///格式化合计字段内容
		G('endDdFmtTime');
		unset($info,$info_cache,$sum); ///内存注销变量 ///内存注销变量 ///内存注销变量
		return $rs;	///返回格式化完的数组信息
	}


	/**
	 * 根据object_id 与 object_type
	 * 返回相对应的链接
	 *
	 * @param array $list
	 * @param string $list_key
	 * @return array
	 */
	function _addFlowLink($list,$Lkey='list'){
		if (!is_array($list)){	return $list; }
		$linkModel	=	D('AbsStat');
		foreach ($list[$Lkey] as $key=> &$row) {  $linkModel->objectTypeCommentSubsidiary($row); }
		return $list;
	}

	/**
	 * _format_first_cache
	 *
	 * @param array $firstInfo
	 */
	function _format_first_cache(&$firstInfo){
		unset($firstInfo['info_cache']);
		foreach ((array)$firstInfo['info_dd'] as $key => $value) {   /// 先循环判断 获取 这次数据中有没 需要转换的字段
			$dd_name							=	$firstInfo['define_dd'][$value];
			$firstInfo['info_cache'][$dd_name]	=	S($dd_name);
		}
		foreach ((array)$firstInfo['info_const_relation'] as $key => $value) {   /// 先循环判断 获取 这次数据中有没 需要转换的字段
			$firstInfo['info_cache'][$key]	=	C($value);
		}
	}

	/**
	 * _format_first
	 *
	 * @param array $value
	 * @param array $sum_flag
	 * @return array
	 */
	function _format_first(&$value,&$sum_flag){
		$format				= array('dd', 'html', 'date', 'money', 'const');
		///求和统计
		if ($sum_flag) {
			$format[]		= 'sum';    ///读取需要 累加的字段 即是合计字段
		}
		foreach ($format as $format_key) {///读取需要 字典/转html/日期/金钱/常量格式化/合计 的字段
			$format_option	= 'define_' . $format_key;
			$$format_option	= S('dd_config_format_' . $format_key);
		}
		$formatKey			= array();///需要格式化的内容
		$dml			=	array(	1=>'money_length',	2=>'price_length',	3=>'int_length',	4=>'int',5=>'cube_length'	);	///数字小数位数 金额=>1,单价=>2,数量=>3

		$dd_split_quantity		= 0;	///字段中切割缓存的个数
		$dd_splits				= S('Dd_split');	///被切割字典类型
		$dd_split				= array_keys($dd_splits);

		foreach ($value as $key => $value_list) {   /// 先循环判断 获取 这次数据中有没 需要转换的字段
			if(in_array($key,$define_date)) {  ///判断是否 有需要转换的 日期 字段
				$info_date_count++;
				if ($info_date_count<2) {///初始化载入日期控件
					import("ORG.Util.Date");
					$dateModel				= new Date();
					$reInfo['dateModel']	= $dateModel;
				}
				$formatKey['date']=1;
				$reInfo['info_date'][]			=	$key;
				$reInfo['info_date_count']		=	$info_date_count;
				continue;
			}
			if(in_array($key,array_keys($define_dd))) {
				///判断是否 有需要转换的 字典 字段
                $Dd = S('Dd_split');
                if(!isset($Dd[$define_dd[$key]])){
                    $info_cache[$define_dd[$key]]	=	S($define_dd[$key]);
                }
				$reInfo['info_dd'][]			=	$key;
				$formatKey['dd']=1;
				continue;
			}
			if(in_array($key,array_keys($define_const))) {
				///判断是否 有需要转换的 字典 字段
				$info_const[]	= $key;
				$info_cache[$key]	 								=	C(($define_const[$key]));
	//			$info_cache[strtolower($define_const[$key])]	 	=	C(($define_const[$key]));
				$reInfo['info_const'][]								=	$key;
				$reInfo['info_const_relation'][$key]				=	$define_const[$key];
				$formatKey['const']=1;
				continue;
			}
			if(in_array($key,array_keys($define_money))) {
				///判断是否 有需要转换的 金钱 字段， 因为金额可能要累加 合计 所以没有 continue;
				$reInfo['info_money'][]					=	$key;
				$reInfo['info_money_dml_leng'][$key]	=	$dml[$define_money[$key]];///数字小数位数 金额=>1,单价=>2,数量=>3
				$formatKey['money']=1;
			}
			///求和
			if($sum_flag && in_array($key,array_keys($define_sum))) {  ///判断是否是 累加的字段 即是合计字段
				$formatKey['sum']=1;
				$reInfo['info_sum'][]				=	$key;
				$reInfo['info_sum_dml'][]			=	$dml[$define_sum[$key]];
				continue;
			}
			if(in_array($key,$define_html)) {  ///判断是否是 转html 的字段
				$reInfo['info_html'][]	= $key;
				$formatKey['html']=1;
				continue;
			}
		}


		if (is_array($info_cache)){ $reInfo['info_cache']	=	$info_cache;}
		$reInfo['dml']					=	$dml;
		$reInfo['formatKey']			=	$formatKey;
		$reInfo['define_dd']			=	$define_dd;
		$reInfo['dd_split_quantity']	=	$dd_split_quantity;
		$reInfo['dd_splits']			=	$dd_splits;
		$reInfo['dd_split']				=	$dd_split;
		return $reInfo;
	}

	/**
	 * 格式化金额
	 *
	 * @param array $info_money
	 * @param double $value
	 * @param int $info_money_dml_leng
	 */
	function _format_money(&$info_money,&$value,&$info_money_dml_leng){
		///如果 有需要转换的 金钱 字段
		foreach ($info_money as $info_money_key=>$value_money) {
			$value['dml_'.$value_money]			= moneyFormat($value[$value_money],0,C($info_money_dml_leng[$value_money]));
			$value['edml_'.$value_money]		= moneyFormat($value[$value_money],0,C($info_money_dml_leng[$value_money]),false);
		}
	}

	/**
	 * 如果 有需要转html 字段
	 * 例如备注等
	 *
	 * @param array $info_html
	 * @param array $value
	 */
	function _format_html(&$info_html,&$value){
		///如果 有需要转html 字段
		foreach ($info_html as $value_html) {
			$value['edit_'.$value_html]		= ($value[$value_html]);
			$value[$value_html]				= specConvertStr($value[$value_html]);
		}
	}

	/**
	 * 格式化指定类型字典
	 *
	 * @param array $info_const
	 * @param array $value
	 * @param array $info_cache
	 * @param array $define_const
	 */
	function _format_const(&$info_const,&$value,&$info_cache,&$info_const_relation){
		if(!empty($info_const)) {
			foreach ($info_const as $value_dd) {
				$dd_array			=&$info_cache[$value_dd][$value[$value_dd]];  ///因为 优先级别，所以这里先 定义，然后再匹配
				if (!empty($dd_array)){
					$value['dd_'.$value_dd]	=	$dd_array;
				}
			}
		}
	}

	/**
	 * 根据规格统计明细中的产品数量
	 *
	 * @param array $value
	 * @param array $total_product_temp
	 * @param array $total_product
	 */
	function _format_count_product(&$value,&$total_product_temp,&$total_product){
		if ($value['product_id']>0 && !isset($total_product_temp[$value['product_id']])){
			$total_product_temp[$value['product_id']] = true;
			$total_product +=1;
		}
	}

	/**
	 * 格式化日期
	 *
	 * @param array $info_date
	 * @param array $value
	 */
	function _format_date(&$info_date,&$value,&$dateModel){
		foreach ($info_date as $value_date) {
			if (empty($value[$value_date])) {continue;}
			$value['fmd_'.$value_date]		= $dateModel->getFormat($value[$value_date]);
			///		$value['ltc_fmd_'.$value_date]	= 'class="t_center"';
		}
	}

	/**
	 * 格式化DD数组
	 *
	 * @param array $info
	 * @param array $define_dd
	 * @param array $dd_split
	 * @param array $info_cache
	 */
	function _format_dd(&$value,&$info_dd,&$define_dd,&$dd_split,&$info_cache){
		foreach ($info_dd as $value_dd) {
			///判断是否是切割的缓存字典
			if (in_array($define_dd[$value_dd],$dd_split) && $value[$value_dd]>0) {
				///判断是否已存在切割过的缓存字典
				$split_no		=	intval(($value[$value_dd]-1)/C('DD_SPLIT_LIMIT'));
				$split_name		=	$define_dd[$value_dd].'_'.$split_no;
				///判断切割过的ID是否已经取过切割后的字典
				if (empty($info_cache[$split_name])) {
					$info_cache[$split_name] = S($split_name);
				}
				$dd_array	=&$info_cache[$split_name];
			}else{
				$dd_array	=&$info_cache[$define_dd[$value_dd]];  ///因为 优先级别，所以这里先 定义，然后再匹配
			}
			if (is_array($dd_array[$value[$value_dd]])){
				$value	=	array_merge($value,$dd_array[$value[$value_dd]]) ;
			}
		}
	}

	/**
	 * 格式化统计
	 *
	 * @param array $info_sum
	 * @param array $sum
	 * @param array $rs
	 * @param array $total_product
	 */
	function _format_total(&$info_sum,&$sum,&$rs,&$total_product,$info_money_dml_leng,$groupBy){

		///格式化合计字段内容
		foreach ((array)$info_sum as $key=>$row) {
			$sum[$row]	= $sum[$row];
			$sum['dml_'.$row]	= moneyFormat($sum[$row],0,C($info_money_dml_leng[$row]));
		}
		///格式化各个币种的合计金额
		foreach ((array)$groupBy as $groupByValues) {
			!is_array($groupByValues) && $groupByValues	= explode(',', $groupByValues);
			$row		= implode('_', $groupByValues);
			$sum_key	= $row.'_sum';
			getDmlResult($sum, $sum[$sum_key], $groupByValues, $info_money_dml_leng, array('dml', $row));
		}
		$sum['total_product'] = $total_product;
		$rs['total']	= $sum;
	}

	/***
	 * 将多维数组转化为一维数组
	 *
	 * @author jph 20140521
	 * @param type $sum
	 * @param type $cur_sum
	 * @param type $groupByValues
	 * @param type $info_money_dml_leng
	 * @param type $key_arr
	 */
	function getDmlResult(&$sum, $cur_sum, $groupByValues,$info_money_dml_leng, $key_arr=array()){
		if (!empty($groupByValues)) {
			$groupByValue	= array_shift($groupByValues);
			foreach ($cur_sum as $sumk=>$sumv) {
				$key_arr[]	= $groupByValue == 'currency_id' ? strtolower(SOnly('currency', $sumk, 'currency_no')) : $sumk;
				getDmlResult($sum, $sumv, $groupByValues,$info_money_dml_leng, $key_arr);
				array_pop($key_arr);
			}
		} else {
			foreach ($cur_sum as $sumk=>$sumr) {
				$sum[implode('_', $key_arr).'_'.$sumk]	= moneyFormat($sumr,0,C($info_money_dml_leng[$sumk]));
			}
		}
	}


	/**
	 * 格式化合计部分(如果 有需要累加的字段  即是合计字段 )
	 *
	 * @param array $value
	 * @param array $sum
	 * @param array $info_sum
	 */
	function _format_sum(&$value,&$sum,&$info_sum,$groupBy=array('currency_id')){
		foreach ((array)$groupBy as $groupByValues) {
			!is_array($groupByValues) && $groupByValues	= explode(',', $groupByValues);
			foreach ($groupByValues as $groupByValue) {
				$$groupByValue	=	isset($value[$groupByValue])?$value[$groupByValue]:1;
			}
		}
		///判断是否需要合计
		foreach ((array)$info_sum as $value_sum) {
			$sum[$value_sum]	+= $value[$value_sum];
			foreach ((array)$groupBy as $groupByValues) {
				!is_array($groupByValues) && $groupByValues	= explode(',', $groupByValues);
				$sum_key			= implode('_', $groupByValues).'_sum';
				!isset($sum[$sum_key]) && $sum[$sum_key]	= array();
				$temp	= &$sum[$sum_key];
				foreach ($groupByValues as $groupByValue) {
					$next_key	= $$groupByValue;
					if (!isset($temp[$next_key])) {
						$temp[$next_key]	= array();
					}
					$temp	= &$temp[$next_key];
				}
				$temp[$value_sum]	+= $value[$value_sum];
				unset($temp);
			}
		}
	}


	/**
	 * 格式化数组
	 *
	 * @param array $data
	 * @param string  $key 多个用","分隔，最多两个 返回数组的key
	 * @param string  $value_key  多个用","分隔   返回数组的数据项key
	 * @author 邹燕娟
	 */
	function formatArray($data, $key = '', $value_key = '') {
		if (!is_array($data) || empty ($data)) {
			return false;
		}
		if ($value_key && strpos($value_key, ',')) {
			$value_key = explode(",", $value_key);
		}
		if (!strstr($key,",")) { /// key 为字符串
			foreach ($data as $k => $list) {
				$key_0 = $list[$key] ; /// 数组的键值
				if (!empty($value_key) && count($value_key) > 1) {
					foreach ($value_key as $v_key){
						$new_list[$key_0][$v_key] = $list[$v_key];
					}
				}elseif (!empty($value_key) && count($value_key)==1){
					$new_list[$key_0] = $list[$value_key];
				}
				else {
					$new_list[$key_0] = $list;
				}
			}
		} else {	/// key 为数组
			$key = explode(",",$key) ;
			foreach ($data as $k => $list) {
				$key_0 = $list[$key[0]]; /// 数组的键值
				$key_1 = $list[$key[1]]; /// 数组的键值
				if (!empty($value_key) && count($value_key) > 1) {
					foreach ($value_key as $v_key){
						$new_list[$key_0][$key_1][$v_key] = $list[$v_key];
					}
				} elseif (!empty($value_key) && count($value_key)==1){
					$new_list[$key_0] = $list[$value_key];
				}
				else {
					$new_list[$key_0][$key_1] = $list;
				}
			}
		}
		return $new_list;
	}

	/**
	 * 删除空值或0
	 *
	 * @param string $str
	 * @return $str
	 */
	function dml($str,$price_foramt=null){
		if ($price_foramt) {
			$str = moneyFormat($str,0,C('PRICE_LENGTH'));
		}else {
			$str = trim($str);
		}
		if (empty($str) || floatval($str)==0 || $str=='NaN') {
			return ;
		}
		return $str;
	}


	/**
	 * 更新字典缓存信息
	 *
	 * @param  int $id	 缓存索引值
	 * @param  int $table_id
	 * @param string $where 查询条件
	 * @param  int $time
	 * @return bool
	 */
	function cacheDd($id,$table_id,$where=null,$time=0){
		$id			=	intval($id);
		if ($id<=0 || in_array($id, C('CFG_NOT_CACHE_DD_NAME'))) { return false;	}
		$DdList		=	createCacheDd();
		$Dd			=	$DdList[$id];
		if (!is_array($Dd)) { return false;	}
		///字段
		$dd_value	=	explode(',',$Dd['dd_value']);
		$count		=	count($dd_value);
		if ($count<=0) { return false;	}
		$model		=	M($Dd['dd_table']);
		empty($where)	&&	$where=' 1 ';
		!empty($Dd['dd_where']) && $where		.=' and '.$Dd['dd_where'];
		///需要进行拆分
		if ($Dd['dd_split']==2) {
			///数组最大数量
			$max_limit		= C('DD_SPLIT_LIMIT');
			///单独更新拆分后的一个数组
			if ($table_id>0) {
				$split_count	=	intval($table_id/$max_limit);
				$limit 	='  and  id>'.($split_count)*$max_limit.' and id<='.(($split_count+1)*$max_limit).' ';
				PushCacheDd($model,$where.$limit,$Dd,$count,$dd_value,$Dd['dd_name'].'_'.$split_count,true,$limit,$time);
			}else{
				$sun_record = $model->where($where)->max('id'); ///总个数
				///拆分后的个数
				$split_count	=	intval($sun_record/$max_limit);
				for ($i = 0; $i <= $split_count; $i++) {
					if ($i==0) {
						$limit 	='  and  id<='.$max_limit;
					}else{
						$limit 	='  and  id>'.($i)*$max_limit.' and id<='.(($i+1)*$max_limit).' ';
					}
					PushCacheDd($model,$where.$limit,$Dd,$count,$dd_value,$Dd['dd_name'].'_'.($i),true);
				}
			}
		}else{
			$sun_record = $model->where($where)->count(); ///总个数
			if ($sun_record>10000) {ini_set('memory_limit', '512M');}
			PushCacheDd($model,$where,$Dd,$count,$dd_value,'','','',$time);
			return true;
		}
		return ;
	}


	/**
	 * 把字典压缩到内存
	 *
	 */
	function createCacheDd(){
		$dd_list	=	M('Dd')->select();
		$dd_split	=	array();
		foreach ((array)$dd_list as $row) {
			$dd[$row['id']]		=	$row;
			if ($row['dd_split']==2) {
				$dd_split[$row['dd_name']]	=	$row['id'];
			}
		}
		///压入内存
		S('Dd',$dd);
		///需要切割的字典名称
		S('Dd_split',$dd_split);
		return $dd;
	}


	/**
	 * 把信息压入内存
	 *
	 * @param object $model
	 * @param string $where
	 * @param array $Dd
	 * @param int $count
	 * @param string $dd_value
	 * @param string $dd_name
	 * @param bool $split
	 * @param array $limit
	 */
	function PushCacheDd($model,$where,&$Dd,&$count,&$dd_value,$dd_name='',$split=false,$limit=array(),$time){
		$Dd['dd_key']	=	trim($Dd['dd_key']);
		if(strpos($Dd['dd_key'],' as ')){
			$dd_key		= trim(end(explode(' as ',$Dd['dd_key'])));
		}else{
			$dd_key		= $Dd['dd_key'];
		}
		$list		=	$model->field($Dd['dd_key'].','.$Dd['dd_value'])->where($where)->order($dd_key)->select();
		///多维数组
		foreach ((array)$list as $key=>$row) {
			$info	=	array();
			$id			=	$row[$dd_key];
			unset($row[$dd_key]);
			$rs[$id]	=	$row;
			unset($info);
		}
		///判断数组是否存在
		if (is_array($rs)) {
			///字典名称
			$dd_name	= 	empty($dd_name)?$Dd['dd_name']:$dd_name;
			S($dd_name,$rs,$time);
			unset($rs);
		}else{
			S($dd_name, null);
		}
		return ;
	}

	/**
	 * 调试语句
	 *
	 * @param array $pathinfo
	 * @param string $echo
	 * @param bool $isexit
	 */
	function pr($info,$echo='',$isexit=0){
		echo $echo.'<br>';
		echo '开始输出测试-------------------<pre>';
		print_r($info);
		echo '结束输出测试-------------------<br>';
		if($isexit==1){
			exit;
		}
	}

	/**
	 * 对pathinfo格式字条串转数组
	 *
	 * @param array $pathinfo
	 * @return array
	 */
	function parsePathinfo($pathinfo){
		$var = array();
		$paths = explode('/',$_POST['id']);
		preg_replace('@(\w+)/([^\/]+)@e', '$var[\'\\1\']="\\2";', implode('/',$paths));
		return $var;
	}
	/**

		 * 获取页面传递来的查询条件

		 * @access public
		 * @Author 何剑波

		 * @return $default_where 默认的where条件
		 * @return $default 第一次载入附加的where条件

		 */
	function _search($default_where=null,$default=null){
		!empty($default_where)	&&	$where	=	' and '.$default_where;
		return getWhere($_POST,$default).$where;
	}

	/**
	 * 简化的_search传递什么查询什么
	 *
	 * @param array $array
	 * @return array
	 */
	function _search_array($array){
		return getWhere($array);
	}

	/**
	 * 特殊的get的URL整理成需要查询的post格式
	 *
	 * 例子: 	$get['sp_query_paid_date']	= 'abc';
				$get['sp_query_paid_date2']	= '123';
		结果:
			Array
			(
				[query] => Array
					(
						[paid_date] => abc
						[paid_date2] => 123
					)

			)
	 * @param array $list
	 */
	function _getSpecialUrl($get){
		foreach ($get as $key => $value) {
			if(substr($key,0,3) == 'sp_')
			{
				$array	=	explode('_',$key);
				if (count($array)>2){
					$name	=	str_replace($array[0].'_'.$array[1].'_','',$key);
					if (strpos($name,'__')) {
						$name	= str_replace('__','.',$name);
					}
					$info[$array[1]][$name]	= $value ;
				}
			}
		}
		return	$info;
	}

	/**
	 * 合并GET值至POST，同时返回查询条件
	 *
	 * @return  string
	 */
	function _getMergePostReturnWhere(){
		$array	= _getSpecialUrl($_GET);
		$where	= _search_array($array);
		if (is_array($array)){
			$_POST	=	array_merge($array,$_POST);
		}
		return $where;
	}

	//根据所属用户读取数据
	function getBelongsWhere($prefix = '', $field = 'factory_id'){
		if(getUser('role_type')!=C('SELLER_ROLE_TYPE')){
			return ' ';
		}
		!empty($prefix) && $field	= $prefix . '.' . $field;
		return intval($_SESSION['LOGIN_USER']['company_id'])>0?' and ' . $field . '='.$_SESSION['LOGIN_USER']['company_id']:'';
	}

	function getWarehouseWhere($prefix = '', $field = 'warehouse_id'){
		if(getUser('role_type')!=C('WAREHOUSE_ROLE_TYPE')){
			return ' ';
		}
		!empty($prefix) && $field	= $prefix . '.' . $field;
		return intval($_SESSION['LOGIN_USER']['company_id'])>0?' and ' . $field . '='.$_SESSION['LOGIN_USER']['company_id']:'';
	}
    //所属仓库包含退货不可再销售仓库
    function getAllWarehouseWhere($prefix = '', $field = 'warehouse_id'){
		if(getUser('role_type')!=C('WAREHOUSE_ROLE_TYPE')){
			return ' ';
		}
		!empty($prefix) && $field	= $prefix . '.' . $field;
        $warehouse_id   = M('warehouse')->where('is_return_sold='.C('NO_RETURN_SOLD').' and relation_warehouse_id='.$_SESSION['LOGIN_USER']['company_id'])->getField('id',true);
        $warehouse_id[] = $_SESSION['LOGIN_USER']['company_id'];
		return intval($_SESSION['LOGIN_USER']['company_id'])>0?' and ' . $field . ' in ('.implode(',', $warehouse_id).')':'';
	}

	/**
	 * 根据数组 调用不同条件，提取 SQL语句的 WHERE条件
	 *
	 * @param array $info
	 * @return string
	 */
	function getWhere($info,$default){
		global $_search_form;
		$_POST['ac_search'] && $_search_form = true;
		/// 合并default_post属性值与实际的POST值，实际POST优先级高
		if (is_array($default)) {
			$_POST = array_merge($default,$info);
		}
		$where	= ' 1 ';               ///WHERE 的初始化
		if(count($default['query']) > 0)    ///where的默认条件
		{
			foreach ($default['query'] as $fieldName => &$fieldValue) {

				if (!empty($fieldName) && $fieldValue!=NULL &&	empty($info['query'][$fieldName]) && !isset($info['query'][$fieldName]))
				{
					$fieldValue	= trim($fieldValue);
					if (empty($fieldValue) && $fieldValue != '0') {	continue;	}
					///					empty($fieldValue)	&& $fieldValue = 0;
					$where 	.= ' and '.$fieldName.'="'.$fieldValue.'" ';
					///POST转换将.替换成_
					if (strpos($fieldName,'.')) {
						$new_key = str_replace('.','_',$fieldName);
						unset($default['query'][$new_key]);
						$_POST['query'][$new_key]	=	$fieldValue;
					}
				}
			}
		}
		if(count($info['query']) > 0)    ///一般 WHERE条件的提取
		{
			foreach ($info['query'] as $fieldName => &$fieldValue) {
				if (is_array($fieldValue)){
					continue;
				}
				if ($fieldValue!=NULL && (!empty($fieldValue) || $fieldValue == '0')){
					if($fieldValue=='-2') continue;
					$where 	.= ' and '.$fieldName.'="'.$fieldValue.'" ';
					///POST转换将.替换成_
					if (strpos($fieldName,'.')) {
						$new_key = str_replace('.','_',$fieldName);
						unset($info['query'][$new_key]);
						$_POST['query'][$new_key]	=	$fieldValue;
					}
				}
			}
		}
        if(count($info['abs_query']) > 0)    ///一般 WHERE条件的提取 added by yyh 20150618
		{
			foreach ($info['abs_query'] as $fieldName => &$fieldValue) {
                    if (is_array($fieldValue)){
                        continue;
                    }
					$where 	.= ' and '.$fieldName.'="'.$fieldValue.'" ';
					///POST转换将.替换成_
					if (strpos($fieldName,'.')) {
						$new_key = str_replace('.','_',$fieldName);
						unset($info['abs_query'][$new_key]);
						$_POST['abs_query'][$new_key]   = $fieldValue;
                }
            }
        }
		if(count($info['strictless']) > 0)    ///小于
		{
			foreach ($info['strictless'] as $fieldName => &$fieldValue) {
				if (!empty($fieldName) && $fieldValue!=NULL)
				{
					$fieldValue	= trim($fieldValue);
					empty($fieldValue)	&& $fieldValue = 0;
					$where 	.= ' and '.$fieldName.'<"'.$fieldValue.'" ';
				}
			}
		}
		if(count($info['lessthan']) > 0)    ///小于等于
		{
			foreach ($info['lessthan'] as $fieldName => &$fieldValue) {
				if (!empty($fieldName) && $fieldValue!=NULL)
				{
					$fieldValue	= trim($fieldValue);
					empty($fieldValue)	&& $fieldValue = 0;
					$where 	.= ' and '.$fieldName.'<="'.$fieldValue.'" ';
				}
			}
		}
		if(count($info['notequal']) > 0)    ///不等于于
		{
			foreach ($info['notequal'] as $fieldName => &$fieldValue) {
				if (!empty($fieldName) && $fieldValue!=NULL)
				{
					$fieldValue	= trim($fieldValue);
					empty($fieldValue)	&& $fieldValue = 0;
					$where 	.= ' and '.$fieldName.'<>"'.$fieldValue.'" ';
				}
			}
		}
        if(count($info['abs_notequal']) > 0)    ///允许为空不等于 added by yyh 20150618
		{
			foreach ($info['abs_notequal'] as $fieldName => &$fieldValue) {
                $fieldValue	= trim($fieldValue);
                $where 	.= ' and '.$fieldName.'<>"'.$fieldValue.'" ';
			}
		}
		if(count($info['morethan']) > 0)    ///大于等于
		{
			foreach ($info['morethan'] as $fieldName => &$fieldValue) {
				if (!empty($fieldName) && $fieldValue!=NULL)
				{
					$fieldValue	= trim($fieldValue);
					empty($fieldValue)	&& $fieldValue = 0;
					$where 	.= ' and '.$fieldName.'>="'.$fieldValue.'" ';
				}
			}
		}
		if(count($info['greaterthan']) > 0)    ///大于
		{
			foreach ($info['greaterthan'] as $fieldName => &$fieldValue) {
				if (!empty($fieldName) && $fieldValue!=NULL)
				{
					$fieldValue	= trim($fieldValue);
					empty($fieldValue)	&& $fieldValue = 0;
					$where 	.= ' and '.$fieldName.'>"'.$fieldValue.'" ';
				}
			}
		}

        if(count($info['in']) > 0){//in
            foreach ($info['in'] as $fieldName => &$fieldValue) {
				if (!empty($fieldName) && $fieldValue!=null)
				{
                    if(is_array($fieldValue)){
                        $fieldValue = implode(',', $fieldValue);
                    }
					$where 	.= ' and '.$fieldName.' in ('.$fieldValue.') ';
				}
			}
        }
        if(count($info['is_null']) > 0){//是否为空(''和NULL) added by yyh 20150619
            foreach ($info['is_null'] as $fieldName => &$fieldValue) {
				if (!empty($fieldName))
				{
                    if($fieldValue){
                        $where 	.= ' and ('.$fieldName.'="" or '.$fieldName.' is null)';
                    }else{
                        $where 	.= ' and '.$fieldName.'<>""';
                    }
				}
			}
        }
		if(count($info['like']) > 0)   ///LIKE 语句的提取
		{
			foreach ($info['like'] as $fieldName => &$fieldValue) {
				if (!empty($fieldName) && $fieldValue!=null)
				{
					$where 	.= ' and '.$fieldName.' like "%'.$fieldValue.'%" ';
					///POST转换将.替换成_
					if (strpos($fieldName,'.')) {
						$new_key = str_replace('.','_',$fieldName);
						unset($info['query'][$new_key]);
						$_POST['like'][$new_key]	=	$fieldValue;
					}
				}
			}
		}
		///多个日期查询需要在页面中增加 date_key 几组日期的数量
		if ($info['date_key']>0) {
			for ($i = 1; $i <= $info['date_key']; $i++) {
				$info_key	 =	$i>1?$i:'';
				$where		.=	_getWhereDate($info,'date'.$info_key);
			}
		}else{
			$where	.=	_getWhereDate($info);
		}
		return $where;
	}
	/**
	 * 格式化日期格式，入库时格式化为：0000-00-00 显示时格式化为 00/00/00
	 * @param string $dateTime 要格式化的时间
	 * @param string $formatTo 将时间格式化为指定格式：date (Y-m-d) outdate 根据当格式转出 ,其它格式见:MyDate->format方法
	 * @return string
	 */
	function formatDate($dateTime,$formatTo='date'){
		///日期格式判断
		if(empty($dateTime) || $dateTime=='0000-00-00' || $dateTime=='0000-00-00 00:00:00'){
			return '';
		}
		if (strpos($dateTime,'/')){
			$arr_dateTime	=	explode(' ', $dateTime);
			$date_array = split('/',$arr_dateTime[0]);
			$year  		= $date_array[2];
			$month 		= $date_array[1];
			$date  		= $date_array[0];
			$dateTime 	= '20'.$year.'-'.$month.'-'.$date;
			$arr_dateTime[1] && $dateTime.= ' '.$arr_dateTime[1];
		}
		switch ($formatTo){
			case 'date':	///导入数据库
			$returnDate	=	$dateTime;
			break;
			case 'vf_date': /// 表单验证中的格式转换
			$dateTime	= substr($dateTime,0,10);
			$returnDate	= $dateTime;///.'-'.$dateTime[1].'-'.substr($dateTime[2],0,2);
			break;
			case 'mg_date': /// 表单验证中的格式转换
			$dateTime	= substr($dateTime,0,10);
			$returnDate	= $dateTime;///.'-'.$dateTime[1].'-'.substr($dateTime[2],0,2);
			$date_array = split('-',$returnDate);
			$returnDate	= substr(join('',$date_array),2,8);
			break;
			case 'outdate':	///导出日期格式化
			import("ORG.Util.Date");
			$dateModel	=	new Date();
			$returnDate	=	$dateModel->getFormat($dateTime);
			break;
		}
		return $returnDate;
	}

	/**
	 * 多个日期查询
	 *
	 * @param array $info
	 * @param string $info_key 日期下标KEY值
	 * @return string
	 */
	function _getWhereDate($info,$info_key='date'){
		$where	=	'';
		if(count($info[$info_key]) > 0)   ///日期 语句的提取
		{
			foreach ($info[$info_key] as $fieldName => &$fieldValue) {
				if (!empty($fieldName) && $fieldValue!=null)
				{
					$fieldValue		= formatDate($fieldValue,'date'); ///对日期格式化 存入数据库
					if (strpos($fieldName,'.')) {
						///POST转换将.替换成_
						$_POST['date'][str_replace('.','_',$fieldName)]	=	$fieldValue;
						$exp_date	=	explode('.',$fieldName);
						$fieldName	=	$exp_date[1];
						$fix_date	=	$exp_date[0].'.';
					}
					if(substr($fieldName,0,9) == 'needdate_') {
						$fieldName	= substr($fieldName,9);
						$needdate	= 1;
					} else {
						$needdate	= 0;
					}

					if(substr($fieldName,0,5) == 'from_')
					{
						$fromTo_fix_date= $fix_date;
						$fromTo_fileds	= $needdate	?	substr($fieldName,5)	:	substr($fieldName,5);
						$date_from		= $fieldValue;
					}
					else if(substr($fieldName,0,3) == 'to_')
					{
						$fromTo_fix_date= $fix_date;
						$fromTo_fileds	= $needdate	?	substr($fieldName,3)	:	substr($fieldName,3);
						$date_to	= $fieldValue;
					}
					else if(substr($fieldName,0,3) == 'mt_')   ///大于 该日期段
					{
						$fileds		= $needdate	?	substr($fieldName,3)	:	substr($fieldName,3);
						$where 		.= ' and '.$fix_date.$fileds.'>="'.$fieldValue.'" ';
					}
					else if(substr($fieldName,0,4) == 'mtt_')   ///大于 该日期段
					{
						$fileds		= $needdate	?	substr($fieldName,4)	:	substr($fieldName,4);
						$where 		.= ' and '.$fix_date.$fileds.'>"'.$fieldValue.'" ';
					}
					else if(substr($fieldName,0,3) == 'lt_')   ///小于 该日期段
					{
						$fileds		= $needdate	?	substr($fieldName,3)	:	substr($fieldName,3);
						$where 		.= ' and '.$fix_date.$fileds.'<="'.$fieldValue.' 23:59:59" ';
					}
					else if(substr($fieldName,0,4) == 'ltt_')   ///小于 该日期段
					{
						$fileds		= $needdate	?	substr($fieldName,4)	:	substr($fieldName,4);
						$where 		.= ' and '.$fix_date.$fileds.'<"'.$fieldValue.' 23:59:59" ';
					}
					else {
						$where 		.= ' and '.$fix_date.$fieldName.'="'.$fieldValue.'" ';
					}
				}
			}
			if($date_from  || $date_to){
				$fix_date	= $fromTo_fix_date;
				$fileds		= $fromTo_fileds;
				/*
				if (!in_array(MODULE_NAME,array('Orders','BankRemittance','BankLog','BankIni','StatOrder','EveryFundsDetail','BankSwap','Instock','InstockStorage')) && in_array($fileds,array('order_date','delivery_date','pre_delivery_date','return_order_date'))){
					$fileds	=	$fileds.'_format';
				}
				*/
				if($date_from && $date_to)   ///日期都存在
				{
					$where			.= ' and '.$fix_date.$fileds.'>="'.$date_from.'" and '.$fix_date.$fileds.'<="'.$date_to.' 23:59:59" ';
				}
				else
				{
					$date_from	?	$date	= $date_from : ($date_to	?	$date	= $date_to : $date = '-1');
					$where	.= ' and '.$fix_date.$fileds.'>="'.$date.'" and '.$fix_date.$fileds.'<="'.$date.' 23:59:59" ';
				}
			}
		}
		return $where;
	}


	/**
	 * 取随机数
	 *
	 * @param int $length 需要返回的随机数长度
	 * @return string
	 */
	function getRands($length=8){
		$str = 'a,b,c,d,e,f,g,h,i,j,k,l,m,n,o,p,q,r,s,t,u,v,w,x,y,z,';
		$str .= 'A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,Q,R,S,T,U,V,W,X,Y,Z,';
		$str .= '0,1,2,3,4,5,6,7,8,9';
		$all=explode(",",$str);
		$randy = '';
		for($i=0;$i<$length;$i++){
			$randy		 = rand(0,61);
			$randStr	.= $all[$randy];
		}
		return $randStr;
	}

	/**
	 * 通过scoket方式运程访问文件
	 *
	 * @param string $url  请求址
	 * @param int $limit  每次读取值大小
	 * @param String $post  POST参数
	 * @param String $cookie  cookie信息
	 * @param  bool $bysocket
	 * @param String $ip  远程地址
	 * @param int $timeout  超时时间
	 * @param bool $block  0是非阻塞，1是阻塞
	 * @return string
	 */
	function uc_fopen($url, $limit = 0, $post = '', $cookie = '', $bysocket = FALSE, $ip = '', $timeout = 15, $block = TRUE) {
		$return = '';
		$matches = parse_url($url);
		!isset($matches['host']) && $matches['host'] = '';
		!isset($matches['path']) && $matches['path'] = '';
		!isset($matches['query']) && $matches['query'] = '';
		!isset($matches['port']) && $matches['port'] = '';
		$host = $matches['host'];
		$path = $matches['path'] ? $matches['path'].($matches['query'] ? '?'.$matches['query'] : '') : '/';
		$port = !empty($matches['port']) ? $matches['port'] : 80;
		if($post) {
			$out = "POST $path HTTP/1.0\r\n";
			$out .= "Accept: */*\r\n";
			///$out .= "Referer: $boardurl\r\n";
			$out .= "Accept-Language: zh-cn\r\n";
			$out .= "Content-Type: application/x-www-form-urlencoded\r\n";
			$out .= "User-Agent: $_SERVER[HTTP_USER_AGENT]\r\n";
			$out .= "Host: $host\r\n";
			$out .= 'Content-Length: '.strlen($post)."\r\n";
			$out .= "Connection: Close\r\n";
			$out .= "Cache-Control: no-cache\r\n";
			$out .= "Cookie: $cookie\r\n\r\n";
			$out .= $post;
		} else {
			$out = "GET $path HTTP/1.0\r\n";
			$out .= "Accept: */*\r\n";
			///$out .= "Referer: $boardurl\r\n";
			$out .= "Accept-Language: zh-cn\r\n";
			$out .= "User-Agent: $_SERVER[HTTP_USER_AGENT]\r\n";
			$out .= "Host: $host\r\n";
			$out .= "Connection: Close\r\n";
			$out .= "Cookie: $cookie\r\n\r\n";
		}
		$fp = @fsockopen(($ip ? $ip : $host), $port, $errno, $errstr, $timeout);
		if(!$fp) {
			return '';///note $errstr : $errno \r\n
		} else {
			stream_set_blocking($fp, $block);
			stream_set_timeout($fp, $timeout);
			@fwrite($fp, $out);
			$status = stream_get_meta_data($fp);
			if(!$status['timed_out']) {
				while (!feof($fp)) {
					if(($header = @fgets($fp)) && ($header == "\r\n" ||  $header == "\n")) {
						break;
					}
				}

				$stop = false;
				while(!feof($fp) && !$stop) {
					$data = fread($fp, ($limit == 0 || $limit > 8192 ? 8192 : $limit));
					$return .= $data;
					if($limit) {
						$limit -= strlen($data);
						$stop = $limit <= 0;
					}
				}
			}
			@fclose($fp);
			return $return;
		}
	}

	/**
	 * 循环创建目录
	 *
	 * @param  string $dir
	 * @param  int $mode
	 * @return  bool
	 */
	function mk_dir($dir, $mode = 0777)
	{
		if (is_dir($dir) || @mkdir($dir,$mode)) return true;
		if (!mk_dir(dirname($dir),$mode)) return false;
		return @mkdir($dir,$mode);
	}


	/**
	 * 自动转换字符集 支持数组转换
	 *
	 * @param string $fContents
	 * @param  string $from
	 * @param  string $to
	 * @return  string
	 */
	function auto_charset($fContents,$from='gbk',$to='utf-8'){
		$from   =  strtoupper($from)=='UTF8'? 'utf-8':$from;
		$to       =  strtoupper($to)=='UTF8'? 'utf-8':$to;
		if( strtoupper($from) === strtoupper($to) || empty($fContents) || (is_scalar($fContents) && !is_string($fContents)) ){
			///如果编码相同或者非字符串标量则不转换
			return $fContents;
		}
		if(is_string($fContents) ) {
			if(function_exists('mb_convert_encoding')){
				return mb_convert_encoding ($fContents, $to, $from);
			}elseif(function_exists('iconv')){
				return iconv($from,$to,$fContents);
			}else{
				return $fContents;
			}
		}
		elseif(is_array($fContents)){
			foreach ( $fContents as $key => $val ) {
				$_key =     auto_charset($key,$from,$to);
				$fContents[$_key] = auto_charset($val,$from,$to);
				if($key != $_key )
				unset($fContents[$key]);
			}
			return $fContents;
		}
		else{
			return $fContents;
		}
	}

	function getLimit($count){
		$limit = _page($count);
		return _limit($limit);
	}

	/**
	 * 分页信息数组
	 *
	 * @param array $limit
	 * @return  string
	 */
	function _limit($limit){
		if(empty($limit)) return ;
		return ' limit '.$limit['firstRow'].','.$limit['listRows'];
	}
	/**
	 * 分页
	 *
	 * @param int $count
	 * @return array
	 */
	function _page($count,$listRows=null){
		if ($count > 0) {
			import("ORG.Util.Page");
			$listRows	= $listRows ? $listRows : !empty($_REQUEST ['listRows']) ? $_REQUEST ['listRows'] : '';
			///实例化分页对象
			$p = new Page ( $count, $listRows );
			///模型对象$options条件赋值

			///			foreach ((array)$options as $key=>$row) {
			///				if (in_array($key,array('sortBy'))) {continue;}
			///				$model->$key($row);
			///			}

			///获取列表信息->分页查询数据
			///			$voList = $model->order( "" . $order . " " . $sort)->limit($p->firstRow . ',' . $p->listRows)->select();
			$limit['firstRow']	=	$p->firstRow;
			$limit['listRows']	=	$p->listRows;
			///分页显示
			$page = $p->show ();
			///列表排序显示
			$sortImg 	= $sort; ///排序图标
			$sortAlt 	= $sort == 'desc' ? L('SORT_ASC') : L('SORT_DESC'); ///排序提示
			$sort 		= $sort == 'desc' ? 1 : 0; ///排序方式
			///			$assign_array = array();
			///			$assign_array = $voList;
			///模板赋值显示
			$view       = Think::instance('View');
			$view->assign ( 'sort', $sort );
			$view->assign ( 'order', $order );
			$view->assign ( 'sortType', $sortAlt );
			$view->assign ( "pageInfo", $p->getPageInfo());///分页信息
			$view->assign ( "page", $page );///页码
			///记录本次POST的值与SESSION
			/*import ( "@.ORG.Session" );
			$Session 		= 	new Session();   ///初始化分页对象
			$Session->setLocal('post_'.MODULE_NAME.'_'.ACTION_NAME,$_POST); ///设置本地化Session癿值
			$Session->set('_output_sql_',$model->getLastSql()); */
		}else{
			return false;
		}
		return	$limit;
	}

	/**

		 * 根据表单生成查询条件
		 * 进行列表过滤

		 * @access protected

		 * @param Model $model 数据对象
		 * @param HashMap $map 过滤条件
		 * @param string $sortBy 排序
		 * @param boolean $asc 是否正序

		 * @return void

		 * @throws ThinkExecption

		 */
	function _list(&$model,&$options) {
		if (ACTION_NAME=='index' && empty($_GET['p'])) {
			global $_search_form;
			///			if (!getShowData() && !$_search_form) { return array();}
		}
		///初始化$model
		if (!is_object($model)) {
			///获取当前Action名称
			$name = $this->getActionName();
			///获取当前模型
			$model 	= D($name);
		}
		extract($options);
		$is_rights	=	$model->_is_rights==false?0:1;
		$asc	=	!empty($asc)?$asc:$model->_asc;
		$asc	=	$asc	==true?true:false;
		$_child	=	$_child	==true?true:false;
		$sortBy	=	!empty($sortBy)?$sortBy:$model->_sortBy;
		///排序字段 默认为主键名
		if (isset ( $_REQUEST ['_order'] )) {
			$order = $_REQUEST ['_order'];
		} else {
			$order = ! empty ( $sortBy ) ? $sortBy : $model->getPk ();
		}
		///排序方式默认按照倒序排列
		///接受 sost参数 0 表示倒序 非0都 表示正序
		if (isset ( $_REQUEST ['_sort'] )) {
			$sort = $_REQUEST ['_sort'] ? 'asc' : 'desc';
		} else {
			$sort = $asc ? 'asc' : 'desc';
		}

		///取得满足条件的记录数
		$group	=	0;
		///判断是简单求列还是复杂求列整理get_count的个数
		foreach ((array)$options as $key=>$row) {
			if (in_array($key,array('table','where','having','group','distinct'))) {
				if (in_array($key,array('having','group'))) {
					$group++;
					continue;
				}
				$model->$key($row);
			}
		}
		///获取列表的总个数
		if ($group>0) {
			$count	=	$model->count(' DISTINCT '.$options['group']);
			///			$count	=	1;
		}else{
			$count	=	$model->count(1);
		}
		///		echo '<br>';  echo '<br>';  echo '<br>';
		///		echo $model->getLastSql();
		///		echo '<br>';
		///		exit;
		if ($count > 0) {
			import("ORG.Util.Page");
			///			import ( "@.ORG.Page" );
			///创建分页对象
			$listRows=	(! empty ( $_REQUEST ['listRows'] ))?$_REQUEST ['listRows']:'';
			///实例化分页对象
			$p = new Page ( $count, $listRows );
			///模型对象$options条件赋值

			foreach ((array)$options as $key=>$row) {
				if (in_array($key,array('sortBy'))) {continue;}
				$model->$key($row);
			}

			///获取列表信息->分页查询数据
			$voList = $model->order( "" . $order . " " . $sort)->limit($p->firstRow . ',' . $p->listRows)->select();

			///分页显示
			$page = $p->show ();
			///列表排序显示
			$sortImg = $sort; ///排序图标
			$sortAlt = $sort == 'desc' ? L('SORT_ASC') : L('SORT_DESC'); ///排序提示
			$sort = $sort == 'desc' ? 1 : 0; ///排序方式
			$assign_array = array();
			$assign_array = $voList;
			///模板赋值显示
			$view       = Think::instance('View');
			$view->assign ( 'sort', $sort );
			$view->assign ( 'order', $order );
			$view->assign ( 'sortType', $sortAlt );
			$view->assign ( "page", $page );///页码
			$view->assign ( "pageInfo", $p->getPageInfo());///分页信息

			///记录本次POST的值与SESSION
			/*import ( "@.ORG.Session" );
			$Session 		= 	new Session();   ///初始化分页对象
			$Session->setLocal('post_'.MODULE_NAME.'_'.ACTION_NAME,$_POST); ///设置本地化Session癿值
			$Session->set('_output_sql_',$model->getLastSql()); */
		}
		return	$assign_array;
	}

	/**
	 * 统计合计SQL的总数量
	 *
	 * @param string $sql
	 * @return int
	 */
	function _listStatCount($sql,$cache=true){
		///如果是翻找下一页先找下是否有历史缓存信息
	//	if ($_REQUEST['nextPage']>1 ){
	//		$rs	= _getSCacheListInfo('count');
	//		if ($rs!=false){
	//			return $rs;
	//		}
	//	}

		$cModel	=	M();
		$sql_count = 'select count(*) as count_stat
					from ('.$sql.') as tmp
					 ';
		if ($cache){
			$cModel->cache();
		}
		$info	=	$cModel->query($sql_count);

		return  is_array($info)?$info[0]['count_stat']:0;
	}


	/**
	 * 统计列表总合计
	 *
	 * @param unknown_type $sql
	 * @return unknown
	 */
	function _listStatTotal($sql){
	//	if ($_REQUEST['nextPage']>1 ){
	//		$rs	= _getSCacheListInfo('all_total');
	//		if ($rs!=false){
	//			return $rs;
	//		}
	//	}
		$model	= M();
		$list	= _formatList($model->cache()->query($sql),null,0);
	//	_addSCacheListInfo('all_total',$list['list'][0]);
		return $list['list'][0];
	}


	/**
	 * 获取统计缓存记录
	 *
	 * @param unknown_type $key
	 * @return unknown
	 */
	function _getSCacheListInfo($key=null){
		$cacheName	=	'tablelist_'.USER_ID.'_'.ACTION_NAME.'_'.MODULE_NAME;
		$cacheInfo	=	S($cacheName);
		if (is_array($cacheInfo)){
			if ($key){
				return $cacheInfo[$key];
			}else{
				return $cacheInfo;
			}
			$requery_time	=	$_REQUEST['REQUEST_TIME']?$_REQUEST['REQUEST_TIME']:$_SERVER['REQUEST_TIME'];
			$view       	= Think::instance('View');
			$view->assign ( 'request_time',$_REQUEST['REQUEST_TIME']);

		}else{
			return false;
		}
	}

	/**
	 * 统计缓存记录
	 *
	 * @param unknown_type $key
	 * @param unknown_type $value
	 */
	function _addSCacheListInfo($key,$value){
	//		$cacheName	=	'tablelist_'.USER_ID.'_'.ACTION_NAME.'_'.MODULE_NAME.'_'.$_SERVER['REQUEST_TIME'];
			///判断历史信息是否存在
			$cacheName	=	'tablelist_'.USER_ID.'_'.ACTION_NAME.'_'.MODULE_NAME;
			$cache_info	=	_getSCacheListInfo();
			if ($cache_info==false){//数组不存在
				$cache_info	=	array(
									$key=>$value,
									);
			}else{
				$cache_info[$key]	=	$value;
			}
			S($cacheName,$cache_info,180);
			$view       = Think::instance('View');
			$view->assign ('request_time',$_SERVER['REQUEST_TIME']);
	}

	/**
	 * 提供统计方面的分页
	 * 返回SQL对应的数组
	 * @access protected
	 * @param Model $sql sql
	 * @param Model $cache 缓存
	 * @return void
	 * @throws ThinkExecption
	 */
	function _listStat($sql,$cache=true) {
		$count	=	_listStatCount($sql,$cache);
		if ($count > 0) {
			$model	=	M();
			import("ORG.Util.Page");
			///			import ( "@.ORG.Page" );
			///创建分页对象
			$listRows=	(! empty ( $_REQUEST ['listRows'] ))?$_REQUEST ['listRows']:'';
			///实例化分页对象
			$p = new Page ( $count, $listRows );
			///模型对象$options条件赋值

			$sql	=	$sql.' limit '.$p->firstRow.' , '.$p->listRows.' ';
			///获取列表信息->分页查询数据
			$voList = $model->query($sql);
			///分页显示
			$page = $p->show ();
			///列表排序显示
			$sortImg = $sort; ///排序图标
			$sortAlt = $sort == 'desc' ? L('SORT_ASC') : L('SORT_DESC'); ///排序提示
			$sort = $sort == 'desc' ? 1 : 0; ///排序方式
			$assign_array = array();
			$assign_array = $voList;
			///模板赋值显示
			$view       = Think::instance('View');
			$view->assign ( 'sort', $sort );
			$view->assign ( 'order', $order );
			$view->assign ( 'sortType', $sortAlt );
			$view->assign ( "page", $page );///页码
			$view->assign('pageInfo', array('firstRow' => $p->firstRow, 'listRows' => $p->listRows, 'count' => $count, 'nowPage' => $p->firstRow/$p->listRows + 1));//added by jp 20131106

	//		_addSCacheListInfo('count',$count);
		}
		return	$assign_array;
	}

	/**
	 * 更新客户款项
	 *
	 * @param $args 参数
	 */
	function Funds($args,$object_type,$action=null){
		$model_type	= FundsObject();
		if(!isset($model_type[$object_type])) {
			throw_exception('Funds'.$object_type.'不存在！');
		}
		$model_name	= $model_type[$object_type];
		$o 			= D($model_name);
		if ($action=='delete'){	$action	=	'deleteOp';	}
		return $o->paidDetail($args,$action);
	}

	/**
	 * object_id对应的Model文件
	 *
	 * @return string
	 */
	function FundsObject(){
		$_paid_detail_object_type	=	array(
		1=>'ComCashIni',///公司现金期初
		101=>'ClientIni',///客户期初欠款
		102=>'ClientOtherArrearages',///客户其他欠款
		103=>'ClientFunds',///客户不指定收款
		104=>'ClientFundsCloseOut',///客户付款平帐

		120=>'ClientSale',///销售单客户欠款
		121=>'ClientSaleAdvance',///销售单预收款
		122=>'ClientSaleCloseOut',///销售单指定平帐
		123=>'ClientReturnSale',///退货
		124=>'ClientDelivery',///销售单实际发货
		129=>'ClientCheckAccount', /// 客户对账
		130=>'ClientPriceAdjust',///调价 added by jp 20131216

		201=>'FactoryIni',///厂家期初欠款
		202=>'FactoryOtherArrearages',///厂家其他欠款
		203=>'FactoryFunds',///厂家不指定收款
		204=>'FactoryFundsCloseOut',///厂家付款平帐

		220=>'FactoryInstock',///入库欠款
		221=>'FactoryOnRoad',///厂家装柜在路上的款项
		229=>'FactoryCheckAccount', /// 厂家对账

		301=>'LogisticsIni',///物流期初欠款
		302=>'LogisticsOtherArrearages',///物流其他欠款
		303=>'LogisticsFunds',///物流不指定收款
		304=>'LogisticsFundsCloseOut',///物流付款平帐

		320=>'LogisticsInstock',///物流入库欠款
		329=>'LogisticsCheckAccount', ///物流公司对账

		800=>'OtherExpenses',///公司其他支出
		801=>'OtherRevenue',///公司其他收入
		);
		return $_paid_detail_object_type;
	}

	/**
	 * 银行中心
	 *
	 * @param $args 参数
	 */
	function BankCenter($args,$object_type,$action=null){
		if(empty($object_type) || $object_type<=0){
			throw_exception('BankCenter方法中'.$object_type.'$object_type不存在！');
		}
		$model_type	=	BankCenterObjectType();
		$model_name	=	$model_type[$object_type].'';
		$o 			= D($model_name);
		if ($action=='delete'){	$action	=	'deleteOp';	}
		return $o->paidDetail($args,$action);
	}

	/**
	 * 定义银行款项数组值
	 *
	 * @return  array
	 */
	function BankCenterObjectType(){
		$bank_object_type	=		array(
		1=>'BankIni',		///银行账号期初
		2=>'BankJournal',	///银行存取款
		3=>'BankRemittance',///银行汇款
		4=>'BankOther',		///银行其他转入
		5=>'BankSwap',		///银行换汇 added by jp 20131212
		);
		return $bank_object_type;
	}

	/**
	 * 获取最大平账或者总平日期
	 *
	 * @param  int $comp_type
	 * @param  int $basic_id
	 * @param  int $comp_id
	 * @param  int $currency_id
	 * @return  string
	 */
	function getMaxCloseOutDate($comp_type,$basic_id,$comp_id,$currency_id){
		if ($comp_type>0 && $basic_id>0 && $comp_id>0 && $currency_id>0){
			/// 对账日期不能小于上次的对账日期
			$model	=	M('PaidDetail');
			$info 	= $model->query(' select DATE_ADD(paid_date, INTERVAL 1 DAY) as tp_max from paid_detail where currency_id='.$currency_id.' and object_type_extend in (3,4) and to_hide=1 and basic_id='.$basic_id.' and comp_type='.$comp_type.' and comp_id='.$comp_id.' group by paid_date order by paid_date desc limit 1');
			$min_paid_date	=	$info[0]['tp_max'];
		}
		return $min_paid_date;
	}

	/**
	 * 进货分析/客户交易统计中的日期处理
	 *
	 * @param  date $from_date
	 * @param  date $to_date
	 * @param  int $type
	 * @return  date
	 */
	function cacuDate($from_date, $to_date, $type) {
		$to_date 		= strtotime(formatDate($to_date));
		$from_date		= strtotime(formatDate($from_date));
		if ($type == 1) { /// 按年
			$year_d		= date('Y', $to_date) - date('Y', $from_date);
			if ($year_d >= 0) {
				for($i=0;$i<=$year_d;$i++) {
					$dates[] = date('Y', $from_date)+$i;
				}
			}
		}elseif ($type == 2) { /// 按月
			$month_d 	= (date('Y', $to_date) - date('Y', $from_date))*12
			+date('m', $to_date)-date('m', $from_date);
			if ($month_d >= 0) {
				for($i=0;$i<=$month_d;$i++) {
					$dates[] = date('Y-m', mktime(0,0,0,date('m',$from_date)+$i,1,date('Y',$from_date)));
				}
			}
		}elseif ($type == 3) { /// 按日
			$day_d		= round(($to_date - $from_date)/3600/24);
			if ($day_d >= 0) {
				for($i=0;$i<=$day_d;$i++) {
					$dates[] = date('Y-m-d', mktime(0,0,0,date('m',$from_date),date('d',$from_date)+$i,date('Y',$from_date)));
				}
			}
		}
		return $dates;
	}

	/**
	 * 获取指属性的条形码长度，未设置返回空
	 *
	 * @param string $pre_name
	 * @return int
	 */
	function getBarcodeLen($pre_name){
		if (!C('barcode')) return 0;
		///		if (empty($pre_name)) {
		$barcode = C('barcode_rules');
		///		}
		return $barcode['barcode'][$pre_name];
	}

	/**
	 * 获取条形码是否可变
	 *
	 * @param  string $pre_name
	 * @return  bool
	 */
	function getBarcodeExchange($pre_name){
		if (!C('barcode')) return false;
		$barcode = C('barcode_rules');
		return $barcode['barcode_exchange'][$pre_name]==1?true:false;
	}

	/**
	 * 通过条形码回返颜色尺寸
	 *
	 * @param  string $barcode_no
	 * @return array
	 */
	function inputBarcode($barcode_no){
		if(empty($barcode_no)) {
			return false;
		}
		$barcode=	M('barcode');
		$rs	=	$barcode->field('p_id,barcode_no,color_id,size_id')->where('barcode_no=\''.$barcode_no.'\'')->select();
		if(count($rs)=='1'){
			$info = $rs[0];
			if($info['p_id']>0){
				$product=	M('product');
				$rs	=	$product->field('factory_id,instock_price')->where('id=\''.$info['p_id'].'\'')->find();
				$info['factory_id']		= $rs['factory_id'];
				$info['instock_price']	= $rs['instock_price'];
			}
			if(!is_array($info)) {
				return false;
			}
			return $info;
		}else{
			return false;
		}
	}

	/**
	 * 通过产品/颜色等找条形码
	 *
	 * @param  int $p_id
	 * @param  int $color_id
	 * @param  int $size_id
	 * @return  string
	 */
	function getBarcode($p_id, $color_id  = 0, $size_id = 0){
		///开启条形码
		if (C('barcode')==1){
			$barcode		= C('barcode_rules');
			$cache_barcode 	= $barcode['barcode'];
			if (!is_array($cache_barcode)) {
				return false;
			}
			$where = 'p_id='.$p_id;
			if ($cache_barcode['barcode']['color_no']>0 && $color_id) {
				$where.=' and color_id='.$color_id;
			}
			if ($cache_barcode['barcode']['size_no'] >0 && $size_id) {
				$where.=' and size_id='.$size_id;
			}
			$model	= M("Barcode");
			$barcode =$model->where($where)->select();
			if (count($barcode)==1) {
				return $barcode[0]['barcode_no'];
			}
			return false;
		}
	}

	/**
	 * 通过产品号把相对应的条形码压入内存
	 *
	 * @param int $id
	 */
	function getProductBarCodeCache($id){
		$where	=	'p_id='.$id;
		$model	= 	M("Barcode");
		$list =$model->where($where)->select();
		foreach ((array)$list as $key=>$row) {
			$insertCache[$id][$row['color_id']][$row['size_id']]	=	$row['barcode_no'];
		}
		insertProductBarCodeCache($id,$insertCache);
		return $insertCache[$id];
	}

	/**
	 * 对应的产品ID的条形码压入内存
	 *
	 * @param int $id
	 * @param array $insertCache
	 */
	function insertProductBarCodeCache($id,$insertCache){
		$name	=	'barcode_'.$id;
		S($name,'');
		S($name,$insertCache[$id]);
	}

	/**
	 * 发送邮件
	 *
	 * @param array $toArray 需要发送的地址
	 * @param string $title   邮件抬头
	 * @param string $content 邮件内容
	 */
	function postEmail($toEmail,$title,$content,$path=NULL){
		try {
			$title			=	empty($title)?'友拓通-邮件提醒':$title;///主题
			$email_adder	=	C('email_adder')?C('email_adder'):'****@163.com';
			$email_password	=	C('email_password')?C('email_password'):'*****';
			$email_host		=	C('email_host')?C('email_host'):'smtp.163.com';
			$email_port		=	C('email_port')?C('email_port'):'25';
			$email_title	=	C('email_title')?C('email_title'):'友拓通';

			import("ORG.Util.Phpmailer");
			$mail = new PHPMailer(true); ///New instance, with exceptions enabled
			$body             = $content;
			///$body             = preg_replace('/\\\\/','', $body); ///Strip backslashes
			$mail->IsSMTP();                           /// tell the class to use SMTP
			$mail->SMTPAuth   = true;                  /// enable SMTP authentication
			$mail->CharSet    =	'utf-8';                  /// enable SMTP authentication
			$mail->Port       = $email_port;                    /// set the SMTP server port
			$mail->Host       = $email_host; /// SMTP server
			$mail->Username   = $email_adder;     /// SMTP server username
			$mail->Password   = $email_password;            /// SMTP server password
			$mail->FromName 	='发件人';//phpmailer设置指定发件人
			//$mail->IsSendmail();  /// tell the class to use Sendmail
			//$mail->AddReplyTo($email_adder,$email_title);
			$mail->From       = $email_adder;
			$mail->FromName   = $email_title;
			if (is_string($toEmail)) {
				$toEmail	= explode(',', $toEmail);
			} else {
				if (!empty($toEmail['ccMail'])) {//抄送
					$ccEmail	= is_string($toEmail['ccMail']) ? explode(',', $toEmail['ccMail']) : $toEmail['ccMail'];
					foreach ($ccEmail as $name => $cc) {
						$name	= is_numeric($name) ? '' : $name;
						$mail->AddCC(trim($cc), $name);
					}
				}
				if (!empty($toEmail['toMail'])) {
					$toEmail	= is_string($toEmail['toMail']) ? explode(',', $toEmail['toMail']) : $toEmail['toMail'];
				}
			}
			foreach ($toEmail as $name => $to) {
				$name	= is_numeric($name) ? '' : $name;
				$mail->AddAddress(trim($to), $name);
			}
			$mail->Subject  = $title;
			$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; /// optional, comment out and test
			$mail->WordWrap   = 80; /// set word wrap
			$mail->MsgHTML($body);
			$mail->IsHTML(true); /// send as HTML
            if(is_array($path)){ // 添加附件
                foreach ($path as $file){
                    $mail->AddAttachment($file);
                }
            }else{
                if(isset($path)){
                    $mail->AddAttachment($path);
                }
            }
			return $mail->Send();
		} catch (phpmailerException $e) {
			echo $e->errorMessage();
			return false;
		}
	}

	/**
	 *导出时使用,获取想对应的$_POST
	 *
	 */
	function getOutPutRand(){
		$rand	= $_POST['rand'] ? $_POST['rand'] :  md5(time());
		session($rand,$_POST);
		$view   = Think::instance('View');
		$view->assign('rand',$rand);
	}

	/**
	 * 交易分析 分页 日期区间
	 *
	 * @param  string $sql
	 * @return  array
	 */
	function getAnalysisDate($sql){
		$compare_type	= $_REQUEST['compare_type'];
		import("ORG.Util.Page");
		$listRows=	(! empty ( $_REQUEST ['listRows'] ))?$_REQUEST ['listRows']:'';
		$count	= M()->cache()->query('select count(*) count from ('.$sql.') t');
		///		echo M()->getLastSql();
		$count	= reset($count);
		$p 		= new Page($count['count'],$listRows);
		$page 	= $p->show();
		$limit 	= ' limit '.$p->firstRow . ','.$p->listRows;
		$order_date	= M()->cache()->query('select min(order_date) from_order_date,max(order_date) to_order_date from(select * from ('.$sql.') t  order by order_date '.$limit.') t');
		$info	= reset($order_date);
		if($compare_type==2){
			$info['from_order_date']	= $info['from_order_date'].'-01';
			$info['to_order_date']		= $info['to_order_date'].'-'.date('t',strtotime($info['to_order_date']));
		}elseif($compare_type==1){
			$info['from_order_date']	= $info['from_order_date'].'-01-01';
			$info['to_order_date']		= $info['to_order_date'].'-12-31';
		}
		$info['page']	= $page;

		return $info;
	}

	/**
	 * 取目录下所有文件
	 *
	 * @param string $dir_now 目录路径
	 * @param bool $postfix
	 * @param string $mark
	 * @return array
	 */
	function getAllFile($dir_now,$postfix=false,$mark='') {
		$dir_now_file = scandir($dir_now, 1);///目录中文件
		if(!is_array($dir_now_file)) {return $lang=array();}
		///获取需要便利的语言包 语言包必须包含-符号
		foreach ($dir_now_file as $dir_file) {
			if ($postfix==true) {
				if (in_array($dir_file,array('.','..','.svn'))) {
					continue;
				}
				if (empty($mark)) {
					$lang[]	=	$dir_file;
				}else{
					if (strpos($dir_file,$mark)) {
						$lang[]	=	$dir_file;
					}
				}
			}else {
				$lang[]	=	$dir_file;
			}
		}
		return $lang;
	}

	/**
	 * 获取逻辑表达式
	 * @author jph 20131126
	 * @param string $fieldName     字段名称
	 * @param string $logic         运算符标示
	 * @param string $fieldValue    字段值
	 * @return string 逻辑表达式
	 */
	function getLogicalExpression($fieldName, $logic, $fieldValue){
		$expression = $fieldName;
		switch (strtolower($logic)) {
			case '#le#':
				$expression   .= '<="'.$fieldValue.'"';
				break;
			case '#lt#':
				$expression   .= '<"'.$fieldValue.'"';
				break;
			case '#ge#':
				$expression   .= '>="'.$fieldValue.'"';
				break;
			case '#gt#':
				$expression   .= '>"'.$fieldValue.'"';
				break;
			case '#ne#':
				$expression   .= '!="'.$fieldValue.'"';
				break;
			case '#null#':
				$expression   .= ' is NULL';
				break;
			case '#notnull#':
				$expression   .= ' is not NULL';
				break;
			case '#empty#':
				$expression    = '('.$fieldName.'="" or ' . $fieldName . ' is NULL)';
				break;
			case '#nonempty#':
				$expression    = '('.$fieldName.'!="" and ' . $fieldName . ' is not NULL)';
				break;
			case '#eq#':
			default :
				$expression   .= '="'.$fieldValue.'"';
				break;
		}
		return $expression;
	}


	function _mergeAddress(&$rs, $delimiter = ',', $fields=array('address','address2','company_name','city_name','country_name','abbr_district_name')){
		if (is_array($rs) && !empty($rs)) {
			if (is_string($fields)) {
				$fields	= explode(',', $fields);
			}
			if (isset($rs['list'])) {//列表
				foreach ($rs['list'] as &$v) {
					$merge_address	= array();
					foreach ($fields as $field) {
						!empty($v[$field]) && $merge_address[]	= $v[$field];
					}
					$v['merge_address']	= implode($delimiter, $merge_address);
				}
			} else {//明细
				$merge_address	= array();
				foreach ($fields as $field) {
					!empty($rs[$field]) && $merge_address[]	= $rs[$field];
				}
				$rs['merge_address']	= implode($delimiter, $merge_address);
			}
		}
		return $rs;
	}

	/**
	 * 格式化带单位重量
	 * @author jp 20140311
	 * @param array $info
	 * @param string $weight_unit_lang_key
	 * @return array
	 */
	function _formatWeight(&$info, $weight_unit_lang_key = 'weight_unit'){
		$info['s_weight']	= $info['dml_weight'];
		$info['s_unit_weight']	= $info['dml_weight'] . L($weight_unit_lang_key);
		if (isset($info['check_weight'])) {
			$info['s_check_weight']	= $info['dml_check_weight'];
			$info['s_unit_check_weight']	= $info['dml_check_weight'] . L($weight_unit_lang_key);
		}
		return $info;
	}

	/**
	 * 格式化带单位规格
	 * @author jp 20140311
	 * @param array $info
	 * @param string $size_unit_lang_key
	 * @param string $volume_size_unit_lang_key
	 * @return array
	 */
	function _formatCube(&$info, $size_unit_lang_key = 'size_unit', $volume_size_unit_lang_key = 'volume_size_unit', $weight_unit_lang_key = 'weight_unit'){
		$info['s_cube']			= $info['dml_cube_long'] . '*' . $info['dml_cube_wide'] . '*' . $info['dml_cube_high'] . '=' . $info['dml_cube'];
		$info['s_unit_cube']	= L('long')  .  $info['dml_cube_long'] . L($size_unit_lang_key) . '*' . L('wide')  .  $info['dml_cube_wide'] . L($size_unit_lang_key) . '*' . L('high')  .  $info['dml_cube_high'] . L($size_unit_lang_key) . '=' . $info['dml_cube'] . L($volume_size_unit_lang_key);
		if(isset($info['volume_weight'])) {
            $info['s_volume_weight']	= $info['dml_volume_weight'];
            $info['s_unit_volume_weight']	= $info['dml_volume_weight'] . L($weight_unit_lang_key);
        }
        if (isset($info['check_cube'])) {
			$info['s_check_cube']		= $info['dml_check_long'] . '*' . $info['dml_check_wide'] . '*' . $info['dml_check_high'] . '=' . $info['dml_check_cube'];
			$info['s_unit_check_cube']	= L('long')  .  $info['dml_check_long'] . L($size_unit_lang_key) . '*' . L('wide')  .  $info['dml_check_wide'] . L($size_unit_lang_key) . '*' . L('high')  .  $info['dml_check_high'] . L($size_unit_lang_key) . '=' . $info['dml_check_cube'] . L($volume_size_unit_lang_key);
		}
		return $info;
	}

	/**
	 * 列表格式化带单位重量、规格
	 * @author jp 20140311
	 * @param array $list
	 * @param string $weight_unit_lang_key
	 * @param string $size_unit_lang_key
	 * @param string $volume_size_unit_lang_key
	 * @return array
	 */
	function _formatWeightCube(&$info, $weight_unit_lang_key = 'weight_unit', $size_unit_lang_key = 'size_unit', $volume_size_unit_lang_key = 'volume_size_unit') {
		if(empty($info)){
            return $info;
        }
		_formatWeight($info, $weight_unit_lang_key);
		_formatCube($info, $size_unit_lang_key, $volume_size_unit_lang_key);
		return $info;
	}

	/**
	 * 列表格式化带单位重量、规格
	 * @author jp 20140311
	 * @param array $list
	 * @param string $weight_unit_lang_key
	 * @param string $size_unit_lang_key
	 * @param string $volume_size_unit_lang_key
	 * @return array
	 */
	function _formatWeightCubeList(&$list, $weight_unit_lang_key = 'weight_unit', $size_unit_lang_key = 'size_unit', $volume_size_unit_lang_key = 'volume_size_unit') {
		foreach($list as &$info) {
			_formatWeightCube($info, $weight_unit_lang_key, $size_unit_lang_key, $volume_size_unit_lang_key);
		}
		return $list;
	}

	/**
	 * 创建条形码
	 *
	 * @author jph 20140320
	 * @param string $code 条形码
	 * @param string $path 存放目录
	 * @param string/array $hri 除条形码以外的标签说明
	 * @param array $barcode_config
	 */
	function generateBarcode($code, $path, $hri='', $barcode_config = null, $wrap = true){
		import("ORG.Util.Barcode");
		$pc_type	= C('BARCODE_PC_TYPE') ? C('BARCODE_PC_TYPE') : 'gif';//图片格式
		$code_type	= C('BARCODE_CODE_TYPE') ? C('BARCODE_CODE_TYPE') : 'code128b';//条形码编码类型
		$filename	= $path . '/' . (isset($barcode_config['file_name']) ? $barcode_config['file_name'] : $code) . '.' . $pc_type;
		$default_config	= array(
							'pc_height'	=> 100,
							'pc_width'	=> 300,
							'y'			=> 35,	// barcode center
							'height'	=> 50,	// 高度
							'width'		=> 2,	// 宽度
							'angle'		=> 0,	//旋转角度.
							'fontSize'	=> 8,   // 标签字体大小 GD1 in px ; GD2 in point
						);
		is_array($barcode_config) && $default_config	= array_merge($default_config, $barcode_config);
		extract($default_config);
		$x		= $pc_width / 2;// barcode center
		$im		= imagecreatetruecolor($pc_width, $pc_height);
		$black	= ImageColorAllocate($im,0x00,0x00,0x00);
		$white  = ImageColorAllocate($im,0xff,0xff,0xff);
		imagefilledrectangle($im, 0, 0, $pc_width, $pc_height, $white);
		$data	= Barcode::gd($im, $black, $x, $y, $angle, $code_type, $code, $width, $height);
		$font   = APP_FONTS_PATH . 'SongBlack.ttf';
		if (mk_dir($path) && @is_writable($path)) {
			if (Barcode::output($im, $pc_type, $filename)){
				if ( isset($font) ){
					$im	= imagecreatefromgif($filename);
					if (is_array($hri)) {
						$hri	= implode("\n", $hri);
					}
					if(!is_null($hri)) {
						if (!empty($hri)) {
							$data['hri']	.= ($wrap ? "\n" : '') . $hri;
						}
						$data['hri']	= mb_convert_encoding($data['hri'], "html-entities", "utf-8");//解决中文乱码
						$data['hri']	= autoWrap($fontSize, $angle, $font, $data['hri'], max($pc_width-20,0));
						$marge    = 10;   // 条形码和标签间隔 像素
						$box = imagettfbbox($fontSize, $angle, $font, $data['hri']);
						$len = $box[2] - $box[0];
						Barcode::rotate(-$len / 2, ($data['height'] / 2) + $fontSize + $marge, $angle, $xt, $yt);
						imagettftext($im, $fontSize, $angle, max(10, $x+$xt), $y + $yt, $black, $font, $data['hri']);
					}
					imagegif($im, $filename);
				}
			}
		} else {
			halt(L('dir_right_error'));
		}
	}

	function autoWrap($fontsize, $angle, $fontface, $string, $width) {
		// 这几个变量分别是 字体大小, 角度, 字体名称, 字符串, 预设宽度
		$content = "";

		// 将字符串拆分成一个个单字 保存到数组 letter 中
		for ($i=0;$i<mb_strlen($string);$i++) {
			$letter[] = mb_substr($string, $i, 1);
		}

		foreach ($letter as $l) {
			$teststr = $content." ".$l;
			$testbox = imagettfbbox($fontsize, $angle, $fontface, $teststr);
			// 判断拼接后的字符串是否超过预设的宽度
			if (($testbox[2] > $width) && ($content !== "")) {
				$content .= "\n";
			}
			$content .= $l;
		}
		return $content;
	}

	/**
	 * 根据图片类别返回图片存储目录
	 * @author jph 20140324
	 * @param int $relation_type
	 * @return string
	 */
	function getUploadDir($relation_type) {
		$dis = C('UPLOAD_DIR');
		return isset($dis[$relation_type]) ? $dis[$relation_type] : '';
	}

	/**
	 * 根据图片类别返回图片存储目录
	 * @author jph 20140324
	 * @param int $relation_type
	 * @return string
	 */
	function getUploadPath($relation_type) {
		return rtrim(UPLOADS_PATH . getUploadDir($relation_type), '/') . '/';
	}


	/**
	 * 根据图片类别返回图片存储目录（远程地址）
	 * @author jph 20150928
	 * @param int $relation_type
	 * @return string
	 */
	function getRealUploadPath($relation_type) {
		$url	= (is_ssl() ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'];
		$path	= APP_NAME . '/' . ltrim(getUploadPath($relation_type), './');
		return $url . '/' . ltrim($path, '/');
	}

	/**
	 * 一维数组转化成字符串
	 * @author jph 20140414
	 * @param array $rs 待转化数组
	 * @param string $fn 函数名称
	 * @param string $delimiter 分隔符
	 * @param array $fn_args 函数参数数组 array(前缀，字段名称:只能为key或value，中间字符串，字段值，后缀)//按位置赋值，跳过用null
	 * @return string
	 */
	function getStrFromArr($rs, $delimiter=',', $fn_args = array(), $fn = 'setElementStr'){
		if (!is_array($rs)) {
			return $rs;
		}
		array_walk($rs, $fn, $fn_args);
		return implode($delimiter, $rs);
	}

	/**
	 * getStrFromArr默认数组元素处理函数
	 * @author jph 20140414
	 * @param string $value
	 * @param string $key
	 * @param array $fn_args 函数参数数组 array(前缀，字段名称:只能为key或value，中间字符串，字段值，后缀)//按位置赋值，跳过用null
	 */
	function setElementStr(&$value, $key, $fn_args = array()) {
		$prefix				= !is_null($fn_args[0]) ?  $fn_args[0] : '';//前缀
		$field_name			= !is_null($fn_args[1]) ? $$fn_args[1] : $key;//字段名称
		$middle_string		= !is_null($fn_args[2]) ?  $fn_args[2] : '=';//中间间隔符
		$value_name			= !is_null($fn_args[3]) ?  $fn_args[3] : $value;//字段值
		$suffix				= !is_null($fn_args[4]) ?  $fn_args[4] : '';//后缀
		$value	= $prefix . $field_name . $middle_string . $value_name . $suffix;
	}

	function implodeExtend($rs, $delimiter=',' ,$prefix = ''){
		if (!is_array($rs)) {
			return $rs;
		}
		if ($prefix != '') {
			array_walk($rs, 'setArrValuePrefix', $prefix);
		}
		return implode($delimiter, $rs);
	}

	function setArrValuePrefix(&$value, $key, $prefix = '') {
		$value	= $prefix . $value;
	}

    function sqlWhereKeyPrefix($rs,$prefix = ''){
		if (!is_array($rs)) {
			return $prefix.$rs;
		}
		if ($prefix != '') {
            foreach ($rs as $key=>$value){
                if($key!='date'){
                    if(!is_array($value)){
                        $arr[$prefix.$key] = $value;
                    }else{
                        $arr[$key] = sqlWhereKeyPrefix($value, $prefix);
                    }
                }else{
                    $arr[$key]  = $value;
                }
            }
		}
		return $arr;
	}
	function implodeByFields($rs, $fields = array(), $delimiter='_'){
		if (!is_array($rs)) {
			return $rs;
		}
		if (!empty($fields)) {
			!is_array($fields)	&& $fields	= explode(',', $fields);
			$tmp	= array();
			foreach ($fields as $field) {
				$tmp[]	= $rs[$field];
			}
			$rs	= $tmp;
		}
		return implode($delimiter, $rs);
	}

	//导出excel
	function tranCsv($source_array,$need_array,$tran_array,$path_str,$head_array=null,$sign=',', $is_utf8 = false){
		$path	= dirname($path_str);
		if (!mk_dir($path) || !@is_writable($path)) {
			halt(L('dir_right_error'));
		}
		$fp = fopen($path_str,'w');
		if ($is_utf8 === true) {
			fwrite($fp, pack('H*','EFBBBF'));//加入BOM头 added by jp 20141118
		}
		if($head_array){
			foreach ($head_array as $i => $v) {
				if ($is_utf8 !== true) {
					$v			= iconv('utf-8', 'iso-8859-1', $v);
				}
				$head[$i]	= $v;
			}
            $data['row']    = $head;
			if (fput_csv($fp,$data,$sign) === false){
				fclose($fp);
				return false;
			}
		}
		$cnt   = 0;
		$limit = 1000;

		foreach ((array)$source_array as $key => $row) {
            $cur_sign   = isset($row['sign']) ? $row['sign'] : $sign;
			$cnt ++;
			if ($limit == $cnt) {
				ob_flush();
				flush();
				$cnt = 0;
			}
			$new_key	= array();
			$new_row	= array();
			foreach($need_array as $field) {
				if (!array_key_exists($field, $row)) {
					$row[$field]	= '';
				}
			}
			foreach ($row as $i => $v) {
				if(in_array($i,$need_array)){
					if(in_array($i,$tran_array)){
						$v = '="'.$v.'"';
					} elseif ($cur_sign == ',' && strpos($v, ',')) {//added by jp 20140730 字符串带逗号需在两端加入双引号，否则会被分割成两个单元格
						$v	= '"' . $v . '"';
					}
					$v = HtmlDecode($v);
					if ($is_utf8 !== true) {
                        if (is_array($v)) {
                            foreach ($v as &$val) {
                                $val    = iconv('utf-8', 'iso-8859-1', $val);
                            }
                        } else {
                            $v  = iconv('utf-8', 'iso-8859-1', $v);
                        }
					}
					$new_row[array_search($i,$need_array)] = $v;
                    $new_key[$i] = array_search($i,$need_array);
				}
			}
			ksort($new_row);
            $data['key']    = $new_key;
            $data['row']    = $new_row;
			//pr($new_row);
			if (fput_csv($fp,$data,$cur_sign) === false){
				fclose($fp);
				return false;
			}
		}
		//exit;
		fclose($fp);
		return true;
	}

	//导出excel
	function tranXls($source_array,$need_array,$tran_array,$path_str,$head_array=null,$sign='\t'){
		ini_set('memory_limit', '64M');
		@unlink($path_str);
		$dir	= dirname($path_str);
		if (!mk_dir($dir) || !is_writable($dir)) {
			halt(L('dir_right_error'));
		}
		vendor('PhpExcel.PHPExcel','','.php');
		$objPHPExcel    = new PHPExcel();
		// 设置excel文件信息
		$objPHPExcel->getProperties()->setCreator("友拓通")->setTitle("Excel");
		$objPHPExcel->createSheet(0);
		$objActSheet    = $objPHPExcel->setActiveSheetIndex(0);
		$rt		    = 1;//行
		$content_length = array();
		foreach ($source_array as $value) {
		$qt	    = 'A';//列
		$need_data  = array();
		foreach($need_array as $field){
			$need_data[]    = $value[$field];
		}
		$row_data   = $sign == '\t' ? $need_data : array(implode("$sign", $need_data));
		foreach($row_data as $content){
			$objActSheet->setCellValue($qt.$rt, $content);
			if ($content_length[$qt] < strlen($content)) {
			$content_length[$qt]	= strlen($content);
			$objActSheet->getColumnDimension($qt)->setWidth($content_length[$qt]+2);
			}
			$objStyle = $objActSheet->getStyle($qt.$rt);
			$objStyle->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT); //水平靠左对齐
			$objStyle->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER); //垂直居中对齐
			$objPHPExcel->getActiveSheet()->getStyle($qt)->getNumberFormat()->setFormatCode("@");
			$qt++;
		}
		$rt++;
		}
		// 设置文件格式为Excel5
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save($path_str);
		return true;
	}

	//导出txt
	function tranTxt($source_array,$need_array,$tran_array,$path_str,$head_array=null,$sign=',', $is_utf8 = false){
		$path	= dirname($path_str);
		if (!mk_dir($path) || !@is_writable($path)) {
			halt(L('dir_right_error'));
		}
		$fp = fopen($path_str,'w');
		if ($is_utf8 === true) {
			fwrite($fp, pack('H*','EFBBBF'));//加入BOM头 added by jp 20141118
		}
		if($head_array){
			foreach ($head_array as $i => $v) {
				if ($is_utf8 !== true) {
					$v			= iconv('utf-8', 'iso-8859-1', $v);
				}
				$head[$i]	= $v;
			}
            $data['row']    = $head;
			if (fput_txt($fp,$data,$sign) === false){
				fclose($fp);
				return false;
			}
		}
		$cnt   = 0;
		$limit = 1000;

		foreach ((array)$source_array as $key => $row) {
            $cur_sign   = isset($row['sign']) ? $row['sign'] : $sign;
			$cnt ++;
			if ($limit == $cnt) {
				ob_flush();
				flush();
				$cnt = 0;
			}
			$new_key	= array();
			$new_row	= array();
			foreach ($row as $i => $v) {
				if(in_array($i,$need_array)){
					$v = HtmlDecode($v);
					if ($is_utf8 !== true) {
                        if (is_array($v)) {
                            foreach ($v as &$val) {
                                $val    = iconv('utf-8', 'iso-8859-1', $val);
                            }
                        } else {
                            $v  = iconv('utf-8', 'iso-8859-1', $v);
                        }
					}
					$new_row[array_search($i,$need_array)] = $v;
                    $new_key[$i] = array_search($i,$need_array);
				}
			}
			ksort($new_row);
            $data['key']    = $new_key;
            $data['row']    = $new_row;
			//pr($new_row);
			if (fput_txt($fp,$data,$cur_sign) === false){
				fclose($fp);
				return false;
			}
		}
		//exit;
		fclose($fp);
		return true;
	}


	//导出pdf
	function outputPdf($source_array,$need_array,$tran_array,$path_str,$head_array=null,$sign='\t'){
		ini_set('memory_limit', '64M');
		vendor('PhpExcel.PHPExcel','','.php');
		$objPHPExcel    = new PHPExcel();
		// 设置excel文件信息
		$objPHPExcel->getProperties()->setCreator("友拓通")->setTitle("Excel");
		$objPHPExcel->createSheet(0);
		$rt		    = 1;//行
		$content_length = array();
		$objActSheet    = $objPHPExcel->setActiveSheetIndex(0);
		foreach ($source_array as $value) {
		$qt	    = 'A';//列
		$need_data  = array();
		foreach($need_array as $field){
			$need_data[]    = $value[$field];
		}
		$row_data   = $sign == '\t' ? $need_data : array(implode("$sign", $need_data));
		foreach($row_data as $content){
			$objActSheet->setCellValue($qt.$rt, $content);
			if ($content_length[$qt] < strlen($content)) {
			$content_length[$qt]	= strlen($content);
			$objActSheet->getColumnDimension($qt)->setWidth($content_length[$qt]+2);
			}
			$objStyle = $objActSheet->getStyle($qt.$rt);
			$objStyle->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT); //水平靠左对齐
			$objStyle->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER); //垂直居中对齐
			$objPHPExcel->getActiveSheet()->getStyle($qt)->getNumberFormat()->setFormatCode("@");
			$qt++;
		}
		$rt++;
		}
		// 设置文件格式为PDF
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'oldPDF');
		$objWriter->output($path_str);
		exit;
	}

	function HtmlDecode($array_string,$code=ENT_QUOTES){
		if(is_array($array_string)){
			foreach($array_string as $key=>$val){
				$array_string[$key] =HtmlDecode($val);
			}
		}else{
			$array_string   = htmlspecialchars_decode($array_string,$code);
		}
		return $array_string;
	}

	function fput_csv($filePointer,$dataArray,$delimiter,$enclosure)
	{
		// Write a line to a file
		// $filePointer = the file resource to write to
		// $dataArray = the data to write out
		// $delimeter = the field separator

		// Build the string
		$string = "";

		// No leading delimiter
		$writeDelimiter = FALSE;
		//pr($dataArray,'',1);
		//判断是否存在扩展列
        $data   = $dataArray['row'];
        $key    = $dataArray['key'];
		if (array_key_exists('ext_cols', $key)) {
			$ext_cols	= "," . (is_array($data[$key['ext_cols']]) ? implode(",", $data[$key['ext_cols']]) : $data[$key['ext_cols']]);
			unset($data[$key['ext_cols']]);
		} else {
			$ext_cols	= '';
		}
		foreach($data as $dataElement)
		{
			// Replaces a double quote with two double quotes
			$dataElement=str_replace("\"", "\"\"", $dataElement);

			// Adds a delimiter before each field (except the first)
			if($writeDelimiter) $string .= $delimiter;

			// Encloses each field with $enclosure and adds it to the string
			$string .= $enclosure . $dataElement . $enclosure;

			// Delimiters are used every time except the first.
			$writeDelimiter = TRUE;
		} // end foreach($dataArray as $dataElement)
		if ($delimiter != ',' && strpos($string, ',')) {//added by jp 20140730 字符串带逗号需在两端加入双引号，否则会被分割成两个单元格
			$string	= '"' . $string . '"';
		}
		//拼接扩展列
		$string	.= $ext_cols;
		// Append new line
		$string .= "\r\n";

		// Write the string to the file
		return fwrite($filePointer,$string) === false ? false : true;
	}

	function fput_txt($filePointer,$dataArray,$delimiter,$enclosure)
	{
		$string = "";
		// No leading delimiter
		$writeDelimiter = FALSE;
		//判断是否存在扩展列
        $data   = $dataArray['row'];
        $key    = $dataArray['key'];
		if (array_key_exists('ext_cols', $key)) {
			$ext_cols	= "," . (is_array($data[$key['ext_cols']]) ? implode(",", $data[$key['ext_cols']]) : $data[$key['ext_cols']]);
			unset($data[$key['ext_cols']]);
		} else {
			$ext_cols	= '';
		}
		foreach($data as $dataElement){
			// Replaces a double quote with two double quotes
			$dataElement=str_replace("\"", "\"\"", $dataElement);

			// Adds a delimiter before each field (except the first)
			if($writeDelimiter) $string .= $delimiter;

			// Encloses each field with $enclosure and adds it to the string
			$string .= $enclosure . $dataElement . $enclosure;

			// Delimiters are used every time except the first.
			$writeDelimiter = TRUE;
		} // end foreach($dataArray as $dataElement)
		//拼接扩展列
		$string	.= $ext_cols;
		// Append new line
		$string .= "\r\n";

		// Write the string to the file
		return fwrite($filePointer,$string) === false ? false : true;
	}

	function checkStrIn($data, $text){
		$result = false;
		foreach((array)$data as $key){
			if(stripos($text,$key)!==false){
				$result = true;
				break;
			}
		}
		return $result;
	}

	function combineArray($key_array, $value_array){
		$result = array();
		foreach((array)$key_array as $key => $value){
			 isset($value_array[$key])&&$result[$key] = $value_array[$key];
		}
		return $result;
	}

	 /**
	 * 递归方式的对变量中的特殊字符进行转义
	 * @access  public
	 * @param   mix     $value
	 * @return  mix
	 */
	function addslashes_deep($value){
		if (empty($value)) {
			return $value;
		} elseif (is_object($value)){
			foreach ($value AS $key => $val){
				$value->$key = addslashes_deep($val);
			}
		} elseif (is_array($value)) {
			foreach((array)$value as $k=>$v) {
				unset($value[$k]);
				$k			= addslashes($k);
				$value[$k]	= addslashes_deep($v);
			}
		} else {
			$value = addslashes($value);
		}
		return $value;
	}

	/**
	 * 递归方式的对变量中的特殊字符去除转义
	 * @access  public
	 * @param   mix     $value
	 * @return  mix
	 */
	function stripslashes_deep($value) {
		if (empty($value)) {
			return $value;
		} elseif (is_object($value)){
			foreach ($value AS $key => $val){
				$value->$key = stripslashes_deep($val);
			}
		} elseif(is_array($value)) {
			foreach((array)$value as $k=>$v) {
				unset($value[$k]);
				$k			= stripslashes($k);
				$value[$k]	= stripslashes_deep($v);
			}
		} else {
			$value = stripslashes($value);
		}
		return $value;
	}

	/**
	 * 通过时间戳比较获取时间差
	 * @author jph 20140610
	 * @param 起始日期时间戳 $begin_time
	 * @param 结束日期时间戳 $end_time
	 * @return string
	 */
	function getDiffTime($begin_time, $end_time){
		$diff_time	= abs($end_time - $begin_time);
		$prefix		= $end_time - $begin_time < 0 ? '-' : '';
		$diff_date	= '';
		$format_arr	= array('Y'=>'年', 'm'=>'个月', 'd'=>'天', 'H'=>'小时', 'i'=>'分钟', 's'=>'秒');
		$begin		= false;
		foreach ($format_arr as $format => $suffix) {
			$value	= date($format, $diff_time) - date($format, 0);
			if (!$begin && $value > 0) {
				$begin	= true;
			}
			if ($begin) {
				$diff_date	.= $value . $suffix;
			}
		}
		return $prefix . $diff_date;
	}

	/**
	 * 通过日期比较获取时间差
	 * @author jph 20140610
	 * @param 起始日期 $begin_date
	 * @param 结束日期 $end_date
	 * @return string
	 */
	function getDiffDate($begin_date, $end_date){
		return getDiffTime(strtotime($begin_date), strtotime($end_date));
	}

	function array_is_null($arr = null){
		if(is_array($arr)){
			foreach($arr as $k=>$v){
				if($v&&!is_array($v)){
					return false;
				}
				$t = array_is_null($v);
				if(!$t){
					return false;
				}
			}
			return true;
		}elseif(!$arr){
			return true;
		}else{
			return false;
		}
	}

	/**
	 * 明细规格验证
	 * @author jph 20140923
	 * @param array $data
	 * @param array $validFields
	 * @param string $errorName
	 * @param string $detailKey
	 * @return array
	 */
	function validDetailSpecRepeat(&$data, $validFields = array(), $errorName = 'product_id', $detailKey = 'detail'){
		$spec		= array();
		$errorArr	= array();
		$first		= null;
		foreach($data[$detailKey] as $key=>$val){
            if(is_array($errorName)){
                $is_empty   = TRUE;
                foreach($errorName as $field){
                    if(!empty($val[$field])){
                        $is_empty   = FALSE;
                    }
                }
            }else{
                $is_empty   = empty($val[$errorName]);
            }
			if ($is_empty){
				if (empty($first) && $key>0){
					$first	=	$key;
					continue;
				}
				unset($data[$detailKey][$key]);
				continue;
			}
            if(!is_array($errorName)){
                $spec_items	= array();
                foreach ($validFields as $field) {
                    $spec_items[]	= $val[$field];
                }
                $detail_spec = implode('_', $spec_items);
                if(in_array($detail_spec,$spec)){
                    $error['name']	= $detailKey . '['.$key.'][' . $errorName . ']';
                    $error['value']	= L('spec_error');
                    $errorArr[]		= $error;
                }else{
                    $spec[]			= $detail_spec;
                }
            }
		}
		if (count($data[$detailKey])>1 && !empty($first)){
			unset($data[$detailKey][$first]);
		}
		return $errorArr;
	}

	/**
	 *  获取APITOKEN
	 * @return string
	 */
	function getApiToken(){
		$token = md5(getRands() . time() . getRands());
		return $token;
	}

	/**
	 * @author yyh 20101031
	 * 获取仓库绑定国家
	 * @param type $warehouse_id
	 * @return int
	 */
	function getWarehouseCountry($warehouse_id){
		$country_id = M('warehouse')->where('id='.(int)$warehouse_id)->getField('country_id');
		return $country_id;
	}

	/**
	 * 通过缓存获取id
	 * @author jph 20141028
	 * @staticvar array $dd_to_id
	 * @param string $dd_name
	 * @param string $dd_field
	 * @return mixed
	 */
	function DdToId($dd_name = null, $dd_field = null){
		static $dd_to_id	= array();
		if (empty($dd_to_id)) {
			$dd_fields	= array(
				'abbr_district_name'	=>'country',
				'w_no'					=>'warehouse',
				'ship_name'				=>'shipping',
                'package_name'          =>'package',
				'logistics_name'		=>'logistics',
				);
			foreach ($dd_fields as $field => $name) {
				$dd	= S($name);
				foreach((array)$dd as $key=>$val){
					if($val[$field]){
						$dd_to_id[$name][strtoupper($val[$field])] = $key;
					}
				}
				unset($dd);
			}
		}
		if (is_null($dd_name)) {
			return $dd_to_id;
		}
		if (is_null($dd_field)) {
			return $dd_to_id[$dd_name];
		}
		return $dd_to_id[$dd_name][$dd_field];
	}

	/**
	 * 按卖家，sku获取产品id
	 * @author jph 20141028
	 * @param mixed $product_no
	 * @param int $factory_id
	 * @return int
	 */
	function getProductIdByFactory($product_no, $factory_id) {
		$where	= array(
			'factory_id'	=> $factory_id,
			'product_no'	=> is_array($product_no) ? array('in', $product_no) : $product_no,
			'to_hide'		=> 1,
		);
		if (is_array($product_no)) {
			return M('product')->where($where)->getField('product_no, id');
		} else {
			$product_id	    = M('product')->where($where)->getField('id');
			return $product_id > 0 ? $product_id : 0;
		}
	}

	/**
	 * 获取最大编号
	 * @param type $model
	 * @param type $step
	 * @return type
	 */
	function getModuleMaxNo($model=null, $step=1){
		if (is_null($model)) {
			$model	= MODULE_NAME;
		}
		$action = A($model);
		if (C(strtoupper($action->_setauto_cache))==1){
			$model = D($model);
			///获取最大编号NO
			$where			= $action->_default_where ? $action->_default_where : '';
			$curr_max_no	= $model->where($where)->order('id desc')->getField($action->_auto_no_name);
			$max			= intval($curr_max_no)+$step;
			$leng			= $action->_setauto_leng>0 ? $action->_setauto_leng : 3;
			$max_no			= str_pad($max, $leng, '0', STR_PAD_LEFT);
			return $max_no;
		}
	}

	/**
	 *重新组织二维数组
	 * @author jph 20141029
	 * @param array $array
	 * @param mixed $keys 索引字段
	 * @return type
	 */
	function resetArrayIndex($array, $keys, $td = false){
		if (!is_array($keys)) {
			$keys	= explode(',', $keys);
		}
		if (empty($keys)) {
			return $array;
		}
		$arr_new = array();
		foreach ((array)$array as $k=>$v){
			$v_keys				= array();
			foreach ($keys as $sub=>$key){
				if (array_key_exists($key, $v)) {
					$v_keys[]	= $v[$key];
				} else {
					unset($keys[$sub]);
				}
			}
			if (empty($v_keys)) {
				return $array;
			}
			$new_key			= implode('_', $v_keys);
			if ($td === true) {
				$arr_new[$new_key][]	= $v;
			} else {
				$arr_new[$new_key]	= $v;
			}
		}
		return $arr_new;
	}

	/**
	 * 销售单可编辑验证
	 * @author jph 20141031
	 * @param int $state 销售单状态
	 * @return int 1可编辑 0不可编辑
	 */
	function saleOrderCheckEdit($state,$id, $params = array()) {
		$role_type	= getUser('role_type');
        if($state == C('SALE_ORDER_DELETED')){
            return 1;
        }
		$_action	= $params['_action'] ? $params['_action'] : ACTION_NAME;
		if ($role_type == C('SELLER_ROLE_TYPE') && !in_array($state, explode(',',C('SELLER_CAN_EDIT_STATE')))) {
            $sale_order_state       = M('state_log')->where('object_type='.array_search('SaleOrder',C('STATE_OBJECT_TYPE')).' and object_id='.$id)->order('id desc')->getField('state_id',true);
            if(in_array($_action, array('edit','index','view')) && $state == C('SALEORDER_OBSOLETE')){
                return 0;
            }
            if((in_array($state, explode(',', C('SALEORDER_OBSOLETE'))) && !in_array(C('SHIPPED'), $sale_order_state)) || $state==C('ERROR_ADDRESS')){
                return 1;
            }
			return 0;
		} elseif ($role_type != C('SELLER_ROLE_TYPE') && !in_array($state, explode(',',C('ADMIN_CAN_EDIT_STATE')))){
			return 0;
		}
		return 1;
	}

	/**
	 * 销售单可删除验证
	 * @author jph 20141031
	 * @param int $state 销售单状态
	 * @return int 1可删除 0不可删除
	 */
	function saleOrderCheckDelete($state,$is_shipped) {
		if ((getUser('role_type') == C('SELLER_ROLE_TYPE') && in_array($state, explode(',',C('SELLER_CAN_DEL_STATE'))))) {
			return 1;
		} else {
			return 0;
		}
	}

    /**
     * 查询库位ID
     * @author yyh 20141114
     * @param string $location_no
     * @return int
     */
    function getLocatioinId($location_no,$warehouse_id=NULL){
        if($warehouse_id != null){
            $where  = ' and warehouse_id='.$warehouse_id;
        }
        $location_id    = M('location')->where('barcode_no like \''.trim($location_no).'\''.$where)->getField('id');
        return $location_id;
    }

    function getLocationNo($location_id,$warehouse_id=NULL){
		static $location_no	= array();
		$where				= array();
		if(!is_null($warehouse_id)){
            $where['warehouse_id']  = $warehouse_id;
        }
        if(!empty($location_id)){
			if (is_array($location_id)) {
				$data			= array();
				foreach ($location_id as $key => $id) {
					if (isset($location_no[$id])) {
						$data[$id]	= $location_no[$id];
						unset($location_id[$key]);
					}
				}
				if (!empty($location_id)) {
					$where['id']	= array('in', $location_id);
					$barcode_no		= M('location')->where($where)->getField('id, barcode_no');
					if ($barcode_no) {
						$data		= $data + $barcode_no;
					}
				}
				$location_no	= $location_no + $data;
				return $data;
			} else {
				if (!isset($location_no[$location_id])) {
					$where['id']  = $location_id;
					$location_no[$location_id]	= M('location')->where($where)->getField('barcode_no');
				}
                return $location_no[$location_id];
			}
        }else{
            return $location_id;
        }
    }

    /**
     * 查询库位ID
     * @author yyh 20151023
     * @param string $location_no
     * @return int
     */
    function getBarcodeNoById($location_id){
        if(empty($location_id)){
            return '';
        }
        if(is_array($location_id)){
            $location_id    = implode(',', $location_id);
        }
        return M('location')->where('id in ('.$location_id.')')->getField('id,barcode_no');
    }
	/**
	 * 解压缩字符串
	 * @author jph 20141201
	 * @param string $string
	 * @param string $type encode:压缩; decode:解压
	 * @return string
	 */
	function stringCompress($string, $type = 'encode'){
		if (empty($string)) {
			return $string;
		}
		$magic_quotes_gpc	= get_magic_quotes_gpc() === 1 ? true : false;
		if ($type == 'encode') {
			if ($magic_quotes_gpc === false) {
				$string	= addslashes($string);
			}
			$string	= base64_encode(gzdeflate($string, 9));
		} else {
			$string	= gzinflate(base64_decode($string));
			if ($magic_quotes_gpc === false) {
				$string	= stripcslashes($string);
			}
		}
		return $string;
	}

	/**
	 * 派送费用计算每公斤增加费用
	 * @param boolean $is_sql 是否sql
	 * @param float $order_weight 订单总重量G
	 * @param array $express_data 派送方式信息
	 * @return string
	 */
	function step_price_calculate($is_sql, $order_weight = 0, $express_data = array()){
		if ($is_sql) {
           return 'if(f.step_price>0, ceil(if(d.calculation=1 and '.volume_weight_calculate(true).'>a.weight,'.volume_weight_calculate(true).',a.weight)/1000)*f.step_price,0)';
		} else {
            if(in_array($express_data['company_id'],C('STEP_PRICE_CALCULATE'))){
                return $order_weight > 0 && $express_data['step_price'] > 0 ? ceil(($order_weight-$express_data['weight_begin']) / 1000) * $express_data['step_price'] : 0;
            }
			return $order_weight > 0 && $express_data['step_price'] > 0 ? ceil($order_weight / 1000) * $express_data['step_price'] : 0;
		}
	}
    /**
	 * 派送费用重量的选择
	 * @param float $order_weight 订单总重量G
     * @param float $order_volume_weight 订单体积重G
	 * @param array $express_data 派送方式信息
	 * @return string
	 */
	function  choose_weight($order_weight,$order_volume_weight,$express_data = array()){
        if($express_data['calculation']==1&&$order_weight<$order_volume_weight){
           $order_weight=$order_volume_weight;
        }
        return $order_weight;
	}
    /**
	 * 体积重的计算
	 * @param boolean $is_sql 是否sql
	 * @param float $volume 体积
     * @param boolean $flag 体积重是否选择向上取整
	 * @return string
	 */
	function volume_weight_calculate($is_sql,$volume=0,$flag=true){
		if ($is_sql) {
           return 'ceil(a.cube_long*a.cube_wide*a.cube_high/6000*2)/2*1000';
		} else {
            if($flag){
                $volume_weight=$volume/6000*1000;
            }
            else{
                $volume_weight=ceil($volume/6000*2)/2*1000;
            }
            return $volume_weight;
		}
	}
	/**
	 *
	 * @param mixed $arr1
	 * @param mixed $arr2
	 * @param int $level
	 * @return mixed
	 */
	function array_merge_deep($arr1, $arr2, $level = 0){
		if (empty($arr1) || !is_array($arr1)) {
			return $arr2;
		}
		if (empty($arr2) || !is_array($arr2)) {
			return $level > 0 ? $arr2 : $arr1;
		}
		foreach ($arr2 as $key => $val) {
			$arr1[$key]	= array_merge_deep($arr1[$key], $val, $level + 1);
		}
		return $arr1;
	}

    //重量G转KG 保留$num位小数
    function WeightGtoKG($weight,$num=2,$rate=1000){
        $weight         = $weight/$rate;
        $min_weight     = 1/pow(10, $num);
        if($weight<=$min_weight){
            return $min_weight;
        }
        return substr(sprintf("%.10f", $weight), 0, $num-10);
    }
    //计算工作日added yyh 20150924
    function workDays($start,$end){
        $end < $start && exit;
        $double =  ($end - $start)/(7*24*3600);
        $double = floor($double);
        $start = date('w',$start);
        $end   = date('w',$end);
        $end = $start > $end ? $end + 5 : $end;
        return $double * 5 + $end - $start;
    }

    //$days个工作日前的日期added yyh 20150924
    function workDaysDate($date,$days){
        is_string($date) && $date = strtotime($date);
        $weeks  = floor($days/5);
        $days   = $days%5;
        $w      = date('w',  intval($date));
        $days   += $w < $days ? 2  :0;
        $days   = -$weeks*7-$days;
        return date('Y-m-d',strtotime($days." day"));
    }

    function dre($info){
        dump($info);
        rollback();
        exit;
    }

	/**
	 * 根据退货服务编号获取退货服务id
	 * @staticvar array $return_service
	 * @param string $return_service_no
	 * @return int
	 */
	function getReturnServiceId($return_service_no){
		static $return_service	= array();
		if (!isset($return_service[$return_service_no])) {
			$where	= array('return_service_no' => $return_service_no);
			$return_service[$return_service_no]	= empty($return_service_no) ? 0 : intval(M('ReturnService')->where($where)->getField('id'));
		}
		return $return_service[$return_service_no];
	}

	/**
	 * 根据退货服务id及项目编号获取编退货服务项目id
	 * @staticvar array $return_service_item_number
	 * @param string $item_number
	 * @param int $return_service_id
	 * @return int
	 */
	function getApiXmlFileName($id, $request_time, $is_request){
		$path	= DATA_PATH . 'ApiXml/'.date('Ymd', strtotime($request_time)) . '/';
		mk_dir($path);
		@chmod($path, 0777);
		return	$path . ($id ? $id : 'fail') . ($is_request ? '_request' : '_return') . '.xml';
	}
    /**
	 * 验证退货单号
	 * @author yyh 20150612
	 * @param string $ReturnOrderNo
	 * @return boolean.
	 */
	function validReturnOrderNo($ReturnOrderNo){
		if (empty($ReturnOrderNo) || preg_match('/^RT\d{10}$/i', $ReturnOrderNo) == 0){
			return false;
		}
		return true;
	}

    //科学计数法转字符串
    function NumToStr($num){
        if (stripos($num,'E')===false) return $num;

        $num = trim(preg_replace('/[=\'"]/','',$num,1),'"');//出现科学计数法，还原成字符串
        $result = "";
        while ($num > 0){
            $v = $num - floor($num / 10)*10;
            $num = floor($num / 10);
            $result   =   $v . $result;
        }
        return $result;
    }
    function a2bc($a,$b,$c){
        return $a ? $b : $c;
    }
    //获取产品ID
    function getProductIdByBarcode($product_id){
        if(!empty($product_id) && is_array($product_id)){
            return M('product')->where('product_id in ('.implode(',', $product_id).')')->getField('custom_barcode','product_id');
        }
    }


	function getReturnServiceItemNumberId($item_number, $return_service_id){
		static $return_service_item_number	= array();
		if (!isset($return_service_item_number[$return_service_id][$item_number])) {
			$where	= array('item_number' => $item_number, 'return_service_id' => $return_service_id);
			$return_service_item_number[$return_service_id][$item_number]	= $return_service_id <= 0 || empty($item_number) ? 0 : intval(M('ReturnServiceDetail')->where($where)->getField('id'));
		}
		return $return_service_item_number[$return_service_id][$item_number];
	}

	/**
	 * post方式请求数据
	 * @author jph 20150829
	 * @param string $url
	 * @param array/string $post
	 * @return mixed
	 */
	function requestDataByPost($url, $post = array()) {
		if (empty($url)) {
			return '';
		}
		if (is_array($post)) {
			ksort($post);
			$post	= http_build_query($post, '', '&');
		}
		$context['http']	= array(
								'method'	=> 'POST',
								'content'	=> $post,
							);
		$path				= str_replace('&amp;', '&', $url);
		$data				= file_get_contents($path, false, stream_context_create($context));
		return $data;
	}

	/**
	 *
	 * @param type $url
	 * @param type $post
	 * @return type
	 */
	function curlRequest($url, $post = array()){
		$ch				= curl_init(); //初始化
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);	//获取内容不直接输出
		curl_setopt($ch, CURLOPT_TIMEOUT, 60);			//超时
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
		$response		= array(
							'errno'		=> curl_errno($ch),
							'content'	=> curl_exec($ch),
						);
		curl_close($ch);
		return $response;
	}

	/**
	 * 获取时区
	 * @param TimeZone $timezone_identifier 默认为空取当前系统时区
	 * @return float
	 */
	function getTimeZone($timezone_identifier = '', $timeZone = null){
		$differ	= false;
		if (!empty($timezone_identifier)) {
			$cur_zone	= date_default_timezone_get();
			if ($timezone_identifier != $cur_zone) {
				$differ	= true;
				date_default_timezone_set($timezone_identifier);
			}
		}
		if (is_null($timeZone)) {
			$timeZone	= date('O');
		}
		if ($differ) {
			date_default_timezone_set($cur_zone);
		}
		return intval($timeZone/100) + $timeZone%100/60;
	}

	/*
	 * 时区转换
	 * @param datetime $dateTime
	 * @param string $from_timeZone
	 * @param string $to_timeZone
	 * @param string $dateFormat
	 * @return datetime
	 */
	function toTimeZone($dateTime, $fromTimeZone = 'Asia/Shanghai', $toTimeZone = 'Europe/Berlin', $dateFormat = 'Y-m-d H:i:s') {
		$DateTime = new DateTime($dateTime, new DateTimeZone($fromTimeZone));
		$DateTime->setTimezone(new DateTimeZone($toTimeZone));
		return $DateTime->format($dateFormat);
	}


	/**
	 * 按字段配置构造数组
	 * @author jph 20150908
	 * @param array $data
	 * @param array $fields
	 * 示例
	 * array(
	 *	'新字段名称' => 0,			//值为0时非必填
	 *	'新字段名称'	=> 子数组,		//多维数组 必填 递归处理
	 *  '新字段名称' => '旧字段名称'	//必填
	 *  '新字段名称',				//此时旧字段名称与新字段名称一致
	 * )
	 * @return array
	 */
	function make_array_by_fields($data, $fields) {
		$result	= array();
		foreach ($fields as $key => $field) {
			switch (true) {
				case is_numeric($field)://field为0时非必填
					if ($field != 0 || array_key_exists($key, $data)) {
						$result[$key]	= $data[$key];
					}
					break;
				case is_array($field)://二维数组
					if (is_numeric($key)) {
						foreach ($data as $val) {
							$result[]	= make_array_by_fields($val, $field);
						}
					} else {
						$result[$key]	= make_array_by_fields($data[$key], $field);
					}
					break;
				default ://必填
					if (is_string($key)) {
						$result[$key]	= $data[$field];
					} else {
						$result[$field]	= $data[$field];
					}
					break;
			}
		}
		return $result;
	}
	/**
	 * 获取卖家自定义条码信息
	 */
    function isCustomBarcode($factory_id){
        if(!empty($factory_id)){
            return M('company_factory')->where('factory_id='.$factory_id)->field('is_custom_barcode')->find();
//            return M('company_factory')->where('factory_id in ('.$factory_id.')')->getField('is_custom_barcode');
        }
    }

	/**
	 *
	 * @param array $data
	 * @param array $fields
	 * @param array &$result
	 */
	function parse_xml_data($data, $fields, &$result){
		if (!is_array($data) || empty($data)) {
			return $data;
		}
		foreach ($fields as $field => $value) {
			if (is_numeric($field)) {
				$field	= $value;
				$value	= array();
			} elseif($value === false) {
				$value	= array(
					'field_required'	=> false,
				);
			} elseif (is_string($value)) {
				$value	= array(
					'field_name'	=> $value,
				);
			}
			$key	= $value['field_name'] ? $value['field_name'] : $field;
			if (empty($value['field_type']) && $value['fields']){
				$value['field_type']	= 'array';
			}
			if (!array_key_exists($field, $data) && array_key_exists('field_value', $value)) {
				$value['field_type']		= 'default';
				$value['field_required']	= true;
			}
			if (array_key_exists($field, $data) || $value['field_required'] !== false) {
				switch ($value['field_type']) {
					case 'default':
						$result[$key]	= $value['field_value'];
						break;
					case 'extend':
						$result[$key]	= array();
						if ($value['field']) {
							parse_xml_data($data[$value['field']], $value['fields'], $result[$key]);
						} else {
							parse_xml_data($data, $value['fields'], $result[$key]);
						}
						break;
					case 'array':
						if (!empty($data[$field])) {
							$result[$key]	= array();
							parse_xml_data($data[$field], $value['fields'], $result[$key]);
						}
						break;
					case 'children':
						if (!isset($data[$field][0])) {
							$data[$field]	= array($data[$field]);
						}
						foreach ((array)$data[$field] as $val) {
							if (is_array($val)) {
								$rs	= array();
								parse_xml_data($val, $value['fields'], $rs);
							} else {
								$rs	= $val;
							}
							if (!is_null($rs)) {
								$result[]	= $rs;
							}
						}
						break;
					case 'float'://浮点型
						$result[$key]	= floatval($data[$field]);
						break;
					case 'int'://整型
						$result[$key]	= intval($data[$field]);
						break;
					case 'date'://日期
						$result[$key]	= trim($data[$field]);
						break;
					case 'string'://字符串
					default :
						$result[$key]	= trim($data[$field]);
						break;
				}
				if (!in_array($value['field_type'], array('children')) && $value['function'] && function_exists($value['function'])) {
					$params	= array_key_exists('params', $value) ? (is_array($value['params']) ? $value['params'] : array($value['params'])) : array();
					array_unshift($params, $result[$key]);
					$result[$key]	= call_user_func_array($value['function'], $params);
				}
			}
		}
	}


	/**
	 *
	 * @param array $data
	 * @param array $fields
	 * @param array &$result
	 */
	function make_xml_data($data, $fields, &$result){
		if (!is_array($data) || empty($data)) {
			$result	= array();
			return;
		}
		foreach ($fields as $field => $value) {
			if (is_numeric($field)) {
				$field	= $value;
				$value	= array();
			} elseif($value === false) {
				$value	= array(
					'field_required'	=> false,
				);
			} elseif (is_string($value)) {
				$value	= array(
					'field_name'	=> $value,
				);
			}
			$key	= $value['field_name'] ? $value['field_name'] : $field;
			if (empty($value['field_type'])){
				if ($value['field_children']) {
					$value['field_type']	= 'parent';
				} elseif ($value['fields']) {
					$value['field_type']	= 'array';
				}
			}
			if (!array_key_exists($key, $data) && array_key_exists('field_value', $value)) {
				$value['field_type']		= 'default';
				$value['field_required']	= true;
			}
			if (array_key_exists($key, $data) || $value['field_required'] !== false) {
				switch ($value['field_type']) {
					case 'default':
						$result[$field]	= $value['field_value'];
						break;
					case 'array':
						if (!empty($data[$key])) {
							make_xml_data($data[$key], $value['fields'], $result[$field]);
						}
						break;
					case 'parent':
						foreach ($data[$key] as $val) {
							if (is_array($val)) {
								$rs	= array();
								make_xml_data($val, $value['fields'], $rs);
							} else {
								$rs	= $val;
							}
							$result[$field][$value['field_children']][]	= $rs;
						}
						break;
					default :
						$result[$field]	= $data[$key];
						break;
				}
				if (!in_array($value['field_type'], array('parent')) && $value['function'] && function_exists($value['function'])) {
					$params	= array_key_exists('params', $value) ? (is_array($value['params']) ? $value['params'] : array($value['params'])) : array();
					array_unshift($params, $result[$field]);
					$result[$field]	= call_user_func_array($value['function'], $params);
				}
			}
		}
	}

	/****************************************************************************
	 * 菜鸟系统对接函数 st														*
	 ****************************************************************************/
	/**
	 * 获取菜鸟api配置及函数
	 */
	function cainiao_load_file(){
		$config_file	= array('action_config', 'fields_config', 'extendDd');
		foreach ($config_file as $file_name) {
			$file_path	= THINK_PATH . 'CaiNiao/' . $file_name . '.php';
			if(is_file($file_path)){
				C(include $file_path);
			}
		}
		$function_file	= array('functions', 'functions_extend');
		foreach ($function_file as $file_name) {
			$file_path	= THINK_PATH . 'CaiNiao/' . $file_name . '.php';
			if(is_file($file_path)){
				require_cache($file_path);
			}
		}
	}

	/**
	 * 菜鸟系统生成消息签名
	 * @author jph 20150831
	 * @param string $logistics_interface 报文xml
	 * @return string
	 */
	function cainiao_get_data_digest($logistics_interface, $sign_key = null, $charset = ''){
		$key		= is_null($sign_key) ? (IS_4PX === true ? C('4PX_SIGN_KEY') : C('CAINIAO_SIGN_KEY')) : $sign_key;
		$content	= $charset ? iconv ('UTF-8', $charset, $logistics_interface . $key) : $logistics_interface . $key;
		$md5bin		= md5bin($content);
		return base64_encode($md5bin);
	}

	/**
	 * 获取指定字符串md5二进制加密串
	 * @param string $string
	 * @return string
	 */
	function md5bin($string) {
		$md5	= md5($string);
		$ret	= '';
		for ($i = 0; $i < 32; $i += 2){
			$ret	.= chr(hexdec($md5{$i + 1}) + hexdec($md5{$i}) * 16);
		}
		return $ret;
	}

	/**
	 * 获取菜鸟Api Xml 保存文件名
	 * @param int $request_id
	 * @param datetime $request_time
	 * @param string $msg_type
	 * @param boolean $is_request
	 * @param string $dir
	 * @return type
	 */
	function cainiao_get_xml_file_name($request_id, $request_time, $msg_type, $is_request = true, $dir = 'CaiNiaoXml'){
		$path	= DATA_PATH . $dir . '/'.date('Ymd', strtotime($request_time)) . '/' . $msg_type . '/';
		mk_dir($path);
		@chmod($path, 0777);
		return	$path . ($request_id ? $request_id : 'fail') . ($is_request ? '_request' : '_return') . '.xml';
	}

	/**
	 * 保存菜鸟Api Xml信息
	 * @param int $request_id
	 * @param string $xml		内容
	 * @param datetime $request_time
	 * @param string $msg_type
	 * @param boolean $is_request 请求/返回
	 * @param string $dir
	 * @return int
	 */
	function cainiao_save_xml($request_id, $xml, $request_time, $msg_type, $is_request = true, $dir = 'CaiNiaoXml'){
		$filename	= cainiao_get_xml_file_name($request_id, $request_time, $msg_type, $is_request, $dir);
		return file_put_contents($filename, $xml, FILE_APPEND);
	}

	/**
	 * 获取菜鸟Api Xml信息
	 * @param int $request_id			ID
	 * @param datetime $request_time
	 * @param boolean $is_request 请求/返回
	 * @param string $dir
	 * @return string
	 */
	function cainiao_get_xml($request_id, $request_time, $msg_type, $is_request = true, $dir = 'CaiNiaoXml'){
		if ($request_id <= 0) {
			return '';
		}
		$filename	= cainiao_get_xml_file_name($request_id, $request_time, $msg_type, $is_request, $dir);
		return file_get_contents($filename);
	}


	/**
	 * 构造请求xml数组
	 * @author jph 20150829
	 * @param array $data 事件类型
	 * @return array
	 */
	function cainiao_make_request_xml($data){
		$eventHeader		= array(
								'eventType'			=> $data['eventType'],			//事件类型
								'eventTime'			=> $data['eventTime'],			//报文发送时间 格式：yyyy-MM-dd HH:mm:ss
								'eventSource'		=> $data['eventSource'],		//事件发起方，仓库Code
								'eventTarget'		=> $data['eventTarget'],		//事件接收方，默认值：CAINIAO
							);
		$logisticsDetail	= cainiao_make_request_xml_logisticsdetail($data);
		$logisticsDetails	= array(
								'logisticsDetail'	=> $logisticsDetail,	//物流信息
							);
		$eventBody			= array(
								'logisticsDetails'	=> $logisticsDetails,	//物流信息列表
							);
		$logisticsEvent		= array(
								'eventHeader'		=> $eventHeader,		//报文头
								'eventBody'			=> $eventBody,			//报文体
							);
		$respnseXmlData		= array(
								'logisticsEvent'	=> $logisticsEvent,		//物流事件报文
							);
		import('ORG.Util.Array2XML');
		$xml				= Array2XML::createXML('request', $respnseXmlData);
		return $xml->saveXML();
	}

	/**
	 * 按指定事件类型的字段配置构造报文明细信息
	 * @param array $data 原始数据信息
	 * @return array
	 */
	function cainiao_make_request_xml_logisticsdetail($data) {
		$config_file		= array('request_fields_config', 'extendDd');
		foreach ($config_file as $file_name) {
			$file_path		= THINK_PATH . 'CaiNiao/' . $file_name . '.php';
			if(is_file($file_path)){
				C(include $file_path);
			}
		}
		$request_fields		= C('CAINIAO_REQUEST_FIELDS.' . $data['eventType']);
		$logisticsdetail	= make_array_by_fields($data, $request_fields);
		return $logisticsdetail;
	}

	/**
	 * 菜鸟api 保存请求日志
	 * @param array $data
	 */
	function cainiao_add_request($data){
		$data['module']			= $data['module']	? $data['module'] : MODULE_NAME;												//请求模块
		$data['action']			= $data['action']	? $data['action'] : ACTION_NAME;												//请求方法
		$data['factory_id']		= $data['factory_id'] ? $data['factory_id'] : C('CAINIAO_FACTORY_ID');								//卖家id
		$data['msg_type']		= $data['eventType']	= $data['msg_type'] ? $data['msg_type'] : $data['eventType'];				//消息类型 or 事件类型
		$data['eventSource']	= $data['logistic_provider_id']	= $data['eventSource'] ? $data['eventSource'] : C('TRAN_STORE_CODE');	//事件发起方
		$data['eventTarget']	= $data['eventTarget'] ? $data['eventTarget'] : C('CAINIAO_NO');									//事件接收方
		$data['eventTime']		= $data['eventTime'] ? $data['eventTime'] : date('Y-m-d H:i:s');									//事件发送时间

		//保存请求日志
		$cainiao_log			= array(
									'module'				=> $data['module'],					//请求模块
									'action'				=> $data['action'],					//请求方法
									'factory_id'			=> $data['factory_id'],				//卖家id
									'logistic_provider_id'	=> $data['eventSource'],			//消息内容，下发的所有报文内容都在此。
									'msg_type'				=> $data['msg_type'],				//消息类型
									'eventType'				=> $data['eventType'],				//事件类型
									'eventTime'				=> $data['eventTime'],				//事件发送时间
									'eventSource'			=> $data['eventSource'],			//事件发起方
									'eventTarget'			=> $data['eventTarget'],			//事件接收方
									'logisticsOrderCode'	=> $data['logisticsOrderCode'],		//退货物流单号 ，简称LP号
									'success'				=> $data['result']['success'],
								);
		$request_id				= M('CaiNiaoLog')->add($cainiao_log);
		$xml					= cainiao_make_request_xml($data);
		cainiao_save_xml($request_id, $xml, $data['eventTime'], $data['msg_type']);//保存请求xml
		return $request_id;
	}

	/**
	 * 是否为菜鸟api的退货单id
	 * @param int $return_sale_order_id
	 * @param string $return_logistics_no
	 * @return int
	 */
	function cainiao_return_sale_order_id($return_sale_order_id = 0, $return_logistics_no = ''){
		static $ids	= array();
		$where		= cainiao_return_sale_order_where();
		if ($return_sale_order_id > 0) {
			if (isset($ids[$return_sale_order_id])) {
				return $ids[$return_sale_order_id];
			}
			$where['detail.return_sale_order_id']	= $return_sale_order_id;
		} elseif (!empty($return_logistics_no)) {
			$where['main.return_logistics_no']		= $return_logistics_no;
		} else {
			return 0;
		}
		$join		= '__RETURN_SALE_ORDER__ main on main.id=detail.return_sale_order_id';
		$id			= M('ReturnSaleOrderDetail')->alias('detail')->join($join)->where($where)->getField('return_sale_order_id');
		if ($return_sale_order_id > 0) {
			$ids[$return_sale_order_id]	= $id;
		}
		return $id;
	}

	/**
	 * 获取请求数据
	 * @return array
	 */
	function cainiao_get_need_request_where () {
		$where	= array(
					'request_status'	=> array('in', C('CAINIAO_ALLOW_REQUEST_STATUS')),
				);
		return $where;
	}

	/**
	 *
	 * @param string $main_prefix return_sale_order 表别名
	 * @param string $detail_prefix return_sale_order_detail 表别名
	 * @return array
	 */
	function cainiao_return_sale_order_where($main_prefix = 'main', $detail_prefix = 'detail', $return_string = false){
		if ($return_string) {
			$where	= $main_prefix . '.factory_id=' . C('CAINIAO_FACTORY_ID') . ' and ' . $detail_prefix . '.warehouse_id=' . C('EXPRESS_ES_WAREHOUSE_ID') . ' and ' . $main_prefix . '.is_related_sale_order<>' . C('IS_RELATED_SALE_ORDER');
		} else {
			$where	= array(
						$main_prefix . '.factory_id'			=> C('CAINIAO_FACTORY_ID'),
						$detail_prefix . '.warehouse_id'		=> C('EXPRESS_ES_WAREHOUSE_ID'),
						$main_prefix . '.is_related_sale_order'	=> array('neq', C('IS_RELATED_SALE_ORDER')),//不关联销售单
					);
		}
		return $where;
	}

	/**
	 * 是否为菜鸟系统类型退货单
	 * @param array $params
	 * @return boolean true:是 false:否
	 */
	function cainiao_return_sale_order($params){
		return $params['factory_id'] == C('CAINIAO_FACTORY_ID') && $params['warehouse_id'] == C('EXPRESS_ES_WAREHOUSE_ID') && $params['is_related_sale_order'] != C('IS_RELATED_SALE_ORDER');
	}

	/**
	 *
	 * @return array
	 */
	function cainiao_request_success() {
		return array(CAINIAO_REQUEST_STATUS_SUCCESS, CAINIAO_REQUEST_STATUS_RETRY_SUCCEEDS);
	}

	/**
	 *
	 * @param string $msg_type
	 * @param string $return_logistics_no
	 * @param string $success
	 * @return type
	 */
	function cainiao_request_not_abandon_count($msg_type, $return_logistics_no, $success = 'true'){
		return cainiao_request_count($msg_type, $return_logistics_no, $success, array('neq', CAINIAO_REQUEST_STATUS_ABANDON));
	}

	/**
	 *
	 * @param string $msg_type
	 * @param string $return_logistics_no
	 * @param string $success
	 * @param int|array $request_status
	 * @return int
	 */
	function cainiao_request_count($msg_type, $return_logistics_no, $success = 'true', $request_status = null){
		$where	= array(
					'msg_type'				=> $msg_type,
					'logisticsOrderCode'	=> $return_logistics_no,
				);
		if (!empty($success)) {
			$where['success']	= $success;
		}
		if (!empty($request_status) || $request_status === 0) {
			$where['request_status']	= is_array($request_status) && is_numeric(reset($request_status)) ? array('in', $request_status) : $request_status;
		}
		$count	= (int)M('CaiNiaoLog')->where($where)->count();
		return $count;
	}
	/****************************************************************************
	 * 菜鸟系统对接函数 ed														*
	 ****************************************************************************/

	/**
	 * 创建条形码图片     add by lxt 20150521
	 * @param array $name   编码内容和图片名组成的数组
	 * @param string $path  路径
	 * @param array $barcode_config    自定义配置
	 * @param array $hri    描述
	 * @param array $err_return_type    错误返回类型 1-提示错误,2-返回false
	 */
	function createBarcodeImg($name,$path,$barcode_config=array(),$hri=array(),$err_return_type = 1){
		if (!is_array($name))
		{
			$name  =   array(
				'name' =>  strval($name),
				'code' =>  strval($name),
			);
		}
		//加载条形码字体类
		vendor('Barcode.BCGFontFile');
		//加载条形码颜色类
		vendor('Barcode.BCGColor');
		//加载条形码绘图类
		vendor('Barcode.BCGDrawing');
		$img_type	= C('BARCODE_PC_TYPE') ? C('BARCODE_PC_TYPE') : 'gif';//图片格式
		//根据编码类型加载对应的条形码编码类
		$code_type	= C('BARCODE_CODE_TYPE') ? C('BARCODE_CODE_TYPE') : 'code128';//条形码编码类型
		$class = 'BCG'.$code_type;
		vendor('Barcode.'.$class,'','.barcode.php');
		//文件名
		$filename	= $path . '/' . $name['name'] . '.' . $img_type;
		$default_config	= array(
			'w'            => 150,     //画布宽度
			'h'            => 80,      //画布高度
			'thickness'    => 50,      //条形码高度
			'padding'      => 1,       //条形码间隔
			'scale'        => 1,       //条形码宽度
			'fontSize'     => 8,       //标签字体大小
			'spacing'      => 12,      //额外信息上边距
			'offsetY'		=> 10,		//上间距
		);
		if (count($barcode_config)){
			$default_config    =   array_merge($default_config,$barcode_config);
		}
		extract($default_config);
		$color_black = new BCGColor(0, 0, 0);
		$color_white = new BCGColor(255, 255, 255);
		$font_url   = APP_FONTS_PATH . 'Arial.ttf';
		$font = new BCGFontFile($font_url, $fontSize);//中文字体
		if (mk_dir($path) && @is_writable($path)) {
			try{
				//编码
				$barcode = new $class();
				$barcode->setScale($scale);
				$barcode->setThickness($thickness);
				$barcode->setPadding($padding);
				$barcode->setForegroundColor($color_black);
				$barcode->setBackgroundColor($color_white);
				$barcode->setFont($font);
				$barcode->parse($name['code']); //参数只能为字符型
				//描述
				if (is_array($hri)) {
					$hri	= implode("\n", $hri);
				}
				$hri	= mb_convert_encoding($hri, "html-entities", "utf-8");//解决中文乱码
				$hri	= autoWrap($fontSize, 0, $font_url, $hri, max($w-20,0));
	//	        if (count($hri) > 0){
					$barcode->clearLabels();
					$i = 0;
	//	            foreach ($hri as $data){
	//                $data = mb_convert_encoding($data, "html-entities", "utf-8");
					$label = new BCGLabel($hri,$font);
					$label->setSpacing($spacing*$i+2);//行距
					$barcode->addLabel($label);
					unset($label);
					$i++;
	//	            }
	//	        }
				//绘制
				$drawing = new BCGDrawing($filename, $color_white);
				$drawing->setDPI(72);
				$drawing->setBarcode($barcode);
				$drawing->drawMyBarcode($w, $h, $offsetY);
				//保存格式
				switch ($img_type){
					case 'png':
						$ext = BCGDrawing::IMG_FORMAT_PNG;
						break;
					case 'jpg':
						$ext = BCGDrawing::IMG_FORMAT_JPEG;
						break;
					case 'bmp':
						$ext = BCGDrawing::IMG_FORMAT_WBMP;
						break;
					default:
						$ext = BCGDrawing::IMG_FORMAT_GIF;
						break;
				}

				//保存图片
				$drawing->finish($ext);
			} catch (Exception $ex) {
				if($err_return_type == 1){
					throw_json(L('incorrect_barcode'));
				}
				return false;
				
			}
		} else {
			if($err_return_type == 1){
				throw_json(L('dir_right_error'));	
			}
			return false;
		}
	}

    /*
     * 验证时间格式
     * $date string
     * $format string
     */
    function ValidateDate($date, $format = 'Y-m-d H:i:s'){
        $version = explode('.', phpversion());
        if (((int) $version[0] >= 5 && (int) $version[1] >= 2 && (int) $version[2] > 17)) {
            $d = DateTime::createFromFormat($format, $date);
        } else {
            $d = new DateTime(date($format, strtotime($date)));
        }
        return $d && strtotime($d->format($format)) == strtotime($d->format($format));
    }
	/*
     * 中国时间格式Y-m-d
     * 欧洲时间格式d/m/y
     */
    function checkdateDate($date,$is_time=false){
        $date   = trim($date);
        $is_time_str    = $is_time ? '\s+\d{1,2}:\d{1,2}:\d{1,2}' : '';
        if(preg_match("/^\d{4}-\d{1,2}-\d{1,2}".$is_time_str."$/",$date) || preg_match("/^\d{1,2}\/\d{1,2}\/\d{4}".$is_time_str."$/",$date)){
            return true;
        }
        return FALSE;
    }
    function getProductBarcodeInfo($product_id){
        if(empty($product_id)){
            return '';
        }
        if(!is_array($product_id)){
            $product_id = explode(',', $product_id);
        }
        foreach($product_id as $p_id){
            if($p_id>0){
                $product_id_arr[$p_id]  = $p_id;
            }
        }
        $product_info   = M('product')
                ->alias('p')
                ->field('p.id as id,p.product_no as product_no,p.product_name as product_name,c.product_barcode_config as product_barcode_config,p.custom_barcode as custom_barcode')
                ->join('__COMPANY__ c on c.id=p.factory_id')
                ->where('p.id in ('.implode(',', $product_id_arr).')')
                ->getField('id,id,product_no,product_name,product_barcode_config,custom_barcode');
		foreach($product_info as &$p_info){
            $product_barcode_config =  empty($p_info['product_barcode_config']) ? $p_info['product_barcode_config'] :explode(',', $p_info['product_barcode_config']);
            $hri	= array(
                'code'          => $p_info['custom_barcode'],
				'product_name'	=> '   ' . $p_info['product_name'],
				'sku'			=> $p_info['product_no'],
			);
            if ($product_barcode_config) {
				$product_barcode_config_filter	= array();
				if (in_array('product_name', $product_barcode_config)) {
					$wrap	= false;
					$product_barcode_config_filter[]	= 'product_name';
				} else {
					unset($hri['product_name']);
				}
				if (isset($hri['sku']) && in_array('made_in_china', $product_barcode_config)) {
					$hri['sku']	.= '   ' . L('made_in_china');
					$product_barcode_config_filter[]	= 'made_in_china';
				}
				foreach ($product_barcode_config as $config) {
					if (!in_array($config, $product_barcode_config_filter)) {
						$hri[$config]	= isset($product[$config]) ? $product[$config] : L($config);
					}
				}
			} else {
				unset($hri['product_name']);
			}
            $p_info['html']= '<span style="color:#000000;">'.implode('<br /></span><span style="color:#000000;">', $hri).'</span>';
        }
        return $product_info;
    }


    /**获取国内运费
     * @author add yyh 20151208
     * @param int $warehouse_id
     * @param int $transport_type  //运输方式
     * @param array $review //空运复核重量/海运复核体积
     * @return array
     */
    function domesticShippingFee($warehouse_id,$transport_type,$review){
        $where  = array();
        $where['transport_type']    = $transport_type;
        $where['warehouse_id']      = $warehouse_id;
        return (float)M('DomesticShippingFee')->alias('dsf')->join('left join __DOMESTIC_SHIPPING_FEE_DETAIL__ dsfd on dsf.id=dsfd.domestic_shipping_fee_id and weight_begin<='.$review.' and weight_end>='.$review)->where($where)->getField('price');
    }

    /**卖家折扣
     * @author add yyh 20151208
     * @param string $factory_id
     * @return array
     */
    function getCompanyFactory($factory_id,$field){
        is_array($factory_id) && $factory_id = implode(',', $factory_id);
        if(!empty($factory_id)){
            return M('CompanyFactory')->where('factory_id in ('.$factory_id.') and is_'.$field.'=1')->getField('factory_id,is_'.$field.' as is_charge,('.$field.'_percentage/100) as percentage');
        }
        return '';
    }

    function getInstockBoxInfo($box_id){
        if(empty($box_id)){
            return '';
        }

        if(!is_array($box_id)){
            $box_id = explode(',', $box_id);
        }
        foreach($box_id as $b_id){
            if($b_id>0){
                $box_id_arr[$b_id]  = $b_id;
            }
        }
        $rs 	= M('InstockBox')->field('*,detail.id as box_id,detail.cube_long*detail.cube_wide*detail.cube_high as cube,detail.check_long*detail.check_wide*detail.check_high as check_cube')->alias('detail')->join('__INSTOCK__ main on main.id=detail.instock_id')->where('detail.id in ('.  implode(',', $box_id).')')->select();
        $box_info   = M('instock_detail')
                ->alias('d')
                ->join('left join product p on d.product_id=p.id')
                ->where('box_id in ('.implode(',', $box_id_arr).')')
                ->field('d.box_id,p.product_no')
                ->select();
        foreach($rs as $box_val){
            $box_val    = _formatWeightCube(_formatArray($box_val));
            if(is_array($box_val) && $box_val['box_id'] > 0){
                $box_info_arr[$box_val['box_id']][]    = $box_val['box_id'];
                $box_info_arr[$box_val['box_id']][]    = $box_val['instock_no'];
                $box_info_arr[$box_val['box_id']][]    = 'BOX_NO: ' . $box_val['box_no'];
                $box_info_arr[$box_val['box_id']][]    = 'CLIENT_ID: ' . $box_val['factory_id'];
                $box_info_arr[$box_val['box_id']][]    = 'WEIGHT: ' . $box_val['s_unit_weight'];
                $box_info_arr[$box_val['box_id']][]    = array_shift(explode('=', $box_val['s_cube'] . L('volume_size_unit')));
                $box_info_arr[$box_val['box_id']][]    = SOnly('country', getWarehouseCountry($box_val['warehouse_id']),'abbr_district_name');
                foreach($box_info as $info_val){
                    if($box_val['box_id'] == $info_val['box_id']){
                        $box_info_arr[$box_val['box_id']][]    = $info_val['product_no'];
                    }
                    if(count($box_info_arr[$box_val['box_id']]) == 12){
                        break;
                    }
                }
            }
        }
        foreach($box_info_arr as $key=>$p_info){
            $box_info_arr[$key]['html']= '<span style="color:#000000;">'.implode('<br /></span><span style="color:#000000;">', $p_info).'</span>';
        }
        return $box_info_arr;
    }

	/**
	 * 数字转化为短代码
	 * @param int $number
	 * @param string $codes
	 * @return string
	 */
	function number_to_code($number, $codes	= 'abcdefghjkmnpqrstuvwxyz23456789ABCDEFGHJKMNPQRSTUVWXYZ'){
		$length	= strlen($codes);
		$out	= '';
		while ($number > $length - 1) {
			$key	= $number % $length;
			$number	= floor($number / $length) - 1;
			$out	= $codes{$key}.$out;
		}
		return $codes{$number}.$out;
	}

	/**
	 * 短代码还原为数字
	 * @param string $code
	 * @param string $codes
	 * @return int
	 */
	function code_to_number($code, $codes = 'abcdefghjkmnpqrstuvwxyz23456789ABCDEFGHJKMNPQRSTUVWXYZ'){
		$length	= strlen($codes);
		$num	= 0;
		$i		= strlen($code);
		for($j = 0; $j < strlen($code); $j++){
			$i--;
			$char	= $code{$j};
			$pos	= strpos($codes,$char);
			$num	+= (pow($length, $i) * ($pos + 1));
		}
		$num--;
		return $num;
	}

	function showImg($id) {
		$id = intval($id);
		if($id<=0) return ;
		$rs = M('gallery')->find($id);
		gallery_permission_validation_factory($rs);
		$file_name	= isset($_GET['view']) ? $rs['file_url'] : 'small_'.$rs['file_url'];
		$url = getUploadPath($rs['relation_type']).$file_name;
		$file = fopen($url,'r');
		if (empty($file)) { exit;}
		Header('Content-type: image/*');
		Header('Accept-Ranges: bytes');
		Header('Accept-Length: '.filesize($url));
		while (!feof($file)){echo fread($file, 8192);}
		fclose($file);
		exit();
    }

	function getTrueModule(){
		switch (MODULE_NAME) {
			case 'Api':
				$_module	= API_MODULE_NAME;
				break;
			case 'CaiNiao':
				$_module	= CAINIAO_MODULE_NAME;
				break;
			default :
				$_module	= MODULE_NAME;
				break;
		}
		return $_module;
	}

	function getTrueAction(){
		switch (getTrueModule()) {
			case 'Api':
				$_action	= API_ACTION_NAME;
				break;
			case 'CaiNiao':
				$_action	= CAINIAO_ACTION_NAME;
				break;
			default :
				$_action	= ACTION_NAME;
				break;
		}
		return $_action;
	}

	/**
	 * 数组降维
	 * @param array $array
	 * @return array
	 */
	function array_dimension_reduce($array){
		$new_array	= array();
		foreach ($array as $arr) {
			foreach ($arr as $val) {
				$new_array[]	= $val;
			}
		}
		return $new_array;
	}

	function get_warehouse_account_start_date($factory_id, $warehouse_id, $warehouse_fee_start_date){
		if ($factory_id > 0 && $warehouse_id > 0) {
			$where['factory_id']    = $factory_id;
			$where['warehouse_id']		= $warehouse_id;
			//上次对账时间
			$last_account_date			= M('warehouse_account')->where($where)->order('account_end_date desc')->getField('account_end_date');
			$account_start_date			= max($warehouse_fee_start_date, (empty($last_account_date) ? '0000-00-00' : $last_account_date));
			return $account_start_date;
		} else {
			return FALSE;
		}
	}

	function get_sale_order_barcode_info($data, $is_pdf = false){
		if ($is_pdf !== true && !empty($data['Labelurl'])) {
			if ($data['track_no_update_tips'] != 0) {
				M('SaleOrder')->save(array('id' => $data['id'], 'track_no_update_tips' => 0));
			}
			if ($data['company_id'] == C('EXPRESS_ES_CORREOS_ID')) {
				$data['Labelurl']	= WAY_BILL_PATH . $data['Labelurl'];
			}
			return array('pdf' => $data['Labelurl']);
		}
        if($data['company_id'] == C('EXPRESS_IT-NEXIVE_ID')){//IT-NEXIVE快递公司
            $PrintHtml  = 'getPrintHtmlITN';
            $size       = array('width'=>'94mm','height'=>'65mm','is_it_nexive'=>true);
		}elseif($data['shipping_type'] == C('SHIPPING_TYPE_SURFACE')) {//平邮
            $PrintHtml  = 'getPrintHtml';
            $size       = array('width'=>'56mm','height'=>'30mm');
        }else{//其他
            $PrintHtml  = 'getPrintHtmlDefault';
            $size       = array('width'=>'100mm','height'=>'65mm');
		}
        $htmlInfo   = A('SaleOrder')->$PrintHtml($data,$is_pdf);
		return array('size'=>$size,'info'=>$htmlInfo);
	}

	/**
	 * 数据验证角色权限（卖家/仓库）
	 * @param array $data
	 * @param string $field
	 * @return boolean
	 */
	function data_permission_validation($data, $field = ''){
		$user	= getUser();
		if ($user['company_id'] <= 0 || !in_array($user['role_type'], array(C('SELLER_ROLE_TYPE'), C('WAREHOUSE_ROLE_TYPE')))) {
			return true;
		}
		if (empty($field)) {
			$field	= $user['role_type'] == C('WAREHOUSE_ROLE_TYPE') ? 'warehouse_id' : 'factory_id';
		} elseif ($field == 'comp_id' && $user['role_type'] == C('WAREHOUSE_ROLE_TYPE')) {
			$field	= 'warehouse_id';
		}
		if ($data[$field] > 0 && $user['company_id'] != $data[$field]) {
			return false;
		}
		return true;
	}

	/**
	 * 附件验证卖家权限
	 * @param array $gallery
	 * @param boolean $exit
	 * @return boolean
	 */
	function gallery_permission_validation_factory($gallery, $exit = true){
		if (getUser('role_type') != C('SELLER_ROLE_TYPE')){
			return true;
		}
		switch ($gallery['relation_type']) {
			case 1://产品附件
				$result	= data_permission_validation(M('Product')->find($gallery['relation_id']));
				break;
			case 3://销售附件
			case 19://订单列表附件
				$result	= data_permission_validation(M('SaleOrder')->find($gallery['relation_id']));
				break;
			case 22://退货图片
				$result	= data_permission_validation(M('ReturnSaleOrder')->find($gallery['relation_id']));
				break;
			case 23://问题订单破损图片
			case 24://问题订单上传签收证明
			case 25://问题订单上传发票附件
				$result	= data_permission_validation(M('QuestionOrder')->find($gallery['relation_id']));
				break;
			case 27://退货入库图片服务
				$return_sale_order_id	= M('ReturnSaleOrderStorage')->where(array('id' => $gallery['relation_id']))->getField('return_sale_order_id');
				$result					= data_permission_validation(M('ReturnSaleOrder')->find($return_sale_order_id));
				break;
			case 29://信息公告附件
				$result	= message_permission_validation(M('Message')->find($gallery['relation_id']));
				break;
			case 30://卖家logo
				$result	= getUser('company_id') == $gallery['relation_id'];
				break;
			case 2://打板
			case 10://导入的Excel文件
			case 11://导入的追踪订单Excel文件
			case 12://导入的Excel文件 发货导入
			case 13://导入的Excel文件 入库单导入
			case 14://导入的Excel文件 订单导入
			case 15://导出的Excel文件 拣货导出
			case 16://导入的Excel文件 拣货导入
			case 17://导入的Excel文件 产品导入
			case 18://导入的Excel文件 库存调整导入
			case 20://订单导出
			case 21://发货入库导入
			case 26://移仓导入
			case 28://派送方式邮编导入
			case 31://邮件附件
				$result	= false;
			default:
				$result	= true;
				break;
		}
		if ($result === false) {
			if ($exit === false) {
				return false;
			}
			exit;
		}
		return true;
	}

	/**
	 * 信息公告验证数据权限
	 * @param array $message
	 * @return boolean
	 */
	function message_permission_validation($message){
		$user_type	= getUser('user_type');
		if ($user_type > 0) {
			$message_user_type	= explode(',', $message['user_type']);
			if (!in_array($user_type, $message_user_type)) {
				return false;
			}
		}
		return true;
	}

	function excel_import_filter($value){
		return str_replace(array('<br />', '<br/>', '<br>', "\n"), '', trim($value));
	}

	function valid_date($date){
		$time	= strtotime($date);
		return $time !== false && $time != -1 ? true : false;
	}

	function emoji_unified_to_html($text){
		$unified_to_html	= array(
			"\xc2\xa9"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emojia9\x22></span></span>",
			"\xc2\xae"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emojiae\x22></span></span>",
			"\xe2\x80\xbc"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji203c\x22></span></span>",
			"\xe2\x81\x89"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji2049\x22></span></span>",
			"\xe2\x84\xa2"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji2122\x22></span></span>",
			"\xe2\x84\xb9"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji2139\x22></span></span>",
			"\xe2\x86\x94"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji2194\x22></span></span>",
			"\xe2\x86\x95"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji2195\x22></span></span>",
			"\xe2\x86\x96"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji2196\x22></span></span>",
			"\xe2\x86\x97"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji2197\x22></span></span>",
			"\xe2\x86\x98"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji2198\x22></span></span>",
			"\xe2\x86\x99"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji2199\x22></span></span>",
			"\xe2\x86\xa9"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji21a9\x22></span></span>",
			"\xe2\x86\xaa"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji21aa\x22></span></span>",
			"\xe2\x8c\x9a"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji231a\x22></span></span>",
			"\xe2\x8c\x9b"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji231b\x22></span></span>",
			"\xe2\x8c\xa8"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji2328\x22></span></span>",
			"\xe2\x8f\xa9"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji23e9\x22></span></span>",
			"\xe2\x8f\xaa"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji23ea\x22></span></span>",
			"\xe2\x8f\xab"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji23eb\x22></span></span>",
			"\xe2\x8f\xac"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji23ec\x22></span></span>",
			"\xe2\x8f\xad"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji23ed\x22></span></span>",
			"\xe2\x8f\xae"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji23ee\x22></span></span>",
			"\xe2\x8f\xaf"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji23ef\x22></span></span>",
			"\xe2\x8f\xb0"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji23f0\x22></span></span>",
			"\xe2\x8f\xb1"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji23f1\x22></span></span>",
			"\xe2\x8f\xb2"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji23f2\x22></span></span>",
			"\xe2\x8f\xb3"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji23f3\x22></span></span>",
			"\xe2\x8f\xb8"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji23f8\x22></span></span>",
			"\xe2\x8f\xb9"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji23f9\x22></span></span>",
			"\xe2\x8f\xba"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji23fa\x22></span></span>",
			"\xe2\x93\x82"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji24c2\x22></span></span>",
			"\xe2\x96\xaa"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji25aa\x22></span></span>",
			"\xe2\x96\xab"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji25ab\x22></span></span>",
			"\xe2\x96\xb6"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji25b6\x22></span></span>",
			"\xe2\x97\x80"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji25c0\x22></span></span>",
			"\xe2\x97\xbb"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji25fb\x22></span></span>",
			"\xe2\x97\xbc"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji25fc\x22></span></span>",
			"\xe2\x97\xbd"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji25fd\x22></span></span>",
			"\xe2\x97\xbe"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji25fe\x22></span></span>",
			"\xe2\x98\x80"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji2600\x22></span></span>",
			"\xe2\x98\x81"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji2601\x22></span></span>",
			"\xe2\x98\x82"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji2602\x22></span></span>",
			"\xe2\x98\x83"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji2603\x22></span></span>",
			"\xe2\x98\x84"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji2604\x22></span></span>",
			"\xe2\x98\x8e"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji260e\x22></span></span>",
			"\xe2\x98\x91"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji2611\x22></span></span>",
			"\xe2\x98\x94"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji2614\x22></span></span>",
			"\xe2\x98\x95"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji2615\x22></span></span>",
			"\xe2\x98\x98"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji2618\x22></span></span>",
			"\xe2\x98\x9d"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji261d\x22></span></span>",
			"\xe2\x98\xa0"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji2620\x22></span></span>",
			"\xe2\x98\xa2"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji2622\x22></span></span>",
			"\xe2\x98\xa3"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji2623\x22></span></span>",
			"\xe2\x98\xa6"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji2626\x22></span></span>",
			"\xe2\x98\xaa"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji262a\x22></span></span>",
			"\xe2\x98\xae"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji262e\x22></span></span>",
			"\xe2\x98\xaf"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji262f\x22></span></span>",
			"\xe2\x98\xb8"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji2638\x22></span></span>",
			"\xe2\x98\xb9"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji2639\x22></span></span>",
			"\xe2\x98\xba"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji263a\x22></span></span>",
			"\xe2\x99\x88"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji2648\x22></span></span>",
			"\xe2\x99\x89"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji2649\x22></span></span>",
			"\xe2\x99\x8a"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji264a\x22></span></span>",
			"\xe2\x99\x8b"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji264b\x22></span></span>",
			"\xe2\x99\x8c"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji264c\x22></span></span>",
			"\xe2\x99\x8d"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji264d\x22></span></span>",
			"\xe2\x99\x8e"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji264e\x22></span></span>",
			"\xe2\x99\x8f"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji264f\x22></span></span>",
			"\xe2\x99\x90"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji2650\x22></span></span>",
			"\xe2\x99\x91"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji2651\x22></span></span>",
			"\xe2\x99\x92"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji2652\x22></span></span>",
			"\xe2\x99\x93"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji2653\x22></span></span>",
			"\xe2\x99\xa0"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji2660\x22></span></span>",
			"\xe2\x99\xa3"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji2663\x22></span></span>",
			"\xe2\x99\xa5"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji2665\x22></span></span>",
			"\xe2\x99\xa6"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji2666\x22></span></span>",
			"\xe2\x99\xa8"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji2668\x22></span></span>",
			"\xe2\x99\xbb"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji267b\x22></span></span>",
			"\xe2\x99\xbf"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji267f\x22></span></span>",
			"\xe2\x9a\x92"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji2692\x22></span></span>",
			"\xe2\x9a\x93"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji2693\x22></span></span>",
			"\xe2\x9a\x94"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji2694\x22></span></span>",
			"\xe2\x9a\x96"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji2696\x22></span></span>",
			"\xe2\x9a\x97"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji2697\x22></span></span>",
			"\xe2\x9a\x99"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji2699\x22></span></span>",
			"\xe2\x9a\x9b"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji269b\x22></span></span>",
			"\xe2\x9a\x9c"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji269c\x22></span></span>",
			"\xe2\x9a\xa0"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji26a0\x22></span></span>",
			"\xe2\x9a\xa1"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji26a1\x22></span></span>",
			"\xe2\x9a\xaa"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji26aa\x22></span></span>",
			"\xe2\x9a\xab"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji26ab\x22></span></span>",
			"\xe2\x9a\xb0"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji26b0\x22></span></span>",
			"\xe2\x9a\xb1"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji26b1\x22></span></span>",
			"\xe2\x9a\xbd"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji26bd\x22></span></span>",
			"\xe2\x9a\xbe"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji26be\x22></span></span>",
			"\xe2\x9b\x84"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji26c4\x22></span></span>",
			"\xe2\x9b\x85"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji26c5\x22></span></span>",
			"\xe2\x9b\x88"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji26c8\x22></span></span>",
			"\xe2\x9b\x8e"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji26ce\x22></span></span>",
			"\xe2\x9b\x8f"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji26cf\x22></span></span>",
			"\xe2\x9b\x91"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji26d1\x22></span></span>",
			"\xe2\x9b\x93"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji26d3\x22></span></span>",
			"\xe2\x9b\x94"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji26d4\x22></span></span>",
			"\xe2\x9b\xa9"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji26e9\x22></span></span>",
			"\xe2\x9b\xaa"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji26ea\x22></span></span>",
			"\xe2\x9b\xb0"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji26f0\x22></span></span>",
			"\xe2\x9b\xb1"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji26f1\x22></span></span>",
			"\xe2\x9b\xb2"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji26f2\x22></span></span>",
			"\xe2\x9b\xb3"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji26f3\x22></span></span>",
			"\xe2\x9b\xb4"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji26f4\x22></span></span>",
			"\xe2\x9b\xb5"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji26f5\x22></span></span>",
			"\xe2\x9b\xb7"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji26f7\x22></span></span>",
			"\xe2\x9b\xb8"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji26f8\x22></span></span>",
			"\xe2\x9b\xb9"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji26f9\x22></span></span>",
			"\xe2\x9b\xba"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji26fa\x22></span></span>",
			"\xe2\x9b\xbd"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji26fd\x22></span></span>",
			"\xe2\x9c\x82"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji2702\x22></span></span>",
			"\xe2\x9c\x85"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji2705\x22></span></span>",
			"\xe2\x9c\x88"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji2708\x22></span></span>",
			"\xe2\x9c\x89"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji2709\x22></span></span>",
			"\xe2\x9c\x8a"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji270a\x22></span></span>",
			"\xe2\x9c\x8b"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji270b\x22></span></span>",
			"\xe2\x9c\x8c"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji270c\x22></span></span>",
			"\xe2\x9c\x8d"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji270d\x22></span></span>",
			"\xe2\x9c\x8f"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji270f\x22></span></span>",
			"\xe2\x9c\x92"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji2712\x22></span></span>",
			"\xe2\x9c\x94"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji2714\x22></span></span>",
			"\xe2\x9c\x96"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji2716\x22></span></span>",
			"\xe2\x9c\x9d"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji271d\x22></span></span>",
			"\xe2\x9c\xa1"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji2721\x22></span></span>",
			"\xe2\x9c\xa8"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji2728\x22></span></span>",
			"\xe2\x9c\xb3"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji2733\x22></span></span>",
			"\xe2\x9c\xb4"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji2734\x22></span></span>",
			"\xe2\x9d\x84"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji2744\x22></span></span>",
			"\xe2\x9d\x87"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji2747\x22></span></span>",
			"\xe2\x9d\x8c"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji274c\x22></span></span>",
			"\xe2\x9d\x8e"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji274e\x22></span></span>",
			"\xe2\x9d\x93"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji2753\x22></span></span>",
			"\xe2\x9d\x94"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji2754\x22></span></span>",
			"\xe2\x9d\x95"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji2755\x22></span></span>",
			"\xe2\x9d\x97"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji2757\x22></span></span>",
			"\xe2\x9d\xa3"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji2763\x22></span></span>",
			"\xe2\x9d\xa4"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji2764\x22></span></span>",
			"\xe2\x9e\x95"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji2795\x22></span></span>",
			"\xe2\x9e\x96"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji2796\x22></span></span>",
			"\xe2\x9e\x97"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji2797\x22></span></span>",
			"\xe2\x9e\xa1"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji27a1\x22></span></span>",
			"\xe2\x9e\xb0"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji27b0\x22></span></span>",
			"\xe2\x9e\xbf"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji27bf\x22></span></span>",
			"\xe2\xa4\xb4"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji2934\x22></span></span>",
			"\xe2\xa4\xb5"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji2935\x22></span></span>",
			"\xe2\xac\x85"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji2b05\x22></span></span>",
			"\xe2\xac\x86"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji2b06\x22></span></span>",
			"\xe2\xac\x87"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji2b07\x22></span></span>",
			"\xe2\xac\x9b"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji2b1b\x22></span></span>",
			"\xe2\xac\x9c"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji2b1c\x22></span></span>",
			"\xe2\xad\x90"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji2b50\x22></span></span>",
			"\xe2\xad\x95"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji2b55\x22></span></span>",
			"\xe3\x80\xb0"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji3030\x22></span></span>",
			"\xe3\x80\xbd"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji303d\x22></span></span>",
			"\xe3\x8a\x97"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji3297\x22></span></span>",
			"\xe3\x8a\x99"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji3299\x22></span></span>",
			"\xf0\x9f\x80\x84"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f004\x22></span></span>",
			"\xf0\x9f\x83\x8f"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f0cf\x22></span></span>",
			"\xf0\x9f\x85\xb0"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f170\x22></span></span>",
			"\xf0\x9f\x85\xb1"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f171\x22></span></span>",
			"\xf0\x9f\x85\xbe"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f17e\x22></span></span>",
			"\xf0\x9f\x85\xbf"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f17f\x22></span></span>",
			"\xf0\x9f\x86\x8e"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f18e\x22></span></span>",
			"\xf0\x9f\x86\x91"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f191\x22></span></span>",
			"\xf0\x9f\x86\x92"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f192\x22></span></span>",
			"\xf0\x9f\x86\x93"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f193\x22></span></span>",
			"\xf0\x9f\x86\x94"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f194\x22></span></span>",
			"\xf0\x9f\x86\x95"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f195\x22></span></span>",
			"\xf0\x9f\x86\x96"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f196\x22></span></span>",
			"\xf0\x9f\x86\x97"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f197\x22></span></span>",
			"\xf0\x9f\x86\x98"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f198\x22></span></span>",
			"\xf0\x9f\x86\x99"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f199\x22></span></span>",
			"\xf0\x9f\x86\x9a"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f19a\x22></span></span>",
			"\xf0\x9f\x88\x81"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f201\x22></span></span>",
			"\xf0\x9f\x88\x82"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f202\x22></span></span>",
			"\xf0\x9f\x88\x9a"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f21a\x22></span></span>",
			"\xf0\x9f\x88\xaf"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f22f\x22></span></span>",
			"\xf0\x9f\x88\xb2"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f232\x22></span></span>",
			"\xf0\x9f\x88\xb3"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f233\x22></span></span>",
			"\xf0\x9f\x88\xb4"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f234\x22></span></span>",
			"\xf0\x9f\x88\xb5"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f235\x22></span></span>",
			"\xf0\x9f\x88\xb6"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f236\x22></span></span>",
			"\xf0\x9f\x88\xb7"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f237\x22></span></span>",
			"\xf0\x9f\x88\xb8"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f238\x22></span></span>",
			"\xf0\x9f\x88\xb9"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f239\x22></span></span>",
			"\xf0\x9f\x88\xba"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f23a\x22></span></span>",
			"\xf0\x9f\x89\x90"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f250\x22></span></span>",
			"\xf0\x9f\x89\x91"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f251\x22></span></span>",
			"\xf0\x9f\x8c\x80"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f300\x22></span></span>",
			"\xf0\x9f\x8c\x81"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f301\x22></span></span>",
			"\xf0\x9f\x8c\x82"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f302\x22></span></span>",
			"\xf0\x9f\x8c\x83"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f303\x22></span></span>",
			"\xf0\x9f\x8c\x84"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f304\x22></span></span>",
			"\xf0\x9f\x8c\x85"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f305\x22></span></span>",
			"\xf0\x9f\x8c\x86"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f306\x22></span></span>",
			"\xf0\x9f\x8c\x87"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f307\x22></span></span>",
			"\xf0\x9f\x8c\x88"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f308\x22></span></span>",
			"\xf0\x9f\x8c\x89"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f309\x22></span></span>",
			"\xf0\x9f\x8c\x8a"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f30a\x22></span></span>",
			"\xf0\x9f\x8c\x8b"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f30b\x22></span></span>",
			"\xf0\x9f\x8c\x8c"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f30c\x22></span></span>",
			"\xf0\x9f\x8c\x8d"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f30d\x22></span></span>",
			"\xf0\x9f\x8c\x8e"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f30e\x22></span></span>",
			"\xf0\x9f\x8c\x8f"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f30f\x22></span></span>",
			"\xf0\x9f\x8c\x90"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f310\x22></span></span>",
			"\xf0\x9f\x8c\x91"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f311\x22></span></span>",
			"\xf0\x9f\x8c\x92"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f312\x22></span></span>",
			"\xf0\x9f\x8c\x93"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f313\x22></span></span>",
			"\xf0\x9f\x8c\x94"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f314\x22></span></span>",
			"\xf0\x9f\x8c\x95"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f315\x22></span></span>",
			"\xf0\x9f\x8c\x96"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f316\x22></span></span>",
			"\xf0\x9f\x8c\x97"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f317\x22></span></span>",
			"\xf0\x9f\x8c\x98"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f318\x22></span></span>",
			"\xf0\x9f\x8c\x99"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f319\x22></span></span>",
			"\xf0\x9f\x8c\x9a"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f31a\x22></span></span>",
			"\xf0\x9f\x8c\x9b"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f31b\x22></span></span>",
			"\xf0\x9f\x8c\x9c"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f31c\x22></span></span>",
			"\xf0\x9f\x8c\x9d"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f31d\x22></span></span>",
			"\xf0\x9f\x8c\x9e"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f31e\x22></span></span>",
			"\xf0\x9f\x8c\x9f"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f31f\x22></span></span>",
			"\xf0\x9f\x8c\xa0"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f320\x22></span></span>",
			"\xf0\x9f\x8c\xa1"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f321\x22></span></span>",
			"\xf0\x9f\x8c\xa4"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f324\x22></span></span>",
			"\xf0\x9f\x8c\xa5"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f325\x22></span></span>",
			"\xf0\x9f\x8c\xa6"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f326\x22></span></span>",
			"\xf0\x9f\x8c\xa7"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f327\x22></span></span>",
			"\xf0\x9f\x8c\xa8"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f328\x22></span></span>",
			"\xf0\x9f\x8c\xa9"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f329\x22></span></span>",
			"\xf0\x9f\x8c\xaa"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f32a\x22></span></span>",
			"\xf0\x9f\x8c\xab"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f32b\x22></span></span>",
			"\xf0\x9f\x8c\xac"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f32c\x22></span></span>",
			"\xf0\x9f\x8c\xad"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f32d\x22></span></span>",
			"\xf0\x9f\x8c\xae"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f32e\x22></span></span>",
			"\xf0\x9f\x8c\xaf"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f32f\x22></span></span>",
			"\xf0\x9f\x8c\xb0"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f330\x22></span></span>",
			"\xf0\x9f\x8c\xb1"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f331\x22></span></span>",
			"\xf0\x9f\x8c\xb2"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f332\x22></span></span>",
			"\xf0\x9f\x8c\xb3"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f333\x22></span></span>",
			"\xf0\x9f\x8c\xb4"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f334\x22></span></span>",
			"\xf0\x9f\x8c\xb5"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f335\x22></span></span>",
			"\xf0\x9f\x8c\xb6"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f336\x22></span></span>",
			"\xf0\x9f\x8c\xb7"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f337\x22></span></span>",
			"\xf0\x9f\x8c\xb8"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f338\x22></span></span>",
			"\xf0\x9f\x8c\xb9"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f339\x22></span></span>",
			"\xf0\x9f\x8c\xba"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f33a\x22></span></span>",
			"\xf0\x9f\x8c\xbb"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f33b\x22></span></span>",
			"\xf0\x9f\x8c\xbc"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f33c\x22></span></span>",
			"\xf0\x9f\x8c\xbd"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f33d\x22></span></span>",
			"\xf0\x9f\x8c\xbe"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f33e\x22></span></span>",
			"\xf0\x9f\x8c\xbf"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f33f\x22></span></span>",
			"\xf0\x9f\x8d\x80"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f340\x22></span></span>",
			"\xf0\x9f\x8d\x81"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f341\x22></span></span>",
			"\xf0\x9f\x8d\x82"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f342\x22></span></span>",
			"\xf0\x9f\x8d\x83"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f343\x22></span></span>",
			"\xf0\x9f\x8d\x84"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f344\x22></span></span>",
			"\xf0\x9f\x8d\x85"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f345\x22></span></span>",
			"\xf0\x9f\x8d\x86"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f346\x22></span></span>",
			"\xf0\x9f\x8d\x87"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f347\x22></span></span>",
			"\xf0\x9f\x8d\x88"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f348\x22></span></span>",
			"\xf0\x9f\x8d\x89"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f349\x22></span></span>",
			"\xf0\x9f\x8d\x8a"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f34a\x22></span></span>",
			"\xf0\x9f\x8d\x8b"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f34b\x22></span></span>",
			"\xf0\x9f\x8d\x8c"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f34c\x22></span></span>",
			"\xf0\x9f\x8d\x8d"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f34d\x22></span></span>",
			"\xf0\x9f\x8d\x8e"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f34e\x22></span></span>",
			"\xf0\x9f\x8d\x8f"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f34f\x22></span></span>",
			"\xf0\x9f\x8d\x90"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f350\x22></span></span>",
			"\xf0\x9f\x8d\x91"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f351\x22></span></span>",
			"\xf0\x9f\x8d\x92"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f352\x22></span></span>",
			"\xf0\x9f\x8d\x93"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f353\x22></span></span>",
			"\xf0\x9f\x8d\x94"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f354\x22></span></span>",
			"\xf0\x9f\x8d\x95"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f355\x22></span></span>",
			"\xf0\x9f\x8d\x96"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f356\x22></span></span>",
			"\xf0\x9f\x8d\x97"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f357\x22></span></span>",
			"\xf0\x9f\x8d\x98"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f358\x22></span></span>",
			"\xf0\x9f\x8d\x99"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f359\x22></span></span>",
			"\xf0\x9f\x8d\x9a"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f35a\x22></span></span>",
			"\xf0\x9f\x8d\x9b"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f35b\x22></span></span>",
			"\xf0\x9f\x8d\x9c"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f35c\x22></span></span>",
			"\xf0\x9f\x8d\x9d"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f35d\x22></span></span>",
			"\xf0\x9f\x8d\x9e"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f35e\x22></span></span>",
			"\xf0\x9f\x8d\x9f"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f35f\x22></span></span>",
			"\xf0\x9f\x8d\xa0"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f360\x22></span></span>",
			"\xf0\x9f\x8d\xa1"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f361\x22></span></span>",
			"\xf0\x9f\x8d\xa2"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f362\x22></span></span>",
			"\xf0\x9f\x8d\xa3"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f363\x22></span></span>",
			"\xf0\x9f\x8d\xa4"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f364\x22></span></span>",
			"\xf0\x9f\x8d\xa5"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f365\x22></span></span>",
			"\xf0\x9f\x8d\xa6"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f366\x22></span></span>",
			"\xf0\x9f\x8d\xa7"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f367\x22></span></span>",
			"\xf0\x9f\x8d\xa8"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f368\x22></span></span>",
			"\xf0\x9f\x8d\xa9"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f369\x22></span></span>",
			"\xf0\x9f\x8d\xaa"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f36a\x22></span></span>",
			"\xf0\x9f\x8d\xab"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f36b\x22></span></span>",
			"\xf0\x9f\x8d\xac"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f36c\x22></span></span>",
			"\xf0\x9f\x8d\xad"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f36d\x22></span></span>",
			"\xf0\x9f\x8d\xae"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f36e\x22></span></span>",
			"\xf0\x9f\x8d\xaf"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f36f\x22></span></span>",
			"\xf0\x9f\x8d\xb0"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f370\x22></span></span>",
			"\xf0\x9f\x8d\xb1"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f371\x22></span></span>",
			"\xf0\x9f\x8d\xb2"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f372\x22></span></span>",
			"\xf0\x9f\x8d\xb3"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f373\x22></span></span>",
			"\xf0\x9f\x8d\xb4"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f374\x22></span></span>",
			"\xf0\x9f\x8d\xb5"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f375\x22></span></span>",
			"\xf0\x9f\x8d\xb6"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f376\x22></span></span>",
			"\xf0\x9f\x8d\xb7"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f377\x22></span></span>",
			"\xf0\x9f\x8d\xb8"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f378\x22></span></span>",
			"\xf0\x9f\x8d\xb9"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f379\x22></span></span>",
			"\xf0\x9f\x8d\xba"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f37a\x22></span></span>",
			"\xf0\x9f\x8d\xbb"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f37b\x22></span></span>",
			"\xf0\x9f\x8d\xbc"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f37c\x22></span></span>",
			"\xf0\x9f\x8d\xbd"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f37d\x22></span></span>",
			"\xf0\x9f\x8d\xbe"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f37e\x22></span></span>",
			"\xf0\x9f\x8d\xbf"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f37f\x22></span></span>",
			"\xf0\x9f\x8e\x80"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f380\x22></span></span>",
			"\xf0\x9f\x8e\x81"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f381\x22></span></span>",
			"\xf0\x9f\x8e\x82"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f382\x22></span></span>",
			"\xf0\x9f\x8e\x83"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f383\x22></span></span>",
			"\xf0\x9f\x8e\x84"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f384\x22></span></span>",
			"\xf0\x9f\x8e\x85"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f385\x22></span></span>",
			"\xf0\x9f\x8e\x86"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f386\x22></span></span>",
			"\xf0\x9f\x8e\x87"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f387\x22></span></span>",
			"\xf0\x9f\x8e\x88"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f388\x22></span></span>",
			"\xf0\x9f\x8e\x89"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f389\x22></span></span>",
			"\xf0\x9f\x8e\x8a"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f38a\x22></span></span>",
			"\xf0\x9f\x8e\x8b"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f38b\x22></span></span>",
			"\xf0\x9f\x8e\x8c"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f38c\x22></span></span>",
			"\xf0\x9f\x8e\x8d"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f38d\x22></span></span>",
			"\xf0\x9f\x8e\x8e"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f38e\x22></span></span>",
			"\xf0\x9f\x8e\x8f"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f38f\x22></span></span>",
			"\xf0\x9f\x8e\x90"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f390\x22></span></span>",
			"\xf0\x9f\x8e\x91"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f391\x22></span></span>",
			"\xf0\x9f\x8e\x92"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f392\x22></span></span>",
			"\xf0\x9f\x8e\x93"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f393\x22></span></span>",
			"\xf0\x9f\x8e\x96"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f396\x22></span></span>",
			"\xf0\x9f\x8e\x97"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f397\x22></span></span>",
			"\xf0\x9f\x8e\x99"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f399\x22></span></span>",
			"\xf0\x9f\x8e\x9a"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f39a\x22></span></span>",
			"\xf0\x9f\x8e\x9b"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f39b\x22></span></span>",
			"\xf0\x9f\x8e\x9e"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f39e\x22></span></span>",
			"\xf0\x9f\x8e\x9f"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f39f\x22></span></span>",
			"\xf0\x9f\x8e\xa0"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f3a0\x22></span></span>",
			"\xf0\x9f\x8e\xa1"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f3a1\x22></span></span>",
			"\xf0\x9f\x8e\xa2"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f3a2\x22></span></span>",
			"\xf0\x9f\x8e\xa3"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f3a3\x22></span></span>",
			"\xf0\x9f\x8e\xa4"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f3a4\x22></span></span>",
			"\xf0\x9f\x8e\xa5"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f3a5\x22></span></span>",
			"\xf0\x9f\x8e\xa6"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f3a6\x22></span></span>",
			"\xf0\x9f\x8e\xa7"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f3a7\x22></span></span>",
			"\xf0\x9f\x8e\xa8"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f3a8\x22></span></span>",
			"\xf0\x9f\x8e\xa9"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f3a9\x22></span></span>",
			"\xf0\x9f\x8e\xaa"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f3aa\x22></span></span>",
			"\xf0\x9f\x8e\xab"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f3ab\x22></span></span>",
			"\xf0\x9f\x8e\xac"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f3ac\x22></span></span>",
			"\xf0\x9f\x8e\xad"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f3ad\x22></span></span>",
			"\xf0\x9f\x8e\xae"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f3ae\x22></span></span>",
			"\xf0\x9f\x8e\xaf"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f3af\x22></span></span>",
			"\xf0\x9f\x8e\xb0"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f3b0\x22></span></span>",
			"\xf0\x9f\x8e\xb1"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f3b1\x22></span></span>",
			"\xf0\x9f\x8e\xb2"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f3b2\x22></span></span>",
			"\xf0\x9f\x8e\xb3"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f3b3\x22></span></span>",
			"\xf0\x9f\x8e\xb4"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f3b4\x22></span></span>",
			"\xf0\x9f\x8e\xb5"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f3b5\x22></span></span>",
			"\xf0\x9f\x8e\xb6"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f3b6\x22></span></span>",
			"\xf0\x9f\x8e\xb7"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f3b7\x22></span></span>",
			"\xf0\x9f\x8e\xb8"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f3b8\x22></span></span>",
			"\xf0\x9f\x8e\xb9"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f3b9\x22></span></span>",
			"\xf0\x9f\x8e\xba"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f3ba\x22></span></span>",
			"\xf0\x9f\x8e\xbb"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f3bb\x22></span></span>",
			"\xf0\x9f\x8e\xbc"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f3bc\x22></span></span>",
			"\xf0\x9f\x8e\xbd"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f3bd\x22></span></span>",
			"\xf0\x9f\x8e\xbe"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f3be\x22></span></span>",
			"\xf0\x9f\x8e\xbf"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f3bf\x22></span></span>",
			"\xf0\x9f\x8f\x80"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f3c0\x22></span></span>",
			"\xf0\x9f\x8f\x81"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f3c1\x22></span></span>",
			"\xf0\x9f\x8f\x82"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f3c2\x22></span></span>",
			"\xf0\x9f\x8f\x83"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f3c3\x22></span></span>",
			"\xf0\x9f\x8f\x84"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f3c4\x22></span></span>",
			"\xf0\x9f\x8f\x85"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f3c5\x22></span></span>",
			"\xf0\x9f\x8f\x86"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f3c6\x22></span></span>",
			"\xf0\x9f\x8f\x87"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f3c7\x22></span></span>",
			"\xf0\x9f\x8f\x88"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f3c8\x22></span></span>",
			"\xf0\x9f\x8f\x89"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f3c9\x22></span></span>",
			"\xf0\x9f\x8f\x8a"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f3ca\x22></span></span>",
			"\xf0\x9f\x8f\x8b"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f3cb\x22></span></span>",
			"\xf0\x9f\x8f\x8c"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f3cc\x22></span></span>",
			"\xf0\x9f\x8f\x8d"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f3cd\x22></span></span>",
			"\xf0\x9f\x8f\x8e"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f3ce\x22></span></span>",
			"\xf0\x9f\x8f\x8f"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f3cf\x22></span></span>",
			"\xf0\x9f\x8f\x90"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f3d0\x22></span></span>",
			"\xf0\x9f\x8f\x91"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f3d1\x22></span></span>",
			"\xf0\x9f\x8f\x92"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f3d2\x22></span></span>",
			"\xf0\x9f\x8f\x93"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f3d3\x22></span></span>",
			"\xf0\x9f\x8f\x94"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f3d4\x22></span></span>",
			"\xf0\x9f\x8f\x95"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f3d5\x22></span></span>",
			"\xf0\x9f\x8f\x96"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f3d6\x22></span></span>",
			"\xf0\x9f\x8f\x97"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f3d7\x22></span></span>",
			"\xf0\x9f\x8f\x98"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f3d8\x22></span></span>",
			"\xf0\x9f\x8f\x99"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f3d9\x22></span></span>",
			"\xf0\x9f\x8f\x9a"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f3da\x22></span></span>",
			"\xf0\x9f\x8f\x9b"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f3db\x22></span></span>",
			"\xf0\x9f\x8f\x9c"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f3dc\x22></span></span>",
			"\xf0\x9f\x8f\x9d"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f3dd\x22></span></span>",
			"\xf0\x9f\x8f\x9e"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f3de\x22></span></span>",
			"\xf0\x9f\x8f\x9f"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f3df\x22></span></span>",
			"\xf0\x9f\x8f\xa0"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f3e0\x22></span></span>",
			"\xf0\x9f\x8f\xa1"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f3e1\x22></span></span>",
			"\xf0\x9f\x8f\xa2"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f3e2\x22></span></span>",
			"\xf0\x9f\x8f\xa3"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f3e3\x22></span></span>",
			"\xf0\x9f\x8f\xa4"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f3e4\x22></span></span>",
			"\xf0\x9f\x8f\xa5"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f3e5\x22></span></span>",
			"\xf0\x9f\x8f\xa6"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f3e6\x22></span></span>",
			"\xf0\x9f\x8f\xa7"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f3e7\x22></span></span>",
			"\xf0\x9f\x8f\xa8"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f3e8\x22></span></span>",
			"\xf0\x9f\x8f\xa9"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f3e9\x22></span></span>",
			"\xf0\x9f\x8f\xaa"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f3ea\x22></span></span>",
			"\xf0\x9f\x8f\xab"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f3eb\x22></span></span>",
			"\xf0\x9f\x8f\xac"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f3ec\x22></span></span>",
			"\xf0\x9f\x8f\xad"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f3ed\x22></span></span>",
			"\xf0\x9f\x8f\xae"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f3ee\x22></span></span>",
			"\xf0\x9f\x8f\xaf"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f3ef\x22></span></span>",
			"\xf0\x9f\x8f\xb0"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f3f0\x22></span></span>",
			"\xf0\x9f\x8f\xb3"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f3f3\x22></span></span>",
			"\xf0\x9f\x8f\xb4"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f3f4\x22></span></span>",
			"\xf0\x9f\x8f\xb5"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f3f5\x22></span></span>",
			"\xf0\x9f\x8f\xb7"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f3f7\x22></span></span>",
			"\xf0\x9f\x8f\xb8"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f3f8\x22></span></span>",
			"\xf0\x9f\x8f\xb9"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f3f9\x22></span></span>",
			"\xf0\x9f\x8f\xba"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f3fa\x22></span></span>",
			"\xf0\x9f\x8f\xbb"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f3fb\x22></span></span>",
			"\xf0\x9f\x8f\xbc"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f3fc\x22></span></span>",
			"\xf0\x9f\x8f\xbd"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f3fd\x22></span></span>",
			"\xf0\x9f\x8f\xbe"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f3fe\x22></span></span>",
			"\xf0\x9f\x8f\xbf"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f3ff\x22></span></span>",
			"\xf0\x9f\x90\x80"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f400\x22></span></span>",
			"\xf0\x9f\x90\x81"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f401\x22></span></span>",
			"\xf0\x9f\x90\x82"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f402\x22></span></span>",
			"\xf0\x9f\x90\x83"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f403\x22></span></span>",
			"\xf0\x9f\x90\x84"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f404\x22></span></span>",
			"\xf0\x9f\x90\x85"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f405\x22></span></span>",
			"\xf0\x9f\x90\x86"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f406\x22></span></span>",
			"\xf0\x9f\x90\x87"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f407\x22></span></span>",
			"\xf0\x9f\x90\x88"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f408\x22></span></span>",
			"\xf0\x9f\x90\x89"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f409\x22></span></span>",
			"\xf0\x9f\x90\x8a"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f40a\x22></span></span>",
			"\xf0\x9f\x90\x8b"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f40b\x22></span></span>",
			"\xf0\x9f\x90\x8c"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f40c\x22></span></span>",
			"\xf0\x9f\x90\x8d"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f40d\x22></span></span>",
			"\xf0\x9f\x90\x8e"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f40e\x22></span></span>",
			"\xf0\x9f\x90\x8f"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f40f\x22></span></span>",
			"\xf0\x9f\x90\x90"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f410\x22></span></span>",
			"\xf0\x9f\x90\x91"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f411\x22></span></span>",
			"\xf0\x9f\x90\x92"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f412\x22></span></span>",
			"\xf0\x9f\x90\x93"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f413\x22></span></span>",
			"\xf0\x9f\x90\x94"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f414\x22></span></span>",
			"\xf0\x9f\x90\x95"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f415\x22></span></span>",
			"\xf0\x9f\x90\x96"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f416\x22></span></span>",
			"\xf0\x9f\x90\x97"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f417\x22></span></span>",
			"\xf0\x9f\x90\x98"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f418\x22></span></span>",
			"\xf0\x9f\x90\x99"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f419\x22></span></span>",
			"\xf0\x9f\x90\x9a"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f41a\x22></span></span>",
			"\xf0\x9f\x90\x9b"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f41b\x22></span></span>",
			"\xf0\x9f\x90\x9c"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f41c\x22></span></span>",
			"\xf0\x9f\x90\x9d"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f41d\x22></span></span>",
			"\xf0\x9f\x90\x9e"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f41e\x22></span></span>",
			"\xf0\x9f\x90\x9f"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f41f\x22></span></span>",
			"\xf0\x9f\x90\xa0"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f420\x22></span></span>",
			"\xf0\x9f\x90\xa1"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f421\x22></span></span>",
			"\xf0\x9f\x90\xa2"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f422\x22></span></span>",
			"\xf0\x9f\x90\xa3"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f423\x22></span></span>",
			"\xf0\x9f\x90\xa4"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f424\x22></span></span>",
			"\xf0\x9f\x90\xa5"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f425\x22></span></span>",
			"\xf0\x9f\x90\xa6"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f426\x22></span></span>",
			"\xf0\x9f\x90\xa7"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f427\x22></span></span>",
			"\xf0\x9f\x90\xa8"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f428\x22></span></span>",
			"\xf0\x9f\x90\xa9"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f429\x22></span></span>",
			"\xf0\x9f\x90\xaa"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f42a\x22></span></span>",
			"\xf0\x9f\x90\xab"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f42b\x22></span></span>",
			"\xf0\x9f\x90\xac"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f42c\x22></span></span>",
			"\xf0\x9f\x90\xad"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f42d\x22></span></span>",
			"\xf0\x9f\x90\xae"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f42e\x22></span></span>",
			"\xf0\x9f\x90\xaf"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f42f\x22></span></span>",
			"\xf0\x9f\x90\xb0"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f430\x22></span></span>",
			"\xf0\x9f\x90\xb1"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f431\x22></span></span>",
			"\xf0\x9f\x90\xb2"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f432\x22></span></span>",
			"\xf0\x9f\x90\xb3"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f433\x22></span></span>",
			"\xf0\x9f\x90\xb4"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f434\x22></span></span>",
			"\xf0\x9f\x90\xb5"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f435\x22></span></span>",
			"\xf0\x9f\x90\xb6"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f436\x22></span></span>",
			"\xf0\x9f\x90\xb7"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f437\x22></span></span>",
			"\xf0\x9f\x90\xb8"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f438\x22></span></span>",
			"\xf0\x9f\x90\xb9"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f439\x22></span></span>",
			"\xf0\x9f\x90\xba"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f43a\x22></span></span>",
			"\xf0\x9f\x90\xbb"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f43b\x22></span></span>",
			"\xf0\x9f\x90\xbc"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f43c\x22></span></span>",
			"\xf0\x9f\x90\xbd"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f43d\x22></span></span>",
			"\xf0\x9f\x90\xbe"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f43e\x22></span></span>",
			"\xf0\x9f\x90\xbf"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f43f\x22></span></span>",
			"\xf0\x9f\x91\x80"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f440\x22></span></span>",
			"\xf0\x9f\x91\x81"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f441\x22></span></span>",
			"\xf0\x9f\x91\x82"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f442\x22></span></span>",
			"\xf0\x9f\x91\x83"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f443\x22></span></span>",
			"\xf0\x9f\x91\x84"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f444\x22></span></span>",
			"\xf0\x9f\x91\x85"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f445\x22></span></span>",
			"\xf0\x9f\x91\x86"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f446\x22></span></span>",
			"\xf0\x9f\x91\x87"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f447\x22></span></span>",
			"\xf0\x9f\x91\x88"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f448\x22></span></span>",
			"\xf0\x9f\x91\x89"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f449\x22></span></span>",
			"\xf0\x9f\x91\x8a"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f44a\x22></span></span>",
			"\xf0\x9f\x91\x8b"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f44b\x22></span></span>",
			"\xf0\x9f\x91\x8c"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f44c\x22></span></span>",
			"\xf0\x9f\x91\x8d"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f44d\x22></span></span>",
			"\xf0\x9f\x91\x8e"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f44e\x22></span></span>",
			"\xf0\x9f\x91\x8f"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f44f\x22></span></span>",
			"\xf0\x9f\x91\x90"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f450\x22></span></span>",
			"\xf0\x9f\x91\x91"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f451\x22></span></span>",
			"\xf0\x9f\x91\x92"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f452\x22></span></span>",
			"\xf0\x9f\x91\x93"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f453\x22></span></span>",
			"\xf0\x9f\x91\x94"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f454\x22></span></span>",
			"\xf0\x9f\x91\x95"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f455\x22></span></span>",
			"\xf0\x9f\x91\x96"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f456\x22></span></span>",
			"\xf0\x9f\x91\x97"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f457\x22></span></span>",
			"\xf0\x9f\x91\x98"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f458\x22></span></span>",
			"\xf0\x9f\x91\x99"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f459\x22></span></span>",
			"\xf0\x9f\x91\x9a"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f45a\x22></span></span>",
			"\xf0\x9f\x91\x9b"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f45b\x22></span></span>",
			"\xf0\x9f\x91\x9c"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f45c\x22></span></span>",
			"\xf0\x9f\x91\x9d"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f45d\x22></span></span>",
			"\xf0\x9f\x91\x9e"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f45e\x22></span></span>",
			"\xf0\x9f\x91\x9f"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f45f\x22></span></span>",
			"\xf0\x9f\x91\xa0"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f460\x22></span></span>",
			"\xf0\x9f\x91\xa1"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f461\x22></span></span>",
			"\xf0\x9f\x91\xa2"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f462\x22></span></span>",
			"\xf0\x9f\x91\xa3"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f463\x22></span></span>",
			"\xf0\x9f\x91\xa4"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f464\x22></span></span>",
			"\xf0\x9f\x91\xa5"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f465\x22></span></span>",
			"\xf0\x9f\x91\xa6"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f466\x22></span></span>",
			"\xf0\x9f\x91\xa7"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f467\x22></span></span>",
			"\xf0\x9f\x91\xa8"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f468\x22></span></span>",
			"\xf0\x9f\x91\xa9"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f469\x22></span></span>",
			"\xf0\x9f\x91\xaa"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f46a\x22></span></span>",
			"\xf0\x9f\x91\xab"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f46b\x22></span></span>",
			"\xf0\x9f\x91\xac"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f46c\x22></span></span>",
			"\xf0\x9f\x91\xad"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f46d\x22></span></span>",
			"\xf0\x9f\x91\xae"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f46e\x22></span></span>",
			"\xf0\x9f\x91\xaf"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f46f\x22></span></span>",
			"\xf0\x9f\x91\xb0"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f470\x22></span></span>",
			"\xf0\x9f\x91\xb1"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f471\x22></span></span>",
			"\xf0\x9f\x91\xb2"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f472\x22></span></span>",
			"\xf0\x9f\x91\xb3"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f473\x22></span></span>",
			"\xf0\x9f\x91\xb4"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f474\x22></span></span>",
			"\xf0\x9f\x91\xb5"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f475\x22></span></span>",
			"\xf0\x9f\x91\xb6"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f476\x22></span></span>",
			"\xf0\x9f\x91\xb7"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f477\x22></span></span>",
			"\xf0\x9f\x91\xb8"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f478\x22></span></span>",
			"\xf0\x9f\x91\xb9"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f479\x22></span></span>",
			"\xf0\x9f\x91\xba"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f47a\x22></span></span>",
			"\xf0\x9f\x91\xbb"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f47b\x22></span></span>",
			"\xf0\x9f\x91\xbc"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f47c\x22></span></span>",
			"\xf0\x9f\x91\xbd"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f47d\x22></span></span>",
			"\xf0\x9f\x91\xbe"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f47e\x22></span></span>",
			"\xf0\x9f\x91\xbf"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f47f\x22></span></span>",
			"\xf0\x9f\x92\x80"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f480\x22></span></span>",
			"\xf0\x9f\x92\x81"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f481\x22></span></span>",
			"\xf0\x9f\x92\x82"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f482\x22></span></span>",
			"\xf0\x9f\x92\x83"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f483\x22></span></span>",
			"\xf0\x9f\x92\x84"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f484\x22></span></span>",
			"\xf0\x9f\x92\x85"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f485\x22></span></span>",
			"\xf0\x9f\x92\x86"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f486\x22></span></span>",
			"\xf0\x9f\x92\x87"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f487\x22></span></span>",
			"\xf0\x9f\x92\x88"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f488\x22></span></span>",
			"\xf0\x9f\x92\x89"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f489\x22></span></span>",
			"\xf0\x9f\x92\x8a"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f48a\x22></span></span>",
			"\xf0\x9f\x92\x8b"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f48b\x22></span></span>",
			"\xf0\x9f\x92\x8c"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f48c\x22></span></span>",
			"\xf0\x9f\x92\x8d"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f48d\x22></span></span>",
			"\xf0\x9f\x92\x8e"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f48e\x22></span></span>",
			"\xf0\x9f\x92\x8f"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f48f\x22></span></span>",
			"\xf0\x9f\x92\x90"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f490\x22></span></span>",
			"\xf0\x9f\x92\x91"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f491\x22></span></span>",
			"\xf0\x9f\x92\x92"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f492\x22></span></span>",
			"\xf0\x9f\x92\x93"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f493\x22></span></span>",
			"\xf0\x9f\x92\x94"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f494\x22></span></span>",
			"\xf0\x9f\x92\x95"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f495\x22></span></span>",
			"\xf0\x9f\x92\x96"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f496\x22></span></span>",
			"\xf0\x9f\x92\x97"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f497\x22></span></span>",
			"\xf0\x9f\x92\x98"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f498\x22></span></span>",
			"\xf0\x9f\x92\x99"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f499\x22></span></span>",
			"\xf0\x9f\x92\x9a"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f49a\x22></span></span>",
			"\xf0\x9f\x92\x9b"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f49b\x22></span></span>",
			"\xf0\x9f\x92\x9c"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f49c\x22></span></span>",
			"\xf0\x9f\x92\x9d"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f49d\x22></span></span>",
			"\xf0\x9f\x92\x9e"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f49e\x22></span></span>",
			"\xf0\x9f\x92\x9f"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f49f\x22></span></span>",
			"\xf0\x9f\x92\xa0"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f4a0\x22></span></span>",
			"\xf0\x9f\x92\xa1"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f4a1\x22></span></span>",
			"\xf0\x9f\x92\xa2"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f4a2\x22></span></span>",
			"\xf0\x9f\x92\xa3"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f4a3\x22></span></span>",
			"\xf0\x9f\x92\xa4"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f4a4\x22></span></span>",
			"\xf0\x9f\x92\xa5"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f4a5\x22></span></span>",
			"\xf0\x9f\x92\xa6"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f4a6\x22></span></span>",
			"\xf0\x9f\x92\xa7"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f4a7\x22></span></span>",
			"\xf0\x9f\x92\xa8"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f4a8\x22></span></span>",
			"\xf0\x9f\x92\xa9"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f4a9\x22></span></span>",
			"\xf0\x9f\x92\xaa"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f4aa\x22></span></span>",
			"\xf0\x9f\x92\xab"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f4ab\x22></span></span>",
			"\xf0\x9f\x92\xac"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f4ac\x22></span></span>",
			"\xf0\x9f\x92\xad"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f4ad\x22></span></span>",
			"\xf0\x9f\x92\xae"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f4ae\x22></span></span>",
			"\xf0\x9f\x92\xaf"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f4af\x22></span></span>",
			"\xf0\x9f\x92\xb0"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f4b0\x22></span></span>",
			"\xf0\x9f\x92\xb1"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f4b1\x22></span></span>",
			"\xf0\x9f\x92\xb2"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f4b2\x22></span></span>",
			"\xf0\x9f\x92\xb3"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f4b3\x22></span></span>",
			"\xf0\x9f\x92\xb4"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f4b4\x22></span></span>",
			"\xf0\x9f\x92\xb5"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f4b5\x22></span></span>",
			"\xf0\x9f\x92\xb6"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f4b6\x22></span></span>",
			"\xf0\x9f\x92\xb7"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f4b7\x22></span></span>",
			"\xf0\x9f\x92\xb8"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f4b8\x22></span></span>",
			"\xf0\x9f\x92\xb9"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f4b9\x22></span></span>",
			"\xf0\x9f\x92\xba"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f4ba\x22></span></span>",
			"\xf0\x9f\x92\xbb"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f4bb\x22></span></span>",
			"\xf0\x9f\x92\xbc"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f4bc\x22></span></span>",
			"\xf0\x9f\x92\xbd"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f4bd\x22></span></span>",
			"\xf0\x9f\x92\xbe"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f4be\x22></span></span>",
			"\xf0\x9f\x92\xbf"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f4bf\x22></span></span>",
			"\xf0\x9f\x93\x80"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f4c0\x22></span></span>",
			"\xf0\x9f\x93\x81"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f4c1\x22></span></span>",
			"\xf0\x9f\x93\x82"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f4c2\x22></span></span>",
			"\xf0\x9f\x93\x83"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f4c3\x22></span></span>",
			"\xf0\x9f\x93\x84"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f4c4\x22></span></span>",
			"\xf0\x9f\x93\x85"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f4c5\x22></span></span>",
			"\xf0\x9f\x93\x86"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f4c6\x22></span></span>",
			"\xf0\x9f\x93\x87"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f4c7\x22></span></span>",
			"\xf0\x9f\x93\x88"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f4c8\x22></span></span>",
			"\xf0\x9f\x93\x89"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f4c9\x22></span></span>",
			"\xf0\x9f\x93\x8a"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f4ca\x22></span></span>",
			"\xf0\x9f\x93\x8b"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f4cb\x22></span></span>",
			"\xf0\x9f\x93\x8c"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f4cc\x22></span></span>",
			"\xf0\x9f\x93\x8d"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f4cd\x22></span></span>",
			"\xf0\x9f\x93\x8e"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f4ce\x22></span></span>",
			"\xf0\x9f\x93\x8f"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f4cf\x22></span></span>",
			"\xf0\x9f\x93\x90"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f4d0\x22></span></span>",
			"\xf0\x9f\x93\x91"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f4d1\x22></span></span>",
			"\xf0\x9f\x93\x92"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f4d2\x22></span></span>",
			"\xf0\x9f\x93\x93"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f4d3\x22></span></span>",
			"\xf0\x9f\x93\x94"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f4d4\x22></span></span>",
			"\xf0\x9f\x93\x95"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f4d5\x22></span></span>",
			"\xf0\x9f\x93\x96"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f4d6\x22></span></span>",
			"\xf0\x9f\x93\x97"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f4d7\x22></span></span>",
			"\xf0\x9f\x93\x98"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f4d8\x22></span></span>",
			"\xf0\x9f\x93\x99"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f4d9\x22></span></span>",
			"\xf0\x9f\x93\x9a"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f4da\x22></span></span>",
			"\xf0\x9f\x93\x9b"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f4db\x22></span></span>",
			"\xf0\x9f\x93\x9c"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f4dc\x22></span></span>",
			"\xf0\x9f\x93\x9d"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f4dd\x22></span></span>",
			"\xf0\x9f\x93\x9e"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f4de\x22></span></span>",
			"\xf0\x9f\x93\x9f"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f4df\x22></span></span>",
			"\xf0\x9f\x93\xa0"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f4e0\x22></span></span>",
			"\xf0\x9f\x93\xa1"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f4e1\x22></span></span>",
			"\xf0\x9f\x93\xa2"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f4e2\x22></span></span>",
			"\xf0\x9f\x93\xa3"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f4e3\x22></span></span>",
			"\xf0\x9f\x93\xa4"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f4e4\x22></span></span>",
			"\xf0\x9f\x93\xa5"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f4e5\x22></span></span>",
			"\xf0\x9f\x93\xa6"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f4e6\x22></span></span>",
			"\xf0\x9f\x93\xa7"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f4e7\x22></span></span>",
			"\xf0\x9f\x93\xa8"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f4e8\x22></span></span>",
			"\xf0\x9f\x93\xa9"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f4e9\x22></span></span>",
			"\xf0\x9f\x93\xaa"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f4ea\x22></span></span>",
			"\xf0\x9f\x93\xab"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f4eb\x22></span></span>",
			"\xf0\x9f\x93\xac"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f4ec\x22></span></span>",
			"\xf0\x9f\x93\xad"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f4ed\x22></span></span>",
			"\xf0\x9f\x93\xae"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f4ee\x22></span></span>",
			"\xf0\x9f\x93\xaf"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f4ef\x22></span></span>",
			"\xf0\x9f\x93\xb0"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f4f0\x22></span></span>",
			"\xf0\x9f\x93\xb1"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f4f1\x22></span></span>",
			"\xf0\x9f\x93\xb2"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f4f2\x22></span></span>",
			"\xf0\x9f\x93\xb3"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f4f3\x22></span></span>",
			"\xf0\x9f\x93\xb4"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f4f4\x22></span></span>",
			"\xf0\x9f\x93\xb5"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f4f5\x22></span></span>",
			"\xf0\x9f\x93\xb6"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f4f6\x22></span></span>",
			"\xf0\x9f\x93\xb7"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f4f7\x22></span></span>",
			"\xf0\x9f\x93\xb8"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f4f8\x22></span></span>",
			"\xf0\x9f\x93\xb9"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f4f9\x22></span></span>",
			"\xf0\x9f\x93\xba"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f4fa\x22></span></span>",
			"\xf0\x9f\x93\xbb"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f4fb\x22></span></span>",
			"\xf0\x9f\x93\xbc"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f4fc\x22></span></span>",
			"\xf0\x9f\x93\xbd"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f4fd\x22></span></span>",
			"\xf0\x9f\x93\xbf"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f4ff\x22></span></span>",
			"\xf0\x9f\x94\x80"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f500\x22></span></span>",
			"\xf0\x9f\x94\x81"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f501\x22></span></span>",
			"\xf0\x9f\x94\x82"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f502\x22></span></span>",
			"\xf0\x9f\x94\x83"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f503\x22></span></span>",
			"\xf0\x9f\x94\x84"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f504\x22></span></span>",
			"\xf0\x9f\x94\x85"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f505\x22></span></span>",
			"\xf0\x9f\x94\x86"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f506\x22></span></span>",
			"\xf0\x9f\x94\x87"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f507\x22></span></span>",
			"\xf0\x9f\x94\x88"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f508\x22></span></span>",
			"\xf0\x9f\x94\x89"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f509\x22></span></span>",
			"\xf0\x9f\x94\x8a"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f50a\x22></span></span>",
			"\xf0\x9f\x94\x8b"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f50b\x22></span></span>",
			"\xf0\x9f\x94\x8c"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f50c\x22></span></span>",
			"\xf0\x9f\x94\x8d"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f50d\x22></span></span>",
			"\xf0\x9f\x94\x8e"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f50e\x22></span></span>",
			"\xf0\x9f\x94\x8f"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f50f\x22></span></span>",
			"\xf0\x9f\x94\x90"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f510\x22></span></span>",
			"\xf0\x9f\x94\x91"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f511\x22></span></span>",
			"\xf0\x9f\x94\x92"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f512\x22></span></span>",
			"\xf0\x9f\x94\x93"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f513\x22></span></span>",
			"\xf0\x9f\x94\x94"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f514\x22></span></span>",
			"\xf0\x9f\x94\x95"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f515\x22></span></span>",
			"\xf0\x9f\x94\x96"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f516\x22></span></span>",
			"\xf0\x9f\x94\x97"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f517\x22></span></span>",
			"\xf0\x9f\x94\x98"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f518\x22></span></span>",
			"\xf0\x9f\x94\x99"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f519\x22></span></span>",
			"\xf0\x9f\x94\x9a"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f51a\x22></span></span>",
			"\xf0\x9f\x94\x9b"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f51b\x22></span></span>",
			"\xf0\x9f\x94\x9c"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f51c\x22></span></span>",
			"\xf0\x9f\x94\x9d"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f51d\x22></span></span>",
			"\xf0\x9f\x94\x9e"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f51e\x22></span></span>",
			"\xf0\x9f\x94\x9f"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f51f\x22></span></span>",
			"\xf0\x9f\x94\xa0"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f520\x22></span></span>",
			"\xf0\x9f\x94\xa1"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f521\x22></span></span>",
			"\xf0\x9f\x94\xa2"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f522\x22></span></span>",
			"\xf0\x9f\x94\xa3"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f523\x22></span></span>",
			"\xf0\x9f\x94\xa4"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f524\x22></span></span>",
			"\xf0\x9f\x94\xa5"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f525\x22></span></span>",
			"\xf0\x9f\x94\xa6"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f526\x22></span></span>",
			"\xf0\x9f\x94\xa7"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f527\x22></span></span>",
			"\xf0\x9f\x94\xa8"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f528\x22></span></span>",
			"\xf0\x9f\x94\xa9"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f529\x22></span></span>",
			"\xf0\x9f\x94\xaa"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f52a\x22></span></span>",
			"\xf0\x9f\x94\xab"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f52b\x22></span></span>",
			"\xf0\x9f\x94\xac"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f52c\x22></span></span>",
			"\xf0\x9f\x94\xad"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f52d\x22></span></span>",
			"\xf0\x9f\x94\xae"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f52e\x22></span></span>",
			"\xf0\x9f\x94\xaf"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f52f\x22></span></span>",
			"\xf0\x9f\x94\xb0"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f530\x22></span></span>",
			"\xf0\x9f\x94\xb1"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f531\x22></span></span>",
			"\xf0\x9f\x94\xb2"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f532\x22></span></span>",
			"\xf0\x9f\x94\xb3"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f533\x22></span></span>",
			"\xf0\x9f\x94\xb4"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f534\x22></span></span>",
			"\xf0\x9f\x94\xb5"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f535\x22></span></span>",
			"\xf0\x9f\x94\xb6"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f536\x22></span></span>",
			"\xf0\x9f\x94\xb7"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f537\x22></span></span>",
			"\xf0\x9f\x94\xb8"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f538\x22></span></span>",
			"\xf0\x9f\x94\xb9"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f539\x22></span></span>",
			"\xf0\x9f\x94\xba"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f53a\x22></span></span>",
			"\xf0\x9f\x94\xbb"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f53b\x22></span></span>",
			"\xf0\x9f\x94\xbc"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f53c\x22></span></span>",
			"\xf0\x9f\x94\xbd"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f53d\x22></span></span>",
			"\xf0\x9f\x95\x89"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f549\x22></span></span>",
			"\xf0\x9f\x95\x8a"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f54a\x22></span></span>",
			"\xf0\x9f\x95\x8b"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f54b\x22></span></span>",
			"\xf0\x9f\x95\x8c"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f54c\x22></span></span>",
			"\xf0\x9f\x95\x8d"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f54d\x22></span></span>",
			"\xf0\x9f\x95\x8e"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f54e\x22></span></span>",
			"\xf0\x9f\x95\x90"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f550\x22></span></span>",
			"\xf0\x9f\x95\x91"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f551\x22></span></span>",
			"\xf0\x9f\x95\x92"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f552\x22></span></span>",
			"\xf0\x9f\x95\x93"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f553\x22></span></span>",
			"\xf0\x9f\x95\x94"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f554\x22></span></span>",
			"\xf0\x9f\x95\x95"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f555\x22></span></span>",
			"\xf0\x9f\x95\x96"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f556\x22></span></span>",
			"\xf0\x9f\x95\x97"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f557\x22></span></span>",
			"\xf0\x9f\x95\x98"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f558\x22></span></span>",
			"\xf0\x9f\x95\x99"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f559\x22></span></span>",
			"\xf0\x9f\x95\x9a"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f55a\x22></span></span>",
			"\xf0\x9f\x95\x9b"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f55b\x22></span></span>",
			"\xf0\x9f\x95\x9c"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f55c\x22></span></span>",
			"\xf0\x9f\x95\x9d"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f55d\x22></span></span>",
			"\xf0\x9f\x95\x9e"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f55e\x22></span></span>",
			"\xf0\x9f\x95\x9f"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f55f\x22></span></span>",
			"\xf0\x9f\x95\xa0"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f560\x22></span></span>",
			"\xf0\x9f\x95\xa1"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f561\x22></span></span>",
			"\xf0\x9f\x95\xa2"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f562\x22></span></span>",
			"\xf0\x9f\x95\xa3"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f563\x22></span></span>",
			"\xf0\x9f\x95\xa4"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f564\x22></span></span>",
			"\xf0\x9f\x95\xa5"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f565\x22></span></span>",
			"\xf0\x9f\x95\xa6"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f566\x22></span></span>",
			"\xf0\x9f\x95\xa7"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f567\x22></span></span>",
			"\xf0\x9f\x95\xaf"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f56f\x22></span></span>",
			"\xf0\x9f\x95\xb0"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f570\x22></span></span>",
			"\xf0\x9f\x95\xb3"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f573\x22></span></span>",
			"\xf0\x9f\x95\xb4"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f574\x22></span></span>",
			"\xf0\x9f\x95\xb5"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f575\x22></span></span>",
			"\xf0\x9f\x95\xb6"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f576\x22></span></span>",
			"\xf0\x9f\x95\xb7"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f577\x22></span></span>",
			"\xf0\x9f\x95\xb8"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f578\x22></span></span>",
			"\xf0\x9f\x95\xb9"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f579\x22></span></span>",
			"\xf0\x9f\x96\x87"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f587\x22></span></span>",
			"\xf0\x9f\x96\x8a"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f58a\x22></span></span>",
			"\xf0\x9f\x96\x8b"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f58b\x22></span></span>",
			"\xf0\x9f\x96\x8c"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f58c\x22></span></span>",
			"\xf0\x9f\x96\x8d"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f58d\x22></span></span>",
			"\xf0\x9f\x96\x90"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f590\x22></span></span>",
			"\xf0\x9f\x96\x95"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f595\x22></span></span>",
			"\xf0\x9f\x96\x96"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f596\x22></span></span>",
			"\xf0\x9f\x96\xa5"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f5a5\x22></span></span>",
			"\xf0\x9f\x96\xa8"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f5a8\x22></span></span>",
			"\xf0\x9f\x96\xb1"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f5b1\x22></span></span>",
			"\xf0\x9f\x96\xb2"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f5b2\x22></span></span>",
			"\xf0\x9f\x96\xbc"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f5bc\x22></span></span>",
			"\xf0\x9f\x97\x82"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f5c2\x22></span></span>",
			"\xf0\x9f\x97\x83"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f5c3\x22></span></span>",
			"\xf0\x9f\x97\x84"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f5c4\x22></span></span>",
			"\xf0\x9f\x97\x91"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f5d1\x22></span></span>",
			"\xf0\x9f\x97\x92"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f5d2\x22></span></span>",
			"\xf0\x9f\x97\x93"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f5d3\x22></span></span>",
			"\xf0\x9f\x97\x9c"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f5dc\x22></span></span>",
			"\xf0\x9f\x97\x9d"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f5dd\x22></span></span>",
			"\xf0\x9f\x97\x9e"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f5de\x22></span></span>",
			"\xf0\x9f\x97\xa1"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f5e1\x22></span></span>",
			"\xf0\x9f\x97\xa3"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f5e3\x22></span></span>",
			"\xf0\x9f\x97\xa8"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f5e8\x22></span></span>",
			"\xf0\x9f\x97\xaf"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f5ef\x22></span></span>",
			"\xf0\x9f\x97\xb3"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f5f3\x22></span></span>",
			"\xf0\x9f\x97\xba"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f5fa\x22></span></span>",
			"\xf0\x9f\x97\xbb"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f5fb\x22></span></span>",
			"\xf0\x9f\x97\xbc"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f5fc\x22></span></span>",
			"\xf0\x9f\x97\xbd"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f5fd\x22></span></span>",
			"\xf0\x9f\x97\xbe"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f5fe\x22></span></span>",
			"\xf0\x9f\x97\xbf"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f5ff\x22></span></span>",
			"\xf0\x9f\x98\x80"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f600\x22></span></span>",
			"\xf0\x9f\x98\x81"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f601\x22></span></span>",
			"\xf0\x9f\x98\x82"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f602\x22></span></span>",
			"\xf0\x9f\x98\x83"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f603\x22></span></span>",
			"\xf0\x9f\x98\x84"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f604\x22></span></span>",
			"\xf0\x9f\x98\x85"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f605\x22></span></span>",
			"\xf0\x9f\x98\x86"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f606\x22></span></span>",
			"\xf0\x9f\x98\x87"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f607\x22></span></span>",
			"\xf0\x9f\x98\x88"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f608\x22></span></span>",
			"\xf0\x9f\x98\x89"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f609\x22></span></span>",
			"\xf0\x9f\x98\x8a"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f60a\x22></span></span>",
			"\xf0\x9f\x98\x8b"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f60b\x22></span></span>",
			"\xf0\x9f\x98\x8c"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f60c\x22></span></span>",
			"\xf0\x9f\x98\x8d"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f60d\x22></span></span>",
			"\xf0\x9f\x98\x8e"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f60e\x22></span></span>",
			"\xf0\x9f\x98\x8f"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f60f\x22></span></span>",
			"\xf0\x9f\x98\x90"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f610\x22></span></span>",
			"\xf0\x9f\x98\x91"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f611\x22></span></span>",
			"\xf0\x9f\x98\x92"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f612\x22></span></span>",
			"\xf0\x9f\x98\x93"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f613\x22></span></span>",
			"\xf0\x9f\x98\x94"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f614\x22></span></span>",
			"\xf0\x9f\x98\x95"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f615\x22></span></span>",
			"\xf0\x9f\x98\x96"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f616\x22></span></span>",
			"\xf0\x9f\x98\x97"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f617\x22></span></span>",
			"\xf0\x9f\x98\x98"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f618\x22></span></span>",
			"\xf0\x9f\x98\x99"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f619\x22></span></span>",
			"\xf0\x9f\x98\x9a"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f61a\x22></span></span>",
			"\xf0\x9f\x98\x9b"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f61b\x22></span></span>",
			"\xf0\x9f\x98\x9c"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f61c\x22></span></span>",
			"\xf0\x9f\x98\x9d"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f61d\x22></span></span>",
			"\xf0\x9f\x98\x9e"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f61e\x22></span></span>",
			"\xf0\x9f\x98\x9f"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f61f\x22></span></span>",
			"\xf0\x9f\x98\xa0"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f620\x22></span></span>",
			"\xf0\x9f\x98\xa1"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f621\x22></span></span>",
			"\xf0\x9f\x98\xa2"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f622\x22></span></span>",
			"\xf0\x9f\x98\xa3"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f623\x22></span></span>",
			"\xf0\x9f\x98\xa4"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f624\x22></span></span>",
			"\xf0\x9f\x98\xa5"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f625\x22></span></span>",
			"\xf0\x9f\x98\xa6"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f626\x22></span></span>",
			"\xf0\x9f\x98\xa7"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f627\x22></span></span>",
			"\xf0\x9f\x98\xa8"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f628\x22></span></span>",
			"\xf0\x9f\x98\xa9"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f629\x22></span></span>",
			"\xf0\x9f\x98\xaa"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f62a\x22></span></span>",
			"\xf0\x9f\x98\xab"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f62b\x22></span></span>",
			"\xf0\x9f\x98\xac"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f62c\x22></span></span>",
			"\xf0\x9f\x98\xad"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f62d\x22></span></span>",
			"\xf0\x9f\x98\xae"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f62e\x22></span></span>",
			"\xf0\x9f\x98\xaf"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f62f\x22></span></span>",
			"\xf0\x9f\x98\xb0"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f630\x22></span></span>",
			"\xf0\x9f\x98\xb1"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f631\x22></span></span>",
			"\xf0\x9f\x98\xb2"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f632\x22></span></span>",
			"\xf0\x9f\x98\xb3"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f633\x22></span></span>",
			"\xf0\x9f\x98\xb4"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f634\x22></span></span>",
			"\xf0\x9f\x98\xb5"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f635\x22></span></span>",
			"\xf0\x9f\x98\xb6"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f636\x22></span></span>",
			"\xf0\x9f\x98\xb7"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f637\x22></span></span>",
			"\xf0\x9f\x98\xb8"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f638\x22></span></span>",
			"\xf0\x9f\x98\xb9"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f639\x22></span></span>",
			"\xf0\x9f\x98\xba"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f63a\x22></span></span>",
			"\xf0\x9f\x98\xbb"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f63b\x22></span></span>",
			"\xf0\x9f\x98\xbc"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f63c\x22></span></span>",
			"\xf0\x9f\x98\xbd"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f63d\x22></span></span>",
			"\xf0\x9f\x98\xbe"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f63e\x22></span></span>",
			"\xf0\x9f\x98\xbf"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f63f\x22></span></span>",
			"\xf0\x9f\x99\x80"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f640\x22></span></span>",
			"\xf0\x9f\x99\x81"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f641\x22></span></span>",
			"\xf0\x9f\x99\x82"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f642\x22></span></span>",
			"\xf0\x9f\x99\x83"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f643\x22></span></span>",
			"\xf0\x9f\x99\x84"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f644\x22></span></span>",
			"\xf0\x9f\x99\x85"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f645\x22></span></span>",
			"\xf0\x9f\x99\x86"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f646\x22></span></span>",
			"\xf0\x9f\x99\x87"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f647\x22></span></span>",
			"\xf0\x9f\x99\x88"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f648\x22></span></span>",
			"\xf0\x9f\x99\x89"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f649\x22></span></span>",
			"\xf0\x9f\x99\x8a"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f64a\x22></span></span>",
			"\xf0\x9f\x99\x8b"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f64b\x22></span></span>",
			"\xf0\x9f\x99\x8c"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f64c\x22></span></span>",
			"\xf0\x9f\x99\x8d"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f64d\x22></span></span>",
			"\xf0\x9f\x99\x8e"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f64e\x22></span></span>",
			"\xf0\x9f\x99\x8f"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f64f\x22></span></span>",
			"\xf0\x9f\x9a\x80"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f680\x22></span></span>",
			"\xf0\x9f\x9a\x81"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f681\x22></span></span>",
			"\xf0\x9f\x9a\x82"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f682\x22></span></span>",
			"\xf0\x9f\x9a\x83"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f683\x22></span></span>",
			"\xf0\x9f\x9a\x84"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f684\x22></span></span>",
			"\xf0\x9f\x9a\x85"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f685\x22></span></span>",
			"\xf0\x9f\x9a\x86"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f686\x22></span></span>",
			"\xf0\x9f\x9a\x87"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f687\x22></span></span>",
			"\xf0\x9f\x9a\x88"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f688\x22></span></span>",
			"\xf0\x9f\x9a\x89"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f689\x22></span></span>",
			"\xf0\x9f\x9a\x8a"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f68a\x22></span></span>",
			"\xf0\x9f\x9a\x8b"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f68b\x22></span></span>",
			"\xf0\x9f\x9a\x8c"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f68c\x22></span></span>",
			"\xf0\x9f\x9a\x8d"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f68d\x22></span></span>",
			"\xf0\x9f\x9a\x8e"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f68e\x22></span></span>",
			"\xf0\x9f\x9a\x8f"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f68f\x22></span></span>",
			"\xf0\x9f\x9a\x90"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f690\x22></span></span>",
			"\xf0\x9f\x9a\x91"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f691\x22></span></span>",
			"\xf0\x9f\x9a\x92"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f692\x22></span></span>",
			"\xf0\x9f\x9a\x93"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f693\x22></span></span>",
			"\xf0\x9f\x9a\x94"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f694\x22></span></span>",
			"\xf0\x9f\x9a\x95"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f695\x22></span></span>",
			"\xf0\x9f\x9a\x96"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f696\x22></span></span>",
			"\xf0\x9f\x9a\x97"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f697\x22></span></span>",
			"\xf0\x9f\x9a\x98"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f698\x22></span></span>",
			"\xf0\x9f\x9a\x99"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f699\x22></span></span>",
			"\xf0\x9f\x9a\x9a"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f69a\x22></span></span>",
			"\xf0\x9f\x9a\x9b"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f69b\x22></span></span>",
			"\xf0\x9f\x9a\x9c"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f69c\x22></span></span>",
			"\xf0\x9f\x9a\x9d"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f69d\x22></span></span>",
			"\xf0\x9f\x9a\x9e"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f69e\x22></span></span>",
			"\xf0\x9f\x9a\x9f"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f69f\x22></span></span>",
			"\xf0\x9f\x9a\xa0"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f6a0\x22></span></span>",
			"\xf0\x9f\x9a\xa1"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f6a1\x22></span></span>",
			"\xf0\x9f\x9a\xa2"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f6a2\x22></span></span>",
			"\xf0\x9f\x9a\xa3"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f6a3\x22></span></span>",
			"\xf0\x9f\x9a\xa4"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f6a4\x22></span></span>",
			"\xf0\x9f\x9a\xa5"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f6a5\x22></span></span>",
			"\xf0\x9f\x9a\xa6"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f6a6\x22></span></span>",
			"\xf0\x9f\x9a\xa7"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f6a7\x22></span></span>",
			"\xf0\x9f\x9a\xa8"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f6a8\x22></span></span>",
			"\xf0\x9f\x9a\xa9"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f6a9\x22></span></span>",
			"\xf0\x9f\x9a\xaa"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f6aa\x22></span></span>",
			"\xf0\x9f\x9a\xab"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f6ab\x22></span></span>",
			"\xf0\x9f\x9a\xac"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f6ac\x22></span></span>",
			"\xf0\x9f\x9a\xad"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f6ad\x22></span></span>",
			"\xf0\x9f\x9a\xae"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f6ae\x22></span></span>",
			"\xf0\x9f\x9a\xaf"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f6af\x22></span></span>",
			"\xf0\x9f\x9a\xb0"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f6b0\x22></span></span>",
			"\xf0\x9f\x9a\xb1"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f6b1\x22></span></span>",
			"\xf0\x9f\x9a\xb2"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f6b2\x22></span></span>",
			"\xf0\x9f\x9a\xb3"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f6b3\x22></span></span>",
			"\xf0\x9f\x9a\xb4"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f6b4\x22></span></span>",
			"\xf0\x9f\x9a\xb5"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f6b5\x22></span></span>",
			"\xf0\x9f\x9a\xb6"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f6b6\x22></span></span>",
			"\xf0\x9f\x9a\xb7"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f6b7\x22></span></span>",
			"\xf0\x9f\x9a\xb8"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f6b8\x22></span></span>",
			"\xf0\x9f\x9a\xb9"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f6b9\x22></span></span>",
			"\xf0\x9f\x9a\xba"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f6ba\x22></span></span>",
			"\xf0\x9f\x9a\xbb"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f6bb\x22></span></span>",
			"\xf0\x9f\x9a\xbc"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f6bc\x22></span></span>",
			"\xf0\x9f\x9a\xbd"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f6bd\x22></span></span>",
			"\xf0\x9f\x9a\xbe"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f6be\x22></span></span>",
			"\xf0\x9f\x9a\xbf"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f6bf\x22></span></span>",
			"\xf0\x9f\x9b\x80"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f6c0\x22></span></span>",
			"\xf0\x9f\x9b\x81"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f6c1\x22></span></span>",
			"\xf0\x9f\x9b\x82"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f6c2\x22></span></span>",
			"\xf0\x9f\x9b\x83"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f6c3\x22></span></span>",
			"\xf0\x9f\x9b\x84"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f6c4\x22></span></span>",
			"\xf0\x9f\x9b\x85"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f6c5\x22></span></span>",
			"\xf0\x9f\x9b\x8b"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f6cb\x22></span></span>",
			"\xf0\x9f\x9b\x8c"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f6cc\x22></span></span>",
			"\xf0\x9f\x9b\x8d"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f6cd\x22></span></span>",
			"\xf0\x9f\x9b\x8e"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f6ce\x22></span></span>",
			"\xf0\x9f\x9b\x8f"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f6cf\x22></span></span>",
			"\xf0\x9f\x9b\x90"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f6d0\x22></span></span>",
			"\xf0\x9f\x9b\xa0"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f6e0\x22></span></span>",
			"\xf0\x9f\x9b\xa1"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f6e1\x22></span></span>",
			"\xf0\x9f\x9b\xa2"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f6e2\x22></span></span>",
			"\xf0\x9f\x9b\xa3"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f6e3\x22></span></span>",
			"\xf0\x9f\x9b\xa4"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f6e4\x22></span></span>",
			"\xf0\x9f\x9b\xa5"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f6e5\x22></span></span>",
			"\xf0\x9f\x9b\xa9"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f6e9\x22></span></span>",
			"\xf0\x9f\x9b\xab"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f6eb\x22></span></span>",
			"\xf0\x9f\x9b\xac"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f6ec\x22></span></span>",
			"\xf0\x9f\x9b\xb0"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f6f0\x22></span></span>",
			"\xf0\x9f\x9b\xb3"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f6f3\x22></span></span>",
			"\xf0\x9f\xa4\x90"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f910\x22></span></span>",
			"\xf0\x9f\xa4\x91"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f911\x22></span></span>",
			"\xf0\x9f\xa4\x92"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f912\x22></span></span>",
			"\xf0\x9f\xa4\x93"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f913\x22></span></span>",
			"\xf0\x9f\xa4\x94"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f914\x22></span></span>",
			"\xf0\x9f\xa4\x95"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f915\x22></span></span>",
			"\xf0\x9f\xa4\x96"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f916\x22></span></span>",
			"\xf0\x9f\xa4\x97"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f917\x22></span></span>",
			"\xf0\x9f\xa4\x98"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f918\x22></span></span>",
			"\xf0\x9f\xa6\x80"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f980\x22></span></span>",
			"\xf0\x9f\xa6\x81"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f981\x22></span></span>",
			"\xf0\x9f\xa6\x82"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f982\x22></span></span>",
			"\xf0\x9f\xa6\x83"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f983\x22></span></span>",
			"\xf0\x9f\xa6\x84"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f984\x22></span></span>",
			"\xf0\x9f\xa7\x80"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f9c0\x22></span></span>",
			"#\xe2\x83\xa3"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji2320e3\x22></span></span>",
			"*\xe2\x83\xa3"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji2a20e3\x22></span></span>",
			"0\xe2\x83\xa3"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji3020e3\x22></span></span>",
			"1\xe2\x83\xa3"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji3120e3\x22></span></span>",
			"2\xe2\x83\xa3"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji3220e3\x22></span></span>",
			"3\xe2\x83\xa3"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji3320e3\x22></span></span>",
			"4\xe2\x83\xa3"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji3420e3\x22></span></span>",
			"5\xe2\x83\xa3"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji3520e3\x22></span></span>",
			"6\xe2\x83\xa3"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji3620e3\x22></span></span>",
			"7\xe2\x83\xa3"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji3720e3\x22></span></span>",
			"8\xe2\x83\xa3"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji3820e3\x22></span></span>",
			"9\xe2\x83\xa3"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji3920e3\x22></span></span>",
			"\xf0\x9f\x87\xa6\xf0\x9f\x87\xa8"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1e61f1e8\x22></span></span>",
			"\xf0\x9f\x87\xa6\xf0\x9f\x87\xa9"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1e61f1e9\x22></span></span>",
			"\xf0\x9f\x87\xa6\xf0\x9f\x87\xaa"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1e61f1ea\x22></span></span>",
			"\xf0\x9f\x87\xa6\xf0\x9f\x87\xab"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1e61f1eb\x22></span></span>",
			"\xf0\x9f\x87\xa6\xf0\x9f\x87\xac"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1e61f1ec\x22></span></span>",
			"\xf0\x9f\x87\xa6\xf0\x9f\x87\xae"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1e61f1ee\x22></span></span>",
			"\xf0\x9f\x87\xa6\xf0\x9f\x87\xb1"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1e61f1f1\x22></span></span>",
			"\xf0\x9f\x87\xa6\xf0\x9f\x87\xb2"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1e61f1f2\x22></span></span>",
			"\xf0\x9f\x87\xa6\xf0\x9f\x87\xb4"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1e61f1f4\x22></span></span>",
			"\xf0\x9f\x87\xa6\xf0\x9f\x87\xb6"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1e61f1f6\x22></span></span>",
			"\xf0\x9f\x87\xa6\xf0\x9f\x87\xb7"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1e61f1f7\x22></span></span>",
			"\xf0\x9f\x87\xa6\xf0\x9f\x87\xb8"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1e61f1f8\x22></span></span>",
			"\xf0\x9f\x87\xa6\xf0\x9f\x87\xb9"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1e61f1f9\x22></span></span>",
			"\xf0\x9f\x87\xa6\xf0\x9f\x87\xba"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1e61f1fa\x22></span></span>",
			"\xf0\x9f\x87\xa6\xf0\x9f\x87\xbc"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1e61f1fc\x22></span></span>",
			"\xf0\x9f\x87\xa6\xf0\x9f\x87\xbd"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1e61f1fd\x22></span></span>",
			"\xf0\x9f\x87\xa6\xf0\x9f\x87\xbf"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1e61f1ff\x22></span></span>",
			"\xf0\x9f\x87\xa7\xf0\x9f\x87\xa6"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1e71f1e6\x22></span></span>",
			"\xf0\x9f\x87\xa7\xf0\x9f\x87\xa7"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1e71f1e7\x22></span></span>",
			"\xf0\x9f\x87\xa7\xf0\x9f\x87\xa9"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1e71f1e9\x22></span></span>",
			"\xf0\x9f\x87\xa7\xf0\x9f\x87\xaa"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1e71f1ea\x22></span></span>",
			"\xf0\x9f\x87\xa7\xf0\x9f\x87\xab"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1e71f1eb\x22></span></span>",
			"\xf0\x9f\x87\xa7\xf0\x9f\x87\xac"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1e71f1ec\x22></span></span>",
			"\xf0\x9f\x87\xa7\xf0\x9f\x87\xad"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1e71f1ed\x22></span></span>",
			"\xf0\x9f\x87\xa7\xf0\x9f\x87\xae"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1e71f1ee\x22></span></span>",
			"\xf0\x9f\x87\xa7\xf0\x9f\x87\xaf"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1e71f1ef\x22></span></span>",
			"\xf0\x9f\x87\xa7\xf0\x9f\x87\xb1"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1e71f1f1\x22></span></span>",
			"\xf0\x9f\x87\xa7\xf0\x9f\x87\xb2"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1e71f1f2\x22></span></span>",
			"\xf0\x9f\x87\xa7\xf0\x9f\x87\xb3"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1e71f1f3\x22></span></span>",
			"\xf0\x9f\x87\xa7\xf0\x9f\x87\xb4"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1e71f1f4\x22></span></span>",
			"\xf0\x9f\x87\xa7\xf0\x9f\x87\xb6"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1e71f1f6\x22></span></span>",
			"\xf0\x9f\x87\xa7\xf0\x9f\x87\xb7"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1e71f1f7\x22></span></span>",
			"\xf0\x9f\x87\xa7\xf0\x9f\x87\xb8"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1e71f1f8\x22></span></span>",
			"\xf0\x9f\x87\xa7\xf0\x9f\x87\xb9"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1e71f1f9\x22></span></span>",
			"\xf0\x9f\x87\xa7\xf0\x9f\x87\xbb"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1e71f1fb\x22></span></span>",
			"\xf0\x9f\x87\xa7\xf0\x9f\x87\xbc"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1e71f1fc\x22></span></span>",
			"\xf0\x9f\x87\xa7\xf0\x9f\x87\xbe"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1e71f1fe\x22></span></span>",
			"\xf0\x9f\x87\xa7\xf0\x9f\x87\xbf"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1e71f1ff\x22></span></span>",
			"\xf0\x9f\x87\xa8\xf0\x9f\x87\xa6"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1e81f1e6\x22></span></span>",
			"\xf0\x9f\x87\xa8\xf0\x9f\x87\xa8"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1e81f1e8\x22></span></span>",
			"\xf0\x9f\x87\xa8\xf0\x9f\x87\xa9"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1e81f1e9\x22></span></span>",
			"\xf0\x9f\x87\xa8\xf0\x9f\x87\xab"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1e81f1eb\x22></span></span>",
			"\xf0\x9f\x87\xa8\xf0\x9f\x87\xac"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1e81f1ec\x22></span></span>",
			"\xf0\x9f\x87\xa8\xf0\x9f\x87\xad"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1e81f1ed\x22></span></span>",
			"\xf0\x9f\x87\xa8\xf0\x9f\x87\xae"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1e81f1ee\x22></span></span>",
			"\xf0\x9f\x87\xa8\xf0\x9f\x87\xb0"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1e81f1f0\x22></span></span>",
			"\xf0\x9f\x87\xa8\xf0\x9f\x87\xb1"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1e81f1f1\x22></span></span>",
			"\xf0\x9f\x87\xa8\xf0\x9f\x87\xb2"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1e81f1f2\x22></span></span>",
			"\xf0\x9f\x87\xa8\xf0\x9f\x87\xb3"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1e81f1f3\x22></span></span>",
			"\xf0\x9f\x87\xa8\xf0\x9f\x87\xb4"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1e81f1f4\x22></span></span>",
			"\xf0\x9f\x87\xa8\xf0\x9f\x87\xb5"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1e81f1f5\x22></span></span>",
			"\xf0\x9f\x87\xa8\xf0\x9f\x87\xb7"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1e81f1f7\x22></span></span>",
			"\xf0\x9f\x87\xa8\xf0\x9f\x87\xba"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1e81f1fa\x22></span></span>",
			"\xf0\x9f\x87\xa8\xf0\x9f\x87\xbb"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1e81f1fb\x22></span></span>",
			"\xf0\x9f\x87\xa8\xf0\x9f\x87\xbc"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1e81f1fc\x22></span></span>",
			"\xf0\x9f\x87\xa8\xf0\x9f\x87\xbd"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1e81f1fd\x22></span></span>",
			"\xf0\x9f\x87\xa8\xf0\x9f\x87\xbe"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1e81f1fe\x22></span></span>",
			"\xf0\x9f\x87\xa8\xf0\x9f\x87\xbf"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1e81f1ff\x22></span></span>",
			"\xf0\x9f\x87\xa9\xf0\x9f\x87\xaa"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1e91f1ea\x22></span></span>",
			"\xf0\x9f\x87\xa9\xf0\x9f\x87\xac"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1e91f1ec\x22></span></span>",
			"\xf0\x9f\x87\xa9\xf0\x9f\x87\xaf"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1e91f1ef\x22></span></span>",
			"\xf0\x9f\x87\xa9\xf0\x9f\x87\xb0"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1e91f1f0\x22></span></span>",
			"\xf0\x9f\x87\xa9\xf0\x9f\x87\xb2"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1e91f1f2\x22></span></span>",
			"\xf0\x9f\x87\xa9\xf0\x9f\x87\xb4"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1e91f1f4\x22></span></span>",
			"\xf0\x9f\x87\xa9\xf0\x9f\x87\xbf"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1e91f1ff\x22></span></span>",
			"\xf0\x9f\x87\xaa\xf0\x9f\x87\xa6"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1ea1f1e6\x22></span></span>",
			"\xf0\x9f\x87\xaa\xf0\x9f\x87\xa8"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1ea1f1e8\x22></span></span>",
			"\xf0\x9f\x87\xaa\xf0\x9f\x87\xaa"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1ea1f1ea\x22></span></span>",
			"\xf0\x9f\x87\xaa\xf0\x9f\x87\xac"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1ea1f1ec\x22></span></span>",
			"\xf0\x9f\x87\xaa\xf0\x9f\x87\xad"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1ea1f1ed\x22></span></span>",
			"\xf0\x9f\x87\xaa\xf0\x9f\x87\xb7"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1ea1f1f7\x22></span></span>",
			"\xf0\x9f\x87\xaa\xf0\x9f\x87\xb8"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1ea1f1f8\x22></span></span>",
			"\xf0\x9f\x87\xaa\xf0\x9f\x87\xb9"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1ea1f1f9\x22></span></span>",
			"\xf0\x9f\x87\xaa\xf0\x9f\x87\xba"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1ea1f1fa\x22></span></span>",
			"\xf0\x9f\x87\xab\xf0\x9f\x87\xae"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1eb1f1ee\x22></span></span>",
			"\xf0\x9f\x87\xab\xf0\x9f\x87\xaf"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1eb1f1ef\x22></span></span>",
			"\xf0\x9f\x87\xab\xf0\x9f\x87\xb0"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1eb1f1f0\x22></span></span>",
			"\xf0\x9f\x87\xab\xf0\x9f\x87\xb2"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1eb1f1f2\x22></span></span>",
			"\xf0\x9f\x87\xab\xf0\x9f\x87\xb4"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1eb1f1f4\x22></span></span>",
			"\xf0\x9f\x87\xab\xf0\x9f\x87\xb7"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1eb1f1f7\x22></span></span>",
			"\xf0\x9f\x87\xac\xf0\x9f\x87\xa6"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1ec1f1e6\x22></span></span>",
			"\xf0\x9f\x87\xac\xf0\x9f\x87\xa7"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1ec1f1e7\x22></span></span>",
			"\xf0\x9f\x87\xac\xf0\x9f\x87\xa9"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1ec1f1e9\x22></span></span>",
			"\xf0\x9f\x87\xac\xf0\x9f\x87\xaa"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1ec1f1ea\x22></span></span>",
			"\xf0\x9f\x87\xac\xf0\x9f\x87\xab"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1ec1f1eb\x22></span></span>",
			"\xf0\x9f\x87\xac\xf0\x9f\x87\xac"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1ec1f1ec\x22></span></span>",
			"\xf0\x9f\x87\xac\xf0\x9f\x87\xad"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1ec1f1ed\x22></span></span>",
			"\xf0\x9f\x87\xac\xf0\x9f\x87\xae"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1ec1f1ee\x22></span></span>",
			"\xf0\x9f\x87\xac\xf0\x9f\x87\xb1"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1ec1f1f1\x22></span></span>",
			"\xf0\x9f\x87\xac\xf0\x9f\x87\xb2"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1ec1f1f2\x22></span></span>",
			"\xf0\x9f\x87\xac\xf0\x9f\x87\xb3"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1ec1f1f3\x22></span></span>",
			"\xf0\x9f\x87\xac\xf0\x9f\x87\xb5"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1ec1f1f5\x22></span></span>",
			"\xf0\x9f\x87\xac\xf0\x9f\x87\xb6"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1ec1f1f6\x22></span></span>",
			"\xf0\x9f\x87\xac\xf0\x9f\x87\xb7"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1ec1f1f7\x22></span></span>",
			"\xf0\x9f\x87\xac\xf0\x9f\x87\xb8"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1ec1f1f8\x22></span></span>",
			"\xf0\x9f\x87\xac\xf0\x9f\x87\xb9"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1ec1f1f9\x22></span></span>",
			"\xf0\x9f\x87\xac\xf0\x9f\x87\xba"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1ec1f1fa\x22></span></span>",
			"\xf0\x9f\x87\xac\xf0\x9f\x87\xbc"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1ec1f1fc\x22></span></span>",
			"\xf0\x9f\x87\xac\xf0\x9f\x87\xbe"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1ec1f1fe\x22></span></span>",
			"\xf0\x9f\x87\xad\xf0\x9f\x87\xb0"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1ed1f1f0\x22></span></span>",
			"\xf0\x9f\x87\xad\xf0\x9f\x87\xb2"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1ed1f1f2\x22></span></span>",
			"\xf0\x9f\x87\xad\xf0\x9f\x87\xb3"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1ed1f1f3\x22></span></span>",
			"\xf0\x9f\x87\xad\xf0\x9f\x87\xb7"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1ed1f1f7\x22></span></span>",
			"\xf0\x9f\x87\xad\xf0\x9f\x87\xb9"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1ed1f1f9\x22></span></span>",
			"\xf0\x9f\x87\xad\xf0\x9f\x87\xba"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1ed1f1fa\x22></span></span>",
			"\xf0\x9f\x87\xae\xf0\x9f\x87\xa8"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1ee1f1e8\x22></span></span>",
			"\xf0\x9f\x87\xae\xf0\x9f\x87\xa9"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1ee1f1e9\x22></span></span>",
			"\xf0\x9f\x87\xae\xf0\x9f\x87\xaa"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1ee1f1ea\x22></span></span>",
			"\xf0\x9f\x87\xae\xf0\x9f\x87\xb1"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1ee1f1f1\x22></span></span>",
			"\xf0\x9f\x87\xae\xf0\x9f\x87\xb2"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1ee1f1f2\x22></span></span>",
			"\xf0\x9f\x87\xae\xf0\x9f\x87\xb3"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1ee1f1f3\x22></span></span>",
			"\xf0\x9f\x87\xae\xf0\x9f\x87\xb4"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1ee1f1f4\x22></span></span>",
			"\xf0\x9f\x87\xae\xf0\x9f\x87\xb6"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1ee1f1f6\x22></span></span>",
			"\xf0\x9f\x87\xae\xf0\x9f\x87\xb7"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1ee1f1f7\x22></span></span>",
			"\xf0\x9f\x87\xae\xf0\x9f\x87\xb8"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1ee1f1f8\x22></span></span>",
			"\xf0\x9f\x87\xae\xf0\x9f\x87\xb9"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1ee1f1f9\x22></span></span>",
			"\xf0\x9f\x87\xaf\xf0\x9f\x87\xaa"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1ef1f1ea\x22></span></span>",
			"\xf0\x9f\x87\xaf\xf0\x9f\x87\xb2"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1ef1f1f2\x22></span></span>",
			"\xf0\x9f\x87\xaf\xf0\x9f\x87\xb4"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1ef1f1f4\x22></span></span>",
			"\xf0\x9f\x87\xaf\xf0\x9f\x87\xb5"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1ef1f1f5\x22></span></span>",
			"\xf0\x9f\x87\xb0\xf0\x9f\x87\xaa"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1f01f1ea\x22></span></span>",
			"\xf0\x9f\x87\xb0\xf0\x9f\x87\xac"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1f01f1ec\x22></span></span>",
			"\xf0\x9f\x87\xb0\xf0\x9f\x87\xad"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1f01f1ed\x22></span></span>",
			"\xf0\x9f\x87\xb0\xf0\x9f\x87\xae"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1f01f1ee\x22></span></span>",
			"\xf0\x9f\x87\xb0\xf0\x9f\x87\xb2"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1f01f1f2\x22></span></span>",
			"\xf0\x9f\x87\xb0\xf0\x9f\x87\xb3"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1f01f1f3\x22></span></span>",
			"\xf0\x9f\x87\xb0\xf0\x9f\x87\xb5"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1f01f1f5\x22></span></span>",
			"\xf0\x9f\x87\xb0\xf0\x9f\x87\xb7"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1f01f1f7\x22></span></span>",
			"\xf0\x9f\x87\xb0\xf0\x9f\x87\xbc"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1f01f1fc\x22></span></span>",
			"\xf0\x9f\x87\xb0\xf0\x9f\x87\xbe"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1f01f1fe\x22></span></span>",
			"\xf0\x9f\x87\xb0\xf0\x9f\x87\xbf"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1f01f1ff\x22></span></span>",
			"\xf0\x9f\x87\xb1\xf0\x9f\x87\xa6"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1f11f1e6\x22></span></span>",
			"\xf0\x9f\x87\xb1\xf0\x9f\x87\xa7"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1f11f1e7\x22></span></span>",
			"\xf0\x9f\x87\xb1\xf0\x9f\x87\xa8"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1f11f1e8\x22></span></span>",
			"\xf0\x9f\x87\xb1\xf0\x9f\x87\xae"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1f11f1ee\x22></span></span>",
			"\xf0\x9f\x87\xb1\xf0\x9f\x87\xb0"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1f11f1f0\x22></span></span>",
			"\xf0\x9f\x87\xb1\xf0\x9f\x87\xb7"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1f11f1f7\x22></span></span>",
			"\xf0\x9f\x87\xb1\xf0\x9f\x87\xb8"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1f11f1f8\x22></span></span>",
			"\xf0\x9f\x87\xb1\xf0\x9f\x87\xb9"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1f11f1f9\x22></span></span>",
			"\xf0\x9f\x87\xb1\xf0\x9f\x87\xba"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1f11f1fa\x22></span></span>",
			"\xf0\x9f\x87\xb1\xf0\x9f\x87\xbb"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1f11f1fb\x22></span></span>",
			"\xf0\x9f\x87\xb1\xf0\x9f\x87\xbe"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1f11f1fe\x22></span></span>",
			"\xf0\x9f\x87\xb2\xf0\x9f\x87\xa6"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1f21f1e6\x22></span></span>",
			"\xf0\x9f\x87\xb2\xf0\x9f\x87\xa8"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1f21f1e8\x22></span></span>",
			"\xf0\x9f\x87\xb2\xf0\x9f\x87\xa9"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1f21f1e9\x22></span></span>",
			"\xf0\x9f\x87\xb2\xf0\x9f\x87\xaa"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1f21f1ea\x22></span></span>",
			"\xf0\x9f\x87\xb2\xf0\x9f\x87\xab"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1f21f1eb\x22></span></span>",
			"\xf0\x9f\x87\xb2\xf0\x9f\x87\xac"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1f21f1ec\x22></span></span>",
			"\xf0\x9f\x87\xb2\xf0\x9f\x87\xad"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1f21f1ed\x22></span></span>",
			"\xf0\x9f\x87\xb2\xf0\x9f\x87\xb0"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1f21f1f0\x22></span></span>",
			"\xf0\x9f\x87\xb2\xf0\x9f\x87\xb1"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1f21f1f1\x22></span></span>",
			"\xf0\x9f\x87\xb2\xf0\x9f\x87\xb2"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1f21f1f2\x22></span></span>",
			"\xf0\x9f\x87\xb2\xf0\x9f\x87\xb3"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1f21f1f3\x22></span></span>",
			"\xf0\x9f\x87\xb2\xf0\x9f\x87\xb4"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1f21f1f4\x22></span></span>",
			"\xf0\x9f\x87\xb2\xf0\x9f\x87\xb5"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1f21f1f5\x22></span></span>",
			"\xf0\x9f\x87\xb2\xf0\x9f\x87\xb6"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1f21f1f6\x22></span></span>",
			"\xf0\x9f\x87\xb2\xf0\x9f\x87\xb7"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1f21f1f7\x22></span></span>",
			"\xf0\x9f\x87\xb2\xf0\x9f\x87\xb8"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1f21f1f8\x22></span></span>",
			"\xf0\x9f\x87\xb2\xf0\x9f\x87\xb9"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1f21f1f9\x22></span></span>",
			"\xf0\x9f\x87\xb2\xf0\x9f\x87\xba"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1f21f1fa\x22></span></span>",
			"\xf0\x9f\x87\xb2\xf0\x9f\x87\xbb"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1f21f1fb\x22></span></span>",
			"\xf0\x9f\x87\xb2\xf0\x9f\x87\xbc"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1f21f1fc\x22></span></span>",
			"\xf0\x9f\x87\xb2\xf0\x9f\x87\xbd"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1f21f1fd\x22></span></span>",
			"\xf0\x9f\x87\xb2\xf0\x9f\x87\xbe"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1f21f1fe\x22></span></span>",
			"\xf0\x9f\x87\xb2\xf0\x9f\x87\xbf"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1f21f1ff\x22></span></span>",
			"\xf0\x9f\x87\xb3\xf0\x9f\x87\xa6"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1f31f1e6\x22></span></span>",
			"\xf0\x9f\x87\xb3\xf0\x9f\x87\xa8"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1f31f1e8\x22></span></span>",
			"\xf0\x9f\x87\xb3\xf0\x9f\x87\xaa"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1f31f1ea\x22></span></span>",
			"\xf0\x9f\x87\xb3\xf0\x9f\x87\xab"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1f31f1eb\x22></span></span>",
			"\xf0\x9f\x87\xb3\xf0\x9f\x87\xac"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1f31f1ec\x22></span></span>",
			"\xf0\x9f\x87\xb3\xf0\x9f\x87\xae"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1f31f1ee\x22></span></span>",
			"\xf0\x9f\x87\xb3\xf0\x9f\x87\xb1"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1f31f1f1\x22></span></span>",
			"\xf0\x9f\x87\xb3\xf0\x9f\x87\xb4"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1f31f1f4\x22></span></span>",
			"\xf0\x9f\x87\xb3\xf0\x9f\x87\xb5"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1f31f1f5\x22></span></span>",
			"\xf0\x9f\x87\xb3\xf0\x9f\x87\xb7"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1f31f1f7\x22></span></span>",
			"\xf0\x9f\x87\xb3\xf0\x9f\x87\xba"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1f31f1fa\x22></span></span>",
			"\xf0\x9f\x87\xb3\xf0\x9f\x87\xbf"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1f31f1ff\x22></span></span>",
			"\xf0\x9f\x87\xb4\xf0\x9f\x87\xb2"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1f41f1f2\x22></span></span>",
			"\xf0\x9f\x87\xb5\xf0\x9f\x87\xa6"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1f51f1e6\x22></span></span>",
			"\xf0\x9f\x87\xb5\xf0\x9f\x87\xaa"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1f51f1ea\x22></span></span>",
			"\xf0\x9f\x87\xb5\xf0\x9f\x87\xab"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1f51f1eb\x22></span></span>",
			"\xf0\x9f\x87\xb5\xf0\x9f\x87\xac"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1f51f1ec\x22></span></span>",
			"\xf0\x9f\x87\xb5\xf0\x9f\x87\xad"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1f51f1ed\x22></span></span>",
			"\xf0\x9f\x87\xb5\xf0\x9f\x87\xb0"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1f51f1f0\x22></span></span>",
			"\xf0\x9f\x87\xb5\xf0\x9f\x87\xb1"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1f51f1f1\x22></span></span>",
			"\xf0\x9f\x87\xb5\xf0\x9f\x87\xb2"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1f51f1f2\x22></span></span>",
			"\xf0\x9f\x87\xb5\xf0\x9f\x87\xb3"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1f51f1f3\x22></span></span>",
			"\xf0\x9f\x87\xb5\xf0\x9f\x87\xb7"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1f51f1f7\x22></span></span>",
			"\xf0\x9f\x87\xb5\xf0\x9f\x87\xb8"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1f51f1f8\x22></span></span>",
			"\xf0\x9f\x87\xb5\xf0\x9f\x87\xb9"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1f51f1f9\x22></span></span>",
			"\xf0\x9f\x87\xb5\xf0\x9f\x87\xbc"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1f51f1fc\x22></span></span>",
			"\xf0\x9f\x87\xb5\xf0\x9f\x87\xbe"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1f51f1fe\x22></span></span>",
			"\xf0\x9f\x87\xb6\xf0\x9f\x87\xa6"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1f61f1e6\x22></span></span>",
			"\xf0\x9f\x87\xb7\xf0\x9f\x87\xaa"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1f71f1ea\x22></span></span>",
			"\xf0\x9f\x87\xb7\xf0\x9f\x87\xb4"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1f71f1f4\x22></span></span>",
			"\xf0\x9f\x87\xb7\xf0\x9f\x87\xb8"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1f71f1f8\x22></span></span>",
			"\xf0\x9f\x87\xb7\xf0\x9f\x87\xba"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1f71f1fa\x22></span></span>",
			"\xf0\x9f\x87\xb7\xf0\x9f\x87\xbc"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1f71f1fc\x22></span></span>",
			"\xf0\x9f\x87\xb8\xf0\x9f\x87\xa6"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1f81f1e6\x22></span></span>",
			"\xf0\x9f\x87\xb8\xf0\x9f\x87\xa7"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1f81f1e7\x22></span></span>",
			"\xf0\x9f\x87\xb8\xf0\x9f\x87\xa8"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1f81f1e8\x22></span></span>",
			"\xf0\x9f\x87\xb8\xf0\x9f\x87\xa9"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1f81f1e9\x22></span></span>",
			"\xf0\x9f\x87\xb8\xf0\x9f\x87\xaa"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1f81f1ea\x22></span></span>",
			"\xf0\x9f\x87\xb8\xf0\x9f\x87\xac"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1f81f1ec\x22></span></span>",
			"\xf0\x9f\x87\xb8\xf0\x9f\x87\xad"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1f81f1ed\x22></span></span>",
			"\xf0\x9f\x87\xb8\xf0\x9f\x87\xae"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1f81f1ee\x22></span></span>",
			"\xf0\x9f\x87\xb8\xf0\x9f\x87\xaf"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1f81f1ef\x22></span></span>",
			"\xf0\x9f\x87\xb8\xf0\x9f\x87\xb0"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1f81f1f0\x22></span></span>",
			"\xf0\x9f\x87\xb8\xf0\x9f\x87\xb1"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1f81f1f1\x22></span></span>",
			"\xf0\x9f\x87\xb8\xf0\x9f\x87\xb2"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1f81f1f2\x22></span></span>",
			"\xf0\x9f\x87\xb8\xf0\x9f\x87\xb3"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1f81f1f3\x22></span></span>",
			"\xf0\x9f\x87\xb8\xf0\x9f\x87\xb4"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1f81f1f4\x22></span></span>",
			"\xf0\x9f\x87\xb8\xf0\x9f\x87\xb7"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1f81f1f7\x22></span></span>",
			"\xf0\x9f\x87\xb8\xf0\x9f\x87\xb8"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1f81f1f8\x22></span></span>",
			"\xf0\x9f\x87\xb8\xf0\x9f\x87\xb9"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1f81f1f9\x22></span></span>",
			"\xf0\x9f\x87\xb8\xf0\x9f\x87\xbb"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1f81f1fb\x22></span></span>",
			"\xf0\x9f\x87\xb8\xf0\x9f\x87\xbd"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1f81f1fd\x22></span></span>",
			"\xf0\x9f\x87\xb8\xf0\x9f\x87\xbe"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1f81f1fe\x22></span></span>",
			"\xf0\x9f\x87\xb8\xf0\x9f\x87\xbf"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1f81f1ff\x22></span></span>",
			"\xf0\x9f\x87\xb9\xf0\x9f\x87\xa6"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1f91f1e6\x22></span></span>",
			"\xf0\x9f\x87\xb9\xf0\x9f\x87\xa8"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1f91f1e8\x22></span></span>",
			"\xf0\x9f\x87\xb9\xf0\x9f\x87\xa9"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1f91f1e9\x22></span></span>",
			"\xf0\x9f\x87\xb9\xf0\x9f\x87\xab"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1f91f1eb\x22></span></span>",
			"\xf0\x9f\x87\xb9\xf0\x9f\x87\xac"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1f91f1ec\x22></span></span>",
			"\xf0\x9f\x87\xb9\xf0\x9f\x87\xad"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1f91f1ed\x22></span></span>",
			"\xf0\x9f\x87\xb9\xf0\x9f\x87\xaf"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1f91f1ef\x22></span></span>",
			"\xf0\x9f\x87\xb9\xf0\x9f\x87\xb0"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1f91f1f0\x22></span></span>",
			"\xf0\x9f\x87\xb9\xf0\x9f\x87\xb1"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1f91f1f1\x22></span></span>",
			"\xf0\x9f\x87\xb9\xf0\x9f\x87\xb2"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1f91f1f2\x22></span></span>",
			"\xf0\x9f\x87\xb9\xf0\x9f\x87\xb3"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1f91f1f3\x22></span></span>",
			"\xf0\x9f\x87\xb9\xf0\x9f\x87\xb4"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1f91f1f4\x22></span></span>",
			"\xf0\x9f\x87\xb9\xf0\x9f\x87\xb7"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1f91f1f7\x22></span></span>",
			"\xf0\x9f\x87\xb9\xf0\x9f\x87\xb9"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1f91f1f9\x22></span></span>",
			"\xf0\x9f\x87\xb9\xf0\x9f\x87\xbb"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1f91f1fb\x22></span></span>",
			"\xf0\x9f\x87\xb9\xf0\x9f\x87\xbc"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1f91f1fc\x22></span></span>",
			"\xf0\x9f\x87\xb9\xf0\x9f\x87\xbf"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1f91f1ff\x22></span></span>",
			"\xf0\x9f\x87\xba\xf0\x9f\x87\xa6"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1fa1f1e6\x22></span></span>",
			"\xf0\x9f\x87\xba\xf0\x9f\x87\xac"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1fa1f1ec\x22></span></span>",
			"\xf0\x9f\x87\xba\xf0\x9f\x87\xb2"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1fa1f1f2\x22></span></span>",
			"\xf0\x9f\x87\xba\xf0\x9f\x87\xb8"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1fa1f1f8\x22></span></span>",
			"\xf0\x9f\x87\xba\xf0\x9f\x87\xbe"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1fa1f1fe\x22></span></span>",
			"\xf0\x9f\x87\xba\xf0\x9f\x87\xbf"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1fa1f1ff\x22></span></span>",
			"\xf0\x9f\x87\xbb\xf0\x9f\x87\xa6"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1fb1f1e6\x22></span></span>",
			"\xf0\x9f\x87\xbb\xf0\x9f\x87\xa8"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1fb1f1e8\x22></span></span>",
			"\xf0\x9f\x87\xbb\xf0\x9f\x87\xaa"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1fb1f1ea\x22></span></span>",
			"\xf0\x9f\x87\xbb\xf0\x9f\x87\xac"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1fb1f1ec\x22></span></span>",
			"\xf0\x9f\x87\xbb\xf0\x9f\x87\xae"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1fb1f1ee\x22></span></span>",
			"\xf0\x9f\x87\xbb\xf0\x9f\x87\xb3"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1fb1f1f3\x22></span></span>",
			"\xf0\x9f\x87\xbb\xf0\x9f\x87\xba"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1fb1f1fa\x22></span></span>",
			"\xf0\x9f\x87\xbc\xf0\x9f\x87\xab"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1fc1f1eb\x22></span></span>",
			"\xf0\x9f\x87\xbc\xf0\x9f\x87\xb8"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1fc1f1f8\x22></span></span>",
			"\xf0\x9f\x87\xbd\xf0\x9f\x87\xb0"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1fd1f1f0\x22></span></span>",
			"\xf0\x9f\x87\xbe\xf0\x9f\x87\xaa"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1fe1f1ea\x22></span></span>",
			"\xf0\x9f\x87\xbe\xf0\x9f\x87\xb9"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1fe1f1f9\x22></span></span>",
			"\xf0\x9f\x87\xbf\xf0\x9f\x87\xa6"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1ff1f1e6\x22></span></span>",
			"\xf0\x9f\x87\xbf\xf0\x9f\x87\xb2"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1ff1f1f2\x22></span></span>",
			"\xf0\x9f\x87\xbf\xf0\x9f\x87\xbc"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f1ff1f1fc\x22></span></span>",
			"\xf0\x9f\x91\xa8\xe2\x80\x8d\xf0\x9f\x91\xa8\xe2\x80\x8d\xf0\x9f\x91\xa6"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f468200d1f468200d1f466\x22></span></span>",
			"\xf0\x9f\x91\xa8\xe2\x80\x8d\xf0\x9f\x91\xa8\xe2\x80\x8d\xf0\x9f\x91\xa6\xe2\x80\x8d\xf0\x9f\x91\xa6"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f468200d1f468200d1f466200d1f466\x22></span></span>",
			"\xf0\x9f\x91\xa8\xe2\x80\x8d\xf0\x9f\x91\xa8\xe2\x80\x8d\xf0\x9f\x91\xa7"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f468200d1f468200d1f467\x22></span></span>",
			"\xf0\x9f\x91\xa8\xe2\x80\x8d\xf0\x9f\x91\xa8\xe2\x80\x8d\xf0\x9f\x91\xa7\xe2\x80\x8d\xf0\x9f\x91\xa6"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f468200d1f468200d1f467200d1f466\x22></span></span>",
			"\xf0\x9f\x91\xa8\xe2\x80\x8d\xf0\x9f\x91\xa8\xe2\x80\x8d\xf0\x9f\x91\xa7\xe2\x80\x8d\xf0\x9f\x91\xa7"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f468200d1f468200d1f467200d1f467\x22></span></span>",
			"\xf0\x9f\x91\xa8\xe2\x80\x8d\xf0\x9f\x91\xa9\xe2\x80\x8d\xf0\x9f\x91\xa6\xe2\x80\x8d\xf0\x9f\x91\xa6"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f468200d1f469200d1f466200d1f466\x22></span></span>",
			"\xf0\x9f\x91\xa8\xe2\x80\x8d\xf0\x9f\x91\xa9\xe2\x80\x8d\xf0\x9f\x91\xa7"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f468200d1f469200d1f467\x22></span></span>",
			"\xf0\x9f\x91\xa8\xe2\x80\x8d\xf0\x9f\x91\xa9\xe2\x80\x8d\xf0\x9f\x91\xa7\xe2\x80\x8d\xf0\x9f\x91\xa6"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f468200d1f469200d1f467200d1f466\x22></span></span>",
			"\xf0\x9f\x91\xa8\xe2\x80\x8d\xf0\x9f\x91\xa9\xe2\x80\x8d\xf0\x9f\x91\xa7\xe2\x80\x8d\xf0\x9f\x91\xa7"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f468200d1f469200d1f467200d1f467\x22></span></span>",
			"\xf0\x9f\x91\xa8\xe2\x80\x8d\xe2\x9d\xa4\xef\xb8\x8f\xe2\x80\x8d\xf0\x9f\x91\xa8"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f468200d2764fe0f200d1f468\x22></span></span>",
			"\xf0\x9f\x91\xa8\xe2\x80\x8d\xe2\x9d\xa4\xef\xb8\x8f\xe2\x80\x8d\xf0\x9f\x92\x8b\xe2\x80\x8d\xf0\x9f\x91\xa8"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f468200d2764fe0f200d1f48b200d1f468\x22></span></span>",
			"\xf0\x9f\x91\xa9\xe2\x80\x8d\xf0\x9f\x91\xa9\xe2\x80\x8d\xf0\x9f\x91\xa6"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f469200d1f469200d1f466\x22></span></span>",
			"\xf0\x9f\x91\xa9\xe2\x80\x8d\xf0\x9f\x91\xa9\xe2\x80\x8d\xf0\x9f\x91\xa6\xe2\x80\x8d\xf0\x9f\x91\xa6"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f469200d1f469200d1f466200d1f466\x22></span></span>",
			"\xf0\x9f\x91\xa9\xe2\x80\x8d\xf0\x9f\x91\xa9\xe2\x80\x8d\xf0\x9f\x91\xa7"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f469200d1f469200d1f467\x22></span></span>",
			"\xf0\x9f\x91\xa9\xe2\x80\x8d\xf0\x9f\x91\xa9\xe2\x80\x8d\xf0\x9f\x91\xa7\xe2\x80\x8d\xf0\x9f\x91\xa6"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f469200d1f469200d1f467200d1f466\x22></span></span>",
			"\xf0\x9f\x91\xa9\xe2\x80\x8d\xf0\x9f\x91\xa9\xe2\x80\x8d\xf0\x9f\x91\xa7\xe2\x80\x8d\xf0\x9f\x91\xa7"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f469200d1f469200d1f467200d1f467\x22></span></span>",
			"\xf0\x9f\x91\xa9\xe2\x80\x8d\xe2\x9d\xa4\xef\xb8\x8f\xe2\x80\x8d\xf0\x9f\x91\xa9"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f469200d2764fe0f200d1f469\x22></span></span>",
			"\xf0\x9f\x91\xa9\xe2\x80\x8d\xe2\x9d\xa4\xef\xb8\x8f\xe2\x80\x8d\xf0\x9f\x92\x8b\xe2\x80\x8d\xf0\x9f\x91\xa9"=>"<span class=\x22emoji-outer emoji-sizer\x22><span class=\x22emoji-inner emoji1f469200d2764fe0f200d1f48b200d1f469\x22></span></span>",
		);
		return str_replace(array_keys($unified_to_html), $unified_to_html, $text);
	}

	/****************************************************************************
	 * 快递API公共函数st															*
	 ****************************************************************************/
	/**
	 * 获取快递api配置及函数
	 * @param string $express_type
	 */
	function express_api_load_file($express_type){
		$path			= THINK_PATH . parse_name($express_type, 1) . '/';
		$config_file	= array('extendDd');
		foreach ($config_file as $file_name) {
			$file_path	= $path . $file_name . '.php';
			if(is_file($file_path)){
				C(include $file_path);
			}
		}
		$function_file	= array('functions');
		foreach ($function_file as $file_name) {
			$file_path	= $path . $file_name . '.php';
			if(is_file($file_path)){
				require_cache($file_path);
			}
		}
	}

	/**
	 *
	 * @param string $express_type
	 * @param string $express_prefix express 表别名
	 * @param boolean $return_string 是否返回字符串，默认为否，返回数组
	 * @return mixed
	 */
	function express_api_sale_order_where($express_type, $express_prefix = 'e', $return_string = false){
		switch (strtoupper($express_type)) {
			case 'DHL':
				$company_id	= C('EXPRESS_DHL_ID');//DHL快递公司
				break;
			case 'CORREOS':
				$company_id	= C('EXPRESS_ES_CORREOS_ID');//CORREOS快递公司
				break;
			case 'GLS':
				$company_id	= array('in', C('GLS_API_EXPRESS_ID'));//GLS快递公司
				break;
		}
		$where	= array(
					$express_prefix . '.company_id'		=> $company_id,
					$express_prefix . '.enable_api'		=> 1,//启用api
				);
		if ($return_string) {
			$where	= implode(' and ', $where);
		}
		return $where;
	}

	/**
	 * 查询指定订单是否为快递API订单
	 * @param string $express_type
	 * @param int $sale_order_id
	 * @param boolean $is_del
	 * @return int
	 */
	function express_api_sale_order_id($express_type, $sale_order_id = 0, $is_del = false){
		static $ids	= array();
		$where		= express_api_sale_order_where($express_type);
		$is_array	= is_array($sale_order_id) ? true : false;
		if ($is_array) {
			$where['s.id']	= array('in', $sale_order_id);
		} elseif ($sale_order_id > 0) {
			if (isset($ids[$express_type][$sale_order_id])) {
				return $ids[$express_type][$sale_order_id];
			}
			$where['s.id']	= $sale_order_id;
		} else {
			return 0;
		}
		$model		= $is_del === true ? 'SaleOrderDel' : 'SaleOrder';
		$join		= array(
			'INNER JOIN __EXPRESS__ e on e.id = s.express_id'
		);
		$id			= M($model)->alias('s')->join($join)->where($where)->getField('s.id', $is_array);
		if ($is_array) {
			foreach ($id as $sale_id) {
				$ids[$express_type][$sale_id]	= $sale_id;
			}
		} elseif ($sale_order_id > 0) {
			$ids[$express_type][$sale_order_id]	= $id;
		}
		return $id;
	}

	/**
	 * 订单是否已创建快递API发货的判断依据
	 * @param string $prefix sale_order 表别名
	 * @return mixed
	 */
	function express_api_created_sale_order_where($prefix = ''){
		if (ltrim($prefix, '.')) {
			$prefix	= ltrim($prefix, '.') . '.';
		}
		$where	= array(
			$prefix . 'track_no'	=> array('neq', ''),
			$prefix . 'Labelurl'	=> array('neq', ''),
			'_string'				=> $prefix . 'Labelurl=list.Labelurl',
		);
		return $where;
	}

	/**
	 * 订单是否已经创建快递API发货单（以追踪单号不为空作判断依据）
	 * @param string $express_type
	 * @param int $sale_order_id
	 * @return boolean
	 */
	function express_api_created_sale_order($express_type, $sale_order_id, $is_del = false){
		$where			= express_api_created_sale_order_where('s');
		$where['s.id']	= $sale_order_id;
		$join			= 'inner join __' . strtoupper($express_type) . '_LIST__ list on list.object_id=s.id';
		$model			= $is_del === true ? 'SaleOrderDel' : 'SaleOrder';
		return M($model)->alias('s')->join($join)->where($where)->count() > 0 ? true : false;
	}

	/**
	 * 获取订单列表允许手动删除快递API发货的条件
	 * @param string $express_type
	 * @param mixed $sale_order_id
	 * @param string $sale_prefix
	 * @param string $express_prefix
	 * @return array
	 */
	function express_api_allow_manually_delete_where($express_type, $sale_order_id, $sale_prefix = 's', $express_prefix = 'e'){
		$where										= array_merge(express_api_sale_order_where($express_type, $express_prefix), express_api_created_sale_order_where($sale_prefix));
		if (ltrim($sale_prefix, '.')) {
			$sale_prefix	= ltrim($sale_prefix, '.') . '.';
		}
		$where[$sale_prefix . 'sale_order_state']	= C('SALE_ORDER_STATE_EXPORTING');
		$where[$sale_prefix . 'id']					= is_array($sale_order_id) ? array('in', $sale_order_id) : $sale_order_id;
		return $where;
	}

	/**
	 * 允许手动删除快递API发货的订单id
	 * @param string $express_type
	 * @param mixed $sale_order_id
	 * @return mixed
	 */
	function express_api_allow_manually_delete_sale_order_id($express_type, $sale_order_id){
		$where	= express_api_allow_manually_delete_where($express_type, $sale_order_id);
		$join							= array(
			'INNER JOIN __EXPRESS__ e on e.id = s.express_id',
			'INNER JOIN __' . strtoupper($express_type) . '_LIST__ list on list.object_id = s.id',
		);
		return M('SaleOrder')->alias('s')->join($join)->where($where)->getField('s.id', is_array($sale_order_id));
	}

	/**
	 * 获取还需请求的条件
	 * @param type $return_string
	 * @return array
	 */
	function express_api_get_need_request_where($return_string = false) {
		if ($return_string === true) {
			$where	= ' request_status in ("' . implode('", "', C('EXPRESS_API_ALLOW_REQUEST_STATUS')) . '")';
		} else {
			$where	= array(
				'request_status'	=> array('in', C('EXPRESS_API_ALLOW_REQUEST_STATUS')),
			);
		}
		return $where;
	}

	/**
	 * 获取还需请求的队列
	 * @param string $express_type
	 * @param type $default_where
	 * @param int $limit
	 * @return array
	 */
	function express_api_get_need_request($express_type, $default_where = array(), $limit = 1){
		$express_list	= strtolower($express_type) . '_list';
		$where			= express_api_get_need_request_where();
		if (!empty($default_where)) {
			$where	= array_merge($where, $default_where);
		}
		$model			= M($express_list);
		$order			= 'last_request_time asc';
		$field			= 'object_id, object_id, object_no, id as ' . $express_list . '_id, request_status';
		$dhl_list		= $model->where($where)->limit($limit)->order($order)->getField($field);
		return $dhl_list;
	}

	/**
	 * 获取还未完成请求的条件
	 * @param type $return_string
	 * @return array
	 */
	function express_api_get_unfinished_request_where ($return_string = false) {
		$request_status		= C('EXPRESS_API_ALLOW_REQUEST_STATUS');
		$request_status[]	= EXPRESS_API_REQUEST_STATUS_REQUESTING;
		if ($return_string === true) {
			$where	= ' request_status in ("' . implode('", "', $request_status) . '")';
		} else {
			$where	= array(
				'request_status'	=> array('in', $request_status),
			);
		}
		return $where;
	}

	/**
	 * 获取快递API所需的订单信息
	 * @param string $express_type
	 * @param mixed $sale_order_id
	 * @return array
	 */
	function express_api_get_sale_order_info($express_type, $sale_order_id){
		$where			= express_api_sale_order_where($express_type);
		$where['s.id']	= is_array($sale_order_id) ? array('in', $sale_order_id) : $sale_order_id;
		$join			= array(
			'INNER JOIN __SALE_ORDER_ADDITION__ d on d.sale_order_id=s.id',
			'INNER JOIN __EXPRESS__ e on e.id=s.express_id',
		);
		$field			= 's.id as sale_order_id, s.sale_order_no, s.weight, s.track_no, s.Labelurl, s.api_checksum, s.track_no_update_tips, s.is_print,s.send_date,s.warehouse_id,s.sale_order_state,'
						. 'd.consignee, d.address, d.address2, d.country_id, d.post_code, d.city_name, d.company_name, d.mobile, d.email, d.fax';
		$model			= M('SaleOrder')->alias('s')->join($join)->where($where)->field($field);
		$sale			= is_array($sale_order_id) ? resetArrayIndex($model->select(), 'sale_order_id') : $model->find();
		return $sale;
	}

	/**
	 * 将指定订单的还需处理请求的请求状态置为已取消
	 * @param string $express_type
	 * @param mixed $sale_order_id
	 * @param mixed $express_list_id
	 */
	function express_api_cancel_request($express_type, $sale_order_id = null, $express_list_id = null){
		$where	= express_api_get_need_request_where();
		$flag	= true;
		if ($sale_order_id) {
			$flag	= false;
			$where['object_id']	= is_array($sale_order_id) ? array('in', $sale_order_id) : $sale_order_id;
		}
		if ($express_list_id) {
			$flag	= false;
			$where['id']		= is_array($express_list_id) ? array('in', $express_list_id) : $express_list_id;
		}
		if ($flag) {
			return false;
		}
		return M(strtolower($express_type) . '_list')->where($where)->setField('request_status', EXPRESS_API_REQUEST_STATUS_CANCELLED);
	}

	/**
	 * 添加新增请求
	 * 真正执行新增请求后，要记录数据校验码，以便更新时进行校验是否需要更新
	 * 1. 先判断本订单有无还需处理的新增请求，如有则跳过本次添加请求，否则继续执行
	 * 2. 当前已存在正在请求的记录，则报错并退出
	 * 3. 将本订单所有还需处理请求的请求状态改为已取消
	 * 4. 添加本次新增请求
	 * @param string $express_type
	 * @param int $sale_order_id
	 * @return boolean
	 */
	function express_api_create_request($express_type, $sale_order_id){
		$request_type	= 'createShipmentDD';
		$default_where	= array(
			'object_id'		=> $sale_order_id,
			'request_type'	=> $request_type,
		);
		if (express_api_created_sale_order($express_type, $sale_order_id) === true || express_api_get_need_request($express_type, $default_where)) {//已有还需处理的新增请求
			return true;
		}
		express_api_verify_requesting($express_type, $sale_order_id);
		express_api_cancel_request($express_type, $sale_order_id);//取消所有未处理请求
		$data			= array(
			'request_type'		=> $request_type,
			'object_id'			=> $sale_order_id,
			'object_no'			=> M('SaleOrder')->where(array('id' => $sale_order_id))->getField('sale_order_no'),
			'request_status'	=> EXPRESS_API_REQUEST_STATUS_PENDING,
			'create_time'		=> date('Y-m-d H:i:s'),
			'last_request_time'	=> date('Y-m-d H:i:s'),
		);
		return M(strtolower($express_type) . '_list')->add($data);//新增请求
	}

	/**
	 * 添加删除请求
	 * 真正执行删除请求成功后，清除数据校验码
	 * 1. 当前已存在正在请求的记录，则报错并退出
	 * 2. 将本订单所有还需处理请求的请求状态改为已取消
	 * 3. 如果当前未创建API发货，则跳过本次添加请求，否则继续
	 * 4. 添加本次删除请求
	 * @param string $express_type
	 * @param int $sale_order_id
	 * @param boolean $is_del
	 * @return mixed
	 */
	function express_api_delete_request($express_type, $sale_order_id, $is_del = false){
		express_api_verify_requesting($express_type, $sale_order_id);
		express_api_cancel_request($express_type, $sale_order_id);//取消所有还需处理的请求
		if (express_api_created_sale_order($express_type, $sale_order_id, $is_del) === false) {//还未创建API发货
			return true;
		}
		$request_type	= 'deleteShipmentDD';
		$model			= $is_del ? 'SaleOrderDel' : 'SaleOrder';
		$filed			= 'l.object_no, l.shipmentNumber, l.Labelurl';
		$join			= 'inner join __' . strtoupper($express_type) . '_LIST__ l on l.object_id=s.id and l.Labelurl=s.Labelurl';
		$where			= array(
			'l.object_id'		=> $sale_order_id,
			'l.request_type'	=> array('in', array('createShipmentDD', 'updateShipmentDD')),
			'l.request_status'	=> EXPRESS_API_REQUEST_STATUS_SUCCESSFUL,
		);
		$queue		= M($model)->alias('s')->field($filed)->join($join)->where($where)->find();
		if (empty($queue)) {
			return true;
		}
		$data			= array(
			'request_type'		=> $request_type,
			'object_id'			=> $sale_order_id,
			'object_no'			=> $queue['object_no'],
			'shipmentNumber'	=> $queue['shipmentNumber'],
			'Labelurl'			=> $queue['Labelurl'],
			'request_status'	=> EXPRESS_API_REQUEST_STATUS_PENDING,
			'create_time'		=> date('Y-m-d H:i:s'),
			'last_request_time'	=> date('Y-m-d H:i:s'),
		);
		return M(strtolower($express_type) . '_list')->add($data);//新增请求
	}

	/**
	 * 添加更新请求
	 * 真正执行更新请求前应判断数据校验码是否与新增时一致，一致则取消更新，否则执行更新，并记录新的数据校验码
	 * 1. 还未创建API发货，则添加新增请求，并返回，否则继续
	 * 2. 当前已存在正在请求的记录，则报错并退出
	 * 3. 将本订单所有还需处理请求的请求状态改为已取消
	 * 4. 添加本次更新请求
	 * @param string $express_type
	 * @param int $sale_order_id
	 * @return mixed
	 */
	function express_api_update_request($express_type, $sale_order_id){
		if (express_api_created_sale_order($express_type, $sale_order_id) !== true) {//还未创建则新增
			return express_api_create_request($express_type, $sale_order_id);
		}
		express_api_verify_requesting($express_type, $sale_order_id);
		express_api_cancel_request($express_type, $sale_order_id);//取消所有未处理请求
		$sale	= express_api_get_sale_order_info($express_type, $sale_order_id);
		$order	= D(ucfirst(strtolower($express_type)) . 'CreateShipment')->getShipmentOrderBasic($sale);
		if ($sale['api_checksum'] == md5(serialize($order))) {
			return true;
		}
		$request_type	= 'updateShipmentDD';
		$data			= array(
			'request_type'		=> $request_type,
			'object_id'			=> $sale_order_id,
			'object_no'			=> M('SaleOrder')->where(array('id' => $sale_order_id))->getField('sale_order_no'),
			'request_status'	=> EXPRESS_API_REQUEST_STATUS_PENDING,
			'create_time'		=> date('Y-m-d H:i:s'),
			'last_request_time'	=> date('Y-m-d H:i:s'),
		);
		return M(strtolower($express_type) . '_list')->add($data);//新增请求
	}

	/**
	 * 当前单据正在执行快递api请求时，不可进行操作
	 * @param string $express_type
	 * @param int $sale_order_id
	 */
	function express_api_verify_requesting($express_type, $sale_order_id, $return = false){
		$where	= array(
			'object_id'			=> $sale_order_id,
			'request_status'	=> EXPRESS_API_REQUEST_STATUS_REQUESTING,
		);
		if (M(strtolower($express_type) . '_list')->where($where)->count() > 0) {
			if ($return === true) {
				return false;
			}
			throw_json(L('sale_order_express_api_requesing'));
			rollback();
			exit;
		}
		return true;
	}
	/****************************************************************************
	 * 快递API公共函数ed															*
	 ****************************************************************************/
