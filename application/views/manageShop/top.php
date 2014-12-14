<?php
    $this->load->library('session');
    $sdata = $this->session->userdata('userinfo');
    if(isset($sdata[0]['legalname']))   $data = $sdata[0];
    //var_dump($sdata);
    
?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>微讯商铺会员管理后台</title>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>frontend/application/manageShop/css/shops.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>frontend/application/manageShop/css/uploadify.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>frontend/application/manageShop/css/commodity.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>frontend/application/manageShop/css/manager.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>frontend/Public/jquery.fancybox/fancybox/jquery.fancybox-1.3.4.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>frontend/Public/kindeditor/themes/default/default.css" />
    <link rel="icon" href="<?php echo base_url();?>w_favicon.ico?v=2" type="image/x-icon">
    <link rel="shortcut icon" href="<?php echo base_url();?>w_favicon.ico?v=2" type="image/x-icon">
</head>
<body>
    <div>
          <table width="100%" border="0" cellpadding="0" cellspacing="0" background="<?php echo base_url() ?>frontend/application/manageShop/images/topbg.gif" height="78px">
            <tr>
              <td height="60" width="6%"> <FONT style="FONT-WEIGHT: bolder; font-family:黑体;FONT-SIZE: 20px; FILTER: blur(add=1, direction=45,strength=1);  POSITION: relative" color=#003300><img src="<?php echo base_url() ?>frontend/application/manageShop/images/logoa.gif" width="59" height="57">
                </FONT></td>
              <td class=ttdd width='31%' height="60"><font style="FONT-WEIGHT: bolder; font-family:黑体;FONT-SIZE: 20px; FILTER: blur(add=1, direction=45,strength=1); WIDTH: 450px; POSITION: relative"> 
                微讯商铺会员管理后台</font></td>
              <td align="right" valign="bottom" width="63%"> 
                <table width="100%" class=ttdd border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td align="right" height="26" style="padding-right:10px;line-height:26px; font-size:12px;">
                      会员名称：<span class="use rname"><?php if( USERNAME) echo USERNAME?>先生</span>&nbsp;<SPAN id='clock'></SPAN> <br>
                      [<a href="<?php echo base_url()?>wxadmin.php/login/modify_pwd"><span class=ttdd>修改密码</span></a>]
                      [<a href="<?php echo base_url()?>index.php/login/out_login" target="_top"><span class=ttdd>注销退出</span></a>]&nbsp; </td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>
    </div>