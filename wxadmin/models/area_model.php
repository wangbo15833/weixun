<?php
/**
 * Created by JetBrains PhpStorm.
 * Author: Lynx
 * Date: 14-2-10
 * Time: 上午11:02
 * To change this template use File | Settings | File Templates.
 */

class Area_model extends MY_Model{
    function __construct() {
        parent :: __construct();
    }

    /*
     * 获取所有区县列表
     */
    function get_area_list(){
        return $this->db->get('area')->result_array();

    }

    /*
     * 按ID查询区县信息
     */

    function getAreaByID($data){
        return $this->db->where('id',$data)->get('area')->row_array();
    }

}