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
                              <td class="left"><?php if ($sort == 'username') { ?>
                                <a href="<?php echo $sort_username; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_username; ?></a>
                                <?php } else { ?>
                                <a href="<?php echo $sort_username; ?>"><?php echo $column_username; ?></a>
                                <?php } ?></td>
                              <td class="left"><?php if ($sort == 'status') { ?>
                                <a href="<?php echo $sort_status; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_status; ?></a>
                                <?php } else { ?>
                                <a href="<?php echo $sort_status; ?>"><?php echo $column_status; ?></a>
                                <?php } ?></td>
                              <td class="left">
                                <?php if ($sort == 'date_added') { ?>
                                  <a href="<?php echo $sort_date_added; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_date_added; ?></a>
                                <?php } else { ?>
                                  <a href="<?php echo $sort_date_added; ?>"><?php echo $column_date_added; ?></a>
                                <?php } ?></td>
                              <td class="right"><?php echo $column_action; ?></td>
                            </tr>
                          </thead>
                          <tbody>
                            <?php if ($users) { ?>
                              <?php foreach ($users as $user) { ?>
                                <tr>
                                  <td style="text-align: center;">
                                    <?php if ($user['selected']) { ?>
                                      <input type="checkbox" name="selected[]" value="<?php echo $user['user_id']; ?>" checked="checked" />
                                    <?php } else { ?>
                                      <input type="checkbox" name="selected[]" value="<?php echo $user['user_id']; ?>" />
                                    <?php } ?></td>
                                  <td class="left"><?php echo $user['username']; ?></td>
                                  <td class="left"><?php echo $user['status']; ?></td>
                                  <td class="left"><?php echo $user['date_added']; ?></td>
                                  <td class="right"><?php foreach ($user['action'] as $action) { ?>
                                    [ <a href="<?php echo $action['href']; ?>"><?php echo $action['text']; ?></a> ]
                                    <?php } ?></td>
                                </tr>
                              <?php } ?>
                            <?php } else { ?>
                              <tr>
                                <td class="center" colspan="5"><?php echo $text_no_results; ?></td>
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
