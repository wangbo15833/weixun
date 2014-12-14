<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Lynx
 * Date: 14-2-9
 * Time: 上午9:01
 * To change this template use File | Settings | File Templates.
 */

class Ad_model extends MY_Model{
    function __construct() {
        parent :: __construct();

    }

    /*
     * 添加广告
     * */
    function  addAdInfo($data){
        return $this->db->insert('ad', $data);
    }

    /*
     * 获得所有广告列表
     */

    function  getAdInfo(){
        return $this->db->get('ad')->result_array();
    }

    /*
     * 审核广告
     */

    function editAd($id, $is_status){
        return  $this->db->where('id',$id)->update('ad', array('is_status'=>$is_status));
    }
}