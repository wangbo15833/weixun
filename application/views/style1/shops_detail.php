<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>我爱生活网</title>
    <link href="/frontend/application/style1/css/total.css" type="text/css" rel="stylesheet"/>
    <link href="/frontend/application/style1/css/third.css" type="text/css" rel="stylesheet"/>
    <script type=text/javascript src="/frontend/application/style1/js/jquery.js"></script>
    <script type=text/javascript src="/frontend/application/style1/js/slide.js"></script>
    <script>
        function change() {

            document.getElementById("input").style.color = "black";
            document.getElementById("input").value = "";
        }
    </script>
</head>
<body>
<div id="total">
<div id="whitebg">

<!--包含头部文件-->
<?php include_once('header.php'); ?>

<div id="space"></div>

<div id="body">
<div id="body_top">
    <a href="#">我爱生活网</a>&gt; <a href="<?php echo base_url() ?>index.php/shops/index?cid=<?php echo $cid;?>"><?php echo $channel;?></a> &gt;<?php echo $shop['title'];?>
</div>

<div id="merchant"><!--商家信息-->
    <div id="body_left_left">
        <h2><?php echo $shop['title'];?></h2>
        <img src="<?php echo $shop['sphoto']?>" style="width:400px;height:250px;"/>
    </div>

    <div id="body_left_right">

        <div id="information"><b>详细地址：</b><?php echo $shop['address'];?></div>
        <div id="information"><b>店铺入住时间：</b>2014-08-08</div>
        <div id="information"><b>类别：</b><?php echo $channel;?></div>
        <div id="information1">
            <div id="information_left"><b>联系电话：</b></div>
            <div id="information_center"><img src="/frontend/application/style1/images/phone01.gif"/></div>
            <div id="information_right"><?php echo $shop['phone'];?></div>
        </div>
        <div id="information_right1">赞（）踩（）</div>
        <div id="information">
            <img src="/frontend/application/style1/images/SCang.gif"/></div>
    </div>
</div>
<!--商家信息结束-->

<div id="line1px"></div>

<div id="body_left"><!--主体左半部分-->
    <div id="map"> <!--地理位置-->
        <div id="map_title">商家地理位置信息</div>
        <div id="line2px"></div>
        <div id="map_body">
            <div id="map_body_left">

                <div><h2>某某商场</h2></div>

                <div id="table">
                    <div id="address"><b>地址：</b>海港北部生态园区东盐务</div>
                    <div id="here">
                        <div id="here_left">到这里去</div>
                        <div id="here_center">从这里出发</div>
                        <div id="here_right">在附近找</div>
                    </div>
                    <!--here结束-->

                    <div id="ser">
                        <div id="ser_left"><input name="" type="text" value="请输入地址" size="20"/></div>
                        <div id="ser_right"><img src="/frontend/application/style1/images/GJ.gif"/><img
                                src="/frontend/application/style1/images/JC.gif"/></div>
                    </div>
                </div>
                <!--table结束-->
            </div>
            <!--map_body_left结束-->

            <div id="map_body_right"><img src="/frontend/application/style1/images/DT.gif"/></div>

        </div>
        <!--map_body结束-->

    </div>
    <!--地理位置结束-->


    <div id="others"><!--商家其它商品栏-->
        <div id="other_title">
            <div id="others_title_left">该商家的特惠商品</div>
            <div id="others_title_right">
                <ul>
                    <li>原价</li>
                    <li>现价</li>
                    <li>优惠</li>
                </ul>
            </div>
        </div>
        <div id="line2px"></div>

        <div id="others_mixtitle">

            <div id="others_mixtitle_left">某某商品</div>
            <div id="others_mixtitle_right">
                <ul>
                    <li>288</li>
                    <li>168</li>
                    <li>120</li>
                </ul>
            </div>
            <div id="others_mixtitle_left">某某商品</div>
            <div id="others_mixtitle_right">
                <ul>
                    <li>288</li>
                    <li>168</li>
                    <li>120</li>
                </ul>
            </div>
            <div id="others_mixtitle_left">某某商品</div>
            <div id="others_mixtitle_right">
                <ul>
                    <li>288</li>
                    <li>168</li>
                    <li>120</li>
                </ul>
            </div>
            <div id="others_mixtitle_left">某某商品</div>
            <div id="others_mixtitle_right">
                <ul>
                    <li>288</li>
                    <li>168</li>
                    <li>120</li>
                </ul>
            </div>
            <div id="others_mixtitle_left">某某商品</div>
            <div id="others_mixtitle_right">
                <ul>
                    <li>288</li>
                    <li>168</li>
                    <li>120</li>
                </ul>
            </div>
            <div id="others_mixtitle_left">某某商品</div>
            <div id="others_mixtitle_right">
                <ul>
                    <li>288</li>
                    <li>168</li>
                    <li>120</li>
                </ul>
            </div>
            <div id="others_mixtitle_left">某某商品</div>
            <div id="others_mixtitle_right">
                <ul>
                    <li>288</li>
                    <li>168</li>
                    <li>120</li>
                </ul>
            </div>

        </div>

    </div>
    <!--商家其它商品栏结束-->

    <div id="introduce"><!--商家介绍-->
        <div id="introduce_title">商家介绍</div>
        <div id="line2px"></div>
        <div id="introduce_txt">
            <?php echo $shop['content']?>
        </div>
        <div style="height: 300px; " class="wrap picshow"><!--大图轮换区-->
            <div id="picarea">
                <div style="margin: 0px auto; width: 600px; height: 300px; overflow: hidden">
                    <div style="margin: 0px auto; width: 600px; height: 300px; overflow: hidden" id="bigpicarea">
                        <p class="bigbtnprev"><span id="big_play_prev"></span></p>

                        <div id="image_xixi-01" class="image">
                            <a href="#" target="_blank">
                                <img alt="" src="/frontend/application/style1/images/0.jpg" width="600px;" height="300px">
                            </a>
                            <div class="word">
                                <h3>111</h3>
                            </div>
                        </div>
                        <div id="image_xixi-02" class="image">
                            <a href="#" target="_blank">
                                <img alt="" src="/frontend/application/style1/images/1.jpg" width="600px" height="300px">
                            </a>
                            <div class="word">
                                <h3>222</h3>
                            </div>
                        </div>
                        <div id="image_xixi-03" class="image">
                            <a href="#" target="_blank">
                                <img alt="" src="/frontend/application/style1/images/2.jpg" width="600px" height="300px">
                            </a>
                            <div class="word">
                                <h3>333</h3>
                            </div>
                        </div>
                        <div id="image_xixi-04" class="image">
                            <a href="#" target="_blank">
                                <img alt="" src="/frontend/application/style1/images/3.jpg" width="600px" height="300px">
                            </a>
                            <div class="word">
                                <h3>4444</h3>
                            </div>
                        </div>
                        <div id="image_xixi-05" class="image">
                            <a href="#" target="_blank">
                                <img alt="" src="/frontend/application/style1/images/4.jpg" width="600px" height="300px">
                            </a>
                            <div class="word">
                                <h3>55555</h3></div>
                        </div>
                        <p class="bigbtnnext"><span id="big_play_next"></span></p></div>
                </div>

                <div id="smallpicarea">
                    <div id="thumbs">
                        <ul>
                            <li class="first btnprev">
                                <img id="play_prev" src="/frontend/application/style1/images/left.png">
                            </li>
                            <li class="slideshowitem">
                                <a id="thumb_xixi-01" href="#">
                                    <img src="/frontend/application/style1/images/0.jpg" width="90px" height="60px">
                                </a>
                            </li>
                            <li class="slideshowitem">
                                <a id="thumb_xixi-02" href="#">
                                    <img src="/frontend/application/style1/images/1.jpg" width="90px" height="60px">
                                </a>
                            </li>
                            <li class="slideshowitem">
                                <a id="thumb_xixi-03" href="#">
                                    <img src="/frontend/application/style1/images/2.jpg" width="90px" height="60px">
                                </a>
                            </li>
                            <li class="slideshowitem">
                                <a id="thumb_xixi-04" href="#">
                                    <img src="/frontend/application/style1/images/3.jpg" width="90px" height="60px">
                                </a>
                            </li>
                            <li class="slideshowitem">
                                <a id="thumb_xixi-05" href="#">
                                    <img src="/frontend/application/style1/images/4.jpg" width="90" height="60px">
                                </a>
                            </li>
                            <li class="last btnnext">
                                <img id="play_next" src="/frontend/application/style1/images/right.png">
                            </li>
                        </ul>
                    </div>
                </div>
                <script>
                    var target = ["xixi-01", "xixi-02", "xixi-03", "xixi-04", "xixi-05"];
                </script>


            </div>
        </div>

    </div>
    <!--商家介绍结束-->
</div>
<!--主体左半部分结束-->


<div id="body_right"><!--主体右半部分-->

    <div id="phone">
        <div id="phone_left"><img src="/frontend/application/style1/images/img_phone.jpg"/></div>
        <div id="phone_right_up"><img src="/frontend/application/style1/images/img_phone_bg.gif"/></div>
        <div id="phone_right_down"><a href="#">免费下载</a></div>
    </div>


    <div id="notice">
        <div id="txt">商家公告</div>
        <div id="notice_body">
            <ul>
                <li>商家公告商家公告商家公告商家公告商家公告商家公告</li>
                <li>商家公告商家公告商家公告商家公告商家公告商家公告商家公告商家公告</li>
                <li>商家公告商家公告商家公告商家公告商家公告商家公告商家公告商家公告商家公告商家公告商家公告商家公告商家公告</li>
            </ul>
        </div>


    </div>


    <div id="enjoy">
        <div id="txt">猜你喜欢</div>
        <div id="enjoy_body">
            <ul class="newslist8">
                <?php foreach ($shopList_zntg as $item): ?>
                <li>
                    <a href="<?php echo WEB_URL ?>shops/detail/<?php echo $item['shopid'] ?>">
                        <img src="/frontend/application/style1/images/shop.jpg"/>
                    </a>
                    <div class="title">
                        <h5><?php echo $item['summary'];?></h5>
                        <span><a href="<?php echo WEB_URL ?>shops/detail/<?php echo $item['shopid'] ?>">了解详情</a></span>
                    </div>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>

    </div>
</div>
<!--主体右半部分结束-->
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
