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
                <td class="left"><span class="required">*</span> 姓名</td>
                <td>
                     <input class='order_date' type="text" name="name" value="<?php echo $name; ?>" />
                </td>
            </tr>
            <tr>
                <td class="left">所属组</td>
                <td>
                    <select name="status">
                        <?php foreach($groups as $group) { ?>
                            <?php if($group_id == $group['client_group_id']) { ?>
                                <option value="<?php echo $group['client_group_id']; ?>" selected="selected"><?php echo $group['name']; ?></option>
                            <?php }else{ ?>
                                <option value="<?php echo $group['client_group_id']; ?>"><?php echo $group['name']; ?></option>
                            <?php } ?>
                        <?php } ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td style="width: 80px"><span class="required">*</span> 手机号</td>
                <td>
                    <input class='order_date' type="text" name="phone" value="<?php echo $phone; ?>" />
                </td>
            </tr>
          </table>
      </form>
    </div>

</div>

<script type="text/javascript">

    var counter = <?php echo $counter; ?>;

    $(function(){

        $("input[name='order_date']").datepicker({
            dateFormat: 'yy-mm-dd'
        });

        $("input[name='lodge_period_start_date']").datepicker({
            dateFormat: 'yy-mm-dd'
        });

        $("input[name='lodge_period_end_date']").datepicker({
            dateFormat: 'yy-mm-dd'
        });

        $("select[name='platform_id']").change(function(){

            $("select[name='platform_channel_id']").attr('disabled',true);
            $("#platform_channel_loading").show();

            var url = 'index.php?route=sale/order/getPlatformChannelsByPlatformID&t=<?php echo $t; ?>';
            var platform_id = $(this).val();

            $.get(url, {platform_id: platform_id}, function(json) {

                var html = "<option value='none'> --- 请选择 --- </option>";
                var length = json.length;
                if(length > 0) {
                    for(var i=0;i<length;i++) {
                        html += "<option value="+json[i].platform_channel_id+">"+json[i].name+"</option>";
                    }
                }
                $("select[name='platform_channel_id']").html(html);

                $("select[name='platform_channel_id']").attr('disabled',false);
                $("#platform_channel_loading").hide();

            }, 'json');

        });

        $("select[name='lodge_building_id']").change(function(){

            $("select[name='room_type_id']").attr('disabled',true);
            $("#room_type_loading").show();

            var url = 'index.php?route=sale/order/getRoomTypesByBuildingID&t=<?php echo $t; ?>';
            var building_id = $(this).val();

            $.get(url, {building_id: building_id}, function(json) {

                var html = "<option value='none'> --- 请选择 --- </option>";
                var length = json.length;
                if(length > 0) {
                    for(var i=0;i<length;i++) {
                        html += "<option value="+json[i].room_type_id+">"+json[i].name+"</option>";
                    }
                }
                $("select[name='room_type_id']").html(html);

                $("select[name='room_type_id']").attr('disabled',false);
                $("#room_type_loading").hide();

            }, 'json');

        });

        $("select[name='room_type_id']").change(function(){

            $("select[name='room_id']").attr('disabled',true);
            $("#room_loading").show();

            var url = 'index.php?route=sale/order/getRoomsByRoomTypeID&t=<?php echo $t; ?>';
            var room_type_id = $(this).val();

            $.get(url, {room_type_id: room_type_id}, function(json) {

                var html = "<option value='none'> --- 请选择 --- </option>";
                var length = json.length;
                if(length > 0) {
                    for(var i=0;i<length;i++) {
                        html += "<option value="+json[i].room_id+">"+json[i].name+"</option>";
                    }
                }
                $("select[name='room_id']").html(html);

                $("select[name='room_id']").attr('disabled',false);
                $("#room_loading").hide();

            }, 'json');

        });

        $("#sync_lodger_and_lodger").click(function(){

            if($("#sync_lodger_and_lodger").attr("checked")) {
                $("select[name='lodger_gender']").get(0).selectedIndex = $("select[name='orderer_gender']").get(0).selectedIndex;
                $("input[name='lodger_name']").val($("input[name='orderer_name']").val());
                $("input[name='lodger_mobile']").val($("input[name='orderer_mobile']").val());
                $("select[name='lodger_card_type_id']").get(0).selectedIndex = $("select[name='orderer_card_type_id']").get(0).selectedIndex;
                $("input[name='lodger_identity']").val($("input[name='orderer_identity']").val());
            }else{
                $("select[name='lodger_gender']").get(0).selectedIndex = 0;
                $("input[name='lodger_name']").val("");
                $("input[name='lodger_mobile']").val("");
                $("select[name='lodger_card_type_id']").get(0).selectedIndex = 0;
                $("input[name='lodger_identity']").val("");
            }

        });


        $("#addNewCard").click(function(){
            var html ="<tr><td class='left'>卡号:&nbsp;&nbsp;&nbsp;&nbsp;<input type='text' name='lodge_room_card_num["+counter+"][value]' style='width:400px;' />&nbsp;<img class='delCard' style='cursor:pointer' src='view/image/delete.png'></td></tr>";
            counter++;
            $("#lodgeInfo").append(html);
        });


        $(".delCard").live("click",function(){
            $(this).parent().parent().remove();
        });

    });
</script>
