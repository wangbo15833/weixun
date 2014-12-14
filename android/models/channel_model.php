<?php
/**
 * Created by JetBrains PhpStorm.
 * Author: Lynx
 * Date: 14-3-28
 * Time: 上午9:11
 * To change this template use File | Settings | File Templates.
 */

class Channel_model extends MY_Model {
    function __construct(){
        parent::__construct();
    }

    /**
     * 获取所有分类
     */
    function getChannel(){
        return $this->db->where(array('is_status'=>1))->get('channel')->result_array();
    }

}