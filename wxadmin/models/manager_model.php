<?php
    /**
     * 管理各函数model
     */
    class Manager_model extends MY_Model {
        const SHOPS="shops";
        const CATEGORY = "category";
        const COMMODITY ="commodity";
        const PREFERENTIAL="preferential";
        const ADMIN = "user";
        const USERS = "user";
        const GOODS_CATEGORY = "goods_category";
        const AD = 'ad';
        const DISTRICT="district";
		const BASE_CATEGORY='base_category';
		const WPOSITION='wposition';

        
        public function get_district_id($value=1)
        {
            if($value == 1){
                return $this->db->where('area_id',13)->get(self::DISTRICT)->result_array();
            }else if($value == 13){
                return $this->db->where('area_id',1303)->get(self::DISTRICT)->result_array();
            }else if($value == 1303){
                return $this->db->where('parent_id',$value)->get(self::DISTRICT)->result_array();
            }
            //return $this->db->where('parent_id',$value)->get(self::DISTRICT)->result_array();
        }



         public function getShopsUser($keys='')
         {
           //  $this->db->where(array('is_type'=>1,'is_status'=>1))->order_by('edittime','desc')->select(array('id','aname'));
           //  if($keys)
           //  $this->db->or_like(array('aname'=>$keys,'id'=>$keys));
          //   $list = $this->db->get(self::ADMIN, 10)->result_array();
            $list =  $this->db->query("select aname,id from service where is_type=1 and is_status =1 and (aname like '%".$keys."%' or id like '%".$keys."%')")->result_array();
             return $list;
         }
         

         /**
         * 管理打折信息
         */
         function perferentialManager($data){
             return $this->db->order_by('datetime','desc')->get(self::PREFERENTIAL, $data['limit'], $data['offset'])->result_array();
         }
         
         function perferentialManager_count(){
             return $this->db->count_all(self::PREFERENTIAL);
         }
         
         function editperferential($id, $status){
              return  $this->db->where('id',$id)->update(self::PREFERENTIAL, array('is_status'=>$status));
         }

    }
    
?>