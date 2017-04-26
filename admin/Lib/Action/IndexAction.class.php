<?php
// 本类由系统自动生成，仅供测试用途
class IndexAction extends CommonAction {
    public function index(){
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
		$where['parent_id']	= $_GET['tag'];
		$list	=	$node->where($where)->field('id,module,title')->order('sort asc')->select();
		if(!empty($_GET['tag'])){
			$this->assign('menuTag',$_GET['tag']);
		}
		$this->assign('menu',$list);
		/// 定义菜单模块名称
		$id_to_module = array(
			'1'	=> 'System',
			'2'	=> 'Flow',
			'3'	=> 'Develop',
			'4'	=> 'Other',
			'5'	=> 'Invoice',
		);
		$this->link_module = $id_to_module[$_GET['tag']];
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
}