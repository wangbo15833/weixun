<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>我爱生活网</title>
</head>

<body>
<link href="/frontend/application/style1/css/shopping1.css" type="text/css" rel="stylesheet"/>
<link href="/frontend/application/style1/css/total.css" type="text/css" rel="stylesheet"/>


<div id="total">

<div id="whitebg">
<!--包含头部文件-->
<?php include_once('header.php'); ?>

<div id="space"></div>

<div id="body"><!--主题部分-->

<div id="body_ul">
    <ul>
        <li>分类：</li>
        <li><a href="<?php echo $type_all ?>" class="item <?php if ($type == '') { ?>this <?php } ?>">全部</a></li>

        <?php foreach ($types as $item): ?>
            <li><a href="<?php echo $item['base_url']; ?>"><?php echo $item['name']; ?></a></li>
        <?php endforeach; ?>
    </ul>

    <br/>

    <div id="line"></div>
    <ul>
        <li>商圈:</li>
        <li><a href="<?php echo $area_all ?>">全部</a></li>
        <?php foreach ($areas as $item): ?>
            <li><a href="<?php echo $item['base_url']; ?>"><?php echo $item['dname']; ?></a></li>
        <?php endforeach; ?>
    </ul>
</div>
<!--ul部分结束-->

<div id="space1"></div>
<div id="navigation1">

    <ul>
        <li class="line"><a href="#">默认排序</a></li>
        <li class="line"><a href="#">好评</a><img src="/frontend/application/style1/images/JT.gif"/></li>
        <li><a href="#">发布时间</a><img src="/frontend/application/style1/images/JT.gif"/></li>
    </ul>

</div>

<div id="space1"></div>

<div id="page" style="float:left; width:700px; height:1700px; position:relative;">
    <ul class="newslist5">
        <?php foreach ($list as $item): ?>
            <li>
                <div class="mainpic">
                    <a href="<?php echo WEB_URL ?>shops/detail/<?php echo $item['shopid'] ?>">
                        <img src="/frontend/application/style1/images/shopping.gif"/>
                    </a>
                </div>
                <div class="shopname">
                    <a href="<?php echo WEB_URL ?>shops/detail/<?php echo $item['shopid'] ?>">
                        <?php echo $item['title'] ?>
                    </a>
                </div>
                <div class="shopdes"><?php echo $item['address'] ?></div>
                <div class="dingcai">踩（）赞（）</div>
            </li>
        <?php endforeach; ?>

    </ul>


    <div id="changpage"
         style="text-align:center; height:100px; width:700px;   bottom:0px; line-height:100px; overflow:auto;">
        <?php echo $pageShow ?>
    </div>


</div>


<div id="body_right">


    <div id="phone">
        <div id="phone_left"><img src="/frontend/application/style1/images/img_phone.jpg"/></div>
        <div id="phone_right_up">5ilife手机端免费下载</div>
        <div id="phone_right_down"><a href="#">免费下载</a></div>
    </div>


    <div id="space2"></div>

    <div id="hot">

        <div id="hot_title">智能推广</div>
        <ul class="newslist7">
            <?php foreach ($shopList_zntg as $item): ?>

                <li>
                    <a href="<?php echo WEB_URL ?>shops/detail/<?php echo $item['shopid'] ?>">
                        <img src="/frontend/application/style1/images/shop.jpg"/>
                    </a>
                    <div class="title">
                        <h5><?php echo $item['summary'];?></h5>
                        <span><a href="<?php echo WEB_URL ?>shops/detail/<?php echo $item['shopid'] ?>">更多内容>></a></span>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>


    <div id="space2"></div>

    <div id="advertise"><img src="/frontend/application/style1/images/logo_05.gif"/></div>

    <div id="space2"></div>

    <div id="ranking">

        <div id="ranking_title">本月购物排行榜</div>
        <div id="space2"></div>
        <div id="space2"></div>
        <div id="space2"></div>
        <div id="rankings">
            <ol class="newslist6">
                <?php foreach ($hotShopList as $item): ?>
                    <li>
                        <a href="<?php echo WEB_URL ?>shops/detail/<?php echo $item['shopid'] ?>"><?php echo $item['title'] ?></a>
                    </li>
                <?php endforeach; ?>
            </ol>
        </div>
    </div>


    <div id="space10"></div>
    <div style="border:1px #CCC solid; height:485px;">
        <div id="body_left_up_left1"><img src="/frontend/application/style1/images/AN_06.gif" class="red"/>
            <b>购物新发现</b>
            <a href="find.html">
                <img src="/frontend/application/style1/images/more_08.gif" class="more"/>
            </a>
        </div>

        <ul class="newslist3">
            <?php foreach ($shoplist_zxfx as $item): ?>
                <li>
                    <img src="/frontend/application/style1/images/star.gif"/>
                    <a href="<?php echo WEB_URL?>shops/detail/<?php echo $item['shopid']?>"><?php echo $item['title']?></a>
                    <span><?php echo $item['pubdate']?></span>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>
</div>
<!--主题body部分结束-->
</div>
<!--白色背景框结束-->
<div id="space"></div>
<!--包含底端文件-->
<?php include_once('footer.php'); ?>
</div>
<!--总体框架-->
</body>
</html>