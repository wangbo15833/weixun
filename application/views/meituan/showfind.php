<?php
include_once 'base.php';
?>
<?php startblock('header_css')?>
    <link rel="stylesheet" href="<?php echo base_url()?>frontend/application/meituan/css/deal.vbefd55b3.css" />
<?php endblock() ?>

<?php startblock('content') ?>
    <div id="content">
        <input type="hidden" id="hid_id" name="hid_id" value="<?php echo $finds['id']?>"/>
        <div class="cf" id="deal-intro">
            <div class="deal-brand"><h1 class="inline-block">【<?php echo $finds['area'] ?>】<?php echo $finds['title'] ?></h1></div>
            <div class="deal-buy-cover-img">
                <img width="462" height="280"  src="<?php //if($finds['photos']){ echo $finds['photos']; }else{}?><?php echo $finds['photos'];?>" alt="<?php echo $finds['title'] ?>">
                <div class="deal-mark"><span title="今日新单" class="deal-mark__item deal-mark__item--new">今日新单</span>
                    <span title="免预约" class="deal-mark__item deal-mark__item--nnbooking">免预约</span></div>
            </div>
        </div>
        <div id="deal-stuff">
            <div class="mainbox cf">
                <div class="main" id="yui_3_8_0_2_1369363581263_80">
                    <h2 id="anchor-detail">商品详情</h2>
                    <div class="blk detail" style="width:500px; overflow: auto;" >
                        <?php echo $finds['content']?>
                    </div>
                        </div>
                 </div>
        </div>
    </div>
    <?php endblock() ?>
    <?php startblock('foot_js')?>
<?php endblock() ?>