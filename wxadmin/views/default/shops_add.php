
<?php
    include_once 'base.php';
?>
<?php startblock('article') ?>
       <div class="commodity_css">
           <h1>添加新商铺</h1><hr/>
        <form id="modify_pwd_table" class="addNewShops" method="post" action="<?php echo WEB_URL?>shops/addShopManager">
            
            <input type="hidden" name="mstatus" id="mstatus" value="1" />
            <table>
                <tr>
                    <td>店铺掌柜:</td><td><input type="text" name="suid" id="suid" value="" />
                                         <input type="hidden" name="h_suid" id="h_suid" value="<?php echo $h_suid?>"  />
                    </td>
                </tr>
                <tr>
                    <td>标&nbsp;&nbsp;&nbsp;&nbsp;题:</td><td><input type="text" name="title" id="title" /></td>
                </tr>
                <tr>
                    <td>简&nbsp;&nbsp;&nbsp;&nbsp;介:</td><td><textarea name="summary" style="width:300px;height:50px;"></textarea></td>
                </tr>
                <tr>
                    <td>内&nbsp;&nbsp;&nbsp;&nbsp;容:</td><td><textarea name="content" style="width:700px;height:300px;visibility:hidden;"></textarea></td>
                </tr>
                
                <tr>
                    <td>联系电话:</td><td><input type="text" name="phone" maxlength="20"/></td>
                </tr>
                <tr>
                    <td>所在地区：</td><td>

                        <select id="areas" name="areas"><option value="">--区、县</option></select><i>注：请慎重填写，创建后不可更改</i>
                         
    
                    </td>
                </tr>
                <tr>
                    <td>地址:</td><td><input type="text" id="address" name="address" maxlength=""/></td>
                </tr>
                <tr><td>地图：</td><td>
                    <script type="text/javascript" src="http://api.map.baidu.com/api?v=1.5&ak=D95ab8521dabc49243d995d83217505d"></script>
                    <div id="container" style="height: 200px;"></div>
                    x-坐标：<input type="text" id="map_x" name="map_x"/>y-坐标：<input type="text" id="map_y" name="map_y"/></td>
                </tr>
                <tr>
                    <td>属性标签:</td><td><input type="text" name="tag" /><i>注：多个属性用";"隔开</i></td>
                </tr>
                <tr>
                    <td colspan="2"><div id="picK"></div><input type="hidden" name="pics" id="pics" value=""></td>
                </tr>
                <tr>
                    <td>上传图片:</td>
                    <td>
                        <div id="picK"></div>
                        <input type="file" name="Filedata" id="Filedata" multiple="true" />
                        <h5 style="color: red;">仅支持jpg, jpeg, gif,png等 图片格式上传</h5>
                    </td>
                </tr>
                
                <tr>
                    <td colspan="2" style="text-align: center">
                        <input type="hidden" name="token" value="<?php echo $token?>"/>
                        <input type="hidden" id="hid_pics" name="hid_pics"/>
                        <input id="submit" type="submit"  value="提&nbsp;&nbsp;交"/></td>
                </tr>
            </table>
        </form>
        </div>
<?php endblock() ?>

<?php startblock('foot_js')?>
    <script type="text/javascript" src="<?php echo base_url() ?>frontend/Public/kindeditor/kindeditor-all.js"></script>
    <script type="text/javascript" src="<?php echo base_url() ?>frontend/Public/kindeditor/lang/zh_CN.js"></script>
	<script type="text/javascript" src="<?php echo base_url()?>frontend/wxadmin/default/js/base_addjs.js"></script>
	<script type="text/javascript" src="<?php echo base_url()?>frontend/wxadmin/default/js/baidumap.js"></script>

<?php endblock() ?>