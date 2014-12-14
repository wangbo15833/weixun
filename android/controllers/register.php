<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Lynx
 * Date: 14-2-10
 * Time: 下午8:37
 * To change this template use File | Settings | File Templates.
 */

class Register extends CI_Controller {

    function __construct(){
        parent :: __construct();
        $this->load->model('user_model','muser');
    }


    public function index()
    {
        $username = $this->input->get_post('user');
        $password= $this->input->get_post('pw');
        $password=sysAuthCode($password);
        $tel=$this->input->get_post('telephone');
        if(!$tel || !$username || !$password)
        {
            echo json_encode(array('status'=>2));
        }
        else{
            $data=array('username'=>$username,'password'=>$password,'tel'=>$tel);
            $this->muser->add_user($data);
            echo json_encode(array('status'=>0));

        }


    }
}