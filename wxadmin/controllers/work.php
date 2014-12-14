<?php
class Work extends MY_Controller{
    const CHANNELID = 9;
    function __construct(){
        parent :: __construct();
        $this->load->model('work_model','wmodel');
        $this->load->model('types_model','mtypes');
        $this->load->model('wposition_model','mwposition');

        $this->load->helper('common');

        // $this->load->library('Pinyin');
    }










}
?>