/**
 * Created with JetBrains PhpStorm.
 * User: Lynx
 * Date: 14-2-11
 * Time: 下午4:32
 * To change this template use File | Settings | File Templates.
 */


$(document).ready(function(){

    $('#address').change(function() {
        var addr = $('#address').val();
        var city = $('#city option:selected').text();
        var s_city = "秦皇岛";

        var map = new BMap.Map("container");
        var myGeo = new BMap.Geocoder();
        // 将地址解析结果显示在地图上，并调整地图视野
        myGeo.getPoint(addr, function(point){
            if (point) {
                map.centerAndZoom(point, 16);
                map.addOverlay(new BMap.Marker(point));

                //添加地图覆盖物
                var opts = {
                    width : 70,     // 信息窗口宽度
                    height: 50,     // 信息窗口高度
                    title : addr  // 信息窗口标题
                }
                var infoWindow = new BMap.InfoWindow("", opts);  // 创建信息窗口对象
                map.openInfoWindow(infoWindow, point);      // 打开信息窗口
            }
        }, s_city);
        map.addControl(new BMap.NavigationControl());//标准地图控件
        map.addControl(new BMap.ScaleControl()); //比例尺控件
        map.addControl(new BMap.OverviewMapControl());
        map.addEventListener("load", function(){
            //alert("您点击了地图。");
            var center = map.getCenter();
            $('#map_x').val(center.lng); $('#map_y').val(center.lat);
        });
        map.addEventListener("dragend", function(){
            var center = map.getCenter();
            $('#map_x').val(center.lng); $('#map_y').val(center.lat);
            //alert("地图中心点变更为：" + center.lng + ", " + center.lat);
        });

    });

});


var map = new BMap.Map("container");          // 创建地图实例
map.centerAndZoom("秦皇岛", 15);                 // 初始化地图，设置中心点坐标和地图级别
map.addControl(new BMap.NavigationControl());//标准地图控件
map.addControl(new BMap.ScaleControl()); //比例尺控件
map.addControl(new BMap.OverviewMapControl());