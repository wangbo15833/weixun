<?php
/**
 * 自定义控制器超类
 * @author gefc
 * @date 2013/04/22
 */
class MY_Controller extends CI_Controller
{
    const STATUS_ACTIVATED = 1;
    const STATUS_NOT_ACTIVATED = 0;
    const COOHIE_TIME = 604800;
    const PAGESIZE = 10;
    const TOKEN_KEY = 'weixun_token';

    function __construct()
    {
        parent :: __construct();
		
        $this->load->library('session');
        $this->load->helper('cookie');
        define('WEB_URL', base_url() . 'index.php/');
        define('DEFAULT_PIC', 'frontend/Public/images/bj.jpg');
        define('LIFT_CLICK',isset($_GET['cname'])?$_GET['cname'] : '');
        define('THEME_STYLE','style1');

        //确定所在城市

        $this->load->model('district_model','mdistrict');
        $areaid = $this->input->cookie('areaid');
        if (!$areaid) define('AREAID', 1502); //默认秦皇岛
        else define('AREAID', $areaid);

        if (!defined('AREANAME')) {
            $areainfo = $this->mdistrict->getDistrictByDid(AREAID);
            define('AREANAME', $areainfo['dname']);
        }

        //判断是否登录 未登录跳转首页
        self::is_user();
    }

    /**
     * @param $pics 序列号过的图片字符串
     * @return array 二维数组
     */
    //$j=self::show_pic($rows['photos']);
    // $jg['photos']=$j[0];

    function show_pic($pics)
    {

        $new_pics = unserialize($pics);

        if (!$new_pics)
            return array(DEFAULT_PIC);
        else {
            $l_pics = explode(';', $new_pics);
            return  $l_pics;
            //return $new_pics;
        }
    }

    function facePic($pics)
    {
        $new_pics = unserialize($pics);
        if (!$new_pics)
            return DEFAULT_PIC;
        else {
            return base_url() . $new_pics;
        }
    }

    function get_ad($type, $site = 1)
    {
        $this->load->model('ad_model','mad');
        /*获取广告图片*/
        $pic = $this->mad->getAdInfo($type, $site);
        $picList = $picList_r = array();
        foreach ($pic as $i) {
            $oto = self::show_pic($i['photoUrl']);
            $i['photoUrl'] = base_url() . $oto[0];
            $picList[] = $i;
        }
        return $picList;
    }

    function web_url($url, $params)
    {
        $myUrl = '';
        foreach ($params as $key => $i) {
            if (!($myUrl)) $myUrl .= '?' . $key . '=' . $i;
            else $myUrl .= '&' . $key . '=' . $i;
        }
        return site_url($url . $myUrl);
    }

    /**
     * 判断是否登录
     * @author gefc
     * @return bool
     *
     */
    function is_user()
    {
        $this->load->model('index_model', 'mindex');

        $ci = & get_instance();
        $users = $ci->session->userdata('userinfo');

        $l_userid = $this->input->cookie('login_userid');
        if ($users) {
            define('USER_ID', $users['id']);
            $uname = isset($users['nickname']) ? $users['nickname'] : $users['username'];
            define('USERNAME', $uname);
            define('USER_TYPE',$users['is_type']);

        } else if (intval($l_userid) > 0) {
            $l_userinfo = $this->mindex->get_user_id($l_userid);
            $uname = $l_userinfo['nickname'] ? $l_userinfo['nickname'] : $l_userinfo['username'];
            define('USER_ID', $l_userinfo['id']);
            define('USERNAME', $uname);
            define('USER_TYPE',$users['is_type']);
            define('L_USER', $this->input->cookie('l_user'));
            define('L_PASS', $this->input->cookie('l_pass'));
        }
        //echo CITYID;
    }

    function vita_get_url_content($url) {
        $file_contents = '';
       /* if(function_exists('file_get_contents')) {
            $i=0;
            while(!$file_contents or $i==1){
                @$content =file_get_contents($url);
                $i++;
            }
            if($i==1) $file_contents = '777';
            //$file_contents = @file_get_contents($url);
        } else {
       */
            $ch = curl_init();
            $timeout = 5;
            curl_setopt ($ch, CURLOPT_URL, $url);
            curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
            $file_contents = curl_exec($ch);
            curl_close($ch);
        //}
        return $file_contents;
    }

    function show_qrcode_img($qr_text = '', $qrlogo = '')
    {

        $this->load->library('Phpqrcode_lib');
        $this->load->library('File_util');
        $file = new File_util();
        $time = date('Y/m/d', time());
        $fileUrl = FILEBASE . $time;
        if (!file_exists($fileUrl))
            $file->createDir($fileUrl);

        $PNG_TEMP_DIR = FWPHP_PATH . FILEBASE . $time;
        $PNG_WEB_DIR = WEB_CODE_PATH . $time . '/';
        $get_uuid = get_uuid();
        $filename = $PNG_TEMP_DIR . '/' . $get_uuid . '.png';
        //$output = $PNG_TEMP_DIR . '/'.$get_uuid.'.png';
        $value = $qr_text;
        $errorCorrectionLevel = 'Q';
        $matrixPointSize = 5;
        QRcode::png($value, $filename, $errorCorrectionLevel, $matrixPointSize);
        //echo "QR code generated"."<br/>";
        $logo =$qrlogo;
        $QR = $filename;
        if ($logo !== FALSE) {
            $QR = imagecreatefrompng($QR);
            $logo = @imagecreatefromstring(self::vita_get_url_content($logo));
            $QR_width = imagesx($QR);
            $QR_height = imagesx($QR);
            $logo_width = imagesx($logo);
            $logo_height = imagesx($logo);
            $logo_qr_width = $QR_width / 5;
            $scale = $logo_width / $logo_qr_width;
            $logo_qr_height = $logo_height / $scale;
            $from_width = ($QR_width - $logo_qr_width) / 2;
            imagecopyresampled($QR, $logo, $from_width, $from_width, 0, 0, $logo_qr_width, $logo_qr_height, $logo_width, $logo_height);
        }
        imagepng($QR, $filename);
        return $PNG_WEB_DIR . basename($filename);
    }


    /**
     * @param $page
     * @param $numTotle
     * @param string $url
     * @internal param string $type
     * @return string
     */
    function _mkPage($page, $numTotle, $url = 'main',$pagesize)
    {
        $pageStr = '';
        if (!$numTotle)
            return $pageStr;
        parse_str($_SERVER['QUERY_STRING'], $outArr);
        unset($outArr['page']);
        $pageNum = ceil($numTotle / $pagesize);
        $showPageNum = $pageNum >= 3 ? 3 : $pageNum;
        $page = $page < $pageNum ? $page : $pageNum;
        //$pageUrl = function($page) use($outArr, $type){return site_url("{$type}",array_merge($outArr, array('page' => $page)));       };
        $pageUrl = function ($page) use ($outArr, $url) {
            return MY_Controller::web_url("{$url}", array_merge($outArr, array('page' => $page)));
        };
        //
        $i = $page;
        $current = "href='javascript:;' class='inte_nowpage'";
        if ($page >= $pageNum) {
            $i -= $showPageNum - 1;
            $showPageNum = 0;

        } elseif ($page > 1 && $page < $pageNum) {
            $showPageNum = ($showPageNum - 1) / 2;
            $i -= $showPageNum;
        } else
            $showPageNum--;
        for ($i; $i <= $page + $showPageNum; $i++) {
            if ($page == $i)
                $a = "href='javascript:;' class='inte_nowpage'";
            else
                $a = "href='{$pageUrl($i)}'";
            $pageStr .= "<a  {$a} >{$i}</a>";
        }
        $prePage = $page - 1 < 1 ? "<a href='javascript:;'>上一页</a>" : "<a href='{$pageUrl($page - 1)}'>上一页</a>";
        $nextPage = $page + 1 > $pageNum ? "<a href='javascript:;'>下一页</a>" : "<a href='{$pageUrl($page + 1)}'>下一页</a>";
        return $pageStr = "<a href='{$pageUrl(1)}'>首页</a>{$prePage}{$pageStr}{$nextPage}<a href='{$pageUrl($pageNum)}'>尾页</a>";
    }

    function is_login($str = 'login')
    {

        //redirect($str);
        echo "<Script Language='Javascript'>";
        echo "alert('提示：您不具有店铺管理权限！');";
        echo "parent.location.href='".$str ."';";
        echo "</Script>";
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
}

?>