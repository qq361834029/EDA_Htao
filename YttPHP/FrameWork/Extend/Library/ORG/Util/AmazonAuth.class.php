<?php
class ModelAmazonAuth 
{
	public $report_url; // 取库存报告的URL
	public $order_url;  // 取订单的URL	
	public $amazon_auth_path;
	public $amazon_tasks_path;
	public $user_id;
	public $site_id;
	public $AWS_ACCESS_KEY_ID;
	public $AWS_SECRET_ACCESS_KEY;
	public $APPLICATION_NAME;
	public $APPLICATION_VERSION;
	public $MERCHANT_ID;
	public $MARKETPLACE_ID;

	// 构造函数
	function __construct($id){
		$data = M('amazon_site')->find($id);
		if($data){
			extract($data);
			$this->user_id					= $user_id;
			$this->amazon_auth_path			= dirname($_SERVER['SCRIPT_FILENAME']).'/Conf/data/amazon/';
			$this->amazon_tasks_path		= dirname($_SERVER['SCRIPT_FILENAME']).'/Conf/timer/amazon/'; 
			$cache_site = C('AMAZON_COUNTRY');
			$this->report_url				= $cache_site[$site_name]['MWS_URL'];
			$this->order_url				= $this->report_url.'/Orders/2013-09-01';
			$this->AWS_ACCESS_KEY_ID		= $access_key_id;
			$this->AWS_SECRET_ACCESS_KEY	= $secret_acess_key_id;
			$this->APPLICATION_NAME			= 'UnionTop';
			$this->APPLICATION_VERSION		= '2013-09-01';
			$this->MERCHANT_ID				= $merchant_id;
			$this->MARKETPLACE_ID			= $marketplace_id;

			$this->createAmazonFile(); 
		}else{
			echo '该用户的认证文件不存在。';
			exit;
		}
		
	}

	// 生成配置文件
    public function createAmazonFile(){
		$config_file = '<?php 
$report_url			   = "'.$this->report_url.'";
$order_url			   = "'.$this->order_url.'";
$AWS_ACCESS_KEY_ID	   = "'.$this->AWS_ACCESS_KEY_ID.'";
$AWS_SECRET_ACCESS_KEY = "'.$this->AWS_SECRET_ACCESS_KEY.'";
$APPLICATION_NAME	   = "'.$this->APPLICATION_NAME.'";
$APPLICATION_VERSION   = "'.$this->APPLICATION_VERSION.'";
$MERCHANT_ID		   = "'.$this->MERCHANT_ID.'";
$MARKETPLACE_ID		   = "'.$this->MARKETPLACE_ID.'";
?>';
		file_put_contents($this->amazon_auth_path.$this->user_id.'.php', $config_file);
	}

	// 生成计划任务文件
	public function createAmazonSystemTasksFile(){
		$file_name		= $this->amazon_tasks_path.'amazon_'.$this->user_id.'.text';
		//if(!file_exists($file_name))
		{
			//销售数据
			$content .= C('CFG_URL').'index.php/AmazonSeller/getOrders/user_id/'.$this->user_id.'
';
		}
		file_put_contents($file_name,$content);
	}

	// 删除认证相关文件
    public function deleteAuthFile(){
		$config_file = $this->amazon_auth_path.$this->user_id.'.php';
		if (is_file($config_file)){
			unlink($config_file);
		}
	}
	//删除计划任务文件
	public function delAmazonSystemTasksFile(){
		$file_name	= $this->amazon_tasks_path.'amazon_'.$this->user_id.'.text';
		if(file_exists($file_name)){
			 @unlink($file_name);
		}
	}
	
	//删除授权文件及自动抓取的文件
	public function deleteFile(){
		$this->delAmazonSystemTasksFile();
		$this->deleteAuthFile();
	}
}
?>