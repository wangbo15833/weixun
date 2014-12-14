<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Administrator
 * Date: 13-9-12
 * Time: 上午10:59
 * To change this template use File | Settings | File Templates.
 */

class Find_model extends MY_Model {
    const FIND = 'find';
    const BASECATEGORY = 'base_category';
    function __construct(){
        parent::__construct();
    }

    function get_category($channelid){
        $sql = "select * from ".self::BASECATEGORY ." WHERE channel_id =".$channelid;
        return $this->db->query($sql)->result_array();
    }

    /**
     * @param $param
     * @return array
     */
    function get_findList($param){
        $sql = "select * from ".self::FIND." where state = 1 limit ".$param['offset'].",".$param['limit'];
        return $this->db->query($sql)->result_array();
    }

    /**
     * @param $param
     * @return mixed
     */
    function get_findList_count($param){
        $sql = "select * from ".self::FIND." where state = 1";
        return $this->db->query($sql)->num_rows();
    }

    /**
     * @param $param
     * @return mixed
     */
    function add_findList($param){
        if($this->db->insert(self::FIND,$param)){
            return true;
        }else
            return false;
    }

    /**
     * @param $param
     * @return mixed
     */
    function del_findList($param){
       $rel =  $this->db->where(array('id'=> $param))->delete(self::FIND);
       return $rel? true: false;
    }

    function get_showfind($param){
        $rel = $this->db->where('id',$param)->get(self::FIND)->result_array();
        return $rel;
    }

    /**
     * @param $param
     * @return mixed
     */
    function edit_findList($param){
        $data = array('type_id'=>$param['type_id'],
                    'channel_id'=>$param['channel_id'],
                    'area_id'=>$param['area_id'],
            'name'=>$param['name'],'photo_url'=>$param['photo_url'],
            'dateline'=>$param['dateline'],'state'=>$param['state']);
       $bool = $this->db->where(array('id'=>$param['id']))->update(self::FIND, $data);
        return $bool ? true : false;
    }
}