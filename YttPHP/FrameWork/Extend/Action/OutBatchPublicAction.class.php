<?php 

/**
 * 库存调整
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category   	库存调整
 * @package  	Action
 * @author    	何剑波
 * @version 	2.1,2012-07-22
*/

class OutBatchPublicAction extends RelationCommonAction {
	
	public function __construct() { 
    	parent::__construct(); 
		$userInfo	=	getUser();
		if ($userInfo['role_type']==C('WAREHOUSE_ROLE_TYPE')){//仓储
			$w_id	= intval($userInfo['company_id']);
            $is_sold    = M('warehouse')->where('id='.$w_id)->getField('is_return_sold');
            if($is_sold != C('NO_RETURN_SOLD')){
                $relation_warehouse = M('warehouse')->where('is_return_sold='.C('NO_RETURN_SOLD').' and relation_warehouse_id='.$w_id)->getField('id',true);
            }
            $relation_warehouse[]   = $w_id;
			$_POST['detail']['in']['warehouse_id'] = $relation_warehouse;
			if ($w_id > 0) {
				$this->assign("w_id", $w_id);
				$this->assign("w_name", SOnly('warehouse',$w_id, 'w_name'));		
			}				
		}
		$this->assign('sid',session_id());
		$this->assign('file_tocken',md5(time()));
	}

	public function _autoIndex($temp_file=null) { 
        if($_GET['to_create_time']){
            $_POST['main']['date']['needdate_to_create_time']   = $_GET['to_create_time'];
            $_POST['main']['query']['is_associate_with']    = $_GET['is_associate_with'];
            $_POST['pack_box']['query']['is_aliexpress']    = C('SELECT_YES');
            $_POST['main']['date_key']                      = 1;
        }
        
		$this->action_name = ACTION_NAME;
    	$model 			   = $this->getModel();
		$list			   = $model->index();
        
        //25工作日前的日期
        $before_date    = workDaysDate(time(),25);
        foreach($list['list'] as &$value){
            $out_batch_id[$value['id']] = $value['id'];
            $value['remind']    = (strtotime($value['create_time']) < strtotime($before_date)) ? 1 : 0;
        }
        if(!empty($out_batch_id)){
            $weight				= D('OutBatch')->getOutBatchWeight($out_batch_id);
			$has_cainiao_doc	= D('OutBatch')->outBatchHasCaiNiaoDoc($out_batch_id);
            foreach($list['list'] as &$val){
                $val['weight']  = $weight[$val['id']];
//                if($val['is_customs_clearance']){//清关后不可删除
                    $val['is_del']   = 0;
//                }
                if($val['is_review_weight']){//复核重量后不可编辑
                    $val['is_update']   = 0;
                }
				if (in_array($val['id'], $has_cainiao_doc)) {
					$val['is_send']   = 1;
				}
            }
        }
        
        $this->list		   = _formatList($list['list']);
		$this->displayIndex($temp_file);
	}  
    
    public function _after_add() {
        $pack_box_id    = S($_GET['record_check_token']);
        $rs['detail']   = M('pack_box')
                ->join('pb left join pack_box_detail pbd on pbd.pack_box_id=pb.id
                        left join return_sale_order_storage_detail rsd on rsd.return_sale_order_id=pbd.return_sale_order_id')
                ->where('pack_box_id in ('.  implode(',', $pack_box_id).')')
                ->field('pb.id as pack_box_id ,pb.pack_box_no as pack_box_no,count(rsd.id) as quantity')
                ->group('pb.id')
                ->select();
        $weight = D('PackBox')->getPackBoxWeight($pack_box_id);
        $number = 1;
        foreach ($rs['detail'] as &$detail){
            $detail['number']   = $number;
            $detail['weight']   = $weight[$detail['pack_box_id']];
            $detail['url']      = U('PackBox/view/','id='.$detail['pack_box_id']);
        }
        $rs = _formatListRelation($rs);
        $this->assign('rs',$rs);
        parent::_after_add();
    }
    
    public function _after_edit() {
        $this->_Member  = $_GET['review_weight'] ? 'review_weight_' : ($_GET['customs_clearance'] ? 'customs_clearance_' : ($_GET['associate_with'] ? 'associate_with_' : ''));
        parent::_after_edit();
    }
    
    public function outBatchLabel($info){
//                                width: 567pt;
//                                height: 794pt;
        $html   = '<div>
                        <style type="text/css">
                            table,th,td
                            {
                                border:1px solid #080808;
                                width: 520pt;
                                text-align: center;
                            }
                            td
                            {
                                width:10%;
                                height:50pt;
                            }
                            div
                            {
                                font-family:Arial,sans-serif;
                                float: initial;
                                color: #000;
                                font-size:11pt; 
                                font-weight:bolder;
                                line-height: 20pt;
                                margin:auto;
                                width:99%;
                            }
                            span
                            {
                                margin:40pt 120pt 40pt 40pt;
                            }
                            .foot_span
                            {
                                margin:0;
                                font-size:15pt;
                            }
                        </style>
                        <div>
                        <span style="font-weight: bolder;margin:0pt;position:relative;left:25%;font-size:20pt;">海外仓-COE香港仓大包交接单</span><br>
                        <span>交接仓库：<u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u></span><br>
                        <span>交接日期：<u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u></span>
                        <span>到仓时间：<u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u></span>
                                <table cellspacing="0" cellpadding="0">
                                <tr>
                                    <td rowspan="2">序号</td>
                                    <td colspan="4">EDAES仓填写</td>
                                    <td colspan="3">COE香港仓填写</td>
                                    <td rowspan="2">接收结果</td>
                                    <td rowspan="2">拒绝原因</td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="width:5%" >大包单号</td>
                                    <td style="width:14%">大包重量(KG)</td>
                                    <td>内件数量</td>
                                    <td style="width:14%">大包外观完好</td>
                                    <td>仓库称重(KG)</td>
                                    <td>重量差异</td>
                                </tr>';
        $number = 1;//序号
        foreach($info['detail'] as $detail){
            $html   .= '<tr>
                            <td>'.$number.'</td>
                            <td colspan="2">'.$detail['pack_box_no'].'</td>
                            <td>'.$detail['dml_weight'].'</td>
                            <td>'.$detail['dml_quantity'].'</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>';
            $number++;
        }
        for($number;$number < 11; $number++){
                        $html   .= '<tr>
                                        <td>'.$number.'</td>
                                        <td colspan="2">&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                    </tr>';
        }

        $html   .= '            <tr>
                                    <td colspan="2" bgcolor="#cccccc">送来大包总数</td>
                                    <td bgcolor="#cccccc">'.$info['detail_total']['dml_quantity'].'</td>
                                    <td bgcolor="#cccccc">送来大包总重(Kg)</td>
                                    <td bgcolor="#cccccc">'.$info['detail_total']['dml_weight'].'</td>
                                    <td>实收大包总数</td>
                                    <td>&nbsp;</td>
                                    <td colspan="2">实收大包总重(Kg)</td>
                                    <td>&nbsp;</td>
                                </tr>
                            </table>
                            <br>
                            <span class="foot_span">交货人签字确认：<u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u></span>
                            <span class="foot_span">接收人签字确认：<u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u></span>
                        </div>
                    </div>';
        return $html;
    }
    public function sendEmail($params){
         $email_info = M('out_batch')
                ->join('ob left join out_batch_detail obd on ob.id=obd.out_batch_id
                        left join pack_box pb on pb.id=obd.pack_box_id
                        left join pack_box_detail pbd on pbd.pack_box_id=obd.pack_box_id
                        left join return_sale_order rso on rso.id=pbd.return_sale_order_id
                        left join return_sale_order_detail rsod on rsod.return_sale_order_id=rso.id
                        left join product p on p.id=rsod.product_id
                        left join product_extend pe on pe.product_id=p.id')
                ->where('ob.id='.$params['id'])
                ->group('rso.id')
                ->field('ob.out_batch_no,transport_start_date,rso.return_logistics_no,rso.order_no,group_concat(distinct p.product_name) as product_name,sum(rsod.quantity) as  return_quantity,rso.totalDeclaredPrice,pb.pack_box_no,rso.id as return_sale_order_id,obd.pack_box_id as pack_box_id')
                ->select();
        foreach($email_info as $value){
            $return_id_arr[$value['return_sale_order_id']]  = $value['return_sale_order_id'];
            $pack_box_id_arr[$value['pack_box_id']]         = $value['pack_box_id'];
            $quantity[$value['return_sale_order_id']]       = $value['return_sale_order_id'];
            $out_batch_no									= $value['out_batch_no'];
			$transport_start_date							= $value['transport_start_date'];
        }
        
        $model				= D('PackBox');
        $return_weight      = $model->getReturnWeight($return_id_arr);
        $pack_box_weight    = $model->getPackBoxWeight($pack_box_id_arr);
        
        foreach($email_info as $val){ 
            $val['order_no']           .=' ';
            $val['product_class']       =' ';
            $val['return_weight']       = $return_weight[$val['return_sale_order_id']] / 1000;
            $val['weight']              = $pack_box_weight[$val['pack_box_id']]/1000;
            $val['quantity']            =count($quantity);
            unset($val['return_sale_order_id'],$val['pack_box_id']);
            $data[]=$val;           
        }
        $head = array(array("out_batch_no"=>L('out_batch_no'), "transport_start_date"=>L('out_stock'),"return_logistics_no"=> L('return_logistics_no'),
         "order_no"=>L('trading_no'), "product_name"=>L('product_name'),"product_class"=>L('product_class'),"return_quantity"=>L('number_return_logistics'),
         "totalDeclaredPrice"=>L('order_return_amount'), "pack_box_no"=>L('bag_no'),"return_weight"=>L('package_weight'),
         "weight"=>L('bag_weight'), "quantity"=>L('bag_quantity')
        ));        
        $fileName = 'Cainiao-EDA-'.date('ymd', strtotime($transport_start_date)).'-'.$out_batch_no.'.xls';  
        $info=array_merge($head,$data);
        $need_array=array("out_batch_no","transport_start_date","return_logistics_no","order_no","product_name","product_class","return_quantity","totalDeclaredPrice",
        "return_weight","pack_box_no", "weight",  "quantity");
        $relation_type	= 31;
        $path			= getUploadPath($relation_type).$fileName;
        $tran_array		= array();
        tranXls($info,$need_array,$tran_array,$path,$head);

        M('gallery')->where(array('relation_id' => $params['id'], 'relation_type' => $relation_type))->delete();
        $keep_array			= array(
                                'file_url'		=> $path,
                                'relation_id'	=> $params['id'],
                                'relation_type'	=> $relation_type,
                                'cpation_name'	=> $fileName,
                                'tocken'		=> '',
                                'add_user'	    => getUser('id'),
                                'insert_date'   => date('Y-m-d'),
                    );
	    M('gallery')->add($keep_array); 
        return $path;
        
    }
    public function sentEmail($module_name, $info){
        $email_info = M('out_batch')
                ->join('ob left join out_batch_detail obd on ob.id=obd.out_batch_id
                        left join pack_box pb on pb.id=obd.pack_box_id
                        left join pack_box_detail pbd on pbd.pack_box_id=obd.pack_box_id
                        left join return_sale_order rso on rso.id=pbd.return_sale_order_id
                        left join return_sale_order_detail rsod on rsod.return_sale_order_id=rso.id
                        left join product p on p.id=rsod.product_id
                        left join product_extend pe on pe.product_id=p.id')
                ->where('ob.id='.$info['object_id'])
                ->group('rso.id')
                ->field('ob.out_batch_no,transport_start_date,rso.return_logistics_no,rso.order_no,group_concat(distinct p.product_name) as product_name,sum(rsod.quantity) as  return_quantity,rso.totalDeclaredPrice,pb.pack_box_no,rso.id as return_sale_order_id,obd.pack_box_id as pack_box_id')
                ->select();
        foreach($email_info as $value){
            $return_id_arr[$value['return_sale_order_id']]  = $value['return_sale_order_id'];
            $pack_box_id_arr[$value['pack_box_id']]         = $value['pack_box_id'];
            $quantity[$value['return_sale_order_id']]       = $value['return_sale_order_id'];
            $out_batch_no									= $value['out_batch_no'];
			$transport_start_date							= $value['transport_start_date'];
        }
        
        $model				= D('PackBox');
        $return_weight      = $model->getReturnWeight($return_id_arr);
        $pack_box_weight    = $model->getPackBoxWeight($pack_box_id_arr);
        
        $content    = ' <style type="text/css">
                            table,tr,td
                            {
                                border:1px solid #080808;
                                width: 100%;
                                text-align: center;
                            }
                            td
                            {
                                width:8%;
                                height:50pt;
                            }
                            div
                            {
                                font-family:Arial,sans-serif;
                                float: initial;
                                color: #000;
                                font-size:11pt; 
                                font-weight:bolder;
                                line-height: 20pt;
                                margin:auto;
                                width:99%;
                            }
                        </style>
                        <div>
                        <p>'.L('to_email_name').'</p>
                        <p>'.L('email_content_one').'</p>
                            <table cellspacing="0" cellpadding="0">
                                <tbody>
                                    <tr>					
                                        <td>'.L('out_batch_no').'</td>
                                        <td>'.L('out_stock').'</td>
                                        <td>'.L('return_logistics_no').'</td>
                                        <td>'.L('trading_no').'</td>
                                        <td>'.L('product_name').'</td>
                                        <td>'.L('product_class').'</td>
                                        <td>'.L('number_return_logistics').'</td>
                                        <td>'.L('order_return_amount').'</td>
                                        <td>'.L('package_weight').'</td>
                                        <td>'.L('bag_no').'</td>
                                        <td>'.L('bag_weight').'</td>
                                        <td>'.L('bag_quantity').'</td>
                                    </tr>';
        
        foreach($email_info as &$val){
            $val['return_weight']   = $return_weight[$val['return_sale_order_id']] / 1000;
            $val['weight']          = $pack_box_weight[$val['pack_box_id']] / 1000;
            $val['quantity']        = $quantity[$val['return_sale_order_id']];
            
            $content				.= '<tr>
										<td>'.$val['out_batch_no'].'</td>
										<td>'.$val['transport_start_date'].'</td>
										<td>'.$val['return_logistics_no'].'</td>
										<td>'.$val['order_no'].'</td>
										<td>'.$val['product_name'].'</td>
										<td></td>
										<td>'.$val['return_quantity'].'</td>
										<td>'.$val['totalDeclaredPrice'].'</td>
										<td>'.$val['return_weight'].'</td>
										<td>'.$val['pack_box_no'].'</td>
										<td>'.$val['weight'].'</td>
										<td>'.count($quantity).'</td>
									</tr>';
        }
        $content    .= '         </tbody>
                            </table>
                        <p>'.L('email_content_two').'</p>    
                        </div>';
		
        $relation_type=31;
        $path=M('gallery')->where('relation_id='.$info['object_id'] .'  and relation_type='.$relation_type)->getField('file_url');
		if(empty($path) || !file_exists($path)){
            $params         =   array();
            $params['id']   =   $info['object_id'];
            $path           =   $this->sendEmail($params);
        }
		
       if(isset($info['email_address'])){
            $coe_email =$info['email_address'];
        }else{
            if(!is_array(C('COE_EMAIL'))){
               $coe_email  = explode(',', C('COE_EMAIL'));
            }
        }
        $result = array();      
        foreach($coe_email as $to_email){
            $result[$to_email] = postEmail($to_email,'Cainiao-EDA-'.date('ymd', strtotime($transport_start_date)).'-'.$out_batch_no, $content,$path);
        }
		return $result;
    }  
}
?>