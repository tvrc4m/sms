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
          <a onclick="$('#form').submit();" class="btn btn-success"><?php echo $button_save; ?></a>
          <a href="<?php echo $cancel; ?>" class="btn btn-success"><?php echo $button_cancel; ?></a>
      </div>
      <div class="form-content">
        <div class="row-fluid">
          <div class="span12">
            <div class="widget_wrapper">
              <form action="<?php echo $action; ?>
                " method="post" enctype="multipart/form-data" id="form">
                <table class="default_table">
                  <tr>
                    <td>
                      <span class="required">*</span>
                      <?php echo $entry_name; ?></td>
                    <td>
                      <input type="text" name="name" value="<?php echo $name; ?>" />
                      <?php if ($error_name) { ?>
                        <span class="error"><?php echo $error_name; ?></span>
                      <?php  } ?></td>
                  </tr>
                  <tr>
                    <td>
                      <?php echo $entry_access; ?></td>
                    <td>
                      <div class="scrollbox">
                        <?php $class = 'odd'; ?>
                        <?php foreach ($permissions as $permission) { ?>
                        <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
                        <div class="<?php echo $class; ?>">
                          <?php if (in_array($permission, $access)) { ?>
                          <input type="checkbox" name="permission[access][]" value="<?php echo $permission; ?>" checked="checked" />
                          <?php echo $permission; ?>
                          <?php } else { ?>
                          <input type="checkbox" name="permission[access][]" value="<?php echo $permission; ?>" />
                          <?php echo $permission; ?>
                          <?php } ?></div>
                        <?php } ?></div>
                      <a onclick="$(this).parent().find(':checkbox').attr('checked', true);">
                        <?php echo $text_select_all; ?></a>
                      /
                      <a onclick="$(this).parent().find(':checkbox').attr('checked', false);">
                        <?php echo $text_unselect_all; ?></a>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <?php echo $entry_modify; ?></td>
                    <td>
                      <div class="scrollbox">
                        <?php $class = 'odd'; ?>
                        <?php foreach ($permissions as $permission) { ?>
                        <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
                        <div class="<?php echo $class; ?>">
                          <?php if (in_array($permission, $modify)) { ?>
                          <input type="checkbox" name="permission[modify][]" value="<?php echo $permission; ?>" checked="checked" />
                          <?php echo $permission; ?>
                          <?php } else { ?>
                          <input type="checkbox" name="permission[modify][]" value="<?php echo $permission; ?>" />
                          <?php echo $permission; ?>
                          <?php } ?></div>
                        <?php } ?></div>
                      <a onclick="$(this).parent().find(':checkbox').attr('checked', true);">
                        <?php echo $text_select_all; ?></a>
                      /
                      <a onclick="$(this).parent().find(':checkbox').attr('checked', false);">
                        <?php echo $text_unselect_all; ?></a>
                    </td>
                  </tr>
                </table>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php echo $footer; ?>