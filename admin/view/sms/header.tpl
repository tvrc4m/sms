<?php echo $header; ?>
<div class="contents">
    <div class="warning hide"></div>
    <div class="success hide"></div>
    <div class="separator">
        <span></span>
    </div>
    <div class="widget leftTabs">
        <ul class="tabs roomSource-tab">
            <li>
                <a url="<?php echo $outbox_action; ?>">发件箱</a>
            </li>
        </ul>
        <div class="tab_container" style="min-height: 1000px;">
            <div class="form-content"></div>
        </div>
    </div>
</div>

<script type="text/javascript">
    loadListInfo('<?php echo $outbox_action; ?>');
</script>

<?php echo $footer; ?>