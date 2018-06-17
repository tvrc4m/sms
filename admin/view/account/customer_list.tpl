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
                <a onclick="$('#customer_list_from').submit();" class="btn btn-success">删除</a>
                <a class="btn btn-success" href="{$insert}">添加客户</a>
            </div>
            <div class="form-content">
                <div class="content">
                  <form action="{$delete}" method="POST" id="customer_list_from">
                    <table class="list">
                      <thead>
                        <tr>
                          <td width="1" style="text-align: center;"><input type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);" /></td>
                          <td class="center" style="width:8%">客户ID</td>
                          <td class="center" style="width:12%">客户名称</td>
                          <td class="center" style="width:12%">电话</td>
                          <td class="center" style="width:15%">邮箱</td>
                          <td class="center" style="width:8%">性别</td>
                          <td class="center" style="width:8%">剩余短信</td>
                          <td class="center" style="width:5%">充值</td>
                          <td class="center" style="width:20%">操作</td>
                        </tr>
                      </thead>
                      <tbody>
                        <tr class="filter">
                          <td class="center"></td>
                          <td class="center"></td>
                          <td class="center">
                            <input type="text" style="width:80%" name="filter_name" value="{$filter_name}" /></td>
                          <td class="center">
                            <input type="text" style="width:80%" name="filter_phone" value="{$filter_phone}" /></td>
                          <td class="center">
                            <input type="text" style="width:80%" name="filter_email" value="{$filter_email}" /></td>
                          <td class="center">
                            <select name="filter_sex">
                              <option>--性别--</option>
                              <option value="1">女</option>
                              <option value="2">男</option>
                            </select>
                          </td>
                          <td class="center"></td>
                          <td class="center"></td>
                          <td class="center">
                            <a class="btn" href="javascript:void(0);" onclick="filterCustomer()">筛选</a>
                          </td>
                        </tr>
                        {if !empty($customers)}
                          {foreach from=$customers item=customer}
                          <tr>
                             <td style="text-align: center">
                                {if $customer['customer_id']}
                                <input type="checkbox" name="selected[]" value="{$customer['customer_id']}" checked="checked" />
                                {else}
                                <input type="checkbox" name="selected[]" value="{$customer['customer_id']}" />
                                {/if}
                              </td>
                              <td class="center">
                                {$customer['customer_id']}</td>
                              <td class="center">
                                {$customer['name']}</td>
                              <td class="center">
                                {$customer['phone']}</td>
                              <td class="center">
                                {$customer['email']}</td>
                              <td class="center">
                                {if $customer['sex']==2}
                                  男
                                {else}
                                  女
                                {/if}
                              </td>
                              <td class="center">
                                {$customer['sms_count']}</td>
                              </td>
                              <td class="center">
                                  <a onclick="recharge(this,{$customer['customer_id']},'{$customer['name']}')" style="text-decoration:none" class="btn btn-small btn-success" href="javascript:void(0);"><strong>充</strong></a>
                              </td>
                              <td class="center">
                                {foreach from=$customer['action'] item=act}
                                  <a href="{$act['href']}" target="{$act['target']}">{$act['text']}</a>
                                {/foreach}
                              </td>
                          </tr>
                          {/foreach}
                        {else}
                          <tr>
                            <td class="center" colspan="7">没有用户</td>
                          </tr>
                        {/if}
                      </tbody>
                    </table>
                  </form>
      <div class="pagination">
        {$pagination}</div>
    </div>
<div class="modal hide" id="customerModal" tabindex="-1" role="dialog"  aria-hidden="true" style="display: hidden;">
      <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h3 id="customer_dialog_name">用户充值</h3>
      </div>
      <div class="modal-body">
          <h4 style='display: none;'></h4>
          <p class='popWindowInfo'>
            <div id="add_client">
                <form class="ui-dialog-content" id="customer_form">
                    <input type="hidden" id="customer_id" name="customer_id" value="" />
                    <div id="tab-info">
                        <table class="form">
                            <tr class="left">
                                <td>客户名称</td>
                                <td id="customer_name"></td>
                            </tr>
                            <tr class="left">
                                <td>充值短信条数</td>
                                <td>
                                    <input style="height:23px;padding:2px;" type="input" id="sms_count" name="sms_count" value='0' />
                                </td>
                            </tr>
                            <tr>
                            <td colspan="2"><span class="error" id="recharge_error"></span></td>
                            </tr>
                        </table>
                    </div>
                </form>
            </div>
          </p>
      </div>
      <div class="modal-footer">
          <button class="btn HidePopWindowInfo" data-dismiss="modal" aria-hidden="true" class='cancel'>取消</button>
          <button class="btn btn-primary makesure"  onclick="doRecharge()">确认充值</button>
      </div>
</div>
{literal}
<script type="text/javascript">
function filterCustomer() {
  url = 'index.php?route=account/customer&token='+token;
  
  var filter_name = $('input[name=\'filter_name\']').attr('value');
  
  if (filter_name) {
    url += '&filter_name=' + encodeURIComponent(filter_name);
  }

  var filter_phone = $('input[name=\'filter_phone\']').attr('value');
  
  if (filter_phone) {
    url += '&filter_phone=' + encodeURIComponent(filter_phone);
  }
    
  var filter_email = $('input[name=\'filter_email\']').attr('value');
  
  if (filter_email) {
    url += '&filter_email=' + encodeURIComponent(filter_email);
  }
  var filter_sex = $('input[name=\'filter_sex\']').val();
  
  if (filter_sex) {
    url += '&filter_sex=' + encodeURIComponent(filter_sex);
  }
  document.location.href=url;
}

function recharge(that,customer_id,name){
  $("#customer_name").html(name);
  $("#sms_count").val(0);
  $("#customer_id").val(customer_id);
  $("#customerModal").modal();
}
function doRecharge(){
  var name=$("#customer_name").html();
  var count=$("#sms_count").val();
  var customer_id=$("#customer_id").val();
  if(window.confirm("确定向"+name+"充值"+count+"条短信数")){
    $.ajax({
      url: 'index.php?route=account/ajax/recharge&token='+token,
      type: 'GET',
      dataType: 'json',
      data:{customer_id:customer_id,sms_count:count},
      success: function(res) {
        switch(res.ret){
          case 0:$("#recharge_error").html('查检参数后再提交');break;
          case -1:$("#recharge_error").html('出问题了,查检后重试');break;
          case 1:document.location.reload();break;
        }
      }
    })
  }
}
</script>
{/literal}
            </div>
        </div>
    </div>
</div>


{$footer}
    