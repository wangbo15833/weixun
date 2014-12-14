<?php

/**
 * model
 *
 * @author        gefc
 * @version       1.0
 */
class Common_model extends MY_Model
{
    const CATEGORY='category';
    function __construct(){
        parent :: __construct();
        
    }
    
    /**
     * 添加分类
     */
    function addType($array){
        $this->db->insert(self::CATEGORY,$array);
    }
    
    /**
     * 获取所有分类
     */
    function getType(){
        return $this->db->get(self::CATEGORY);
    }
    
    /**
     * 启用/关闭 分类
     */
     function editType($state=null){
         if(!$state) return false;
         return $this->db->update(self::CATEGORY, array('is_status' =>$state ));
     }
}
?>