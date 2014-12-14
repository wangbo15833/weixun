<!--顶端-->
<?php
$burl =  'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'];
?>
<div id="top">
    <div id="top_left">
        欢迎来到我爱生活网!
        <?php if(defined('USER_ID') ){?>
            <a href="<?php echo WEB_URL?>lists/show_list" rel="nofollow">
                <strong class="vwmy"><?php echo USERNAME?></strong>
            </a>
            |
            <a rel="nofollow" href="<?php echo  WEB_URL?>login/out_login">退出</a>

        <?php }else{?>
            <a href='<?php echo WEB_URL?>login/index?burl=<?php echo sysAuthCode($burl);?>' class='login'>[登陆]</a>
            <a href="<?php echo WEB_URL?>login/register">[注册]</a>
        <?php }?>
    </div>
    <div id="top_right">
        <a href="personal.html">我的5i</a>
        <a href="login_shop.html">商家管理</a>
        <img src="/frontend/application/style1/images/WX_03.gif"/>
        <a href="javascript:;" onclick="window.open('/frontend/application/style1/html/weixin.html','','width=300,height=350')">微信我们</a>
        <img src="/frontend/application/style1/images/Sc_03.gif"/>
        <a href="#"> 加入收藏</a>
    </div>
    <iframe src="http://www.thinkpage.cn/weather/weather.aspx?uid=U383680236&cid=CHHE100000&l=zh-CHS&p=SMART&a=0&u=C&s=7&m=2&x=1&d=0&fc=&bgc=&bc=&ti=0&in=0&li=&ct=iframe" frameborder="0" scrolling="no" width="300" height="17" allowTransparency="true"></iframe>
</div>
<!--logo栏-->
<div id="logo">
    <div id="logo_left"><img src="/frontend/application/style1/images/logo.jpg" class="logo_pic"/></div>
    <div id="logo_right"><img src="/frontend/application/style1/images/logo_05.gif" class="logo_pic1"/></div>
</div>
<!--导航条-->
<div id="navigation">
    <div id="navigation_left">
        <ul>
            <li><a href="<?php echo WEB_URL?>index">首页</a></li>
            <li><a href="<?php echo WEB_URL?>shops/index?cid=1">购物</a></li>
            <li><a href="<?php echo WEB_URL?>shops/index?cid=2">吃喝</a></li>
            <li><a href="<?php echo WEB_URL?>shops/index?cid=3">玩乐</a></li>
            <li><a href="<?php echo WEB_URL?>shops/index?cid=4">出行</a></li>
            <li><a href="<?php echo WEB_URL?>shops/index?cid=5">住宿</a></li>
            <li><a href="<?php echo WEB_URL?>work/index/8">找活</a></li>
            <li><a href="<?php echo WEB_URL?>shops/index?cid=7">发现</a></li>
            <li style="width:70px; margin-right:10px;" class="li_w"><a href="<?php echo WEB_URL?>shops/index?cid=9">医疗保健</a></li>
            <li><a href="<?php echo WEB_URL?>shops/index?cid=6">服务</a></li>
        </ul>
    </div>
    <div id="navigation_found">
        <input name="text" type="text" style="color:#cccccc" onclick="this.value=''" value="请输入要搜索的关键字" size="30"/>
        <a href="#"><img src="/frontend/application/style1/images/ser.gif"/></a>
    </div>
</div>
<!--导航条结束-->