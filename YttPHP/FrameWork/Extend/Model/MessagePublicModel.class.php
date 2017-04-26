<?php

/**
 * 信息公布栏
 * @copyright   Copyright (c) 2006 - 2013 Top Union 展联软件友拓通
 * @category    信息列表
 * @package		Model
 * @author		lml
 * @version    2016-01-12
 */

class MessagePublicModel extends  RelationCommonModel {

	/// 定义真实表名
	protected $tableName = 'message';
	/// 定义索引字段
	public $id;
	/// 自动验证设置
	protected $_validate	 =	 array(
			array("message_title",'require',"require",1), //信息标题
		    array("message_category_id",'require',"require",1),			
		);
	/// 自动填充
	protected $_auto = array(
							array("create_time", "date", 1, "function", "Y-m-d H:i:s"), // 创建时间
							array("update_time", "date", 2, "function", "Y-m-d H:i:s"), // 更新时间
						);
	/// 验证表单明细
	protected $_validDetail	 =	 array(
			array("category_name",'require','require',1),
	);  
			
	public function getIndex() {
		if (isset($_REQUEST['_sort'])) {
			if($_REQUEST['_order']=='message_time'){
				$field =' create_time';
			}
			$order	= $_REQUEST['_sort']!=1?' ' . $field . ' desc':' ' .  $field;
		} else {
			$order	= ' create_time desc';
		}
		$where = '1 and ';

		$where  .= getWhere($_POST);		 
		if (!empty($_POST['from_paid_date'])) {
			$where .= ' and   date(create_time)>=\''.$_POST['from_paid_date'].'\'';
		}
		if (!empty($_POST['to_paid_date'])) {
			$where .= ' and  date(create_time)<=\''.$_POST['to_paid_date'].'\'';
		}
		if (!empty($_POST['user_type'])) {
			$where .= ' and  FIND_IN_SET('.$_POST['user_type'].',user_type)';
		}
		if (!empty($_POST['is_read'])) {
			 $where_state_log =' user_id='.getUser('user_id');
		}
		if($_SESSION[C('ADMIN_AUTH_KEY')]){
            if(getUser('user_type')>0){
                if($_REQUEST['is_read']== C('UNREAD')){
                    $where .=' and  (FIND_IN_SET('.getUser('user_type').',user_type) or m.add_user='.getUser('id').') ';
                }else{
                    $where .=' and  (FIND_IN_SET('.getUser('user_type').',user_type) or add_user='.getUser('id').') ';
                }
            }
        }else{
			$where .=' and is_announced=1 and  FIND_IN_SET('.getUser('user_type').',user_type) ';
		}
		if($_GET['is_read']){
			$where_state_log = ' user_id='.getUser('user_id');
		}
		if($_REQUEST['is_read']== C('UNREAD')){
			$sql='SELECT COUNT(*) sum  FROM `message`  m
				left join message_category  c on c.id=m.message_category_id
				left join message_state_log l on l.message_id=m.id and l.user_id='.getUser('user_id').' where '.$where.' and l.message_id is null';	
			$count=M()->query($sql);
			$count=$count[0]['sum'];
			$this->setPage($count);
			$_limit = _page($count);
			$sql='SELECT m.id  FROM `message`  m
					left join message_category  c on c.id=m.message_category_id
					left join message_state_log l on l.message_id=m.id and l.user_id='.getUser('user_id').' where '.$where.' and l.message_id is null order by m.id desc limit '.$_limit['firstRow'].','.$_limit['listRows'];		 
			$ids=M()->query($sql);
			foreach($ids as &$val){
				$val=$val['id'];
			}
			$ids ='('.implode(',',$ids).')';
        }elseif($_REQUEST['is_read']== C('HAVE_ANNOUNCED')){
            $exists_message_category	= 'select 1 from message_category  where message.message_category_id= message_category.id';
            $exists_message_state_log	= 'select 1 from message_state_log where message_state_log.message_id=message.id  and '.$where_state_log;
            $count 	= $this->exists($exists_message_category)
                            ->exists($exists_message_state_log,$where_state_log)
                            ->where($where)
                            ->count();
            $this->setPage($count);
            $ids 	=$this->field('message.id')
                            ->exists($exists_message_category)
                            ->exists($exists_message_state_log,$where_state_log)
                            ->where($where)->order($order)->page()->selectIds();

        }else{
            $count 	= $this->exists('select 1 from message left join message_category on message.message_category_id= message_category.id')->where($where)->count();
            $this->setPage($count);
            $ids	= $this->field('id')->exists('select 1 from message left join message_category on message.message_category_id= message_category.id ')->where($where)->order($order)->page()->selectIds();
        }
	
		$info['from'] 	= 'message m left join message_category as c on m.message_category_id = c.id';
		if($ids=='()'){
			return null;
		}else{
			$info['where'] 	= ' where m.id in'.$ids;
			$info['group']  =' group by m.id order by '.$order;
			$info['field'] 	= ' m.id,m.is_announced ,c.category_name,date(m.create_time) as message_time,m.create_time,m.message_title,m.user_type,m.to_hide';
			$sql =  'select '.$info['field'].' from '.$info['from'].$info['where'].$info['group'];
			$list=M()->query($sql);
			$list	= _formatList($list);
			$user_type  =  C('CFG_USER_TYPE');
			if(getUser('user_type')>0){
				$message_id = 'message_id in '.$ids.' and user_id='.getUser('user_id');
				$state_log_id=M('MessageStateLog')->where($message_id)->field('message_id')->select();
				foreach($state_log_id as &$val){
					$val=$val['message_id'];
				}
				foreach($list['list'] as &$val){
					if(in_array($val['id'],$state_log_id)){
						$val['dd_is_read']=L('yes');
					}else{
						$val['dd_is_read']=L('no');
					}
				}
			}
			//管理员权限可见帐号类型
			if($_SESSION[C('ADMIN_AUTH_KEY')]){
				foreach($list['list'] as &$val){
					if(empty($val['dd_user_type'])){
						$rs['user_type']=explode(",",$val['user_type']);
						foreach($rs['user_type'] as &$value){
							$value=$user_type[$value];
						}
						$val['dd_user_type']=implode(",",$rs['user_type']);
					}
				}
			}
			unset($value,$val);
			return $list;
		}
	}

	 /// 查看
	public function view(){
		return $this->getInfo($this->id);
	}
	/// 编辑
	public function edit(){
		return $this->getInfo($this->id);
	}
	/**
	 * 获取明细信息(用于查看/编辑)
	 *
	 * @param int $id
	 * @return array
	 */
	public  function getInfo($id) {
		$user_type  =  C('CFG_USER_TYPE');//账户类型
		$rs			  = $this->find($id);
		$rs['category_name']  = M('Message')->alias('m')->join('left join message_category as c on m.message_category_id=c.id')->where('m.id='.$id)->getField('category_name');
		if(getUser('user_type')>0){
			if (message_permission_validation($rs) === false) {
				throw_json(L('data_right_error'));
			}
			$rs['out_of_sight'] = true;
            $this->addMessageStateLog($id);
		}		 
		$rs	  = _formatListRelation($rs);	
		if(empty($rs['dd_user_type'])){
			$rs['user_type']=explode(",",$rs['user_type']);//转化为数组
			if(ACTION_NAME=='view'){
				foreach($rs['user_type'] as &$val){
					$val=$user_type[$val];
				}
				unset($val);
			$rs['dd_user_type']=implode(",",$rs['user_type']);
			}
		}else{			
			$aa[]=$rs['user_type'];
			$rs['user_type']=$aa;
		}
		$rs['is_update'] = $rs['is_announced']==2 ? 1 : 0;
        $file_url = D('Gallery')->getAry($id,C('MESSAGE_DOWNLOAD_FILE_TYPE')); 
		$path	= getUploadPath(C('MESSAGE_DOWNLOAD_FILE_TYPE'));
        foreach($file_url as &$val){
            $val['file_url']      = $path . $val['file_url'];
        }
        $rs['gallery']  = $file_url;
		return $rs;
	}
    public function addMessageStateLog($id){
        $message_id = 'message_id ='.$id.' and user_id='.getUser('user_id');
        $result=M('MessageStateLog')->where($message_id)->find();
        if(!$result){
            $data['user_id']=getUser('id');
            $data['message_id']= $id;
            $data['reading_time']  = date('Y-m-d H:i:s',time());
            $result = D('Message_state_log')->add($data);
            if(!$result){
                return L('_ERROR_');
            }
        }
    }
	

			

	
}