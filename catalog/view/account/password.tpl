 <div class="widget_wrapper">
     <form action="<?php echo $update_storeinfo; ?>
         " method="post" enctype="multipart/form-data" id="customer_form">
         <div id="tab-info">
             <table class="form">
                 <tr class="left">
                     <td>旧密码</td>
                     <td >
                         <input type="password" name="old" value="" />
                         <span id="error_old" class="error"></span>
                         </td>
                 </tr>
                 <tr class="left">
                     <td>新密码</td>
                     <td>
                         <input type="password" name="new" value="" />
                         <span id="error_new" class="error"></span>
                         </td>
                 </tr>
                 <tr class="left">
                     <td>确认新密码</td>
                     <td>
                         <input type="password" name="newtwo" value="" />
                         <span id="error_newtwo" class="error"></span>
                         </td>
                 </tr>
                 <tr class="left">
                     <td >
                         <input type="button" class="btn" onclick="change()"  value="确认" /> 
                     </td>
                 </tr>
             </table>
         </div>
     </form>
 </div>
<script type="text/javascript">
    function change(){
        $.ajax({
            url:'index.php?route=account/password/change&t=<?php echo $this->session->data["t"]; ?>',
            type:'POST',
            dataType:'json',
            data:$("#customer_form input"),
            success:function(res){
                $('.error').html('');
                if(res.ret==-1){
                    for(error in res.errors){
                        $('#'+error).html(res.errors[error]);
                    }
                }else{
                    location.href=res.redirect;
                }
            }
        })
    }
</script>