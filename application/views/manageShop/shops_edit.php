<?php
    include_once 'base.php';
?>
<?php startblock('article') ?>
    <div class="commodity_css">
        <h1>编辑店铺信息</h1><hr>
        <form id="modify_pwd_table" class="" method="post" action="<?php echo WEB_URL?>manageShop/editShopsInfo">

                <table>
                    <tr>
                        <td>店铺名称：</td>
                        <td><input type="text" name="title" id="title" class=""  value="<?php echo $shop['title']?>"/></td>
                    </tr>
                    <tr>
                        <td>所属频道:</td>
                        <td>
                                <select id="channelid" name="channelid">
                                    <option value="">--请选择--</option>
                                    <?php foreach( $channels as $cItem):?>
                                        <option value="<?php echo $cItem['cid']?>" <?php if($shop['channel_id']==$cItem['cid']) echo "selected"?>><?php echo $cItem['name']?></option>
                                    <?php endforeach;?>
                                </select>
                        </td>
                    </tr>

                    <tr>
                        <td>所属类别:</td>
                        <td>
                            <select id="typeid" name="typeid">
                                <option value="">--请选择--</option>
                                <?php foreach( $typelist as $cItem):?>
                                    <option value="<?php echo $cItem['typeid']?>" <?php if($shop['type_id']==$cItem['typeid']) echo "selected"?>><?php echo $cItem['name']?></option>
                                <?php endforeach;?>

                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>店铺简介：</td>
                        <td><textarea name="summary" style="width:400px;height:50px;"><?php echo $shop['summary']?></textarea></td>
                    </tr>
                    <tr>
                        <td>店铺详情：</td>
                        <td><textarea name="content" style="width:700px;height:300px;visibility:hidden;"><?php echo $shop['content']?></textarea></td>
                    </tr>

                    <tr>
                        <td>联系方式：</td>
                        <td><input type="text" name="phone" id="phone" class="" value="<?php echo $shop['phone']?>"/></td>
                    </tr>

                    <tr>
                        <td>属性标签：</td>
                        <td><input type="text" name="tag" id="tag" class="" value="<?php echo $shop['tag']?>"/></td>
                    </tr>

                    <tr>
                        <td colspan="2">
                            <div id="picK">

                                <ul>
                                <?php foreach( $imagelist as $Item):?>
                                    <li style="float:left;width:90px;">
                                    <img src="<?php echo base_url($Item);?>">
                                    <a href="javascript:void(0);">删除</a>
                                    </li>
                                <?php endforeach;?>
                                </ul>
                            </div>
                            <input type="hidden" name="pics" id="pics" value="<?php echo $photoid?>"></td>
                    </tr>
                    <tr>
                        <td>上传图片:</td>
                        <td>
                            <input type="file" name="Filedata" id="Filedata" multiple="true" />
                            <h5 style="color: red;">仅支持jpg, jpeg, gif,png等 图片格式上传</h5>
                        </td>
                    </tr>
                
                    <tr>
                        <td colspan="2" style="text-align: center">
                            <input type="hidden" name="shopid" id="shopid" value="<?php echo $shop['shopid']?>" />
                            <input type="hidden" name="token" value="<?php echo $token?>"/>
                            <input type="submit" value="提交" style="margin-bottom: 5px;"/>
                        </td>
                    </tr>
            </table>
        </form>
    </div>
<?php endblock() ?>

<?php startblock('foot_js')?>
    <script type="text/javascript" src="<?php echo base_url() ?>frontend/Public/kindeditor/kindeditor-all.js"></script>
    <script type="text/javascript" src="<?php echo base_url() ?>frontend/Public/kindeditor/lang/zh_CN.js"></script>
    <script type="text/javascript" src="<?php echo base_url() ?>frontend/application/manageShop/js/base_addjs.js"></script>

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
    $("#picK li a").click(function(){
        //当点击“删除”后，li元素消失
        $(this).parent().remove();
        //获取删除的图片链接
        var img=$(this).prev().attr("src");
        //截取图片名称
        var img=img.substr(-47);
        //获取隐藏域的图片集字符串
        var allimg=$("#pics").val();
        //把图片集字符串拆分成数组
        var arrimg=allimg.split(";");
        //从数组中根据图片名称删除数组元素
        arrimg.splice($.inArray(img,arrimg),1);
        //合并数组元素为字符串
        arrimg=arrimg.join(";");
        //把新的图片集字符串保存到隐藏域
        $("#pics").val(arrimg);
    });
</script>
<?php endblock() ?>