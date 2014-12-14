<?php
/**
 * Created by JetBrains PhpStorm.
 * Author: Lynx
 * Date: 14-4-1
 * Time: 上午10:54
 * To change this template use File | Settings | File Templates.
 */

class District_model extends MY_Model{
    function __construct(){
        parent :: __construct();
    }
    function getDistrictByPid($pid){
        return $this->db->where('parentid',$pid)->get('district')->result_array();
    }
    function  getDistrictByDid($did){
        return $this->db->where(array('did'=>$did))->get('district')->row_array();
    }

}