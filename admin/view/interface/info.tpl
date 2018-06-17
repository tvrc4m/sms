<?php echo $header; ?>
<div class="contents">
    <div class="warning hide"></div>
    <div class="success hide"></div>
    <div class="separator">
        <span></span>
    </div>
    <div class="widget leftTabs">
        <ul class="tabs roomSource-tab">
            <li>
                <a url="<?php echo $outbox_action; ?>">接口信息</a>
            </li>
        </ul>
        <div class="tab_container" style="min-height: 1000px;">
            <div class="form-content">
                <div class="row-fluid">
                    <div class="span12">
                            <div class="widget_content no-padding">
                                <table width="30%" cellspacing="0" cellpadding="0" class="default_table">
                                    <thead>
                                        <tr>
                                        <td colspan="2"><a href="http://www.sp1086.com" target="_blank"><strong>www.sp1086.com</strong></a></td>
                                        </tr>
                                    </thead>
                                    <tr>
                                        <td>剩余短信条数</td>
                                        <td><?php echo $balance['balance_num']; ?></td>
                                    </tr>
                                     <tr>
                                        <td>已发送短信条数</td>
                                        <td><?php echo $balance['send_num']; ?></td>
                                    </tr>
                                    <tr>
                                        <td>帐户</td>
                                        <td><?php echo $interface['name']; ?></td>
                                    </tr>
                                    <tr>
                                        <td>密码</td>
                                        <td><?php echo $interface['password']; ?></td>
                                    </tr>
                                    <tr>
                                        <td>开启</td>
                                        <td><?php echo $interface['status']; ?></td>
                                    </tr>
                                </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

   
</script>


<?php echo $footer; ?>