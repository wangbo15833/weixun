<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
    include_once 'base.php';
?>
<?php startblock('article') 
?><br>
<table width="1000" height="51" border="0" align="center">
  <tr align="center" height="33px;" style="background:url(<?php echo base_url();?>frontend/application/manageShop/images/body.gif) repeat-x;";>
    <td width='200'>公司名称</td>
    <td width='150'>公司规模</td>
    <td width='200'>招聘职位</td>
    <td width='200'>薪资待遇</td>
    <td width='100'>招聘人数</td>
	<td width='150'>操作</td>
  </tr>
  <?php foreach($worklist as $row):
	  	if($j%2==0)
        	$bg="url(".base_url()."frontend/application/manageShop/images/body.gif) repeat-x;";
        else 
        	$bg="url(".base_url()."frontend/application/manageShop/images/body.jpg) repeat-x;";
  ?>
  <tr align="center" style="background:<?php echo $bg?>" height="33px;">
    <td><?php echo $row['name']?></td>
    <td><?php echo $row['size']?></td>
    <td><?php echo $row['title']?></td>
    <td><?php echo $row['treatment']?></td>
    <td><?php echo $row['number']?></td>
	<td>
	<a title="查看" onclick="window.open ('<?php echo WEB_URL?>work/ckwork/<?php echo $row['id'];?>', 'newwindow','height=600, width=800, top=70, left=100, toolbar=no, menubar=no, scrollbars=yes, resizable=no,location=no, status=no')"
            href="#this"><img src="<?php echo base_url()?>frontend/application/manageShop/images/icon_view.gif"/></a>
	<a title="编辑" href="<?php echo WEB_URL ?>work/editwork/<?php echo $row['id']?>"><img src="<?php echo base_url()?>frontend/application/manageShop/images/edit.gif" /></a>
	<a title="删除" href="<?php echo WEB_URL ?>work/delwork/<?php echo $row['id']?>">
    <img onClick="return confirm('确定删除吗？\n\n删除后此操作无法恢复!')" src="<?php echo base_url()?>frontend/application/manageShop/images/del.jpg" /></a>
	</td>
  </tr>
  <?php 
  $j++;
  endforeach;?>
</table>
<br>
<div class="page newinte_seepage"><?php echo $pageShow?></div>
<?php endblock() ?>