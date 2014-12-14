<?php
/**
 * Created by JetBrains PhpStorm.
 * Author: Lynx
 * Date: 14-3-1
 * Time: 上午9:07
 * To change this template use File | Settings | File Templates.
 */
const EARTH_RADIUS = 6371;
class Goods_model extends MY_Model {

    function __construct(){
        parent::__construct();
    }

    function returnSquarePoint($lng, $lat,$distance = 0.5){

        $dlng =  2 * asin(sin($distance / (2 * EARTH_RADIUS)) / cos(deg2rad($lat)));
        $dlng = rad2deg($dlng);

        $dlat = $distance/EARTH_RADIUS;
        $dlat = rad2deg($dlat);

        return array(
            'left-top'=>array('lat'=>$lat + $dlat,'lng'=>$lng-$dlng),
            'right-top'=>array('lat'=>$lat + $dlat, 'lng'=>$lng + $dlng),
            'left-bottom'=>array('lat'=>$lat - $dlat, 'lng'=>$lng - $dlng),
            'right-bottom'=>array('lat'=>$lat - $dlat, 'lng'=>$lng + $dlng)
        );
    }

    //获取周边
    function getGoodsAround($param){
        $squares = $this->returnSquarePoint($param['map_x'], $param['map_y']);
        $sql = "select * from goods g left join shops s on g.shopid=s.id where map_y<>0 and map_y>{$squares['right-bottom']['lat']} and map_y<{$squares['left-top']['lat']} and map_x>{$squares['left-top']['lng']} and map_x<{$squares['right-bottom']['lng']} ";
        return $this->db->query($sql)->result_array();
    }

    function getHotGoods(){
        return $this->db->where('channel',1)->get('goods');
    }
}