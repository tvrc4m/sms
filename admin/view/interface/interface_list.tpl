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
                <a href="<?php echo $interface_list; ?>">接口列表</a>
            </li>
        </ul>
        <div class="tab_container" style="min-height: 1000px;">
            <div class="form-content">
                <div class="content-form">

                    <div class="row-fluid">
                        <div class="span12">
                            <div class="widget_wrapper">
                                <div class="widget_content no-padding">
                                    <div class="margin" style="position:absolute; margin-top:-44px; right:10px;">
                                        <a href="<?php echo $new; ?>" class="btn btn-success">新增</a>
                                    </div>
                                    <form action="" method="post" enctype="multipart/form-data" id="form">
                                        <table width="100%" cellspacing="0" cellpadding="0" class="outinterface default_table">
                                            <thead>
                                                <tr>
                                                    <td class="center" style="width:25%">接口名</td>
                                                    <td class="center" style="width:25%">帐户</td>
                                                    <td class="center" style="width:25%">状态</td>
                                                    <td class="right" style="width:25%">操作</td>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                <?php if (!empty($interfaces)) { ?>
                                                <?php foreach ($interfaces as $interface) { ?>
                                                <tr>
                                                    <td class="center" style="overflow:hidden" title="<?php echo $interface['name']; ?>
                                                        ">
                                                        <?php echo $interface['name']; ?></td>
                                                    <td class="center">
                                                        <?php echo $interface['account']; ?></td>
                                                    <td class="center">
                                                        <?php if($interface['status']==1){ ?>
                                                            启用
                                                        <?php }else { ?>
                                                            禁用
                                                        <?php } ?>
                                                    </td>
                                                   <!--  <td class="center">
                                                        <?php if($interface['is_default']==0){ ?>
                                                            非默认
                                                        <?php }else { ?>
                                                            默认
                                                        <?php } ?>
                                                    </td> -->
                                                    <td class="center">
                                                        <a href="<?php  echo $interface['set_default']; ?>">
                                                        <?php if($interface['status']==1){ ?>
                                                            禁用
                                                        <?php }else { ?>
                                                            启用
                                                        <?php } ?></a>&nbsp;&nbsp;
                                                        <a href="<?php  echo $interface['update']; ?>">编辑</a>&nbsp;&nbsp;
                                                        <!-- <a href="<?php  echo $interface['delete']; ?>">删除</a> -->

                                                    </td>
                                                    <td class="center"></td>
                                                </tr>
                                                <?php } ?>
                                                <?php } else { ?>
                                                <tr>
                                                    <td class="center" colspan="7">没有创建客户</td>
                                                </tr>
                                                <?php } ?></tbody>
                                        </table>
                                    </form>
                                    <div class="pagination">
                                        <?php echo $pagination; ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php echo $footer; ?>