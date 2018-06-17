{$header}

<div class="contents">
   
    <div class="warning hide"></div>
    <div class="success hide"></div>
    <div class="separator">
        <span></span>
    </div>
    <div class="widget leftTabs">
        <ul class="tabs roomSource-tab">
            <li class="{$menu['className']}">
                <a href="{$customer_action}">客户列表</a>
            </li>
        </ul>
        <div class="tab_container" style="min-height: 1000px;">
            <div class="margin" style="position:absolute; margin-top:-44px; right:10px;">
                <a class="btn btn-primary" onclick="$('#form').submit()">保存</a>
            </div>
            <div class="form-content">
                <form action="{$action}" method="post" enctype="multipart/form-data" id="form">
            <table class="form">
              <tr>
                <td><span class="required">*</span> {$entry_name}</td>
                <td><input type="text" name="name" value="{$name}" />
                  {if $error_name}
                  <span class="error">{$error_name}</span>
                  {/if}</td>
              </tr>
              <tr>
                <td><span class="required">*</span> {$entry_email}</td>
                <td><input type="text" name="email" value="{$email}" />
                  {if $error_email}
                  <span class="error">{$error_email}</span>
                  {/if}</td>
              </tr>
              <tr>
                <td><span class="required">*</span> {$entry_telephone}</td>
                <td><input type="text" name="telephone" value="{$telephone}" />
                  {if $error_telephone}
                  <span class="error">{$error_telephone}</span>
                  {/if}</td>
              </tr>
              <tr>
                <td>{$entry_password}</td>
                <td><input type="password" name="password" value="{$password}"  />
                  {if $error_password}
                  <span class="error">{$error_password}</span>
                  {/if}</td>
              </tr>
              <tr>
                <td>{$entry_confirm}</td>
                <td><input type="password" name="confirm" value="{$confirm}" />
                  {if $error_confirm}
                  <span class="error">{$error_confirm}</span>
                  {/if}</td>
              </tr>
              <tr>
                <td>{$entry_customer_group}</td>
                <td>
                    <select name="customer_group_id">
                        {foreach from=$customer_groups item=customer_group}
                            {if $customer_group['customer_group_id'] == $customer_group_id}
                                <option value="{$customer_group['customer_group_id']}" selected="selected">{$customer_group['name']}</option>
                            {else}
                                <option value="{$customer_group['customer_group_id']}">{$customer_group['name']}</option>
                            {/if}
                        {/foreach}
                  </select>
                  </td>
              </tr>
              <tr>
                <td>{$entry_status}</td>
                <td><select name="status">
                    {if $status}
                      <option value="1" selected="selected">{$text_enabled}</option>
                      <option value="0">{$text_disabled}</option>
                    {else}
                      <option value="1">{$text_enabled}</option>
                      <option value="0" selected="selected">{$text_disabled}</option>
                    {/if}
                  </select></td>
              </tr>
            </table>
      </form>

            </div>
        </div>
    </div>
</div>

{$footer}