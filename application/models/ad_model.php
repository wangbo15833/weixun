<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Lynx
 * Date: 14-1-30
 * Time: 下午3:54
 * To change this template use File | Settings | File Templates.
 */

class Ad_model extends MY_Model{
    function __construct(){
        parent :: __construct();
    }

    /*
     * 获取审核通过的广告列表
     */

    function  get_add_info($type){
        $lists = $this->db->where(array('is_status'=>1,'type'=>$type))->get('ad')->result_array();
        return $lists;
    }

    function  getAdInfo($type, $site=1){
        $lists = $this->db->where(array('is_status'=>1,'type'=>$type, 'site' => $site))->get('ad')->result_array();
        return $lists;
    }

}