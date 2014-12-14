<?php include_once 'base.php';?>
<?php startblock('header_css')?>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('/frontend/application/default/css/login.css') ?>" />
<?php endblock() ?>

<?php startblock('content') ?>
<div class="w980 mt5">
            <div id="content">
                <div class="mainbox">
                    <div class="head-section cf">
                       <!-- <ul>
                            <li class="current">
                                <a href="/account/signup" class="email-trigger "><i></i><span></span>邮箱注册</a>
                            </li>
                            <li>
                                <a href="/account/mobilesignup" class="mobile-trigger"><i></i><span></span>手机注册</a>
                            </li>
                        </ul>
                        -->
                        <span class="login-guide">已有我爱生活网账号？<a gaevent="content/login" href="<?php echo WEB_URL?>login/index">登录</a></span>
                        <hr>
                    </div>

                    <form class="common-form" method="post" autocomplete="off" action="<?php echo WEB_URL?>login/register" id="signup-form">
                        <div class="field-group field-group-type" id="yui_3_8_0_2_1369294405492_43">
                            <label for="signup-email-address">邮箱</label>
                            <input type="text" value="" autocomplete="off" class="f-text" id="email" name="email">
                            <span class="inline-tip">用于登录和找回密码，不会公开</span>
                            <div id="show_email_error" style="display: none;color: red;">该邮箱已被注册，请填写重新填写邮箱！</div>
                        </div>
                        <div style="display:none;" class="email-auto" id="signup-email-auto">
                            <p class="email-title">请选择您的邮箱类型...</p>
                            <ul class="email-list"></ul>
                        </div>
                        <div class="field-group" id="yui_3_8_0_2_1369294405492_45">
                            <label for="signup-username">用户名</label>
                            <input type="text" value="" autocomplete="off" class="f-text" id="signup-username" name="username">
                        </div>
                        <div class="field-group" id="yui_3_8_0_2_1369294405492_47">
                            <label for="signup-password">创建密码</label>
                            <input type="password" autocomplete="off" class="f-text" id="signup-password" name="password">
                        </div>
                        <div class="field-group" id="yui_3_8_0_2_1369294405492_49">
                            <label for="signup-password-confirm">确认密码</label>
                            <input type="password" autocomplete="off" class="f-text" id="signup-password-confirm" name="password2">
                        </div>

                        <div class="field-group" id="yui_3_8_0_2_1369294405492_50">
                            <label for="signup-telephone">手机号码</label>
                            <input type="text" autocomplete="off" class="f-text" id="signup-telephone" name="telephone">
                        </div>

                        <div class="field-group" id="yui_3_8_0_2_1369294405492_52">
                            <label for="signup-city" id="enter-address-city-label">所在城市</label>
                            <span  class="province-city-select" id="yui_3_8_0_2_1369294405492_51">

                                <select name="province" id="province">
                                    <option value="-1">--省--</option>
                                </select>
                                <select name="city" id="city">
                                    <option value="-1">--市--</option>
                                </select>
                            </span>
                        </div>
                       <!-- <div class="field-group">
                            <input type="checkbox" autocomplete="off" checked="checked" class="f-check" id="subscribe" name="subscribe" value="1">
                            <label for="subscribe" class="normal">订阅每日最新团购信息，可随时退订</label>
                        </div>
                        -->
                        <div class="field-group captcha" id="yui_3_8_0_2_1369294405492_54">
                            <label for="captcha">验证码</label>
                            <input type="text" autocomplete="off" name="captcha" class="f-text" id="captcha">
                            <span id="show_captcha"></span>
                            <a href="javascript:void(0)" class="captcha-refresh inline-link" tabindex="-1" id="change_captcha">看不清楚？换一张</a>
                            <input type="hidden" name="hid_uuid" id="hid_uuid"/>
                        </div>
                        <div class="field-group operate">
                            <input type="submit" value="同意以下协议并注册" name="commit" class="form-button">
                            <br>
                            <a class="terms" target="_blank" href="<?php echo base_url() ?>index.php/about/user_pact" tabindex="-1">《我爱生活网用户协议》</a>
                        </div>
                    </form>
                </div>
            </div>
</div>
<?php endblock() ?>

<?php startblock('foot_js')?>
    <script>
        $(document).ready(function() {
            get_captcha();
            $('#change_captcha').click(function(){
                //console.log('change');
                get_captcha();
            })
            function get_captcha(){
                $.ajax({
                    url:web_url + 'index.php/login/captcha',
                    type:'POST',
                    dataType:'json',
                    //data:values,
                    success:function(data){
                        if(data.status ==1){
                            $("#show_captcha").html(data.data);
                            $('#hid_uuid').val(data.uuid);
                        }else{
                            //console.log('false');
                        }
                    },
                    error:function(XMLHttpRequest, textStatus, errorThrown){
                        //console.log(textStatus);
                    }
                });
            }
            $('#email').blur(function() {
                var email = $('#email').val();
                $.ajax({
                    url:web_url + 'index.php/login/check_email',
                    type:'POST',
                    dataType:'json',
                    data:{ ename: email },
                    success:function(data){
                        if(data.status ==1){
                            if(data.data == 0){
                                $('#show_email_error').css('display','none');
                            }else{
                                $('#show_email_error').css('display','');
                                $('#email').val('');
                            }
                        }else{
                            //console.log('false');
                        }
                    },
                    error:function(XMLHttpRequest, textStatus, errorThrown){
                        //console.log(textStatus);
                    }
                });
            });
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
                            $('#city').html(_str);
                        }
                    }
                })
            });
        });

    </script>
<?php endblock() ?>