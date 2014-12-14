<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN""http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>我爱生活网</title>
    <link href="/frontend/application/style1/css/total.css" type="text/css" rel="stylesheet"/>
    <link href="/frontend/application/style1/css/index.css" type="text/css" rel="stylesheet"/>
    <script type="text/javascript" src="<?php echo base_url('/frontend/application/style1/js/easytabs.js') ?>"></script>
    <style type="text/css">
        body, td, th {
            color: #999;
        }

        body {
            background-color: #CCC;
        }
    </style>
    <script src="/frontend/application/style1/js/flash.js" type="text/javascript"></script>
    <script>
        function change() {

            document.getElementById("input").style.color = "black";
            document.getElementById("input").value = "";
        }
    </script>
</head>
<body>
<!--总体框架div-->
<div id="total">
    <div id="whitebg">

    <!--包含头部文件-->
    <?php include_once('header.php'); ?>

    <div id="space"></div>
    <!--主题部分-->
    <div id="body">
    <div id="body_left">
        <div id="body_left_up">
            <div id="body_left_up_left">
                <div id="body_left_up_left1"><img src="/frontend/application/style1/images/AN_06.gif"
                                                  class="red"/><b>优惠活动</b><a href="YH.html"><img
                            src="/frontend/application/style1/images/more_08.gif" class="more"/></a></div>
                <ul class="newslist1">
                    <?php foreach($promotionList as $item):?>
                        <li><a class="body_link_left" href="<?php echo WEB_URL?>shops/detail/<?php echo $item['shopid']?>?cid=8" title="<?php echo $item['pname']?>" target="_blank"><?php echo $item['pname']?></a><span><?php echo $item['pubtime']?></span></li>
                    <?php  endforeach;?>

                </ul>

                <div id="body_left_up_left1"><img src="/frontend/application/style1/images/AN_06.gif" class="red"/><b>服务</b><a
                        href="serve.html"><img src="/frontend/application/style1/images/more_08.gif" class="more"/></a>
                </div>

                <ul class="server">
                    <?php foreach($typelist_fuwu as $item):?>
                        <li><a href="<?php echo WEB_URL?>shops/index?cid=1&type=<?php echo $item['typeid']?>"><?php echo $item['name']?></a></li>
                    <?php  endforeach;?>
                </ul>
            </div>
            <div id="body_left_up_right">
                <div id="flashcontent01">
                    <script type="text/javascript">
                        var speed = 1000;
                        var pics = '/frontend/application/style1/images/11.jpg|/frontend/application/style1/images/13.jpg|/frontend/application/style1/images/14.jpg|/frontend/application/style1/images/15.jpg|/frontend/application/style1/images/14.jpg';
                        var mylinks = 'http://www.5ilife.cn/|http://www.5ilife.cn/|http://www.5ilife.cn/|http://www.5ilife.cn/';
                        var texts = '秦皇岛风景，魅力秦皇！|秦皇岛风景，魅力秦皇！|秦皇岛风景，魅力秦皇！|秦皇岛风景，魅力秦皇！|魅力秦皇欢迎您！';
                        var sohuFlash2 = new sohuFlash("/frontend/application/style1/swf/focus0414a.swf", "flashcontent01", "380", "255", "8", "#ffffff");

                        sohuFlash2.addParam("quality", "medium");
                        sohuFlash2.addParam("wmode", "opaque");
                        sohuFlash2.addVariable("speed", speed);
                        sohuFlash2.addVariable("p", pics);
                        sohuFlash2.addVariable("l", mylinks);
                        sohuFlash2.addVariable("icon", texts);
                        sohuFlash2.write("flashcontent01");
                    </script>

                </div>
                <div id="show_title">[<b>酷热夏日避暑首选</b>]休闲娱乐，观光健身必游</div>
                <div id="show_explain">&nbsp;&nbsp;&nbsp;&nbsp;南戴河国际娱乐中心属于南戴河旅游度假区三小区省级森林公园，总占地面积250万平方米，是一处充分利用海水、沙滩、山丘、森林等自然资源，集休闲、娱乐、观光、健身于一体，内涵颇为丰富之滨海旅游景区...<a
                        href="#">了解更多>></a></div>
            </div>
        </div>
        <!--左上结束-->
        <div id="body_left_bottom">
            <!--购物-->
            <div id="body_left_bottom_left">
                <div id="img"><img src="/frontend/application/style1/images/shop.gif"/></div>
                <div><img src="/frontend/application/style1/images/shop.jpg" class="img1"/></div>
                <div id="first_title">
                    <a href="<?php echo WEB_URL?>shops/detail/<?php echo $ShopRgtj_gouwu['shopid']?>">
                        <?php echo $ShopRgtj_gouwu['title']?>
                    </a>
                </div>
                <div id="explain"><p>包括大型购物中心、特色步行街、高档酒店、商务办公<a href="<?php echo WEB_URL?>shops/detail/<?php echo $ShopRgtj_gouwu['shopid']?>">了解更多>></a></p></div>

                <ul class="newslist4">
                    <?php foreach($list1 as $item):?>
                        <li><a href="<?php echo WEB_URL?>shops/detail/<?php echo $item['shopid']?>"><?php echo $item['title']?></a></li>
                    <?php  endforeach;?>
                </ul>

            </div>

            <!--住宿-->
            <div id="body_left_bottom_right">
                <div id="img"><img src="/frontend/application/style1/images/hotels.gif"/></div>
                <div><img src="/frontend/application/style1/images/shop.jpg" class="img1"/></div>
                <div id="first_title">
                    <a href="<?php echo WEB_URL?>shops/detail/<?php echo $ShopRgtj_zhusu['shopid']?>">
                        <?php echo $ShopRgtj_zhusu['title']?>
                    </a>
                </div>
                <div id="explain"><p>包括大型购物中心、特色步行街、高档酒店、商务办公<a href="<?php echo WEB_URL?>shops/detail/<?php echo $ShopRgtj_zhusu['shopid']?>">了解更多>></a></p></div>

                <ul class="newslist4">
                    <?php foreach($list5 as $item):?>
                        <li><a href="<?php echo WEB_URL?>shops/detail/<?php echo $item['shopid']?>"><?php echo $item['title']?></a></li>
                    <?php  endforeach;?>
                </ul>
            </div>


            <!--玩乐-->
            <div id="body_left_bottom_center">

                <div id="img"><img src="/frontend/application/style1/images/play.gif"/></div>
                <div><img src="/frontend/application/style1/images/shop.jpg" class="img1"/></div>
                <div id="first_title">
                    <a href="<?php echo WEB_URL?>shops/detail/<?php echo $ShopRgtj_wanle['shopid']?>">
                        <?php echo $ShopRgtj_wanle['title']?>
                    </a>
                </div>
                <div id="explain"><p>包括大型购物中心、特色步行街、高档酒店、商务办公<a href="<?php echo WEB_URL?>shops/detail/<?php echo $ShopRgtj_wanle['shopid']?>">了解更多>></a></p></div>
                <ul class="newslist4">
                    <?php foreach($list3 as $item):?>
                        <li><a href="<?php echo WEB_URL?>shops/detail/<?php echo $item['shopid']?>"><?php echo $item['title']?></a></li>
                    <?php  endforeach;?>
                </ul>
            </div>

            <!--广告模块-->
            <div id="advertise"><img src="/frontend/application/style1/images/GG.gif" class="advertise"/></div>

            <!--吃喝-->
            <div id="body_left_bottom_left">
                <div id="img"><img src="/frontend/application/style1/images/eatting.gif"/></div>
                <div><img src="/frontend/application/style1/images/shop.jpg" class="img1"/></div>
                <div id="first_title">
                    <a href="<?php echo WEB_URL?>shops/detail/<?php echo $ShopRgtj_chihe['shopid']?>">
                        <?php echo $ShopRgtj_chihe['title']?>
                    </a>
                </div>
                <div id="explain"><p>包括大型购物中心、特色步行街、高档酒店、商务办公<a href="<?php echo WEB_URL?>shops/detail/<?php echo $ShopRgtj_chihe['shopid']?>">了解更多>></a></p></div>

                <ul class="newslist4">
                    <?php foreach($list2 as $item):?>
                        <li><a href="<?php echo WEB_URL?>shops/detail/<?php echo $item['shopid']?>"><?php echo $item['title']?></a></li>
                    <?php  endforeach;?>
                </ul>
            </div>

            <!--发现-->
            <div id="body_left_bottom_right">
                <div id="img"><img src="/frontend/application/style1/images/found1.gif"/></div>
                <div><img src="/frontend/application/style1/images/shop.jpg" class="img1"/></div>
                <div id="first_title"><a href="#">沃尔玛商城（海港区）</a></div>
                <div id="explain"><p>包括大型购物中心、特色步行街、高档酒店、商务办公<a href="#">了解更多>></a></p></div>
                <ul class="newslist4">
                    <li><a href="#">金三角（海阳路）</a></li>
                    <li><a href="#">华联商厦（海阳路）</a></li>
                    <li><a href="#">国美电器（文化路）</a></li>
                </ul>
            </div>

            <!--出行-->
            <div id="body_left_bottom_center">
                <div id="img"><img src="/frontend/application/style1/images/tript.gif"/></div>
                <div><img src="/frontend/application/style1/images/shop.jpg" class="img1"/></div>
                <div id="first_title">
                    <a href="<?php echo WEB_URL?>shops/detail/<?php echo $ShopRgtj_chuxing['shopid']?>">
                        <?php echo $ShopRgtj_chuxing['title']?>
                    </a>
                </div>
                <div id="explain"><p>包括大型购物中心、特色步行街、高档酒店、商务办公<a href="<?php echo WEB_URL?>shops/detail/<?php echo $ShopRgtj_chuxing['shopid']?>">了解更多>></a></p></div>
                <ul class="newslist4">
                    <li><a href="#">金三角（海阳路）</a></li>
                    <li><a href="#">华联商厦（海阳路）</a></li>
                    <li><a href="#">国美电器（文化路）</a></li>
                </ul>
            </div>
        </div>
        <!--左下结束-->
        <div class="dor">
            <div id="dor_left">
                <div style="margin-left:20px; margin-top:10px;"><img src="/frontend/application/style1/images/health.gif"/>
                </div>
                <div><img src="/frontend/application/style1/images/shop.jpg" class="img1"/></div>

            </div>

            <div id="dor_right">
                <ul class="newslist4" style="margin-top:40px;">
                    <li><a href="#">金三角（海阳路）</a></li>
                    <li><a href="#">华联商厦（海阳路）</a></li>
                    <li><a href="#">国美电器（文化路）</a></li>
                    <li><a href="#">金三角（海阳路）1</a></li>
                    <li><a href="#">华联商厦（海阳路）</a></li>
                    <li><a href="#">国美电器（文化路）</a></li>
                    <li><a href="#">国美电器（文化路）</a></li>
                </ul>
            </div>

            <div id="dor_center">
                <div id="first_title" style="margin-top:15px;"><a href="#">沃尔玛商城（海港区）</a></div>
                <div id="explain" style="margin-top:20px;"><p>包括大型购物中心、特色步行街、高档酒店、商务办公<a href="#">了解更多>></a></p></div>

            </div>
        </div>

    </div>
    <!--主体左侧结束-->
    <div id="body_right">

        <div id="body_left_up_left1"><img src="/frontend/application/style1/images/AN_06.gif" class="red"/><b>找活</b><a
                href="working.html"><img src="/frontend/application/style1/images/more_08.gif" class="more"/></a></div>

        <ul class="newslist2">
            <?php foreach($list9 as $item):?>
                <li><a href="<?php echo WEB_URL?>work/detail/<?php echo $item['id']?>?cid=8"><?php echo $item['name']?></a><span><?php echo $item['creattime']?></span></li>
            <?php  endforeach;?>
        </ul>
        <div id="space10"></div>

        <div id="body_left_up_left1">
            <img src="/frontend/application/style1/images/AN_06.gif" class="red"/>
            <b>最新发现</b>
            <a href="find.html"><img src="/frontend/application/style1/images/more_08.gif" class="more"/></a>
        </div>

        <ul class="newslist3">
            <?php foreach($shoplist_zxfx as $item):?>
                <li>
                    <img src="/frontend/application/style1/images/star.gif"/>
                    <a href="<?php echo WEB_URL?>shops/detail/<?php echo $item['shopid']?>"><?php echo $item['title']?></a>
                    <span><?php echo $item['pubdate']?></span>
                </li>
            <?php  endforeach;?>

        </ul>

        <div id="phone">
            <div id="phone_left"><img src="/frontend/application/style1/images/img_phone.jpg"/></div>
            <div id="phone_right_up"><!--img src="/frontend/application/style1/images/img_phone_bg.gif" /-->5ilife手机端免费下载
            </div>
            <div id="phone_right_down"><a href="#">免费下载</a></div>
        </div>

        <div id="body_space"></div>
        <div id="ranking">
            <div id="ranking_title">本月排行榜</div>
            <div id="ranking_mixtitle">
                <ul class="tab">
                    <li onmouseover="easytabs('1', '1');" onfocus="easytabs('1', '1');" id="tablink1"><a onclick="return false;" href="#">吃喝</a></li>
                    <li onmouseover="easytabs('1', '2');" onfocus="easytabs('1', '2');" id="tablink2"><a onclick="return false;" href="#">玩乐</a></li>
                    <li onmouseover="easytabs('1', '3');" onfocus="easytabs('1', '3');" id="tablink3"><a onclick="return false;" href="#">购物</a></li>
                    <li onmouseover="easytabs('1', '4');" onfocus="easytabs('1', '4');" id="tablink4"><a onclick="return false;" href="#">住宿</a></li>
                </ul>
            </div>

            <div id="tabcontent1">
                <!--吃喝排行-->
                <ol class="newslist6">
                    <?php foreach($phlist_chihe as $item):?>
                        <li><a href="<?php echo WEB_URL?>shops/detail/<?php echo $item['shopid']?>"><?php echo $item['title']?></a></li>
                    <?php  endforeach;?>
                </ol>
            </div>

            <div id="tabcontent2">
                <!--玩乐排行-->
                <ol class="newslist6">
                    <?php foreach($phlist_wanle as $item):?>
                        <li><a href="<?php echo WEB_URL?>shops/detail/<?php echo $item['shopid']?>"><?php echo $item['title']?></a></li>
                    <?php  endforeach;?>
                </ol>
            </div>

            <div id="tabcontent3">
                <!--购物排行-->
                <ol class="newslist6">
                    <?php foreach($phlist_gouwu as $item):?>
                        <li><a href="<?php echo WEB_URL?>shops/detail/<?php echo $item['shopid']?>"><?php echo $item['title']?></a></li>
                    <?php  endforeach;?>

                </ol>
            </div>

            <div id="tabcontent4">
                <!--住宿排行-->
                <ol class="newslist6">
                    <?php foreach($phlist_zhusu as $item):?>
                        <li><a href="<?php echo WEB_URL?>shops/detail/<?php echo $item['shopid']?>"><?php echo $item['title']?></a></li>
                    <?php  endforeach;?>
                </ol>
            </div>

        </div>
    </div>
    <!--主体右侧结束-->
    </div>
    <!--主题部分结束-->
    </div>
    <!--白色背景框结束-->

    <!--包含底端文件-->
    <?php include_once('footer.php'); ?>

</div>
<!--总体框架-->
</body>
</html>