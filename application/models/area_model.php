<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Lynx
 * Date: 14-1-28
 * Time: 下午3:50
 * To change this template use File | Settings | File Templates.
 */
class Area_model extends MY_Model{
    function __construct(){
        parent :: __construct();
    }

    function get_area_list(){
            return $this->db->get('area')->result_array();

    }

    function get_areabyId($area_id){
        return $this->db->where('id',$area_id)->get('area')->row_array();
    }

    /*
 * 按ID查询区县信息
 */

    function getAreaByID($data){
        return $this->db->where('id',$data)->get('area')->row_array();
    }

    function get_areaname($data){
        return	$this->db->where('id',$data)->get('area')->row_array();
    }
}