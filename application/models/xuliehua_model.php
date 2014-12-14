<?php
/**
 * Created by JetBrains PhpStorm.
 * Author: Lynx
 * Date: 14-2-15
 * Time: 下午4:28
 * To change this template use File | Settings | File Templates.
 * 本工具用于批量修改数据库中非序列号的photo字段，用完可删
 */
class Xuliehua_model extends MY_Model {
    function __construct() {
        parent :: __construct();

    }
    function getlist(){
        $sql="select * from goods where photo not like 's:4:%'";
        return $this->db->query($sql)->result_array();
    }

    function update($data){
        $this->db->where(array('id'=>$data['id']))->update('goods',array('photo'=>"s:0:\"\";"));
    }
}