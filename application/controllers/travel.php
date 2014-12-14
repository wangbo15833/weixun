<?php
/**
 * Created by JetBrains PhpStorm.
 * User: gefc
 * Date: 13-6-26
 * Time: 下午2:57
 * 美食频道 相关函数
 */
class Travel extends MY_Controller{
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
		$this->load->view('meituan/travel_mapTravel.html');
	}

    /**
     * 地图页面
     */
    function showTravelList(){
		$this->load->view('meituan/travel_list1',array('type'=>4));
	}

    function getTravel(){
        $data['name'] = "点击访问";
        $data['value'] = '';
        $data['needAz'] = 'false';
        $data['cid'] = 4;
        echo json_encode(array($data));
    }
	/**
	本地、公交、自驾 搜索
     * #已丢弃
	*/
	function searchControl(){
		$this->load->view('meituan/travel_control');
	}

}
?>