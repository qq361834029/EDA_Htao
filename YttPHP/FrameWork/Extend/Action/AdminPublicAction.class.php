<?php
/**
 * 原来的后台管理界面，该文件需要删除
 * @copyright   Copyright (c) 2006 - 2013 TOP UNION 展联软件友拓通
 * @category   	角色信息
 * @package  	Action
 * @author    	何剑波
 * @version 	2.1,2013-08-06
*/

class AdminPublicAction extends Action {
	// 检测是否存在超管权限
	function _initialize() {
		// 用户权限检查
		if (!$_SESSION [C('SUPER_ADMIN_AUTH_KEY')]) {
			 exit('非法操作！');
		}
	}
	// 公共配置
	public function common(){
		$this->assign('client_currency',explode(',',C('client_currency')));
		$this->assign('factory_currency',explode(',',C('factory_currency')));
		$this->assign('logistics_currency',explode(',',C('logistics_currency')));
		$this->assign('company_currency',explode(',',C('company_currency')));
		$this->display();
	}
	
	// 首页
	public function index(){
		$this->display();
	}
	// 中间操作栏
	public function drag(){
		$this->display();
	}
	
	// 顶部页面
	public function top() {
		$model	=	M("NodeAdmin");
		$list	=	$model->where('level=1')->order('sort asc')->getField('id,title');
		$this->assign('nodeGroupList',$list);
		$this->display();
	}
	
	// 菜单页面
	public function menu() {
		//读取数据库模块列表生成菜单项
		$node    =   M("NodeAdmin");
		$where['level']		= 2;
//		$where['status']	= 1;
		$where['parent_id']	= $_GET['tag'];
		$list	=	$node->where($where)->field('id,module,title')->order('sort asc')->select();
		if(!empty($_GET['tag'])){
			$this->assign('menuTag',$_GET['tag']);
		}
		$this->assign('menu',$list);

		C('SHOW_RUN_TIME',false);			// 运行时间显示
		C('SHOW_PAGE_TRACE',false);
		$this->display();
	}

    // 后台首页 查看系统信息
    public function main() {
        $info = array(
            '操作系统'=>PHP_OS,
            '运行环境'=>$_SERVER["SERVER_SOFTWARE"],
            'PHP运行方式'=>php_sapi_name(),
            'ThinkPHP版本'=>THINK_VERSION.' [ <a href="http://thinkphp.cn" target="_blank">查看最新版本</a> ]',
            '上传附件限制'=>ini_get('upload_max_filesize'),
            '执行时间限制'=>ini_get('max_execution_time').'秒',
            '服务器时间'=>date("Y年n月j日 H:i:s"),
            '北京时间'=>gmdate("Y年n月j日 H:i:s",time()+8*3600),
            '服务器域名/IP'=>$_SERVER['SERVER_NAME'].' [ '.gethostbyname($_SERVER['SERVER_NAME']).' ]',
            '剩余空间'=>round((@disk_free_space(".")/(1024*1024)),2).'M',
            'register_globals'=>get_cfg_var("register_globals")=="1" ? "ON" : "OFF",
            'magic_quotes_gpc'=>(1===get_magic_quotes_gpc())?'YES':'NO',
            'magic_quotes_runtime'=>(1===get_magic_quotes_runtime())?'YES':'NO',
            );
        $this->assign('info',$info);
        $this->display();
    }
    
    // 保存配置
    public function save(){
    	$type = $_POST['type']; 
    	if($type=='common') D('Admin')->updateCurrency($_POST);
    	D('Admin')->saveConfig();
    	redirect($type,2,'保存成功，2秒后跳转');
    }
    // 流程配置
    public function flow() {
       $this->assign('menu',D('Admin')->getNode());
       $this->display();
    }
    // 更新项目可用模块
    public function updateNode(){
    	D('Admin')->saveNode();
    	redirect('flow',2,'保存成功，2秒后跳转');
    }
    
    // 更新配置缓存
    public function updateConfig(){
    	F('_tables',NULL);	// 删除文件缓存
    	D('Admin')->updateConfig();
    	D('Admin')->saveExcelAry();
    	exit('更新项目配置成功！');
    }

   
    //更新缓存
    public function cache(){
    	D('Cache')->updateCache();
    	redirect('main',10,'<br><br><br>会出现错误代码，不影响缓存更新！');
    }
    
    // 菜单管理
    public function node(){
    	if ($_GET['id']>0) {
    		$where = ' (parent_id='.$_GET['id'].')';
    	}else{
    		$where = 'group_id=0 and level=1';
    	}
    	$this->node = M('Node')->where($where)->order('sort asc')->select();
//    	echo M('Node')->getLastSql();
    	$this->display();
    }
    
    public function editnode(){
    	$rs = M('Node')->find($_GET['id']);
    	if ($rs['parent_id'] && $temp = M('Node')->find($rs['parent_id'])) {
    		$rs['parent_title'] = $temp['title'];
    		unset($temp);
    	}
    	if ($rs['group_id'] && $temp = M('Node')->find($rs['group_id'])) {
    		$rs['group_title'] = $temp['title'];
    	}
    	$this->rs =$rs;
    	$this->display();
    }
    public function deletenode(){
    	M('Node')->delete($_GET['id']);
    	header("location:".__URL__."/node");
    }
    public function saveNode(){
    	$model = M('Node');
    	$model->create($_POST);
		if($_POST['id']){
    		$model->save();
		}else{
			$id	= $model->add($_POST); 
		}
		if ($id!==false) { ///保存成功 
			redirect(__URL__.'/node',2,'保存成功，2秒后跳转');
		} else { 
			///失败提示  
			redirect(__URL__.'/node',2,'保存失败，2秒后跳转');
		}
    }
    
     // 菜单管理
    public function dd(){
    	$this->dd = M('Dd')->order('id asc')->select();
    	$this->display();
    }
    //发票公共配置
    public function invoice(){
    	$this->assign('weekend',explode(',',C('invoice.weekend')));
    	$this->display();
    }
    
    public function updateFlowStorage(){
    	$flow = array('order','loadContainer','instock','sale','preDelivery','delivery','adjust','transfer','stocktake','initStorage');
    	$key = array('color','size','storage_format','mantissa');
    	$flow_to_once = array('color'=>'storage_color','size'=>'storage_size','storage_format'=>'storage_format','mantissa'=>'storage_mantissa');
    	foreach ($flow as $type) {
    		foreach ($key as $value) {M('Config')->where('`key`=\''.$value.'\' and `type`=\''.$type.'\'')->delete();
    			if ($type=='order' && $value=='mantissa') {
    				continue;
    			}
    			
    			$value2 = C($flow_to_once[$value]);
    			if (empty($value2)) {$value2 = 2;}
    			M('Config')->add(array('key'=>$value,'value'=>$value2,'type'=>$type,'type_key'=>1));
    		}
    	}
    	D('Admin')->updateCofig();
    	redirect('once',2,'保存成功，2秒后跳转');
    }
    
    public function logout(){
    	redirect(PHP_FILE.'/Public/logout');
    }
    
    public function resetRole(){
    	if ($_GET['update']) {
    		$exec = include(THINK_PATH.'Conf/sqlInit.php');
    		foreach ($exec as $sql) {
    			M()->execute($sql);
    		}
    		if (C('product_color')==2) {
    			M()->execute("INSERT INTO `access` (`id`, `role_id`, `node_id`, `data_rights`) VALUES (14, 2, 340, NULL),(15, 2, 341, NULL);");
    		}
    		if(C('product_size')==2){
    			M()->execute("INSERT INTO `access` (`id`, `role_id`, `node_id`, `data_rights`) VALUES (19, 2, 343, NULL),(20, 2, 344, NULL);");
    		}
    		exit('初始化成功');
    	}else {
    		$this->display();
    	}
    }
    
    //插入条形码业务规则
    public function saveBarcode(){  
    	//开启条形码
    	if (C('barcode')) { 
    		$Model = D('Admin'); 
	    	$Model->addConfigBarcode($_POST); 
	    	redirect('barcode',2,'保存成功，2秒后跳转');
        }else{//未开启条形码 
    		redirect('barcode',2,'操作失败,请开启条形码，2秒后跳转');
    	}
    }
    
   	public function barcode(){
    	$model		= D('Admin');
    	$this->list	= $model->getBarcode();
    	$this->info	= array(
    			'country'	=> L('country_no'),
				'size_no'	=> L('size_no'),
				'color_no'	=> L('color_no'),
				'class_no'	=> L('class_no'),
				'product_no'=> L('product_no'),
				'comp_no'	=> L('fac_no'),
				'serial_no'	=> L('water_no')
   		);
    	$this->display();
    }
    
   	//导入模版
    public function importTemp(){
    	$data = include(RUNTIME_PATH.'~ExcelTemplete.php');
		asort($data);
		$this->list	= $data;
		$this->display('excelTemplate');
    }
    //生产所有
    public function saveTempleteAll() {
		$data 	= include(RUNTIME_PATH.'~ExcelTemplete.php');
		foreach ((array)$data as $key=>$value){
			$this->saveTemplete($key);
		}
		redirect('importTemp',2,'保存成功，2秒后跳转');
	}
	public function saveTemplete($filename=null) {
		empty($filename) && $filename = trim($_GET['key']);
		if(empty($filename)) return false;
		unset($_GET['key']);
		$data = include(RUNTIME_PATH.'~ExcelTemplete.php');
		$data = $data[$filename];
		$model= D('Admin');
		$model->saveTemplete($data,$filename);
		if(ACTION_NAME=='saveTemplete'){
			redirect(__URL__.'/importTemp',2,'保存成功，2秒后跳转');
		}
	}
	//更新语言包
	public function lang(){
		$path	= THINK_PATH.'Lang/';
		$count	= M('lang')->count();
		if($count==0){
			D('Admin')->importLang($path);
			echo '更新完成。';
		}else{
			echo '请清空lang表数据，再执行导入语言包。';
		}
		exit;
	}

}