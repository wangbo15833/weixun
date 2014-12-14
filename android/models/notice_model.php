<?php
/**
 * Created by JetBrains PhpStorm.
 * Author: Lynx
 * Date: 14-4-25
 * Time: 上午11:36
 * To change this template use File | Settings | File Templates.
 */

class Notice_model extends MY_Model{
    function __construct(){
        parent::__construct();
    }

    /*
     * 发送通知
     */
    function noticeAdd($param){
        $this->db->insert('notice', $param);
        return $this->db->insert_id();
    }

    function noticeMapAdd($noticeid,$ruid){
        $data=array('noticeid'=>$noticeid,'ruid'=>$ruid);
        return $this->db->insert('noticemap',$data);
    }

    /*
     * 通过Receiver字段获取通知
     */
    function getNoticeByReciver($param){
        return $this->db->from('noticemap')->join('notice','notice.noticeid=noticemap.noticeid')->where(array('ruid'=>$param))->get()->result_array();
    }


    /*
     * 删除个人通知
     */
    function noticeDel($param){
        return $this->db->where(array('id'=>$param))->delete('noticemap');
    }

	function detail($param){
		return $this->db->from('noticemap')->join('notice','notice.noticeid=noticemap.noticeid')->where(array('id'=>$param))->get()->row_array();
	}


}