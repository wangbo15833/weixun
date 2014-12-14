<?php
/**
 * Created by JetBrains PhpStorm.
 * Author: Lynx
 * Date: 14-2-28
 * Time: 下午4:25
 * To change this template use File | Settings | File Templates.
 */

class Ordermeal_model extends MY_Model {
    function __construct(){
        parent::__construct();
    }

    function add_ordermeal($data){
        $this->db->insert('order_meal',$data);
        return $this->db->insert_id();

    }

    function del_ordermeal($data){
        return $this->db->where(array('id'=>$data['id']))->delete('order_meal');
    }

    function getOrderByUser($data){
        $sql="select om.id AS id,username,title,pubtime,num from order_meal om left join user u on om.userid=u.id left join goods g on om.goodsid=g.id where userid =".$data;
        return $this->db->query($sql)->result_array();
    }
}