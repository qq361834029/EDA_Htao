<?php

require_once 'setincludepath.php';
require_once 'EbatNs_Environment.php';

class ModelEbayToken extends EbatNs_Environment
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
		//判断是否存在认证文件。如果没有则自动生成
		if(!is_file($this->ebay_token_path.$this->user_id.'-'.$this->site_id.'.token') || !is_file($this->ebay_token_path.$this->user_id.'-'.$this->site_id.'.php')){
			$this->createEbayFile();
		}
		parent::__construct(0,$this->user_id.'-'.$this->site_id);
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
	    $req->setRuName(C('EBAY_RUNAME'));
        $res = $this->proxy->GetSessionID($req);
        if ($this->testValid($res))
        {
            return $res->SessionID;
        }else{
        	//$content = $this->proxy->getErrorsToString($res, true);
			//如果获取Session有可能是认证已经过期，就需要删除掉旧的授权文件，重新生成标准的授权文件
			$this->deleteFile();
			$this->createEbayFile();
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
            return false;
        }
    }


	/**
     * 生成getToken文件
     * @session_id 从EBAYAPI获取的SESSION_ID  string
     */
    public function createTokenConfig(){
		$config_file = '[ebay-config]
compat-level = 811

dev-key-prod = 85b1a647-26e1-434d-9e58-e4e0bbba4a9f
app-key-prod = EZDe5bad9-07e6-4dd5-a6a0-7e2c4fd1fa3
cert-id-prod = c20e0154-5235-40e7-86fa-cd6aa8b32690

; primary site id
site-id = '.$this->site_id.'
; 1 => sandbox, 0 => production
;app-mode = 1
app-mode = 0

[ebay-transaction-config]
use-http-compression=1

; put in here the full absolute path to your config file !
token-pickup-file="'.$this->ebay_token_path.$this->user_id.'-'.$this->site_id.'.token"
token-mode=1
error-language="zh_CN"';
		$file_name = $this->ebay_token_path.$this->user_id.'-'.$this->site_id.'.php';
		file_put_contents($file_name,strip_whitespace($config_file));
	}

	/**
     * 生成getToken文件
     * 
     */
    public function createTokenFile($token='')
    {
		if($token==''){
			$token='AgAAAA**AQAAAA**aAAAAA**2ifdVg**nY+sHZ2PrBmdj6wVnY+sEZ2PrA2dj6AFk4WpAJaGoQmdj6x9nY+seQ**674AAA**AAMAAA**J9tHxJAXO4gFKt6uMm0+7mz3DWBqnv6M12MV3ODx6btF3Mz+EmnEnSlfbcXL7+lVK8LvnxComIzP+Z5Nyq3eM6G9ekxaJxw38MYo6zhI+A9zqMmbacpftPt3lEjWhGZugiGMcBH47EOPupHrvzhRWTPnGyBbg2+Kxox5z7MRMRieXSD/ny0wpiB2504EKGKmS1HMBnzlzmHUgma1zHCynduKzKDBQFm5hXD3xJ7V+ID0Ye7xDmhQGfbqW9PK4j1qCzNGAckKgjM8eAMfyHRE8bvYbVYxjYtlTaKUZbkPQLoNdwTOCTOHbMoAxp6OY9YShz8Vgxm/CoDtjQiPrOLHV7oSPdwbvgkeqYM/SNzDKCTLiCELFBKOlJq4Gwhe815/4VY+PpM+7zoedcbblKKSHfmjCVk1RnVWrG7+iR/DDc3kqTosyJEC8M9XYDHEZjiUkaXjiu92nuukyRPzmeZhxR4G8qW3PRQ8rtCp7ulNt6XQML9/uWoaJVZQXoreNExAbngPtu6NNO4+xhuWYhzSTQHrQgAz5IiJxPr6tMxk+9F+OTXgoESs1bUpVoLIRRt6cniRvhY+/A7zkBGISLSvnulOYED0Mv+OY9ANB2qRzuZdYkm4jNggyD74GfgmgaIqbtxipomaTIru4GEaHC6ybNpIxRMwZojYrnQ1orZEuctoZKKaiR2VfbDjRGQsM2YQGQoQY8YI/8qxfwEF9lL8yDMJg0JrlQHXRX8QyJXtAiE+mtD4O+hsqxmGzCsyH9Bf';
		}
		$file_name = $this->ebay_token_path.$this->user_id.'-'.$this->site_id.'.token';
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
			$this->site_id = $value->SiteID;
			$this->__construct($this->user_id,$this->site_id);
			$this->setURLDetails($this->site_id);
		}
		asort($SiteDetails);
		S('SiteDetails',$SiteDetails);
		return $SiteDetails;
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
		S('URLDetails'.$site_id,$URLDetails);
	}

	/**
     * 更新EBAY所需的缓存
     * 
     */
	public function updateEbayCache(){
		$this->getSiteDetail();
	}

	/**
     * 更新EBAY所需的缓存
     * 
     */
	public function getTestToken(){
		//获取SITE_ID信息
		$res = $this->getEbayDetail('URLDetails');
		return $res->Ack=='Success' ? true : false;

	}

	/**
     * 生成Ebay计划任务文件
     * 
     */
	public function createEbaySystemTasksFile(){
		$file_name = $this->ebay_tasks_path.'ebay_'.$this->user_id.'.text';
		//if(!file_exists($file_name))
		{
			//交易数据
			$content .= C('CFG_URL').'index.php/EbaySeller/ajaxOldSale/time_type/minutes/from_time/90/site_id/'.$this->site_id.'/user_id/'.$this->user_id.'
';
		}
		file_put_contents($file_name,$content);
	}
	/**
     * 删除认证相关文件
     * 
     */
    public function deleteTokenFile(){
		$config_file = $this->ebay_token_path.$this->user_id.'-'.$this->site_id.'.php';
		$token_file  = $this->ebay_token_path.$this->user_id.'-'.$this->site_id.'.token';
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
		if ($res->TokenStatus->Status=='Active'){	 
			return 1;
        } else {
			$this->deleteFile();
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