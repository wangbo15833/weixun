<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Lynx
 * Date: 14-1-31
 * Time: 下午8:19
 * To change this template use File | Settings | File Templates.
 */
class Comment_model extends MY_Model{
    function __construct(){
        parent::__construct();
    }

    function add_comment($data){
        return $this->db->insert('comments', $data);
    }

    function get_comment_list($param){
        return $this->db->where(array('shop_id'=>$param['shopid']))->get('comments')->result_array();
    }
}