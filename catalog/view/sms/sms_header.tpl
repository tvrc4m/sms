<?php echo $header; ?>
<div class="contents">
    <div class="warning hide"></div>
    <div class="success hide"></div>
    <div class="separator">
        <span></span>
    </div>
    <div class="widget leftTabs">
        <ul class="tabs roomSource-tab">
            <li class="active">
                <a url="<?php echo $send_action; ?>">发送短信</a>
            </li>
        </ul>
        <div class="tab_container" style="min-height: 1000px;">
            <div class="form-content">
                
            </div>
        </div>
    </div>
</div>

<!-- room type start -->
<script type="text/javascript">

    loadListInfo('<?php echo $send_action; ?>');

</script>




<?php echo $footer; ?>
