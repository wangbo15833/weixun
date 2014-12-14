<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Lynx
 * Date: 14-1-31
 * Time: 下午8:36
 * To change this template use File | Settings | File Templates.
 */

class User_model extends MY_Model {
    function __construct(){
        parent::__construct();
    }


    function check_user($data){
        //    $this->db->where(array('username'=>$data['username'])) ->or_where('email',$data['username']);
        //    return $this->db->where('password',$data['password'])->get(self::USER)->row_array();
        $sql = 'select u.*,um.nickname as nickname from user as u  left join  user_material as um  on u.id = um.uid  where  (u.username  = "'.$data['username'].'" or u.email ="'.$data['username'] .'") and u.password="'.$data['password'].'"';
        return $this->db->query($sql)->row_array();
    }

    /**
     * 根据uid获取用户信息
     *
     */
    function get_user_id($id){
        //return $this->db->where('id',$id)->get(self::USER)->row_array();
        $sql = 'select u.*,um.nickname as nickname from user as u left join user_material as um on u.id = um.uid  where u.id="'.$id.'"';
        return $this->db->query($sql)->row_array();
    }

    /**
     * @param $data
     * @return mixed
     */
    function add_user($data){
        $this->db->insert('user',$data);
        return $this->db->insert_id();
    }

    /**
     * @param $data
     * @return mixed
     */
    function  edit_user($data){
        $this->db->where(array('email'=>$data['email']))->update('user',array('password'=>$data['password'],'last_ip'=>$data['last_ip'],'l_time'=>$data['l_time']));
        return  $this->db->where(array('email'=>$data['email']))->get('user')->row_array();
    }

    function  check_email($ename){
        return  $this->db->where('email',$ename)->get('user')->num_rows();
    }


    /**
     * 根据uid获取商铺信息
     */
    function get_shops_user($s_uid){
        return $this->db->where(array('id'=> $s_uid, 'is_status' =>1))->get('user')->row_array();
    }

    /**
     * 修改用户密码
     */
    function edit_user_pwd($param){
        $data = array(
            'password' => $param['resetpassword']
        );
        $this->db->where('password', $param['password']);
        $this->db->where('id', $param['userid']);
        return $this->db->update('user', $data);
    }


    function get_user_info($uid){
        $sql = ' select u.id as u_uid ,u.*,m.* from user as u  left join  user_material as m  on u.id = m.uid where u.id ='.$uid;
        return $this->db->query($sql)->row_array();
    }


    /**
     * 更新用户基本信息
     */
    function  edit_user_base($param){
        $row_num =  $this->db->where('uid',$param['currentUserSign'])->get('user_material')->num_rows();
        $data = array(
            'nickname' => $param['userNickName'],
            'sex' => $param['userSex'],
            'address' => $param['userCityName'],
            'present' => $param['userSign'],
            'tel' => $param['userTelName'],
            'email' => $param['userEmailName']
        );
        if($row_num > 0){
            $this->db->where('uid', $param['currentUserSign']);
            return $this->db->update('user_material', $data);
        }else{
            $data['uid'] = $param['currentUserSign'];
            return $this->db->insert('user_material', $data);
        }
    }

    /**
     * 更新用户详细信息
     */
    function  edit_user_detail($param){
        $row_num =  $this->db->where('uid',$param['userid'])->get('user_material')->num_rows();
        $data = array(
            'weight' => $param['weight'],
            'loveStatus' => $param['loveStatus'],
            'birthday' => $param['datepicker'],
            'constellation' => $param['select_Constellation'],
            'userQQ' => $param['userQQ'],
            'isQQPublic' => $param['isQQPublic'],
            'job' => $param['job'],
            'university' => $param['university'],
            'middleSchool' => $param['middleSchool'],
            'userHomePage' => $param['userHomePage'],
            'interest' => $param['interest']
        );
        if($row_num > 0){
            $this->db->where('uid', $param['userid']);
            return $this->db->update('user_material', $data);
        }else{
            $data['uid'] = $param['userid'];
            return $this->db->insert('user_material', $data);
        }
    }

    /**
     * 更新用户头像
     */
    function  edit_user_face($param){
        $row_num =  $this->db->where('uid',$param['currentUserSign'])->get('user_material')->num_rows();
        $data = array(
            'picture' => $param['face'],
        );
        if($row_num > 0){
            $this->db->where('uid', $param['currentUserSign']);
            return $this->db->update('user_material', $data);
        }else{
            $data['uid'] = $param['currentUserSign'];
            return $this->db->insert('user_material', $data);
        }
    }
}