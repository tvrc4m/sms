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
                <a class="btn btn-primary" onclick="$('#form').submit()">保存</a>
            </div>
            <div class="form-content">
                <form action="{$action}" method="post" enctype="multipart/form-data" id="form">
                    <input type="hidden" name="bank_account_id" value="{$bank_account_id}">
                    <table class="form">
                      <tr>
                        <td><span class="required">*</span>持卡姓名</td>
                        <td><input type="text" name="realname" value="{$realname}" />
                          {if $error_realname}
                            <span class="error">{$error_realname}</span>
                          {/if}
                        </td>
                      </tr>
                      <tr>
                        <td><span class="required">*</span>银行名</td>
                        <td><input type="text" name="bank_name" value="{$bank_name}" />
                          <?php if ($error_bank) { ?>
                          {if $error_bank}
                            <span class="error">{$error_bank}</span>
                          {/if}
                        </td>
                      </tr>
                      <tr>
                        <td><span class="required">*</span>银行记号</td>
                        <td><input type="text" name="card_number" value="{$card_number}"  />
                          {if $error_card}
                            <span class="error">{$error_card}</span>
                          {/if}
                        </td>
                      </tr>
                      <tr>
                        <td><span class="required">*</span>持卡人电话</td>
                        <td><input type="text" name="phone" value="{$phone}" />
                          <?php if ($error_phone) { ?>
                          {if $error_phone}
                            <span class="error">{$error_phone}</span>
                          {/if}
                        </td>
                      </tr>
                      <tr>
                        <td>默认帐户</td>
                        <td>
                            <input type="checkbox" name="default" value="1" {if $default}"checked"{/if}; />
                            (同一时间只有有一个默认)
                        </td>
                      </tr>
                      <tr>
                        <td>状态</td>
                        <td><select name="status">
                            <?php if ($status) { ?>
                            <option value="1" selected="selected">{$text_enabled}</option>
                            <option value="0">{$text_disabled}</option>
                            <?php } else { ?>
                            <option value="1">{$text_enabled}</option>
                            <option value="0" selected="selected">{$text_disabled}</option>
                            <?php } ?>
                          </select>
                        </td>
                      </tr>
                    </table>
                </form>
            </div>
        </div>
    </div>
</div>
{$footer}
