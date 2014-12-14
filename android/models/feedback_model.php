<?php
/**
 * Created by JetBrains PhpStorm.
 * Author: Lynx
 * Date: 14-3-28
 * Time: 上午10:14
 * To change this template use File | Settings | File Templates.
 */

class Feedback_model extends MY_Model{
    const TABLE="feedback";
    function __construct(){
        parent::__construct();
    }

    function feedbackAdd($param){
        return $this->db->insert(self::TABLE, $param);
    }

}