<?php
    include_once 'base.php';
?>
<?php startblock('article') ?>
       <div class="commodity_css">
           <h1>添加新商铺</h1><hr/>
        <form id="modify_pwd_table" class="addNewShops" method="post" action="<?php echo WEB_URL?>manageShop/addShopManager">
            
            <input type="hidden" name="mstatus" id="mstatus" value="1" />
            <table>
                <tr>
                    <td>店铺名称:</td>
                    <td><input type="text" name="title" id="title" /></td>
                </tr>
                <tr>
                    <td>所属频道:</td>
                    <td>
                        <select id="channelid" name="channelid">
                            <option value="">--请选择--</option>
                            <?php foreach( $channels as $cItem):?>
                                <option value="<?php echo $cItem['cid']?>"><?php echo $cItem['name']?></option>
                            <?php endforeach;?>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td>所属类别:</td>
                    <td>
                        <select id="typeid" name="typeid">
                            <option value="">--请选择--</option>

                        </select>
                    </td>
                </tr>

                <tr>
                    <td>店铺简介:</td><td><textarea name="summary" style="width:300px;height:50px;"></textarea></td>
                </tr>
                <tr>
                    <td>店铺详情:</td><td><textarea name="content" style="width:700px;height:300px;visibility:hidden;"></textarea></td>
                </tr>
                
                <tr>
                    <td>联系电话:</td><td><input type="text" name="phone" maxlength="20"/></td>
                </tr>
                <tr>
                    <td>所在地区：</td>
                    <td>
                        <select name="province" id="province">
                            <option value="-1">--省--</option>
                        </select>

                        <select name="city" id="city">
                            <option value="-1">--市--</option>
                        </select>

                        <select id="areaid" name="areaid">
                            <option value="">--区、县</option>
                        </select><i>注：请慎重填写，创建后不可更改</i>
                         
    
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
                        <input type="hidden" name="h_suid" id="h_suid" value="<?php echo $h_suid?>"  />
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
	<script type="text/javascript" src="<?php echo base_url() ?>frontend/application/manageShop/js/base_addjs.js"></script>
	<script type="text/javascript" src="<?php echo base_url()?>frontend/application/manageShop/js/baidumap.js"></script>

<script>
    $(document).ready(function() {
        //get_captcha();
        $('#channelid').change(function() {
            var channelid = $('#channelid').val();
            //alert(base_url);
            $.ajax({
                url: base_url +'manageShop/getTypeList',
                type:'post',
                dataType:'json',
                data:{param_id:channelid},
                success:function(data){
                    if(data.status == 1){
                        data = data.data;
                        var count=data.length;
                        var _str = '<option value="">请选择</option>';
                        for(j=0;j< count; j++){
                            _str +='<option value="'+data[j].typeid+'">'+data[j].name+'</option>';
                        }
                        $('#typeid').html(_str);
                        $('#typeid').css('display','');
                        //$('#county').html('<option value="">--区、县</option>');
                    }
                }
            })
        })
    });
</script>

<script>
    $(document).ready(function(){
        $.ajax({
            url: web_url +'index.php/district/getDistrictByPid',
            type:'post',
            dataType:'json',
            data:{param_id:0},
            success:function(data){
                if(data.status == 1){
                    data = data.data;
                    var count=data.length;
                    var _str = '';
                    for(j=0;j< count; j++){
                        _str +='<option value="'+data[j].did+'">'+data[j].dname+'</option>';
                    }
                    $('#province').append(_str);
                }
            }
        })

        $('#province').change(function() {
            var pid = $('#province').val();

            $.ajax({
                url: web_url +'index.php/district/getDistrictByPid',
                type:'post',
                dataType:'json',
                data:{param_id:pid},
                success:function(data){
                    if(data.status == 1){
                        data = data.data;
                        var count=data.length;
                        var _str = '';
                        for(j=0;j< count; j++){
                            _str +='<option value="'+data[j].did+'">'+data[j].dname+'</option>';
                        }
                        $('#city').append(_str);
                    }
                }
            })
        })

        $('#city').change(function() {
            var pid = $('#city').val();

            $.ajax({
                url: web_url +'index.php/district/getDistrictByPid',
                type:'post',
                dataType:'json',
                data:{param_id:pid},
                success:function(data){
                    if(data.status == 1){
                        data = data.data;
                        var count=data.length;
                        var _str = '';
                        for(j=0;j< count; j++){
                            _str +='<option value="'+data[j].did+'">'+data[j].dname+'</option>';
                        }
                        $('#areaid').html(_str);
                    }
                }
            })
        })
    });

</script>

<?php endblock() ?>