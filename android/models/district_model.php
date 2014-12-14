<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by JetBrains PhpStorm.
 * Author: Lynx
 * Date: 14-4-1
 * Time: 上午9:44
 * To change this template use File | Settings | File Templates.
 */

class District_model extends MY_Model{
    function __construct(){
        parent :: __construct();
    }
    function districtAdd($param){
        return $this->db->insert('district', $param);

    }

    function get_district_list(){
        return $this->db->get('district')->result_array();

    }

    function getDistrictByPid($pid){
        return $this->db->where(array('parentid'=>$pid))->get('district')->result_array();
    }
}