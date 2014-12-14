<?php
class Work_model extends MY_Model {
    const DISTRICT = 'district';
	const WPOSITION = 'wposition';
	const TABLE = 'work';
        function __construct(){
            parent ::__construct();
			date_default_timezone_set("PRC");
        }
    /*
     * 增
     */
    function addwork($data){
        return $this->db->insert(self::TABLE,$data);
    }
    
    /*
     * 删
     */

    function delwork($id){
        return $this->db->where('id',$id)->delete(self::TABLE);
    }
    
    /*
     * 改
     */

    function editwork($id,$data){
        return $this->db->where('id',$id)->update(self::TABLE,$data);
    }
    

    /*
 * 查
 */

    /*
     * 分页获取自己添加的招聘信息列表
     */
    function userworklist($data){
        return $this->db->where('uid',USER_ID)->get(self::TABLE,$data['limit'], $data['offset'])->result_array();
    }

    /*
     * 获取自己添加的招聘信息数量
     */
    function userworklist_count(){
        return $this->db->where('uid',USER_ID)->get(self::TABLE)->num_rows();
    }



    /*
     * 分页获取所有招聘信息
     */
    function allUserWorklist($data){
        $sql ='select * from work limit ? , ?';
        return $this->db->query($sql, array($data['offset'], $data['limit']))->result_array();
    }

    /*
     * 获取所有招聘信息数量
     */
    function allUserWorksl(){
        $sql ='select * from work';
        return $this->db->query($sql)->num_rows();
    }
    
    /*
     * 按工作id查询工作信息
     */
    function getWorkByID($id){
        return $this->db->where('id',$id)->get(self::TABLE)->row_array();
    }
    
    function getuserwork($id){
        return $this->db->where('uid',$id)->get(self::TABLE)->result_array();
    }
    function userwork($id){
        return $this->db->where('id',$id)->get(self::TABLE)->row_array();
    }


		


/*获取所有工作列表*/
    function get_Work_List($data){
        $sql="select * from work where id > 0";
        if(isset($data['position1'])) $sql .= ' AND position1 = '.$data['position1'];
        if(isset($data['areaid'])) $sql .= ' AND area_id = '.$data['areaid'];
        if(isset($data['sname'])) $sql .= ' AND name like "%'.$data['sname'].'%" ';


        $sql .=' limit '.$data['offset'].','.$data['limit'];
        return $this->db->query($sql)->result_array();

    }

/*
 * 获取所有工作数量
 */
    function count_Work_List($data){
        $sql="select * from work where id > 0";
        if(isset($data['position1'])) $sql .= ' AND position1 = '.$data['position1'];
        if(isset($data['areaid'])) $sql .= ' AND area_id = '.$data['areaid'];
        if(isset($data['sname'])) $sql .= ' AND name like "%'.$data['sname'].'%" ';
        $c_count =  $this->db->query($sql)->num_rows();
        return $c_count;
    }

    /*
     * 获取一定数量的找活条目
     */

    function getWorksByLimit($param){
        return $this->db->get('work',$param,0)->result_array();
    }
}		
?>