<div id="hdw">
    <div id="hd">
        <div id="site-top" class="cf">
            <a class="logo" href="#" gaevent="header/logo">
                <img src="<?php echo base_url();?>frontend/application/meituan/images/logo1.png?v=2" width="98" height="61" title="发现网，您正确的选择" alt="发现网，您正确的选择"
                    /></a>
            <!----><div class="city-info">
                <h2><a href="#" ><?php echo AREANAME;?></a></h2>
                <!--
                        <a href="<?php echo WEB_URL?>index/show_district" gaevent="header/changecity" class="change-city">[切换城市]</a>
                        -->
            </div>

            <div class="site-info">
                <ul>


                    <li class="last">
                        <a rel="nofollow" class="" gaevent="header/faq" href="#">帮助</a>
                    </li>
                </ul>
            </div>
            <div class="search-w">
                <div class="search cf">
                    <form action="<?php echo WEB_URL?>goods/searchList"  name="searchForm" method="get">
                        <input type="text" name="header_search" id="header_search"  class="s-text" value="" x-webkit-speech placeholder="请输入商品名称、地址等" />
                        <input type="submit" class="s-submit" hidefocus="true" value="搜索" />
                    </form>
                </div>
                <div id="J-search-suggest" class="search-suggest" style="display:none;">
                    <ul id="J-search-suggest-list" class="search-suggest__list"></ul>
                </div>
            </div>
        </div>
        <div id="site-nav" class="site-nav">
            <div class="nav-wrapper cf">
                <ul class="nav">
                    <li class="<?php if(!isset($cid)){?>current<?php }?>"><a href="<?php echo WEB_URL?>index"><span class="nav-label">首页</span></a></li>
                    <li class="<?php if(isset($cid) && $cid==1){?>current<?php }?>"><a href="<?php echo WEB_URL?>goods/index/1"><span class="nav-label">购</span></a></li>
                    <li class="<?php if(isset($cid) && $cid==2){?>current<?php }?>"><a href="<?php echo WEB_URL?>goods/index/2"><span class="nav-label">吃</span></a></li>
                    <li class="<?php if(isset($cid) && $cid==3){?>current<?php }?>"><a href="<?php echo WEB_URL?>goods/index/3"><span class="nav-label">玩</span></a></li>
                    <li class="<?php if(isset($cid) && $cid==4){?>current<?php }?>"><a href="<?php echo WEB_URL?>travel/showTravelList"><span class="nav-label">行</span></a></li>
                    <li class="<?php if(isset($cid) && $cid==5){?>current<?php }?>"><a href="<?php echo WEB_URL?>goods/index/5"><span class="nav-label">住</span></a></li>
                    <li class="<?php if(isset($cid) && $cid==6){?>current<?php }?>"><a href="<?php echo WEB_URL?>goods/index/6"><span class="nav-label">乐</span></a></li>
                    <li class="<?php if(isset($cid) && $cid==7){?>current<?php }?>"><a href="<?php echo WEB_URL?>goods/index/7"><span class="nav-label">服务</span></a></li>
                    <li class="<?php if(isset($cid) && $cid==8){?>current<?php }?>"><a href="<?php echo WEB_URL?>work/index/8"><span class="nav-label">找活</span></a></li>
                    <?php if(defined('USER_ID') ):?>
                        <li class="<?php if(isset($type) && $type==8){?>current<?php }?>"><a href="<?php echo WEB_URL?>find/do_find"><span class="nav-label">我发现</span></a></li>
                    <?php endif; ?>
                </ul>
                <ul class="user-info">
                    <?php if(defined('USER_ID') ){?>
                        <li id="J-growth-nav-info" class="info-item  name growth-info growth-nav-info ">
                                <span id="J-my-growth" class="my-growth">
                                    <a class="username"  href="<?php echo WEB_URL?>lists/show_list" rel="nofollow"><?php echo USERNAME?></a>
                                    <a class="level-icon level-icon-0"  href="javascript:;" rel="nofollow"></a>
                                </span>
                            <div  style="display: none;" class="growth-bubble" id="J-growth-bubble">
                                <span class="bubble-top"></span>
                                <span class="bubble-close" id="J-bubble-close">×</span>
                                <div class="bubble-content">
                                    <p class="bubble-text">等级VIP0，成长值<span class="growth-value">0</span></p>
                                    <p class="bubble-button"><a  href="/account/growth" class="">查看我的成长</a></p>
                                </div>
                            </div></li>
                        <li class="info-item info-item--logout"><a  href="<?php echo  WEB_URL?>login/out_login" class="info-link login" rel="nofollow"><span class="nav-label">退出</span></a></li>
                    <?php  }else{ ?>
                        <?php
                        $burl =  'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'];
                        ?>
                        <li class="info-item"><a rel="nofollow" class="info-link login" href="<?php echo WEB_URL?>login/index?burl=<?php echo sysAuthCode($burl);?>" gaevent="nav/login"><span class="nav-label">登录</span></a></li>
                        <li class="info-item"><a rel="nofollow" class="info-link login" href="<?php echo WEB_URL?>login/register" gaevent="nav/signup"><span class="nav-label">注册</span></a></li>
                    <?php }?>
                    <li class="end"></li>
                </ul>
            </div>
        </div>
    </div>
</div>