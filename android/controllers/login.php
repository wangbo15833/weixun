<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Administrator
 * Date: 13-5-20
 * Time: 下午5:46
 * To change this template use File | Settings | File Templates.
 */

class Login extends  CI_Controller{

    function __construct(){
        parent :: __construct();
        $this->load->model('user_model','muser');

    }

    function index(){
        $username = $this->input->get_post('user');
        $password= $this->input->get_post('pw');
        $password=sysAuthCode($password);
        $data=array('username'=>$username,'password'=>$password);
        $user=$this->muser->check_user($data);

        echo json_encode(array($user));


    }


}