<?php echo $header; ?>

<div class="contents">

    <div class="warning hide"></div>
    <div class="success hide"></div>
    <div class="separator">
        <span></span>
    </div>
    <div class="widget leftTabs">
        <ul class="tabs service-tab">
            <li class="">
                <a url="<?php echo $client_list_action; ?>">接口列表</a>
            </li>
        </ul>

        <div class="content-form">

            <div class="row-fluid">
                <div class="span12">
                    <div class="widget_wrapper">
                        <div class="widget_content no-padding">
                           <div class="margin" style="position:absolute; margin-top:-34px; right:10px;">
                                <a href="javascript:void(0);" onclick="$('#form').submit()" class="btn btn-success">保存</a>
                            </div>
                            <form action="<?php echo $action; ?>
                                " method="post" enctype="multipart/form-data" id="form">
                                <input type="hidden" name="sms_interface_id" value="<?php echo $sms_interface_id; ?>" />
                                <table class="form">
                                    <tr>
                                        <td class="left">
                                            <span class="required">*</span>
                                            接口名
                                        </td>
                                        <td>
                                        <?php if(!empty($sms_interface_id)){ ?>
                                            <input type="text" readonly name="name" value="<?php echo $name; ?>" />
                                        <?php }else {?>
                                            <input type="text" name="name" value="<?php echo $name; ?>" />
                                        <?php } ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="left">
                                            <span class="required">*</span>
                                            帐户名
                                        </td>
                                        <td>
                                            <input type="text" name="account" value="<?php echo $account; ?>" /></td>
                                    </tr>
                                    <tr>
                                        <td class="left">
                                            <span class="required">*</span>
                                            帐户密码
                                        </td>
                                        <td>
                                            <input type="password" name="password" value="" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="left">状态</td>
                                        <td>
                                            <input type="checkbox" name="status" value="1" <?php if($status==1){echo 'checked';}?> />
                                        </td>
                                    </tr>
                                </table>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php echo $footer; ?>