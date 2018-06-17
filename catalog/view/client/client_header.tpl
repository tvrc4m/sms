<?php echo $header; ?>

<div class="contents">
   
    <div class="warning hide"></div>
    <div class="success hide"></div>
    <div class="row-fluid">
        <div class="pull-right">
            <!-- <a onclick="addClient()" class="btn btn-success">批量导入客户</a> -->
            <a onclick="addClient()" class="btn btn-success">添加客户</a>
            &nbsp;|&nbsp;
            <!-- <a onclick="addGroup()" class="btn btn-danger">批量导入群组</a> -->
            <a onclick="addGroup()" class="btn btn-danger">创建群组</a>
        </div>
    </div>
    <div class="separator">
        <span></span>
    </div>
    <div class="widget leftTabs">
        <ul class="tabs service-tab">
            <li class="">
                <a url="<?php echo $client_list_action; ?>">客户列表</a>
            </li>
            <li class="">
                <a url="<?php echo $group_list_action; ?>">群组列表</a>
            </li>
        </ul>
        
        <div class="tab_container" style="min-height: 1000px;">

            <div class="form-content">
                
            </div>
        </div>
    </div>
</div>
<div class="modal hide fade" id="clientModal" tabindex="-1" role="dialog"  aria-hidden="true" style="display: hidden;">
      <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h3 id="client_dialog_name">添加客户</h3>
      </div>
      <div class="modal-body">
          <h4 style='display: none;'></h4>
          <p class='popWindowInfo'>
            <div id="add_client">
                <form class="ui-dialog-content" id="client_form">
                    <input type="hidden" id="client_id" name="client_id" value="" />
                    <div id="tab-info">
                        <table class="form">
                            <tr class="left">
                                <td>客户群组</td>
                                <td >
                                    <select type="text" id="group" name="group_id">
                                        <option value="0">--请选择群组--</option>
                                        <?php foreach ($groups as $group) { ?>
                                            <option value="<?php echo $group['client_group_id']; ?>"><?php echo $group['name']; ?></option>
                                        <?php } ?>
                                    </select>
                                </td>
                            </tr>
                            <tr class="left">
                                <td>客户名称</td>
                                <td><input type="text" id="client_name" name="name" />
                                    <span class="error"></span>
                                </td>
                            </tr>
                            <tr class="left">
                                <td>客户性别</td>
                                <td>
                                    <input type="radio" name="sex" value='1' /> 男 &nbsp;&nbsp;&nbsp;&nbsp;
                                    <input type="radio" name="sex" value='2' /> 女
                                </td>
                            </tr>
                            <tr class="left">
                                <td>客户手机号</td>
                                <td><input type="text" id="iphone" name="phone" /></td>
                            </tr>
                            <tr class="left">
                                <td>邮箱</td>
                                <td><input type="text" id="email" name="email" /></td>
                            </tr>
                            <tr class="left">
                                <td>公司</td>
                                <td><input type="text" id="company" name="company" /></td>
                            </tr>
                            <tr class="left">
                                <td>渠道备注</td>
                                <td><input type="text" id="remark" name="remark" /></td>
                            </tr>
                        </table>
                    </div>
                </form>
            </div>
          </p>
      </div>
      <div class="modal-footer">
          <button class="btn HidePopWindowInfo" data-dismiss="modal" aria-hidden="true" class='cancel'>取消</button>
          <button class="btn btn-primary makesure"  onclick="updateClient()">确认</button>
      </div>
</div>
<div class="modal hide fade" id="groupModal" tabindex="-1" role="dialog"  aria-hidden="true" style="display: hidden;">
      <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h3 id="group_dialog_name">添加群组</h3>
      </div>
      <div class="modal-body">
          <h4 style='display: none;'></h4>
          <p class='popWindowInfo'>
            <div id="add_client_group">
                <form class="ui-dialog-content" id="group_form">
                    <input type="hidden" id="group_id" name="group_id" value="" />
                    <div id="tab-info">
                        <table class="form">
                            <tr class="left">
                                <td>群组名称</td>
                                <td><input type="text" id="group_name" name="name" />
                                    <span class="error"></span>
                                </td>
                            </tr>
                            <tr class="left">
                                <td>群组备注</td>
                                <td><input type="text" id="group_remark" name="remark" /></td>
                            </tr>
                        </table>
                    </div>
                </form>
            </div>
          </p>
      </div>
      <div class="modal-footer">
          <button class="btn HidePopWindowInfo" data-dismiss="modal" aria-hidden="true" class='cancel'>取消</button>
          <button class="btn btn-primary makesure"  onclick="updateClientGroup()">确认</button>
      </div>
</div>

<script type="text/javascript">
    function delClient(that,client_id){
        if(window.confirm('是否确认要删除?')){
            $.ajax({
                url:'index.php?route=client/ajax/delClient&t=<?php echo $this->session->data["t"]; ?>',
                data:{client_id:client_id},
                dataType:'json',
                type:'GET',
                success:function(res){
                    if(res.ret==1){
                        document.location.reload();
                    }else if(res.ret==-1){
                        //没有权限
                    }
                }
            });
        }
        return false;
    }
    function addClient(){
        $("#group option").removeAttr('selected');
        $('#client_name').val('');
        $('#remark').val('');
        $("#client_id").val(0);
        $("#client_dialog_name").html('添加客户');
        $("#add_client .error").html('');
        $('#clientModal').modal();
    }
    function addGroup(){
        $('#group_name').val('');
        $('#group_remark').val('');
        $("#group_id").val(0);
        $("#group_dialog_name").html('添加群组');
        $("#add_group .error").html('');
        $('#groupModal').modal();
    }
    function editGroup(that){
        var group_id=$(that).attr('groupid');
        if(!group_id) return false;
        $.ajax({
            url:'index.php?route=client/ajax/getGroup&t=<?php echo $this->session->data["t"]; ?>',
            data:{group_id:group_id},
            type:'GET',
            dataType:'json',
            success:function(res){
                if(res.ret==1){
                    $('#group_id').val(res.info.client_group_id);
                    $("#group_name").val(res.info.name);
                    $("#group_remark").val(res.info.remark);
                     $("#group_dialog_name").html('群组编辑');
                    $("#add_group .error").html('');
                    $('#groupModal').modal();
                }
            }
        })
    }
    function delGroup(that){
        var group_id=$(that).attr('groupid');
        if(!group_id) return false;
        if(window.confirm('是否确认要删除?')){
            delClient=0;
            if(window.confirm('是否删除群组里的成员,否则转移移到默认组')){
                delClient=1;
            }
            $.ajax({
                url:'index.php?route=client/ajax/delGroup&t=<?php echo $this->session->data["t"]; ?>',
                data:{group_id:group_id,client:delClient},
                dataType:'json',
                type:'GET',
                success:function(res){
                    if(res.ret==1){
                        $(".widget .tabs li[class*='active']").trigger('click');
                    }else if(res.ret==-1){
                        //没有权限
                    }
                }
            });  
        }
        return false;
    }
    function editClient(that,client_id){
        $.ajax({
            url:'index.php?route=client/ajax/getClient&t=<?php echo $this->session->data["t"]; ?>',
            data:{client_id:client_id},
            dataType:'json',
            type:'GET',
            success:function(res){
                var options=[];
                var group_id=res.client.client_group_id;
                var options=$("#group option");
                options.each(function(i,e){
                    if($(e).attr('value')==group_id){
                        $(e).attr('selected','selected');
                        return false;
                    }
                });
                $('#client_name').val(res.client.name);
                $('#iphone').val(res.client.phone);
                $('#email').val(res.client.email);
                $('#sex').val(res.client.sex);
                $('#remark').val(res.client.remark);
                $("#client_id").val(res.client.client_id);
                $("#client_dialog_name").html('编辑客户信息');
                $("#add_client .error").html('');
                $('#clientModal').modal();
            }
        });
        return false;
    }
    function updateClient(){
        var name=$('#client_name').val();
        var phone=$('#iphone').val();
        if(!name){
            $('#client_name').focus();
            $('#client_name').siblings('span').html('客户名称不能为空');
            return false;
        }
        if(!phone){
            $('#iphone').focus();
            $('#iphone').siblings('span').html('客户手机号不能为空');
            return false;
        }
        $.ajax({
            url:'index.php?route=client/ajax/updateClient&t=<?php echo $this->session->data["t"]; ?>',
            data:$("#client_form input,#client_form select,#client_form radio:selected"),
            type:'POST',
            dataType:'json',
            success:function(res){
                if(res.ret==1){
                    document.location.reload();
                }else if(res.ret==-1){
                    $('#channel_name').siblings('span').html(res.error.error_name);
                }
            }
        });
        return false;
    }
    function updateClientGroup(){
        var name=$('#group_name').val();
        if(!name){
            $('#group_name').focus();
            $('#group_name').siblings('span').html('群组名不能为空');
            return false;
        }
        $.ajax({
            url:'index.php?route=client/ajax/updateGroup&t=<?php echo $this->session->data["t"]; ?>',
            data:$("#group_form input"),
            type:'GET',
            dataType:'json',
            success:function(res){
                switch(res.ret){
                    case 0:$("#group_name").siblings('span').html('群组名不能为空');break;
                    case -1:$("#group_name").siblings('span').html('群组名已经存在');break;
                    default:$(".widget .tabs li[class*='active']").trigger('click'); break;
                }
            }
        });
        return false;
    }
</script>
<script type="text/javascript">

    loadListInfo('index.php?route=client/client/getList&t=<?php echo $t; ?>');

</script>


<?php echo $footer; ?>