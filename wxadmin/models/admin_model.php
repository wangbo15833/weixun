<?php
    /**
     * 登录
     */
    class Admin_model extends MY_Model {
        const TABLE ='admin';
        function __construct() {
            parent :: __construct();
        }

        /*
         * 增
         */

        /**
         * 添加管理员
         */
        function adduser($data){
            return $this->db->insert('admin', $data);
        }


        /*
         * 改
         */

        /**
         * 用户修改密码
         */
        function editUpdate($data){
            return $this->db->where(array('id'=>$data['id']))->update(self::TABLE, array('apwd'=>$data['apwd']));
        }

        /*
         * 变更用户类型
         */
        function editUser($id, $auth){
            return $this->db->where('id', $id)->update(self::TABLE, array('is_type'=>$auth));
        }

        /*
         * 审核管理员
         */
        function editshopUser($id, $status){
            return  $this->db->where('id',$id)->update('admin', array('is_status'=>$status));
        }

        /*
         * 审核管理员
         */
        function editadminUser($id, $status){
            return  $this->db->where('id',$id)->update(self::TABLE, array('is_status'=>$status));
        }


        /*
         * 查
         */

        /**
         * 按用户名、密码、会员类型、状态查找用户
         */
        public function login($data)
        {
           return  $this->db->where(array('aname'=>$data['aname'], 'apwd'=>$data['apwd'], 'is_type'=>$data['type'],'is_status' => 1))->get(self::TABLE)->result_array();
        }

        /**
         * 判断输入用户名原密码是否正确
         */

        function check_user($data){

            $sql = "select * from ". self::TABLE ." where id = ? and aname =? and apwd = ?";
            return $this->db->query($sql, array($data['id'], $data['aname'], $data['apwd']))->num_rows();

        }



         function get_user_info($data){
              return $this->db->where(array('is_status'=>1))->order_by('is_type','desc')->limit($data['limit'],$data['offset'] )->get(self::TABLE)->result_array();
         }

        function get_user_info_count(){
            return $this->db->where(array('is_status'=>1))->order_by('is_type','desc')->get(self::TABLE)->num_rows();
        }



        /*
         * 获取店铺管理员列表
         */
        function shopUserMananger($data){
            return $this->db->where('is_type',1)->order_by('createtime','desc')->get('admin', $data['limit'], $data['offset'])->result_array();
        }

        /*
         * 获取店铺管理员数量
         */

        function shopUserMananger_count(){
            return $this->db->where('is_type',1)->count_all_results('admin');
        }


        /**
         * 获取普通管员列表
         */
        function adminUserManager($data){
            return $this->db->where('is_type',2)->order_by('edittime','desc')->get('admin', $data['limit'], $data['offset'])->result_array();
        }

        /**
         * 获取普通管员数量
         */

        function adminUserManager_count(){
            return $this->db->count_all_results(self::TABLE);
        }


        /*
         * 按ID查询管理员信息
         */
        function  getUserinfoById($id){
            return $this->db->where(array('is_status'=>1,'id'=>$id))->get(self::TABLE)->result_array();
        }

    }
    
?>