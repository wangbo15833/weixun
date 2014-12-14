<?php
/**
 * Created by JetBrains PhpStorm.
 * Author: Lynx
 * Date: 14-2-13
 * Time: 下午4:16
 * To change this template use File | Settings | File Templates.
 */


class Findjob_model extends MY_Model{
    const TABLE ='findjob';
    function __construct(){
        parent::__construct();
    }

    function add_findjob($data){
        return $this->db->insert(self::TABLE, $data);
    }

    function del_findjob($param){
        return $this->db->where('id',$param)->delete(self::TABLE);
    }
}