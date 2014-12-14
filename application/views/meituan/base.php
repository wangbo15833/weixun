<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>【发现网】我爱发现_爱生活_秦皇岛发现网__发现网秦皇岛站</title>
    <?php include_once 'ti.php';?>

    <link rel="icon" href="<?php echo base_url();?>favicon.ico?v=3" type="image/x-icon">
    <link rel="shortcut icon" href="<?php echo base_url();?>favicon.ico?v=3" type="image/x-icon">

    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>frontend/application/meituan/css/base.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>frontend/application/meituan/css/index.css" />

    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>frontend/application/meituan/css/uploadify.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>frontend/application/meituan/css/base.vfa7462d9.css" />

    <?php startblock('header_css')?>
    <?php endblock() ?>

    <link rel="alternate" href="#" title="订阅更新" type="application/rss+xml" />
    <!--[if IE 6]>
    <script src="<?php echo base_url()?>frontend/application/meituan/js/common/DD_belatedPNG_0.0.8a-min.vb4e86b02.js"></script>
    <![endif]-->
    <!--[if lt IE 9]>
    <script src="<?php echo base_url()?>frontend/application/meituan/js/common/html5shiv.min-min.v01cbd8f0.js"></script>
    <![endif]-->

    <meta name="description" content="发现网秦皇岛站 - 我爱发现，我爱生活！" />

</head>
<body id="index">
    <div id="doc">
        <?php include_once('header.php'); ?>

        <div class="content_main">
            <?php startblock('content') ?>
            <?php endblock() ?>
        </div>
    </div>

    <?php include_once 'footer.php';?>

    <script type="text/javascript" src="<?php echo base_url() ?>frontend/Public/js/common/base.js"></script>
    <script type="text/javascript" src="<?php echo base_url('/frontend/Public/js/jquery.1.9.1.js') ?>"></script>
    <script type="text/javascript" src="<?php echo base_url() ?>frontend/Public/js/jquery.uploadify-3.1.js"></script>
    <script type="text/javascript" src="<?php echo base_url() ?>frontend/Public/jquery-validation/jquery.validate.js"></script>
    <script type="text/javascript" src="<?php echo base_url()?>frontend/application/meituan/js/common/common.js"></script>
    <script src="<?php echo base_url() ?>frontend/Public/artDialog/artDialog.js?skin=default"></script>

    <link rel="stylesheet" href="<?php echo base_url() ?>frontend/Public/jquery-ui/themes/base/jquery.ui.all.css">
    <script src="<?php echo base_url() ?>frontend/Public/jquery-ui/ui/jquery.ui.core.js"></script>
    <script src="<?php echo base_url() ?>frontend/Public/jquery-ui/ui/jquery.ui.widget.js"></script>
    <script src="<?php echo base_url() ?>frontend/Public/jquery-ui/ui/jquery.ui.position.js"></script>
    <script src="<?php echo base_url() ?>frontend/Public/jquery-ui/ui/jquery.ui.menu.js"></script>
    <script src="<?php echo base_url() ?>frontend/Public/jquery-ui/ui/jquery.ui.autocomplete.js"></script>

    <script>
        $(document).ready(function(){
            var auserUrl = web_url +'index.php/index/get_search';
            $('#header_search').autocomplete({
               // appendTo:'#',
                source:function(request, response){
                    $.ajax({
                        url:auserUrl,
                        type:'POST',
                        dateType:'json',
                        data:{'c_title':request.term},
                        success:function(data, textStatus,jqSHR){
                            data = eval("("+data+")");
                            response($.map(data, function(item, index){
                                    return {
                                        label: item.title,
                                        value: item.title,
                                        id:item.id
                                    }
                                }
                            ));
                        },
                        error:function(){
                            return "暂无可匹配信息";
                        }
                    })
                },
                select: function( event, ui ) {
                    // $('#hid_search_key').val(ui.item.id);
                }
            });
        })
    </script>
    <?php startblock('foot_js')?>
    <?php endblock() ?>
</body>
</html>

