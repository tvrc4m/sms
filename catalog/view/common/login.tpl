<?php echo $header; ?>
<div class="container-fluid">

    <div class="row-fluid">

        <div class="span12">
            <div class="login">
                <!--<img src="view/responsive/img/user.png" alt="user" class="glossy">-->
                <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form" class="inline-block fwf">
                    <div class="login-content">
                        <h4>客户关系综合管理系统</h4>
                        <!--<?php if ($success) { ?>
                        <div class="success"><?php echo $success; ?></div>
                        <?php } ?>-->

                        <?php if ($error_warning) { ?>
                        <div class="warning"><?php echo $error_warning; ?></div>
                        <?php } ?>
                        <div class="username"><i class="name"></i><input type="text" name="name" placeholder="用户名" value="<?php echo $name; ?>" class="span12" /></div>
                        <div class="password"><i class="pass"></i><input type="password" name="password" value="<?php echo $password; ?>" placeholder="密码" class="span12" /></div>
                        <div class="auxiliary" style="display: none">
                            <div class="forgot"><a href="<?php echo $forgotten; ?>"><?php echo $text_forgotten; ?></a></div>
                            <div class="state">
                                <div class="state-text">保持登录状态</div>
                                <!--<div class="state-open"><a href="#" class="state-btn"></a></div>-->
                                <div class="state-close"><a href="#" class="state-close-btn"></a></div>
                            </div>
                        </div>

                        <?php if ($forgotten) { ?>

                        <?php } ?>
                    </div>
                    <div class="login-button">
                        <a class="btn" onclick="$('#form').submit();" ><?php echo $button_login; ?></a>
                    </div>
                    <!--<?php if ($redirect) { ?>
                    <input type="hidden" name="redirect" value="<?php echo $redirect; ?>" />
                    <?php } ?>-->
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript"><!--
$('#form input').keydown(function(e) {
	if (e.keyCode == 13) {
		$('#form').submit();
	}
});
//--></script>
<?php echo $footer; ?>