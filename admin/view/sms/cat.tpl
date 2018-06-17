<div class="row-fluid">
    <div class="span12">

        <div class="widget_wrapper">

            <div class="widget_content no-padding">
                <div class="pull-left content_actions" style="margin:10px 6px;">
                    <a onclick="addNew();" class="btn">增加类别</a>
                </div>
                <form action="" method="post" enctype="multipart/form-data" id="form">
                    <table width="100%" cellspacing="0" cellpadding="0" class="default_table">
                        <thead>
                            <tr>
                                <td class="center" style="width:8%">类别名称</td>
                                <td class="center" style="width:20%">类别描述</td>
                                <td class="center" style="width:12%">操作</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($cats as $cat) { ?>
                            <tr>
                                <td class="center">
                                    <?php echo $cat['name']; ?></td>
                                <td class="center">
                                    <?php echo $cat['description']; ?></td>
                                <td class="center">
                                    <a>编辑</a>
                                    <a>删除</a>
                                </td>
                            </tr>
                            <?php } ?></tbody>
                    </table>
                </form>
            </div>

        </div>
    </div>
</div>
<div class="modal hide" id="catModal" tabindex="-1" role="dialog"  aria-hidden="true" style="display: hidden;">
      <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h3 id="group_dialog_name">新增短信类别</h3>
      </div>
      <div class="modal-body">
          <h4 style='display: none;'></h4>
          <p class='popWindowInfo'>
            <div id="add_client_group">
                <form class="ui-dialog-content" id="cat_form">
                    <div id="tab-info">
                        <table class="form">
                            <tr class="left">
                                <td>类别名称</td>
                                <td>
                                    <input type="text" name="name" id="name" />
                                    <span class="error"></span>
                                </td>
                            </tr>
                            <tr class="left">
                                <td>短信类别</td>
                                <td>
                                    <select name="sms_cat" id="sms_cat">
                                        <?php foreach($sms_cats as $cat){ ?>
                                            <option value="<?php echo $cat['sms_cat_id']; ?>"><?php echo $cat['name']; ?>（<?php echo $cat['count']; ?>条）</option>
                                        <?php } ?>
                                    </select>
                                </td>
                            </tr>
                            <tr class="left">
                                <td>描述</td>
                                <td>
                                    <textarea name="desc" id="desc" style="width:200px;height:120px;"></textarea>
                                    <span class="error"></span>
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
          <button class="btn btn-primary makesure"  onclick="updateClientGroup()">发送</button>
      </div>
</div>
<script type="text/javascript">
    function addNew(){
        $("#catModal").modal();
    }
</script>