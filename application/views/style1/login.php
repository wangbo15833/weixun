<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>登陆页面</title>
    <link href="/frontend/application/style1/css/total.css" type="text/css" rel="stylesheet"/>
    <link href="/frontend/application/style1/css/login.css" type="text/css" rel="stylesheet"/>
    <script type="text/javascript" src="<?php echo base_url('/frontend/Public/js/jquery.1.9.1.js') ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('/frontend/Public/js/base.js') ?>"></script>

</head>

<body>
<div id="total">

    <div id="whitebg">

        <!--包含头部文件-->
        <?php include_once('header.php'); ?>

        <div id="space20"></div>
        <div id="body"><!--主体部分-->
            <div id="body_top"><img src="/frontend/application/style1/images/login.gif"/></div>
            <div id="body1">
                <form class="common-form" name="login_form_user" method="post" action="<?php WEB_URL?>login" id="login_form_user">
                <div id="body1_left">
                    <div id="body1_left_top">
                        <div id="body1_left_left">
                            <img src="/frontend/application/style1/images/5login_03.gif"/>
                            <img src="/frontend/application/style1/images/5login_05.gif"/>
                            <img src="/frontend/application/style1/images/5login_06.gif"/>

                        </div>
                        <div id="body1_left_right">
                            <div class="input"><input name="email" type="text" size="30"/></div>
                            <div class="input1"><input name="password" type="password" size="30"/></div>
                            <div class="input2">
                                <input name="captcha" type="text" size="10"/>
                                <span id="show_captcha"></span>
                                <a href="javascript:void(0)" class="captcha-refresh inline-link" tabindex="-1" id="change_captcha">换一张</a>
                            </div>
                            <input type="hidden" id="hid_uuid" name="hid_uuid" value=""/>
                        </div>
                    </div>
                    <div id="choose">
                        <input name="remember" type="checkbox" value="记住账号"/>记住账号
                        <input name="login" type="checkbox" value=""/>下次自动登录 （公共场所慎用）
                    </div>

                    <div id="login"><input name="commit" type="submit" value="登陆"/>忘记密码？</div>
                </div>
                </form>


                <div id="body1_center"><img src="/frontend/application/style1/images/login_center.gif"/></div>
                <div id="body1_right">
                    <div id="body1_right_left">还不是5i会员？</div>

                    <div id="body1_right_register"><a href="register.html">注册新会员</a></div>
                </div>

            </div>
        </div>
        <!--主体部分结束-->
    </div>
    <!--白色背景框结束-->

    <!--包含底端文件-->
    <?php include_once('footer.php'); ?>
</div>
<!--总体框架-->
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
</body>
</html>
