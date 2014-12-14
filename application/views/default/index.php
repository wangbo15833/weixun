<?php include_once 'base.php';?>
<?php startblock('header_css')?>

<link rel="stylesheet" type="text/css" href="<?php echo base_url('/frontend/application/default/css/index.css') ?>" />
<script type="text/javascript" src="<?php echo base_url('/frontend/application/default/js/easytabs.js') ?>"></script>
<!--搜索栏专用start-->
<script type="text/javascript" src="<?php echo base_url('/frontend/application/default/js/search.js') ?>"></script>

<link rel="stylesheet" href="<?php echo base_url() ?>frontend/Public/jquery-ui/themes/base/jquery.ui.all.css">
<script src="<?php echo base_url() ?>frontend/Public/jquery-ui/ui/jquery.ui.core.js"></script>
<script src="<?php echo base_url() ?>frontend/Public/jquery-ui/ui/jquery.ui.widget.js"></script>
<script src="<?php echo base_url() ?>frontend/Public/jquery-ui/ui/jquery.ui.position.js"></script>
<script src="<?php echo base_url() ?>frontend/Public/jquery-ui/ui/jquery.ui.menu.js"></script>
<script src="<?php echo base_url() ?>frontend/Public/jquery-ui/ui/jquery.ui.autocomplete.js"></script>

<!--搜索栏专用end-->
<?php endblock() ?>

<?php startblock('content') ?>
<div class="w980">

<div class="ad mt5">
    <div class="ad_module"><a href="#" target="_blank"><img src="<?php echo base_url('/ad/1_2013120609090910478.jpg') ?>" height="60" width="980" alt="印尚婚纱" border="0"></a></div>
</div>
<div class="ad mt5 clearfix">
    <div class="l">
        <div class="ad_module"><a href="#" target="_blank"><img src="<?php echo base_url('/ad/1_20130823155236199PN.jpg') ?>" height="60" width="487" border="0"></a></div>
    </div>
    <div class="r">
        <div class="ad_module"><a href="#" target="_blank"><img src="<?php echo base_url('/ad/1_201401141716551fMEs.jpg') ?>" height="60" width="487" border="0"></a></div>
    </div>
</div>
<div class="border p5 mt8 clearfix">
    <div class="search l">
        <form id="form_search" target="_blank" method="get" action="<?php echo base_url('/index.php/shops/index') ?>" onsubmit="return brand_search(this)">
            <label>
                <input name="searchkey" id="header_search"  type="text" class="text" value="请输入商家名称" onfocus="if(this.value=='请输入商家名称')this.value='';" onblur="if(this.value=='')this.value='请输入商家名称';" x-webkit-speech autocomplete="off"/>
            </label>
            <label>
                <SELECT id="region" name="area" class="select" style="height:31px;">
                    <OPTION value=0 selected>请选择区域</OPTION>
                    <?php foreach($areas as $item):?>
                        <option value=<?php echo $item['did']?>><?php echo $item['dname']?></option>
                    <?php  endforeach;?>

                </SELECT>
            </label>
            <label>
                <input class="button "  id="search_submit" type="submit" value="搜索"/>
            </label>
        </form>
    </div>
    <div class="hotSearch l ml10">
        热门搜索：<a href="store.php?id=467" target="_blank" title="友姐腌面">友姐腌面</a>
        <a href="store.php?id=29" target="_blank" title="麦当劳（江南店）">麦当劳（江南店）</a>
        <a href="store.php?id=608" target="_blank" title="四季阳光-清田日本料理">四季阳光-清田日本料理</a>
        <!--首页评分榜-->
    </div>
    <div class="r">
        <a href="<?php echo WEB_URL?>login/register" target="_blank" title="商家入驻,秦皇岛，客家美食，秦皇岛美食，秦皇岛电影，秦皇岛旅游，秦皇岛团购，秦皇岛房产，ktv，美容"><img title="商家入驻," alt="商家入驻,秦皇岛，秦皇岛美食，秦皇岛电影，飞翔影视，秦皇岛旅游，秦皇岛团购，秦皇岛房产，ktv，美容" src="<?php echo base_url('/frontend/application/default/images/sjrz.jpg') ?>" /></a>
        <a href="#" title="我要推荐,秦皇岛，秦皇岛美食，秦皇岛电影，秦皇岛旅游，秦皇岛团购，秦皇岛房产，ktv，美容" target="_blank"><img alt="我要推荐,秦皇岛，秦皇岛美食，秦皇岛电影，秦皇岛旅游，秦皇岛团购，秦皇岛房产，ktv，美容" title="我要推荐" src="<?php echo base_url('/frontend/application/default/images/wytj.jpg') ?>" /></a>
    </div>
</div>
<div class="clearfix mt8">
    <div class="w250 l">
        <div class="border">
            <h3 class="title relative"><i class="hot" style="left:55px;"></i>优惠活动</h3>
            <ul class="bbsText p7">
                <?php foreach($promotionList as $item):?>
                    <li>
                            <span class="greyA r">
                                <span title="<?php echo $item['pubtime']?>"><?php echo $item['pubtime']?></span>
                            </span>
                        <a href="<?php echo WEB_URL?>shop/detail/<?php echo $item['shopid']?>?cid=8" title="<?php echo $item['pname']?>" target="_blank"><?php echo $item['pname']?></a>
                    </li>
                <?php  endforeach;?>

            </ul>
        </div>
        <!--border end-->
        <div class="mt8"><a href="#" target="_blank" title="舌尖上的豆豉"><img src="<?php echo base_url('/ad/bei.gif') ?>" alt="免费加入吃喝玩乐频道，只需一步，轻松完成"/></a></div>
    </div>
    <!--w250 end-->
    <div class="w720 r">
        <div class="border">
            <h3 class="title"><span class="orange eat">热门分类</span></h3>
            <ul class="choose">
                <li>
                    <span><a href="<?php echo WEB_URL?>shops/index?cid=1" class="black">购物</a></span>
                    <?php foreach($typelist1 as $item):?>
                        <a href="<?php echo WEB_URL?>shops/index?cid=1&type=<?php echo $item['typeid']?>" target="_blank"><?php echo $item['name']?></a>
                    <?php  endforeach;?>
                </li>
                <li>
                    <span><a href="<?php echo WEB_URL?>shops/index?cid=2" class="black">吃喝</a></span>
                    <?php foreach($typelist2 as $item):?>
                        <a href="<?php echo WEB_URL?>shops/index?cid=2&type=<?php echo $item['typeid']?>" target="_blank"><?php echo $item['name']?></a>
                    <?php  endforeach;?>

                </li>
                <li>
                    <span><a href="<?php echo WEB_URL?>shops/index?cid=3" class="black">玩乐</a></span>
                    <?php foreach($typelist3 as $item):?>
                        <a href="<?php echo WEB_URL?>shops/index?cid=3&type=<?php echo $item['typeid']?>" target="_blank"><?php echo $item['name']?></a>
                    <?php  endforeach;?>
                </li>
                <li>
                    <span><a href="<?php echo WEB_URL?>shops/index?cid=5" class="black">住宿</a></span>
                    <?php foreach($typelist5 as $item):?>
                        <a href="<?php echo WEB_URL?>shops/index?cid=5&type=<?php echo $item['typeid']?>" target="_blank"><?php echo $item['name']?></a>
                    <?php  endforeach;?>
                </li>
            </ul>

        </div>
    </div>
    <!--w720 end-->
</div>
<!--clearfix end-->

<div class="mt8 clearfix">
    <div class="w720 l">
        <div class="border">
            <h3 class="title" style="padding-left:0;">
                <ul class="tab">
                    <li onmouseover="easytabs('1', '1');" onfocus="easytabs('1', '1');" id="tablink1"><a href="#"  onclick="return false;"  title="" >美食推荐</a></li>
                    <li onmouseover="easytabs('1', '2');" onfocus="easytabs('1', '2');" id="tablink2"><a href="#"  onclick="return false;"  title="" >玩乐推荐 </a></li>
                </ul>
            </h3>

            <!--吃喝推荐-->
            <div id="tabcontent1">
                <ul class="shopListA clearfix" id="this_this1">
                    <?php foreach($list2 as $item):?>
                        <li class="relative">
                            <i class="tui"></i>
                            <a href="<?php echo WEB_URL?>shops/detail/<?php echo $item['shopid']?>" target="_blank" class="img">
                                <img src="<?php echo $item['photos']?>" alt="<?php echo $item['title']?>" width="123" height="100"/>
                                <br /><?php echo $item['title']?>
                            </a>
                        </li>
                    <?php  endforeach;?>
                </ul>
            </div>
            <!--玩乐推荐-->
            <div id="tabcontent2">
                <!--end of border-->
                <ul class="shopListA clearfix" id="this_this2">
                    <?php foreach($list3 as $item):?>
                        <li class="relative">
                            <i class="tui"></i>
                            <a href="<?php echo WEB_URL?>shops/detail/<?php echo $item['shopid']?>" target="_blank" class="img">
                                <img src="<?php echo $item['photos']?>" alt="<?php echo $item['title']?>" width="123" height="100"/>
                                <br /><?php echo $item['title']?>
                            </a>
                        </li>
                    <?php  endforeach;?>
                </ul>
            </div>
        </div>
    </div>

    <div class="w250 r">
        <div class="border">
            <h3 class="title" style="padding-left:0;">

                <ul class="tab">
                    <li onmouseover="easytabs('2', '1');" onfocus="easytabs('2', '1');" id="linktow1"><a href="#"  onclick="return false;"  title="" >美食排行</a></li>
                    <li onmouseover="easytabs('2', '2');" onfocus="easytabs('2', '2');" id="linktow2"><a href="#"  onclick="return false;"  title="" >玩乐排行 </a></li>
                </ul>
            </h3>

            <!--吃喝排行-->
            <div id="contenttow1">
                <ul class="number clearfix" id="this_this1">
                    <?php foreach($list2 as $item):?>
                        <li class="clearfix">
                            <span style="width:180px;height: 30px;overflow:hidden;" class="l">
                                <a target="_blank" title="<?php echo $item['title']?>" href="<?php echo WEB_URL?>shops/detail/<?php echo $item['shopid']?>"  class="orange"><?php echo $item['title']?></a>
                            </span>
                            <span class="r"><em class="orange"><?php echo $item['sales']?></em></span>
                        </li>
                    <?php  endforeach;?>
                </ul>
            </div>
            <!--玩乐排行-->
            <div id="contenttow2">
                <ul class="number clearfix" id="this_this2">
                    <?php foreach($list3 as $item):?>
                        <li class="clearfix">
                            <span style="width:180px;height: 30px;overflow:hidden;" class="l">
                                <a target="_blank" title="<?php echo $item['title']?>" href="<?php echo WEB_URL?>shops/detail/<?php echo $item['shopid']?>"  class="orange"><?php echo $item['title']?></a>
                            </span>
                            <span class="r"><em class="orange"><?php echo $item['sales']?></em></span>
                        </li>
                    <?php  endforeach;?>
                    <!--首页评分榜-->
                </ul>
            </div>
        </div>
    </div>
</div>
<!--mt8 end-->

<div class="ad mt5">
    <div class="ad_module"><div class="ad_module"><a href="http://www.mzktyc.com/" target="_blank"><img src="<?php echo base_url('/ad/1_201308121620451z9Fz.jpg') ?>" height="60" width="980" alt="客都游船" border="0"></a></div></div>
</div>
<div class="mt8 clearfix">
    <div class="w720 l">
        <div class="border">
            <h3 class="title" style="padding-left:0;">
                <ul class="tab">
                    <li onmouseover="easytabs('3', '1');" onfocus="easytabs('3', '1');" id="linkthree1"><a href="#"  onclick="return false;"  title="" >购物推荐</a></li>
                    <li onmouseover="easytabs('3', '2');" onfocus="easytabs('3', '2');" id="linkthree2"><a href="#"  onclick="return false;"  title="" >住宿推荐 </a></li>
                </ul>
            </h3>

            <!--购物推荐-->
            <div id="contentthree1">

                <ul class="shopListA clearfix" id="this_this1">
                    <?php foreach($list1 as $item):?>
                        <li class="relative">
                            <i class="tui"></i>
                            <a href="<?php echo WEB_URL?>shops/detail/<?php echo $item['shopid']?>" target="_blank" class="img">
                                <img src="<?php echo $item['photos']?>" alt="<?php echo $item['title']?>" width="123" height="100"/>
                                <br /><?php echo $item['title']?>
                            </a>
                        </li>
                    <?php  endforeach;?>
                </ul>
            </div>

            <!--住宿推荐-->
            <div id="contentthree2">
                <!--end of border-->
                <ul class="shopListA clearfix" id="this_this2">
                    <?php foreach($list5 as $item):?>
                        <li class="relative">
                            <i class="tui"></i>
                            <a href="<?php echo WEB_URL?>shops/detail/<?php echo $item['shopid']?>" target="_blank" class="img">
                                <img src="<?php echo $item['photos']?>" alt="<?php echo $item['title']?>" width="123" height="100"/>
                                <br /><?php echo $item['title']?>
                            </a>
                        </li>
                    <?php  endforeach;?>
                </ul>
            </div>
        </div>
    </div>

    <div class="w250 r">
        <div class="border">
            <h3 class="title" style="padding-left:0;">

                <ul class="tab">
                    <li onmouseover="easytabs('4', '1');" onfocus="easytabs('4', '1');" id="linkfour1"><a href="#"  onclick="return false;"  title="" >购物排行</a></li>
                    <li onmouseover="easytabs('4', '2');" onfocus="easytabs('4', '2');" id="linkfour2"><a href="#"  onclick="return false;"  title="" >住宿排行 </a></li>
                </ul>
            </h3>

            <!--购物排行-->
            <div id="contentfour1">
                <ul class="number clearfix" id="this_this1">
                    <?php foreach($list1 as $item):?>
                        <li class="clearfix">
                            <span style="width:180px;height: 30px;overflow:hidden;" class="l">
                                <a target="_blank" title="<?php echo $item['title']?>" href="<?php echo WEB_URL?>shops/detail/<?php echo $item['shopid']?>"  class="orange"><?php echo $item['title']?></a>
                            </span>
                            <span class="r"><em class="orange"><?php echo $item['sales']?></em></span>
                        </li>
                    <?php  endforeach;?>
                    <!--首页评分榜-->
                </ul>
            </div>

            <!--住宿排行-->
            <div id="contentfour2">
                <ul class="number clearfix" id="this_this2">
                    <?php foreach($list5 as $item):?>
                        <li class="clearfix">
                            <span style="width:180px;height: 30px;overflow:hidden;" class="l">
                                <a target="_blank" title="<?php echo $item['title']?>" href="<?php echo WEB_URL?>shops/detail/<?php echo $item['shopid']?>"  class="orange"><?php echo $item['title']?></a>
                            </span>
                            <span class="r"><em class="orange"><?php echo $item['sales']?></em></span>
                        </li>
                    <?php  endforeach;?>
                    <!--首页评分榜-->
                </ul>
            </div>
        </div>
    </div>
</div>
<!--mt8 end-->

<div class="mt8 clearfix">
    <div class="w250 l">
        <div class="border">
            <h3 class="title"><span class="r"><a href="<?php echo WEB_URL?>goods/index/6" class="grey">更多</a></span><span class="orange">服务</span>市场</h3>

            <!--服务市场-->
            <div>
                <ul class="bbsText p7">
                    <?php foreach($list6 as $item):?>
                        <li>
                            <a href="<?php echo WEB_URL?>shops/detail/<?php echo $item['shopid']?>" title="<?php echo $item['title']?>" target="_blank"><?php echo $item['title']?></a>
                        </li>
                    <?php  endforeach;?>
                </ul>
            </div>
        </div>
    </div>
    <!--w250 end-->
    <div class="w460 ml10 l">
        <div class="border">
            <h3 class="title"><span class="r"><a href="<?php echo WEB_URL?>goods/index/9" class="grey">更多</a></span>找活</h3>

            <div>
                <div class="textList">
                    <ul class="p_y5">
                        <?php foreach($list9 as $item):?>
                            <li>
                            <span class="greyA r">
                                <span title="<?php echo $item['creattime']?>"><?php echo $item['creattime']?></span>
                            </span>
                                <a href="<?php echo WEB_URL?>work/detail/<?php echo $item['id']?>?cid=8" title="<?php echo $item['name']?>" target="_blank"><?php echo $item['name']?></a>
                            </li>
                        <?php  endforeach;?>

                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!--w460 end-->
    <div class="w250 r">
        <div class="border">
            <h3 class="title"><span class="r"><a href="street.php" class="grey">更多</a></span><span class="orange">人气</span>商家</h3>
            <ul class="rank p_x10">
                <?php foreach($hotShopList as $key => $item):?>
                    <li class="borderBottom clearfix">
                        <i class="one l pr10"><?php echo $key+1 ?></i>
                        <a target="_blank" class="img l pr10" href="<?php echo WEB_URL?>shops/detail/<?php echo $item['shopid']?>" title="<?php echo $item['title']?>">
                            <img src="<?php echo $item['photos']?>" alt="<?php echo $item['title']?>" width="36" height="36"/>
                        </a>
                        <p><a href="<?php echo WEB_URL?>shops/detail/<?php echo $item['shopid']?>" target="_blank" class="red"><?php echo $item['title']?></a></p>
                        <p><a href="<?php echo WEB_URL?>shops/index?cid=<?php echo $item['channel_id']?>&type=<?php echo $item['tid']?>" class="orange">【<?php echo $item['name']?>】</a></p>
                    </li>

                <?php  endforeach;?>


            </ul>
        </div>
    </div>
    <!--w250 end-->
</div>
</div>
<?php endblock() ?>
