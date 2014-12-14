<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Administrator
 * Date: 13-6-24
 * Time: 下午3:54
 * To change this template use File | Settings | File Templates.
 */
?>
<html>
<head></head>
<script type="text/javascript" src="<?php echo base_url('/frontend/Public/js/jquery.1.9.1.js') ?>"></script>
<body>
<script type="text/javascript" src="http://api.map.baidu.com/api?v=1.5&ak=D95ab8521dabc49243d995d83217505d"></script>
<!----><form id="form1" name="form1" method="post" action="<?php echo WEB_URL?>welcome/c_maps">
    <input id="address" name="address" value="<?php echo $rows['addrs']?>" type="text"/>
    <input id="city" name="city" value="" type="text"/>
    <input id="id" name="id" value="<?php echo $rows['id']?>" type="text"/>
    <input id="x" name="x" value="" type="text"/>
    <input id="y" name="y" value="" type="text"/>
    <input type="submit" name="" value="提交">
</form>

<div id="container" style="height: 30%; width:100%"></div>
</body>
<script type="text/javascript" src="<?php echo base_url() ?>frontend/Public/js/base.js"></script>
<script>
    $(document).ready(function(){
        var map = new BMap.Map("container");          // 创建地图实例
        var point = new BMap.Point(116.404, 39.915);  // 创建点坐标
        map.centerAndZoom(point, 15);                 // 初始化地图，设置中心点坐标和地图级别
        /*// 创建地址解析器实例*/
        var addr = "秦皇岛市"+$('#address').val();
        var city = '秦皇岛市';//$('#city').val();
        // console.log(addr);console.log(city);
        var myGeo = new BMap.Geocoder();
        // 将地址解析结果显示在地图上，并调整地图视野
        myGeo.getPoint(addr, function(point){
            if (point) {
                map.centerAndZoom(point, 16);
                map.addOverlay(new BMap.Marker(point));
            }
        }, city);
        map.addEventListener("tilesloaded", function(){
            //alert("您点击了地图。");
            var center = map.getCenter();
            //console.log(center.lng);
            $('#x').val(center.lng); $('#y').val(center.lat);
        });
        //document.all.form1.submit();
        //setInterval("document.all.form1.submit()",3000)
    });
    /*
    $(document).ready(function(){
        // 百度地图API功能
        var map = new BMap.Map("container");            // 创建Map实例
        map.centerAndZoom(new BMap.Point(116.4035,39.915), 14);  //初始化时，即可设置中心点和地图缩放级别。
        map.addEventListener("tilesloaded", function(){
            var bs = map.getBounds();   //获取可视区域
            var bssw = bs.getSouthWest();   //可视区域左下角
            var bsne = bs.getNorthEast();   //可视区域右上角
            //alert("当前地图可视范围是：" + bssw.lng + "," + bssw.lat + "到" + bsne.lng + "," + bsne.lat);
            load_info(bssw.lng, bssw.lat, bsne.lng, bsne.lat);
        });
        map.addEventListener("dragend", function(){
            var bs = map.getBounds();   //获取可视区域
            var bssw = bs.getSouthWest();   //可视区域左下角
            var bsne = bs.getNorthEast();   //可视区域右上角
            alert("当前地图可视范围是：" + bssw.lng + "," + bssw.lat + "到" + bsne.lng + "," + bsne.lat);
            map.removeEventListener("dragend",function(){});//移除事件
        });

    });
    */
    function load_info(swlng, swlat, nelng, nelat){
        $.ajax({
            url: base_url +'welcome/getAround',
            type:'post',
            dataType:'json',
            data:{swlng:swlng, swlat: swlat, nelng:nelng, nelat:nelat},
            success:function(data){
                console.log(data);
               /* if(data.status == 1){
                    data = data.data;
                    var count=data.length;
                    var _str = '';
                    for(j=0;j< count; j++){
                        _str +='<option value="'+data[j].area_id+'">'+data[j].area_name+'</option>';
                    }
                    $('#province').append(_str);
                }
                */
            }
        })
    }
    $('#address').change(function() {
        var addr = $('#address').val();
        var s_city = '秦皇岛市';
        var map = new BMap.Map("container");
        var myGeo = new BMap.Geocoder();
        // 将地址解析结果显示在地图上，并调整地图视野
        myGeo.getPoint(addr, function(point){
            if (point) {
                map.centerAndZoom(point, 16);
                map.addOverlay(new BMap.Marker(point));
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
        //添加地图覆盖物
        var opts = {
            width : 70,     // 信息窗口宽度
            height: 50,     // 信息窗口高度
            title : addr  // 信息窗口标题
        }
        var infoWindow = new BMap.InfoWindow("", opts);  // 创建信息窗口对象
        map.openInfoWindow(infoWindow, map.getCenter());      // 打开信息窗口
    })
</script>
</html>