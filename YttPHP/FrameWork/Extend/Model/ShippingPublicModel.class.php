<?php

/**
 * 派送方式管理
 * @copyright   Copyright (c) 2006 - 2013 TOP UNION 展联软件友拓通
 * @category   	派送管理
 * @package  	Model
 * @author    	jph
 * @version 	2.1,2014-03-01
*/

class ShippingPublicModel extends RelationCommonModel {
	
	/// 定义真实表名
	protected $tableName = 'express';
	
	/// 定义表关联
	protected $_link	 = array('detail' => 
									array(
										'mapping_type'	=> HAS_MANY,
										'foreign_key' 	=> 'express_id',
										'class_name'	=> 'ExpressDetail',
                                        '_link'			=> array(
                                                            'post_section' => array(
                                                                        'foreign_field' => 'relation_no',
                                                                        'foreign_key' 	=> 'express_detail_id',
                                                                   ),
                                                            'country' => array(
                                                                        'foreign_field' => 'relation_no',
                                                                        'foreign_key' 	=> 'express_detail_id',
                                                                   )
                                        ),
									),
                                'post_section' => array(
                                        'mapping_type'	=> HAS_MANY,
                                        'foreign_key' 	=> 'express_id',
                                        'class_name'	=> 'ExpressPost',
                                    ),
                                'country' => array(
                                        'mapping_type'	=> HAS_MANY,
                                        'foreign_key' 	=> 'express_id',
                                        'class_name'	=> 'ExpressCountry',
                                    ),
								);	
	/// 自动验证设置
	protected $_validate	 =	 array(
			array("express_no",'require','require',1),
			array("express_no",'is_no',"valid_error",1), 
			array("express_no",'','unique',1,'unique'),
			array("express_name",'require','require',1),
			array("express_name",'',"unique",1,'unique'),//验证唯一  
			array("shipping_type",'require','require',1),
			array("warehouse_id",'require','require',1),
			array("express_date",'require','require',1),
			array("company_id",'require','require',1),		
			array("",'_validDetail','require',1,'validDetail'),
			array("",'validDetailLimit','',1,'callbacks'),
		);
 
	/// 验证表单明细
	protected $_validDetail	 =	 array(
			array("area",'require','require',1),
//			array("country_id",'require','require',1),
//			array("post_begin",'zip','valid_zip',2),//起始邮编
//			array("post_end",'zip','valid_zip',2),//结束邮编
			array("weight_begin",'require','require',1),//起始重量
			array("weight_begin",'double','double',1),//起始重量
			array("weight_end",'require','require',1),//结束重量
			array("weight_end",'double','double',1),//结束重量
			array('weight_end','weight_begin','weight_limit',1,'gt'), 
			array("cube_high",'require','require',1),
			array("cube_high",'double','double',1),
			array("cube_wide",'require','require',1),
			array("cube_wide",'double','double',1),
			array("cube_long",'require','require',1),	
			array("cube_long",'double','double',1),
			array("price",'require','require',1),
			array("price",'double','double',1),
			array("cost",'require','require',1),
			array("cost",'double','double',1),		
			array("step_price",'double','double',2),
			array("registration_fee",'double','double',2),
			array("registration_cost",'double','double',2),
			array("return_fee",'require',"require",1), 
			array("return_fee",'ymoney',"money_error",1),
	);		

    /// 自动填充
	protected $_auto = array(
		array("create_time", "date", 1, "function", "Y-m-d H:i:s"),
		array("update_time", "date", 2, "function", "Y-m-d H:i:s"),					
	);	
	
	
	/**
	 * 1：验证重量期间必填，2：区域不可重复
	 *
	 * @author jph 20140301
	 * @param array $data = $_POST
	 */
	public function validDetailLimit($data){		
		$area  = array();
		$check = array('area');
		foreach ((array)$data['detail'] as $key=>$value){ //循环验证明细  
			if (!empty($value['area'])){ 
				if (empty($value['weight_begin']) && empty($value['weight_end'])) {
					$error['name']	= 'detail[' . $key . '][weight_begin]';
					$error['value']	= L('require');
					$this->error[]	= $error;		
					$error['name']	= 'detail[' . $key . '][weight_end]';
					$error['value']	= L('require');
					$this->error[]	= $error;						
				}
				$real_key	=	'';	
				foreach ($check as $k => $v){ //循环验证明细  
					if (isset($value[$v])){
						$real_key  .=	'_'.strtolower($value[$v]);
					} 
				} 
				if (isset($area[$real_key])){
					$error['name']	= 'detail[' . $key . '][area]';
					$error['value']	= L('unique');
					$this->error[]	= $error;				
					continue;
				}
				$area[$real_key] = 2;
			}
		}   		
	}		

	//重组明细
	public function _beforeModel($info){
		$contrast = $ids = $insert = array();
		if (ACTION_NAME == 'update') {
//			$id_array		= array();
			$express_detail = M('express_detail');
			$detail	        = $express_detail->join('ed left join express_country ec on ed.id=ec.express_id')->field('ed.id,ed.area,ed.express_id,ec.country_id')->where('ed.express_id='.$info['id'])->select(); 
			foreach((array)$detail as $k => $v){
//				$con_key	= $v['country_id'].'_'.$v['area'];
				$con_key	= $v['area'];
				$contrast[$con_key]	= $v['id'];
			} 
		}
		foreach ((array)$info['detail'] as $value) {  
			if (!empty($value['area'])){
//				$countrys = explode(',', $value['country_id']);
				$ids	  = explode(',', $value['id']);
				foreach($countrys as $country_id){
//					$value['id']         = '';
					if (ACTION_NAME == 'update') {
//						$tmp_key		 = $country_id.'_'.$value['ori_area'];
						$tmp_key		 = $value['ori_area'];
						if(array_key_exists($tmp_key, $contrast)){
//							$value['id'] = $contrast[$tmp_key];
							$id_array[]	 = $contrast[$tmp_key];
						}
					}
//					$value['country_id'] = $country_id;
//					$insert['detail'][]  = $value;  
				}
				//订单使用派送，已不可删除
				if (ACTION_NAME == 'update') {
					$diff					 = array_diff($ids,$id_array);
					is_array($diff)&&$diff&&$this->checkSaleOrderExist($diff);
				} 
			}
		}   
//		$this->data['detail'] = $insert['detail']; 
		return true;
	}
			
	public function checkSaleOrderExist($id){
		$id_string = implode(',', $id); 
		if($id_string){
			$count = M('SaleOrder')->where('express_detail_id in ('.$id_string.')')->count(); 
			if ($count>0) {
				throw_json(L('record_is_used_cant_del'));
			}
		}
	}	

	/// 取信息
	public function getInfo($id){
		$rs		= $this->find($id);  
		if (false === $rs || $rs == null) { // 记录不存在或没权限查看该记录
			halt(L('data_right_error'));
		} 
        $rs['currency_no']  = SOnly('currency', SOnly('warehouse', $rs['warehouse_id'],'w_currency_id'),'currency_no');
		$details		= M('ExpressDetail')->field('*,cube_high*cube_wide*cube_long as cube')->where('express_id='.$id)->order('id asc')->select(); 
		$unique_fields	= array('area','post_section', 'post_is_express', 'is_express', 'registration_fee', 'registration_cost', 'weight_begin', 'weight_end', 'cube_high', 'cube_wide', 'cube_long', 'price', 'cost', 'step_price');
		//, 'post_begin', 'post_end'
        $country		= S('country');
        foreach($details as $value){
            $detail_ids[$value['id']]   = $value['id'];
        }
        $detail_post    = M('ExpressPost')->where('express_id ='.$id)->getField('id,express_detail_id,english,post_begin,post_end');
        $detail_country = M('ExpressCountry')->where('express_id ='.$id)->getField('id,express_detail_id,country_id');
        $detail_country = _formatList($detail_country);
        foreach($detail_post as $val){
            $post[$val['express_detail_id']][$val['english'].'_'.$val['post_begin'].'_'.$val['post_end']][] = $val['english'];
            $post[$val['express_detail_id']][$val['english'].'_'.$val['post_begin'].'_'.$val['post_end']][] = $val['post_begin'];
            $post[$val['express_detail_id']][$val['english'].'_'.$val['post_begin'].'_'.$val['post_end']][] = $val['post_end'];
        }
        foreach($detail_country['list'] as $country_info){
            $sign   = isset($country_arr[$country_info['express_detail_id']]) ? ',': ''; 
            $country_arr[$country_info['express_detail_id']]['country']         .= $sign.$country_info['country_id'];
            $country_arr[$country_info['express_detail_id']]['country_name']    .= $sign.$country_info['full_country_name'];
            $country_arr[$country_info['express_detail_id']]['abbr_district']   .= $sign.$country_info['abbr_district_name'];
        }
        foreach($details as $detail) {
			$unique_key		= array();
            foreach($post[$detail['id']] as $post_detail){
                $detail['post_section'] .= '-'.md5(implode('-', $post_detail));
            }
			foreach ($unique_fields as $field) {
				$unique_key[]	= $detail[$field];
			}
			$key			= implode('_', $unique_key);
			$country_info	= $country[$detail['country_id']];
//			if (isset($rs['detail'][$key])) {
//				$rs['detail'][$key]['id']				.= ',' . $detail['id'];
//				$rs['detail'][$key]['country']			.= ',' . $detail['country_id'];
//				$rs['detail'][$key]['country_name']		.= (ACTION_NAME=='view' ? '<br />' : ';') . $country_info['full_country_name'];
//				$rs['detail'][$key]['abbr_district']	.= '<br />' . $country_info['abbr_district_name'];	
//				$rs['detail'][$key]['post_section']     = array_merge($rs['detail'][$key]['post_section'],$post[$detail['id']]);	
//			} else {
				$detail['country']						 = $country_arr[$detail['id']]['country'];
				$detail['country_name']					 = $country_arr[$detail['id']]['country_name'];
				$detail['abbr_district']				 = $country_arr[$detail['id']]['abbr_district'];
				$detail['post_section']                  = $post[$detail['id']];
				$rs['detail'][$key]						 = $detail;
//			}
            $key++;
		}
        //邮编区间转JSON
        foreach($rs['detail'] as &$detail){
            $view_post_section  = array();
            $view_post          = array();
            foreach($detail['post_section'] as &$post_section){
                $post_string    = $post_section       = array_values($post_section);
                foreach ($post_string as $key=>$p_str){
                    if(empty($p_str)){
                        unset($post_string[$key]);
                    }
                }
                $view_post_section[]    = implode('-', $post_string);
            }
            $detail['post_section'] = json_encode(array_values($detail['post_section']));
            $view_post_section  = array_chunk($view_post_section, 5);
            foreach($view_post_section as $v_p_s){
                $view_post[]    = implode(',', $v_p_s);
            }
            $detail['view_post_section'] = implode('<br>', $view_post);
        }
		$data				   = _formatListRelation($rs);
		unset($rs, $country, $details);
		_formatWeightCubeList($data['detail']);
		$data['is_update']	   = getUser('role_type')==C('SELLER_ROLE_TYPE') ? 0:1;
		return $data;
	}

	/// 查看
	public function view(){
		 $rs=$this->getInfo($this->id);
         foreach($rs['detail'] as &$detail){
                $detail['dml_weight_begin']=rtrim(rtrim($detail['dml_weight_begin'],'0'),'.,');
                $detail['dml_weight_end']=rtrim(rtrim($detail['dml_weight_end'],'0'),'.,');
          }
         return $rs;
	}
	
	/// 编辑
	public function edit(){
		return $this->getInfo($this->id);
	}
		 
    public function setPost(){
        $field  = array('english','post_begin','post_end');
        foreach($_POST['detail'] as $key=>$value){
            if(!empty($value['area'])){
                $_POST['detail'][$key]['relation_no']   = $key;
                $post_section_detail    = json_decode(htmlspecialchars_decode(stripcslashes($value['post_section'])),true);
                if(!empty($post_section_detail)){
                    foreach($post_section_detail as $val){
                        $val= array_combine($field, $val);
                        $val['relation_no'] = $key;
                        $post_section[] = $val;
                    }
                }else{
                    $empty_post['english']      = '';
                    $empty_post['post_begin']   = '';
                    $empty_post['post_end']     = '';
                    $empty_post['relation_no']  = $key;
                    $post_section[] = $empty_post;
                }
                $country_detail = explode(',', $_POST['detail'][$key]['country_id']);
                foreach ($country_detail as $count){
                    $county_arr['relation_no']  = $key;
                    $county_arr['country_id']   = $count;
                    $county[]   = $county_arr;
                }
            }
        }
        $_POST['post_section']  = $post_section;
        $_POST['country']       = $county;
        $this->Mdate = $_POST;
		return $_POST;
	}
	/**
	 * 所有派送方式列表SQL
	 *
	 * @return  array
	 */
	public function indexSql(){  
		$count 	= $this->exists('select 1 from express_detail where express_id=express.id and '.getWhere($_POST['detail']),$_POST['detail'])->where(getWhere($_POST['main']))->count();
		$this->setPage($count);
		$ids	= $this->field('id')->exists('select 1 from express_detail where express_id=express.id and '.getWhere($_POST['detail']),$_POST['detail'])->where(getWhere($_POST['main']))->order('express_name desc')->page()->selectIds();
		
		$info['from'] 	= 'express a left join express_detail b on(a.id=b.express_id) ';
		$info['group'] 	= ' group by a.id order by express_name desc';
		$info['where'] 	= ' where a.id in'.$ids;
		$info['field'] 	= 'a.*,count(b.id) as sum_qn, sum(cube_high*cube_wide*cube_long) as cube';
		return  'select '.$info['field'].' from '.$info['from'].$info['where'].$info['group']; 
		
	}
	
	/**
	 * 获取派送方式明细
	 *
	 * @param array $opert
	 * @return array
	 */
	public function detail($opert) {	
		$sql = 'select 
					a.id, a.express_name, a.warehouse_id, a.express_date, a.company_id, a.comments, 
					b.id AS detail_id,b.country_id, b.post_begin, b.post_end, b.post_is_express, b.is_express,b.registration_fee 
				    b.weight_begin, b.weight_end, 
					b.cube_high, b.cube_wide, b.cube_long,
					(b.cube_high * b.cube_wide * b.cube_long) AS cube, 
				    b.price, b.step_price'.$opert['field'].'
					from orders a left join order_details b on(a.id=b.orders_id) 
						left join load_container_details c on(b.id=c.order_details_id) 
						left join load_container d on(c.load_container_id=d.id) 
					where '.$opert['where'].' group by '.$opert['group_by'].' order by a.express_name desc';
		$rs = $this->indexList('',$sql);
		return $rs['list'];
	}
}