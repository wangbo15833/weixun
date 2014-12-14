<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Administrator
 * Date: 14-2-9
 * Time: 上午10:04
 * To change this template use File | Settings | File Templates.
 */

class Types_model extends MY_Model{
    function __construct() {
        parent :: __construct();

    }

    function  getCategoryById($id){
        return $this->db->where(array('state'=>1 ,'id'=>$id))->get('types')->result_array();
    }

}

?>