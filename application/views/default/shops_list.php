<?php include_once 'base.php';?>
<?php startblock('header_css')?>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('/frontend/application/default/css/goods.css') ?>" />
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
<div class="w980 mt10">
<div class="clearfix">
<div class="w740 l">
    <div class="border location f12 mb10"><a title="吃喝玩乐网" class="home" id="fjump" href="./">吃喝玩乐网</a><span></span><a href="street.php">商圈</a>
        <span></span> <a href="street.php?catid=1&amp;region=0">餐饮美食</a>

    </div>
    <div class="shopChoose p_x10 f12 mb10">
        <div class="chooseSearch line p_y10 clearfix"> <span class="l">共查找到 <em class="orange bold">624</em> 个商家</span>
            <form id="searchForm" method="get" action="<?php echo base_url('/index.php/shops/index') ?>" class="shopSearch r">
                <label>
                    <input class="text" type="text" name="searchkey" id="header_search" value="">

                </label>
                <label>
                    <input class="button "  id="search_submit" type="submit" value="搜索"/>
                </label>
            </form>
        </div>
        <div class="classInfo p_y10 line clearfix">
            <span class="l">选择分类</span>
            <span class="r">
                <a  href="<?php echo $type_all?>" class="item <?php if($type == ''){ ?>this <?php }?>">全部</a>
                <?php foreach($types as $item):?>
                    <a href="<?php  echo $item['base_url']; ?>" class="item <?php if($type == $item['typeid']){ ?>this <?php }?>"><?php  echo $item['name']; ?></a>
                <?php endforeach; ?>

            </span>
        </div>

        <div class="classInfo p_y10 clearfix">
            <span class="l">选择地区</span>
            <span class="r">
                <a href="<?php echo $area_all?>" class="item <?php if($area == ''){ ?>this <?php }?>">全部</a>
                <?php foreach($areas as $item):?>
                    <a href="<?php  echo $item['base_url']; ?>" class="item <?php if($area == $item['did']){ ?>this <?php }?>"><?php echo $item['dname']; ?></a>
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
                <dt><a target="_blank" href="<?php echo WEB_URL?>shops/detail/<?php echo $item['shopid']?>" class="img">
                        <img src="<?php echo $item['photos']?>" alt="<?php echo $item['title']?>" width="120" height="120"></a></dt>
                <dd><h3><a target="_blank" href="<?php echo WEB_URL?>shops/detail/<?php echo $item['shopid']?>" title="<?php echo $item['title']?>" class="orange"><?php echo $item['title']?></a></h3></dd>
                <dd>地址：<?php echo $item['address']?></dd>
                <dd>电话：<?php echo $item['phone']?></dd>
                <dd>评分：<i class="bold orange">5</i><i class="orange">.00</i> 分</dd>
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

            <?php foreach($hotShopList as $item):?>
                <dl class="clearfix">
                    <dt>
                        <a href="<?php echo WEB_URL?>shops/detail/<?php echo $item['shopid']?>" target="_blank" class="img">
                            <img src="<?php echo $item['photos']?>" alt="<?php echo $item['title']?>" width="50" height="50">
                        </a>
                    </dt>
                    <dd><a href="<?php echo WEB_URL?>shops/detail/<?php echo $item['shopid']?>" target="_blank" class="grey"><?php echo $item['title']?></a></dd>
                    <dd><a href="<?php echo WEB_URL?>shops/index?cid=<?php echo $item['channel_id']?>&type=<?php echo $item['tid']?>" class="orange"><?php echo $item['name']?></a></dd>
                </dl>
            <?php  endforeach;?>

        </div>
    </div>
    <!--end of border-->
 </div>
<!--end of w230-->
</div>
<!--end of clearfix-->

</div>
<?php endblock() ?>

<?php startblock('foot_js')?>
<?php endblock() ?>

