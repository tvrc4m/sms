<?php echo $header; ?>
<div class="contents">
    <div class="warning hide"></div>
    <div class="success hide"></div>
    <div class="separator">
        <span></span>
    </div>
    <div class="widget leftTabs">
        <ul class="tabs roomSource-tab">
            <li class="<?php if($user){echo $user; }?>">
                <a href="<?php echo $user_action; ?>">后台用户</a>
            </li>
            <li class="<?php if($group){echo $group; }?>">
                <a href="<?php echo $group_action; ?>">后台群组</a>
            </li>
        </ul>
        <div class="tab_container" style="min-height: 1000px;">
            <div class="margin" style="position:absolute; margin-top:-44px; right:10px;">
                <a href="<?php echo $insert; ?>" class="btn btn-success">新建</a>
                <a onclick="$('form').submit();" class="btn btn-success">删除</a>
            </div>
            <div class="form-content">
                <div class="row-fluid">
                    <div class="span12">
                        <div class="widget_wrapper">
                          <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form">
                            <table class="list">
                              <thead>
                                <tr>
                                  <td width="1" style="text-align: center;"><input type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);" /></td>
                                  <td class="left">
                                    <?php if ($sort == 'name') { ?>
                                      <a href="<?php echo $sort_name; ?>" class="<?php echo strtolower($order); ?>">组名</a>
                                    <?php } else { ?>
                                      <a href="<?php echo $sort_name; ?>"><?php echo $column_name; ?></a>
                                    <?php } ?></td>
                                  <td class="right"><?php echo $column_action; ?></td>
                                </tr>
                              </thead>
                              <tbody>
                                <?php if ($user_groups) { ?>
                                  <?php foreach ($user_groups as $user_group) { ?>
                                    <tr>
                                      <td style="text-align: center;"><?php if ($user_group['selected']) { ?>
                                        <input type="checkbox" name="selected[]" value="<?php echo $user_group['user_group_id']; ?>" checked="checked" />
                                        <?php } else { ?>
                                        <input type="checkbox" name="selected[]" value="<?php echo $user_group['user_group_id']; ?>" />
                                        <?php } ?></td>
                                      <td class="left"><?php echo $user_group['name']; ?></td>
                                      <td class="right"><?php foreach ($user_group['action'] as $action) { ?>
                                        [ <a href="<?php echo $action['href']; ?>"><?php echo $action['text']; ?></a> ]
                                        <?php } ?></td>
                                    </tr>
                                  <?php } ?>
                                <?php } else { ?>
                                  <tr>
                                    <td class="center" colspan="3"><?php echo $text_no_results; ?></td>
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
    </div>
</div>

<?php echo $footer; ?>

