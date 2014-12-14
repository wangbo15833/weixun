<?php
/**
 * @author gefc
 * @version 1.0
 * @desc 商品相关函数
 */
    class Commodity_model extends MY_Model{
        const COMMODITY="commodity";
        function __construct(){
            parent::__construct();
        }
        
        /*
         * 添加新商品
         */
        public function addCommodity($data)
        {
            $this->db->add(self::COMMODITY,$data);
        }
        
        /**
         * 按规则获取商品信息
         * 
         */
         function getCommodity($data){
             if(isset($data['shops_id'])){
                 $this->db->where(array('type'=>$data['shops_id']));
             }
             return $this->db->where(array('is_status'=>$data['is_status']))->get(self::COMMODITY,$data['limit'],$data['offset']);
         }
         
         /*
          * 更新商品审核状态 
          */
          public function editCommodity($data){
              return $this->db->update(self::COMMODITY, array('is_status'=>$data['is_status']));
          }
          
    }
?>