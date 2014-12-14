<?php include_once 'base.php';?>
<?php startblock('header_css')?>

<?php endblock() ?>

<?php startblock('content') ?>

<div class="show_pic">
    <div data-mod="ic" id="filter">
        <div class="hot-tag-outer-box"></div>
        <div class="filter-sortbar-outer-box" id="yui_3_8_0_1_1369787566859_215">

            <div class="filter-section-wrapper" id="yui_3_8_0_1_1369787566859_214">
                <?php //if(count($categorys) > 0):?>
                <div id="div_categorys" class="filter-label-list filter-section category-filter-wrapper first-filter" id="yui_3_8_0_1_1369787566859_213">
                    <div class="label has-icon"><i></i>分类：</div>
                    <ul class="inline-block-list" id="categorys">
                        <li class="item <?php if($ctype == ''){ ?>current <?php }?>"><a  href="<?php echo $ctype_all?>">全部</a></li>
                        <?php foreach($categorys as $item):?>
                            <li class="item <?php if($ctype == $item['id']){ ?>current <?php }?>"><a href="<?php  echo $item['base_url']; ?>"><?php  echo $item['name']; ?><span></span></a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <?php if(count($hm) > 0):?>
                    <div id="div_home" class="filter-label-list filter-section category-filter-wrapper first-filter">
                        <div class="label has-icon"><i></i>子类：</div>
                        <ul class="inline-block-list" id="homes">
                            <li class="item <?php if($hmi == ''){ ?>current <?php }?>"><a  href="<?php echo $home_all?>">全部</a></li>
                            <?php foreach($hm as $item):?>
                                <li class="item <?php if($hmi == $item['id']){ ?>current <?php }?>">
                                    <a href="<?php  echo $item['base_url']; ?>"><?php  echo $item['name']; ?>
                                        <span></span></a></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif;?>
                <div class="filter-label-list filter-section geo-filter-wrapper">
                    <div class="label has-icon"><i></i>区域：</div>
                    <ul class="inline-block-list" id="districtList">
                        <li class="item <?php if($district == ''){ ?>current <?php }?>"><a  href="<?php echo $district_all?>">全部</a></li>
                        <?php foreach($citys as $item):?>
                            <li class="item <?php if($district == $item['area_id']){ ?>current <?php }?>"><a href="<?php  echo $item['base_url']; ?>"><?php echo $item['area_name']; ?><span></span></a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
            <div class="sort-bar">

                <a  href="<?php echo$url_window?>"><strong class="show_datudt"></strong></a><a  href="<?php echo $url_list?>"><strong class="show_datu"></strong></a>
                <div class="button-strip inline-block">

                    <a class="button-strip-item inline-block button-strip-item-right button-strip-item-checked" title="默认排序"
                       href='javascript: get_search_url(1);'><span class="inline-block button-outer-box"><span class="inline-block button-content">默认排序</span></span></a>
                    <a class="button-strip-item inline-block button-strip-item-left button-strip-item-right button-strip-item-asc" title="价格从低到高"
                       href="javascript: get_search_url(2);"><span class="inline-block button-outer-box">
                                <span class="inline-block button-content">价格</span><span class="inline-block button-img"></span></span></a>
                    <a class="button-strip-item inline-block button-strip-item-left button-strip-item-right button-strip-item-desc" title="价格从高到低"
                       href="javascript: get_search_url(3);"><span class="inline-block button-outer-box">
                                <span class="inline-block button-content">价格</span><span class="inline-block button-img"></span></span></a>
                    <a class="button-strip-item inline-block button-strip-item-left button-strip-item-desc large-button" title="发布时间从新到旧"
                       href="javascript: get_search_url(4);"><span class="inline-block button-outer-box">
                                <span class="inline-block button-content">发布时间</span><span class="inline-block button-img"></span></span></a>
                </div>
            </div>
        </div>
    </div></div>

<?php if(count($picList_r)>0):?>
    <div class="show_right" >
        <?php foreach($picList_r as $i):?>
            <?php if($i['site']== 2): ?>
                <div class="show_right_item"><img src="<?php echo $i['photoUrl']?>"/></div><?php endif;?>
        <?php endforeach;?>
    </div>
<?php endif;?>
<div  id="content" class="normal-deal-list cf ">

    <?php if(count($list)): $j =1;?>
        <?php if($n ==1):?>
            <?php foreach($list as $item):?>
                <div class="item <?php if(($j%2) == 0):?>odd<?php endif; $j++;?>" id="" >
                    <div class="cover">
                        <a href="<?php echo WEB_URL?>service/detail/<?php echo $item['type']?>/<?php echo $item['id']?>" target="_blank">
                            <img width="312" height="189"  src="<?php echo $item['photos']?>" alt=""></a>
                    </div>
                    <h3 ><a title="<?php echo $item['name']?>"   href="<?php echo WEB_URL?>service/detail/<?php echo $item['type']?>/<?php echo $item['id']?>" target="_blank">
                            <span class="xtitle" style="display: inline"><?php echo $item['name']?></span>
                            <span class="short-title"><?php echo $item['addr']?></span>
                        </a></h3>
                    <p class="detail" style="text-align: left"><a  href="<?php echo WEB_URL?>service/detail/<?php echo $item['type']?>/<?php echo $item['id']?>" target="_blank" hidefocus="true" class="buy" rel="nofollow">去看看</a>
                        <em class="price num" >¥<?php echo $item['price']?></em>
                        <!--<span class="bypast">门店价 <span class="num"><span>¥</span>248</span></span>-->
                    </p><!--<p class="total"><strong class="num">110</strong>人已团购</p>-->
                </div>
            <?php  endforeach;?>
        <?php else:?>
            <div class="item" style="width: 670px;height: auto;; margin: 0px;">
                <?php foreach($list as $item):?>
                    <div>
                        <div class="list_d_item">
                            <ul>
                                <li>
                                    <a  target="_blank" href="<?php echo WEB_URL?>service/detail/<?php echo $item['type']?>/<?php echo $item['id']?>">
                                        <h1><?php echo $item['name']?></h1></a></li>
                                <li><i>地址：</i><?php echo $item['addr']?>&nbsp;&nbsp;<?php echo $item['phone']?></li>
                                <li><i>标签：</i><?php echo $item['tag']?></li>
                            </ul>

                        </div>
                        <div class="list_d_item_1">
                            ￥<?php if($item['price'] > 0){echo $item['price'];}else{ echo 0;}?>元
                        </div>
                        <div style="height: 70px;text-align: center;margin:0px; padding-top: 10px;">
                            <ul>
                                <li>
                                    <a rel="nofollow" class="buy" hidefocus="true" target="_blank" href="<?php echo WEB_URL?>service/detail/<?php echo $item['type']?>/<?php echo $item['id']?>">去看看</a>
                                </li>

                            </ul>
                        </div>
                    </div>
                    <hr/>
                <?php  endforeach;?>
            </div>
        <?php endif;?>
        <div class="page newinte_seepage"><?php echo $pageShow?></div>
    <?php else:?>
        <div style="margin: 5px;">暂无可展示数据！</div>
    <?php endif;?>

</div>

<?php endblock() ?>

<?php startblock('foot_js')?>
<script>
    function get_search_url(status){
        var url =window.location.href;
        var new_url;
        //alert(url.substr(url.indexOf('datastatus')));
        if(url.indexOf('?') > 0){
            if(url.indexOf('datastatus') <0){
                new_url = url + '&datastatus='+status;
            }else{
                new_url = url.substr(0,url.indexOf('datastatus')) + 'datastatus='+status;
            }
        }else{
            new_url = url + '?datastatus='+status;
        }
        window.location.href= new_url;
    }
    $(document).ready(function(){})

        function get_order_url(status){
            var url = window.location.href;
            var sequence ='';
            if(url.indexOf('?')>0){
                sequence = url +'&sequence='+status;
            }else{
                sequence = url +'?sequence='+status;
            }
            window.location.href = sequence;
        }


</script>
<?php endblock() ?>

