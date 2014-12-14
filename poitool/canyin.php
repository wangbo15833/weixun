<?php
//连接数据库
$link=@mysql_connect("localhost","root","root") or die ("连接数据库失败");  
mysql_select_db("poitool",$link) or die ("没有该数据库"); 


$ch = curl_init();
$str ="http://api.map.baidu.com/place/v2/search?ak=cl5mNGp7Dfe8dxoeOA1doxFM&output=json&query=餐饮&page_size=20&page_num=1&scope=1&region=秦皇岛";
curl_setopt($ch, CURLOPT_URL, $str);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );
$output = curl_exec($ch);
$obj = json_decode($output);
$total_num = $obj->total;

//echo $total_num;
	
$total_page = ceil($total_num/20);

if($total_page>37) $total_page=37;

for($page_num=0;$page_num<$total_page;$page_num++){

	$str ="http://api.map.baidu.com/place/v2/search?ak=cl5mNGp7Dfe8dxoeOA1doxFM&output=json&query=餐饮&page_size=20&page_num=".$page_num."&scope=1&region=秦皇岛";

	curl_setopt($ch, CURLOPT_URL, $str);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );
	$output = curl_exec($ch);
	$obj = json_decode($output);

	$obj1 = $obj->results;

	foreach($obj1 as $item){
		echo $item->name;
		echo $item->location->lat;
		echo $item->location->lng;
		echo $item->address;
		if(!isset($item->telephone)){
			$item->telephone="";
		}
		echo $item->telephone;

		$sql="insert into shops(title,map_x,map_y,address,phone,channel_id,city_id) values('".$item->name."','".$item->location->lng."','".$item->location->lat."','".$item->address."','".$item->telephone."','2','1502')";
		$query=mysql_query($sql);
		echo "<br/>";
	}


}


?>