<?php echo $header; ?>
<div class="contents">
    <div class="warning hide"></div>
    <div class="success hide"></div>
    <div class="separator">
        <span></span>
    </div>
    <div class="widget leftTabs">
        <div class="margin" style="position:absolute; margin-top:-34px; right:10px;">
        </div>
        <div class="tab_container" style="min-height: 1000px;">
            <div class="form-content">
                <div class="content-form">

                    <div class="row-fluid">
                        <div class="span12">
                            <div class="widget_wrapper">
                                <div class="widget_content no-padding">
                                    <form action="" method="post" enctype="multipart/form-data" id="form">
                                         <table width="100%" cellspacing="0" cellpadding="0" class="outbox default_table">
                                            <thead>
                                                <tr>
                                                    <td class="center" style="width:13%">操作时间</td>
                                                    <td class="center" style="width:8%">短信类别</td>
                                                    <td class="center" style="width:8%">发送条数</td>
                                                    <td class="center" style="width:8%">状态</td>
                                                    <td class="center" style="width:10%">发送设置</td>
                                                    <td class="center" style="width:13%">发送时间</td>
                                                    <td class="center" style="width:15%">内容</td>
                                                    <td class="center" style="width:13%">操作</td>
                                                    <!-- <td class="right" style="width:10%">操作</td> -->
                                                </tr>
                                            </thead>
                                            <tbody>
                                                
                                                <?php if (!empty($outbox)) { ?>
                                                <?php foreach ($outbox as $box) { ?>
                                                <tr>
                                                    <td>
                                                        <?php echo $box['added_time']; ?>
                                                    </td>
                                                    <td>
                                                        发送短信
                                                    </td>
                                                    <td attr="<?php echo $box['count']; ?>">
                                                        <?php echo $box['count']; ?>
                                                    </td>
                                                    <td>
                                                        发送成功
                                                    </td>
                                                    <td>
                                                        <?php echo $box['is_timer']==1?'定时发送':'立即发送'; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $box['added_time']; ?>
                                                    </td>
                                                    <td class="center" style="overflow:hidden" title="<?php echo $box['message']; ?>">
                                                        <?php echo $box['message']; ?>
                                                    </td>
                                                    <td class="center" list="<?php echo $box['phones']; ?>">
				                                        <a href="<?php echo $box['download']; ?>">下载</a>
                                                    </td>
                                                </tr>
                                                <?php } ?>
                                                <?php } else { ?>
                                                <tr>
                                                    <td class="center" colspan="7">没有创建客户</td>
                                                </tr>
                                                <?php } ?></tbody>
                                        </table>
                                    </form>
                                    <div class="pagination">
                                        <?php echo $pagination; ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <script type="text/javascript"></script>

        </div>
    </div>
</div>
</div>
<div class="modal hide fade" id="viewPhone" tabindex="-1" role="dialog"  aria-hidden="true" style="display: hidden;">
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
          <button class="btn btn-primary makesure"  onclick="copyPhone(this)">确定</button>
      </div>
</div>
<script type="text/javascript" src="static/js/jquery.zclip.min.js"></script>
<script type="text/javascript">
    function viewPhoneList(that){
        var list=$(that).parent('td').attr('list');
        list=list.replace(/,/g,"\n");
        $("#view_phone_list textarea").val(list);
        $("#viewPhone").modal();
    }
    $("a.copy_phone").click(function(){

    })
    $("a.copy_phone").zclip({
        copy: function(){
                // var list=
                return list.replace(/,/g,"\n");
            }
    });
    function copyPhone(that){
        $(that).zclip({
            copy: function(){
                // var list=
                // console.log(list);
                return list.replace(/,/g,"\n");
            }
        });
    }
</script>
<?php echo $footer; ?>