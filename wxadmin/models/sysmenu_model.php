<?php
/**
 * Created by JetBrains PhpStorm.
 * Author: Lynx
 * Date: 14-2-9
 * Time: 下午4:34
 * To change this template use File | Settings | File Templates.
 */

class Sysmenu_model extends MY_Model{
    function __construct() {
        parent :: __construct();
    }


    function get_wdPublic($type){
        $sql = " select * from sysmenu where is_state = 1 and (is_type = ? or is_type = 0) order by sort ";
        return $this->db->query($sql, array($type))->result_array();
    }

    function getD(){
        //->where('is_state' ,1)
        return $this->db->get('sysmenu')->result_array();
    }

    function delD($id, $state){
        $state = $state == 0 ? 1 : 0;
        return $this->db->where('id', $id)->update('sysmenu', array('is_state'=> $state));
    }

    function addD($data) {
        return $this->db->insert('sysmenu', $data);
    }

}