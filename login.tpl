{$header}
<div class="container-fluid">

    <div class="row-fluid">

        <div class="span12">
            <div class="login">
                <!--<img src="view/responsive/img/user.png" alt="user" class="glossy">-->
                <form action="{$action}" method="post" enctype="multipart/form-data" id="form" class="inline-block fwf">
                    <div class="login-content">
                        <h4>供应链系统</h4>
                        <!--<?php if ($success) { ?>
                        <div class="success">{$success}</div>
                        <?php } ?>-->

                        {if $error_warning}
                        <div class="warning">{$error_warning}</div>
                        {/if}
                        <div class="username"><i class="name"></i><input type="text" name="username" placeholder="用户名" value="{$username}" class="span12" /></div>
                        <div class="password"><i class="pass"></i><input type="password" name="password" value="{$password}" placeholder="密码" class="span12" /></div>
                        <div class="auxiliary" style="display: none">
                            <div class="forgot"><a href="{$forgotten}">{$text_forgotten}</a></div>
                            <div class="state">
                                <div class="state-text">保持登录状态</div>
                                <!--<div class="state-open"><a href="#" class="state-btn"></a></div>-->
                                <div class="state-close"><a href="#" class="state-close-btn"></a></div>
                            </div>
                        </div>

                    </div>
                    <div class="login-button">
                        <a class="btn" onclick="$('#form').submit()">login</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
{literal}
<script type="text/javascript"><!--
$('#form input').keydown(function(e) {
	if (e.keyCode == 13) {
		$('#form').submit();
	}
});
//--></script>
{/literal}
{$footer}
