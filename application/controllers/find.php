<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Administrator
 * Date: 13-9-12
 * Time: 下午2:40
 * To change this template use File | Settings | File Templates.
 */

class Find extends MY_Controller {
    function __construct(){
        parent :: __construct();
        $this->load->model('find_model','fm');
        $this->load->model('index_model', 'im');
        $this->load->model('channel_model','mchannel');
        $this->load->model('area_model','marea');
        $this->load->model('types_model','mtypes');
    }


    function get_district_id(){
        $param = $this->input->get_post('param_id');
        $areas = $this->marea->get_area_list();
        //var_dump($areas);
        echo json_encode(array('status'=>1,'data'=>$areas));
    }

    function do_find(){
        //获取初始频道
        if(!defined('USER_ID')) self::is_login();
        $channels = $this->mchannel->getChannel();
        //获取初始地区
        $areas = $this->marea->get_area_list();
        $this->load->view('default/dofind',array('areas'=>$areas,'channels'=>$channels,'uid'=>USER_ID));
    }

    function doFind(){
        $param['area_id'] = get_post('area') ? get_post('area') : 0;
        $param['uid'] = get_post('uid') ? get_post('uid') : 0;
        $param['channel_id'] = get_post('channelid') ? get_post('channelid') : 0;
        $param['type_id'] = get_post('type') ? get_post('type'):0;
        $param['title'] = get_post('username') ? get_post('username') : '';
        $param['photo_url'] = get_post('hid_pic') ? serialize(get_post('hid_pic')) :'';
        $param['content'] = get_post('content') ? get_post('content') : '';
        $param['dateline'] = time();
        $param['state'] = 1;
        $bool = $this->fm->add_findList($param);
        self::do_find();
    }

    function get_channel(){
        $channels = $this->cm->getType();
        return $channels;
    }

    function get_type(){
        $data = array();
        $channelid = htmlspecialchars($this->input->get_post('param_id'));
        $data=$this->mtypes->get_types($channelid, 0);
        echo json_encode(array('status'=>1,'data'=>$data));
    }

    function get_district(){
        $city_id = 11; //htmlspecialchars($this->input->get_post('city_id'));
        $district = $this->im->get_district_id($city_id);
        var_dump($district);
    }

    function getFind(){
        $this->load->model('channel_model', 'mchannel');
        $channels = $this->mchannel->getChannel();
        $page = $this->input->get_post('page') ? htmlspecialchars($this->input->get_post('page')) : 1;
        $offset = ($page-1) * self::PAGESIZE;
        $limit = self::PAGESIZE;
        $data = array('limit' => $limit ,'offset' => $offset ,'uid' => USER_ID);
        $jgjs=array();
        $rel_count = $this->fm->get_findList_count($data);
        $startPage = 1;
        $endPage = ceil($rel_count/self::PAGESIZE);
        $upPage = $page-1 > 0 ? $page -1 : 1;
        $downPage = $page+1 <= $endPage ? $page +1 : $endPage;
        $mylist = $this->fm->get_findList($data);
        foreach($mylist as  $item){
            $j = self::show_pic($item['photo_url']);
            $param['photos'] = base_url() . $j[0];
            $param['title'] = $item['title'];
            $param['sub_title'] = utf8substr($item['title'], 0, 18);
            $param['channel'] = $channels[$item['channel_id']]['name'];
            $param['content'] = utf8substr($item['content'], 0, 18);
            $param['dateline'] = friendlyDate($item['dateline']);
            $param['url'] = WEB_URL . 'find/showfind/'.$item['id'];
            $param['durl'] = WEB_URL . 'find/delfind/'.$item['id'];
            $jgjs[] = $param;
        }
        echo json_encode(array('status'=>1,
            'data'=>array('count'=>array('startPage'=>$startPage,'endPage'=>$endPage,
                'upPage'=>$upPage,'downPage'=>$downPage),'list'=> $jgjs)));
    }

    function showfind($id = ''){
        $finds = $this->fm->get_showfind($id);
		//echo $finds[0]['state'];
		//echo $finds[0]['area_id'];
		//exit;
        //var_dump($finds);exit;
        $district = $this->marea->get_areabyId($finds[0]['area_id']);
		//var_dump($district);
		//exit;
        if($district) {
            $finds[0]['area'] = $district['name'];
        }
        else{
            $finds[0]['area']="未选择区县";
        }
        $j = self::show_pic($finds[0]['photo_url']);
        $finds[0]['photos'] = base_url() . $j[0];
        $this->load->view('meituan/showfind',array('finds'=>$finds[0]));
    }

    function delfind($id=''){
        $this->fm->del_findList($id);
        //self::getFind();
        $this->load->model('user_model','m_index');
        $u_i = $this->m_index->get_user_info(USER_ID);
        $u_i['nickname'] = isset($u_i['nickname']) ? $u_i['nickname'] : $u_i['username'] ;
        $u_i['picture'] = self::facePic($u_i['picture'] );
        //echo "<pre>";
        //print_r($u_i);
        $this->load->view('default/list',array('list_u' => $u_i));
    }
}