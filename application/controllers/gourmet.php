<?php
/**
 * Created by JetBrains PhpStorm.
 * User: gefc
 * Date: 13-6-26
 * Time: 下午2:57
 * 美食频道 相关函数
 */
class Gourmet extends MY_Controller{
    const CHANNEL_ID = 2;
    /**
     *
     */
    function __construct(){
        parent::__construct();

        $this->load->model('Gourmet_model','gourmet');
        $this->load->model('index_model','mindex');
    }

    function index(){
        self::do_upload();
    }
    /**
     * 上传美食相关图片
     */
    function uploadPic(){
       // $this->load->view('list1');
    }
    /**
     * 获取美食展示列表
     * @param int $type
     */
    function getGourmet($type=2){
        /*获取广告图片*/
        $picList = self::get_ad($type,1);
        $picList_r =  self::get_ad($type,2);
        //获取请求参数
        $n = $this->input->get_post('n')? htmlspecialchars($this->input->get_post('n')):2;
        $ctype = $this->input->get_post('ctype') ? htmlspecialchars($this->input->get_post('ctype')):'';
        $district=$this->input->get_post('district')? htmlspecialchars($this->input->get_post('district')):'';
        $page = $this->input->get_post('page') ? htmlspecialchars($this->input->get_post('page')):1;
        $datastatus = $this->input->get_post('datastatus') ? htmlspecialchars($this->input->get_post('datastatus')):'';
        $req_url = 'gourmet/getGourmet/'.$type;
        parse_str($_SERVER['QUERY_STRING'], $outArr);
        $paramData['ctype'] = $ctype;
        $paramData['district'] = $district;
        $paramData['ctype_all'] = self::web_url($req_url,array_merge($outArr,array('ctype'=>'','page'=>1)));
        $paramData['district_all'] = self::web_url($req_url,array_merge($outArr,array('district'=>'','page'=>1)));
        $paramData['url_window'] =self::web_url($req_url,array_merge($outArr,array('n'=>'1')));
        $paramData['url_list'] = self::web_url($req_url,array_merge($outArr,array('n'=>'2')));
        $citys = $this->mindex->get_district_id(CITYID);
        $categorys = $this->mindex-> get_goodsCategory_id($type, 0);
        $new_citys = $new_categorys = array();
        foreach($citys as $item){
            $item['base_url'] = self::web_url($req_url,array_merge($outArr,array('district'=>$item['area_id'],'page'=>1)));
            $new_citys[] = $item;
        }

        foreach($categorys as $item){
            $item['base_url'] = self::web_url($req_url,array_merge($outArr,array('ctype'=>$item['id'],'page'=>1)));
            $new_categorys[] = $item;
        }
        if($ctype) $param['type_id'] = $ctype;
        if($district) $param['area_id'] = $district;
        $offset = ($page-1) * self::PAGESIZE;
        $param['limit'] = self::PAGESIZE;
        $param['offset'] = $offset;
        $param['data_status'] = $datastatus;
        $rel =  $this->gourmet->get_Gourmet_Info($param);
        $list = array();
        foreach($rel as $item){
            $item['photos'] =base_url().$item['photo'];
            $list[] = $item;
        }
        $count = $this->gourmet->get_Gourmet_Info_Count($param);
        $pageShow = self::_mkPage($page, $count,$req_url);
        $paramData['n'] = $n;
        $paramData['type'] = $type; //选择分类
        $paramData['list'] = $list;//返回数据
        $paramData['pageShow'] = $pageShow;//分类数据
        $paramData['picList'] = $picList;//左侧上图片
        $paramData['picList_r'] = $picList_r;//右侧图片
        $paramData['citys'] = $new_citys;//筛选条件 地区
        $paramData['categorys'] = $new_categorys;//筛选条件 分类
        $this->load->view('meituan/gourmet',$paramData);
    }

    /**
     * @param int $param_id
     * 美食详细页面
     */
    

    /**
     * 美食评论
     */




    /**
     * 修改信息页面及准备数据
     */
    function edit_gourmet(){
        $g_id = $this->input->get_post('g_id')?htmlspecialchars($this->input->get_post('g_id')):0;
        $citys = $this->mindex->get_district_id(CITYID);
        $categorys = $this->mindex-> get_goodsCategory_id(self::CHANNEL_ID, 0);
        $g_info = $this->gourmet->gourmet_detail($g_id);
        $this->load->view('meituan/gourmet_edit',array('citys'=>$citys, 'categorys'=> $categorys, 'g_info'=> $g_info));
    }

    /**
     * 更新信息
     */
    function updateGourmet(){
        if(!defined('USER_ID')) self::is_login();

        $data['g_id'] = $this->input->get_post('hid_id');
        $data['txtName'] = $this->input->get_post('txtName') ? htmlspecialchars($this->input->get_post('txtName')) : '';
        $data['txtPrice'] = $this->input->get_post('txtPrice')? htmlspecialchars($this->input->get_post('txtPrice')) : '';
        $data['ddlCategory'] = $this->input->get_post('ddlCategory1')? htmlspecialchars($this->input->get_post('ddlCategory1')) : '';
        $data['ddlArea'] = $this->input->get_post('ddlArea1')? htmlspecialchars($this->input->get_post('ddlArea1')) : '';
        $data['txtAddress'] = $this->input->get_post('txtAddress')? htmlspecialchars($this->input->get_post('txtAddress')) : '';
        $data['txtPhone'] = $this->input->get_post('txtPhone')? htmlspecialchars($this->input->get_post('txtPhone')) : '';
        $data['txtTag'] = $this->input->get_post('txtTag')? htmlspecialchars($this->input->get_post('txtTag')) : '';
        $data['myContent'] = $this->input->get_post('myContent')? htmlspecialchars($this->input->get_post('myContent')) : '';
        $g_info = $this->gourmet->updateGourmet($data);
        self::gourmetDetail($data['g_id']);
    }

    /**
     * 转到上传图片页面
     */
    function do_upload(){
        if(!defined('USER_ID')) self::is_login();
        $state = $this->input->get_post('state')?$this->input->get_post('state'):1;
        $c_id = $this->input->get_post('cid')?$this->input->get_post('cid'):1;
        $gourmetid = $this->input->get_post('gourmetid')?$this->input->get_post('gourmetid'):1;
        $hid_id = $this->input->get_post('hid_id')?$this->input->get_post('hid_id'):1;
        if($state == 1){
            $g_info = $this->gourmet->gourmet_detail($gourmetid);
            $cate = $this->gourmet->getGourmetCategory(array('parentid'=>0));
            $cate_s = $this->gourmet->getGourmetCategory(array('parentid'=>$hid_id,'g_id'=>$gourmetid));
            $datas = count($cate_s)>0? $cate_s : false;
            //跳转至上传页面
            $this->load->view('meituan/gourmet_addpic',array('cate'=>$cate,'cate_s'=>$datas,'gourmetid'=>$gourmetid,'g_info'=>$g_info,'cid'=>$c_id));
            return;
        }
        $hid['title'] = $this->input->get_post('hid_name')?$this->input->get_post('hid_name'):'';

        $hid['price'] = $this->input->get_post('hid_price')?$this->input->get_post('hid_price'):0;
        $hid['picUrl'] = $this->input->get_post('hid_pics')?serialize($this->input->get_post('hid_pics')):'';
        $hid['b_type'] = $hid_id;
        $hid['s_type'] = intval($this->input->get_post('hid_title')) > 0 ?$this->input->get_post('hid_title'):$hid_id;
        $hid['dateline'] = time();
        $hid['uid'] = USER_ID;
        $hid['g_id'] = $gourmetid;
        $this->gourmet->addGourmetPic($hid);
        self::do_load($gourmetid);
        //获取数据存档
    }

    /**
     *图片展示列表
     */
    function do_load(){
        $newList = $cs = array();
        $params['c_id'] = $this->input->get_post('cid')?$this->input->get_post('cid'):'';
        $params['g_id'] = $this->input->get_post('gourmetid')?$this->input->get_post('gourmetid'):'';
        $params['b_type'] = $this->input->get_post('b_type')?$this->input->get_post('b_type'):'';
        $params['s_type'] = $this->input->get_post('s_type')?$this->input->get_post('s_type'):'';
        $g_info = $this->gourmet->gourmet_detail($params['g_id']);
        $lists = $this->gourmet->getGourmetPics($params);

        foreach( $lists as $item){
           $item['picUrl'] = base_url() . unserialize($item['picUrl']);
            $item['dateline'] = friendlyDate($item['dateline']);
            $users = $this->mindex->get_user_id($item['uid']);
            $item['username'] = $users['username'];
            $newList[] = $item;
        }
        $pgc = $this->gourmet->getGourmetCategory(array('parentid'=>0));
        foreach($pgc as $pi){
            $pi['childs'] = $this->gourmet->getGourmetCategory(array('parentid'=> $pi['id'],'g_id'=>$params['g_id'] ));
            $cs[] = $pi;
        }
        $this->load->view('meituan/gourmet_showpic',array('g_info'=>$g_info,'gourmetid'=> $params['g_id'], 'lists' => $newList, 'pgc' => $cs,'cid'=>$params['c_id']));
    }

    /**
     * 添加自定义分类
     */
    function add_types(){
        $param['name'] = $this->input->get_post('name')?$this->input->get_post('name'):1;
        $param['g_id'] = $this->input->get_post('gourmetid')?$this->input->get_post('gourmetid'):1;
        $param['parentid'] = $this->input->get_post('parentid')?$this->input->get_post('parentid'):1;
        $newData =  $this->gourmet->addGourmetCategory($param);
        echo json_encode(array('status'=>1,'data'=>$newData));
    }
}