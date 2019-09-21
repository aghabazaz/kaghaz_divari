<?php

/* @var $breadcrumbWidget \f\w\breadcrumb */
$breadcrumbWidget = \f\widgetFactory::make('breadcrumb') ;
if ( is_array($breadcrumb) )
{
    echo $breadcrumbWidget->renderTexty($breadcrumb) ;
}
else
{
    echo $breadcrumbWidget->autoGenerate($breadcrumb) ;
}