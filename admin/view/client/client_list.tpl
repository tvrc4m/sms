<div class="content-form">
<div class="row-fluid">
    <div class="span12">
        <div class="widget_wrapper">
            <div class="widget_content no-padding">
                <form action="" method="post" enctype="multipart/form-data" id="form">
                    <table width="100%" cellspacing="0" cellpadding="0" class="default_table">
                        <thead>
                        <tr>
                            <td class="center" style="width:5%">客户ID</td>
                            <td class="center" style="width:15%">客户名称</td>
                            <td class="center" style="width:15%">电话</td>
                            <td class="center" style="width:15%">邮箱</td>
                            <td class="center" style="width:10%">性别</td>
                            <td class="center" style="width:10%">发送短信</td>
                            <td class="right" style="width:15%">操作</td>
                            <td class="right" style="width:20%">筛选</td>
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="filter">
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
                                <td class="center"><?php echo $client['client_id']; ?></td>
                                <td class="center"><?php echo $client['name']; ?></td>
                                <td class="center"><?php echo $client['phone']; ?></td>
                                <td class="center"><?php echo $client['email']; ?></td>
                                <td><?php if($client['sex']==2){echo '男';}else{echo '女';} ?></td>
                                <td class="center"><a href="javascript:void(0);" onclick="sendSms()">发短信</a></td>
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
<script type="text/javascript">
    function filterGroup(){
        url = 'index.php?route=client/client/getList&token=<?php echo $this->session->data["token"]; ?>';
        var filter_name = $('input[name=\'filter_name\']').attr('value');
        if (filter_name) {
            url += '&filter_name=' + encodeURIComponent(filter_name);
        }
        var filter_phone = $('input[name=\'filter_phone\']').attr('value');
        if (filter_phone) {
            url += '&filter_phone=' + encodeURIComponent(filter_phone);
        }
        var filter_sex = $('input[name=\'filter_sex\']').attr('value');
        if (filter_sex) {
            url += '&filter_name=' + encodeURIComponent(filter_sex);
        }
        var filter_remark = $('input[name=\'filter_remark\']').attr('value');
        
        if (filter_remark) {
            url += '&filter_remark=' + encodeURIComponent(filter_remark);
        }
        $(".form-content").load(url);
    }

</script>