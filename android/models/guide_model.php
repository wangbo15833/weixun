<?php
/**
 * Created by JetBrains PhpStorm.
 * Author: Lynx
 * Date: 14-3-28
 * Time: 上午9:42
 * To change this template use File | Settings | File Templates.
 */

class Guide_model extends MY_Model{
    function __construct(){
        parent :: __construct();
    }
    function get_guide_list(){
        return $this->db->get('guide')->result_array();

    }
}