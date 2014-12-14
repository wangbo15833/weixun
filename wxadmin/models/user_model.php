<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Administrator
 * Date: 14-2-9
 * Time: 下午1:51
 * To change this template use File | Settings | File Templates.
 */

class User_model extends MY_Model{
    function __construct() {
        parent :: __construct();

    }

    /**
     * 管理网站会员
     */
    function userManager($data){
        return $this->db->order_by('l_time','desc')->get('user', $data['limit'], $data['offset'])->result_array();
    }

    function userManager_count(){
        return $this->db->count_all_results('user');
    }

    function editUser($id, $status){
        return  $this->db->where('id',$id)->update('user', array('is_status'=>$status));
    }
}