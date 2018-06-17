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
            <li>
                <a href="{$account_action}">充值帐户</a>
            </li>
        </ul>
        <div class="tab_container" style="min-height: 1000px;">
            <div class="form-content">
                <div class="content">
                    <form action="{$delete}" method="POST" id="customer_list_from">
                        <table class="list">
                            <thead>
                                <tr>
                                    <!-- <td width="50" style="text-align: center;">
                                        <input type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);" />
                                    </td> -->
                                    <td class="center">帐户名</td>
                                    <td class="center"><a href="{$counturl}">充值条数</a></td>
                                    <td class="center"><a href="{$timeurl}">充值时间</a></td>
                                    <td class="center">充值状态</td>
                                    <td class="center">操作</td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="filter">
                                  <!-- <td class="center"></td> -->
                                    <td class="center">
                                        <input type="text" style="width:80%" name="filter_name" value="{$filter_name}" /></td>
                                    <td class="center">
                                        <!-- <input type="text" style="width:80%" name="filter_phone" value="{$filter_phone}" /> -->
                                    </td>
                                    <td class="center">
                                        <!-- <input type="text" style="width:80%" name="filter_email" value="{$filter_email}" /> -->
                                    </td>
                                    <td class="center">
                                        <select name="filter_status">
                                          <option>--状态--</option>
                                          <option value="1">成功</option>
                                          <option value="2">失败</option>
                                        </select>
                                    </td>
                                    <td class="center">
                                        <a class="btn" href="javascript:void(0);" onclick="filter()">筛选</a>
                                    </td>
                                </tr>
                                {if !empty($records)}
                                    {foreach from=$records item=record}
                                        <tr>
                                            <!-- <td style="text-align: center;">
                                                {if $accout['selected']}
                                                    <input type="checkbox" name="selected[]" value="{$record['bank_record_id']}" checked="checked" />
                                                {else}
                                                    <input type="checkbox" name="selected[]" value="{$record['bank_record_id']}" />
                                                {/if}    
                                            </td> -->
                                            <td class="center">
                                                {$record['realname']}dddd</td>
                                            <td class="center">
                                                {$record['count']}</td>
                                            <td class="center">
                                                {$record['ctime']}</td>
                                            <td class="center">
                                                {if $record['status']==1}
                                                    成功
                                                {else}
                                                    失败
                                                {/if}
                                            </td>
                                            <td class="center"></td>
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
                    <div class="pagination">{$pagination}</div>
                </div>
            </div>
        </div>
    </div>
</div>
{literal}
    <script type="text/javascript">
        function filter(){
            url = 'index.php?route=deposit/record/&token='+token;
            var filter_name = $('input[name=\'filter_name\']').attr('value');
            if (filter_name) {
                url += '&filter_name=' + encodeURIComponent(filter_name);
            }
            var filter_status = $('input[name=\'filter_status\']').attr('value');
            
            if (filter_status) {
                url += '&filter_status=' + encodeURIComponent(filter_status);
            }
            $(".form-content").load(url);
        }

    </script>
{/literal}
{$footer}