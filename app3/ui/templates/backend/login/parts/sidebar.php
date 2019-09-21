<?php
/* @var $sidebarWidget \f\w\sidebar */
$sidebarWidget = \f\widgetFactory::make('sidebar') ;

echo $sidebarWidget->autoGenerateMenu() ;
?>
<!--<div class="col-md-2 left-sidebar">
    <nav class="main-nav">
        <ul class="main-menu">
            <li>
                <a href="index.html">
                    <i class="fa fa-dashboard fa-fw"></i>
                    <span class="text">داشبورد </span>
                </a>
            </li>
            <li class=""><a class="js-sub-menu-toggle" href="#"><i class="fa fa-clipboard fa-fw"></i><span class="text">صفحات </span>
                    <i class="toggle-icon fa fa-angle-left"></i></a>
                <ul class="sub-menu " >
                    <li><a href="page-profile.html"><span class="text">پروفایل </span></a></li>
                    <li><a href="page-invoice.html"><span class="text">فاکتور </span></a></li>
                    <li><a href="page-knowledgebase.html"><span class="text">پایگاه دانش </span></a></li>
                    <li><a href="page-inbox.html"><span class="text">صندوق ورودی </span></a></li>
                    <li><a href="page-register.html"><span class="text">ثبت نام </span></a></li>
                    <li><a href="page-login.html"><span class="text">ورود </span></a></li>
                    <li><a href="page-404.html"><span class="text">404</span></a></li>
                    <li><a href="page-blank.html"><span class="text">صفحات خالی </span></a></li>
                </ul>
            </li>

        </ul>
    </nav>
    <div class="sidebar-minified js-toggle-minified">
        <i class="fa fa-angle-right"></i>
    </div>
</div>-->
