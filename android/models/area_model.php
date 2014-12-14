<?php
/**
 * Created by JetBrains PhpStorm.
 * Author: Lynx
 * Date: 14-3-28
 * Time: 上午9:42
 * To change this template use File | Settings | File Templates.
 */

class Area_model extends MY_Model{
    function __construct(){
        parent :: __construct();
    }
    function get_area_list(){
        return $this->db->get('area')->result_array();

    }
}