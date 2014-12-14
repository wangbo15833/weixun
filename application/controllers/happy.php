<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Administrator
 * Date: 13-8-2
 * Time: 上午8:31
 * To change this template use File | Settings | File Templates.
 */

class Happy extends MY_Controller {
    const CHANNEL_ID = 6;
    function __construct(){
        parent::__construct();
        $this->load->model('happy_model','h_model');
        $this->load->model('index_model','mindex');
    }

    /**
     * 首页获取分类
     */
    function get_category(){
        $cid= $this->input->get_post('city');
        $categorys = $this->h_model->get_category();
        $arrs = array();
        foreach($categorys as $item){
            $data['name'] = $item['type_name'];
            $data['value'] = $item['type_id'];
            $data['needAz'] = 'false';
            $data['cid'] = $cid;
            $arrs[] = $data;
        }
        echo json_encode($arrs);
    }

    function showHappylList($type=6){
        /*获取广告图片*/
        $picList = self::get_ad($type,1);
        $picList_r =  self::get_ad($type,2);
        //获取请求参数
        $n = $this->input->get_post('n')? htmlspecialchars($this->input->get_post('n')):2;
        $ctype = $this->input->get_post('ctype') ? htmlspecialchars($this->input->get_post('ctype')):'';
        $district=$this->input->get_post('district')? htmlspecialchars($this->input->get_post('district')):'';
        $page = $this->input->get_post('page') ? htmlspecialchars($this->input->get_post('page')):1;
        $datastatus = $this->input->get_post('datastatus') ? htmlspecialchars($this->input->get_post('datastatus')):'';
        $req_url = 'happy/showHappylList/'.$type;
        parse_str($_SERVER['QUERY_STRING'], $outArr);
        $paramData['ctype'] = $ctype;
        $paramData['district'] = $district;
        $paramData['ctype_all'] = self::web_url($req_url,array_merge($outArr,array('ctype'=>'','page'=>1)));
        $paramData['district_all'] = self::web_url($req_url,array_merge($outArr,array('district'=>'','page'=>1)));
        $paramData['url_window'] = self::web_url($req_url,array_merge($outArr,array('n'=>'1')));
        $paramData['url_list'] = self::web_url($req_url,array_merge($outArr,array('n'=>'2')));
        $citys = $this->mindex->get_district_id(CITYID);
        $categorys = $this->h_model->get_category();
        $new_citys = $new_categorys = array();
        foreach($citys as $item){
            $item['base_url'] = self::web_url($req_url,array_merge($outArr,array('district'=>$item['area_id'],'page'=>1)));
            $new_citys[] = $item;
        }

        foreach($categorys as $item){
            $item['base_url'] = self::web_url($req_url,array_merge($outArr,array('ctype'=>$item['id'],'page'=>1)));
            $item['name'] = $item['type_name'];
            $item['id'] = $item['type_id'];
            $new_categorys[] = $item;
        }
        if($ctype) $param['type_id'] = $ctype;
        if($district) $param['area_id'] = $district;
        $offset = ($page-1) * self::PAGESIZE;
        $param['limit'] = self::PAGESIZE;
        $param['offset'] = $offset;
        $param['data_status'] = $datastatus;
        $param['where'] = " and c.type < 7 ";
        $rel =  $this->h_model->get_Happy_Info($param);
        $list = array();
        foreach($rel as $item){
            $item['photos'] =base_url().unserialize($item['photo']);
            $list[] = $item;
        }
        $count = $this->h_model->get_Happy_Info_Count($param);
        $pageShow = self::_mkPage($page, $count,$req_url);
        $paramData['n'] = $n;
        $paramData['type'] = $type; //选择分类
        $paramData['list'] = $list;//返回数据
        $paramData['pageShow'] = $pageShow;//分类数据
        $paramData['picList'] = $picList;//左侧上图片
        $paramData['picList_r'] = $picList_r;//右侧图片
        $paramData['citys'] = $new_citys;//筛选条件 地区
        $paramData['categorys'] = $new_categorys;//筛选条件 分类
        $this->load->view('meituan/happy_List',$paramData);
    }

   

    /**
     * 修改信息页面及准备数据
     */
    function happyEdit(){
        $g_id = $this->input->get_post('g_id')?htmlspecialchars($this->input->get_post('g_id')):0;
        $citys = $this->mindex->get_district_id(CITYID);
        $categorys = $this->h_model->get_category();
        $g_info = $this->h_model->detail($g_id);
        $this->load->view('meituan/happy_Edit',array('citys'=>$citys, 'categorys'=> $categorys, 'g_info'=> $g_info));
    }

    function happyUpdate(){
        if(!defined('USER_ID')) self::is_login();

        $data['g_id'] = $this->input->get_post('hid_id');
        $data['txtName'] = $this->input->get_post('txtName') ? htmlspecialchars($this->input->get_post('txtName')) : '';
        $data['txtPrice'] = $this->input->get_post('txtPrice')? htmlspecialchars($this->input->get_post('txtPrice')) : '';
        $data['ddlCategory1'] = $this->input->get_post('ddlCategory1')? htmlspecialchars($this->input->get_post('ddlCategory1')) : '';
        $data['ddlArea1'] = $this->input->get_post('ddlArea1')? htmlspecialchars($this->input->get_post('ddlArea1')) : '';
        $data['txtAddress'] = $this->input->get_post('txtAddress')? htmlspecialchars($this->input->get_post('txtAddress')) : '';
        $data['txtPhone'] = $this->input->get_post('txtPhone')? htmlspecialchars($this->input->get_post('txtPhone')) : '';
        $data['txtTag'] = $this->input->get_post('txtTag')? htmlspecialchars($this->input->get_post('txtTag')) : '';
        $data['myContent'] = $this->input->get_post('myContent')? htmlspecialchars($this->input->get_post('myContent')) : '';
        $g_info = $this->h_model->updateHappy($data);
        self::detail($data['g_id']);
    }


}