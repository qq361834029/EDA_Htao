<?php  
/*
	新订单导出->
	追踪单号导入->
	追踪单号列表
*/
class TrackOrderPublicAction extends RelationCommonAction {

	public function __construct(){
		parent::__construct(); 
		$this->assign('sid',session_id());
		$this->assign('file_tocken',md5(time()));
		if(getUser('role_type')==C('WAREHOUSE_ROLE_TYPE')) {
			$_POST['sale_order']['query']['warehouse_id'] = intval(getUser('company_id'));
			if (getUser('company_id') > 0) {
				$this->assign("warehouse_id", getUser('company_id'));
				$this->assign("w_name", SOnly('warehouse',getUser('company_id'), 'w_name'));		
			}	
		}
	}
	
	//列表
	public function _autoIndex($temp_file=null) { 
		$this->action_name = ACTION_NAME;
    	$model			   = $this->getModel(); 	
    	$list			   = $model->index();  
		if($list['list']){
			$express	= S('express');
			if($express){
				foreach($express as $k => $v){
					$e_d[$v['express_no']] = $k;
				}
			}
			$path		   = getUploadPath(11);
			foreach($list['list'] as $key=>&$val){
				$val['file_exists'] = file_exists($path.$val['file_url'])?1:0;
				$tmp			    = explode('-',$val['cpation_name']);
				$val['is_dhl']		= 0;
                if(count($tmp)==4 && array_key_exists($tmp[2],$e_d)){
                    switch ($e_d[$tmp[2]]){
                        case C('EXPRESS_DHL_ID')://快递是否是DHL
                            $val['is_dhl']  = 1;
                            break;
                        case C('EXPRESS_IT-NEXIVE_ID')://added yyh 20150526
                        case C('EXPRESS_BRT_ID')://快递是否是BRT
                            $val['is_dhl']  = 2;
                            break;
                        //case C('EXPRESS_FR-GLS_ID'):
                           // $val['is_dhl']  = 3;
                           // break;
                        case C('EXPRESS_UPS_ID'):
                            $val['is_dhl']  = 5;
                            break;
                        case C('EXPRESS_UK-DPD_ID'):
                            $val['is_dhl']  = 6;
                            break;
                    }
				}
                if(strtolower(substr($val['file_url'], -3))=='txt' && $val['is_dhl'] == 0){//added by yyh 20141029//是否是西班牙Correos快递/UK-DPD
                    $val['is_dhl']		= 4;
                }   
			}
		}
		$this->list		   = $list;
		$this->displayIndex($temp_file);
	}  
	
	//新订单导出
	public function exportSaleOrder(){
		if($_POST){
			$w_id = $company_id	= 0;  

			if(intval($_POST['query']['a.warehouse_id'])>0){
				$w_id			= $_POST['query']['a.warehouse_id'];
			}
			if(intval($_POST['query']['d.company_id'])>0){
				$company_id		= $_POST['query']['d.company_id'];
			}
			if(intval($_POST['query']['express_id'])>0){
				$express_id		= $_POST['query']['express_id'];
			}
            if(!empty($_POST)){
                $type           = $_POST['type'];
            }
            $this->assign("type",$type);
			$this->assign("w_id", $w_id);
			$this->assign("express_id", $express_id);
			$this->assign("company_id", $company_id);		
		}
		getOutPutRand();
		if ($_POST['search_form']) {
			$this->display ('export_list');
		}else {
			$this->display ();
		}
	}
    public function exportSaleOrderList(){
        $this->action_name = ACTION_NAME;
    	$model			   = $this->getModel(); 	
    	$list			   = $model->index();  
		if($list['list']){			
			$path		   = getUploadPath(C('TRACK_ORDER_RELATION_TYPE'));
			foreach($list['list'] as $key=>&$val){
				$val['file_exists'] = file_exists($path.$val['file_url'])?1:0;
				$tmp			    = explode('-',$val['cpation_name']);
			}
		}
		$this->list		   = $list;
		$this->displayIndex('index');
    }

        //追踪单号导入
	public function importTrackNo(){  
		if (empty($temp_file)){ 
			$temp_file	=	empty($this->_Member)?ACTION_NAME:$this->_Member.ACTION_NAME;  
		}  
		$this->display($temp_file);
	}
	
	//追踪单号导入
	public function import(){
		$id			  = intval($_GET['id']);
		$is_dhl		  = intval($_GET['type']);
		if($id>0){
			$gallery  = M('gallery');
			$file_url = $gallery->where('id='.$id.' and relation_type=11')->getField('file_url');            
			$this->id = $id;
			if($file_url){
				startTrans();
				$this->track_quantity = $this->insertTrack($file_url,$is_dhl);
				$list	  = $gallery->where('id='.$id.' and relation_type=11')->setField(array('is_first'=>1,'upload_date'=>date("Y-m-d H:i:s")));
				if($list==false) {
					rollback();
					$this->error(L('data_right_del_error'));
				}
				commit();
			}else{
				$this->error(L('data_right_del_error'));
			}	
		}else{
			$this->error(L('_ERROR_'));
		}
	}

	public function _after_import(){
		$result			   =  array();
		$result['status']  = 0;
		$result['info']    = '成功导入'.$this->track_quantity.'个订单';
		$result['data']    = '';
    	echo json_encode($result);
		exit; 	
    }

	public function insertTrack($file_url,$is_dhl){
		$path			   = getUploadPath(11);
		$handle			   = fopen($path.$file_url, 'r'); 
		$sign			   = in_array($is_dhl, array(1,4,5)) ? "\r\n" : ",";				//分割符
        if (strtolower(substr($file_url, -3)) == 'txt') {
            $path = getUploadPath(11);
            $fp_in = file_get_contents($path . $file_url, "r");
            $result = preg_split('/\n/', $fp_in);
        } else {
            $result = $this->input_csv($handle, $sign);
        }
        $sale_order		   = M('sale_order');
		$track_quantity	   = 0;
		if($is_dhl==1){
			$result_count = count($result);
			if(is_array($result)&&$result_count>=3){  
				for($i = 0; $i < $result_count; $i += 3){
					$value	       = iconv("iso-8859-1",'utf-8',$result[$i]);
					$track_no	   = '';
					$array_info    = explode(';',$value);
					$count		   = count($array_info);
					$track         = trim($array_info[1]);          //追踪单号
					if($count>=37){
						if(preg_match("/^[A-Za-z0-9\-]{2,255}$/i", $track)){
							$track_no  = $track; 
						}
						$sale_order_no = trim($array_info[22]);     //处理单号
						if($sale_order_no){ 							
							if (is_numeric($sale_order_no)) {//added by jp 20140730
								$sale_order_no	= 'DD' . $sale_order_no;
							}
							$rs		   = $sale_order->where('sale_order_no=\''.$sale_order_no.'\' ')->setField('track_no',$track_no);
							if($rs > 0) {
								$track_quantity++;
							}
						}
					}else{
                        $array_info    = array_merge($array_info,explode(';', iconv("iso-8859-1",'utf-8',$result[$i+1])));
                        $i++;
                        if(preg_match("/^[A-Za-z0-9\-]{2,255}$/i", $track)){
							$track_no  = $track; 
						}
                        //字段被分割所以合并后取23
						$sale_order_no = trim($array_info[23]);     //处理单号
						if($sale_order_no){ 							
							if (is_numeric($sale_order_no)) {//added by jp 20140730
								$sale_order_no	= 'DD' . $sale_order_no;
							}
							$rs		   = $sale_order->where('sale_order_no=\''.$sale_order_no.'\' ')->setField('track_no',$track_no);
							if($rs > 0) {
								$track_quantity++;
							}
						}
                    }
				}
			}
        }else if($is_dhl==2){
            foreach ((array)$result as $key=>$value){
				$value         = iconv("iso-8859-1",'utf-8',$value);
				$array_info    = explode(';',$value);
					$track         = trim($array_info[0]);         //追踪单号
					if(preg_match("/^[A-Za-z0-9\-]{2,255}$/i", $track)){
						$track_no	= $track; 
					} else {
						$track_no	= '';
					}
					$sale_order_no = trim($array_info[0]);     //处理单号
					if($sale_order_no && preg_match('/DD/', $sale_order_no)){ 				
						$rs		   = $sale_order->where('sale_order_no=\''.$sale_order_no.'\' ')->setField('track_no',$track_no);
						if($rs > 0) {
							$track_quantity++;
						}
					}
			}
        }else if($is_dhl ==3){
            foreach ((array) $result as $key => $value) {
                $value = iconv("iso-8859-1", 'utf-8', $value);
                $array_info = explode(';', $value);
                $count = count($array_info);
                if ($count >= 2) {
                    $track = trim($array_info[2]);         //追踪单号
                    if (preg_match("/^[A-Za-z0-9\-]{2,255}$/i", $track)) {
                        $track_no = $track;
                    } else {
                        $track_no = '';
                    }
                    $sale_order_no = trim($array_info[1]);     //处理单号
                    if ($sale_order_no && preg_match('/^(DD)?\d+$/', $sale_order_no)) {
                        if (is_numeric($sale_order_no)) {//added by jp 20140730
                            $sale_order_no = 'DD' . $sale_order_no;
                        }
                        $rs = $sale_order->where('sale_order_no=\'' . $sale_order_no . '\' ')->setField('track_no', $track_no);
                        if ($rs > 0) {
                            $track_quantity++;
                        }
                    }
                }
            }
        }else if($is_dhl ==4){
             foreach ((array) $result as $key => $value) {
                $array_info = preg_split('/\t/', $value);
                $count = count($array_info);
                if ($count >= 2) {
                    $track_no = trim($array_info[9]);         //追踪单号
                    $sale_order_no = trim($array_info[42]);     //处理单号
                    $sale_order_no  = ltrim($sale_order_no,'"');
                    if ($sale_order_no && preg_match('/^(DD)?\d+$/', $sale_order_no)) {
                        $rs = $sale_order->where('sale_order_no=\'' . $sale_order_no . '\' ')->setField('track_no', $track_no);
                        if ($rs > 0) {
                            $track_quantity++;
                        }
                    }
                }
            }
        }elseif($is_dhl ==5){
            foreach ((array) $result as $key => $value) {
                $value  = iconv("iso-8859-1", 'utf-8', $value);
                $value  = str_replace('"', '', $value) ;
                $array_info = explode(',', $value);
                if($array_info[2]=="Y"){
                    $count = count($array_info);
                    if ($count >= 2) {
                        $track = trim($array_info[0]);         //追踪单号
                        if (preg_match("/^[A-Za-z0-9\-]{2,255}$/i", $track)) {
                            $track_no = $track;
                        } else {
                            $track_no = '';
                        }
                        $sale_order_no = trim($array_info[1]);     //处理单号
                        if ($sale_order_no && preg_match('/^(DD)?\d+$/', $sale_order_no)) {
                            if (is_numeric($sale_order_no)) {//added by jp 20140730
                                $sale_order_no = 'DD' . $sale_order_no;
                            }
                            $rs = $sale_order->where('sale_order_no=\'' . $sale_order_no . '\' ')->setField('track_no', $track_no);
                            if ($rs !== false) {
                                $track_quantity++;
                            }
                        }
                    }
                }
            }
        }elseif($is_dhl == 6){
            foreach ((array) $result as $key => $value) {
                $array_info = explode(',', $value);
                $count = count($array_info);
                if ($count = 10) {
                    $track_no = trim($array_info[0]).trim($array_info[1]);         //追踪单号
                    $sale_order_no = trim($array_info[3]);     //处理单号
                    if ($sale_order_no && preg_match('/^(DD)?\d+$/', $sale_order_no)) {
                        $rs = $sale_order->where('sale_order_no=\'' . $sale_order_no . '\' ')->setField('track_no', $track_no);
                        if ($rs > 0) {
                            $track_quantity++;
                        }
                    }
                }
            }
        }else {
            foreach ((array) $result as $key => $value) {
                $value = iconv("iso-8859-1", 'utf-8', $value);
                $array_info = explode(';', $value);
                $count = count($array_info);
                if ($count >= 2) {
                    $track = trim($array_info[1]);         //追踪单号
                    if (preg_match("/^[A-Za-z0-9\-]{2,255}$/i", $track)) {
                        $track_no = $track;
                    } else {
                        $track_no = '';
                    }
                    $sale_order_no = trim($array_info[0]);     //处理单号
                    if ($sale_order_no && preg_match('/^(DD)?\d+$/', $sale_order_no)) {
                        if (is_numeric($sale_order_no)) {//added by jp 20140730
                            $sale_order_no = 'DD' . $sale_order_no;
                        }
                        $rs = $sale_order->where('sale_order_no=\'' . $sale_order_no . '\' ')->setField('track_no', $track_no);
                        if ($rs !== false) {
                            $track_quantity++;
                        }
                    }
                }
            }
        }
        return $track_quantity;
	}
	
	function input_csv($handle,$sign) {     
		$out		 = array();         
		while ($data = fgetcsv($handle, 10000, $sign)) {         
			$num	 = count($data);         
			for ($i = 0; $i < $num; $i++) {             
				$out[] = $data[$i];         
			}            
		}     
		return $out;
	}
    public function delete() {
        $this->id   = intval($_GET['id']);
        if ($this->id > 0) {  
			$model	= $this->getModel();
			if ($model->relationDelete($this->id)===false){ 
				if ($model->error_type==1){
					$this->error ( $model->getError(),$model->errorStatus);	
				}else{
					$this->error (L('_ERROR_'));
				} 
			}  
		} else {
			$this->error(L('_ERROR_ACTION_'));
		}
    }
    public function _after_delete() {
        $ajax   = array('status'=>1,'href'=>U('/TrackOrder/exportSaleOrderList'),'title'=>title('exportSaleOrderList','TrackOrder'));
    	$this->success(L('_OPERATION_SUCCESS_'),'',$ajax);
    }
}
?>