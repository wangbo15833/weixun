<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Administrator
 * Date: 13-8-3
 * Time: 上午10:11
 * To change this template use File | Settings | File Templates.
 */

class service extends MY_Controller{
    const CHANNEL_ID = 7;
    function __construct(){
        parent :: __construct();
        $this->load->model('live_model','l_model');
        $this->load->model('index_model','mindex');
    }

    /**
     * 首页获取分类
     */
    function get_category(){
        $cid= $this->input->get_post('city');
        $categorys = $this->l_model->get_category(1);
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

    function showLiveList($type=6){
        /*获取广告图片*/
        $picList = self::get_ad($type,1);
        $picList_r =  self::get_ad($type,2);
        //获取请求参数
        $n = $this->input->get_post('n')? htmlspecialchars($this->input->get_post('n')):2;
        $ctype = $this->input->get_post('ctype') ? htmlspecialchars($this->input->get_post('ctype')):'';
        $district=$this->input->get_post('district')? htmlspecialchars($this->input->get_post('district')):'';
        $page = $this->input->get_post('page') ? htmlspecialchars($this->input->get_post('page')):1;
        $datastatus = $this->input->get_post('datastatus') ? htmlspecialchars($this->input->get_post('datastatus')):'';
        $hmi = $this->input->get_post('hmi') ? htmlspecialchars($this->input->get_post('hmi')):'';
        $req_url = 'service/showLiveList/'.$type;

        parse_str($_SERVER['QUERY_STRING'], $outArr);
        if($ctype != 55){ //55为服务
            unset($outArr['hmi'], $hmi);
        }
        $paramData['ctype'] = $ctype;
        $paramData['district'] = $district;
        $paramData['ctype_all'] = self::web_url($req_url, array_merge($outArr, array('ctype' => '','page'=>1)));
        $paramData['district_all'] = self::web_url($req_url, array_merge($outArr, array('district' => '','page'=>1)));
        $paramData['home_all'] = self::web_url($req_url, array_merge($outArr, array('hmi' => '','page'=>1)));

        $paramData['url_window'] = self::web_url($req_url, array_merge($outArr, array('n' => 1)));
        $paramData['url_list'] = self::web_url($req_url, array_merge($outArr, array('n' => 2)));
        $citys = $this->mindex->get_district_id(CITYID);
        $categorys = $this->l_model->get_category(1);
        $new_citys = $new_categorys = array();
        foreach($citys as $item){
            $item['base_url'] = self::web_url($req_url, array_merge($outArr, array('district' => $item['area_id'],'page'=>1)));
            $new_citys[] = $item;
        }

        foreach($categorys as $item){
            $item['base_url'] = self::web_url($req_url, array_merge($outArr, array('ctype' => $item['type_id'],'page'=>1)));
            $item['name'] = $item['type_name'];
            $item['id'] = $item['type_id'];
            $new_categorys[] = $item;
        }
        if($ctype) $param['type_id'] = $ctype;
        if($district) $param['area_id'] = $district;
        if(isset($hmi)) $param['home_b'] = $hmi;
        $offset = ($page-1) * self::PAGESIZE;
        $param['limit'] = self::PAGESIZE;
        $param['offset'] = $offset;
        $param['data_status'] = $datastatus;
        $param['where'] = '  and c.type not in (18,66) ';
        $rel =  $this->l_model->get_Live_Info($param);
        $list = $hml = array();
        foreach($rel as $item){
            $item['photos'] =base_url().unserialize($item['photo']);
            $list[] = $item;
        }
        $count = $this->l_model->get_Live_Info_Count($param);
        $pageShow = self::_mkPage($page, $count,$req_url);
        if($ctype == 55){//if(家政服务)
           $hm =  $this->l_model->getHome_c(0);
            foreach($hm as $item){
                $item['base_url'] = self::web_url($req_url, array_merge($outArr, array('hmi' => $item['id'],'page'=>1)));
                $hml[] = $item;
            }
        }
        $paramData['hmi'] = isset($hmi)?$hmi:'';
        $paramData['hm'] = $hml;
        $paramData['n'] = $n;
        $paramData['type'] = $type; //选择分类
        $paramData['list'] = $list;//返回数据
        $paramData['pageShow'] = $pageShow;//分类数据
        $paramData['picList'] = $picList;//左侧上图片
        $paramData['picList_r'] = $picList_r;//右侧图片
        $paramData['citys'] = $new_citys;//筛选条件 地区
        $paramData['categorys'] = $new_categorys;//筛选条件 分类
        $this->load->view('meituan/service_List',$paramData);
    }

    

    /**
     * 修改信息页面及准备数据
     */
    function liveEdit(){
        $g_id = $this->input->get_post('g_id')?htmlspecialchars($this->input->get_post('g_id')):0;
        $citys = $this->mindex->get_district_id(CITYID);
        $categorys = $this->l_model->get_category(1);
        $g_info = $this->l_model->detail($g_id);
        $this->load->view('meituan/service_Edit',array('citys'=>$citys, 'categorys'=> $categorys, 'g_info'=> $g_info));
    }

    function liveUpdate(){
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
        $g_info = $this->l_model->updateLive($data);
        self::detail($data['g_id']);
    }

    /**
     *图片展示列表
     */
    function do_load(){
        $this->load->model('Gourmet_model','gourmet');
        $newList = $cs = array();
        $params['c_id'] = $this->input->get_post('cid')?$this->input->get_post('cid'):'';
        $params['g_id'] = $this->input->get_post('gourmetid')?$this->input->get_post('gourmetid'):'';
        $params['b_type'] = $this->input->get_post('b_type')?$this->input->get_post('b_type'):'';
        $params['s_type'] = $this->input->get_post('s_type')?$this->input->get_post('s_type'):'';
        $g_info = $this->l_model->detail($params['g_id']);
        $lists = $this->l_model->getLivePics($params);
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
        $this->load->view('meituan/service_ShowPic',array('g_info'=>$g_info,'gourmetid'=> $params['g_id'], 'lists' => $newList, 'pgc' => $cs,'cid'=>$params['c_id']));
    }

    /**
     * 转到上传图片页面
     */
    function do_upload(){
        $this->load->model('Gourmet_model','gourmet');
        if(!defined('USER_ID')) self::is_login();
        $state = $this->input->get_post('state')?$this->input->get_post('state'):1;
        $c_id = $this->input->get_post('cid')?$this->input->get_post('cid'):1;
        $gourmetid = $this->input->get_post('gourmetid')?$this->input->get_post('gourmetid'):1;
        $hid_id = $this->input->get_post('hid_id')?$this->input->get_post('hid_id'):1;
        if($state == 1){
            $h_info = $this->l_model->detail($gourmetid);
            $cate = $this->gourmet->getGourmetCategory(array('parentid'=>0));
            $cate_s = $this->gourmet->getGourmetCategory(array('parentid'=>$hid_id,'g_id'=>$gourmetid));
            $datas = count($cate_s)>0? $cate_s : false;
            //跳转至上传页面
            $this->load->view('meituan/service_AddPic',array('cate'=>$cate,'cate_s'=>$datas,'gourmetid'=>$gourmetid,'h_info'=>$h_info,'cid'=>$c_id));
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
        $this->l_model->addLivePic($hid);
        self::do_load($gourmetid);
        //获取数据存档
    }
}