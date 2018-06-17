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
        <a href="javascript:void(0);">创建应用</a>
      </li>
    </ul>
    <div class="tab_container" style="min-height: 1000px;">
      <div class="margin" style="position:absolute; margin-top:-44px; right:10px;">
        <a class="btn btn-primary" onclick="$('#form').submit()">保存</a>
      </div>
      <div class="form-content">
        <form action="{$action}" method="post" enctype="multipart/form-data" id="form">
          <input type="hidden" name="customer_id" value="{$customer_id}">
          <table class="form">
            <tr>
              <td><span class="required">*</span>应用名称</td>
              <td><input type="text" name="name" value="{$name}" />
              {if $error_name}
              <span class="error">{$error_name}</span>
            {/if}</td>
          </tr>
        </table>
      </form>
    </div>
  </div>
</div>
</div>
{$footer}