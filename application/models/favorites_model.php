<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Lynx
 * Date: 14-2-3
 * Time: 下午2:43
 * To change this template use File | Settings | File Templates.
 */
class Favorites_model extends MY_Model{
    function __construct(){
        parent :: __construct();
    }


    /**
     * 判断是否已收藏
     * @param $uid
     * @param $gid
     * @return mixed
     */
    function cx_sc($uid,$shopid, $type=0){
        return  $this->db->where(array('uid'=>$uid,'shopid'=>$shopid))->get('favorites')->num_rows();
    }

    function wdsc($uid){
        return $query=$this->db->where(array('uid'=>$uid))->get('favorites')->result_array();
    }


    function  get_sc_count($data){
        return $this->db->where(array('uid'=>$data['uid']))->count_all_results('favorites');
    }


    function get_sc_info($data){
        // $query_str = "select * from ".self::COLLECTION ." as col , ". self::COMMODITY ." as com where col.c_cid = com.id and col";
        return $this->db->where(array('uid'=>$data['uid']))->order_by('timeline', 'desc')
            ->limit($data['limit'], $data['offset'])->get('favorites')->result_array();
    }

    function del_sc($id){
        return $this->db->where(array('id'=>$id))->delete('favorites');
    }

    function add_sc($param){
        return $this->db->insert('favorites', $param);
    }

}