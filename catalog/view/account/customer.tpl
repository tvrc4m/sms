<div class="content-form">
<div class="row-fluid">
    <div class="span12">
        <div class="widget_wrapper">
            <div class="widget_content no-padding">
                <form id="customer_form">
                    <div id="tab-info">
                        <table class="form">
                            <tbody><tr class="left">
                                <td>用户名</td>
                                <td><input type="text" name="name" value="<?php echo $customer['name']; ?>" />
                                <span id="error_name" class="error"></span>
                                </td>
                            </tr>
                            <tr class="left">
                                <td>邮箱</td>
                                <td><input type="text" name="email" value="<?php echo $customer['email']; ?>" />
                                    <span id="error_email" class="error"></span>
                                </td>
                            </tr>
                            <tr class="left">
                                <td>电话</td>
                                <td><input type="text" name="phone" value="<?php echo $customer['phone']; ?>" />
                                    <span id="error_phone" class="error"></span>
                                </td>
                            </tr>
                            <tr class="left">
                                <td><input type="button" class="btn" onclick="save()" value="确认" /></td>
                                <td></td>
                            </tr>
                        </tbody></table>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
<script type="text/javascript">
    function save(){
        $.ajax({
            url:'index.php?route=account/customer/save&t=<?php echo $this->session->data["t"]; ?>',
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
                    $(".success").html('修改成功!').show();
                }
            }
        })
    }
</script>