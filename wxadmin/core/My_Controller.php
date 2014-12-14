<?php
    /**
     * 自定义控制器超类
     * @author gefc
     * @date 2013/04/22
     */
    class MY_Controller extends CI_Controller {
    protected $uid,$username="";
    const TOKEN_KEY = 'weixun_token';
    const PAGESIZE = 10;
        function __construct() {
            parent :: __construct();
            $this->load->library('session');
            $this->load->helper('common');
            define('DEFAULT_PIC',  'frontend/Public/images/bj.jpg');

            define('LIFT_CLICK',isset($_GET['cname'])?$_GET['cname'] : '');
            //判断是否登录 未登录跳转首页
            $this->checkLogin();
        }
        
        function checkLogin(){
            $user = $this->getsessinfo();
            $ci = &get_instance();
            if(!$user && $ci->router->fetch_class() !='login' && $ci->router->fetch_method()!='index'){                //
                redirect('login');
                return;
            }else{
                //获取用户登录信息
                if(!defined('UID'))define('UID', $user[0]['id']);
                if(!defined('UNAME'))define('UNAME', $user[0]['aname']);
                if(!defined('STATUS'))define('STATUS', $user[0]['is_type']);
                if(!defined('WEB_URL'))define('WEB_URL', base_url().'wxadmin.php/');
                //define('USERINFO', $user[0]);


                //if(!defined("PUBLIC_STR"))define('PUBLIC_STR', $public_str);
                //var_dump(PUBLIC_STR);exit;
                //$this->load->view('base',array('public_str'=>$public_str));
            }
        }

        
        /**
         * 判断是否登录
         * @author gefc
         * @return bool
         * 
         */
        function is_login(){
            $bool=$this->session->userdata('logininfo')  ? TRUE : FALSE;
            return $bool;
        }
        
        /**
         * 登出
         */
         public function log_out()
         {
             $this->session->sess_destroy();
             //$this->load->view('login');
             redirect('login/index');
         }
         
         /**
          * 获取登录信息
          */
          function  getsessinfo(){
              $sdata = $this->session->userdata('logininfo');
              return $sdata;
          }

        /**
         * 获取用户信息
         * @params uid
         * return userinfo
         */
       static  function  getUserinfoById($id = ''){
            if(!$id) return false;
           $ci = &get_instance();
           $ci->load->model('admin_model','madmin');
           $user = $ci->madmin->getUserinfoById($id);
           return $user;
        }
        /**
             * 生成一个当前的token
             * @param string $form_name
             * return string
             */
            public static function grante_token($form_name)
            {
                $ci = & get_instance();
                //$CI->load->library('session');
                $key = self::grante_key();
                $token = md5(substr(time(), 0, 3).$key.$form_name);
                $key = self::TOKEN_KEY.$form_name;
                $ci->session->set_userdata($key, $token);
                return $token;
            }

        /**
         * 验证一个当前的token
         * @param string $form_name
         * @return string
         */
            public static function is_token($form_name,$token)
            {
                $ci = & get_instance();
                $old_token = $ci->session->userdata(self::TOKEN_KEY.$form_name);
                if($old_token == $token)
                {
                    return true;
                } else {
                    return false;
                }
            }
         
            /**
             * 删除一个token
             * @param string $form_name
             * @return boolean
             */
            public static function drop_token($form_name)
            {
                $ci = & get_instance();
                $ci->session->unset_userdata(self::TOKEN_KEY.$form_name);
                return true;
            }
         
            /**
             * 生成一个密钥
             * @return string
             */
            public static function grante_key()
            {
                $encrypt_key = md5(((float) date("YmdHis") + rand(100,999)).rand(1000,9999));
                return $encrypt_key;
            }
            
             function web_url($url, $params){
                $myUrl = '';
                foreach($params as $key => $i){
                    if(!($myUrl))  $myUrl .= '?'.$key.'='.$i;
                    else $myUrl .= '&'.$key.'='.$i;
                }
               return  site_url($url.$myUrl);
            }
             
             /**
             * @param $page
             * @param $numTotle
             * @param string $url
             * @internal param string $type
             * @return string
             */
            function mkPage($page, $numTotle, $url = 'main')
            {
                $pageStr = '';
                if(!$numTotle)
                    return $pageStr;
                parse_str($_SERVER['QUERY_STRING'], $outArr);
                unset($outArr['page']);
                $pageNum = ceil($numTotle/self::PAGESIZE);
                $showPageNum = $pageNum >=3 ? 3 : $pageNum;
                $page = $page < $pageNum ? $page : $pageNum;
                //$pageUrl = function($page) use($outArr, $type){return site_url("{$type}",array_merge($outArr, array('page' => $page)));       };
                $pageUrl = function($page) use($outArr, $url){return MY_Controller::web_url("{$url}", array_merge($outArr, array('page' => $page)));       };
                //
                $i = $page;
                $current = "href='javascript:;' class='inte_nowpage'";
                if($page >= $pageNum)
                {
                    $i -= $showPageNum-1;
                    $showPageNum = 0;
    
                }
                elseif($page >1 && $page <$pageNum)
                {
                    $showPageNum = ($showPageNum - 1)/2;
                    $i -= $showPageNum;
                }
                else
                    $showPageNum--;
                for($i; $i <= $page + $showPageNum; $i++)
                {
                    if($page == $i)
                        $a = "href='javascript:;' class='inte_nowpage'";
                    else
                        $a = "href='{$pageUrl($i)}'";
                    $pageStr .= "<a  {$a} >{$i}</a>";
                }
                $prePage = $page-1 < 1 ? "<a href='javascript:;'>上一页</a>" : "<a href='{$pageUrl($page-1)}'>上一页</a>";
                $nextPage = $page+1 > $pageNum ? "<a href='javascript:;'>下一页</a>" : "<a href='{$pageUrl($page+1)}'>下一页</a>";
                return  $pageStr = "<a href='#'>{$page}/{$pageNum}</a><a href='{$pageUrl(1)}'>首页</a>{$prePage}{$pageStr}{$nextPage}<a href='{$pageUrl($pageNum)}'>尾页</a>";
            }

        function show_pic($pics)
        {
            //var_dump($pics);
            $new_pics = unserialize($pics);
            if (!$new_pics)
                return array(DEFAULT_PIC);
            else {
                $l_pics = explode(';', $new_pics);
                return  $l_pics;
                //return $new_pics;
            }
        }

        function _mkPage($page, $numTotle, $type = 'main')
        {
            $pageStr = '';
            if(!$numTotle)
                return $pageStr;
            parse_str($_SERVER['QUERY_STRING'], $outArr);
            unset($outArr['page']);
            $pageNum = ceil($numTotle/self::PAGESIZE);
            $showPageNum = $pageNum >=3 ? 3 : $pageNum;
            $page = $page < $pageNum ? $page : $pageNum;
            //$pageUrl = function($page) use($outArr, $type){return site_url("{$type}",array_merge($outArr, array('page' => $page)));       };
            $pageUrl = function($page) use($outArr, $type){return site_url("{$type}/".$page);       };
            $i = $page;
            $current = "href='javascript:;' class='inte_nowpage'";
            if($page >= $pageNum)
            {
                $i -= $showPageNum-1;
                $showPageNum = 0;

            }
            elseif($page >1 && $page <$pageNum)
            {
                $showPageNum = ($showPageNum - 1)/2;
                $i -= $showPageNum;
            }
            else
                $showPageNum--;
            for($i; $i <= $page + $showPageNum; $i++)
            {
                if($page == $i)
                    $a = "href='javascript:;' class='inte_nowpage'";
                else
                    $a = "href='{$pageUrl($i)}'";
                $pageStr .= "<a  {$a} >{$i}</a>";

            }
            $prePage = $page-1 < 1 ? "<a href='javascript:;'>上一页</a>" : "<a href='{$pageUrl($page-1)}'>上一页</a>";
            $nextPage = $page+1 > $pageNum ? "<a href='javascript:;'>下一页</a>" : "<a href='{$pageUrl($page+1)}'>下一页</a>";
            return  $pageStr = "<a href='{$pageUrl(1)}'>首页</a>{$prePage}{$pageStr}{$nextPage}<a href='{$pageUrl($pageNum)}'>尾页</a>";
        }


    }
    
?>