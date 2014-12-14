<?php include_once 'base.php';?>
<?php startblock('header_css')?>
    <link rel="stylesheet" href="<?php echo base_url()?>frontend/application/default/css/list.css" />
<?php endblock() ?>

<?php startblock('content') ?>
<div class="w980">
    <div id="content">
        <div class="mainbox">
            <div class="head-section cf">
                <span class="login-guide">管理我发现内容？
                    <a gaevent="content/login" href="<?php echo WEB_URL?>lists/show_list">去管理</a>
                </span>
                <hr>
            </div>

            <form class="common-form" method="post" autocomplete="off" action="<?php echo WEB_URL?>find/doFind" id="signup-form">
                <div class="field-group field-group-type" id="yui_3_8_0_2_1369294405492_43">
                    <label for="signup-email-address">发现类型</label>
                    <select id="channelid" name="channelid" style="width: 100px; height: 30px;">
                        <option value="0">请选择</option>
                        <?php foreach($channels as $c):?>
                            <option value="<?php echo $c['id']?>"><?php echo $c['name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                    <select id="type" name="type" style="display: none;width: 100px; height: 30px;"></select>
                    <!--<span class="inline-tip">用于登录和找回密码，不会公开</span>
                    -->
                    <div id="show_email_error" style="display: none;color: red;"></div>
                </div>
                <div class="field-group" id="yui_3_8_0_2_1369294405492_52">
                    <label for="signup-city" id="enter-address-city-label">发现地点</label>
                            <span  class="province-city-select" id="yui_3_8_0_2_1369294405492_51">

                                <select name="area" id="area">
                                    <option value="-1">--区县--</option>
                                </select>
                            </span>
                </div>

                <div class="field-group" id="yui_3_8_0_2_1369294405492_45">
                    <label for="signup-username">发现标题</label>
                    <input type="text" value="" autocomplete="off" class="f-text" id="signup-username" name="username">
                </div>
                <div class="field-group" id="yui_3_8_0_2_1369294405492_49">
                    <label for="signup-password-confirm">发现内容</label>
                    <textarea name="content"></textarea>
                </div>
                <div class="field-group" id="yui_3_8_0_2_1369294405492_47">
                    <label for="signup-password">发现图片</label>
                    <input type="hidden" name="hid_pic" id="hid_pic" value="">
                    <img id="J_bface" src="" style="width: 110px; height: 140px;">
                    <input type="file" name="Filedata" id="Filedata" multiple="true" />
                    <h5 style="color: #23a7ff;">仅支持jpg, jpeg, gif,png等 图片格式上传</h5></td>
                </div>


<!--
                <div class="field-group captcha" id="yui_3_8_0_2_1369294405492_54">
                    <label for="captcha">验证码</label>
                    <input type="text" autocomplete="off" name="captcha" class="f-text" id="captcha">
                    <span id="show_captcha"></span>
                    <a href="javascript:void(0)" class="captcha-refresh inline-link" tabindex="-1" id="change_captcha">看不清楚？换一张</a>
                    <input type="hidden" name="hid_uuid" id="hid_uuid"/>
                </div>
    -->
                <div class="field-group operate">
                    <input type="submit" value="发布" name="commit" class="form-button">
                    <input type="hidden" name="uid" value="<?php echo $uid;?>">
                </div>
            </form>
        </div>
    </div>
</div>
<?php endblock() ?>

<?php startblock('foot_js')?>
    <script type="text/javascript" src="<?php echo base_url() ?>frontend/Public/kindeditor/kindeditor-all.js"></script>
    <script type="text/javascript" src="<?php echo base_url() ?>frontend/Public/kindeditor/lang/zh_CN.js"></script>
    <script>
        var editor;
        KindEditor.ready(function(K) {
            editor = K.create('textarea[name="content"]', {
                allowFileManager : true,
                width:"75%"
            });
        });
        $(document).ready(function() {
            //get_captcha();
            $('#change_captcha').click(function(){
                get_captcha();
            })
            function get_captcha(){
                $.ajax({
                    url:web_url + 'index.php/login/captcha',
                    type:'POST',
                    dataType:'json',
                    success:function(data){
                        if(data.status ==1){
                            $("#show_captcha").html(data.data);
                            $('#hid_uuid').val(data.uuid);
                        }else{
                            //console.log('false');
                        }
                    },
                    error:function(XMLHttpRequest, textStatus, errorThrown){
                    }
                });
            }

            $.ajax({
                url: web_url +'index.php/find/get_district_id',
                type:'post',
                dataType:'json',
                data:{param_id:1},
                success:function(data){
                    if(data.status == 1){
                        data = data.data;
                        var count=data.length;
                        var _str = '';
                        for(j=0;j< count; j++){
                            _str +='<option value="'+data[j].id+'">'+data[j].name+'</option>';
                        }
                        $('#area').append(_str);
                    }
                }
            })
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
                            $('#type').html(_str);
                            $('#type').css('display','');
                            //$('#county').html('<option value="">--区、县</option>');
                        }
                    }
                })
            });
        });

    </script>
<?php endblock() ?>