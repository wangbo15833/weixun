<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Lynx
 * Date: 14-2-9
 * Time: 上午10:25
 * To change this template use File | Settings | File Templates.
 */

class Shopkeeper extends MY_Controller{
    function __construct() {
        parent :: __construct();
        $this->load->model('shopkeeper_model','mshopkeeper');

    }

    /**
     * 管理商户会员
     */



}