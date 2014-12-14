
<?php
    include_once 'base.php';
?>
<?php startblock('article') ?>
       <div class="commodity_css">
           <h1>添加目录访问配置信息</h1><hr/>
        <form id="addGourmet" name="addGourmet" class="addNewGourmet" method="post" action="<?php echo WEB_URL?>Configuration/drectory/addD">
            <table>
                <tr>
                    <td>名&nbsp;&nbsp;&nbsp;&nbsp;称:</td><td><input type="text" name="name" id="name" /></td>
                </tr>
                <tr>
                    <td>名称属性:</td><td><input type="text" name="name_param" id="name_param"></td>
                </tr>
                <tr>
                    <td>路&nbsp;&nbsp;&nbsp;&nbsp;径:</td><td><input type="text" name="url" id="url"></td>
                </tr>
                
                <tr>
                    <td>联系电话:</td><td><input type="radio" checked="" name="is_type" value="1" maxlength="20"/>普通会员
                                        <input type="radio" name="is_type" value="10" maxlength="20"/>管理员
                                        <input type="radio" name="is_type" value="100" maxlength="20"/>超级管理员</td>
                </tr>
                <tr>
                    <td colspan="2" style="text-align: center">                        <input type="hidden" value="100" id="typeState" name="typeState">
                        <input id="submit" type="submit"  value="提&nbsp;&nbsp;交"/></td>
                </tr>
            </table>
        </form>
        </div>
<?php endblock() ?>

<?php startblock('foot_js')?>
    <script type="text/javascript" src="http://api.map.baidu.com/api?v=1.5&ak=D95ab8521dabc49243d995d83217505d"></script>
    <script type="text/javascript" src="<?php echo base_url() ?>frontend/Public/kindeditor/kindeditor-all.js"></script>
    <script type="text/javascript" src="<?php echo base_url() ?>frontend/Public/kindeditor/lang/zh_CN.js"></script>
    <script type="text/javascript" src="<?php echo base_url() ?>frontend/wxadmin/default/js/base_addjs.js"></script>

<?php endblock() ?>