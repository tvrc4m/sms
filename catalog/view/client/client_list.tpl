
<div class="margin" style="position:absolute; margin-top:-44px; right:10px;">
    <a class="sms_send btn btn-primary" onclick="smsModal()">发短信</a>
</div>
<div class="content-form">

<div class="row-fluid">
    <div class="span12">
        <div class="widget_wrapper">
            <div class="widget_content no-padding">
                <form action="" method="post" enctype="multipart/form-data" id="form">
                    <table width="100%" cellspacing="0" cellpadding="0" class="default_table">
                        <thead>
                        <tr>
                            <td class="center" style="width:10%">
                                <input type="checkbox" onclick='$("input:checkbox[name*=client]").attr("checked", this.checked);' />
                            </td>
                            <td class="center" style="width:8%">客户ID</td>
                            <td class="center" style="width:12%">客户名称</td>
                            <td class="center" style="width:12%">电话</td>
                            <td class="center" style="width:15%">邮箱</td>
                            <td class="center" style="width:8%">性别</td>
                            <td class="center" style="width:10%">发送短信</td>
                            <td class="right" style="width:15%">操作</td>
                            <td class="right" style="width:15%">筛选</td>
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="filter">
                            <td class="center"></td>
                            <td class="center"></td>
                            <td class="center"><input type="text" style="width:80%" name="filter_name" value="<?php echo $filter_name; ?>" /></td>
                            <td class="center"><input type="text" style="width:80%" name="filter_phone" value="<?php echo $filter_phone; ?>" /></td>
                            <td class="center"><input type="text" style="width:80%" name="filter_email" value="<?php echo $filter_email; ?>" /></td>
                            <td class="center">
                                <select name="filter_sex">
                                    <option>--性别--</option>
                                    <option value="1">女</option>
                                    <option value="2">男</option>
                                </select>
                            </td>
                            <td class="center"></td>
                            <td class="center"></td>
                            <td class="center"><a class="btn" href="javascript:void(0);" onclick="filterClient()">筛选</a></td>
                        </tr>
                        <?php if (!empty($clients)) { ?>
                            <?php foreach ($clients as $client) { ?>
                            <tr>
                                <td class="center">
                                    <input type="checkbox" name="client[]" value="<?php echo $client['client_id']; ?>" />
                                </td>
                                <td class="center"><?php echo $client['client_id']; ?></td>
                                <td class="center"><?php echo $client['name']; ?></td>
                                <td class="center"><?php echo $client['phone']; ?></td>
                                <td class="center"><?php echo $client['email']; ?></td>
                                <td><?php if($client['sex']==2){echo '男';}else{echo '女';} ?></td>
                                <td class="center"><a href="javascript:void(0);" onclick="smsPopup(<?php echo $client['client_id']; ?>)">发短信</a></td>
                                <td class="center">
                                    <a onclick="delClient(this,<?php  echo $client['client_id']; ?>)" href="javascript:void(0);">删除</a>
                                    <a onclick="editClient(this,<?php  echo $client['client_id']; ?>)" href="javascript:void(0);">编辑</a>
                                </td>
                                <td class="center"></td>
                            </tr>
                            <?php } ?>
                        <?php } else { ?>
                        <tr>
                            <td class="center" colspan="7">没有创建客户</td>
                        </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </form>
                <div class="pagination"><?php echo $pagination; ?></div>
            </div>
        </div>
    </div>
</div>
</div>
<div class="modal hide" id="smsModal" tabindex="-1" role="dialog"  aria-hidden="true" style="display: hidden;">
      <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h3 id="group_dialog_name">发送短信</h3>
      </div>
      <div class="modal-body">
          <h4 style='display: none;'></h4>
          <p class='popWindowInfo'>
            <div id="add_client_group">
                <form class="ui-dialog-content" id="sms_form">
                
                    <div id="tab-info">
                        <table class="form">
                            <tr class="left">
                                <td>短信内容</td>
                                <td>
                                    <textarea name="message" id="sms_message" style="width:400px;height:120px;"></textarea>
                                    <span class="error"></span>
                                </td>
                            </tr>
                           <!--  <tr class="left">
                                <td>短信类别</td>
                                <td>
                                    <select name="sms_cat" id="sms_cat">
                                        <?php foreach($sms_cats as $cat){ ?>
                                            <option value="<?php echo $cat['sms_cat_id']; ?>"><?php echo $cat['name']; ?>（<?php echo $cat['count']; ?>条）</option>
                                        <?php } ?>
                                    </select>
                                </td>
                            </tr> -->
                            <tr class="left">
                              <td>定时</td>
                              <td>
                                <input id="istimer" name="is_timer" type="checkbox" value="1" style="height:26px;" />
                                <input type="text" name="datetime" id="datepicker" style="width:150px;margin:0 10px;padding-left:10px;display:none" class="hasDatepicker" />
                              </td>
                            </tr>
                            <tr class="left">
                              <td></td>
                              <td>
                                <span id="sms_error" style="font-size: 14px;font-weight: bold;"></span>
                              </td>
                            </tr>
                        </table>
                    </div>
                </form>
            </div>
          </p>
      </div>
      <div class="modal-footer">
          <button class="btn HidePopWindowInfo" data-dismiss="modal" aria-hidden="true" class='cancel'>取消</button>
          <button class="btn btn-primary makesure"  onclick="sendClient()">发送</button>
      </div>
</div>
<script type="text/javascript">
    function filterClient(){
        url = 'index.php?route=client/client/getList&t=<?php echo $this->session->data["t"]; ?>';
        var filter_name = $('input[name=\'filter_name\']').val();
        console.log(filter_name);
        if (filter_name) {
            url += '&filter_name=' + encodeURIComponent(filter_name);
        }
        var filter_phone = $('input[name=\'filter_phone\']').val();
        if (filter_phone) {
            url += '&filter_phone=' + encodeURIComponent(filter_phone);
        }
        var filter_sex = $('input[name=\'filter_sex\'] option:selected').val();
        if (filter_sex) {
            url += '&filter_sex=' + encodeURIComponent(filter_sex);
        }
        var filter_remark = $('input[name=\'filter_remark\']').val();
        
        if (filter_remark) {
            url += '&filter_remark=' + encodeURIComponent(filter_remark);
        }
        $(".form-content").load(url);
    }
    function removeClientHidden(){
        $('#sms_form input:hidden[name*=client]').remove();
    }
    function smsPopup(cliend_id){
        if(!cliend_id) return false;
        removeClientHidden();
        $('#sms_form').append('<input type="hidden" name="client[]" value="'+cliend_id+'" />');
        $("#smsModal").modal();
    }
    function smsModal(){
        var selected=$('input:checkbox[name*=client][checked]');
        if(!selected.length){
            alert('请选选中用户');
            return false;
        }
        removeClientHidden();
        $('input:checkbox[name*=client][checked]').each(function(i,e){
            $('#sms_form').append('<input type="hidden" name="client[]" value="'+$(e).val()+'" />');
        });
        $("#smsModal").modal();
    }
    function sendClient(){
        $.ajax({
            url:'index.php?route=sms/ajax/send&t=<?php echo $this->session->data["t"]; ?>',
            type:'POST',
            dataType:'json',
            data:$("#sms_form input:not(:checkbox),#sms_form textarea,#sms_form input:checkbox[checked]"),
            success:function(res){
                if(res.ret==-1){
                    $("#sms_error").addClass('error').html(res.error);
                }else{
                    $("#sms_error").removeClass('error').html('正在等待发送中……');
                }
            }
        })
    }
    $("#datepicker").datetimepicker({
        format: 'yyyy-mm-dd hh:ii:00',
        language:'zh-CN',
        autoclose:true
    });
    $("#istimer").click(function(){
        if($(this).attr('checked')){
          $("#datepicker").show();
        }else{
          $("#datepicker").hide();
        }
    })
</script>