<?php include_once 'base.php';?>
<?php startblock('header_css')?>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('/frontend/application/css/goods.css') ?>" />
<?php endblock() ?>

<?php startblock('content') ?>
<div class="w980 mt10">
<div class="clearfix">
<div class="w740 l">
    <div class="border location f12 mb10"><a title="吃喝玩乐网" class="home" id="fjump" href="">吃喝玩乐网</a><span></span><a href="street.php">商圈</a>
        <span></span> <a href="street.php?catid=1&amp;region=0">餐饮美食</a>

    </div>
    <div class="shopChoose p_x10 f12 mb10">
        <div class="chooseSearch line p_y10 clearfix"> <span class="l">共查找到 <em class="orange bold">624</em> 个商家</span>
            <form id="searchForm" method="get" action="street.php" class="shopSearch r">
                <label>
                    <input class="text" type="text" name="keyword" id="keyword" value="">
                    <input type="hidden" name="catid" value="1">
                    <input type="hidden" name="region" value="0">
                </label>
                <label>
                    <button name="shopsubmit" value="true" type="submit" class="button">搜索</button>
                </label>
            </form>
        </div>
        <div class="classInfo p_y10 line clearfix">
            <span class="l">选择分类</span>
            <span class="r">
                <a  href="<?php echo $type_all?>" class="item <?php if($type == ''){ ?>this <?php }?>">全部</a>
                <?php foreach($types as $item):?>
                    <a href="<?php  echo $item['base_url']; ?>" class="item <?php if($type == $item['id']){ ?>this <?php }?>"><?php  echo $item['name']; ?></a>
                <?php endforeach; ?>

            </span>
        </div>

        <div class="classInfo p_y10 clearfix">
            <span class="l">选择地区</span>
            <span class="r">
                <a href="<?php echo $area_all?>" class="item <?php if($area == ''){ ?>this <?php }?>">全部</a>
                <?php foreach($areas as $item):?>
                    <a href="<?php  echo $item['base_url']; ?>" class="item <?php if($area == $item['id']){ ?>this <?php }?>"><?php echo $item['name']; ?></a>
                <?php endforeach; ?>

            </span>
        </div>
    </div>
    <!--end of choose-->
    <div class="border">
        <div class="shopTitle f12 p_x10 clearfix">
            <div class="sort r"> <a href="javascript:" onclick="updateListView('street', 'sort', 'default'); return false;" style="color:red;">默认</a> | <a href="javascript:" onclick="updateListView('street', 'sort', 'remark'); return false;" style="">评分</a> | <a href="javascript:void();" onclick="updateListView('street', 'sort', 'view'); return false;" style="">浏览量</a> </div>
            <div class="l">
                <ul class="shopView clearfix">
                    <li>查看</li>
                    <li><a href="javascript:void();" onclick="updateListView('street', 'view', 'list'); return false;" class="mode_list_none mode_list_this">列表</a></li>
                    <li><a href="javascript:void();" onclick="updateListView('street', 'view', 'pic'); return false;" class="mode_big_none">大图</a></li>
                </ul>
            </div>
        </div>
        <!--end of shopTitle-->
        <div class="f12 p10">
            <?php if(count($list)): $j =1;?>
                <?php foreach($list as $item):?>
            <dl class="shopTextList clearfix">
                <dt><a target="_blank" href="<?php echo WEB_URL?>goods/detail/<?php echo $item['g_id']?>" class="img">
                        <img src="<?php echo $item['photos']?>" alt="<?php echo $item['g_title']?>" width="120" height="120"></a></dt>
                <dd><h3><a target="_blank" href="<?php echo WEB_URL?>goods/detail/<?php echo $item['g_id']?>" title="<?php echo $item['g_title']?>" class="orange"><?php echo $item['g_title']?></a></h3></dd>
                <dd>地址：<?php echo $item['address']?></dd>
                <dd>电话：<?php echo $item['phone']?></dd>
                <dd>现价：<?php echo $item['cprice']?></dd>  <dd>评分：<i class="bold orange">5</i><i class="orange">.00</i> 分</dd>
            </dl>
                <?php  endforeach;?>
                <div class="pg"><?php echo $pageShow?></div>
            <?php else:?>
            <div style="margin: 5px;">暂无可展示数据！</div>
            <?php endif;?>

        </div>
    </div>
</div>
<!--end of w740-->
<div class="w230 r">

    <div class="border mb10">
        <div class="shopRtitle f12 p_x10 bold">人气商家</div>
        <div class="rightList f12">

            <dl class="clearfix">
                <dt><a href="store.php?id=1344" target="_blank" class="img"><img src="http://e.meizhou.com/attachments/temp/871c0f42dc0c1fc0.temp.jpg" alt="亲亲天使宝宝浴池" width="50" height="50"></a></dt>
                <dd><a href="store.php?id=1344" target="_blank" class="grey">亲亲天使宝宝浴池</a></dd>
                <dd><a href="" class="orange">游泳</a></dd>
            </dl>
            <dl class="clearfix">
                <dt><a href="store.php?id=1343" target="_blank" class="img"><img src="http://e.meizhou.com/attachments/temp/4372629e9ac85e19.temp.jpg" alt="天宝帝豪会" width="50" height="50"></a></dt>
                <dd><a href="store.php?id=1343" target="_blank" class="grey">天宝帝豪会</a></dd>
                <dd><a href="" class="orange">KTV</a></dd>
            </dl>
            <dl class="clearfix">
                <dt><a href="store.php?id=1342" target="_blank" class="img"><img src="http://e.meizhou.com/attachments/temp/3829b71629da0e26.temp.jpg" alt="喜莹农家乐·乐晖豪酒吧" width="50" height="50"></a></dt>
                <dd><a href="store.php?id=1342" target="_blank" class="grey">喜莹农家乐·乐晖豪酒吧</a></dd>
                <dd><a href="" class="orange">KTV</a></dd>
            </dl>
            <dl class="clearfix">
                <dt><a href="store.php?id=1282" target="_blank" class="img"><img src="http://e.meizhou.com/attachments/temp/4e2b138265c0ca90.temp.jpg" alt="加州红KTV" width="50" height="50"></a></dt>
                <dd><a href="store.php?id=1282" target="_blank" class="grey">加州红KTV</a></dd>
                <dd><a href="" class="orange">KTV</a></dd>
            </dl>
            <dl class="clearfix">
                <dt><a href="store.php?id=1292" target="_blank" class="img"><img src="http://e.meizhou.com/attachments/temp/898bb533b05bc349.temp.jpg" alt="梅州客都大酒店帝豪音乐会所" width="50" height="50"></a></dt>
                <dd><a href="store.php?id=1292" target="_blank" class="grey">梅州客都大酒店帝豪音乐会所</a></dd>
                <dd><a href="" class="orange">KTV</a></dd>
            </dl>
            <dl class="clearfix">
                <dt><a href="store.php?id=518" target="_blank" class="img"><img src="http://e.meizhou.com/attachments/temp/f4450552695b45ff.temp.jpg" alt="天宝保健城" width="50" height="50"></a></dt>
                <dd><a href="store.php?id=518" target="_blank" class="grey">天宝保健城</a></dd>
                <dd><a href="" class="orange">沐足按摩</a></dd>
            </dl>
            <dl class="clearfix">
                <dt><a href="store.php?id=489" target="_blank" class="img"><img src="http://e.meizhou.com/attachments/temp/2af84a6a1930fdef.temp.jpg" alt="金德宝国际酒店" width="50" height="50"></a></dt>
                <dd><a href="store.php?id=489" target="_blank" class="grey">金德宝国际酒店</a></dd>
                <dd><a href="" class="orange">粤菜</a></dd>
            </dl>
            <dl class="clearfix">
                <dt><a href="store.php?id=1295" target="_blank" class="img"><img src="http://e.meizhou.com/attachments/temp/0f4b28b2ba70f2af.temp.jpg" alt="开心动漫城" width="50" height="50"></a></dt>
                <dd><a href="store.php?id=1295" target="_blank" class="grey">开心动漫城</a></dd>
                <dd><a href="" class="orange">桌球</a></dd>
            </dl>
            <dl class="clearfix">
                <dt><a href="store.php?id=520" target="_blank" class="img"><img src="http://e.meizhou.com/attachments/temp/d1570f87102aa6b1.temp.jpg" alt="飞鱼俱乐部（休闲吧）" width="50" height="50"></a></dt>
                <dd><a href="store.php?id=520" target="_blank" class="grey">飞鱼俱乐部（休闲吧）</a></dd>
                <dd><a href="" class="orange">休闲吧</a></dd>
            </dl>
            <dl class="clearfix">
                <dt><a href="store.php?id=537" target="_blank" class="img"><img src="http://e.meizhou.com/attachments/temp/371044f35fa627db.temp.jpg" alt="泊涯户外自助咖啡馆" width="50" height="50"></a></dt>
                <dd><a href="store.php?id=537" target="_blank" class="grey">泊涯户外自助咖啡馆</a></dd>
                <dd><a href="" class="orange">休闲吧</a></dd>
            </dl>
        </div>
    </div>
    <!--end of border-->
    <div class="border mb10">
        <div class="shopRtitle f12 p_x10 bold">人气商家</div>
        <div class="rightList f12"><dl class="clearfix">
                <dt><a href="store.php?id=483" target="_blank" class="img"><img src="http://e.meizhou.com/attachments/temp/cb9c73edc3fe268b.temp.jpg" alt="金沙湾酒店（自助餐）"></a></dt>
                <dd><a href="store.php?id=483" target="_blank" class="grey">金沙湾酒店（自助餐）</a></dd>
                <dd><a href="" class="orange">自助餐</a></dd>
            </dl>
            <dl class="clearfix">
                <dt><a href="store.php?id=363" target="_blank" class="img"><img src="http://e.meizhou.com/attachments/temp/05eb9fda4f7ea652.temp.jpg" alt="联邦酒店"></a></dt>
                <dd><a href="store.php?id=363" target="_blank" class="grey">联邦酒店</a></dd>
                <dd><a href="" class="orange">粤菜</a></dd>
            </dl>
            <dl class="clearfix">
                <dt><a href="store.php?id=36" target="_blank" class="img"><img src="http://e.meizhou.com/attachments/temp/474f4db74c275db6.temp.jpg" alt="友谊宾馆"></a></dt>
                <dd><a href="store.php?id=36" target="_blank" class="grey">友谊宾馆</a></dd>
                <dd><a href="" class="orange">粤菜</a></dd>
            </dl>
            <dl class="clearfix">
                <dt><a href="store.php?id=267" target="_blank" class="img"><img src="http://e.meizhou.com/attachments/temp/9bbed7784b897f50.temp.jpg" alt="客都大酒店"></a></dt>
                <dd><a href="store.php?id=267" target="_blank" class="grey">客都大酒店</a></dd>
                <dd><a href="" class="orange">酒店</a></dd>
            </dl>
            <dl class="clearfix">
                <dt><a href="store.php?id=4" target="_blank" class="img"><img src="http://e.meizhou.com/attachments/temp/0ac23856adcd1be8.temp.jpg" alt="金雁富源大酒店（中餐）"></a></dt>
                <dd><a href="store.php?id=4" target="_blank" class="grey">金雁富源大酒店（中餐）</a></dd>
                <dd><a href="" class="orange">粤菜</a></dd>
            </dl>
        </div>
    </div>
    <!--end of border--></div>
<!--end of w230-->
</div>
<!--end of clearfix-->

</div>
<?php endblock() ?>

<?php startblock('foot_js')?>
<?php endblock() ?>

