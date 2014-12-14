<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Administrator
 * Date: 13-5-20
 * Time: 下午5:46
 * To change this template use File | Settings | File Templates.
 */

class Login extends  MY_Controller{

    function __construct(){
        parent :: __construct();
        $this->load->model('index_model','m_index');
        $this->load->model('user_model','muser');

    }

    function setpwd(){
        echo sysAuthCode('666666');
    }
    function check_captcha(){
        $uuid = $this->input->get_post('hid_uuid');
        $captcha = $this->input->get_post('captcha');
        //获取验证码内容用于比对
        $sess_uuid = $this->session->userdata($uuid);
        $email = $this->input->get_post('email');
        $password = $this->input->get_post('password');
        $param['username'] = $email;
        $param['password'] = sysAuthCode($password);

        $users = $this->muser->check_user($param);
        if(strtolower($sess_uuid) != strtolower($captcha)){
            echo json_encode(array('state'=>1));
        }elseif(count($users) == 0){
            echo json_encode(array('state'=>2));
        }else{
            echo json_encode(array('state'=>3));
        }
    }

    function index(){
        $uuid = $this->input->get_post('hid_uuid');
        if(!$uuid){
            $bUrl = $this->input->get_post('burl');
            $this->load->view(THEME_STYLE.'/login',array('type'=>100,'requestUrl'=>$bUrl));
        }else{
            $requestUrl = $this->input->get_post('requestUrl');
            $email = $this->input->get_post('email');
            $password = $this->input->get_post('password');

            if(!$email || !$password) show_error("用户名、密码不能为空；");

            $autologin = $this->input->get_post('autologin');
            $remember_username = $this->input->get_post('remember_username');

            $param['username'] = $email;
            $param['password'] = sysAuthCode($password);
            $users = $this->muser->check_user($param);
            if(count($users) > 0){
                if($autologin ==1){
                    $this->input->set_cookie('login_userid',$users['id'],self::COOHIE_TIME);
                }
                if($remember_username == 1){
                    $this->input->set_cookie('l_user',$email,self::COOHIE_TIME);
                    $this->input->set_cookie('l_pass',$password,self::COOHIE_TIME);
                }
                //删除验证码session
                $this->session->unset_userdata($uuid);
                $this->session->set_userdata('userinfo',$users);
                if(sysAuthCode($requestUrl,'DECODE')=='')
                    redirect('index');
                else
				    echo "<script>location.href='".sysAuthCode($requestUrl,'DECODE')."';</script>";
            }else{
                //登录失败
                $this->load->view('login',array('type'=>100));
            }
        }
    }

    function captcha(){
        $this->load->helper('captcha');
        $vals = array(
           // 'word' => 'Random word',
            'img_path' => './captcha/',
            'img_url' => base_url().'captcha/',
            'font_path' => base_url().'captcha/fonts/5.ttf',
            'img_width' => '80',
            'img_height' => 30,
            'expiration' => 5,
            'wordlen' =>4
        );
        $cap = create_captcha($vals);
        $uuid = get_uuid();
        $this->session->set_userdata($uuid,$cap['word']);
         echo json_encode(array('status'=>1,'data' =>$cap['image'],'uuid'=>$uuid,'test'=>$cap['word']));
    }

    function out_login(){
        $this->session->sess_destroy();
        delete_cookie('login_userid');
        redirect('index');
		//echo "<script>location.href='".WEB_URL."index';</script>";
    }

    function check_email(){
        $ename = $this->input->get_post('ename');
        $rel = $this->muser->check_email($ename);
        $data = array('status' => 1, 'data'=>$rel);
        echo json_encode($data);
    }

    function  register(){
        $uuid = $this->input->get_post('hid_uuid');
        if(!$uuid){
           // $areaList = $this->m_index->get_area();
           // var_dump($areaList);exit;
            $this->load->view(THEME_STYLE.'/register',array('areaList'=>''));
        }else{
            $email = $this->input->get_post('email');
            $username = $this->input->get_post('username');
            $password = $this->input->get_post('password');
            $password2 = $this->input->get_post('password2');
            $tel = $this->input->get_post('telephone');
            $city = $this->input->get_post('city');
            $captcha = $this->input->get_post('captcha');
            if(!$email || !$username || !$password || !$tel)show_error("不能为空！");
            if($password != $password2) show_error("二次密码输入有误！");
            /*没有判断用户名存在的情况*/
            //获取验证码内容用于比对
            $sess_uuid = $this->session->userdata($uuid);
            if(strtolower($sess_uuid) != strtolower($captcha)){
                show_error("验证码输入错误la！");
            }
            $data = array('username'=>$username,'tel'=>$tel,'password'=>sysAuthCode($password),'email'=>$email,'area'=>$city,'last_ip'=>$this->input->ip_address(), 'c_time'=>time(),'is_type'=>1);
            $users = $this->muser->add_user($data);
            if($users){
                $data['id'] = $users;
                //删除验证码session
                $this->session->unset_userdata($uuid);
                $this->session->set_userdata('userinfo',$data);
                redirect('index');
            }
        }
    }

    function resetreq(){
        $this->load->view('default/resetemail');
    }

    function reset(){
        $pass = $this->input->get_post('password');
        if(!$pass){
            $this->load->view('default/reset');
        }else{
            $param = $this->session->userdata('reset_email');
            $pass2 = sysAuthCode($this->input->get_post('password2'));
            if($pass != $pass2) show_error("2次密码输入不同！");
            $data = array('email'=>$param, 'password'=> sysAuthCode($pass),'last_ip'=>$this->input->ip_address(),'l_time'=>time());
            $rel = $this->muser->edit_user($data);
            $this->session->set_userdata('userinfo',$rel);
            redirect('index');
        }
    }

    function edit_pass(){
        if(!defined('USER_ID')) self::is_login();
        $param['password'] = $this->input->get_post('password') ?sysAuthCode(htmlspecialchars($this->input->get_post('password'))) :'';
        $param['resetpassword'] = $this->input->get_post('resetpassword') ? sysAuthCode(htmlspecialchars($this->input->get_post('resetpassword'))) :'';
        $param['userid'] = $this->input->get_post('userid') ? htmlspecialchars($this->input->get_post('userid')) :'';
        $myusers = $this->muser->edit_user_pwd($param);
        echo json_encode(array('state'=>1));
    }

    function sendEmail(){
        $uuid = $this->input->get_post('hid_uuid');
        $captcha = $this->input->get_post('captcha');
        $sess_uuid = $this->session->userdata($uuid);
        if(strtolower($sess_uuid) != strtolower($captcha)){
            show_error("验证码输入错误！");
        }
        $config = array(
            'crlf'          => "\r\n",
            'newline'       => "\r\n",
            'charset'       => 'utf-8',
            'protocol'      => 'smtp',
            'mailtype'      => 'text',
            'smtp_host' => 'smtp.qq.com',
            'smtp_port' => '25',
            'smtp_user' => '845932786@qq.com',
            'smtp_pass' => 'gfc2010ty'
        );
        $this->load->helper('email');
        $this->load->library('email',$config);
        $param_email = $this->input->get_post('email');
        if (!valid_email($param_email))
        {
            show_error("email 格式有误！");
        }
        $this->email->from('845932786@qq.com', 'Your Name');
        $this->email->to($param_email);
       // $this->email->cc('another@another-example.com');
       // $this->email->bcc('them@their-example.com');
        $this->email->subject(' 钱盒儿网重设密码');
        $this->email->mailtype='html';
        $message = " hi _".$param_email.",您在钱盒儿网申请了重设密码，请点击下面的链接，然后根据页面提示完成密码重设：".WEB_URL."login/reset
                                                                                                -- 钱盒儿网";
        $new_msg ="<div style='background:#fff;padding-bottom:20px;zoom:1;position:relative;z-index:1;' id='contentDiv0'>
            hi $param_email,<br><br>您在钱盒儿网申请了重设密码，请点击下面的链接，然后根据页面提示完成密码重设：<br><br><br>
            <a target='_blank' href='".WEB_URL."login/reset"."'>".WEB_URL."login/reset/".passport_encrypt($param_email,'key')."</a><br>
            <img width='1px' height='1px' style='border:none;vertical-align:top;' src='http://www.meituan.com/m.gif?mi=6a74d46'><br> -- <br>
                钱盒儿网</div>";
        $this->email->message($new_msg);
        $this->email->send();
        $this->session->set_userdata('reset_email',$param_email);
        //删除验证码session
        $this->session->unset_userdata($uuid);
        //echo $this->email->print_debugger();
        $this->load->view('default/resetreq',array('email'=>$param_email));

    }
}