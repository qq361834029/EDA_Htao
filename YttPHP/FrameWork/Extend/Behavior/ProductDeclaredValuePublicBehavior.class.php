<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class ProductDeclaredValuePublicBehavior extends Behavior {
    public function run(&$params) {
        $mo  = M('product_detail');
        $data   = array();
        foreach ($params['detail'] as $key=>$val) {
            if (!empty($val['product_id'])) {
                $rs = $mo->field('id')->where('properties_id='.C('DECLARED_VALUE').' and product_id='.$val['product_id'])->find();
                if(!empty($rs)){
                    $data['value']  = $val['declared_value'];
                    $data['id']     = $rs['id'];
                    $mo->save($data);
                }else{
                    $add_arr[]  = array(
                        'product_id'    => $val['product_id'],
                        'properties_id' => C('DECLARED_VALUE'),
                        'value'         => $val['declared_value'],
                    );
                }
            }
        }
        if(!empty($add_arr)){
            $mo->addAll($add_arr);
        }
    }

}
