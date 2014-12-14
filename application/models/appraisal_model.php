<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Lynx
 * Date: 14-1-31
 * Time: 下午8:19
 * To change this template use File | Settings | File Templates.
 */
class Appraisal_model extends MY_Model{
    function __construct(){
        parent::__construct();
    }

    function add_appraisal($data){
        return $this->db->insert('appraisal', $data);
    }

    function get_appraisal_list($param){
        return $this->db->where(array('commented_id'=>$param['id'], 'c_id'=> $param['cid']))->get('appraisal')->result_array();
    }
}