<?php
include_once 'base.php';
?>
<?php startblock('header_css') ?>
<link href="<?php echo base_url();?>frontend/application/meituan/css/travel.css" rel="stylesheet" type="text/css" />
<style>
    .frmInput{
        margin: 20px;
    }
    tr{border: 1px solid #000000;}
</style>
<?php endblock() ?>
<?php startblock('content') ?>
<div id="" style=" width: auto; height: 700px; padding: 0px;">

    <div>
        <a href="javascript:;"><input type="button" id="btn_train" alt="本地火车售票查询" value="火车售票点"/></a>
        <a href="javascript:;"><input type="button" id="btn_aircraft" alt="本地飞机售票查询"  value="飞机售票点"/></a>
        <a href="javascript:;"><input type="button" id="btn_car" alt="本地租车服务查询"  value="租车"/></a>
        <!--
        <a href="javascript:;"><input type="button" id="btn_travel" alt="本地旅行社查询"  value="旅行社"/></a>
        -->
        <a href="javascript:;"><input type="button" id="btn_Stations" alt="本地加油站查询"  value="加油站"/></a>
        <a href="javascript:;"><input type="button" id="btn_trainTime" alt="火车时刻表查询"  value="火车时刻表"/></a>
        <a href="javascript:;"><input type="button" id="btn_flyTime" alt="飞机时刻表查询"  value="飞机时刻表"/></a>

        <div  id="selectBox" class="">
            <select id="selectChange"><option value="1">本地搜索</option><option value="2">公交搜索</option><option value="3">自驾搜索</option></select>
            <div id="box1" class=""><input type="text" id="box1_txt" name="box1_txt" autocomplete ='true'/><input type="button" id="box1_btn" name="box1_btn" value="搜索" /> </div>
            <div id="box2" class="Hide"><input type="text" id="box2_start" name="box2_start"/>-<input type="text" id="box2_end" name="box2_end" />
                <input type="button" id="box2_btn" name="box2_btn" value="搜索"/></div>
            <input type="hidden" id="hid_box1_txt" name="hid_box1_txt" value=""/>
            <input type="hidden" id="hid_box2_start" name="hid_box2_start" value=""/>
            <input type="hidden" id="hid_box2_end" name="hid_box2_end" value=""/>
            <input type="hidden" id="hid_select_id" name="hid_select_id" value=""/>
        </div>
        <div id="trainTime" style="display:none; padding: 20px;">
            <table cellspacing="0" cellpadding="4" bordercolor="#dcdcdc" style="border-collapse: collapse;" rules="none" frame="box">
                <tbody>
                <tr>
                    <td style="color: #000000; font-weight: normal;" class="frmText">出发地:</td>
                    <td><input type="text" id="t_startCity" name="t_departureAirport" size="20" class="frmInput"></td>
                    <td style="color: #000000; font-weight: normal;" class="frmText">目的地:</td>
                    <td><input type="text" id="t_lastCity" name="t_arrivalAirport" size="20" class="frmInput"></td>
                    <td style="color: #000000; font-weight: normal;" class="frmText">出发时间:</td>
                    <td><input type="text" id="t_theDate" name="t_date" size="10" class="frmInput">
                    </td>

                    <td></td>
                    <td align="right"> <input type="button" id="t_btn" class="button" value=""></td>
                </tr>
                </tbody></table>
        </div>
        <div id="flyTime" style="display:none; padding: 20px;">
            <table cellspacing="0" cellpadding="4" bordercolor="#dcdcdc" style="border-collapse: collapse;" rules="none" frame="box">
                <tbody>
                <tr>
                    <td style="color: #000000; font-weight: normal;" class="frmText">出发地:</td>
                    <td><input type="text" id="startCity" name="departureAirport" size="20" class="frmInput"></td>
                    <td style="color: #000000; font-weight: normal;" class="frmText">目的地:</td>
                    <td><input type="text" id="lastCity" name="arrivalAirport" size="20" class="frmInput"></td>
                    <td style="color: #000000; font-weight: normal;" class="frmText">出发时间:</td>
                    <td><input type="text" id="theDate" name="date" size="10" class="frmInput">
                    </td>
                    <td></td>
                    <td align="right"> <input type="button" id="dy" class="button" value=""></td>
                </tr>
                </tbody></table>
        </div>
    </div>
	<div id="r-result" style="height: 620px;width:25%;float:left; margin-right: 3px;overflow:auto;"></div>
    <div id="allmap" style="height: 620px;width:74.3%;border:1px solid gray;float:left; border-right:2px solid #bcbcbc; margin-right: 0px;"></div>

    <div id="showList" style="min-height: 80%; width: 99%;background-color: #ffffff; display: none">
    </div>
</div>
<?php endblock() ?>

<?php startblock('foot_js') ?>
    <script type="text/javascript" src="http://api.map.baidu.com/api?v=1.5&ak=D95ab8521dabc49243d995d83217505d"></script>
    <script src="<?php echo base_url() ?>frontend/Public/jquery-ui/ui/jquery.ui.datepicker.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>frontend/application/meituan/js/common/travel.js"></script>

<?php endblock() ?>