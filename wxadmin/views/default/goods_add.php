<?php
include_once 'base.php';
?>
<?php startblock('article') ?>
<div class="commodity_css">
    <h1>添加商品信息</h1><hr/>
    <form id="addGoods" name="addGoods" class="addGoods" method="post" action="<?php echo WEB_URL?>goods/addGoods">
        <table>
            <tr>
                <td>商品名称</td>
                <td>
                    <input type="text" name="title" id="title" />
                </td>
            </tr>

            <tr>
                <td>所属店铺:</td>
                <td>
                    <select id="shopid" name="shopid">
                        <option value="">--请选择--</option>
                        <?php foreach( $shops as $cItem):?>
                            <option value="<?php echo $cItem['id']?>"><?php echo $cItem['title']?></option>
                        <?php endforeach;?>
                    </select>
                </td>
            </tr>

            <tr>
                <td>所属频道:</td>
                <td>
                    <select id="channelid" name="channelid">
                        <option value="">--请选择--</option>
                        <?php foreach( $channels as $cItem):?>
                            <option value="<?php echo $cItem['id']?>"><?php echo $cItem['name']?></option>
                        <?php endforeach;?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>所属类别</td>
                <td>
                    <select id="typeid" name="typeid" style="display: none;width: 100px; height: 30px;"></select>
                </td>
            </tr>
            <tr>
                <td>原价</td>
                <td>
                    <input type="text" id="oprice" name="oprice"/>
                </td>
            </tr>
            <tr>
                <td>折扣</td>
                <td>
                    <input type="text" id="discount" name="discount"/>
                </td>
            </tr>
            <tr>
                <td>现价:</td>
                <td>
                    <input type="text" name="cprice" id="cprice" />元
                </td>
            </tr>
            <tr>
                <td>属性标签:</td>
                <td>
                    <input type="text" name="tag" id="tag" />
                    <i>注：多个属性用";"隔开</i>
                </td>
            </tr>
            <tr>
                <td colspan="2"><div id="picK"></div><input type="hidden" name="pics" id="pics" value=""></td>
            </tr>
            <tr>
                <td>上传图片:</td><td>
                    <input type="file" name="g_Filedata" id="g_Filedata" multiple="true" />
                    <h5 style="color: red;">仅支持jpg, jpeg, gif,png等 图片格式上传</h5></td>
            </tr>

            <tr>
                <td>简介:</td>
                <td>
                    <textarea name="description" style="width:600px;height:300px;"></textarea>
                </td>
            </tr>

            <tr>
                <td>详情:</td>
                <td>
                    <textarea name="content" style="width:500px;height:300px;visibility:hidden;"></textarea>
                </td>
            </tr>

            <tr>
                <td colspan="2" style="text-align: center">
                    <input type="hidden" name="hid_areaName" id="hid_areaName" value="">
                    <input type="hidden" name="token" value="<?php echo $token?>"/>
                    <input type="hidden" name="typeState" id="typeState" value="5" />
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

<script>
    $(document).ready(function() {
        //get_captcha();
        $('#channelid').change(function() {
            var channelid = $('#channelid').val();
            $.ajax({
                url: base_url +'find/get_type',
                type:'post',
                dataType:'json',
                data:{param_id:channelid},
                success:function(data){
                    if(data.status == 1){
                        data = data.data;
                        var count=data.length;
                        var _str = '<option value="">请选择</option>';
                        for(j=0;j< count; j++){
                            _str +='<option value="'+data[j].id+'">'+data[j].name+'</option>';
                        }
                        $('#typeid').html(_str);
                        $('#typeid').css('display','');
                        //$('#county').html('<option value="">--区、县</option>');
                    }
                }
            })
        });
    });
</script>

<?php endblock() ?>