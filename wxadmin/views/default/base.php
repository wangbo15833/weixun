<?php 
      include_once "top.php";
      include_once 'ti.php';
?>
<div id="main">
<input type="hidden" id="hid_clickValue" name="hid_clickValue" value="<?php echo LIFT_CLICK;?>"/>
<div id="main_left">
    <table id="menu_left" cellpadding=0 cellspacing=0 width=100% align=center>
                <tr>
                  <td height="25" class="menu_title"   id="menuTitle1 "> 
                    <span >系统管理</span>
                  </td>
                </tr>
                <tr>
                    <td style="" id='submenu1'>
                        <div class=sec_menu style="">
                            <table id="table_str" cellpadding=0 cellspacing=0 align=center width=70%>

                            </table>
                        </div>
                    </td>
                </tr>
    </table>
</div>
<div id="main_right" style=" ">
    <?php startblock('article') ?>
    
    <?php endblock() ?>
</div>
<div class="clear"></div>
<?php //include_once "footer.php" ?>
</div>

    <script src="<?php echo base_url() ?>frontend/Public/js/base.js"></script>
    <script type="text/javascript" src="<?php echo base_url('/frontend/Public/js/jquery.1.9.1.js') ?>"></script>
    <script type="text/javascript" src="<?php echo base_url() ?>frontend/Public/js/jquery.uploadify-3.1.js"></script>

<script type="text/javascript" src="<?php echo base_url() ?>frontend/Public/jquery.fancybox/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>frontend/Public/jquery.fancybox/fancybox/jquery.easing-1.3.pack.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>frontend/Public/jquery.fancybox/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>

    <script src="<?php echo base_url() ?>frontend/Public/artDialog/artDialog.js?skin=default"></script>
    <script type="text/javascript" src="<?php echo base_url() ?>frontend/Public/jquery-validation/jquery.validate.js"></script>

    <link rel="stylesheet" href="<?php echo base_url() ?>frontend/Public/jquery-ui/themes/base/jquery.ui.all.css">
    <script src="<?php echo base_url() ?>frontend/Public/jquery-ui/ui/jquery.ui.core.js"></script>
    <script src="<?php echo base_url() ?>frontend/Public/jquery-ui/ui/jquery.ui.widget.js"></script>
    <script src="<?php echo base_url() ?>frontend/Public/jquery-ui/ui/jquery.ui.position.js"></script>
    <script src="<?php echo base_url() ?>frontend/Public/jquery-ui/ui/jquery.ui.menu.js"></script>
    <script src="<?php echo base_url() ?>frontend/Public/jquery-ui/ui/jquery.ui.autocomplete.js"></script>
    
    <script type="text/javascript" src="<?php echo base_url() ?>frontend/wxadmin/default/js/upload.js"></script>
    <script type="text/javascript" src="<?php echo base_url() ?>frontend/wxadmin/default/js/ajaxtest.js"></script>

    <?php startblock('foot_js')?>
    <?php endblock() ?>
</body>
</html>