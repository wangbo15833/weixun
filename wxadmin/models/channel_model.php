<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Lynx
 * Date: 14-2-6
 * Time: 下午8:11
 * To change this template use File | Settings | File Templates.
 */
class Channel_model extends MY_Model {

    function __construct() {
        parent :: __construct();
    }

    /*
     * 获取所有审核通过的频道列表
     */
    public function getChannel($value = 0)
    {
        return $this->db->where(array('is_status'=>1))->get('channel')->result_array();
    }

    /*
     *按ID查询频道信息
     */

    function getChannelById($cid){
        return $this->db->where('id',$cid)->get('channel')->result_array();
    }
}