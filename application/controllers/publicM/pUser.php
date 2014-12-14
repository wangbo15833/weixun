<?php
class PUser extends CI_Controller{
    function __construct(){
        parent :: __construct();
        $this->load->library('HessianPHP_lib');
        $this->load->model('index_model','m_index');
        $this->load->model('common_model','cmodel');
    }

    function add($a, $b){
        return "This is a first hessianPHP!".$a."+".$b;
    }

    function index(){
        $server = new HessianService(new PUser(), array('displayInfo' => true));
        $server -> handle();
    }

    /**
     * 登录函数
     * @param uname upwd //captcha
     * return array/false
     */
    function doLogin(){
        $email = $this->input->get_post('uname');
        $password = $this->input->get_post('upwd');
        $param['username'] = $email;
        $param['password'] = sysAuthCode($password);
        $users = $this->m_index->check_user($param);
        if(count($users) > 0)
            return json_encode($users);
        else return json_encode(false);
    }

    /**
     * 注册函数
     * @param unama upwd uemail ucity
     * @return bool
     */
    function doRegister(){
        $email = $this->input->get_post('uemail');
        $username = $this->input->get_post('unama');
        $password = $this->input->get_post('upwd');
        $city = $this->input->get_post('ucity');
        $data = array('username'=>$username,'password'=>sysAuthCode($password),'email'=>$email,'area'=>$city,'last_ip'=>$this->input->ip_address(), 'c_time'=>time());
        $users = $this->m_index->add_user($data);
        if($users){
            //$data['id'] = $users;
            //删除验证码session
            //$this->session->unset_userdata($uuid);
            //$this->session->set_userdata('userinfo',$data);
            return true;
        }else
            return false;
    }

    /**
     * 获取分类
     * @param void
     * @return array
     */
    function getCategory(){
       $c =  $this->cmodel->getType();
       return json_encode($c);
    }

    function searchList(){
        $this->load->model('gourmet_model','gourmet');
        $this->load->model('happy_model', 'happy');
        $this->load->model('live_model', 'live');
        $page = $this->input->get_post('page') ? htmlspecialchars($this->input->get_post('page')):1;
        $search_key = $this->input->get_post('header_search') ? htmlspecialchars($this->input->get_post('header_search')):'';
        $offset = ($page-1) * self::PAGESIZE;
        $param['c_title'] = $search_key;
        $param['data_status'] = '';
        $param['limit'] = self::PAGESIZE;
        $param['offset'] = $offset;
        $param['city_id'] = CITYID;
        //购
        $rel =   $this->mindex->get_c_info($param);
        $list = $pageShow = array();
        foreach($rel as $item){
            $oto =  self::show_pic($item['photos']);
            //var_dump($oto);
            $item['photos'] =$oto[0];
            $item['name'] = $item['title'];
            $item['new_jianjie'] = utf8substr($item['jianjie'],0,20);
            //$item['addr'] = $item['new_jianjie'];
            $list[] = $item;
        }
        //吃
        $param['name'] = $search_key;
        $param['data_status'] = 4;
        $sGourmet = $this->gourmet->get_Gourmet_Info($param);
        //玩
        $param['where'] =" and c.type >= 7 ";
        $sPlay = $this->happy->get_Happy_Info($param);
        //乐
        $param['where'] = " and c.type < 7 ";
        $sHappy = $this->happy->get_Happy_Info($param);
        //住
        $param['where'] = " and c.type = 18 ";
        $sLive = $this->live->get_Live_Info($param);
        //服务
        $param['where'] = " and c.type != 18 ";
        $sService = $this->live->get_Live_Info($param);
        $data = array('list'=>$list,'gourmet'=>$sGourmet, 'pageShow'=>$pageShow,'search_key'=>$search_key);
        $data['play'] = $sPlay; $data['happy'] = $sHappy; $data['live'] = $sLive; $data['service'] = $sService;
        return json_encode($data);
    }
}
?>