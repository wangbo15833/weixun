<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<div>
   <h1>招聘信息</h1><hr/>
	<table align="center"> 
		<tr>
		  <td height="24">公司名称:<?php echo $ck['name']?></td>
		</tr>
		<tr>
			<td>公司规模:<?php echo $ck['size']?>人</td>
		</tr>
		<tr>
			<td>公司性质:<?php if($ck['property']==1){
				echo '国企';
			}elseif($ck['property']==2){
				echo '私企';
			}elseif($ck['property']==3){
				echo '股份制';                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                       
			}else{
				echo '未填写';
			}
			?></td>
		</tr>
		<tr>
			<td>公司行业:<?php echo $ck['property'];?></td>
		</tr>
		<tr>
			<td>职位类型:<?php echo $ck['position1'];?></td>
		</tr>
		<tr>
			<td>职位标题:<?php echo $ck['title'];?></td>
		</tr>
		<tr>
			<td>职位描述:<?php  $a=htmlspecialchars_decode($ck['description']); echo $a;?></td>
		</tr>
		<tr>
			<td>薪资待遇:<?php echo $ck['treatment'];?></td>
		</tr>
		<tr>
			<td>学历要求:<?php echo $ck['education'];?></td>
		</tr>
		<tr>
			<td>工作年限:<?php echo $ck['life'];?></td>
		</tr>
		<tr>
			<td>招聘人数:<?php echo $ck['number'];?></td>
		</tr>
		<tr>
			<td>联系方式:<?php echo $ck['contact'];?></td>
		</tr>
		<tr>
			<td>所在地区：<?php echo $ck['area_name'].$ck['address'];?></td>
		</tr>
		<tr>
			<td>具体街道地址:<?php echo $ck['jd'];?></td>
		</tr>
	</table>
</div>