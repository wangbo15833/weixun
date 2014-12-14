<?php include_once 'base.php'; ?>
<?php startblock('header_css') ?>

<?php endblock() ?>

<?php startblock('content') ?>

<div id="content" class="normal-deal-list cf ">
<div class="item" style="width: 670px;height: auto;; margin: 0px;">
    <h1>购</h1>
    <?php if (count($goods1)): $j = 1; ?>
        <?php foreach ($goods1 as $item): ?>
            <div>
                <div class="list_d_item">
                    <ul>
                        <li>
                            <a target="_blank" href="<?php echo WEB_URL ?>goods/detail/<?php echo $item['g_channelid'] ?>/<?php echo $item['g_id'] ?>">
                                <h1><?php echo $item['g_title'] ?></h1></a></li>
                        <li><i>地址：</i><?php echo $item['address'] ?>&nbsp;&nbsp;<?php echo $item['phone'] ?></li>
                        <li><i>标签：</i><?php echo $item['tag'] ?></li>
                    </ul>

                </div>
                <div class="list_d_item_1">
                    ￥<?php echo $item['cprice'] ?>元
                </div>
                <div style="height: 70px;text-align: center;margin:0px; padding-top: 10px;">
                    <ul>
                        <li>
                            <a rel="nofollow" class="buy" hidefocus="true" target="_blank"
                               href="<?php echo WEB_URL ?>index/showDetial/<?php echo $item['id'] ?>">去看看</a>
                        </li>

                    </ul>
                </div>
            </div>
            <hr/>
        <?php endforeach; ?>
        <!--  <div class="page newinte_seepage"><?php echo $pageShow?></div>
                  -->
    <?php else: ?>
        <div style="margin: 5px;">暂无可展示数据！</div>
    <?php endif; ?>
</div>
<div class="item" style="width: 670px;height: auto;; margin: 0px;">
    <h1>吃</h1>
    <?php if (count($goods2)): ?>
        <?php foreach ($goods2 as $item): ?>
            <div>
                <div class="list_d_item">
                    <ul>
                        <li>
                            <a target="_blank"
                               href="<?php echo WEB_URL ?>goods/detail/<?php echo $item['g_channelid'] ?>/<?php echo $item['g_id'] ?>">
                                <h1><?php echo $item['g_title'] ?></h1></a></li>
                        <li><i>地址：</i><?php echo $item['address'] ?>&nbsp;&nbsp;<?php echo $item['phone'] ?></li>
                        <li><i>标签：</i><?php echo $item['tag'] ?></li>
                    </ul>

                </div>
                <div class="list_d_item_1">
                    ￥<?php echo $item['cprice'] ?>元
                </div>
                <div style="height: 70px;text-align: center;margin:0px; padding-top: 10px;">
                    <ul>
                        <li>
                            <a rel="nofollow" class="buy" hidefocus="true" target="_blank"
                               href="<?php echo WEB_URL ?>gourmet/gourmetDetail/<?php echo $item['id'] ?>">去看看</a>
                        </li>

                    </ul>
                </div>
            </div>
            <hr/>
        <?php endforeach; ?>
        <!--<div class="page newinte_seepage"><?php //echo $pageShow?></div>
            -->
    <?php else: ?>
        <div style="margin: 5px;">暂无可展示数据！</div>
    <?php endif; ?>
</div>
<div class="item" style="width: 670px;height: auto;; margin: 0px;">
    <h1>玩</h1>
    <?php if (count($goods3)): ?>
        <?php foreach ($goods3 as $item): ?>
            <div>
                <div class="list_d_item">
                    <ul>
                        <li>
                            <a target="_blank" href="<?php echo WEB_URL ?>goods/detail/<?php echo $item['g_channelid'] ?>/<?php echo $item['g_id'] ?>">
                                <h1><?php echo $item['g_title'] ?></h1></a></li>
                        <li><i>地址：</i><?php echo $item['address'] ?>&nbsp;&nbsp;<?php echo $item['phone'] ?></li>
                        <li><i>标签：</i><?php echo $item['tag'] ?></li>
                    </ul>

                </div>
                <div class="list_d_item_1">
                    ￥<?php echo $item['cprice'] ?>元
                </div>
                <div style="height: 70px;text-align: center;margin:0px; padding-top: 10px;">
                    <ul>
                        <li>
                            <a rel="nofollow" class="buy" hidefocus="true" target="_blank"
                               href="<?php echo WEB_URL ?>play/detail/<?php echo $item['id'] ?>">去看看</a>
                        </li>

                    </ul>
                </div>
            </div>
            <hr/>
        <?php endforeach; ?>
        <!--<div class="page newinte_seepage"><?php //echo $pageShow?></div>
            -->
    <?php else: ?>
        <div style="margin: 5px;">暂无可展示数据！</div>
    <?php endif; ?>
</div>
<div class="item" style="width: 670px;height: auto;; margin: 0px;">
    <h1>住</h1>
    <?php if (count($goods5)): ?>
        <?php foreach ($goods5 as $item): ?>
            <div>
                <div class="list_d_item">
                    <ul>
                        <li>
                            <a target="_blank" href="<?php echo WEB_URL ?>goods/detail/<?php echo $item['g_channelid'] ?>/<?php echo $item['g_id'] ?>">
                                <h1><?php echo $item['g_title'] ?></h1></a></li>
                        <li><i>地址：</i><?php echo $item['address'] ?>&nbsp;&nbsp;<?php echo $item['phone'] ?></li>
                        <li><i>标签：</i><?php echo $item['tag'] ?></li>
                    </ul>

                </div>
                <div class="list_d_item_1">
                    ￥<?php echo $item['cprice'] ?>元
                </div>
                <div style="height: 70px;text-align: center;margin:0px; padding-top: 10px;">
                    <ul>
                        <li>
                            <a rel="nofollow" class="buy" hidefocus="true" target="_blank"
                               href="<?php echo WEB_URL ?>live/detail/<?php echo $item['id'] ?>">去看看</a>
                        </li>

                    </ul>
                </div>
            </div>
            <hr/>
        <?php endforeach; ?>
        <!--<div class="page newinte_seepage"><?php //echo $pageShow?></div>
            -->
    <?php else: ?>
        <div style="margin: 5px;">暂无可展示数据！</div>
    <?php endif; ?>
</div>
<div class="item" style="width: 670px;height: auto;; margin: 0px;">
    <h1>乐</h1>
    <?php if (count($goods6)): ?>
        <?php foreach ($goods6 as $item): ?>
            <div>
                <div class="list_d_item">
                    <ul>
                        <li>
                            <a target="_blank" href="<?php echo WEB_URL ?>goods/detail/<?php echo $item['g_channelid'] ?>/<?php echo $item['g_id'] ?>">
                                <h1><?php echo $item['g_title'] ?></h1></a></li>
                        <li><i>地址：</i><?php echo $item['address'] ?>&nbsp;&nbsp;<?php echo $item['phone'] ?></li>
                        <li><i>标签：</i><?php echo $item['tag'] ?></li>
                    </ul>

                </div>
                <div class="list_d_item_1">
                    ￥<?php echo $item['cprice'] ?>元
                </div>
                <div style="height: 70px;text-align: center;margin:0px; padding-top: 10px;">
                    <ul>
                        <li>
                            <a rel="nofollow" class="buy" hidefocus="true" target="_blank"
                               href="<?php echo WEB_URL ?>happy/detail/<?php echo $item['id'] ?>">去看看</a>
                        </li>

                    </ul>
                </div>
            </div>
            <hr/>
        <?php endforeach; ?>
        <!--<div class="page newinte_seepage"><?php //echo $pageShow?></div>
            -->
    <?php else: ?>
        <div style="margin: 5px;">暂无可展示数据！</div>
    <?php endif; ?>
</div>
<div class="item" style="width: 670px;height: auto;; margin: 0px;">
    <h1>服务</h1>
    <?php if (count($goods7)): ?>

        <?php foreach ($goods7 as $item): ?>
            <div>
                <div class="list_d_item">
                    <ul>
                        <li>
                            <a target="_blank" href="<?php echo WEB_URL ?>goods/detail/<?php echo $item['g_channelid'] ?>/<?php echo $item['g_id'] ?>">
                                <h1><?php echo $item['g_title'] ?></h1></a></li>
                        <li><i>地址：</i><?php echo $item['address'] ?>&nbsp;&nbsp;<?php echo $item['phone'] ?></li>
                        <li><i>标签：</i><?php echo $item['tag'] ?></li>
                    </ul>

                </div>
                <div class="list_d_item_1">
                    ￥<?php echo $item['cprice'] ?>元
                </div>
                <div style="height: 70px;text-align: center;margin:0px; padding-top: 10px;">
                    <ul>
                        <li>
                            <a rel="nofollow" class="buy" hidefocus="true" target="_blank"
                               href="<?php echo WEB_URL ?>service/detail/<?php echo $item['id'] ?>">去看看</a>
                        </li>

                    </ul>
                </div>
            </div>
            <hr/>
        <?php endforeach; ?>
        <!--<div class="page newinte_seepage"><?php //echo $pageShow?></div>
            -->
    <?php else: ?>
        <div style="margin: 5px;">暂无可展示数据！</div>
    <?php endif; ?>
</div>
</div>
<?php endblock() ?>

<?php startblock('foot_js') ?>

<?php endblock() ?>

