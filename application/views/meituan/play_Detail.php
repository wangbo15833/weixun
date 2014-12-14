<?php
include_once 'base.php';
?>
<?php startblock('header_css')?>
    <link rel="stylesheet" href="<?php echo base_url()?>frontend/application/meituan/css/deal.vbefd55b3.css" />

<?php endblock() ?>

<?php startblock('content') ?>

    <div id="content">
        <input type="hidden" id="hid_id" name="hid_id" value="<?php echo $commoditys['id']?>"/>
        <input type="hidden" id="hid_cid" name="hid_cid" value="<?php echo $channelId?>"/>

        <div class="cf" id="deal-intro">
            <h2 class="deal-title">【<?php echo $commoditys['area'] ?>】<?php echo $commoditys['name'] ?></h2>
            <div class="deal-buy-cover-img">
                <img width="462" height="280"  src="<?php if($commoditys['photos']){ echo $commoditys['photos']; }else{?>http://p0.meituan.net/deal/__12299505__9489745.jpg<?php }?>" alt="<?php echo $commoditys['name'] ?>">
                <p style="margin: 5px 5px 5px 10px">
                    <a style="float: left" href="<?php echo WEB_URL?>play/do_load?gourmetid=<?php echo $commoditys['id']?>&cid=<?php echo $channelId?>">所有图片</a>
                    <a  href="<?php echo WEB_URL?>play/do_upload?gourmetid=<?php echo $commoditys['id']?>&cid=<?php echo $channelId?>"/>
                    <span style="" class="utop"></span>我来上传</a></p>
            </div>
            <div class="main">
                <div class="deal-discount">
                    <span class="price"><span class="symbol-RMB"></span> 单价：<?php echo $commoditys['price'] ?>元</span>
                </div>

                <div class="deal-info">
                    <p class="p_show">电话：<?php echo $commoditys['phone'] ?></p>
                    <p class="p_show">地址：<?php echo $commoditys['addr'] ?></p>
                    <p class="p_show">标签：<?php echo $commoditys['tag'] ?></p>

                    <div class="">
                        <p class=""><img style="width:150px;height: 150px;" src="<?php if(isset($commoditys['show_code'])) echo $commoditys['show_code']?>"/></p>
                    </div>
                    <input type="button" class="btn_bg" value="完善资料"/>
                </div>
            </div>
            <div class="deal-preference">
                <div class="preference-bar">
                    <div class="deal-share">

                    </div>
                    <?php if($commoditys['shoucang']==1):?>
                        <a class="in-favorite" href="javascript:void(0)">已收藏本单</a>
                    <?php else: ?>
                        <a gaevent="content/main/addFavorite" class="add-favorite" href="javascript:void(0)" id="shoucang">收藏商品</a>
                    <?php endif;?>
                </div>
            </div>
        </div>

        <div style="height: 39px; display: none;" class="common-fix-placeholder" id="yui_3_8_0_2_1369363581263_185"></div>
        <div id="deal-stuff">
            <div class="mainbox cf">
                <div class="main" id="yui_3_8_0_2_1369363581263_80">
                    <h2 id="anchor-detail">商品详情</h2>
                    <div>
                        <p> --推荐菜</p>
                        <?php if($relList != ''): foreach($relList as $ritem): ?>
                            <img src="<?php echo $ritem['picUrl']; ?>" title="<?php echo $ritem['gc_name']; ?>" alt="<?php echo $ritem['gc_name']; ?>" style="width: 150px; height: 120px;" />
                        <?php endforeach; endif; ?>
                    </div>
                    <div class="blk detail" style="width:500px; overflow: auto;" >
                        <?php if(isset($commoditys['summary'])) echo $commoditys['summary'];?>
                    </div>
                    <!--评论-->
                    <div class="user-reviews" id="anchor-reviews">
                        <div class="standard-bar" style="width:617px; ">会员评价<a href="javascript:void(0)" style="float: right">我要评价</a></div>
                        <form action="" method="post" id="" name="">
                            <div class="overview">
                                <div class="overview-head cf">
                                    <h3 class="overview-title">总体评价</h3>
                                </div>
                                <div class="" style="margin: 5px; padding: 5px;">
                                    <div class="form-block rating-block rating-changes" id="J_shop-rating" style="height: 60px;">
                                        <span class="label label_required" style="float: left">总体评价：</span>
                                        <div id="J_review-s1" class="rating-wrap-big" >
                                            <ul>
                                                <li>
                                                    <a href="javascript:;" data-rate-value="10" data-hint="很差" title="很差" class="one-star "></a>
                                                </li>
                                                <li>
                                                    <a href="javascript:;" data-rate-value="20" data-hint="差" title="差" class="two-stars "></a>
                                                </li>
                                                <li>
                                                    <a href="javascript:;" data-rate-value="30" data-hint="还行" title="还行" class="three-stars "></a>
                                                </li>
                                                <li>
                                                    <a href="javascript:;" data-rate-value="40" data-hint="好" title="好" class="four-stars "></a>
                                                </li>
                                                <li>
                                                    <a href="javascript:;" data-rate-value="50" data-hint="很好" title="很好" class="five-stars "></a>
                                                </li>
                                            </ul>
                                        </div>
                                        <span class="hint">总体评价打分</span>
                                        <input type="hidden" id="hid_star"/>
                                    </div>
                                    <div class="form-block rating-block rating-changes" id="J_shop-rating2" style="height: 60px;">
                                        <span class="label label_required" style="float: left">服务态度：</span>
                                        <div id="J_review-s2" class="rating-wrap-big">
                                            <ul>
                                                <li>
                                                    <a href="javascript:;" data-rate-value="10" data-hint="很差" title="很差" class="one-star "></a>
                                                </li>
                                                <li>
                                                    <a href="javascript:;" data-rate-value="20" data-hint="差" title="差" class="two-stars "></a>
                                                </li>
                                                <li>
                                                    <a href="javascript:;" data-rate-value="30" data-hint="还行" title="还行" class="three-stars "></a>
                                                </li>
                                                <li>
                                                    <a href="javascript:;" data-rate-value="40" data-hint="好" title="好" class="four-stars "></a>
                                                </li>
                                                <li>
                                                    <a href="javascript:;" data-rate-value="50" data-hint="很好" title="很好" class="five-stars "></a>
                                                </li>
                                            </ul>
                                        </div>
                                        <span class="hint">给服务打分</span>
                                        <input type="hidden" id="hid_star2"/>
                                    </div>
                                    <div class="form-block rating-block rating-changes" id="J_shop-rating3" style="height: 60px;">
                                        <span class="label label_required" style="float: left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;环境：</span>
                                        <div id="J_review-s3" class="rating-wrap-big" style="float: left">
                                            <ul>
                                                <li>
                                                    <a href="javascript:;" data-rate-value="10" data-hint="很差" title="很差" class="one-star "></a>
                                                </li>
                                                <li>
                                                    <a href="javascript:;" data-rate-value="20" data-hint="差" title="差" class="two-stars "></a>
                                                </li>
                                                <li>
                                                    <a href="javascript:;" data-rate-value="30" data-hint="还行" title="还行" class="three-stars "></a>
                                                </li>
                                                <li>
                                                    <a href="javascript:;" data-rate-value="40" data-hint="好" title="好" class="four-stars "></a>
                                                </li>
                                                <li>
                                                    <a href="javascript:;" data-rate-value="50" data-hint="很好" title="很好" class="five-stars "></a>
                                                </li>
                                            </ul>
                                        </div>
                                        <span class="hint" style="width: 120px;">给环境打分</span>
                                        <input type="hidden" id="hid_star3"/>
                                    </div>
                                    <div ><textarea id="messText" name="messText" style="width: 95%;height: 50%; margin: 10px 10px 5px 10px;"></textarea></div></div>
                                <input type="button" name="" id="messBtn" class="" style="margin: 5px 0px 5px 80%;" value="发  布" />
                            </div>
                        </form>
                        <div class="detail">
                            <ul class="filter cf" id="yui_3_8_0_2_1369363581263_135">
                                <li class="current">
                                    <a data-filter="all" gaevent="content/detail/reviews/all" href="javascript:void(0);">全部评价</a>
                                </li>
                                <!---->
                                <li class="last">
                                    <input type="checkbox" id="with-content" checked="checked" name="withcontent">
                                    <label for="with-content" class="widthcontent-label">有内容的评价</label>
                                    <a href="javascript:void(0)" hidefocus="true" data-sort="default" class="sort-default selected-sort">默认</a>
                                    <a href="javascript:void(0)" hidefocus="true" data-sort="time" class="sort-time">按时间<span class="pngfix sort-icon"></span></a>
                                </li>

                            </ul>
                            <ul class="review-list"><!--评论内容展示--></ul>
                            <div class="page-navbar cf"></div>
                        </div>
                    </div>            </div>
            </div>
        </div>
        <!---可能感兴趣的商品列表
        <div  id="deal-bottom-list" class="recommend-deals cf  recommend-skin"> </div>--->
    </div>
<div id="sidebar">
    <div id="c_shops_info" style="width: 240px; background-color: #ffffff; margin-bottom: 5px;"></div>
    <!----start map--->
    <input type="hidden" name="hid_map_x" id="hid_map_x" value="<?php echo $commoditys['map_x'] ?>"/>
    <input type="hidden" name="hid_map_y" id="hid_map_y" value="<?php echo $commoditys['map_y'] ?>"/>
    <div id="container" style="height: 200px;"></div>
    <!--**************************************************right  start************************************************************************************************-->
    <?php endblock() ?>

    <?php startblock('foot_js')?>
    <script type="text/javascript" src="http://api.map.baidu.com/api?v=1.5&ak=D95ab8521dabc49243d995d83217505d"></script>
    <script type="text/javascript" src="<?php echo base_url()?>frontend/application/meituan/js/common/gourmet.js"></script>
    <script>//点击完善资料、路径
        $('.btn_bg').click(function () {
            if (parseInt($('#hid_id').val()) > 0)
                window.location.href = base_url + 'play/happyEdit?g_id=' + $('#hid_id').val();
        });</script>
<?php endblock() ?>