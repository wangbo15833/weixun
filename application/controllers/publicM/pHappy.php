<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Administrator
 * Date: 13-8-28
 * Time: 上午8:57
 * To change this template use File | Settings | File Templates.
 */

class PHappy extends CI_Controller {
    const CHANNELID = 6;
    const PAGESIZE = 20;
    function __construct(){
        parent :: __construct();
        $this->load->library('HessianPHP_lib');
        $this->load->model('index_model','mindex');
        $this->load->model('Gourmet_model','gourmet');
        $this->load->model('happy_model','h_model');
    }

    function index(){
        $server = new HessianService(new PHappy(), array('displayInfo' => true));
        $server -> handle();
    }

    /**
     *获取列表信息
     * @param ctype district page
     * @return array
     */
    function getData(){
        $ctype = $this->input->get_post('ctype') ? htmlspecialchars($this->input->get_post('ctype')):'';
        $district=$this->input->get_post('district')? htmlspecialchars($this->input->get_post('district')):'';
        $page = $this->input->get_post('page') ? htmlspecialchars($this->input->get_post('page')):1;
        $datastatus = $this->input->get_post('datastatus') ?
            htmlspecialchars($this->input->get_post('datastatus')):0;
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
        return array('count' => $count, 'list' => $list);

    }

    /**
     *编辑信息
     * @param g_id txtName txtPrice ddlCategory ddlArea txtAddress txtPhone txtTag myContent
     * @return bool
     */
    function editData(){
        $data['g_id'] = $this->input->get_post('g_id');
        $data['txtName'] = $this->input->get_post('txtName') ? htmlspecialchars($this->input->get_post('txtName')) : '';
        $data['txtPrice'] = $this->input->get_post('txtPrice')? htmlspecialchars($this->input->get_post('txtPrice')) : '';
        $data['ddlCategory1'] = $this->input->get_post('ddlCategory')? htmlspecialchars($this->input->get_post('ddlCategory')) : '';
        $data['ddlArea1'] = $this->input->get_post('ddlArea')? htmlspecialchars($this->input->get_post('ddlArea')) : '';
        $data['txtAddress'] = $this->input->get_post('txtAddress')? htmlspecialchars($this->input->get_post('txtAddress')) : '';
        $data['txtPhone'] = $this->input->get_post('txtPhone')? htmlspecialchars($this->input->get_post('txtPhone')) : '';
        $data['txtTag'] = $this->input->get_post('txtTag')? htmlspecialchars($this->input->get_post('txtTag')) : '';
        $data['myContent'] = $this->input->get_post('myContent')? htmlspecialchars($this->input->get_post('myContent')) : '';
        $g_info = $this->h_model->updateHappy($data);
        return $g_info ? true : false;
    }

    /**
     *添加信息
     * @param title typeId content phone county address map_x map_y price tag pics areaName
     * @return bool
     */
    function doData(){
        $this->load->library('Pinyin');
        $data['name'] = get_post('title') ? htmlspecialchars(get_post('title')) : '';
        $data['type'] = get_post('typeId') ? htmlspecialchars(get_post('typeId')) : '';
        $data['summary'] = get_post('content') ? htmlspecialchars(get_post('content')) : '';
        $data['phone'] = get_post('phone') ? htmlspecialchars(get_post('phone')) : '';
        $data['area_id'] = get_post('county') ? htmlspecialchars(get_post('county')) : '';
        $data['addr'] = get_post('address') ? htmlspecialchars(get_post('address')) : '';
        $map_x = get_post('map_x') ? htmlspecialchars(get_post('map_x')) : '';
        $map_y = get_post('map_y') ? htmlspecialchars(get_post('map_y')) : '';
        $data['maps'] = $map_x .','.$map_y;
        $data['price'] = get_post('price') ? htmlspecialchars(get_post('price')) : '';
        $data['tag'] = get_post('tag') ? htmlspecialchars(get_post('tag')) : '';
        $data['photo'] = get_post('pics') ? serialize(htmlspecialchars(get_post('pics'))) : '';

        $data['dateline'] = time();
        $data['area'] = get_post('areaName');
        $py = new Pinyin();
        $pyValue = $py->convert($data['name']);
        $ls = $py->mb_strrev($data['name']);
        $temp_str = '';
        foreach($ls as $item){
            $temp_str .= strtoupper(mb_substr($py->convert($item), 0, 1));
        }
        $data['quanpin'] = $pyValue;
        $data['jianpin'] = $temp_str;
        $s = $this->h_model->addInfo($data);
        return $s ? true : false;
    }

    /**
     *获取附图图片
     * @param g_id b_type s_type
     * @return array or false
     */
    function getDataPic(){
        $newList = $cs = array();
        $params['g_id'] = $this->input->get_post('g_id')?$this->input->get_post('g_id'):'';
        $params['b_type'] = $this->input->get_post('b_type')?$this->input->get_post('b_type'):'';
        $params['s_type'] = $this->input->get_post('s_type')?$this->input->get_post('s_type'):'';
        if(!$params['g_id']) return false;
        $lists = $this->h_model->getHappyPics($params);
        foreach( $lists as $item){
            $item['picUrl'] = base_url() . unserialize($item['picUrl']);
            $item['dateline'] = friendlyDate($item['dateline']);
            $users = $this->mindex->get_user_id($item['uid']);
            $item['username'] = $users['username'];
            $newList[] = $item;
        }
        return $newList;
    }

    /**
     * 添加附图
     * @param uid b_type s_type picUrl dateline price g_id title
     * @return bool
     */
    function  doDataPic(){
        $hid['uid'] = $this->input->get_post('uid')?$this->input->get_post('uid'):1;
        $hid['b_type'] = $this->input->get_post('b_type')?$this->input->get_post('b_type'):1;
        $hid['s_type'] = intval($this->input->get_post('s_type')) > 0 ?$this->input->get_post('s_type'):1;
        $hid['picUrl'] = $this->input->get_post('picUrl')?serialize($this->input->get_post('picUrl')):'';
        $hid['dateline'] = time();
        $hid['price'] = $this->input->get_post('price')?$this->input->get_post('price'):0;
        $hid['g_id'] = $this->input->get_post('g_id')?$this->input->get_post('g_id'):1;
        $hid['title'] = $this->input->get_post('title')?$this->input->get_post('title'):'';
        $s = $this->h_model->addHappyPic($hid);
        return $s ? true : false;

    }

    /**
     *获取评论
     * @param id cid
     * @return array
     */
    function getAppraisal(){
        $param['id'] = $this->input->get_post('id');
        $param['cid'] = $this->input->get_post('cid');
        $data = $this->gourmet->get_appraisal_list($param);
        $newData = array();
        if(count($data) > 0){
            foreach($data as $i){
                $users =  $this->mindex->get_user_id($i['uid_appraisal']);
                $i['username'] = $users['username'];
                $i['dateline'] = friendlyDate($i['dateline']);
                $newData[] = $i;
            }}
        echo json_encode(array('status'=>1,'data'=>$newData));
    }

    /**
     *添加评论
     */
    function doAppraisal(){
        $param['c_id'] = $this->input->get_post('c_id');
        $param['commented_id'] = $this->input->get_post('commented_id');
        $param['commented_info'] = $this->input->get_post('commented_info');
        $param['total_appraisal'] = $this->input->get_post('total_appraisal');
        $param['service_appraisal'] = $this->input->get_post('service_appraisal');
        $param['condition_appraisal'] = $this->input->get_post('condition_appraisal');
        $param['uid_appraisal'] =  $this->input->get_post('uid');;
        $param['dateline'] = time();
        if(!$param['uid_appraisal'] ||!$param['c_id'] ) return false;
        $this->gourmet->add_appraisal($param);
        return true;
    }

    /**
     *添加收藏
     * @param cid,uid
     * @return bool
     */
    function doSC(){
        $param['c_cid'] = $this->input->get_post('cid');
        $param['c_uid'] = $this->input->get_post('uid');
        if(! $param['c_cid'] || !$param['c_uid']){ echo json_encode(array('status'=>0));//show_error("请登录以后收藏！");
            return;
        }
        $param['c_type'] = self::CHANNELID;
        $param['c_timeline'] = time();
        $this->mindex->add_sc($param);
        echo json_encode(array('status'=>1));
    }
}