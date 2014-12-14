/**
 * @author Administrator
 */
$('.shopTable tr:odd').addClass('odd');
$('.shopTable tr:even').filter(':gt(0)').addClass('even');
$('.shopTable td:contains("Because of you")').addClass('highlight');

$(document).ready(function(){

  	/*弹窗展示数据*/
  	$('.showMessage').fancybox({
            'width'             : '50%',
            'height'            : '100%',
            'autoScale'         : false,
            'transitionIn'      : 'none',
            'transitionOut'     : 'none',
            'type'              : 'iframe'
    });
        
    if($('#state').val() == 1){
                art.dialog({
                    time: 2,
                    icon:'face-smile',
                    content: '亲，操作成功！'
                });
     }else if($('#state').val() == 3){
         art.dialog({
                    time: 2,
                    icon:'face-smile',
                    content: '亲，操作失败！'
                });
     }
});
