<?php
/**
 * CommonModel
 * @copyright   Copyright (c) 2006 - 2010 YTT 展联软件友拓通
 * @category   	账目信息
 * @package  	Model
 * @author    	何剑波
 * @version 	2.1,2012-07-22
 */
class CommonModel extends Model {

	/// 获取当前用户的ID
    public function getMemberId() {
        return isset($_SESSION[C('USER_AUTH_KEY')])?$_SESSION[C('USER_AUTH_KEY')]:0;
    }
 
   /**
    * 根据条件禁用表数据
    *
    * @param array $options
    * @param string $field
    * @return boolen
    */
    public function forbid($options,$field='status'){ 
        if(FALSE === $this->where($options)->setField($field,0)){
            $this->error =  L('_OPERATION_WRONG_');
            return false;
        }else {
            return True;
        }
    }
 
	/**
	 * 根据条件批准表数据
	 *
	 * @param array $options
	 * @param string $field
	 * @return boolen
	 */
    public function checkPass($options,$field='status'){
        if(FALSE === $this->where($options)->setField($field,1)){
            $this->error =  L('_OPERATION_WRONG_');
            return false;
        }else {
            return True;
        }
    }
 
    /**
     * 根据条件恢复表数据
     *
     * @param array $options
     * @param string $field
     * @return boolen
     */
    public function resume($options,$field='status'){
        if(FALSE === $this->where($options)->setField($field,1)){
            $this->error =  L('_OPERATION_WRONG_');
            return false;
        }else {
            return True;
        }
    }
 
    /**
     * 根据条件恢复表数据
     *
     * @param array $options
     * @param string $field
     * @return boolen
     */
    public function recycle($options,$field='status'){
        if(FALSE === $this->where($options)->setField($field,0)){
            $this->error =  L('_OPERATION_WRONG_');
            return false;
        }else {
            return True;
        }
    }

    /**
     * recommend
     *
     * @param array $options
     * @param string $field
     * @return array
     */
    public function recommend($options,$field='is_recommend'){
        if(FALSE === $this->where($options)->setField($field,1)){
            $this->error =  L('_OPERATION_WRONG_');
            return false;
        }else {
            return True;
        }
    }

    /**
     * unrecommend
     *
     * @param array $options
     * @param string $field
     * @return array
     */
    public function unrecommend($options,$field='is_recommend'){
        if(FALSE === $this->where($options)->setField($field,0)){
            $this->error =  L('_OPERATION_WRONG_');
            return false;
        }else {
            return True;
        }
    }
}
?>