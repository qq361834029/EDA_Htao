<?php 
/**
 * 条形码
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category   	账目信息
 * @package  	Model
 * @author    	何剑波
 * @version 	2.1,2012-07-22
 */
class BarcodePublicModel extends CommonModel {
	
	protected 	$tableName = 'barcode'; 
	public  	$serial_no = 0; 


	/** 
     * 新增条形码 
     * @access public 
     * @param int $id 产品ID
     * @param string $first 生成前缀 
     * @return array 
     */	
	public function addBarcode($id){
		///判断条形码是否开启 
		if (C('barcode')!=1){
			return ;
		} 
		$options	=	C('barcode_rules');   
		
		///判断是否有条形码规则
		if (empty($options)) {
			return false;
		}
		///判断是否有间隔->插入间隔符
		$is_comma	=	$options['is_comma']==1 ? ' ' : '';
		///获取产品信息
		$product 		=	D('product'); 
		$this->p_info	=	$product->getInfo($id);  
 		///判断是否有流水码
 		if (isset($options['barcode']['serial_no'])) {
 			$serial_no	=	$options['barcode']['serial_no']; 
 			unset($options['barcode']['serial_no']);
 		}    
		$combinlist	= $this->getCombinlist($options['barcode'], $id, $is_comma);  
		///获取条形码
		$barcode_info	=	 $this->createBarcode($combinlist); 
		$info			=	 $barcode_info['barcode'];
		$barcode_key	=	 $barcode_info['key'];
		foreach ((array)$info as $key=>$row) {
			$insert	=	array(
								'barcode_no'=>trim($row.($serial_no>0 ? $is_comma.$this->getBarCodeserial_no($serial_no, $row) : '')),
								'size_id'=>isset($barcode_key[$key]['size_no'])?$barcode_key[$key]['size_no']:0,
								'color_id'=>isset($barcode_key[$key]['color_no'])?$barcode_key[$key]['color_no']:0, 
								'p_id'=>$id,); 	 
			$insertCache[$id][$insert['color_id']][$insert['size_id']]	=	$insert['barcode_no'];			
			$this->add($insert);
		}		
		insertProductBarCodeCache($id,$insertCache); 
		return true;
	}
	
	/**
	 * 
	 * @param array $barcode
	 * @param int $id
	 * @param string $is_comma
	 * @return array
	 */
	public function getCombinlist($barcode, $id, $is_comma){
		foreach ((array)$barcode as $key=>$row) {  
			$function_name		= 'getBarCode'.$key;   ///根据流程类型 得到函数名
			if (method_exists($this,$function_name)) {
				$combinlist[][] 	= $is_comma.$this->$function_name($id,$row);  
			}else{ 
				if (in_array($key,array('color_no','size_no'))) { 
					$function_name		= 'properties'.$key;   ///根据流程类型 得到函数名
					$combinlist[$key] 	= $this->$function_name($key,$id,$row,$is_comma); 
				}else{
					///初始化字典
					if (empty($this->dd_info)) {	$this->dd_info	=	S('properties');	}   
					$combinlist[] 	= $is_comma . $this->properties($key,$this->p_info['detail'][$key],$row); 
				}
				
			}  
		}   
		return $combinlist;
	}

	/** 
     * 更新条形码 
     * @access public 
     * @param int $id 产品ID
     * @param string $first 生成前缀 
     * @return array 
     */	
	public function updateBarcode($id){ 
		$id	=	intval($id);
		if ($id>0) {
			$this->deleteBarcode($id);
			$this->addBarcode($id);
		} 
	}
	
	/**
	 * 删除条形码
	 *
	 * @param int $id
	 */
	public function deleteBarcode($id){
		if ($id>0) {
			///删除原有ID 
			$this->where('p_id='.$id)->delete(); /// 初除id为5癿用户数据  
		} 
	}
	 
	/**
	 * 扩展属性
	 *
	 * @param int $properties_id
	 * @param array $info
	 * @param string $strlen
	 * @return array
	 */
	public function properties($properties_id,$info,$strlen='1'){  
		$function_name		= 'getProperties'.$info['properties_type'];   ///根据流程类型 得到函数名
		if (method_exists($this,$function_name)) {
				$combinlist	= $this->$function_name($info,$strlen);
		} 
		return $combinlist; 
	}
	
	/**
	 * 颜色编号
	 *
	 * @param string $key
	 * @param int $id
	 * @param string $strlen
	 * @param bool $is_comma
	 * @return array
	 */
	public function propertiescolor_no($key,$id,$strlen,$is_comma){
		if ($id>0) { 
			$model	=	M('product_color');
			$list	=	$model->where('product_id='.intval($id))->select();  
			if (is_array($list)) {
				 $color_dd	=	S('color');
				 foreach ((array)$list as $key=>$row) { 
				 	$rs[$row['color_id']]		=	$is_comma.$this->cutStr($color_dd[$row['color_id']]['color_no'],$strlen,getBarcodeExchange('color_no'));
				 } 		
				 unset($color_dd);	
			}else{
					$rs[0]		=	$is_comma.$this->cutStr('',$strlen);
			}   
			return $rs; 			
		}
	}
	 
	/**
	 * 产品尺码
	 *
	 * @param string $key
	 * @param int $id
	 * @param string $strlen
	 * @param bool $is_comma
	 * @return array
	 */
	public function propertiessize_no($key,$id,$strlen,$is_comma){ 
		if ($id>0) { 
			$model	=	M('product_size');
			$list	=	$model->where('product_id='.intval($id))->select(); 
			
			if (is_array($list)) {
				 $size_dd	=	S('size'); 
				 foreach ((array)$list as $key=>$row) { 
				 	$rs[$row['size_id']]		=	$is_comma.$this->cutStr($size_dd[$row['size_id']]['size_no'],$strlen,getBarcodeExchange('size_no'));
				 } 		
				 unset($size_dd);	
			}else{
					$rs[0]		=	$is_comma.$this->cutStr('',$strlen);
			}   
			return $rs; 			
		} 
	}
	 
	/**
	 * 客户输入的所属参数
	 *
	 * @param array $info
	 * @param string $strlen
	 * @return array
	 */
	public function getProperties1($info,$strlen){ 
		$rs		=	array($this->cutStr($info['value'],$strlen));
		return 	$rs;
	}
	 
	/**
	 * 客户单选的所属参数
	 *
	 * @param array $info
	 * @param string $strlen
	 * @return array
	 */
	public function getProperties2($info,$strlen){
		$dd		=	&$this->dd_info;	  
		$rs		=	array($this->cutStr($dd[$info['value']]['properties_value_no'],$strlen));
		return $rs;
	}
	
	/**
	 * 客户多选的所属参数
	 *
	 * @param array $info
	 * @param string $strlen
	 * @return array
	 */
	public function getProperties3($info,$strlen){
	 	$dd		=	&$this->dd_info;	 
		$value	=	explode(',',$info['value']);  
		///获取参数编号
		foreach ((array)$value as $key=>$row) {  	$rs[]		=	$this->cutStr($dd[$row]['properties_value_no'],$strlen);		}   
		return $rs;
	}		
	
	 
	/**
	 * 截取
	 *
	 * @param string $str
	 * @param int $strlend
	 * @param int $strlend 判断是否补充值
	 * @return string
	 */
	public function cutStr($str,$strlen,$isStrPad=false){
		///截取 
		$str	=	 substr($str,0,$strlen); 
		if ($isStrPad==false){
			///补充位数补0
			return $this->strPad($str,$strlen);  
		}else{
			return $str; 
		} 
	} 
	 
	/**
	 * 补充位数补0
	 *
	 * @param string $str
	 * @param int $strlend
	 * @return array
	 */
	public function strPad($str,$strlen='1'){
///		return $str;
		///不够位数补0
		return str_pad($str, $strlen , '0',STR_PAD_LEFT); 
	}	
	
	/**
	 * 国家代码国家代码
	 *
	 * @param int $id
	 * @param string $strlen
	 */
	public function getBarCodecountry($id,$strlen='1'){  
		$barcode	= C('barcode_rules');    
		$str		= $barcode['country_no'];  /// abcdef  
		return $this->cutStr($str,$strlen,getBarcodeExchange('country')); 
	}		
	
	/**
	 * 厂家编号
	 *
	 * @param int $id
	 * @param string $strlen
	 */
	public function getBarCodecomp_no($id,$strlen='1'){ 
		$dd		=	S('factory'); 
		$str	=	$dd[$this->p_info['factory_id']]['factory_no'];   
		unset($dd);
		return $this->cutStr($str,$strlen,getBarcodeExchange('comp_no')); 
	} 	

	/**
	 * 类别编号
	 *
	 * @param int $id
	 * @param string $strlen
	 */
	public function getBarCodeclass_no($id,$strlen='1'){  
		$dd		=	S('product_class'); 
		$str	=	$dd[$this->p_info['product_class_id']]['class_no'];   
		unset($dd);
		///补充返回
		return $this->cutStr($str,$strlen,getBarcodeExchange('class_no')); 
	}	
	
	/**
	 * 产品编号
	 *
	 * @param int $id
	 * @param string $strlen
	 */
	public function getBarCodeproduct_no($id,$strlen='1'){   
		$str		=	$this->p_info['product_no']; 
		///补充返回
		return $this->cutStr($str,$strlen,getBarcodeExchange('product_no')); 
	}		
	 
	/**
	 * 流水码
	 *
	 * @param string $strlen
	 * $param string $row
	 * @return array
	 */
	public function getBarCodeserial_no($strlen='1', $row = ''){   
		if ($this->serial_no <= 0) {
			$row	= trim($row);
			$len	= strlen($row);
			$barcode_no	= $this->field('max(substr( `barcode_no` , ' . ($len+1) . ')) as max_serial_no')->where("left(barcode_no," . $len . ")='" . $row . "'")->find();
			$this->serial_no	= (int)$barcode_no['max_serial_no'];
		}
		$str	=	++$this->serial_no;
		return $this->cutStr($str,$strlen);   
	}
 
	/** 
     * 生成条形码 
     * @access public 
     * @param array $combinlist 条形码数组 
     * @return array 
     */	
	public function createBarcode($combinlist){
 
		/* 计算c(a,1) * c(b, 1) * ... * c(n, 1)的值 */
		$combinecount = 1;  
		foreach($combinlist as $key => $value) {
			$count	=	count($value);
			if ($count>0) {
				$combinecount *=$count;
			} 
		}  
		$repeattime = $combinecount;
		foreach($combinlist as $key => $value) {
		    /// $value中的元素在拆分成组合后纵向出现的最大重复次数
		    $repeattime = $repeattime / count($value);
		    $startposition = 1; 
		    foreach($value as $combinlist_value_key=>$combinlist_value) {
		        $tempstartposition = $startposition;
		        $spacecount = $combinecount / count($value) / $repeattime;
		        for($j = 1; $j <= $spacecount; $j ++) {
		            for($i = 0; $i < $repeattime; $i ++) {  
		               $result[$tempstartposition + $i][$key] = $combinlist_value; 
		               if(in_array($key,array('color_no','size_no'))) {
		               	 $result_key[$tempstartposition + $i-1][$key] = $combinlist_value_key; 
		               }
		            }
		            $tempstartposition += $repeattime * count($value);
		        }
		        $startposition += $repeattime;
		    }
		}  
		///循环组合成一条条形码 
		foreach ((array)$result as $key=>$row) { 
			$barcode[]	=	 join($row);
		} 
		$info['barcode']	=	$barcode;
		$info['key']		=	$result_key;
		return $info;
	}
	
	/**
	 * 增加条形码业务规则
	 *
	 * @param array $info
	 */
	public function addConfigBarcode($info){
			///更新条形码业务规则
///			BarcodeModel::saveConfigBarcodeDd($info);
    		///条形码规则压入DD
///    		BarcodeModel::createConfigBarcodeDd();
	}
	
	/**
	 * 更新条形码业务规则
	 *
	 * @param array $info
	 * @return array
	 */
	public function saveConfigBarcodeDd($info){
		///循环选择的业务规则
		foreach ((array)$info['rights_id'] as $key=>$row) { 
			$rs['barcode'][$row]		=	$_POST['len'][$key]; 
			if(isset($info['is_exchange'][$key])) {
				$barcode_is_exchange	=	$info['rights_id'][$key];
			} 
    	}
    	$rs['barcode_length']			=	$_POST['barcode_length'];	///长度
    	$rs['barcode_is_exchange']		=	$barcode_is_exchange;		///长度
    	$rs['is_comma']					=	$_POST['is_comma'];			///是否逗号隔离  
    	$rs['country_no']				=	$_POST['country_no'];			///是否逗号隔离 
    	 
    	///插入数据库 
		M('appConfig')->execute('update __TABLE__  set `content`=\''.json_encode($rs).'\' where id=2'); 
		return $rs;
	}
	
	/**
	 * 创建条形码字典
	 *
	 * @return array
	 */
	public function createConfigBarcodeDd(){
		///开启条形码
		if (C('barcode')) {
			///获取条形码规则
			$options	=	M('appConfig')->where('id=2')->find();      
			$dd			=	json_decode($options['content'],true);	 
			///规则压入DD
			S('barcode',$dd);  
			return $dd; 
		} 
	}
	 
	/**
	 * 清除条形码字典
	 *
	 */
	public function clearConfigBarcodeDd(){ 
		S('barcode','');  
	}
}
