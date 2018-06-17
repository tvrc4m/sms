<?php echo $header; ?>

<div class="contents">
   
    <div class="warning hide"></div>
    <div class="success hide"></div>
    <div class="separator">
        <span></span>
    </div>
    <div class="widget leftTabs">
        <ul class="tabs service-tab">
            <li class="">
                <a url="<?php echo $customer_action; ?>">用户信息</a>
            </li>
            <li class="">
                <a url="<?php echo $password_action; ?>">修改密码</a>
            </li>
        </ul>
        <div class="tab_container" style="min-height: 1000px;">

            <div class="form-content">
                
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

    loadListInfo('index.php?route=account/customer&t=<?php echo $t; ?>');

</script>


<?php echo $footer; ?>