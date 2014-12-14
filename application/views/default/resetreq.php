<?php include_once 'base.php';?>
<?php startblock('header_css')?>

<?php endblock() ?>

<?php startblock('content') ?>
    <div id="sysmsg-success" class="sysmsgw">
        <div class="sysmsg" style="width: 98%">
            <p>操作成功</p>
            <span class="close">关闭</span>
        </div>
    </div>
<div id="content" style="width: 100%">
    <div class="mainbox" id="yui_3_8_0_1_1369296658098_121">
        <h2>找回密码</h2>
        <div class="notice" id="yui_3_8_0_1_1369296658098_120">
            <p id="yui_3_8_0_1_1369296658098_119">操作成功！请到 <strong><?php echo $email?></strong> 查阅来自美团的邮件，点击邮件中的链接重设您的密码。</p>

            <a target="_blank" href="http://mail.qq.com/" class="link-button">去邮箱收信</a>        </div>
    </div>
</div>
<?php endblock() ?>

<?php startblock('foot_js')?>

<?php endblock() ?>