<?php

require_once 'setincludepath.php';
require_once 'EbatNs_Environment.php';

class EbayTokenPublicModel extends EbatNs_Environment
{
	/// EBAY用户ID
    protected $user_id   = '';

	/// 主要站点ID
    protected $site_id   = '';

	/// EBAY配置文件路径
    protected $ebay_token_path   = '';

	/// EBAY计划任务文件路径
    protected $ebay_tasks_path   = '';

	/**
 	 * 构造函数
 	 *
 	 * @param 表单参数  $query
 	 */
	function __construct($user_id='dev',$site_id=77){
		$this->user_id = $user_id;
		$this->site_id = $site_id;
		$this->ebay_token_path = dirname($_SERVER['SCRIPT_FILENAME']).'/Conf/data/ebay/';
		$this->ebay_tasks_path = dirname($_SERVER['SCRIPT_FILENAME']).'/Conf/timer/ebay/';
		Model::setParametersForModel($this);
		//判断是否存在认证文件。如果没有则自动生成
		if(!is_file($this->ebay_token_path.$this->user_id.'.token') || !is_file($this->ebay_token_path.$this->user_id.'.php')){
			$this->createEbayFile();
		}
		parent::__construct(0,$user_id);
	}

	/**
 	 * 设置user_id
 	 *
 	 * @user_id user_id  string
 	 */
	function setUserID($user_id){
		$this->user_id = $user_id;
	}

	/**
 	 * 获取user_id
 	 *
 	 * @获取user_id user_id  string
 	 */
	function getUserID(){
		return $this->user_id;
	}

	/**
 	 * 设置site_id
 	 *
 	 * @site_id site_id  string
 	 */
	function setSiteID($site_id){
		$this->site_id = $site_id;
	}

	/**
 	 * 获取site_id
 	 *
 	 * @site_id 表单参数  string
 	 */
	function getSiteID(){
		return $this->site_id;
	}

	/**
     * 获取SessionID
     * 
     */
    public function getSessionID()
    {
    	require_once 'GetSessionIDRequestType.php';
        $req = new GetSessionIDRequestType();
        //RuName
	    $req->setRuName(EBAY_RUNAME);
        
        $res = $this->proxy->GetSessionID($req);
        if ($this->testValid($res))
        {
            return $res->SessionID;
        }
        else 
        {
        	$content = $this->proxy->getErrorsToString($res, true);
            sendValidEmail('EBAY SessionID 获取SessionID失败，日期'.date('Y-m-d H:i:s'),$content.'<br>user_name:'.$info['user_name'],1);
            return false;
        }
    }

	/**
     * 获取getToken
     * @session_id 从EBAYAPI获取的SESSION_ID  string
     */
    public function getToken($session_id)
    {
    	require_once 'FetchTokenRequestType.php';
        $req = new FetchTokenRequestType();
        //RuName
	    $req->setSessionID($session_id);
        
        $res = $this->proxy->FetchToken($req);
        if ($this->testValid($res))
        {
			$return_info['eBayAuthToken']		= $res->eBayAuthToken;
			$return_info['HardExpirationTime']	= $res->HardExpirationTime;
			//生成文档 
			$this->createTokenFile($return_info['eBayAuthToken']);
            return $return_info;
        }
        else 
        {
			$this->deleteTokenFile();
        	$content = $this->proxy->getErrorsToString($res, true);
            sendValidEmail('EBAY Token 获取Token失败，日期'.date('Y-m-d H:i:s'),$content.'<br>user_id:'.$this->user_id,1);
            return false;
        }
    }


	/**
     * 生成getToken文件
     * @session_id 从EBAYAPI获取的SESSION_ID  string
     */
    public function createTokenConfig(){
		$config_file = '[ebay-config]
compat-level = 711

dev-key-prod = 346ac902-f137-4b42-aa71-1b3915eed89d
app-key-prod = EDZ2252c9-b8ff-4dd3-91aa-202e9efae77
cert-id-prod = d2ae7fc9-c805-43a3-9591-025305ff1b5b

; primary site id
site-id = '.$this->site_id.'
; 1 => sandbox, 0 => production
;app-mode = 1
app-mode = 0

[ebay-transaction-config]
use-http-compression=1

; put in here the full absolute path to your config file !
token-pickup-file="'.$this->ebay_token_path.$this->user_id.'.token"
token-mode=1
error-language="zh_CN"';
		$file_name = $this->ebay_token_path.$this->user_id.'.php';
		file_put_contents($file_name,strip_whitespace($config_file));
	}

	/**
     * 生成getToken文件
     * 
     */
    public function createTokenFile($token='')
    {
		if($token==''){
			$token='AgAAAA**AQAAAA**aAAAAA**41yTUA**nY+sHZ2PrBmdj6wVnY+sEZ2PrA2dj6AFk4WpAJaGoQmdj6x9nY+seQ**EcAAAA**AAMAAA**l79YGUmJxZU8Nm7m9Osw+EHQ0f7yObuBdABgvtXLCodLI8V2jLft3FP9RUoLvC80DeQBOGuz++qMj7wUYl45opL/drvvslsOqrxLzV3OM5DEosL7LG/a90chN/7cV9rgmYFKGRyNl+shEJ1ZB9RERaGN0a4RjQYnvgMw7LbhKSp66KRoco+05eutAA3r4b44RQMCGbvCAqmh+rKH9V0dAi5dtd2laTXL6Q4UqutmJJO8Tht6eECXRR97gilEDwloRznXR+AE/fI50aGxe2pjh5NbaPmYVQ6/Z+M9AADcgXBxMKfpc44wHi5zMZWJKO2qClWKS7pKvAqANvwAD7e8eyqLg5mPxXJgJ/F1mVI37Kp5ef0+LNvrVg1guQzgE3EfwoPBMw+wS+0Y4dcK8OhmgYlHfq704dFTu7ILV1NRPsqxb8Uhh149nncm624a9kGlaMHe+pQIJ8pRPvqPrqZ4tczur74D62hbXmR2xsc7uwQzPYY/TioaDYKwrL3rcseso08cQ+g+WnlfU7G9mc459jcH5eksDbRG+vAu9sArV2WO8FK4ON0m7p+9nINlfh8YxJWg0te0BQDTonehEwQr7FbL/dzQgYIOtZbKs7L/rmsQfG2628nOMVo73Tef2qbvM1r1Bui+9ec8Z9xXVt/n6g9VHXbqOGdo4d9D6ckK4Xi+rRbN/nNaqk0mBFy7luEl6vaRPGRptL5PgzUwR4vT7NELeimOn/z/gwAMRbkKf06eTAhLEs6f9EtMFDPsboov';
		}
		$file_name = $this->ebay_token_path.$this->user_id.'.token';
    	file_put_contents($file_name,strip_whitespace($token));
	}
		

	/**
     * 生成getToken文件
     * 
     */
    public function createEbayFile($token='')
    {
		$this->createTokenConfig();
		$this->createTokenFile($token);
		$URLDetails = $this->MCache->getArray('URLDetails'.$this->site_id);
		//初始化站点URL信息
		if(!is_array($URLDetails)){
			$this->setURLDetails($this->site_id);
		}
    }

	/**
     * 获取EBAY详细信息
     * 
     */
	public function getEbayDetail($DetailsName){
		require_once 'GeteBayDetailsRequestType.php';
        $req = new GeteBayDetailsRequestType();
        $req->setDetailName($DetailsName);
        $res = $this->proxy->GeteBayDetails($req);
        if ($this->testValid($res))
        {
            return $res;
        }
        else 
        {
        	$content = $this->proxy->getErrorsToString($res, true);
            sendValidEmail('EbayCountry 获取国家失败，日期'.date('Y-m-d H:i:s'),$content.'<br>user_id:'.$this->user_id,1);
            return false;
        }
	}

	/**
     * 获取SiteID详细信息
     * 
     */
	public function getSiteDetail(){
		//获取SITE_ID信息
		$res = $this->getEbayDetail('SiteDetails');
		//更新系统国家字段
		foreach ($res->SiteDetails as $key =>$value){
			$SiteDetails[$value->SiteID] = $value->Site;
		}
		asort($SiteDetails);
		$this->MCache->set('SiteDetails',$SiteDetails);
	}

	/**
     * 获取各站点URL详细信息
	 URLType   

     * 
     */
	public function setURLDetails($site_id=0){
		if($site_id == 0){
			$site_id = $this->site_id;
		}

		//获取SITE_ID信息
		$res = $this->getEbayDetail('URLDetails');
		//更新系统国家字段
		foreach ($res->URLDetails as $key =>$value){
			//站点名称
			$URLDetails[$value->URLType]	= $value->URL;
		}
		$this->MCache->set('URLDetails'.$site_id,$URLDetails);
	}

	/**
     * 获取EBAY时区详细信息
     * 
     */
	public function setTimeZoneDetails(){
		//获取SITE_ID信息
		$res = $this->getEbayDetail('TimeZoneDetails');
		//更新系统国家字段
		foreach ($res->TimeZoneDetails as $key =>$value){
			//所在地区名称
			$TimeZoneDetails[$value->TimeZoneID]['TimeZoneID']			= $value->TimeZoneID;
			//标准时区名称
			$TimeZoneDetails[$value->TimeZoneID]['StandardLabel']			= $value->StandardLabel;
			//标准时差
			$TimeZoneDetails[$value->TimeZoneID]['StandardOffset']		= $value->StandardOffset;
			//夏令时时区名称
			$TimeZoneDetails[$value->TimeZoneID]['DaylightSavingsLabel']	= $value->DaylightSavingsLabel;
			//夏令时时区时差
			$TimeZoneDetails[$value->TimeZoneID]['DaylightSavingsOffset']	= $value->DaylightSavingsOffset;
		}
		ksort($TimeZoneDetails);
		$this->MCache->set('TimeZoneDetails',$TimeZoneDetails);
	}

	/**
     * 更新EBAY所需的缓存
     * 
     */
	public function updateEbayCache(){
		$this->getSiteDetail();
		$cache_ebay_site = $this->MCache->getArray('ebay_site');
		//更新站点URL
		foreach ($cache_ebay_site as $value){
			$site_ids[$value['site_id']] = $value['user_id'];
		}
		//更新站点URL
		foreach ($site_ids as $key => $value){
			$this->site_id = $key;
			$this->user_id = $value;
			$this->__construct($this->user_id,$this->site_id);
			$this->setURLDetails($value);
		}
		$this->setTimeZoneDetails();
	}

	/**
     * 更新EBAY所需的缓存
     * 
     */
	public function getTestToken(){
		//获取SITE_ID信息
		$res = $this->getEbayDetail('URLDetails');
		if($res->Ack=='Success'){
			return true;
		}else{
			return false;
		}
	}

	/**
     * 生成Ebay计划任务文件
     * 
     */
	public function createEbaySystemTasksFile(){
		$file_name		= $this->ebay_tasks_path.'ebay_'.$this->user_id.'.text';
		if(!file_exists($file_name)){
			//上货数据
			$ebay_content .= CFG_URL.'index.php?c=Seller&action=ajaxOldSeller&time_type=minutes&from_time=90&site_id='.$this->site_id.'&user_id='.$this->user_id.'
';
			//交易数据
			$ebay_content .= CFG_URL.'index.php?c=Seller&action=ajaxOldSale&time_type=minutes&from_time=90&site_id='.$this->site_id.'&user_id='.$this->user_id.'
';
			/// 自动发送好评
			$ebay_content .= CFG_URL.'index.php?c=Seller&action=putFeedbackToEbay&site_id='.$this->site_id.'&user_id='.$this->user_id.'
';
			/// 客户对店铺的评价
			$ebay_content .= CFG_URL.'index.php?c=Seller&action=ajaxFeedBack&type=FeedbackReceivedAsSeller&site_id='.$this->site_id.'&user_id='.$this->user_id.'
';
			/// 店铺对客户的评价
			$ebay_content .= CFG_URL.'index.php?c=Seller&action=ajaxFeedBack&type=FeedbackLeft&site_id='.$this->site_id.'&user_id='.$this->user_id;
/*			
			///活跃数据
			$ebay_content .= CFG_URL.'index.php?c=Seller&action=updateActiveSeller&site_id='.$this->site_id.'&user_id='.$this->user_id.'
';
*/
			}
		file_put_contents($file_name,$ebay_content);
	}
	/**
     * 删除认证相关文件
     * 
     */
    public function deleteTokenFile(){
		$config_file = $this->ebay_token_path.$this->user_id.'.php';
		$token_file  = $this->ebay_token_path.$this->user_id.'.token';
		if (is_file($config_file)){
			unlink($config_file);
		}
		if (is_file($token_file)){
			unlink($token_file);
		}
	}
	/**
	 * 删除Ebay计划任务文件
	 * 
	 */
	public function delEbaySystemTasksFile(){
		$file_name		= $this->ebay_tasks_path.'ebay_'.$this->user_id.'.text';
		if(file_exists($file_name)){
			 @unlink($file_name);
		}
	}
	
	/**
     * 验证Token是否有效
     * 1有效，0无效
     */
	public function getTokenStatus(){
		require_once 'GetTokenStatusRequestType.php';
        $req = new GetTokenStatusRequestType();
		$res = $this->proxy->GetTokenStatus($req);
		if ($res->TokenStatus->Status=='Active')
        {	 
			return 1;
        }
        else 
        {
			$this->deleteFile();
        	$content = $this->proxy->getErrorsToString($res, true);
            sendValidEmail('EBAY Token 无效，日期'.date('Y-m-d H:i:s'),$content.'<br>user_id:'.$this->user_id,1);
            return 0;
        }
	}
	/**
     * 删除授权文件及自动抓取的文件
     *
     */
	public function deleteFile(){
		$this->delEbaySystemTasksFile();
		$this->deleteTokenFile();
	}
}
?>