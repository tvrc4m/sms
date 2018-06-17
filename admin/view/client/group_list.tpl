<div class="content-form">
<div class="row-fluid">
    <div class="span12">
        <div class="widget_wrapper">
            <div class="widget_content no-padding">
                <form action="" method="post" enctype="multipart/form-data" id="form">
                    <table width="100%" cellspacing="0" cellpadding="0" class="default_table">
                        <thead>
                        <tr>
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
                            <td class="center"><input type="text" style="width:80%" name="filter_name" value="<?php echo $filter_name; ?>" /></td>
                            <td class="center"><input type="text" style="width:80%" name="filter_remark" value="<?php echo $filter_remark; ?>" /></td>
                            <td class="center"></td>
                            <td class="center"></td>
                            <td class="center"><a onclick="filterGroup();" class="btn">筛选</a></td>
                        </tr>
                        <?php if (!empty($groups)) { ?>
                        <?php foreach ($groups as $group) { ?>
                        <tr>
                            <td class="center"><?php echo $group['client_group_id']; ?></td>
                            <td class="center"><?php echo $group['name']; ?></td>
                            <td class="center"><?php echo $group['remark']; ?></td>
                            
                            <td class="center"><a href="javascript:void(0);" onclick="sendSmsInGroup()">发短信</a></td>
                            <td class="center">
                                <a groupid="<?php  echo $group['client_group_id']; ?>" onclick="delGroup(this)" href="javascript:void(0);">删除</a>
                                <a groupid="<?php  echo $group['client_group_id']; ?>" onclick="editGroup(this)" href="javascript:void(0);">编辑</a>
                            </td>
                            <td class="center"></td>
                        </tr>
                        <?php } ?>
                        <?php } else { ?>
                        <tr>
                            <td class="center" colspan="7">还没有创建群组</td>
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
        url = 'index.php?route=client/group&token=<?php echo $this->session->data["token"]; ?>';
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
    function sendSmsInGroup(){

    }
</script>