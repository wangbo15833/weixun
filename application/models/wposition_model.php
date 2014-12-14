<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Lynx
 * Date: 14-2-9
 * Time: 下午4:09
 * To change this template use File | Settings | File Templates.
 */

class Wposition_model extends MY_Model {
    function __construct() {
        parent :: __construct();

    }

    /*
     * 获取Level1职位列表
     */

    function getPositionList(){
        return $this->db->get('wposition1')->result_array();
    }


    /*
     * 按父ID查询Level2职位列表
     */
    function getPositionByPid($value=0)
    {
        return $this->db->where('pid',$value)->get('wposition2')->result_array();
    }

    /*
     * 按ID获取职位信息
     */
    function getPositionByID($data){
        return	$this->db->where('id',$data)->get('wposition1')->row_array();
    }

}