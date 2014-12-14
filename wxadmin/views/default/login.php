<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>登录入口</title>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url()?>frontend/wxadmin/default/css/login.css" />
</head>
<body>
    <div class="loginDiv" id="myLogin">
        <h1>微讯信息管理后台</h1>
        <form id="login" name="login" method="post"  action="<?php echo base_url()?>wxadmin.php/login/checkin">
            <ul>
                <li><label for="lname">用户名：</label><input name="lname" id="lname" value="" type="text" /></li>
                <li><label for="lpwd">密&nbsp; 码：</label><input name="lpwd" id="lpwd" value="" type="password" /></li>
                <li><input type="radio" name="rdotype" id="rdotype" value="1"  checked="checked"/>商铺会员
                    <input type="radio" name="rdotype" id="rdotype" value="2" />管理员
                    <input type="radio" name="rdotype" id="rdotype" value="3" />超级管理员员</li>
                <li><input id="submit" type="submit" value="确定"/></li>
            </ul>
        </form>
    </div>
</body>
</html>