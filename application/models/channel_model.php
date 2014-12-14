<?php

/**
 * model
 *
 * @author        gefc
 * @version       1.0
 */
class Channel_model extends MY_Model
{
    function __construct(){
        parent :: __construct();
        
    }
    
    /**
     * 添加分类
     */
    function addChannel($array){
        $this->db->insert('channel',$array);
    }
    
    /**
     * 获取所有分类
     */
    function getChannel(){
        return $this->db->where(array('is_status'=>1))->get('channel')->result_array();
    }
    
    /**
     * 启用/关闭 分类
     */
     function editChannel($state=null){
         if(!$state) return false;
         return $this->db->update('channel', array('is_status' =>$state ));
     }

    /**
     * 按ID查询分类
     */
    function getChannelByID($param){
        return $this->db->where(array('id'=>$param))->get('channel')->row_array();
    }
}
?>