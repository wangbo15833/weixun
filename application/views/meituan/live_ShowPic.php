<?php
include_once 'base.php';
?>
<?php startblock('header_css')?>
    <link rel="stylesheet" href="<?php echo base_url()?>frontend/application/meituan/css/gallery.css" type="text/css" />
<?php endblock() ?>

<?php startblock('content') ?>
    <input type="hidden" id="hid_gid" name="hid_gid" value="<?php echo $g_info['id']?>">
    <!--面包屑-->
    <div class="trans-nav">
        <div class="crumb">
            <ul>
                <li>
                    <strong><a href="javascript:;" ><?php echo $g_info['name']?></a></strong>
                    <span class="icon-arow"></span>
                </li>
                <li>
                    <a href="javascript:;" onclick="">全部图片</a>
                    <span class="icon-arow"></span>
                </li>
            </ul>
        </div>
        <a class="btn-upload " title="上传图片" onclick="" href="<?php echo WEB_URL?>live/do_upload?gourmetid=<?php echo $gourmetid; ?>&cid=<?php echo $cid?>" rel="nofollow">上传图片</a>
    </div>
    <!--end of 面包屑-->

    <!--左边导航栏-->
    <div id="photoNav" class="photo-nav">
        <ul>
            <li class="cur">
                <a title="" class="roundbg" onclick="changeUrl(0,1)" href="javascript:;">全部图片<em class="nav-t">»</em></a>
            </li>
            <?php foreach( $pgc as $pgci):?>
                <li>
                    <dl>
                        <dt>

                            <a title=""  href="javascript:;" onclick="changeUrl(1, <?php echo $pgci['id']?>)"><?php echo $pgci['name']?><em class="nav-t">»</em></a>
                        </dt>
                        <?php foreach( $pgci['childs'] as $cci):?>
                            <dd>
                                <a title="<?php echo $cci['name']?>" onclick="changeUrl(2, <?php echo $cci['id']?>)" href="javascript:;"><?php echo $cci['name']?></a>
                            </dd>
                        <?php endforeach;?>
                    </dl>
                </li>
            <?php endforeach;?>
        </ul>
    </div>
    <!--左边导航栏结束-->

    <!--图片列表-->
    <div class="picture-list">
        <ul>
            <?php
            if(count($lists) > 0){
                foreach ($lists as $li): ?>
                    <li class="J_list">
                        <div class="img">
                            <span class="hook"></span>
                            <a  target="_blank" href="javascript:;">
                                <img alt="<?php echo $li['s_type']?>-<?php echo $g_info['name']?>" title="点击看大图" src="<?php echo $li['picUrl']?>"></a>
                        </div>
                        <div class="picture-info">
                            <div class="name">
                                <h3>
                                    <a  title="<?php echo $li['s_type']?>" target="_blank" href="javascript:;"><?php if($li['title']){ echo $li['title'];}else{echo $li['s_type'];}?></a>
                                </h3>
                                <span class="price">￥<?php echo $li['price']?></span>
                            </div>
                            <div class="info">
                                <a  title="jackbacon" target="_blank" href="javascript:;" rel="nofollow"><?php echo $li['username']?></a>
                                <em class="sep">|</em>
                                <span><?php echo $li['dateline']?></span>
                                <div class="digg-box">
                                    <a  href="javascript:" title="举报" rel="nofollow" class="J_report report Hide">举报</a>


                                    <div class="J_digg digg-wrapper digg-wrapper-s Hide">

                                        <a  href="javascript:" rel="nofollow" data-zaned="0" class="digg-btn" id="btnPraise26188876">赞</a>

                                        <span class="digg-count Hide"><strong>0</strong><em>次</em></span>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                <?php endforeach;
            }else{?>
                <li style="width: 100%; text-align: center;">暂无可显示数据!</li>
            <?php }?>
        </ul>
    </div>
    <!--图片列表-->



    <div class="Pages">

    </div>
<?php endblock() ?>

<?php startblock('foot_js')?>
    <script>
        function changeUrl(type, id){
            gid = document.getElementById('hid_gid').value;
            if(type == 0){
                window.location.href=base_url+"live/do_load?gourmetid="+gid;
            }else if(type == 1){
                window.location.href=base_url+"live/do_load?gourmetid="+gid+"&b_type="+id;
            }else{
                window.location.href=base_url+"live/do_load?gourmetid="+gid+"&s_type="+id;
            }
        }
        $(document).ready(function(){
        })
    </script>
<?php endblock() ?>