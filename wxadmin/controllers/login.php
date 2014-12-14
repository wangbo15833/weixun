<?php
/**
 * 后台登陆
 * @author gefc
 * @date 20130426
 */
class Login extends MY_Controller
{
    function __construct()
    {
        parent :: __construct();
        $this->load->model('admin_model', 'madmin');
    }


    public function index()
    {


        if (parent::is_login()) {
            redirect("index/index");
        }
        else{
            $this->load->view("default/login");
        }
    }

    /**
     * 登陆
     */
    function checkin()
    {

        $aname = get_post('lname') ? htmlspecialchars(get_post('lname')) : '';
        $apwd = get_post('lpwd') ? htmlspecialchars(get_post('lpwd')) : '';
        $apwd =  sysAuthCode($apwd);
        $rdotype = get_post('rdotype') ? get_post('rdotype') : 1;
        $data = array('aname' => $aname, 'apwd' => $apwd, 'type' => $rdotype);
        $larray = $this->madmin->login($data);
        if ($larray != null) {
            $this->session->set_userdata('logininfo', $larray);
            redirect('index');
        }

        else{

            //失败返回登录页
            if ($aname != '' || $apwd != '') {
                show_error('输入用户名、密码错误或者无登陆权限！请核准后重新输入。。。
                        倒计时<span id="totalSecond">5</span>秒<a href="' . WEB_URL . 'login">点击返回</a>

                        <script language="javascript" type="text/javascript">
                        varsecond=document.getElementById("totalSecond").textContent;

                        if(navigator.appName.indexOf("Explorer")>-1)
                        {
                        second=document.getElementById("totalSecond").innerText;
                        }else
                        {
                        second=document.getElementById("totalSecond").textContent;
                        }
                        setInterval("redirect()",1000);
                        function redirect()
                        {
                        if(second<0)
                        {
                        location.href="' . WEB_URL . 'login";
                        }else
                        {
                            if(navigator.appName.indexOf("Explorer")>-1)
                            {
                                document.getElementById("totalSecond").innerText=second--;
                            }else
                            {
                                document.getElementById("totalSecond").textContent=second--;
                            }
                        }
                    }
                    </script>');
                //echo "<script>alert('输入用户名、密码错误或者无登陆权限！请核准后重新输入。。。');window.location.href='".WEB_URL."login';</script>";
                //redirect('login');
            } else
                $this->load->view('default/login');

        }


    }

    function logout()
    {
        parent::log_out();
    }

    /**
     * 跳转修改页
     */

}

?>