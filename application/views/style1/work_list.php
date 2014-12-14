<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>找活</title>
    <script>
        function change() {

            document.getElementById("input").style.color = "black";
            document.getElementById("input").value = "";
        }
    </script>
</head>

<body>
<link href="/frontend/application/style1/css/total.css" type="text/css" rel="stylesheet"/>
<link href="/frontend/application/style1/css/working.css" type="text/css" rel="stylesheet"/>
<div id="total">
<div id="whitebg">
<!--包含头部文件-->
<?php include_once('header.php'); ?>
<div id="space"></div>
<div id="body"><!--主题部分-->
<div id="body_ul">
    <ul>
        <li>任务类型：</li>
        <li><a href="<?php echo $position1_url ?>">全部</a></li>

        <?php foreach ($position1s as $item): ?>
            <li><a href="<?php echo $item['base_url']; ?>"><?php echo $item['name']; ?></a></li>
        <?php endforeach; ?>
    </ul>

    <div id="line"></div>
    <ul>
        <li>地区分类:</li>
        <li><a href="<?php echo $area_url ?>">全部</a></li>
        <?php foreach ($areas as $item): ?>
            <li><a href="<?php echo $item['base_url']; ?>"><?php echo $item['dname']; ?></a></li>
        <?php endforeach; ?>
    </ul>
    <div id="line"></div>
    <ul>
        <li>发布时间:</li>
        <li><a href="#">全部</a></li>
        <li><a href="#">今天</a></li>
        <li><a href="#">昨天</a></li>
        <li><a href="#">近三天</a></li>
        <li><a href="#">近五天</a></li>
        <li><a href="#">近一周</a></li>
        <li><a href="#">本月</a></li>
    </ul>
    <div id="line"></div>
    <ul>
        <li>是否认证:</li>
        <li><a href="#">全部</a></li>
        <li><a href="#">已认证</a></li>
    </ul>
</div>
<!--ul部分结束-->
<div id="space1"></div>
<div id="body_border">
<div id="body_border_txt">

    <table class="worklist1" cellspacing="0">
        <thead>
        <tr>
            <td>标题</td>
            <td>会员诚信度</td>
            <td>技能</td>
            <td>发布时间</td>
            <td>明细</td>
        </tr>
        </thead>
        <tbody>
        <?php foreach($list as $item):?>
            <tr>
                <td width=20%><?php echo $item['name']?></td>
                <td width=20%>3级</td>
                <td width=20%>无要求</td>
                <td width=20%><?php echo $item['creattime']?></td>
                <td width=20%><a href="<?php echo WEB_URL?>work/detail/<?php echo $item['id']?>?cid=<?php echo $cid ;?>">查看明细</a></td>
            </tr>

        <?php  endforeach;?>
        </tbody>

    </table>

</div>

<div id="changpage" style="text-align:center; height:30px;  bottom:0px; padding-top:10px">
    <?php echo $pageShow?>
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
</div>
<!--主题body部分结束-->
</div>
<!--白色背景框结束-->
<div id="space"></div>
</div>
<!--总体框架-->
<!--包含底端文件-->
<?php include_once('footer.php'); ?>
</body>
</html>
