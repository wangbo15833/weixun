<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Administrator
 * Date: 13-6-14
 * Time: 下午3:07
 * To change this template use File | Settings | File Templates.
 */
?>
<!DOCTYPE html>
<html lang="zh">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <script src="<?php echo base_url()?>frontend/application/meituan/ele.me_files/ga.js" async="" type="text/javascript"></script><script type="text/javascript">
      if(!window.localStorage)
          window.location.href='<?php echo WEB_URL .'index'?>';
    </script>
    <script type="text/javascript" src="<?php echo base_url() ?>frontend/Public/js/base.js"></script>
    <title>发现网-您身边的朋友</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="description" content="饿了么是中国最专业的网上订餐平台， 提供各类中式、日式、韩式、西式等美食的优质外卖服务">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
<link href="<?php echo base_url()?>frontend/application/meituan/ele.me_files/forward_homepage_201306130146.css" type="text/css" rel="stylesheet">
<!--[if (gte IE 7)&( lte IE 9)]>
<link href="http://static10.elemecdn.com/css/public/forward_iehack_201306130146.css" type="text/css" rel="stylesheet" />
<![endif]-->

    <link rel="apple-touch-icon-precomposed" href="http://static10.elemecdn.com/apple-touch-icon.png?v=2">
    <link rel="icon" href="<?php echo base_url();?>favicon.ico?v=2" type="image/x-icon">
    <link rel="shortcut icon" href="<?php echo base_url();?>favicon.ico?v=2" type="image/x-icon">
    <!--[if lt IE 9]>
  <script src="http://static10.elemecdn.com/js/forward/lib/html5shiv.js"></script>
<![endif]-->

<script type="text/javascript" src="<?php echo base_url()?>frontend/application/meituan/ele.me_files/head_201306130146.js"></script>
  </head>

<!--[if IE 8]><body id="homepage" class="lt-ie9 lt-ie10"><![endif]-->
<!--[if IE 9]><body id="homepage" class="lt-ie10"><![endif]-->
<!--[if gt IE 9]><!--> <body id="homepage"> <!--<![endif]-->

    <div class="content" id="step1">
  <h1 class="logo"></h1>

  <div class="main">

    <menu class="city_fr">
      <ul class="city-wrapper city_wrapper">
                <li class="city city_obj" id="city_1" data-id="1">
          <a class="hover">
            <!--[if lt IE 9]><i class="border"></i><![endif]-->
            <b></b>
            <strong class="city_name">购</strong>
            <!--[if lte IE 9]><span class="text-shadow">购</span><![endif]-->
          </a>
        </li>
                <li class="city city_obj" id="city_3" data-id="2">
          <a class="hover">
            <!--[if lt IE 9]><i class="border"></i><![endif]-->
            <b></b>
            <strong class="city_name">吃</strong>
            <!--[if lte IE 9]><span class="text-shadow">吃</span><![endif]-->
          </a>
        </li>
                <li class="city city_obj" id="city_4" data-id="3">
          <a class="hover">
            <!--[if lt IE 9]><i class="border"></i><![endif]-->
            <b></b>
            <strong class="city_name">玩</strong>
            <!--[if lte IE 9]><span class="text-shadow">玩</span><![endif]-->
          </a>
        </li>
                <li class="city city_obj" id="city_2" data-id="4">
          <a class="hover">
            <!--[if lt IE 9]><i class="border"></i><![endif]-->
            <b></b>
            <strong class="city_name">行</strong>
            <!--[if lte IE 9]><span class="text-shadow">行</span><![endif]-->
          </a>
        </li>
                <li class="city city_obj" id="city_5" data-id="5">
          <a class="hover">
            <!--[if lt IE 9]><i class="border"></i><![endif]-->
            <b></b>
            <strong class="city_name">住</strong>
            <!--[if lte IE 9]><span class="text-shadow">住</span><![endif]-->
          </a>
        </li>
                <li class="city city_obj" id="city_8" data-id="6">
          <a class="hover">
            <!--[if lt IE 9]><i class="border"></i><![endif]-->
            <b></b>
            <strong class="city_name">乐</strong>
            <!--[if lte IE 9]><span class="text-shadow">乐</span><![endif]-->
          </a>
        </li>
                <li class="city city_obj" id="city_9" data-id="7">
          <a class="hover">
            <!--[if lt IE 9]><i class="border"></i><![endif]-->
            <b></b>
            <strong class="city_name">生活服务</strong>
            <!--[if lte IE 9]><span class="text-shadow">生活服务</span><![endif]-->
          </a>
        </li>
          <!--
                <li class="city city_obj" id="city_7" data-id="8">
          <a class="getDistrict">
            <i class="border"></i>
            <b></b>
            <strong class="city_name">银行</strong>
            <span class="text-shadow">银行</span>
          </a>
        </li>
          -->
              </ul>

      <div class="select-wrapper select_fr">
        <nav>
          <a class="icon-back to_city"></a>
          <span id="select_city" class="select"></span>
          <span>
            <i class="icon-dot"></i>
            <a id="select_district" class="select current" data-name="请选择">请选择</a>
          </span>
          <span class="hide">
            <i class="icon-dot"></i>
            <a id="select_zone" class="select" data-name="请选择商圈">请选择商圈</a>
          </span>
        </nav>
        <section class="selections"></section>
      </div>

    </menu>

    <div class="entry-wrapper entry_fr">
      <nav>
        <a class="icon-back to_zone" id="backto_step1"></a>
        <span id="home_nav"></span>
      </nav>
      <section class="econ_fr">
        <aside class="azgroup"></aside>
        <ul id="entry_con" class="econ"></ul>
      </section>
    </div>
    <!--移动应用
    <a class="fade_item app-promotion" href="http://ele.me/mobile" target="_blank">iPhoen客户端免费了！</a>
      -->
    <footer class="footer-homepage">
           <!-- <a class="btn-addr"><i></i>我的地址</a>
           -->
      <a class="btn-login" href="<?php echo WEB_URL?>login"><i></i>登录</a>

          </footer>

  </div>
</div>

<aside class="homepage-aside">
  <a href="#" target="_blank">友情链接</a> <span>|</span> <a href="#" target="_blank">网站地图</a>
</aside>

<div id="em_mapFrame" class="homepage-map">
  <div class="map-wrapper">

    <header class="map-header">
      <a id="em_close" class="icon-back" title="返回"><i>返回</i></a>
      <div id="em_searchWrapper" class="search-wrapper">
        <span id="em_searchCity" class="search-city"></span>
        <input autocomplete="off" id="em_searchInput" class="search-input ui-autocomplete-input" placeholder="输入学校，地址，写字楼确定当前位置" type="text">
          <span class="ui-helper-hidden-accessible" aria-live="polite" role="status"></span>
        <a id="em_searchButton" class="icon-search">搜索</a>
      </div>
      <div id="em_userAddr" class="eleme_dropdown my-addr-wrapper">
        <a id="em_userAddrBtn" class="e_toggle icon-addr" title="我的地址"><i>我的地址</i></a>
        <div class="e_dropdown my-addr-dropdown">
          <h4>我的地址</h4>
          <ul id="em_userAddrList" class="my-addr-list">
              <li class="patch-height" ><a class="del">删除</a><a class="place" href="http://ele.me/place/-615746940961261203" title="登新公寓" target="_blank">登新公寓</a></li>
          </ul>
          <p id="em_userAddrNone" class="no-addr hide"><i class="icon-alert"></i>还没有历史地址</p>
        </div>
      </div>
    </header>

    <div class="fix-height">
      <div id="em_mapMask" class="map-mask hide">
        <i class="icon-map-arrow"></i>
        <p>输入所在地址</p><p>
      </p></div>
      <aside id="em_resultWrapper" class="result-wrapper">
        <figure id="em_resultLoading" class="loading">
          <img src="<?php echo base_url()?>frontend/application/meituan/ele.me_files/eleme-loading.gif" alt="loading">
          <figcaption>搜索中……</figcaption>
        </figure>
        <div id="em_resultBlock" class="hide">
          <p class="result-total">共<span id="em_resultTotal">0</span>个地址</p>

          <div id="em_resultMain" class="fix-height">
            <ul id="em_resultList" class="result-list"></ul>
            <p id="em_resultPaging" class="pagination"></p>
          </div>

          <div id="em_resultNone" class="no-result hide">
            <h4>建议：</h4>
            <p>1. 请确保所有字词拼写正确。</p>
            <p>2. 尝试不同的关键字。</p>
          </div>
        </div>
      </aside>
      <div id="em_mapWrapper" class="fix-width">
        <div id="em_mapContainer" class="map-container"></div>
        <div id="em_dropWrapper" class="drop-wrapper"><i id="em_dropPin" class="icon-pin ui-draggable"></i></div>
      </div>
    </div>

  </div>
</div>
  <script src="<?php echo base_url()?>frontend/application/meituan/ele.me_files/homepage_201306130146.js"></script>

<!--
<script type="text/javascript">
    (function() {
        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
        ga.src = 'http://static10.elemecdn.com/js/forward/lib/ga.js?v=20130110';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
    })();
</script>
-->
<ul style="z-index: 11; display: none;" tabindex="0" id="ui-id-1" class="ui-autocomplete ui-menu ui-widget ui-widget-content ui-corner-all"></ul></body></html>