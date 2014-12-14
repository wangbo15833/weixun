<?php
class Work_model extends MY_Model {
    const DISTRICT = 'district';
	const WPOSITION = 'wposition';
	const WORK = 'work';
        function __construct(){
            parent ::__construct();
			date_default_timezone_set("PRC");
        }


    /*
     * 增
     */

    /*
     * 添加招聘信息
     */
    function addwork($data){
        return $this->db->insert(self::WORK,$data);
    }


    /*
     * 删
     */


    /*
     * 删除招聘信息
     */
    function delwork($id){
        return $this->db->where('id',$id)->delete(self::WORK);
    }

    /*
     * 改
     */


    /*
     * 编辑招聘信息
     */
    function editwork($id,$data){
        return $this->db->where('id',$id)->update(self::WORK,$data);
    }



}
?>