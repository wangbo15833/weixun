<?php
include_once 'base.php';
?>
<?php startblock('header_css')?>

    <link href="<?php echo base_url();?>frontend/application/meituan/css/index.css" rel="stylesheet"
          xmlns="http://www.w3.org/1999/html">
<?php endblock() ?>

<?php startblock('content') ?>
<div id="content" >
    <div class="mainbox">
        <div class="head-section cf">
            <strong class="title-main">修改信息</strong>
            <span class="title-misc">(<em>*</em>为必填选项)</span>
            <hr>
        </div>
        <form id="signup-form" class="common-form" action="<?php echo WEB_URL?>play/happyUpdate" autocomplete="off" method="post">
            <div class="field-group field-group-type">
                <label for="txtShopName" class="label label_required">商户名：<em>*</em></label>
                <input type="text" value="<?php echo $g_info['name']?>" size="60" autocomplete="off" class="form-txt form-txt-l" name="txtName" id="txtName" maxlength="50">
            </div>
            <div class="field-group field-group-type">
                <label for="txtAltName" class="label">单价：</label>
                <input type="text" value="<?php echo $g_info['price']?>" size="60" autocomplete="off" class="form-txt form-txt-l" name="txtPrice" id="txtPrice" maxlength="50">
            </div>
            <div class="field-group">
                <label for="txtPhone1" class="label">类型：</label>
                <select class="form-select-sim form-select-sim-m J_ddlCategory" name="ddlCategory1" id="ddlCategory1">
                    <?php foreach($categorys as $cateItem):?>
                        <option ch value="<?php echo $cateItem['type_id']?>" <?php if($cateItem['type_id'] == $g_info['type']):?>selected="selected"<?php endif;?>><?php echo $cateItem['type_name']?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="field-group">
                <label for="txtPhone1" class="label">区域：<em>*</em></label>
                <select class="form-select-sim form-select-sim-m J_ddlRegion" name="ddlArea1" id="ddlArea1">
                    <?php foreach($citys as $cityItem):?>
                        <option value="<?php echo $cityItem['area_id']?>" <?php if($cityItem['area_id'] == $g_info['area_id']){?> selected="selected"<?php }?>><?php echo $cityItem['area_name']?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="field-group">
                <label for="txtPhone1" class="label">地址：</label>
                <input type="text" value="<?php echo $g_info['addr']; ?>" size="60" autocomplete="off" class="form-txt form-txt-m" name="txtAddress" id="txtAddress" maxlength="100">
            </div>

            <div class="field-group">
                <label for="txtPhone1" class="label">电话：</label>
                <input type="text" value="<?php echo $g_info['phone']; ?>" size="60" autocomplete="off" class="form-txt form-txt-m" name="txtPhone" id="txtPhone" maxlength="20">
            </div>
            <div class="field-group">
                <label for="txtPhone2" class="label">标签：</label>
                <input type="text" value="<?php echo $g_info['tag']; ?>" size="60" autocomplete="off" class="form-txt form-txt-m" name="txtTag" id="txtTag" maxlength="20">
            </div>
            <div class="field-group">
                <label for="txtPhone2" class="label">简介：</label>
                <textarea id="myContent" name="myContent"><?php echo $g_info['summary']; ?></textarea>
            </div>
            <div class="field-group">
                <strong class="btn-type-b btn-fn-c"><input type="submit" class="form-btn" value="提交修改" id="btnUpdateShop"></strong>
                <strong class="btn-type-b btn-fn-d"><input type="button" class="form-btn" value="取消" id="btnUpdateCancled"></strong>
                <input type="hidden" value="<?php echo $g_info['id']; ?>" name="hid_id" id="hid_id">
            </div>
        </form>
    </div>
    <?php endblock() ?>

    <?php startblock('foot_js')?>
    <script type="text/javascript" src="http://api.map.baidu.com/api?v=1.5&ak=D95ab8521dabc49243d995d83217505d"></script>
    <script type="text/javascript" src="<?php echo base_url() ?>frontend/Public/kindeditor/kindeditor-all.js"></script>
    <script type="text/javascript" src="<?php echo base_url() ?>frontend/Public/kindeditor/lang/zh_CN.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            var editor;
            KindEditor.ready(function(K) {
                editor = K.create('textarea[name="myContent"]', {
                    resizeType : 1,
                    allowPreviewEmoticons : false,
                    autoHeightMode : true,
                    allowImageUpload : true,
                    minWidth:400,
                    items : [
                        'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold', 'italic', 'underline',
                        'removeformat', '|', 'justifyleft', 'justifycenter', 'justifyright', 'insertorderedlist',
                        'insertunorderedlist', '|', 'emoticons', 'image', 'link']
                });
            });
            $('#btnUpdateShop').click(function(){
                // $('#signup-form').submit();
            });

            /*     var map = new BMap.Map("container");          // 创建地图实例
             var point = new BMap.Point( $('#hid_map_x').val(),  $('#hid_map_y').val());  // 创建点坐标
             map.centerAndZoom(point, 15);                 // 初始化地图，设置中心点坐标和地图级别
             // window.setTimeout(function(){       //2秒后平移地图
             //     map.panTo(new BMap.Point(116.409, 39.918));
             //  }, 2000);
             map.addControl(new BMap.NavigationControl());//标准地图控件
             map.addControl(new BMap.ScaleControl()); //比例尺控件
             map.addControl(new BMap.OverviewMapControl());
             map.addControl(new BMap.MapTypeControl());//地图显示类型控件 ：普通、卫星、三维 地图
             var marker = new BMap.Marker(point);        // 创建标注
             map.addOverlay(marker);                     // 将标注添加到地图中
             */ });

    </script>

<?php endblock() ?>