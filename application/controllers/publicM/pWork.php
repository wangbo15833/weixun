<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Administrator
 * Date: 13-12-27
 * Time: 上午13:53
 * To change this template use File | Settings | File Templates.
 */

class PWork extends CI_Controller {
	const CHANNELID = 9;
	const PAGESIZE=5;
    function __construct(){
        parent :: __construct();
        $this->load->library('HessianPHP_lib');
		$this->load->helper('common');
		$this->load->model('work_model','wmodel');
    }
	 /**
     *添加找活信息
     * @param ctype district page
     * @return array
     */
	function addwork(){
		$data['name'] = get_post('name') ? htmlspecialchars(get_post('name')) : '';
		$data['size'] = get_post('size') ? htmlspecialchars(get_post('size')) : '';
		$data['property'] = get_post('property') ? htmlspecialchars(get_post('property')) : '';
		$data['profession'] = get_post('profession') ? htmlspecialchars(get_post('profession')) : '';
		$data['zwork'] = get_post('zwork') ? htmlspecialchars(get_post('zwork')) : '';
		$data['fwork'] = get_post('fwork') ? htmlspecialchars(get_post('fwork')) : '';
		$data['title'] = get_post('title') ? htmlspecialchars(get_post('title')) : '';
		$data['treatment'] = get_post('treatment') ? htmlspecialchars(get_post('treatment')) : '';
		$data['education'] = get_post('education') ? htmlspecialchars(get_post('education')) : '';
		$data['life'] = get_post('life') ? htmlspecialchars(get_post('life')) : '';
		$data['number'] = get_post('number') ? htmlspecialchars(get_post('number')) : '';
		$data['content'] = get_post('content') ? htmlspecialchars(get_post('content')) : '';
		$data['county'] = get_post('county') ? htmlspecialchars(get_post('county')) : '';
		$data['address'] = get_post('address') ? htmlspecialchars(get_post('address')) : '';
		$data['contact'] = get_post('contact') ? htmlspecialchars(get_post('contact')) : '';
		$data['jd'] = get_post('jd') ? htmlspecialchars(get_post('jd')) : '';
		$areaname=$this->wmodel->get_areaname($data['county']);
		$data['area_name']=$areaname['area_name'];
		$fname=$this->wmodel->get_fname($data['fwork']);
		$data['zfname']=$fname['zfname'];
		$time=date("Y-m-d H:i:s",time());
		$creattime=strtotime($time);
		$param=array(
			'name'=>$data['name'],
			'size'=>$data['size'],
			'property'=>$data['property'],
			'profession'=>$data['profession'],
			'title'=>$data['title'],
			'description'=>$data['content'],
			'treatment'=>$data['treatment'],
			'education'=>$data['education'],
			'life'=>$data['life'],
			'number'=>$data['number'],
			'contact'=>$data['contact'],
			'area_id'=>$data['county'],
			'area_name'=>$data['area_name'],
			'address'=>$data['address'],
			'type_zid'=>$data['zwork'],
			'type_fid'=>$data['fwork'],
			'position'=>$data['zfname'],
			'creattime'=>$creattime,
			'jd'=>$data['jd'],
			'uid'=>UID
		);
		$result=$this->wmodel->addwork($param);
		return $result ? true : false;
    }
	/**
     *获取会员自己添加找活的列表信息
     * @param ctype district page
     * @return array
     */
	function getuserwork($id=1){
		$result=$this->wmodel->getuserwork($id);
		echo json_encode(array('data'=>$result));
	}
	 /**
     *查看会员自己添加找活的详细信息
     * @param ctype district page
     * @return array
     */
	function ckwork($id=1){
		$row=$this->wmodel->userwork($id);
		echo json_encode(array('data'=>$row));
	}
	 /**
     *编辑会员自己添加找活的信息
     * @param ctype district page
     * @return array
     */	
	function editworktj($id){
		$data['name'] = get_post('name') ? htmlspecialchars(get_post('name')) : '';
		$data['size'] = get_post('size') ? htmlspecialchars(get_post('size')) : '';
		$data['property'] = get_post('property') ? htmlspecialchars(get_post('property')) : '';
		$data['profession'] = get_post('profession') ? htmlspecialchars(get_post('profession')) : '';
		$data['zwork'] = get_post('zwork') ? htmlspecialchars(get_post('zwork')) : '';
		$data['fwork'] = get_post('fwork') ? htmlspecialchars(get_post('fwork')) : '';
		$data['title'] = get_post('title') ? htmlspecialchars(get_post('title')) : '';
		$data['treatment'] = get_post('treatment') ? htmlspecialchars(get_post('treatment')) : '';
		$data['education'] = get_post('education') ? htmlspecialchars(get_post('education')) : '';
		$data['life'] = get_post('life') ? htmlspecialchars(get_post('life')) : '';
		$data['number'] = get_post('number') ? htmlspecialchars(get_post('number')) : '';
		$data['content'] = get_post('content') ? htmlspecialchars(get_post('content')) : '';
		$data['county'] = get_post('county') ? htmlspecialchars(get_post('county')) : '';
		$data['address'] = get_post('address') ? htmlspecialchars(get_post('address')) : '';
		$data['contact'] = get_post('contact') ? htmlspecialchars(get_post('contact')) : '';
		$data['jd'] = get_post('jd') ? htmlspecialchars(get_post('jd')) : '';
		$areaname=$this->wmodel->get_areaname($data['county']);
		$area_name=$areaname['area_name'];
		$fname=$this->wmodel->get_fname($data['fwork']);
		$zfname=$fname['zfname'];
		$time=date("Y-m-d H:i:s",time());
		$creattime=strtotime($time);
		$param=array(
			'name'=>$data['name'],
			'size'=>$data['size'],
			'property'=>$data['property'],
			'profession'=>$data['profession'],
			'title'=>$data['title'],
			'description'=>$data['content'],
			'treatment'=>$data['treatment'],
			'education'=>$data['education'],
			'life'=>$data['life'],
			'number'=>$data['number'],
			'contact'=>$data['contact'],
			'area_id'=>$data['county'],
			'area_name'=>$area_name,
			'address'=>$data['address'],
			'type_zid'=>$data['zwork'],
			'type_fid'=>$data['fwork'],
			'position'=>$zfname,
			'creattime'=>$creattime,
			'jd'=>$data['jd'],
			'uid'=>UID
		);
		$result=$this->wmodel->editwork($id,$param);
		return $result ? true : false;
	}
	 /**
     *删除会员自己添加找活的信息
     * @param ctype district page
     * @return array
     */	
	function delwork($id){
		$result=$this->wmodel->delwork($id);
		return $result ? true : false;
	}
}
?>