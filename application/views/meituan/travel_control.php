<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
<title>GeolocationControl</title>
<style type="text/css">/*<![CDATA[*/
body{margin:0;padding:0;font-family:Times New Roman, serif}
p{margin:0;padding:0}
html,body{
    width:100%;
    height:100%;
}
#map_container{width:100%;border: 1px solid #999;height:230px;}

@media print{
  #notes{display:none}
  #map_container{margin:0}
}
/*]]>*/</style>
<script type="text/javascript" src="http://api.map.baidu.com/api?v=1.4"></script>
<script type="text/javascript" src="http://api.map.baidu.com/library/SearchControl/1.4/src/SearchControl_min.js"></script>
<link rel="stylesheet" href="http://api.map.baidu.com/library/SearchControl/1.4/src/SearchControl_min.css" />
</head>

<body>
  <div id="searchBox"></div>
  <div id="map_container"></div>
  <div id="test_container">
      选择检索类型:
      <select id="selectType" name="">
          <option value="1">LOCAL_SEARCH</option>
          <option value="2">TRANSIT_ROUTE</option>
          <option value="3">DRIVING_ROUTE</option>
      </select>
  </div>
</body>
<script type="text/javascript">/*<![CDATA[*/


// 创建地图对象并初始化
var mp = new BMap.Map("map_container");
var point = new BMap.Point(119.562599,39.950826);//(116.404, 39.915);
mp.centerAndZoom(point, 14);
mp.enableInertialDragging();

var type = "";
type = TRANSIT_ROUTE; //公交检索
type = DRIVING_ROUTE; //驾车检索
type = LOCAL_SEARCH ; //本地检索

//创建检索控件
var searchControl = new BMapLib.SearchControl({
    container : "searchBox" //存放控件的容器
    , map     : mp  //关联地图对象
    , type    : type  //检索类型
});

document.getElementById("selectType").onchange = function () {
    searchControl.setType(this.value);
};
/*]]>*/</script>
</html>
