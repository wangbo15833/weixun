<?php
$this->load->library('session');
$user = $this->session->userdata('userinfo');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <?php include_once 'ti.php';?>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="description" content="发现网秦皇岛站 - 我爱发现，我爱生活！" />
    <title>【发现网】我爱发现_爱生活_秦皇岛发现网__发现网秦皇岛站</title>

    <link rel="icon" href="<?php echo base_url();?>favicon.ico?v=3" type="image/x-icon">
    <link rel="shortcut icon" href="<?php echo base_url();?>favicon.ico?v=3" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('/frontend/application/default/css/style.css') ?>" />
    <script type="text/javascript" src="<?php echo base_url('/frontend/Public/js/jquery.1.9.1.js') ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('/frontend/Public/js/base.js') ?>"></script>


    <?php startblock('header_css')?>
    <?php endblock() ?>
</head>
<body class="index">
<?php include_once('header.php'); ?>
<?php startblock('content') ?>
<?php endblock() ?>
<?php include_once 'footer.php';?>

<script type="text/javascript" src="<?php echo base_url() ?>frontend/Public/jquery.fancybox/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>frontend/Public/jquery.fancybox/fancybox/jquery.easing-1.3.pack.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>frontend/Public/jquery.fancybox/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>

<!--对话框弹出-->
<script type="text/javascript" src="<?php echo base_url() ?>frontend/application/default/js/showDialog.js"></script>
<script src="<?php echo base_url() ?>frontend/Public/artDialog/artDialog.js?skin=default"></script>
<?php startblock('foot_js')?>
<?php endblock() ?>
</body>
</html>

