<style>
    .error{
        display:inline;
        margin-left:20px;
    }
</style>
<div class="contents">
  <?php if ($error_warning) { ?>
  <div class="warning"><?php echo $error_warning; ?></div>
  <?php } ?>
    <div class="contents">
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
          <table class="form">
            <tr>
                <td class="left"><span class="required">*</span> 组名</td>
                <td>
                     <input class='order_date' type="text" name="name" value="<?php echo $name; ?>" />
                </td>
            </tr>
          </table>
      </form>
    </div>

</div>

<script type="text/javascript">

</script>
