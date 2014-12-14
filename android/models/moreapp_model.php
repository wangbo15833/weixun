<?php
/**
 * Created by JetBrains PhpStorm.
 * Author: Lynx
 * Date: 14-3-28
 * Time: 下午1:30
 * To change this template use File | Settings | File Templates.
 */


class Moreapp_model extends MY_Model{
    function __construct(){
        parent :: __construct();
    }
    function getMoreApp(){
        return $this->db->get('moreapp')->result_array();

    }
}