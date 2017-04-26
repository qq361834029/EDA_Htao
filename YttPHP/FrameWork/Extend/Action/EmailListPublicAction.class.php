<?php 
/**
 * 邮件列表
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category   	系统信息
 * @package  	Action
 * @author    	何剑波
 * @version 	2.1,2013-08-06
 */

class EmailListPublicAction extends BasicCommonAction {
	  
	public 	$_sortBy 			= 'id';  ///默认排序字段  
	 
	///邮件列表
	public function index() {	
		$this->basicList('and is_sent=2'); 
		$this->displayIndex();
	}	
	
	///未发送邮件列表
	public function unsentEmailList() {	 
		$this->basicList('and is_sent=1');  
		///display
		$this->displayIndex(__FUNCTION__);
	}	
	
	///取消邮件列表
	public function deleteEmailList() {	 
		$this->basicList('and is_sent=3');   
		///display
		$this->displayIndex(__FUNCTION__);
	}	
	
	
	public function basicList($where){
		///获取当前Action名称
	 	$name = $this->getActionName(); 
 		///获取当前模型
		$model 	= D($name);    
		///条件
		$opert	=	array(
		'field'=>'*,case email_type
     	when 1 then \'Orders\'
        when 2 then \'LoadContainer\'
        when 3 then \'Instock\'
        when 4 then \'SaleOrder\'
        when 5 then \'Delivery\'
        when 6 then \'Storage\'
		when 7 then \'CaiNiao\'
		else 8 end as object_type',
        'where'=>_search($this->_default_where,$this->_default_post).' and to_hide=1 '.$where);
		///格式化+获取列表信息  
		$list		= _list($model,$opert);  
		$linkModel	= D('AbsStat');
		$client		= S('client');
		$factory	= S('factory');
		foreach ((array)$list as $key=>$row) {
			$list[$key]		= $linkModel->objectTypeCommentSubsidiary($row);
			$comp_array		= explode(',',$row['comp_id']);
			if(in_array($row['object_type'],array(4,5,6))){
				foreach ($comp_array as $comp_key=>$comp_row) {
					$list[$key]['comp_name'][]	= $client[$comp_row]['client_name'];
				}
			}else{
				foreach ($comp_array as $comp_key=>$comp_row) {
					$list[$key]['comp_name'][]	= $factory[$comp_row]['factory_name'];
				}
			}
			$list[$key]['comp_name'] = implode('<br>',$list[$key]['comp_name']);
		}
		$list	=	_formatList($list);
		///assign
		$this->assign('list',$list);
	}
	
	///更新
	public function edit() {
		///获取当前Action名称
	 	$name = $this->getActionName();
 		///获取当前模型
		$model 	= D($name);   
		///当前主键
		$pk		=	$model->getPk();
		$id 	= 	intval($_REQUEST[$pk]);
		
		///给所有权限
		if ($_SESSION[C('ADMIN_AUTH_KEY')]==false){
				$_SESSION[C('ADMIN_AUTH_KEY')]			=	true;
				$a	=	true;
		} 
		if ($id>0) {  ///发单个
			$info	=	$model->find($id); 
			$this->sentEmailArray($info,$id,$model); 
			///回退权限
			if ($a){
				$_SESSION[C('ADMIN_AUTH_KEY')]			=	false;
			} 
		}else{ 
			///用于群发
			$batch	= array();
			$list	= $model->where('is_sent=1 and to_hide=1')->select();
			foreach ((array)$list as $row) {
				$modelArray		= array_flip($model->email_type_array);
				$module_name	= $modelArray[$row['email_type']];
				if ($module_name) {
					switch ($module_name) {
						case 'StorageWarn':
						case 'CaiNiaoRequestAbnormal':
							$batch[$module_name][$row['id']]	= $row;
							break;
						default :
							$this->sentEmailArray($row,$row['id'], $model, $module_name);
							break;
					}
				}
			}
			if (!empty($batch)) {
				foreach ($batch as $module_name => $list) {
					if (method_exists($this, $module_name)) {
						$this->$module_name($list, $model);
					}
				}
			}
			///回退权限
			if ($a){
				$_SESSION[C('ADMIN_AUTH_KEY')]			=	false;
			} 
			echo 'sent OK';
			exit;
			//$this->error(L('_ERROR_'));
		}  
	}
	
	public function sentEmailArray($info,$id,&$model, $module_name){
		$_GET['id']	=	$info['object_id'];
		$flow		=	A($module_name);
		$flow->autoLang($module_name);
		$flow->setName($module_name);
		$flow->sentEmail($module_name, $info);
		$data		= array('is_sent'=>2,'send_time'=>date("Y-m-d H:m:s"));
		$list		= $model->where('id='.$id)->setField($data);
	}

	public function CaiNiaoRequestAbnormal($list, &$model){
		$email_list	= C('CAINIAO_REQUEST_ABNORMAL_EMAIL');
		if (empty($list) || empty($email_list)){
			return false;
		}
		$ids		= array();
		$log_ids	= array();
		foreach ($list as $row) {
			$ids[$row['id']]			= $row['id'];
			$log_ids[$row['object_id']]	= $row['object_id'];
		}
		$log_list	= M('CaiNiaoLog')->where(array('id' => array('in', $log_ids)))->getField('id, logisticsOrderCode, module, action, msg_type');
		$table		= '<table>';
		$table		.= '<tr><th width=120>Log ID</th><th width=80>Factory ID</th><th width=200>Return Logistics No.</th><th width=150>Module</th><th width=100>Action</th><th width=200>Msg Type</th></tr>';
		foreach ($list as $row) {
			$log	= $log_list[$row['object_id']];
			$table	.= '<tr><td>' . $row['object_id'] . '</td><td>' . $row['comp_id'] . '</td><td>' . $log['logisticsOrderCode'] . '</td><td>' . $log['module'] . '</td><td>' . $log['action'] . '</td><td>' . $log['msg_type'] . '</td></tr>';
		}
		$table		.= '</table>';
		$html		= '<html xmlns="http:///www.w3.org/1999/xhtml">
						<head>
							<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
							<title>'.C('email_title').'</title>
							<style>
								table, th, td{
									border: 1px solid #000000;
									text-align: center;
								}
							</style>
						</head>
						<body>
						' . $table . '
						</body>
					</html>';
		if (postEmail($email_list, '易达请求菜鸟异常提醒', $html)) {
			$where	= array('id' => array('in', $ids));
			$data	= array('is_sent'=>2,'send_time'=>date("Y-m-d H:m:s"));
			$model->where($where)->setField($data);
			$return	= true;
		} else {
			$return		= false;
		}
		return $return;
	}

		public function sentStorageWarn(){
        $sql    = 'SELECT tt.*,c.email,c.warn_email,c.comp_name,e.id as email_id FROM (SELECT * , sum( onroad_qn ) AS onroad_quantity, sum( sale_qn ) AS sale_quantity, sum( real_qn ) AS real_quantity, sum( real_qn ) - sum( sale_qn ) AS reserve_quantity
			FROM (
			SELECT p . * , b.warehouse_id, a.product_id, a.quantity AS onroad_qn, 0 AS sale_qn, 0 AS real_qn, 0 AS reserve_qn
			FROM instock_detail a
			LEFT JOIN instock b ON b.id = a.instock_id
			LEFT JOIN product p ON p.id = a.product_id
			WHERE 1
			AND b.instock_type >' . C('CFG_INSTOCK_TYPE_UNEDIT') . '
			AND a.in_quantity <=0
			UNION ALL SELECT p . * , a.warehouse_id, a.product_id, 0 AS onroad_qn, a.quantity AS sale_qn, 0 AS real_qn, 0 AS reserve_qn
			FROM sale_storage a
			LEFT JOIN product p ON p.id = a.product_id
			WHERE 1
			UNION ALL SELECT p . * , a.warehouse_id, a.product_id, 0 AS onroad_qn, 0 AS sale_qn, a.quantity AS real_qn, 0 AS reserve_qn
			FROM storage a
			LEFT JOIN product p ON p.id = a.product_id
			WHERE 1
			)as tmp
			GROUP BY product_id,warehouse_id) as tt
            RIGHT JOIN email_list e on tt.id=e.object_id and tt.warehouse_id=e.warehouse_id
            LEFT JOIN company c on tt.factory_id =c.id
            WHERE e.is_sent=1 ORDER BY factory_id';
        $rs	= _formatList(M()->query($sql));
        $content_head    =' <table id="index" class="list" border="1">
            <thead>
                <tr>
                    <th>'.L('warehouse').'</th>
                    <th>'.L('product_id').'</th>
                    <th>'.L('product_no').'</th>
                    <th>'.L('product_name').'</th>
                    <th>'.L('real_storage').'</th>
                    <th>'.L('sale_storage').'</th>
                    <th>'.L('onroad_storage').'</th>
                    <th>'.L('storage_remind').'</th>
                </tr>
            </thead>
            <tbody>';
        $content_foot   ='</tbody>
        </table>';
        foreach($rs['list'] as $key=>$val){            
            if($key == 0 || $rs['list'][$key]['factory_id'] != $rs['list'][$key-1]['factory_id']){
                if(empty($val['warn_email'])){                    
                    $send_email[$val['factory_id']]['toEmail']    = $val['email'];
                }  else {                             
                    $send_email[$val['factory_id']]['toEmail']    = $val['warn_email'];
                }
                $send_email[$val['factory_id']]['email_id']   = $val['email_id'];
                $send_email[$val['factory_id']]['content']    = '<tr>		   
                    <td>'.SOnly('warehouse',$val['warehouse_id'],'w_name').'</td>
                    <td>'.$val['id'].'</td>
                    <td>'.$val['product_no'].'</td>
                    <td>'.$val['product_name'].'</td>
                    <td>'.$val['real_quantity'].'</td>
                    <td>'.$val['sale_quantity'].'</td>
                    <td>'.$val['onroad_quantity'].'</td>
                    <td>'.$val['warning_quantity'].'</td>
		</tr>';
            }else{
                $send_email[$val['factory_id']]['content']    .= '<tr>		   
                    <td>'.SOnly('warehouse',$val['warehouse_id'],'w_name').'</td>
                    <td>'.$val['id'].'</td>
                    <td>'.$val['product_no'].'</td>
                    <td>'.$val['product_name'].'</td>
                    <td>'.$val['real_quantity'].'</td>
                    <td>'.$val['sale_quantity'].'</td>
                    <td>'.$val['onroad_quantity'].'</td>
                    <td>'.$val['warning_quantity'].'</td>
		</tr>';                            
                $send_email[$val['factory_id']]['email_id']   .= ','.$val['email_id'];
            }
        }     
        foreach ($send_email as $val){
            $toEmail    = $val['toEmail'];
            $email_id   = $val['email_id'];
            $content    = $val['content'];
            $title      = '';
            $content    = $content_head.$content.$content_foot;
            if (postEmail($toEmail, $title, $content)) {
				$data		= array('is_sent'=>2,'send_time'=>date("Y-m-d H:m:s"));
                M('email_list')->where('id in (' . $email_id . ')')->setField($data);
            }
        }
    }
    
    public function _after_edit(){
    	$this->success(L('_OPERATION_SUCCESS_')); 	
    } 
    
	 ///删除
    public function delete(){  
	    	///获取当前Action名称
		 	$name = $this->getActionName();
	 		///获取当前模型
			$model 	= D($name);   
			///当前主键
			$pk		=	$model->getPk ();
			$id 	= 	intval($_REQUEST[$pk]);
			if ($id>0) {  
				$condition 	= $pk.'='.$id; 
				$today 	= date("Y-m-d H:m:s");                           /// 20010310 
				$data 	= array('is_sent'=>3,'delete_time'=>$today);   
				$list	= $model->where($condition)->setField($data);   
				///如果删除操作失败提示错误
				if ($list==false) {
					$this->error(L('data_right_del_error'));
				}
			}else{
				$this->error(L('_ERROR_'));
			}  
    }   
      
}