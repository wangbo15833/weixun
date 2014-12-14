<?php
/**
 * Created by JetBrains PhpStorm.
 * Author: Lynx
 * Date: 14-4-28
 * Time: 下午3:03
 * To change this template use File | Settings | File Templates.
 */

class Luck_model extends MY_Model{
    function __construct(){
        parent::__construct();
    }

    function luckAdd($data){
        return $this->db->insert('luck', $data);
    }

    function getLuckByShopID($shopid){
        return $this->db->where(array('shopid'=>$shopid))->get('luck')->result_array();
    }

    function detail($lid){
        //$sql="SELECT * from shops WHERE shopid=".$shopid;
        return $this->db->where(array('id'=>$lid))->get('luck')->row_array();
    }

    function saveLuckers($luckid,$luckers){
        return $this->db->where(array('id'=>$luckid))->update('luck',array('luckers'=>$luckers,'isLocked'=>1));


    }

}