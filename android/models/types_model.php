<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Lynx
 * Date: 14-1-29
 * Time: 下午9:42
 * To change this template use File | Settings | File Templates.
 */

class Types_model extends MY_Model{
    function getTypes($cid){
        return $this->db->where(array('channelid'=>$cid,'state'=>1))->get('types')->result_array();
    }
}