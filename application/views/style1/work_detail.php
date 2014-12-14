<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>找活三级页面</title>
    <script>
        function change() {

            document.getElementById("input").style.color = "black";
            document.getElementById("input").value = "";
        }
    </script>
</head>

<body>
<link href="/frontend/application/style1/css/total.css" type="text/css" rel="stylesheet"/>
<link href="/frontend/application/style1/css/workingthird.css" type="text/css" rel="stylesheet"/>


<div id="total">

    <div id="whitebg">
        <!--包含头部文件-->
        <?php include_once('header.php'); ?>
        <div id="space"></div>
        <div id="body">
            <div id="body_top"><a href="#">秦皇岛找活></a> <a href="#">海港区></a> <a href="#">某某活</a></div>

            <div id="working">
                <div id="working_name"><?php echo $work['name']?></div>
                <div id="people">发活者：发活者姓名/某某先生</div>
                <div id="working_time">

                    <div id="time_left">发布时间：<?php echo $work['creattime']?></div>
                    <div id="time_center"> 注册时间：2014-07-07</div>

                </div>

                <div id="working_txt">
                    <p>类型：服务/技工...</p>

                    <p>技能要求：条件放宽面谈/需掌握某某技能</p>

                    <p>工作地址：<?php echo $work['address']?>.</p>
                </div>

                <div id="working_ph">
                    <div id="working_ph_left"><b>联系电话:</b></div>
                    <div id="working_ph_center"><img src="/frontend/application/style1/images/phone01.gif"/></div>
                    <div id="working_ph_right"><?php echo $work['contact']?></div>
                </div>

                <ul id="step" style="list-style:none;">
                    <li class="bg"><a href="#">任务托管</a></li>
                    <li class="j"></li>
                    <li class="bg1"><a href="#">投稿到我们</a></li>
                    <li class="j"></li>
                    <li class="bg1"><a href="#">发活者选标</a></li>
                    <li class="j"></li>
                    <li class="bg1"><a href="#">交易进行中</a></li>
                    <li class="j"></li>
                    <li class="bg1"><a href="#">完成交易</a></li>

                </ul>


            </div>
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
                <div id="introduce"><!--介绍-->
                    <div id="introduce_title">活内容详细说明</div>
                    <div id="line2px"></div>

                    <div id="introduce_txt">
                        <?php echo $work['description']?>
                    </div>
                </div>
                <!--介绍结束-->
            </div>
            <!--主体左半部分结束-->
            <div id="body_right"><!--主体右半部分-->

                <div id="phone">
                    <div id="phone_left"><img src="/frontend/application/style1/images/img_phone.jpg"/></div>
                    <div id="phone_right_up"><img src="/frontend/application/style1/images/img_phone_bg.gif"/></div>
                    <div id="phone_right_down"><a href="#">免费下载</a></div>
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
