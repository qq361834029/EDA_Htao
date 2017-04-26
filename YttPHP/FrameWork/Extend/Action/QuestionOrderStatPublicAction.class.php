<?php
/**
 * 问题订单统计表
 * @author lxt 2015.06.09
 *
 */
class QuestionOrderStatPublicAction extends RelationCommonAction{
    
    public function _autoIndex($temp_file=null){
        $this->action_name = ACTION_NAME;
        $model			   = $this->getModel();
        $list			   = $model->index();
        //问题占比
        foreach ($list['list'] as &$row){
            $row['rate']    =   ($row['rate']>0&&$row['rate']<0.01)?(0.01."%"):(round($row['rate'],2)."%");
        }
        $this->assign("list",$list);
        $this->displayIndex();
    }
    
}