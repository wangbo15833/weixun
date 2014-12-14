<?php
include_once 'base.php';
?>
<?php startblock('header_css')?>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('/frontend/application/default/css/shops.css') ?>" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('/frontend/application/default/css/comment.css') ?>" />

    <script type="text/javascript" src="<?php echo base_url('/frontend/application/default/js/easytabs.js') ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('/frontend/application/default/js/common.js') ?>"></script>
    <script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=D233382db800044ba5915ab2ffaae458"></script>
    <style type="text/css">
        #allmap {width: 100%;height: 100%;overflow: hidden;hidden;margin:0;}
    </style>

<?php endblock() ?>

<?php startblock('content') ?>

    <div class="w980">
    <div class="detail mb10">
        <div class="dTitle orange p_x10 bold f12">
            <a href="<?php echo base_url() ?>" class="orange">我爱生活网</a> &gt; <a href="<?php echo base_url() ?>index.php/shops/index/<?php echo $cid;?>"><?php echo $channel;?></a> &gt; <?php echo $shop['title'];?>
        </div>
        <div class="p10 clearfix">
            <div class="l">
                <a href="" class="img">
                    <img src="<?php echo $shop['sphoto']?>" width="300" height="260">
                </a>
            </div>
            <div class="name l">
                <h1 class="weiruan orange pb10 mb10"><?php echo $shop['title'];?></h1>
                <p>电话： <?php echo $shop['phone'];?></p>
                <p>地址： <?php echo $shop['address'];?></p>

                <div class="orange clearfix"><span class="l">口味:&nbsp;&nbsp;</span><div class="score l f12 orange"><div class="scoreBg" style="width:100%;"><span>5 分</span></div></div></div>

                <div class="orange clearfix"><span class="l">环境:&nbsp;&nbsp;</span><div class="score l f12 orange"><div class="scoreBg" style="width:100%;"><span>5 分</span></div></div></div>

                <div class="orange clearfix"><span class="l">服务:&nbsp;&nbsp;</span><div class="score l f12 orange"><div class="scoreBg" style="width:100%;"><span>5 分</span></div></div></div>

                <p style="margin-bottom:10px;">总评分：<img style="vertical-align:middle;" src="<?php echo base_url('/frontend/application/default/images/5_big.png') ?>">
                    <font color="red" style="font-weight:blod;font-size:14px;vertical-align:middle;">5.00</font> 分</p>
                <p><a href="#我要点评" title="我要点评" class="want l"></a><span class="l ml10 f12" style="line-height:36px;">共<em class="red">1</em>人点评</span>
                    <span class="l ml10 f12" style="line-height:36px;"><em class="red">&nbsp;&nbsp;人均: 12.0 元</em></span></p>
            </div>
            <div class="map r">
                <input name="map_x" id="map_x" type="hidden" value="<?php echo $shop['map_x']?>">
                <input name="map_y" id="map_y" type="hidden" value="<?php echo $shop['map_y']?>">
                <input name="address" id="address" type="hidden" value="<?php echo $shop['address']?>">
                <div style="width: 250px; height: 230px; position: relative; background-color: rgb(229, 227, 223); overflow: hidden; ">
                    <div id="allmap"></div>
                </div>
                <ul class="map_a f12 clearfix">
                    <li><a href="store.php?id=1268&amp;action=map" target="_blank">查看大图</a></li>
                    <li><a href="store.php?id=1268&amp;action=map&amp;op=mark" target="_blank">纠正标注</a></li>
                </ul>
            </div>
        </div>
    </div>
    <!--end of detail--><div class="clearfix">
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
    <div class="w740 l">
        <ul class="shopTab f12 clearfix">
            <li onmouseover="easytabs('1', '1');" onfocus="easytabs('1', '1');" id="tablink1"><a href="#"  onclick="return false;"  title="" >店铺详情</a></li>
            <li onmouseover="easytabs('1', '2');" onfocus="easytabs('1', '2');" id="tablink2"><a href="#"  onclick="return false;"  title="" >店铺公告</a></li>

        </ul>
        <div id="tabcontent1">
            <div class="p10 border mb10 introduce">
                <?php echo $shop['content']?>

            </div>
        </div>

        <div id="tabcontent2">
            <div class="p10 border mb10 introduce">
                abccc

            </div>
        </div>

        <script type="text/javascript" charset="gbk">
            function deletecomm(cid,score) {
                if(score) {
                    var from = 'remark';
                } else {
                    var from = 'comm';
                }
                if (confirm("确认要删除吗?")){
                    $("#delitemid")[0].value = cid;
                    $("#delMegForm_"+from).submit();
                }
                return false;
            }
        </script>
        <div class="message">
            <ul class="shopTab f12 clearfix">
                <li><a href="" name="我要点评" class="mouseover">我要点评</a></li>
            </ul>

            <div id="comment208">
                <div class="comment">

                </div>
            </div><div id="postlistreply"></div><!--comment form-->
            <script type="text/javascript">
                var hdrewardid = "commentscorestr";
                function setreward(rewardid,value) {
                    var hdreward = document.getElementById(hdrewardid);
                    if(hdreward.value.indexOf("@" + rewardid +"@") > -1 ) {
                        var reg = new RegExp("@" + rewardid +"@\\d");
                        hdreward.value = hdreward.value.replace(reg,"@" + rewardid +"@" + value);
                    } else {
                        hdreward.value += "@" + rewardid +"@" + value;
                    }
                    return false;
                }

                // onmouseover change the style
                function star_hover(rewardid,cur){
                    for(var i = 1;i<6;i++) {
                        var oldclick = document.getElementById("reward"+i+"_"+rewardid);
                        if(i < (cur+1)) {
                            oldclick.src = "<?php echo base_url('/frontend/application/default/images/star_yellow.gif') ?>";
                        }else{
                            oldclick.src = "<?php echo base_url('/frontend/application/default/images/star_grey.gif') ?>";
                        }
                    }
                }
                // onmouseout restore the style
                function star_restore(rewardid){
                    var hdreward = document.getElementById(hdrewardid).value;
                    var reg = new RegExp("@" + rewardid +"@(\\d)");
                    oldscore = reg.exec(hdreward);
                    if(oldscore == null || oldscore[1]==null){
                        star_hover(rewardid,0);
                    }else{
                        star_hover(rewardid,parseInt(oldscore[1]));
                    }

                }
            </script>
            <div class="publish border mt10">
                <div class="shopRtitle f12 p_x10 bold">发表点评</div>
                <div class="p10 f12">
                    <form id="msgForm_remark" action="" method="post" class="send">
                        
                        <div class="writemessage">
                            <input name="commentscorestr" id="commentscorestr" type="hidden">


                            <label class="clearfix" id="comment_score_area">
                                <div class="l mr10">
                                    <span class="l">商品:&nbsp;</span>
                                    <span class="l">
                                        <img id="reward1_11" onmouseover="star_hover(11,1);" onmouseout="star_restore(11);" onclick="return setreward(11,1);" src="<?php echo base_url('/frontend/application/default/images/star_grey.gif') ?>">
                                        <img id="reward2_11" onmouseover="star_hover(11,2);" onmouseout="star_restore(11);" onclick="return setreward(11,2);" src="<?php echo base_url('/frontend/application/default/images/star_grey.gif') ?>">
                                        <img id="reward3_11" onmouseover="star_hover(11,3);" onmouseout="star_restore(11);" onclick="return setreward(11,3);" src="<?php echo base_url('/frontend/application/default/images/star_grey.gif') ?>">
                                        <img id="reward4_11" onmouseover="star_hover(11,4);" onmouseout="star_restore(11);" onclick="return setreward(11,4);" src="<?php echo base_url('/frontend/application/default/images/star_grey.gif') ?>">
                                        <img id="reward5_11" onmouseover="star_hover(11,5);" onmouseout="star_restore(11);" onclick="return setreward(11,5);" src="<?php echo base_url('/frontend/application/default/images/star_grey.gif') ?>">
                                    </span>
                                </div>
                                <div class="l mr10">
                                    <span class="l">环境:&nbsp;</span>
                                    <span class="l">
                                        <img id="reward1_12" onmouseover="star_hover(12,1);" onmouseout="star_restore(12);" onclick="return setreward(12,1);" src="<?php echo base_url('/frontend/application/default/images/star_grey.gif') ?>">
                                        <img id="reward2_12" onmouseover="star_hover(12,2);" onmouseout="star_restore(12);" onclick="return setreward(12,2);" src="<?php echo base_url('/frontend/application/default/images/star_grey.gif') ?>">
                                        <img id="reward3_12" onmouseover="star_hover(12,3);" onmouseout="star_restore(12);" onclick="return setreward(12,3);" src="<?php echo base_url('/frontend/application/default/images/star_grey.gif') ?>">
                                        <img id="reward4_12" onmouseover="star_hover(12,4);" onmouseout="star_restore(12);" onclick="return setreward(12,4);" src="<?php echo base_url('/frontend/application/default/images/star_grey.gif') ?>">
                                        <img id="reward5_12" onmouseover="star_hover(12,5);" onmouseout="star_restore(12);" onclick="return setreward(12,5);" src="<?php echo base_url('/frontend/application/default/images/star_grey.gif') ?>">
                                    </span>
                                </div>
                                <div class="l mr10">
                                    <span class="l">服务:&nbsp;</span>
                                    <span class="l">
                                        <img id="reward1_13" onmouseover="star_hover(13,1);" onmouseout="star_restore(13);" onclick="return setreward(13,1);" src="<?php echo base_url('/frontend/application/default/images/star_grey.gif') ?>">
                                        <img id="reward2_13" onmouseover="star_hover(13,2);" onmouseout="star_restore(13);" onclick="return setreward(13,2);" src="<?php echo base_url('/frontend/application/default/images/star_grey.gif') ?>">
                                        <img id="reward3_13" onmouseover="star_hover(13,3);" onmouseout="star_restore(13);" onclick="return setreward(13,3);" src="<?php echo base_url('/frontend/application/default/images/star_grey.gif') ?>">
                                        <img id="reward4_13" onmouseover="star_hover(13,4);" onmouseout="star_restore(13);" onclick="return setreward(13,4);" src="<?php echo base_url('/frontend/application/default/images/star_grey.gif') ?>">
                                        <img id="reward5_13" onmouseover="star_hover(13,5);" onmouseout="star_restore(13);" onclick="return setreward(13,5);" src="<?php echo base_url('/frontend/application/default/images/star_grey.gif') ?>">
                                    </span>
                                </div>
                            </label>

                            <h5 id="reply" style="display:none;">回复： <span id="replyname"></span></h5>
                            <label>
                                <textarea cols="10" rows="5" id="commentmessage" name="commentmessage"></textarea>
                            </label>
                            <div id="ajax_status_display"></div>
                            <label class="clearfix">
                                <span class="l grey">(15-250个字)</span>
                                <span class="r">
                                    <input id="submitMsgForm" name="" value="我要点评" type="button"  class="button white bold">
                                    <!--<input id="isprivate" name="isprivate" class="checkbox" value="1" type="checkbox" style="border:none; background:none;" />仅店长可见-->

                                    <input type="hidden" id="shopid" name="shopid" value="<?php echo $shop['shopid']?>">
                                    <input type="hidden" id="channelid" name="channelid" value="<?php echo $shop['cid']?>">
                                    <input type="hidden" id="upcid" name="upcid" value="" size="5">
                                    <input type="hidden" id="type" name="type" value="shop" size="5">
                                    <input type="hidden" value="1" name="ismodle" id="ismodle">
                                    <input type="hidden" value="store.php?id=1268&amp;op=view" name="stuffurl">
                                    <input type="hidden" value="1" name="page">
                                </span>
                            </label>
                        </div>
                    </form>
                </div>

            </div>
        </div>
        <script type="text/javascript" charset="gbk">
            //	bindform('msgForm');
        </script>
        <script type="text/javascript" charset="gbk">
            function isAvg(){
                var avgprice = document.getElementById("avgprice").value;
                var type="^[1-9]*[1-9][0-9]*$";
                var re   =   new   RegExp(type);
                if (avgprice.match(re)==null && avgprice != "")
                {
                    alert("请输入正整数");
                    document.getElementbyId("avgprice").focus;
                }
            }
        </script></div>
    <!--end of w740-->
    </div>
    <!--end of clearfix-->
    </div>

<?php endblock() ?>

<?php startblock('foot_js')?>
    <script type="text/javascript" src="<?php echo base_url('/frontend/application/default/js/comment.js') ?>"></script>
    <script type="text/javascript">

        var map_x = document.getElementById("map_x").value;
        var map_y = document.getElementById("map_y").value;
        var address = document.getElementById("address").value;
        // 百度地图API功能
        var map = new BMap.Map("allmap");
        map.centerAndZoom(new BMap.Point(map_x, map_y), 14);
        var marker1 = new BMap.Marker(new BMap.Point(map_x, map_y));  // 创建标注
        map.addOverlay(marker1);              // 将标注添加到地图中

        //创建信息窗口
        var infoWindow1 = new BMap.InfoWindow(address);
        marker1.addEventListener("click", function(){this.openInfoWindow(infoWindow1);});


    </script>
<?php endblock() ?>