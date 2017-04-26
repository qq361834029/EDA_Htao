<?php 

/**
 * 退换货管理
 * @copyright   Copyright (c) 2006 - 2013 TOP UNION 展联软件友拓通
 * @category    基本信息
 * @package		Model
 * @author		何剑波
 * @version  2.1,2012-07-22
 */

class QuestionOrderPublicModel extends RelationCommonModel {
	/// 定义真实表名
	protected $tableName = 'question_order';
	/// 定义表关联
	protected $_link	 = array();
	/// 自动验证设置
	protected $_validate	 =	 array(
			array("warehouse_id",'pst_integer','require', self::EXISTS_VAILIDATE),
			array("sale_order_id",'require','require',self::EXISTS_VAILIDATE),
			array("sale_order_no",'require','require',self::EXISTS_VAILIDATE),
			array("question_order_state",'pst_integer','require', self::EXISTS_VAILIDATE),
			array("add_order_date",'require','require', self::EXISTS_VAILIDATE),
            array('','validQuestionReason','require', self::MUST_VALIDATE,'callbacks'),
            array('','validProcessMode','require', self::MUST_VALIDATE,'callbacks'),
            array('factory_id','require','require', self::EXISTS_VAILIDATE),
	);
    
    /// 自动填充
	protected $_auto = array(
		array("create_time", "date", 1, "function", "Y-m-d H:i:s"), // 创建时间
		array("update_time", "date", 3, "function", "Y-m-d H:i:s"), // 更新时间
	);
    //问题订单原因是否为空验证
	public function validQuestionReason($data){
        if(getUser('role_type') != C('WAREHOUSE_ROLE_TYPE')){
            $question_reason    = array(
                array("question_reason", 'require', "require", 0),
            );
        }
        return $this->_validSubmit($data, $question_reason);
    }
    //问题处理方式是否为空验证
	public function validProcessMode($data){
        if(in_array($data['question_order_state'], explode(',', C('PROCESS_MODE_REQUIRE')))){
            $process_mode       = array(
                array("process_mode", 'require', "require", 0),
            );
            if($data['process_mode'] == C('UPLOADED_PROOF')){
                $process_mode[]     = array("proof_delivery_fee",'zmoney',"money_error", 0);
            }
            if($data['process_mode'] == C('HAS_COMPENSATION')){
                $process_mode[]     = array("compensation_fee",'money',"money_error", 0);
                $process_mode[]     = array("compensation_date",'require',"require", 0);
            }
            //处理完成时间    add by lxt 2015.06.09
            if ($data['process_mode']==C('FINISH')){
                $process_mode[]     = array("finish_date","require","require",1);
            }
            //卖家账号如果选择提供买家电话，买家电话必填     add by lxt 2015.06.11
            if ($data['process_mode']==C('PROVIDE_CLIENT_MOBILE') && getUser('role_type')==C('SELLER_ROLE_TYPE')){
                $process_mode[]     =   array("mobile",'require',"require",1);
            }
        }
        return $this->_validSubmit($data, $process_mode);
    }
    

    public function setPost(){ 
        //问题订单状态不是已完成，清空完成日期字段      add by lxt 2015.06.05
        if ($_POST['process_mode']!=C('FINISH')){
            $_POST['finish_date'] = '';
        }
	}

	/// 查看
	public function view(){
		return $this->getInfoQuestionOrder($this->id);
	}
	/// 编辑
	public function edit(){
		return $this->getInfoQuestionOrder($this->id);
	}
	
	public function getInfoQuestionOrder($id){
		$id		= (int)$id;
		$where	= 'id=' . $id . getBelongsWhere().getWarehouseWhere();
        //主表信息
        $sale_order_id  = M('question_order')->where('id='.$id)->getField('sale_order_id');
		$rs		= $this->where($where)->find();
		if (false === $rs || $rs == null) { /// 记录不存在或没权限查看该记录
			halt(L('data_right_error'));
		}
        //查询明细
		$sql = ' select a.*
				from sale_order_detail as a
				where a.sale_order_id='.$sale_order_id.'
				group by a.id order by a.id';  
		$rs['detail'] = $this->db->query($sql); 
        //客户信息
		$client				= M('Client')->field('comp_name as client_name,comp_no as client_no,email as comp_email')->find($rs['client_id']);
		if($client){
			$rs				= array_merge($rs,$client);
		}
        //合并销售单主表信息
        $sale_order		   = M('sale_order');
        $sale_order_data   = $sale_order->field('warehouse_id,client_id,order_date,order_no,track_no,comments')->where('id='.$rs['sale_order_id'])->find();  
        if (!isset($sale_order_data) || empty($sale_order_data)) { /// 记录不存在或没权限查看该记录
            halt(L('data_right_error'));
        }
        $rs					= array_merge($rs,$sale_order_data);
		$rs['ship_id']		= $rs['express_id'];	//缓存派送方式命名有误，转换
        //获取地址信息
		$addition			= M('sale_order_addition')->where('sale_order_id='.$sale_order_id)->find();
		$rs['addition']		= _formatArray($addition);
		$rs					= _formatListRelation($rs);
		$rs['express_name'] = $rs['ship_name'];//缓存派送方式命名有误，转换
        //图片附件
		$model              = D('Gallery'); 
		$rs['question_pics']    = $model->getAry($id,C('QUESTION_IMAGE'));
        //签收证明附件
		$file_url = D('Gallery')->getAry($id,C('TRANSACTION_PROOF')); 
		$path	= getUploadPath(C('TRANSACTION_PROOF'));
        foreach($file_url as &$val){
            $val['file_url']      = $path . $val['file_url'];
        }
        $rs['transaction_proof']  = $file_url;
        //上传发票附件
		$file_url = D('Gallery')->getAry($id,C('INVOICE_FILE')); 
		$path	= getUploadPath(C('INVOICE_FILE'));
        foreach($file_url as &$val){
            $val['file_url']      = $path . $val['file_url'];
        }
        $rs['invoice_file']  = $file_url;
        $rs['currency_no']  = SOnly('currency', $rs['w_currency_id'],'currency_no');
		return $rs;
	}
	
	public function indexSql(){ 
		$order					= 'update_time desc';
        $exists_detail_sql		= 'select 1 from sale_order_detail inner join product on product.id=sale_order_detail.product_id where sale_order_detail.sale_order_id=question_order.sale_order_id and '.getWhere($_POST['sale_order_detail']).' and '.getWhere($_POST['product']);
        $exists_sale_sql		= 'select 1 from sale_order where sale_order.id=question_order.sale_order_id and '.getWhere($_POST['sale_order']);
		$exists_client_sql		= 'select 1 from client where client.id=question_order.client_id and '.getWhere($_POST['client']);
        $exists_addition_sql	= 'select 1 from sale_order_addition where sale_order_addition.sale_order_id=question_order.sale_order_id and '.getWhere($_POST['sale_order_addition']);
        $exists_user_sql        = 'select 1 from user where user.id=question_order.add_user and '.  getWhere($_POST['user']);
        $where  = getWhere($_POST['main']).getBelongsWhere().getWarehouseWhere();
        //分页
        $count					= $this
								->exists($exists_detail_sql, ($_POST['sale_order_detail'] || $_POST['product']))
								->exists($exists_sale_sql, $_POST['sale_order'])
								->exists($exists_client_sql, $_POST['client'])
								->exists($exists_user_sql, $_POST['user'])
								->where($where)
								->order($order)
								->count();
		$this->setPage($count);
        //当前页显示ID
        $ids            = $this->field('id')
                        ->exists($exists_detail_sql, ($_POST['sale_order_detail'] || $_POST['product']))
                        ->exists($exists_sale_sql, $_POST['sale_order'])
                        ->exists($exists_client_sql, $_POST['client'])
                        ->exists($exists_user_sql, $_POST['user'])
                        ->where($where)
                        ->order($order)
                        ->page()
                        ->selectIds();
        //明细
        $info['from']	= ' question_order a 
							left join sale_order_detail b on(a.sale_order_id=b.sale_order_id) 
							left join sale_order c on(a.sale_order_id=c.id) 
							left join sale_order_addition f on(f.sale_order_id=a.id)
                            left join express e on c.express_id=e.id
                            left join company ec on e.company_id=ec.id
							left join client d on d.id=a.client_id';
		$info['where']	= ' where a.id in '.$ids;
		$info['group']	= ' group by a.id order by a.update_time desc';
		$info['field']	= ' a.finish_date,a.client_id,d.comp_name as client_name,d.comp_no as client_no,d.email as comp_email,a.order_no,c.order_type,f.consignee,
							group_concat(distinct b.product_id) as p_ids,
							a.mobile as mobile,a.id,a.question_order_no,a.factory_id,a.sale_order_id,a.sale_order_no,a.question_order_state,
							a.add_order_date,if(a.add_user=' . getUser('id') . ',1,0) as is_self,a.question_reason,
							count(distinct b.product_id) as product_qn,a.add_user,a.process_mode,proof_delivery_fee,compensation_fee,a.warehouse_id,e.express_name,c.track_no,ec.web_url';
		return  'select '.$info['field'].' from '.$info['from'].$info['where'].$info['group']; 
	}
}