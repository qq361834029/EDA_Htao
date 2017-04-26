<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2009 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
// $Id: Page.class.php 2601 2012-01-15 04:59:14Z liu21st $

class Page {
    // 分页栏每页显示的页数
    public $rollPage = 5;
    // 页数跳转时要带的参数
    public $parameter  ;
    // 默认列表每页显示行数
    public $listRows = 20;
    // 起始行数
    public $firstRow	;
    // 分页总页面数
    protected $totalPages  ;
    // 总行数
    protected $totalRows  ;
    // 当前页数
    protected $nowPage    ;
    // 分页的栏的总页数
    protected $coolPages   ;
    // 分页显示定制
    protected $config  =	array('header'=>'条记录','prev'=>'上一页','next'=>'下一页','first'=>'首页','last'=>'末页','up'=>'上','down'=>'下','page'=>'页','theme'=>' %totalRow% %header% %nowPage%/%totalPage% 页 %first% %upPage% %downPage% %end% %jump%');

    /**
     +----------------------------------------------------------
     * 架构函数
     +----------------------------------------------------------
     * @access public
     +----------------------------------------------------------
     * @param array $totalRows  总的记录数
     * @param array $listRows  每页显示记录数
     * @param array $parameter  分页跳转的参数
     +----------------------------------------------------------
     */
    public function __construct($totalRows,$listRows='',$parameter='') {
        $this->totalRows = $totalRows;
        $this->parameter = $parameter;
        if(!empty($listRows)) {
            $this->listRows = intval($listRows);
        }elseif (C('line_number')>0){
        	$this->listRows = C('line_number');
        }
        
        $this->totalPages = ceil($this->totalRows/$this->listRows);     //总页数
        $this->coolPages  = ceil($this->totalPages/$this->rollPage);  
        $this->nowPage    = !empty($_REQUEST[C('VAR_PAGE')])?intval($_REQUEST[C('VAR_PAGE')]):1; 
        if(!empty($this->totalPages) && $this->nowPage>$this->totalPages) {
            $this->nowPage = $this->totalPages;
        }
        $this->firstRow = $this->listRows*($this->nowPage-1);
    }

    public function setConfig($name,$value) {
        if(isset($this->config[$name])) {
            $this->config[$name]    =   $value;
        }
    }
	
	public function getPageInfo() {
        return array(
					'firstRow'		=> $this->firstRow,
					'listRows'		=> $this->listRows,
					'totalRows'		=> $this->totalRows,
					'nowPage'		=> $this->nowPage,
					'totalPages'	=> $this->totalPages,
				);
    }

    /**
     +----------------------------------------------------------
     * 分页显示输出
     +----------------------------------------------------------
     * @access public
     +----------------------------------------------------------
     */
    public function show() {
        if(0 == $this->totalRows) return ''; 
        $p = C('VAR_PAGE')?C('VAR_PAGE'):'p';
        $nowCoolPage      = ceil($this->nowPage/$this->rollPage);
        $url  =  $_SERVER['REQUEST_URI'].(strpos($_SERVER['REQUEST_URI'],'?')?'':"?").$this->parameter;
        $parse = parse_url($url);
        if(isset($parse['query'])) {
            parse_str($parse['query'],$params);
            unset($params[$p]);
            $url   =  $parse['path'].'?'.http_build_query($params);
        }
        //上下翻页字符串
        $upRow   = $this->nowPage-1;
        $downRow = $this->nowPage+1;
        if ($upRow>0){
            $upPage="<a onclick='nextPage($upRow)'>".$this->config['prev']."</a>";
//            $upPage="<a href='".$url."&".$p."=$upRow'>".$this->config['prev']."</a>";
        }else{
            $upPage="";
        }

        if ($downRow <= $this->totalPages){
            $downPage="<a  onclick='nextPage($downRow)'>".$this->config['next']."</a>";
        }else{
            $downPage="";
        }
        // << < > >>
		if($this->nowPage > 1){
            $theFirst = "<a onclick='nextPage(1)' >".$this->config['first']."</a>";
        }
        if($nowCoolPage == 1){
            $prePage = "";
        }else{
            $preRow =  $this->nowPage-$this->rollPage;
            $prePage = "<a onclick='nextPage($preRow)' >上".$this->rollPage."页</a>";
        }
        if($nowCoolPage == $this->coolPages){
            $nextPage = "";
            $theEnd="";
        }else{
            $nextRow = $this->nowPage+$this->rollPage;
            $theEndRow = $this->totalPages;
            $nextPage = "<a onclick='nextPage($nextRow)' >下".$this->rollPage."页</a>";
            $theEnd = "<a onclick='nextPage($theEndRow)' >".$this->config['last']."</a>";
            
        }
        // 1 2 3 4 5
        $linkPage = "";
        for($i=1;$i<=$this->rollPage;$i++){
            $page=($nowCoolPage-1)*$this->rollPage+$i;
            if($page!=$this->nowPage){
                if($page<=$this->totalPages){
                    $linkPage .= "&nbsp;<a href='".$url."&".$p."=$page'>&nbsp;".$page."&nbsp;</a>";
                }else{
                    break;
                }
            }else{
                if($this->totalPages != 1){
                    $linkPage .= "&nbsp;<span class='current'>".$page."</span>";
                }
            }
        }
        $jumpPage = '<input type="text" id="page_no" value="'.$this->nowPage.'" class="pageno_input"><input type="button" class="pageno_go" value="GO" onclick="goPage()">';
        $pageStr	 =	 str_replace(
            array('%header%','%nowPage%','%totalRow%','%totalPage%','%upPage%','%downPage%','%first%','%prePage%','%linkPage%','%nextPage%','%end%','%jump%'),
            array($this->config['header'],$this->nowPage,$this->totalRows,$this->totalPages,$upPage,$downPage,$theFirst,$prePage,$linkPage,$nextPage,$theEnd,$jumpPage),$this->config['theme']);
        //在没有查询框的情况下 需要用到当前页--用smarty创建一个隐藏查询框  zmx-2012-09-27
        $view       = Think::instance('View');
		$view->assign ( 'nowPage', $this->nowPage );//edit yyh 20150917 原第一个DIV高度height:30px;
        return '<div id="_page_qtp" class="page_toolbar"> <div style="position:fixed; bottom:33px;overflow:auto; left:0;width:100%;height:0px;"></div><div class="page">'.$pageStr.'</div></div>'; 
    }

}