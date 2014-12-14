<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Administrator
 * Date: 13-8-27
 * Time: 下午2:48
 * To change this template use File | Settings | File Templates.
 */

class PShop extends CI_Controller{
    const CHANNELID = 1;
    const PAGESIZE = 20;
    function __construct(){
        parent :: __construct();
        $this->load->library('HessianPHP_lib');
        $this->load->model('index_model','mindex');
    }

    function index(){
        $server = new HessianService(new PShop(), array('displayInfo' => true));
        $server -> handle();
    }

    /**
     * 获取购物数据
     *@param $page
     *@return array
     */
    function getShopList(){
        $page = $this->input->get_post('page');
        $offset = ($page-1) * self::PAGESIZE;
        $param['limit'] = self::PAGESIZE;
        $param['offset'] = $offset;
        $param['channel_id'] = self::CHANNELID;
        $rel =   $this->mindex->get_c_info($param);
        $counts =  $this->mindex->count_c_info($param);
        return json_encode(array('count'=>$counts, 'list'=> $rel));
    }


    /**
     *完善购物数据

    function updateData(){
//弃用
    }*/

    /**
     *添加购物图片

    function doDataPic(){
//弃用
    }*/

    /**
     *添加评论
     * @param cid uid message
     * @result bool
     */
    function doMessage(){
        $param['commodity_id'] = $this->input->get_post('cid');
        $param['uid'] = $this->input->get_post('uid');
        if(! $param['commodity_id'] || !$param['uid']){ echo json_encode(array('status'=>0));
            return;
        }
        $param['type'] = 1;
        $param['message'] = $this->input->get_post('message');
        $param['dateline'] = time();

        $this->mindex->add_message($param);
        echo json_encode(array('status'=>1));
    }

    /**
     * 获取评论
     * @param cid
     * @return array
     */
    function getMessage(){
        $param['id'] = $this->input->get_post('c_id');
        $data = $this->mindex->get_message_list($param);
        $newData = array();
        foreach($data as $i){
            $users =  $this->mindex->get_user_id($i['uid']);
            $i['username'] = $users['username'];
            $i['dateline'] = friendlyDate($i['dateline']);
            $newData[] = $i;
        }
        echo json_encode(array('status'=>1,'data'=>$newData));
    }

    /**
     *收藏
     * @param cid,uid
     * @return bool
     */
    function doShowcang(){
        $param['c_cid'] = $this->input->get_post('cid');
        $param['c_uid'] = $this->input->get_post('uid');
        if(! $param['c_cid'] || !$param['c_uid']){ echo json_encode(array('status'=>0));//show_error("请登录以后收藏！");
            return;
        }
        $param['c_type'] = self::CHANNELID;
        $param['c_timeline'] = time();
		$data=array(
			 'c_uid'=>$param['c_uid'],
			 'c_cid'=>$param['c_cid'],
			 'c_type'=>$param['c_type'],
			 'c_timeline'=>$param['c_timeline']
		 );
        $this->mindex->add_sc($data);
        echo json_encode(array('status'=>1));
    }

    /**
     *添加新购物数据

    function addShop(){
        return false;
    }*/
}