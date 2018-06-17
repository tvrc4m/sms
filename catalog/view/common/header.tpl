<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>">
<head>
<meta charset="UTF-8" />
<title><?php echo $title; ?></title>
<base href="<?php echo $base; ?>" />
<?php if ($description) { ?>
<meta name="description" content="<?php echo $description; ?>" />
<?php } ?>
<?php if ($keywords) { ?>
<meta name="keywords" content="<?php echo $keywords; ?>" />
<?php } ?>
<link href="static/image/lannting.png" rel="icon">
<link rel="stylesheet" type="text/css" href="static/css/common.css" />
<link rel="stylesheet" href="static/css/bootstrap.css"/>
<link rel="stylesheet" href="static/css/bootstrap-responsive.css"/>
<link rel="stylesheet" href="static/css/style.css"/>
<link rel="stylesheet" href="static/css/plugins.css">

<script type="text/javascript" src="static/js/jquery/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="static/js/jquery/superfish/js/superfish.js"></script>
<script type="text/javascript" src="static/js/bootstrap-datetimepicker.min.js"></script>
<script type="text/javascript" src="static/js/common.js"></script>

</head>

<body>
<?php if ($logged) { ?>
    <div  class="header_wrapper">
        <div class="container-fluid">
            <div class="row-fluid">
            <a class="logo" title="" href="<?php echo $home; ?>"><img src="static/image/logo.png" /> </a>
            <ul class="user_nav">
                <li>
                    <a href="<?php echo $logout; ?>" title="<?php echo $text_logout; ?>" class="">退出系统</a>
                </li>
                <li><span>&nbsp;</span></li>
                </ul><!-- user_nav end -->

            </div>
        </div>
     </div>
    <?php } ?>
    <?php if ($logged) { ?>
    <div class="highligts_content">
        <div class="container-fluid">
            <div class="stats">
                <div class="row-fluid">
                    <div class="span12">
                        <div class="statistics">
                            <ul class="quickstats">
                                    <li class="blue">
                                        <a href="<?php echo $top_send; ?>" class="top">
                                            <span>发送短信</span>
                                        </a>
                                    </li>
                                    <li class="red">
                                        <a href="<?php echo $top_outbox; ?>" class="top">
                                            <span>发件箱</span>
                                        </a>

                                    </li>
                                    <!-- <li class="aqua">
                                        <a href="<?php echo $addNewOrder; ?>" class="top">
                                            <img alt="" src="static/image/icons/black/glyphicons_029_notes_2.png">
                                            <span>常用短语</span>
                                        </a>
                                    </li> -->
                                    <li class="yellow">
                                        <a href="<?php echo $addLotteryAction ?>" class="top">
                                            <span>财务管理</span>
                                        </a>
                                    </li>
                                    <!-- <li class="green">
                                        <a href="<?php echo $room_manage; ?>" class="top">
                                            <img alt="" src="static/image/icons/black/glyphicons_020_home.png">
                                            <span>系统设置</span>
                                        </a>
                                    </li> -->
                            </ul>
                        </div><!-- statistics end -->
                    </div>
                </div>
            </div>
        </div>
    </div><!-- hightlights_content end -->
    <?php } ?>

<?php if($isLogged) { ?>
    <div class="contentainer_wrapper">
        <div class="container-fluid">
            <div class="row-fluid">
                <div class="span12">
                    <div class="wrapper">
                        <!-- sidebar_navigation start -->
                        <div class="sidebar_navigation gradient">
                            <!-- new category added by david start -->

                            <ul id="constant" class="sf-vertical sub-menu" style='display:block;'>
                               
                                <li class="tip-right" data-original-title="短信群发" style="height: auto;">
                                    <a class="i_3_2 " href="<?php echo $sms_manage; ?>"><span class="tab_label" style="visibility: visible;">短信群发</span><span class="tab_info" style="visibility: visible;">发送短信</span></a>
                                    <!-- <ul id="sub_catalog" class="sub-menu">
                                        <li class=" tip-right" style="height: auto;">
                                             <a href="">
                                                 <span class="tab_sub_label" style="visibility: visible;">发送短信</span>
                                             </a>
                                         </li>
                                    </ul> -->
                                </li>
                                 <li class="tip-right" data-original-title="短信群发" style="height: auto;">
                                    <a class="i_3_2 " href="<?php echo $client_manage; ?>"><span class="tab_label" style="visibility: visible;">客户管理</span><span class="tab_info" style="visibility: visible;">客户管理</span></a>
                                </li>
                                <li class=" tip-right" data-original-title="财务管理" style="height: auto;">
                                    <a class="i_2 " href="<?php echo $finance_manage; ?>"><span class="tab_label" style="visibility: visible;">财务管理</span><span class="tab_info" style="visibility: visible;">财务管理</span></a>
                                </li>
                               <!--  <li class=" tip-right" data-original-title="辅助功能" style="height: auto;">
                                    <a class="i_6_1 " href="<?php echo $account_manage; ?>"><span class="tab_label" style="visibility: visible;">辅助功能</span><span class="tab_info" style="visibility: visible;">高级功能</span></a>
                                </li> -->
                                <li class=" tip-right" data-original-title="用户信息" style="height: auto;">
                                    <a class="i_5 " href="<?php echo $account_manage ?>"><span class="tab_label" style="visibility: visible;">用户信息</span><span class="tab_info" style="visibility: visible;">用户信息管理</span></a>
                                   
                                </li>
                                
                            </ul>
                            <!-- new category added by david end -->

                            <div style="height: 1px;display: block;font-size: 1px;"></div>
                        </div>
                        <!-- sidebar_navigation end -->

                        <div class="content_wrapper">
                            <?php } ?>

                    <?php if($_SESSION['alert_dialog']){ ?>
                        <div class="modal hide fade" id="alert" tabindex="-1" role="dialog"  aria-hidden="true" style="display: hidden;">
                          <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                              <h3 id="group_dialog_name">通知</h3>
                          </div>
                          <div class="modal-body">
                              <h4 style='display: none;'></h4>
                              <p class='popWindowInfo'>
                                <div id="add_client_group" style="color:red">
                                   重要通知！通知！根据法律法规，群发商业广告短信内容最后需加:回td退订或者回电话退订比如:庆双节，全场优惠，进店有礼！电话898989可退订信息
                                </div>
                              </p>
                          </div>
                          <div class="modal-footer">
                              <button class="btn btn-primary makesure"  onclick="$('#alert').modal('hide')">确定</button>
                          </div>
                        </div>
                        <script type="text/javascript">
                        $(document).ready(function(){
                            $('#alert').modal();    
                        })
                        </script>
                        <?php unset($_SESSION['alert_dialog']); ?>
                    <?php } ?>
