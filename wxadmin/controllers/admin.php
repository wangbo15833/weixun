<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Lynx
 * Date: 14-2-9
 * Time: 上午10:50
 * To change this template use File | Settings | File Templates.
 */

class Admin extends MY_Controller{
    function __construct() {
        parent :: __construct();
        $this->load->model('admin_model','madmin');


    }

    public function modify_pwd()
    {
        //$sdata = parent::getsessinfo();
        $this->load->view('default/modify_pwd', array('uid' => UID));
    }

    /**
     * 修改密码
     */
    public function update()
    {
        $this->load->helper('Valid');
        $valid = new Valid();
        $id = get_post('hid_id') ? htmlspecialchars(get_post('hid_id')) : false;
        $name = get_post('lname') ? htmlspecialchars(get_post('lname')) : false;
        $pwd = get_post('lpwd') ? htmlspecialchars(get_post('lpwd')) : false;
        $npwd = get_post('npwd') ? htmlspecialchars(get_post('npwd')) : false;
        $qpwd = get_post('qpwd') ? htmlspecialchars(get_post('qpwd')) : false;
        //var_dump($valid->isNumber(intval($pwd)));exit;
        if ($id == false || $name == false || $pwd == false || $npwd == false || $qpwd == false)
            show_error('输入不能为空！');
        /*else if (!$valid->isNumber(intval($pwd)))
            show_error('密码错误，只能输入数字！');
        else if (!$valid->isNumber(intval($npwd)))
            show_error('新密码只能输入数字！');
        else if (!$valid->isNumber(intval($qpwd)))
            show_error('重复密码只能输入数字！');*/
        else if (!$valid->pwd_check($npwd, $qpwd))
            show_error('两次密码输入不相同！');

        $data = array('id' => $id, 'aname' => $name, 'apwd' => sysAuthCode($npwd));
        //var_dump(array('id'=>$id,'aname'=>$name,'apwd'=>sysAuthCode($pwd)));
        $tmp = $this->madmin->check_user(array('id' => $id, 'aname' => $name, 'apwd' => sysAuthCode($pwd)));
        if ($tmp == 0)
        {

            header("Content-type: text/html; charset=utf-8");
            echo "<Script Language='Javascript'>";
            echo "alert('提示：原用户名密码错误，请重新输入！');";
            echo "history.go(-1);";
            echo "</Script>";
        }
        else{
            $rel = $this->madmin->editUpdate($data);
            $this->load->view('default/index');

        }
    }

    function shopUserMananger($page = 1, $state=0){
        $offset = ($page-1) * self::PAGESIZE;
        $param['limit'] = self::PAGESIZE;
        $param['offset'] = $offset;
        $data = $this->madmin->shopUserMananger($param);
        //获取总数
        $shopCount = $this->madmin->shopUserMananger_count();
        $pageShow = self::_mkPage($page, $shopCount,'/admin/shopUserMananger');
        $this->load->view('default/manangerShopUser',array('shopsData'=>$data,'showPage'=>$pageShow, 'state'=>$state));

    }

    public function editshopUser($value='',$status='')
    {
        if(!$value || !$status) show_error(array('传入参数错误！','<a href="'.WEB_URL.'setting/index/shopUserMananger">点击返回</a>'));
        $this->madmin->editshopUser($value, $status);
        $this->shopUserMananger(1, 1);
    }


    function user_info()
    {
        $page = ($this->input->get_post('page')) ? get_post('page') : 1;
        $offset = ($page - 1) * self::PAGESIZE;
        $data = array('limit' => self::PAGESIZE, 'offset' => $offset);
        $userList = $this->madmin->get_user_info($data);
        $userCount = $this->madmin->get_user_info_count();
        $pageStr = self::mkPage($page, $userCount, 'login/user_info');
        $this->load->view('default/levelList', array('shopsData' => $userList, 'showPage' => $pageStr));
    }


    function editAuth()
    {
        $auth = get_post('auth') ? htmlspecialchars(get_post('auth')) : '';
        $id = get_post('id') ? htmlspecialchars(get_post('id')) : '';
        if (!$auth || !$id) show_error('参数错误！');
        $this->madmin->editUser($id, $auth);
        self::user_info();
    }

    /**
     * 添加商铺or管理员信息
     */

    function addadminP(){
        $this->load->view('default/admin_add');
    }
    function addadmin()
    {
        $data['aname'] = get_post('name') ? htmlspecialchars(get_post('name')) : '';
        $data['apwd'] = get_post('pwd') ? htmlspecialchars(get_post('pwd')) : '';
        $data['apwd'] = sysAuthCode($data['apwd']);
        $data['legalname'] = get_post('legalname') ? htmlspecialchars(get_post('legalname')) : '';
        $data['phone'] = get_post('phone') ? htmlspecialchars(get_post('phone')) : '';
        $data['email'] = get_post('email') ? htmlspecialchars(get_post('email')) : '';
        $data['address'] = get_post('address') ? htmlspecialchars(get_post('address')) : '';
        $data['createtime'] = time();
        $data['edittime'] = time();
        $data['is_type']=2;
        $rel = $this->madmin->adduser($data);
        self::user_info();
    }

    /**
     * 管理员管理
     */
    function adminUserManager($page = 1, $state =0){
        $offset = ($page-1) * self::PAGESIZE;
        $param['limit'] = self::PAGESIZE;
        $param['offset'] = $offset;
        $data = $this->madmin->adminUserManager($param);
        $newdata = array();
        foreach($data as $item){
            $item['createtime'] = friendlyDate($item['createtime'],'ymd');
            if( $item['is_type'] ==1) $item['is_type'] ='商铺会员';elseif($item['is_type'] ==2) $item['is_type'] ='管理员'; else $item['is_type'] ='超级管理员';
            $newdata[] = $item;
        }
        //获取总数
        $shopCount = $this->madmin->adminUserManager_count();
        $pageShow = $this->_mkPage($page, $shopCount,'/admin/adminUserManager');
        $this->load->view('default/managerAdminUser',array('shopsData'=>$newdata,'showPage'=>$pageShow, 'state'=>$state));
    }

    function editadminUser($value='',$status=''){
        if(!$value || !$status) show_error(array('传入参数错误！','<a href="'.WEB_URL.'setting/index/adminUserManager">点击返回</a>'));
        $this->madmin->editadminUser($value, $status);
        $this->adminUserManager(1, 1);
    }

    public function getShopsUser($key ='')
    {
        $key = get_post('sKey') ;
        $list = $this->manager->getShopsUser($key);

        echo json_encode((count($list) > 0) ? $list : false);
    }


}