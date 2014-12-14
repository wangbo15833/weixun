<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>会员注册页面</title>
    <script>
        function change() {

            document.getElementById("input").style.color = "black";
            document.getElementById("input").value = "";
        }
    </script>
    <link href="/frontend/application/style1/css/total.css" type="text/css" rel="stylesheet"/>
    <link href="/frontend/application/style1/css/register.css" type="text/css" rel="stylesheet"/>

</head>

<body>
<div id="total">
    <div id="whitebg">
        <!--包含头部文件-->
        <?php include_once('header.php'); ?>

        <div id="space20"></div>
        <div id="body"><!--主体部分-->
            <div id="body_top"><img src="/frontend/application/style1/images/register_title.gif"/></div>
            <div id="body1">
                <div id="body1_left">
                    <div id="body1_left_top">
                        <div id="body1_left_left">
                            <img src="/frontend/application/style1/images/5register_01_03.gif"/>
                            <img src="/frontend/application/style1/images/5register_01_05.gif"/>
                            <img src="/frontend/application/style1/images/5register_01_06.gif"/>
                            <img src="/frontend/application/style1/images/5register_01_07.gif"/>
                            <img src="/frontend/application/style1/images/5register_01_08.gif"/>
                            <img src="/frontend/application/style1/images/5register_01_09.gif"/>
                            <img src="/frontend/application/style1/images/5register_01_10.gif"/>
                        </div>
                        <div id="body1_left_right">
                            <div class="input"><input name="name" type="text" size="30"/></div>
                            <div class="input1"><input name="e-mail" type="text" size="30"/></div>
                            <div class="input2"><input name="phone" type="text" size="30"/></div>
                            <div class="texting">免费获取短信验证码</div>
                            <div class="input3"><input name="text" type="text" size="10"/></div>
                            <div class="address">
                                <select name="country">
                                    <option>河北省</option>
                                </select>省
                                <select name="city" size="1">
                                    <option>--请选择--</option>
                                    <option>秦皇岛</option>
                                    <option>石家庄</option>
                                    <option>张家口</option>
                                    <option>唐山</option>
                                    <option>承德</option>
                                    <option>保定</option>
                                    <option>邢台</option>
                                    <option>邯郸</option>
                                    <option>廊坊</option>
                                    <option>沧州</option>
                                    <option>衡水</option>
                                </select>市
                            </div>
                            <div class="password"><input name="password" type="password"/></div>
                            <div class="password1"><input name="password1" type="password"/></div>
                        </div>
                    </div>


                    <div id="register"><input name="commit" type="submit" value="同意以下协议并注册"/></div>
                    <div id="agreement"><textarea name="" cols="50" rows="5">用户协议</textarea></div>
                </div>
                <div id="body1_center"><img src="/frontend/application/style1/images/register_center.gif"/></div>
                <div id="body1_right">
                    <div id="body1_right_left">已是5i会员？</div>

                    <div id="body1_right_register"><a href="#">请点击登录</a></div>
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

</body>
</html>
