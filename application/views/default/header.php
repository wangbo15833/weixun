<div class="allHeader">
    <div class="w980">
        <div class="allHeaderTop clearfix">
            <div class="l"><span class="l haka">休闲到秦皇岛 享受慢生活</span><span class="l" style="margin:4px 0 0 10px;"> </span> </div>
            <div class="r">欢迎来到吃喝玩乐频道 <a href="#" onclick="this.style.behavior='url(#default#homepage)';this.setHomePage('http://www.5ilife.cn');">设为首页</a><a href="javascript:window.external.AddFavorite('http://www.5ilife.cn', '秦皇岛信息港吃喝玩乐')" title="秦皇岛信息港吃喝玩乐">加入收藏</a></div>
        </div>
        <!--allHeaderTop end-->
        <div class="headerCon">
            <div class="clearfix">
                <div class="login weiruan f12 r">
                <?php if(defined('USER_ID') ){?>
                    <a href="map.php"></a>
                    <a href="<?php echo WEB_URL?>lists/show_list" rel="nofollow">
                        <strong class="vwmy"><?php echo USERNAME?></strong>
                    </a>
                    <?php if($user['is_type']==2){ ?>
                    <span class="pipe"> | </span>
                    <a href="<?php echo base_url('/index.php/manageShop/') ?>" target="_blank" id="navmsg">店铺管理</a>

                    <?php }?>
                    |
                    <a rel="nofollow" href="<?php echo  WEB_URL?>login/out_login">退出</a>
                    <p></p>
                <?php  }else{ ?>
                    <?php
                    $burl =  'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'];
                    ?>
                    <a href="<?php echo WEB_URL?>login/register" target="_blank" class="loginA f14">免费注册</a>
                    <a href="<?php echo WEB_URL?>login/index?burl=<?php echo sysAuthCode($burl);?>" class="loginA f14">会员登录</a>
                    <?php }?>
                </div>
                <div class="weather">
                <!--调试期间暂时注释
                    <iframe src="http://www.thinkpage.cn/weather/weather.aspx?uid=U383680236&cid=101091101&l=zh-CHS&p=CMA&a=0&u=C&s=4&m=2&x=1&d=0&fc=FFFFFF&bgc=&bc=&ti=0&in=0&li=&ct=iframe" frameborder="0" scrolling="no" width="300" height="27" allowTransparency="true"></iframe>
                 -->
                </div>
            </div>
            <div class="menu weiruan f14 bold">
                <ul class="clearfix">
                    <li class="<?php if(!isset($cid)){?>this<?php }?>"><a href="<?php echo WEB_URL?>index">首页</a></li>
                    <li class="<?php if(isset($cid) && $cid==1){?>this<?php }?>"><a href="<?php echo WEB_URL?>shops/index?cid=1">购物</a></li>
                    <li class="<?php if(isset($cid) && $cid==2){?>this<?php }?>"><a href="<?php echo WEB_URL?>shops/index?cid=2">吃喝</a></li>
                    <li class="<?php if(isset($cid) && $cid==3){?>this<?php }?>"><a href="<?php echo WEB_URL?>shops/index?cid=3">玩乐</a></li>
                    <li class="<?php if(isset($cid) && $cid==4){?>this<?php }?>"><a href="<?php echo WEB_URL?>shops/index?cid=4">出行</a></li>
                    <li class="<?php if(isset($cid) && $cid==5){?>this<?php }?>"><a href="<?php echo WEB_URL?>shops/index?cid=5">住宿</a></li>
                    <li class="<?php if(isset($cid) && $cid==6){?>this<?php }?>"><a href="<?php echo WEB_URL?>shops/index?cid=6">服务</a></li>
                    <li class="<?php if(isset($cid) && $cid==7){?>this<?php }?>"><a href="<?php echo WEB_URL?>shops/index?cid=7">我发现</a></li>
<!--
                    <li class="<?php if(isset($cid) && $cid==8){?>this<?php }?>"><a href="<?php echo WEB_URL?>work/index/8">找活</a></li>
-->
                </ul>
            </div>
        </div>
        <!--headerCon end-->
    </div>
</div>
<!--allHeader end-->