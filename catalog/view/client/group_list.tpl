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
                                <input type="checkbox" onclick='$("input:checkbox[name*=group]").attr("checked", this.checked);' />
                            </td>
                            <td class="center" style="width:10%">群组ID</td>
                            <td class="center" style="width:20%">群组名称</td>
                            <td class="center" style="width:20%">群组备注</td>
                            <td class="center" style="width:10%">发送群组短信</td>
                            <td class="right" style="width:20%">操作</td>
                            <td class="right" style="width:20%">筛选</td>
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="filter">
                            <td class="center"></td>
                            <td class="center"></td>
                            <td class="center"><input type="text" style="width:80%" name="filter_name" value="<?php echo $filter_name; ?>" /></td>
                            <td class="center"><input type="text" style="width:80%" name="filter_remark" value="<?php echo $filter_remark; ?>" /></td>
                            <td class="center"></td>
                            <td class="center"></td>
                            <td class="center"><a onclick="filterGroup();" class="btn">筛选</a></td>
                        </tr>
                        <?php if (!empty($groups)) { ?>
                        <?php foreach ($groups as $group) { ?>
                        <tr>
                            <td class="center">
                                <input type="checkbox" name="group[]" value="<?php echo $group['client_group_id']; ?>" />
                            </td>
                            <td class="center"><?php echo $group['client_group_id']; ?></td>
                            <td class="center"><?php echo $group['name']; ?></td>
                            <td class="center"><?php echo $group['remark']; ?></td>
                            
                            <td class="center"><a href="javascript:void(0);" onclick="smsGroup(<?php echo $group['client_group_id']; ?>)">发短信</a></td>
                            <td class="center">
                                <a groupid="<?php  echo $group['client_group_id']; ?>" onclick="delGroup(this)" href="javascript:void(0);">删除</a>
                                <a groupid="<?php  echo $group['client_group_id']; ?>" onclick="editGroup(this)" href="javascript:void(0);">编辑</a>
                            </td>
                            <td class="center"></td>
                        </tr>
                        <?php } ?>
                        <?php } else { ?>
                        <tr>
                            <td class="center" colspan="8">还没有创建群组</td>
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
          <button class="btn btn-primary makesure"  onclick="sendClientGroup()">发送</button>
      </div>
</div>
<script type="text/javascript">
    function filterGroup(){
        url = 'index.php?route=client/group&t=<?php echo $this->session->data["t"]; ?>';
        var filter_name = $('input[name=\'filter_name\']').attr('value');
        if (filter_name) {
            url += '&filter_name=' + encodeURIComponent(filter_name);
        }
        var filter_remark = $('input[name=\'filter_remark\']').attr('value');
        
        if (filter_remark) {
            url += '&filter_remark=' + encodeURIComponent(filter_remark);
        }
        $(".form-content").load(url);
    }
    function removeClientHidden(){
        $('#sms_form input:hidden[name*=group]').remove();
    }
    function sendSmsInGroup(){

    }
    function smsGroup(group_id){
        if(!group_id) return false;
        $("#istimer[checked]").trigger('click');
        removeClientHidden();
        $('#sms_form').append('<input type="hidden" name="group[]" value="'+group_id+'" />');
        $("#smsModal").modal();
    }
    function smsModal(){
        var selected=$('input:checkbox[name*=group][checked]');
        if(!selected.length){
            alert('请选选中群组');
            return false;
        }
        removeClientHidden();
        $('input:checkbox[name*=group][checked]').each(function(i,e){
            $('#sms_form').append('<input type="hidden" name="group[]" value="'+$(e).val()+'" />');
        });
        $("#istimer[checked]").trigger('click');
        $("#smsModal").modal();
    }
    function sendClientGroup(){
        $.ajax({
            url:'index.php?route=sms/ajax/group_send&t=<?php echo $this->session->data["t"]; ?>',
            type:'POST',
            dataType:'json',
            data:$("#sms_form input:not(:checkbox),#sms_form textarea,#sms_form input:checkbox[checked]"),
            success:function(res){
                if(res.ret==-1){
                    $("#sms_error").addClass('error').html(res.error);
                }else if($res.ret==1){
                    $("#sms_error").removeClass('error').html('已成功发送');
                }else{
                    $("#sms_error").removeClass('error').html('请稍后再试');
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