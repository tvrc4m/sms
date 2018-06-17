<div class="content-form">
    <div class="row-fluid">
        <div class="span12">
        <div class="margin" style="position:absolute; margin-top:-44px; right:10px;">
                <a class="btn btn-success" onclick="hideApi(this)" href="javascript:void(0);">
                    <input type='checkbox' <?php if(!$filter_api) echo 'checked'; ?> />显示通过接口发送的短信
                </a>
            </div>
            <div class="widget_wrapper">

                <div class="tab_container" style="min-height: 1000px;">
            
                <div class="widget_content no-padding">

                    <form action="" method="post" enctype="multipart/form-data" id="form">
                        <input type="hidden" name="filter_api" value="1" />
                        <div class="row-fluid">
                            
                        </div>
                        <table width="100%" cellspacing="0" cellpadding="0" class="outbox default_table">
                            <thead>
                                <tr>
                                    <td class="center" style="width:5%">
                                        <input type="checkbox" onclick='$("input:checkbox[name*=box]").attr("checked", this.checked);' />
                                    </td>
                                    <td class="center" style="width:12%">操作时间</td>
                                    <td class="center" style="width:8%">短信类别</td>
                                    <td class="center" style="width:8%">发送条数</td>
                                    <td class="center" style="width:8%">状态</td>
                                    <td class="center" style="width:10%">发送设置</td>
                                    <td class="center" style="width:12%">发送时间</td>
                                    <td class="center" style="width:15%">内容</td>
                                    <td class="right" style="width:12%">操作</td>
                                    <td class="right" style="width:10%">筛选</td>
                                </tr>
                                <tr class="filter">
                                    <td class="center"></td>
                                    <td class="center">
                                        <input type="text" style="width:80%" name="filter_time" value="<?php echo $filter_time; ?>" />
                                    </td>
                                    <td class="center"></td>
                                    <td class="center"></td>
                                    <td class="center">
                                        <select name="filter_status">
                                            <option>--状态--</option>
                                            <option value="1">等待发送</option>
                                            <option value="2">正在发送</option>
                                            <option value="3">发送成功</option>
                                            <option value="4">发送失败</option>
                                            <option value="5">取消发送</option>
                                        </select>
                                    </td>
                                    </td>
                                    <td class="center">
                                        <input type="text" style="width:80%" name="filter_timer" value="<?php echo $filter_timer; ?>" />
                                    </td>
                                    <td class="center">
                                        <input type="text" style="width:80%" name="filter_send" value="<?php echo $filter_send; ?>" />
                                    </td>
                                    <td class="center">
                                        <input type="text" style="width:80%" name="filter_message" value="<?php echo $filter_message; ?>" />
                                    </td>
                                    </td>
                                    <td class="center"></td>
                                    <td class="center">
                                        <a class="btn" href="javascript:void(0);" onclick="filterOutbox()">筛选</a>
                                    </td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($outbox)) { ?>
                                <?php foreach ($outbox as $box) { ?>
                                <tr>
                                    <td class="center">
                                        <input type="checkbox" name="box[]" value="<?php echo $box['sms_id']; ?>" />
                                    </td>
                                    <td>
                                        <?php echo $box[ 'added_time']; ?>
                                    </td>
                                    <td>
                                        发送短信
                                    </td>
                                    <td>
                                        <?php echo $box[ 'count']; ?>
                                    </td>
                                    <td>
                                        <?php echo $status[$box[ 'status']]; ?>
                                    </td>
                                    <td>
                                        <?php echo $box[ 'is_timer']==1? '定时发送': '立即发送'; ?>
                                    </td>
                                    <td>
                                        <?php echo $box[ 'is_timer']==1?date( 'Y-m-d H:i:s',$box[ 'timer']):$box[ 'added_time']; ?>
                                    </td>
                                    <td class="center" style="overflow:hidden" title="<?php echo $box['message']; ?>">
                                        <?php echo $box[ 'message']; ?>
                                    </td>
                                    <td class="center" list="<?php echo $box['phones']; ?>">
                                        <a href="<?php echo $box['download']; ?>">下载</a>
                                        <a class="copy_phone">复制</a>
                                        <a onclick="viewPhoneList(this)">查看</a>
                                    </td>
                                    <td class="center">
                                        <?php if($box[ 'status']==1 || $box[ 'status']==2){ ?>
                                        <a onclick="editbox(this,<?php  echo $box['sms_id']; ?>)" href="javascript:void(0);">取消发送</a>
                                        <?php } ?>
                                        <a onclick="delbox(this,<?php  echo $box['sms_id']; ?>)" href="javascript:void(0);">删除</a>
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
                    <div class="pagination">
                        <?php echo $pagination; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal hide fade" id="viewPhone" tabindex="-1" role="dialog" aria-hidden="true" style="display: hidden;">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="group_dialog_name">查看发送电话列表</h3>
    </div>
    <div class="modal-body">
        <h4 style='display: none;'></h4>
        <p class='popWindowInfo'>
            <div id="add_client_group">
                <form class="ui-dialog-content" enctype="multipart/form-data" id="view_phone_list">
                    <div id="tab-info">
                        <textarea style="width: 100%;height: auto;min-height: 300px;"></textarea>
                    </div>
                </form>
            </div>
        </p>
    </div>
    <div class="modal-footer">
        <button class="btn HidePopWindowInfo" data-dismiss="modal" aria-hidden="true" class='cancel'>取消</button>
        <button class="btn btn-primary makesure" onclick="updateBook()">确定</button>
    </div>
</div>
<script type="text/javascript" src="/static/js/jquery.zclip.min.js"></script>
<script type="text/javascript">
function filterOutbox() {
    url = 'index.php?route=sms/outbox&token=<?php echo $this->session->data["token"]; ?>';
    var filter_name = $('input[name=\'filter_name\']').val();
    if (filter_name) {
        url += '&filter_name=' + encodeURIComponent(filter_name);
    }
    var filter_client = $('input[name=\'filter_client\']').val();
    if (filter_client) {
        url += '&filter_client=' + encodeURIComponent(filter_client);
    }
    var filter_phone = $('input[name=\'filter_phone\']').val();
    if (filter_phone) {
        url += '&filter_phone=' + encodeURIComponent(filter_phone);
    }
    var filter_status = $('input[name=\'filter_status\'] option:selected').val();
    if (filter_status) {
        url += '&filter_status=' + encodeURIComponent(filter_status);
    }
    var filter_api = $('input[name=\'filter_api\']').val();
    url += '&filter_api=' + filter_api;
    var filter_message = $('input[name=\'filter_message\']').val();

    if (filter_message) {
        url += '&filter_message=' + encodeURIComponent(filter_message);
    }
    $(".form-content").load(url);
}

function viewPhoneList(that) {
    var list = $(that).parent('td').attr('list');
    list = list.replace(/,/g, "\n");
    $("#view_phone_list textarea").val(list);
    $("#viewPhone").modal();
}

function hideApi(that){
    $(that).find('input:checkbox').attr('checked',!$(that).find('input:checkbox').attr('checked'));
    var checked=$(that).find('input:checkbox').attr('checked');
    console.log(checked);
    if(checked){
        $("input[name=filter_api]").val(0);
    }else{
        $("input[name=filter_api]").val(1);
    }
    filterOutbox();
}

$(".pagination").on('click', 'a', function() {
    loadListInfo($(this).attr('link'));
    return false;
});

$(".pagination a").each(function(i, e) {
    $(e).attr('link', $(e).attr('href')).attr('href', 'javascript:void(0);');
});

$(document).ready(function() {
    $(".copy_phone").zclip({
        path: "static/js/ZeroClipboard.swf",
        copy: function() {
            console.log(343434);
            var list = $(this).parent('td').attr('list');
            console.log(list);
            return list.replace(/,/g, "\n");
        },
        beforeCopy: function() { /* 按住鼠标时的操作 */
            $(this).css("color", "orange");
        },
        afterCopy: function() { /* 复制成功后的操作 */
            var $copysuc = $("<div class='copy-tips'><div class='copy-tips-wrap'>☺ 复制成功</div></div>");
            $("body").find(".copy-tips").remove().end().append($copysuc);
            $(".copy-tips").fadeOut(3000);
        }
    });

});
</script>
