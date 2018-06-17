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
            <div class="form-content">
              <div class="margin" style="position:absolute; margin-top:-44px; right:10px;">
                <a onclick="$('#form').submit();" class="btn btn-success"><?php echo $button_save; ?></a>
                <a href="<?php echo $cancel; ?>" class="btn btn-info"><?php echo $button_cancel; ?></a>
              </div>
              <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
                <table class="form">
                  <tr>
                    <td><span class="required">*</span> <?php echo $entry_username; ?></td>
                    <td><input type="text" name="username" value="<?php echo $username; ?>" />
                      <?php if ($error_username) { ?>
                      <span class="error"><?php echo $error_username; ?></span>
                      <?php } ?></td>
                  </tr>
                  <tr>
                    <td><?php echo $entry_email; ?></td>
                    <td><input type="text" name="email" value="<?php echo $email; ?>" /></td>
                  </tr>
                  <tr>
                    <td><?php echo $entry_user_group; ?></td>
                    <td><select name="user_group_id">
                        <?php foreach ($user_groups as $user_group) { ?>
                        <?php if ($user_group['user_group_id'] == $user_group_id) { ?>
                        <option value="<?php echo $user_group['user_group_id']; ?>" selected="selected"><?php echo $user_group['name']; ?></option>
                        <?php } else { ?>
                        <option value="<?php echo $user_group['user_group_id']; ?>"><?php echo $user_group['name']; ?></option>
                        <?php } ?>
                        <?php } ?>
                      </select></td>
                  </tr>
                  <tr>
                    <td><?php echo $entry_password; ?></td>
                    <td><input type="password" name="password" value="<?php echo $password; ?>"  />
                      <?php if ($error_password) { ?>
                      <span class="error"><?php echo $error_password; ?></span>
                      <?php  } ?></td>
                  </tr>
                  <tr>
                    <td><?php echo $entry_confirm; ?></td>
                    <td><input type="password" name="confirm" value="<?php echo $confirm; ?>" />
                      <?php if ($error_confirm) { ?>
                      <span class="error"><?php echo $error_confirm; ?></span>
                      <?php  } ?></td>
                  </tr>
                  <tr>
                    <td><?php echo $entry_status; ?></td>
                    <td><select name="status">
                        <?php if ($status) { ?>
                        <option value="0"><?php echo $text_disabled; ?></option>
                        <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                        <?php } else { ?>
                        <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                        <option value="1"><?php echo $text_enabled; ?></option>
                        <?php } ?>
                      </select></td>
                  </tr>
                </table>
              </form>
            </div>
        </div>
    </div>
</div>

<?php echo $footer; ?>