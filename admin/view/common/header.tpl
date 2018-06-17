<!DOCTYPE html>
<html dir="{$direction}" lang="{$lang}">
<head>
<meta charset="UTF-8" />
<title>{$title}</title>
<meta name="description" content="{$description}" />
<meta name="keywords" content="{$keywords}" />
<link href="static/image/lannting.png" rel="icon">
<link rel="stylesheet" type="text/css" href="static/css/common.css" />
<link rel="stylesheet" href="static/css/bootstrap.css"/>
<link rel="stylesheet" href="static/css/bootstrap-responsive.css"/>
<link rel="stylesheet" href="static/css/style.css"/>
<link rel="stylesheet" href="static/css/plugins.css">
<script type="text/javascript" src="static/js/jquery/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="static/js/jquery/superfish/js/superfish.js"></script>
<script type="text/javascript" src="static/js/common.js"></script>
<script type="text/javascript">
    var token="{$smarty.session.token}";
</script>
</head>

<body>
    {if $logged}
    <div  class="header_wrapper">
        <div class="container-fluid">
            <div class="row-fluid">
                <a class="logo" title="" href="{$home}"><img src="static/image/logo.png" /> </a>
                <ul class="user_nav">
                    <li><h3 style="margin-top:5px;margin-right:10px;">hi,admin</h3></li>
                    <li>
                        <a href="{$logout}" title="{$text_logout}" rel="tooltip" class="tips icon_logout"></a>
                    </li>
                </ul><!-- user_nav end -->
            </div>
        </div>
     </div>
    {/if}
    <div class="contentainer_wrapper">
        {if $logged}
                    <div class="wrapper">
                        
                        <!-- sidebar_navigation start -->
                        <div class="sidebar_navigation gradient">
                            <!-- new category added by david start -->

                            <ul id="constant" class="sub-menu" style='display:block;'>
                               
                                <li class="tip-right" data-original-title="用户管理" style="height: auto;">
                                    <a class="i_3_2 " href="{$account_manage}"><span class="tab_label" style="visibility: visible;">用户管理</span><span class="tab_info" style="visibility: visible;">用户管理</span></a>
                                </li>
                                <li class="tip-right" data-original-title="短信管理" style="height: auto;">
                                    <a class="i_3_2 " href="{$sms_manage}"><span class="tab_label" style="visibility: visible;">短信管理</span><span class="tab_info" style="visibility: visible;">短信管理</span></a>
                                </li>
                                 <li class="tip-right" data-original-title="接口管理" style="height: auto;">
                                    <a class="i_3_2 " href="{$interface_manage}"><span class="tab_label" style="visibility: visible;">接口管理</span><span class="tab_info" style="visibility: visible;">接口管理</span></a>
                                </li>
                                <li class=" tip-right" data-original-title="系统设置" style="height: auto;">
                                    <a class="i_2 " href="{$order_manage}"><span class="tab_label" style="visibility: visible;">系统设置</span><span class="tab_info" style="visibility: visible;">系统设置</span></a>
                                </li>
                                <li class=" tip-right" data-original-title="辅助功能" style="height: auto;">
                                    <a class="i_6_1 " href="{$deposit_manage}"><span class="tab_label" style="visibility: visible;">充值设置</span><span class="tab_info" style="visibility: visible;">充值设置</span></a>
                                </li>
                                <li class=" tip-right" data-original-title="帐户管理" style="height: auto;">
                                    <a class="i_5 " href="{$user_manage}"><span class="tab_label" style="visibility: visible;">帐户管理</span><span class="tab_info" style="visibility: visible;">帐户管理</span></a>
                                </li>
                            </ul>
                           
                        </div>
                        <!-- sidebar_navigation end -->
                    </div> 

        {/if}

        <div class="content_wrapper">
