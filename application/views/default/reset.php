<?php include_once 'base.php';?>
<?php startblock('header_css')?>

<?php endblock() ?>

<?php startblock('content') ?>
<div id="content" style="width: 100%">
    <div class="mainbox" id="yui_3_8_0_1_1369296685340_118">
        <h2>重设密码</h2>
        <form action="<?php echo WEB_URL?>login/reset" id="reset-form" method="post">
            <div class="field-group" id="yui_3_8_0_2_1369296685340_17">
                <label for="reset-password" class="f-label">新密码</label>
                <input type="password" maxlength="32" id="reset-password" value="" name="password" class="f-text">
                <span class="inline-tip" style="display: none;"></span></div>
            <div class="field-group" id="yui_3_8_0_2_1369296685340_19">
                <label for="reset-password2" class="f-label">重复密码</label>
                <input type="password" maxlength="32" id="reset-password2" value="" name="password2" class="f-text">
            </div>
            <div class="field-group" id="yui_3_8_0_1_1369296685340_119">
                <input type="hidden" value="j5XECk5NWue3_7CevQF8fdwN9ZcKoVxW" name="code">
                <input type="submit" value="重设密码" class="form-button">
            </div>
        </form>
    </div>
</div>
<?php endblock() ?>

<?php startblock('foot_js')?>

<?php endblock() ?>