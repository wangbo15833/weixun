<?php include_once 'base.php';?>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('/frontend/application/default/css/login.css') ?>" />
<?php startblock('header_css')?>

<?php endblock() ?>

<?php startblock('content') ?>
<div class="w980 mt5">
            <div class="pg-login" id="content" style="width: 100%">
                <div class="mainbox">
                    <h2>登录<span>尚未注册？<a  href="<?php echo WEB_URL?>login/register">免费注册</a></span></h2>
                    <div class="signup-section">

                        <form class="common-form" name="login_form_user" method="post" action="<?php WEB_URL?>login" id="login_form_user">

                            <div class="field-group field-group-type" id="yui_3_8_0_2_1369269574812_29">
                                <label for="login-email">账号</label>
                                <input type="text" placeholder="您可用绑定用户名、邮箱登录" value="<?php if(defined('L_USER')){ echo L_USER ; }?>" name="email" class="f-text" id="email">
                            </div>
                            <div class="field-group" id="yui_3_8_0_2_1369269574812_31">
                                <label for="login-password">密码</label>
                                <input type="password" name="password" class="f-text" id="password" value="<?php if(defined('L_PASS')){ echo L_PASS ; }?>"><label class="error"></label>
                            </div>
                            <div class="field-group captcha" id="yui_3_8_0_2_1369269574812_33">
                                <label for="captcha">验证码</label>
                                <input type="text" autocomplete="off" name="captcha" class="f-text" id="captcha">
                                <span id="show_captcha"></span>
                                <a href="javascript:void(0)" class="captcha-refresh inline-link" tabindex="-1" id="change_captcha">看不清楚？换一张</a>
                                <input type="hidden" id="hid_uuid" name="hid_uuid" value=""/>
                            </div>
                            <div class="field-group auto-login">
                                <input type="checkbox" class="f-check" id="remember_username" name="remember_username" checked="" value="1">
                                <label for="remember-username" class="normal">记住账号</label>
                                <input type="checkbox" class="f-check" id="autologin" name="autologin" value="1">
                                <label for="autologin" class="normal">下次自动登录</label>
                            </div>
                            <div class="field-group">
                                <a class="inline-link" href="<?php echo WEB_URL?>login/resetreq" tabindex="-1">忘记密码？</a>
                                <p style="display:none" class="error"></p>
                                <input type="button" value="登录" id="commit" name="commit" class="form-button">
                                <input type="hidden" name="requestUrl" id="requestUrl" value="<?php echo $requestUrl;?>">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
</div>
<?php endblock() ?>

<?php startblock('foot_js')?>
    <script>
        $(document).ready(function() {
            get_captcha();
            $('#change_captcha').click(function(){
               // console.log('change');
                get_captcha();
            })
              function get_captcha(){
            $.ajax({
                url:base_url + 'login/captcha',
                type:'POST',
                dataType:'json',
                //data:values,
                success:function(data){
                    if(data.status ==1){
                        $("#show_captcha").html(data.data);
                        $('#hid_uuid').val(data.uuid);
                    }else{
                        console.log('false');
                    }
                },
                error:function(XMLHttpRequest, textStatus, errorThrown){
                    console.log(textStatus);
                }
            });
            }
        });

        $('#commit').click(function(){
            var email = $('#email').val();
            var password = $('#password').val();
            var captcha = $('#captcha').val();
            var hid_uuid = $('#hid_uuid').val();

            values = {email:email, password:password, captcha:captcha, hid_uuid:hid_uuid}
            $.ajax({
                url:base_url + 'login/check_captcha',
                type:'POST',
                dataType:'json',
                data:values,
                success:function(data){
                    if(data.state ==1){
                        art.dialog({
                            time: 2,
                            width: '20em',
                            height: 55,
                            content: '验证码输入错误！'
                        });
                    }else if(data.state ==2){
                        art.dialog({
                            time: 2,
                            width: '20em',
                            height: 55,
                            content: '用户名、密码错误！'
                        });
                    }else{
                        $('#login_form_user').submit();
                    }
                },
                error:function(XMLHttpRequest, textStatus, errorThrown){
                    console.log(textStatus);
                }
            });
        });
    </script>
<?php endblock() ?>