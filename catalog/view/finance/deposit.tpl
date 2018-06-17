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
                <a href="<?php echo $amount_action; ?>">帐户金额</a>
            </li>
            <li class="">
                <a href="<?php echo $deposit_action; ?>">帐户充值</a>
            </li>
        </ul>
        <div class="tab_container" style="min-height: 1000px;">

            <div class="form-content">
                <div class="row-fluid">
                    <div class="span12">
                        <form id="customer_form">
                            <div id="tab-info">
                                <table class="form">
                                    <tbody>
                                        <tr class="left">
                                            <td>帐户名</td>
                                            <td><?php echo $account['realname']; ?></td>
                                        </tr>
                                        <tr class="left">
                                            <td>银行</td>
                                            <td><?php echo $account['bank_name']; ?></td>
                                        </tr>
                                        <tr class="left">
                                            <td>银行卡号</td>
                                            <td><?php echo $account['card_number']; ?></td>
                                        </tr>
                                        <tr class="left">
                                            <td>联系电话</td>
                                            <td><?php echo $account['phone']; ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php echo $footer; ?>