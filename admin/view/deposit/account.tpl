{$header}

<div class="contents">

    <div class="warning hide"></div>
    <div class="success hide"></div>
    <div class="separator">
        <span></span>
    </div>
    <div class="widget leftTabs">
        <ul class="tabs roomSource-tab">
            <li class="active">
                <a href="{$record_action}">充值记录</a>
            </li>
            <li class="active">
                <a href="{$account_action}">充值帐户</a>
            </li>
        </ul>
        <div class="tab_container" style="min-height: 1000px;">
            <div class="margin" style="position:absolute; margin-top:-44px; right:10px;">
                <a onclick="$('#customer_list_from').submit();" class="btn btn-success">删除</a>
                <a class="btn btn-success" href="{$insert}">添加</a>
            </div>
            <div class="form-content">
                <div class="content">
                    <form action="{$delete}" method="POST" id="customer_list_from">
                        <table class="list">
                            <thead>
                                <tr>
                                    <td width="1" style="text-align: center;">
                                        <input type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);" />
                                    </td>
                                    <td class="center" style="width:10%">帐户名</td>
                                    <td class="center" style="width:15%">银行</td>
                                    <td class="center" style="width:25%">银行卡号</td>
                                    <td class="center" style="width:15%">电话</td>
                                    <td class="center" style="width:8%">是否默认帐户</td>
                                    <td class="center" style="width:8%">状态</td>
                                    <td class="center" style="width:8%">操作</td>
                                </tr>
                            </thead>
                            <tbody>
                                {if !empty($accounts)}
                                    {foreach from=$accounts item=account}
                                    <tr>
                                        <td style="text-align: center;">
                                            {if $account['selected']}
                                                <input type="checkbox" name="selected[]" value="{$account['bank_account_id']}" checked="checked" />
                                            {else}
                                                <input type="checkbox" name="selected[]" value="{$account['bank_account_id']}" />
                                            {/if}
                                        </td>
                                        <td class="center">
                                            {$account['realname']}</td>
                                        <td class="center">
                                            {$account['bank_name']}</td>
                                        <td class="center">
                                            {$account['card_number']}</td>
                                        <td class="center">
                                            {$account['phone']}</td>
                                        <td class="center">
                                            {$account['default']}</td>
                                        <td class="center">
                                            {$account['status']}</td>
                                        <td class="center">
                                            {foreach from=$account['action'] item=$act}
                                                <a href="{$act['href']}">
                                                    {$act['text']}
                                                </a>
                                            {/foreach}
                                            </td>
                                    </tr>
                                {/foreach}
                            {else}
                                <tr>
                                    <td class="center" colspan="9">没有帐号</td>
                                </tr>
                            {/if}    
                        </tbody>
                    </table>
                </form>
                <div class="pagination">
                    {$pagination}</div>
            </div>

        </div>
    </div>
</div>
</div>
{$footer}
