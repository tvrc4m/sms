<?php echo $header; ?>
<div class="contents">
    <div class="warning hide"></div>
    <?php if(!empty($success)){ ?>
      <div class="success"><?php echo $success; ?></div>
    <?php } ?>
    <div class="separator">
        <span></span>
    </div>
    <div class="widget leftTabs">
        <div class="tab_container" style="min-height: 1000px;">
            <div class="form-content">
                <div class="content-form">
    <div class="contents">
      <form action="<?php echo $send_action; ?>" method="post" enctype="multipart/form-data" id="form">
        <div id="tab-customer" class="vtabs-content">
          <table class="form">
            <tr>
              <td>短信内容:</td>
              <td>
                <div><h4>当前短信余额<?php echo $sms_count; ?>条</h4></div>
                <textarea id="message" onkeyup="countMessage(this)" onblur="countMessage(this)" onfocus="countMessage(this)" name="message" style="width:700px;height:80px;"><?php echo $message; ?></textarea>
                <div style="font-size:14px;">
                  您已输入<b class="word_count">0</b>个字符,手机分<b class='send_count'>1</b>条发送,
                  <strong>注意:每条短信内容最多70字，超过将以长短信方式发送！</strong>
                </div>
              </td>
              <td><span class="error_message error"><?php echo $error_message; ?></span></td>
            </tr>
            <tr>
              <td>短信签名:</td>
              <td>
                <input name="sign" type="text" value='' />
              </td>
            </tr>
            <tr>
              <td>预定发送时间:</td>
              <td>
                <input id="istimer" name="is_timer" type="checkbox" style="height:26px;" />
                <input type="text" name="datetime" id="datepicker" style="width:150px;margin:0 10px;padding-left:10px;display:none" class="hasDatepicker" />
              </td>
              <td><span class="error_timer error"><?php echo $error_timer; ?></span></td>
            </tr>
            <tr>
              <td>手机号码:</td>
              <td>
                <textarea name="phones" id="phonelist" onkeyup="countPhone()" onfocus="countPhone()" onblur="countPhone()" onchange="countPhone()" style="width:700px;height:150px;"><?php echo $phones; ?></textarea>
                <div style="margin:5px 5px 5px 0">
                  <input type="button" class="btn" onclick="importTxt()" value="txt导入" />
                  <input type="button" class="btn" onclick="importByXml()" value="xml导入" />
                  <input type="button" class="btn" onclick="importByBook()" value="通讯录导入" />
                  <!-- <input type="button" class="btn" onclick="filterWrong()" value="过滤错号" /> -->
                  <!-- <input type="button" class="btn" onclick="filterDuplicate()" value="过滤重号" /> -->
                  <input type="button" class="btn" onclick="clearPhone()" value="清空" />
                </div>
                <div>
                  共有<b id="phone_count">0</b>个号码
                  <!-- 手机分<input type="text" name="" />条，小灵通分<input type="text" name="" /> 条发送。 -->
                </div>
              </td>
              <td><span class="error_phone error"><?php echo $error_phone; ?></span></td>
            </tr>
            <!-- <tr>
              <td>短信类别:</td>
              <td>
                <select name="sms_cat">
                  <option>
                    sms
                  </option>
                </select>
              </td>
            </tr> -->
            <tr>
              <td style="padding-left: 150px;" colspan="2"><input style="width:80px" type="button" onclick="sendSMS()" class="btn btn-success" value="发送" /> <span class="error_submit error"></span></td>
            </tr>
          </table>
        </div>
      </form>
    </div>

    <!-- 从txt文本导入弹出层 -->
<div class="modal hide fade" id="importTxtModal" tabindex="-1" role="dialog"  aria-hidden="true" style="display: hidden;">
      <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h3 id="group_dialog_name">从txt文本导入</h3>
      </div>
      <div class="modal-body">
          <h4 style='display: none;'></h4>
          <p class='popWindowInfo'>
            <div id="add_client_group">
                <form class="ui-dialog-content" action="index.php?route=sms/upload/txt&t=<?php echo $t; ?>" enctype="multipart/form-data" method="POST" id="import_txt_form">
                    <div id="tab-info">
                        <table class="form">
                            <tr class="left">
                                <td>上传文本</td>
                                <td>
                                    <input type="file" id="txtfile" name="txtfile" />
                                    <p id="txtstatus"></p>
                                    <span id="txterror" class="error"></span>
                                </td>
                                <td>**一行一个号码**</td>
                            </tr>
                        </table>
                    </div>
                </form>
            </div>
          </p>
      </div>
      <div class="modal-footer">
          <button class="btn HidePopWindowInfo" data-dismiss="modal" aria-hidden="true" class='cancel'>取消</button>
          <button class="btn btn-primary makesure"  onclick="uploadTxt()">上传</button>
      </div>
</div>
<div class="modal hide fade" id="importBook" tabindex="-1" role="dialog"  aria-hidden="true" style="display: hidden;">
      <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h3 id="group_dialog_name">从通讯录导入</h3>
      </div>
      <div class="modal-body">
          <h4 style='display: none;'></h4>
          <p class='popWindowInfo'>
            <div id="add_client_group">
                <form class="ui-dialog-content" enctype="multipart/form-data" id="import_book_form">
                    <div id="tab-info">
                        <table class="form">
                        </table>
                    </div>
                </form>
            </div>
          </p>
      </div>
      <div class="modal-footer">
          <button class="btn HidePopWindowInfo" data-dismiss="modal" aria-hidden="true" class='cancel'>取消</button>
          <button class="btn btn-primary makesure"  onclick="updateBook()">确定</button>
      </div>
</div>
<div class="modal hide fade" id="successTip" role="dialog"  aria-hidden="true">
      <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h3 id="group_dialog_name">发送成功</h3>
      </div>
      <div class="modal-body">
          <h4 style='display: none;'></h4>
          <p class='popWindowInfo'>
            <div id="add_client_group">
              <h2 class="success_message" style="color:red;"></h2>
            </div>
          </p>
      </div>
      <div class="modal-footer">
          <button class="btn HidePopWindowInfo" data-dismiss="modal" aria-hidden="true" class='cancel' onclick="document.location.href='/index.php?route=sms/outbox&t=<?php echo $t; ?>';">跳到发件箱</button>
          <button class="btn btn-primary makesure"  onclick="document.location.reload();">返回</button>
      </div>
</div>
<script type="text/javascript" src="static/js/jquery.form.js"></script>
    <script type="text/javascript">
      function countMessage(that){
        var length=$(that).val().length;
        var multi=1;
        if(length>70){
        	multi=1+Math.ceil((length-70)/65);
        }
        $(".word_count").html(length);
        $(".send_count").html(multi);
      }
      function clearPhone(){
        $('#phonelist').val('');
      }
      function importTxt(){
        $('#importTxtModal').modal();
      }
      function uploadTxt(){
        $("#import_txt_form").ajaxSubmit({
          url:"index.php?route=sms/upload/txt&t=<?php echo $t; ?>",
          data:{},
          type:'POST',
          dataType:'json',
          beforeSend:function(){
            $('#txtstatus').html('正在上传……');
          },
          success:function(res){
            $('#txtstatus').html('');
            if(res.status==1){
              $('#txterror').html('');
              $('#txtstatus').html('共有'+res.total+'条数据,'+res.avaiable+"有效,"+res.unavaiable+"无效");
              if(res.values){
                for (var i = res.values.length - 1; i >= 0; i--) {
                  $("#phonelist").val($("#phonelist").val()+res.values[i]+"\n");
                };
                $("#phonelist").trigger('change');
                $('#importTxtModal').modal('hide');
              }
            }else if(res.status==-1){
              $('#txterror').html(res.error);
            }
          },
          error:function(xhr){
            $('#txterror').html(xhr.responseText);
          }
        });
      }

      function importByBook(){
        $('#importBook').modal();
        $.ajax({
          url:"index.php?route=sms/ajax/addressbook&t=<?php echo $t; ?>",
          type:'GET',
          dataType:"json",
          success:function(res){
            if(res.length){
                var tr='<tr><td><input type="checkbox" onclick=\'$("input[name*=book]").attr("checked", this.checked);\' />全选</td></tr>';
                for (var i = res.length - 1; i >= 0; i--) {
                  console.log(res[i]);
                  tr+="<tr>";
                  tr+='<td><input type="checkbox" name="book[]" value="'+res[i].phone+'" /></td>';
                  tr+='<td>'+res[i].name+'</td>';
                  tr+='<td>'+res[i].phone+'</td>';
                  tr+='</tr>';
                };
                $('#import_book_form table').html(tr);
            }
          }
        })
      }
      function updateBook(){
        $("#import_book_form input:checkbox[name*=book][checked]").each(function(i,e){
            $("#phonelist").val($("#phonelist").val()+$(e).val()+"\n");
        });
        $('#importBook').modal('hide');
      }
      function filterWrong(){
        var phonelist=$("#phonelist").val();
        var list=phonelist.split('\n');
        var length=list.length,success='';
        for (var i =0; i <length; i++) {
          if(/^1\d{10}$/.test(list[i])){
            success+=list[i]+'\n';
          }
        }
        $("#phonelist").val(success);
      }
      function filterDuplicate(){
        var phonelist=$("#phonelist").val();
        var list=phonelist.split('\n');
        var newlist=ov2(list);
        var length=newlist.length;
        $("#phonelist").val(newlist.join('\n'));
        $('#phone_count').html(length);
      }
      function ov2(a) {
        var b = [], n = a.length, i, j;
        for (i = 0; i < n; i++) {
            for (j = i + 1; j < n; j++)
                if (a[i] === a[j]){j=false;break;}
            if(j)b.push(a[i]);
        }
        return b;
      }
      function countPhone(){
        var phonelist=$("#phonelist").val();
        var list=phonelist.split('\n');
        var length=0;
        for (var i = list.length - 1; i >= 0; i--) {
          if(list[i].length){
            length+=1;
          }
        };
        $("#phone_count").html(length);
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

      function sendSMS(){
        $.ajax({
          url: 'index.php?route=sms/send&t=<?php echo $t; ?>',
          type: 'POST',
          dataType: 'json',
          data: $("#form").serialize(),
          beforeSend:function(){
            $("#form").find('span.error').html('');
          },
          success:function(data){
            if(data.ret==1){
              $(".success_message").html(data.message);
              alert(data.message);
              document.location.reload();
              // $("#successTip").modal();
            }else if(data.ret==-1){
              if(data.errors){
                for(error in data.errors){
                  $("."+error).html(data.errors[error]);
                }
                $(".error_submit").html('请检查错误再提交');
              }
            }
          }
        })
      }
    </script>

    </div>
    </div>
</div>
</div>
<?php echo $footer; ?>
