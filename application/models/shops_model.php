<?php
/**
 * @author gefc
 * @version 1.0
 * @desc 店铺相关函数
 */
    class Shops_model extends MY_Model{
        const TABLE="shops";
        function __construct(){
            parent::__construct();
        }
        
        /*
         * 添加新商铺
         */
        public function addShops($data)
        {
            $this->db->insert(self::TABLE,$data);
        }


        /*
        * 更新商铺信息
        */
        public function editShops($data)
        {
            //var_dump($data);exit;

            return $this->db->where('shopid', $data['shopid'])
                ->update(self::TABLE,
                    array('title' => $data['title'],
                        'summary' => $data['summary'],
                        'content' => $data['content'],
                        'phone' => $data['phone'],
                        'tag' => $data['tag'],
                        'channel_id'=>$data['channel_id'],
                        'type_id'=>$data['type_id'],
                        'photoid'=>$data['photoid']));
        }

        /**
         * 按规则获取商铺信息
         *
         */
        function getShops($data){
            if(isset($data['type'])){
                $this->db->where(array('type'=>$data['type']));
            }
            return $this->db->where(array('is_status'=>$data['is_status']))->get(self::TABLE,$data['limit'],$data['offset']);
        }

        /**
         * 按条件获取商铺列表
         *
         */

        function get_Shops_List($data){
            $sql='SELECT *,t.id as tid from shops s left join types t on s.type_id=t.id WHERE shopid>0';
            if($data['channel_id'])     $sql .= ' AND channel_id = '.$data['channel_id'];
            if(isset($data['type_id'])) $sql .= ' AND type_id = '.$data['type_id'];
            if(isset($data['area_id'])) $sql .= ' AND area_id = '.$data['area_id'];
            if(isset($data['isMyfind'])) $sql .= ' AND is_myfind = '.$data['isMyfind'];
            if(isset($data['search_key']))     $sql .= ' AND title like "%'.$data['search_key'].'%" ';
            //$sql .= ' AND g.state=2 ';
            switch($data['order']){
                case 1:
                    $sql .=' order by shopid desc';
                    break;
                case 2:
                    $sql .=' order by pubdate asc';
                    break;
            }

            $sql .=' limit '.$data['offset'].','.$data['limit'];
            //print_r($sql);exit;
            return $this->db->query($sql)->result_array();

        }

        /*
         * 与上面函数相配合，按条件获取店铺数量
         */
        function count_Shops_List($data){
            $sql='SELECT * from shops WHERE shopid>0';
            if($data['channel_id'])     $sql .= ' AND channel_id = '.$data['channel_id'];
            if(isset($data['type_id'])) $sql .= ' AND type_id = '.$data['type_id'];
            if(isset($data['area_id'])) $sql .= ' AND area_id = '.$data['area_id'];
            if(isset($data['isMyfind'])) $sql .= ' AND is_myfind = '.$data['isMyfind'];
            if($data['search_key'])     $sql .= ' AND title like "%'.$data['search_key'].'%" ';
            //$sql .= ' AND g.state=2 ';
            $c_count =  $this->db->query($sql)->num_rows();
            return $c_count;
        }

        /**
         * @param $data
         * @return mixed
         * 按ID查询商铺详情
         */
        function detail($data){
            $sql="SELECT * from shops s left join channel c on s.channel_id=c.cid WHERE s.shopid=".$data;
            return $this->db->query($sql)->row_array();
        }

        /**
         * @param $data
         * @return mixed
         * 搜索时用
         */
        function  get_search($data){
            $sql = "SELECT * from shops where title like '%".$data['c_title']."%'";
            return $this->db->query($sql)->result_array();
        }

        function get_types_list($data){
            $sql='SELECT * from shops s left join types t on s.type_id=t.id WHERE shopid>0';
            if($data['channel_id'])     $sql .= ' AND channel_id = '.$data['channel_id'];
            if(isset($data['type_id'])) $sql .= ' AND type_id = '.$data['type_id'];
            if(isset($data['area_id'])) $sql .= ' AND area_id = '.$data['area_id'];
            if($data['search_key'])     $sql .= ' AND title like "%'.$data['search_key'].'%" ';
            $sql .=' group by type_id';
            return $this->db->query($sql)->result_array();

        }


        /**
         * @param $data
         * @return mixed
         * 按用户ID获取店铺
         */
        function getShopsByUid($data)
        {
            return $this->db->where(array('is_status' => $data['status'], 'uid' => $data['uid']))->order_by('pubdate', 'desc')->get('shops', $data['limit'], $data['offset'])->result_array();
        }

        /**
         * 按审核状态获取自己添加的店铺数量
         */

        function  countShopsByUid($data)
        {

            return $this->db->where(array('is_status' => $data['status'], 'uid' => $data['uid']))->count_all_results(self::TABLE);
        }

        /**
         * 把店铺放入回收站，并没有从数据库中删除
         */
        public function delshops($data)
        {
            return $this->db->where(array('shopid' => $data['id'], 'uid' => $data['uid'], 'is_status' => $data['is_status']))->update(self::TABLE, array('is_status' => 3));
        }

        /*
         * 按店铺名称查找店铺
         */
        public function getShopByName($title){
            return $this->db->where(array('title'=>$title))->get('shops')->row_array();
        }

        /*
         * 按频道获取一定数量店铺并指定排序方式，主要用于不用分页的数据列表
         */
        public function getShopList($channel,$num,$orderby){
            return $this->db->where(array('channel_id'=>$channel))->limit($num)->order_by($orderby,"desc")->get('shops')->result_array();
        }

        /*
         * 获取我发现
         */
        public function getShopList_find($num,$orderby){
            return $this->db->where(array('is_myfind'=>1))->limit($num)->order_by($orderby,"desc")->get('shops')->result_array();
        }

        /*
         * 获取人工推荐
         */
        public function getShoplistRgtj($channel){
            $shop=$this->db->where(array('channel_id'=>$channel,'rgtj'=>1))->get('shops')->row_array();
            if(empty($shop)){
                $shop['title']="未指定";
                $shop['shopid']=0;
            }
            return $shop;

        }
          
    }
?>