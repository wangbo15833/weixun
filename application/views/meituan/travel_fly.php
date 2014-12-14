<?php
header("Content-type:text/html;charset=utf8");
include_once 'base.php';
?>
<?php startblock('header_css') ?>
    <link href="<?php echo base_url();?>frontend/application/meituan/css/travel.css" rel="stylesheet" type="text/css" />
<?php endblock() ?>
<?php startblock('content') ?>
    <div id="" style=" width: auto; height: 700px; padding: 0px;">
        <form method="POST" action="http://chepiao.sinaapp.com/api.php?act=plane" target="_blank">

            <table cellspacing="0" cellpadding="4" bordercolor="#dcdcdc" style="border-collapse: collapse;" rules="none" frame="box">
                <tbody>
                <tr>
                    <td style="color: #000000; font-weight: normal;" class="frmText">startCity:</td>
                    <td><input type="text" id="startCity" name="departureAirport" size="50" class="frmInput"></td>
                </tr>

                <tr>
                    <td style="color: #000000; font-weight: normal;" class="frmText">lastCity:</td>
                    <td><input type="text" id="lastCity" name="arrivalAirport" size="50" class="frmInput"></td>
                </tr>

                <tr>
                    <td style="color: #000000; font-weight: normal;" class="frmText">theDate:</td>
                    <td><input type="text" id="theDate" name="date" size="50" class="frmInput">
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td align="right"> <input type="button" id="dy" class="button" value=""></td>
                </tr>
                </tbody></table>


        </form>
    </div>
<?php endblock() ?>

<?php startblock('foot_js') ?>
<script>
    $(document).ready(function(){
        $('#dy').click(function(){
            var startCiy = $('#startCity').val();
            var lastCity = $('#lastCity').val();
            var theDate=$('#theDate').val();
            $.ajax({
                url:base_url + 'lcskb/fly',
                type:'post',
                dataType:'json',
                data:{departureAirport:startCiy,arrivalAirport:lastCity,date:theDate},
                success:function(data){
                    data = data.data;
                    var m = 0; c = data.count;
                    for(;m<c;m++){
                        console.log(data.myitems[m]);
                    }
                }
            })
        });
    })
</script>
<?php endblock() ?>