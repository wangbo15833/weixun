<?php
/**
 * Created by JetBrains PhpStorm.
 * Author: Lynx
 * Date: 14-3-20
 * Time: 上午8:35
 * To change this template use File | Settings | File Templates.
 */

class ManageShop extends MY_Controller{
    function __construct() {
        parent :: __construct();
        if(!defined('USER_TYPE') || USER_TYPE!=2) self::is_login(base_url());
        $this->load->model('sysmenu_model','msysmenu');
        $this->load->model('shops_model','mshops');
        $this->load->model('channel_model','mchannel');
        $this->load->model('types_model','mtypes');
        $this->load->model('area_model','marea');
        $this->load->library('Pinyin');
    }

    public function getMenu(){
        $public_str = $this->msysmenu->get_wdPublic();
        foreach($public_str as $i){
            $i['url'] = WEB_URL . $i['url'];
            $newList[] = $i;
        }
        echo json_encode(array('public'=>$newList));
    }
    public function index()
    {



        //print_r(USER_TYPE);exit;
        $this->load->view("manageShop/index");

    }

    /**
     * 获取参数处理
     */
    function shops_param(){
        //var_dump($_POST);
        $shopid = get_post('shopid')? htmlspecialchars(get_post('shopid')):'';
        $uid = get_post('h_suid') ? htmlspecialchars(get_post('h_suid')) : 0;
        $title = get_post('title') ? htmlspecialchars(get_post('title')) : '';
        $summary = get_post('summary') ? htmlspecialchars(get_post('summary')) : '暂无简介';
        $content = get_post('content') ? htmlspecialchars(get_post('content')) : '暂无详情';
        $is_status2= 2;
        $phone = get_post('phone') ? htmlspecialchars(get_post('phone')) : '';
        $tag = get_post('tag') ? htmlspecialchars(get_post('tag')) : '';
        $is_hot = 1;
        $sort = 1;
        $photoid= get_post('pics') ? htmlspecialchars(get_post('pics')) : '';
        $channelid = get_post('channelid') ? htmlspecialchars(get_post('channelid')) : '';
        $typeid = get_post('typeid') ? htmlspecialchars(get_post('typeid')) : '';
        $areaid = get_post('areaid') ? htmlspecialchars(get_post('areaid')) : '';
        $district_id = get_post('county');
        $city_id = get_post('city');
        $datetime = time();

        $map_x = get_post('map_x');
        $map_y = get_post('map_y');
        $address = get_post('address')? htmlspecialchars(get_post('address')):'';
        $data = array(
            'shopid'=>$shopid,
            'uid' => $uid,
            'title' => $title,
            'summary' => $summary,
            'content' => $content,
            'is_status' => $is_status2,
            'phone' => $phone,
            'tag' => $tag,
            'is_hot' => $is_hot,
            'sort' => $sort,
            'photoid' => serialize($photoid),
            'city_id'=>$city_id,
            'district_id'=>$district_id,
            'channel_id' =>$channelid,
            'type_id' => $typeid,
            'area_id'=> $areaid,
            'pubdate' => $datetime,
            'maps'=>$map_x.",".$map_y,
            'map_x' => $map_x,
            'map_y' => $map_y,
            'address' => $address
        );
        //var_dump($data);exit;
        return $data;
    }

    /**
     * 添加新商铺
     */
    public function addShopManager()
    {
        $shopManager_status = get_post('mstatus') ? htmlspecialchars(get_post('mstatus')) : '';
        if(!$shopManager_status){

            //添加表单token
            $token = self::grante_token(USER_ID);
            $this->load->view('manageShop/shops_add', array('status'=>STATUS,'token'=>$token));
        }else{
            $form_token = get_post('token');
            if(self::is_token(USER_ID, $form_token)){
                $shopsData = $this->shops_param();
                $state = $this->mshops->addShops($shopsData);
                self::drop_token(USER_ID);
                $this->getShopsInfo(1,1);
            }
            else $this->getShopsInfo(1,2);

        }
    }


    /**
     * 发布新商铺信息
     */
    public function addShopsInfo()
    {
        $page_status = htmlspecialchars(get_post('mstatus'));
        if($page_status){
            $form_token = get_post('token');
            if(self::is_token(USER_ID, $form_token)){
                $data =  $this->get_params();
                $this->mshops->addShops($data);
                self::drop_token(USER_ID);
                $this->getShopsInfo(1,1);
            }else $this->getShopsInfo(1,3);
        }else{
            $areas=$this->marea->get_area_list();
            $channels = $this->mchannel->getChannel();
            $token = self::grante_token(USER_ID);
            $this->load->view('manageShop/shops_add', array('token'=>$token,'h_suid'=>USER_ID,'channels'=>$channels,'areas'=>$areas));
        }
    }

    /**
     * 获取店铺信息
     */
    public function getShopsInfo($page=1,$state = 0)
    {


        $lists = array();
        $uid= USER_ID;
        $status = 2;
        $offset = ($page-1) * self::PAGESIZE;
        $param['limit'] = self::PAGESIZE;
        $param['offset'] = $offset;
        $param['uid'] = $uid;
        $param['status'] = $status;
        $shops_data = $this->mshops->getShopsByUid($param);
        //var_dump($shops_data);exit;
        foreach($shops_data as $item){

            $item['new_summary'] = utf8substr($item['summary'], 0, 10);
            $lists[] = $item;
        }
        //获取总数
        $shopCount = $this->mshops->countShopsByUid($param);
        $pageShow = self::_mkPage($page, $shopCount,'shops/getShopsInfo');
        $this->load->view('manageShop/shops_list',array('shopsList'=>$lists,'pageData'=>$pageShow,'state'=>$state));
    }

    /**
     * @param string $id
     * 显示店铺信息
     */
    public function showShops($id='')
    {
        $lists = array();
        if(!$id) show_error(array('传入参数错误！','<a href="'.WEB_URL.'manageShop/getShopsInfo">点击返回</a>'));
        $shop = $this->mshops->detail($id);

        $shop['pics'] = explode(';', unserialize($shop['photoid']));
        $shop['pubdate'] = date('Y-m-d',$shop['pubdate']);



        $this->load->view('manageShop/showShops',array('shopsInfo'=>$shop));
    }

    /**
     * @param string $id
     */
    public function getedit($id=''){
        if(!$id) show_error(array('传入参数错误！','<a href="'.WEB_URL.'manageShop/getShopsInfo">点击返回</a>'));
        $shop = $this->mshops->detail($id);
        $data = $this->mchannel->getChannel();
        $typelist = $this->mtypes->getTypesByChannel($shop['channel_id']);

        //获取店铺图片
        $oto = self::show_pic($shop['photoid']);
        $photoid = unserialize($shop['photoid']);

        //添加表单token
        $token = self::grante_token(USER_ID);
        $this->load
            ->view('manageShop/shops_edit',
            array(
                'channels'=>$data,
                'typelist'=>$typelist,
                'imagelist'=>$oto,
                'photoid'=>$photoid,
                'shop'=>$shop,
                'token'=>$token
            )
        );
    }

    /**
     * 店主编辑店铺信息
     */
    public function editShopsInfo()
    {
        $form_token = get_post('token');
        if(self::is_token(USER_ID, $form_token)){
            $data = $this->shops_param();
            $this->mshops->editShops($data);
            self::drop_token(USER_ID);
            $this->getShopsInfo(1,1);
        }
        else   $this->getShopsInfo(1,2);
    }

    public function getTypeList(){
        $cid = get_post('param_id')? htmlspecialchars(get_post('param_id')):'';
        $types=$this->mtypes->getTypesByChannel($cid);
        echo json_encode(array('status'=>1, 'data'=>$types));

    }

    /**
     * 关闭商铺信息
     * @date 20130503
     * @param uid,id
     * @author gefc
     */
    function delshops($id=0){
        $uid = USER_ID;
        if($id==0) return false;
        $data = array('id'=>$id,'uid'=>$uid,'is_status'=>2);
        $rel = $this->mshops->delshops($data);
        $this->getShopsInfo(1,1);
    }

    /*
     * 店铺名重复检测
     */

    function repetitionCheck(){
        $title = $this->input->get_post('param')?$this->input->get_post('param'):'';
        $shops=$this->mshops->getShopByName($title);
        //print_r($shops);exit;
        if($shops){
            echo json_encode(false);
        }
        else{
            echo json_encode(true);
        }

    }


}