<?php
/* @var $addWidget \f\w\form */
$addWidget = \f\widgetFactory::make('form') ;

//------------------------------------------------------------------------------
$config = '' ;

$config.=$addWidget->begin(array (
    'htmlOptions' => array (
        'method' => 'post',
        'action' => '',
        'id'     => 'siteConfig'
    ),
        )) ;
$config .= $addWidget->rowStart() ;
$config .= $addWidget->radio(array (
    'linear'      => false,
    'htmlOptions' => array (
        'name' => 'status',
    ),
    'choices'     => array ( \f\ifm::t('online') => 'enabled', \f\ifm::t('offline') => 'disabled' ),
    'label'       => array (
        'text' => \f\ifm::t('websiteStatus'),
    ),
    'checked'     => ($row[ 'resultMain' ]) ? $row[ 'resultMain' ][ 'status' ] : 'enabled',
        )) ;
$config .= $addWidget->rowEnd() ;

$config .= $addWidget->rowStart() ;

$checkBoxSettings = array (
    'settings[showdate]'              => array (
        'title'   => \f\ifm::t('showdate'),
        'checked' => $settings[ 'showdate' ] == 'yes' ? true : false,
    ),
    'settings[searchInsite]'          => array (
        'title'   => \f\ifm::t('searchInsite'),
        'checked' => $settings[ 'searchInsite' ] == 'yes' ? true : false,
    ),
    'settings[showTelInHeader]'       => array (
        'title'   => \f\ifm::t('showTelInHeader'),
        'checked' => $settings[ 'showTelInHeader' ] == 'yes' ? true : false,
    ),
    'settings[showAdressInFooter]'    => array (
        'title'   => \f\ifm::t('showAdressInFooter'),
        'checked' => $settings[ 'showAdressInFooter' ] == 'yes' ? true : false,
    ),
    'settings[enableIntro]'           => array (
        'title'   => \f\ifm::t('enableIntro'),
        'checked' => $settings[ 'enableIntro' ] == 'yes' ? true : false,
    ),
    'settings[showCopyrightInFooter]' => array (
        'title'   => \f\ifm::t('showCopyrightInFooter'),
        'checked' => $settings[ 'showCopyrightInFooter' ] == 'yes' ? true : false,
    ),
    'settings[showTitleInHeader]'     => array (
        'title'   => \f\ifm::t('showTitleInHeader'),
        'checked' => $settings[ 'showTitleInHeader' ] == 'yes' ? true : false,
    )
        ) ;

foreach ( $checkBoxSettings as $key => $value )
{
    $checkedArray = array () ;
    if ( isset($value[ 'checked' ]) && $value[ 'checked' ] )
    {
        $checkedArray[] = $key ;
    }

    $config .= $addWidget->checkbox(array (
        'checked'     => $checkedArray,
        'htmlOptions' => array (
            'name'  => $key,
            'class' => 'langSite'
        ),
        'choices'     => array (
            $value[ 'title' ] => $key
        )
            )) ;
}

//$config .= $addWidget->checkbox(array (
//    'checked'     => array ( 'enableIntro' ),
//    'htmlOptions' => array (
//        'name'  => 'settings[]',
//        'class' => 'langSite'
//    ),
//    'choices'     => array (
//        \f\ifm::t('showdate')              => 'showdate',
//        \f\ifm::t('searchInsite')          => 'searchInsite',
//        \f\ifm::t('showTelInHeader')       => 'showTelInHeader',
//        \f\ifm::t('showAdressInFooter')    => 'showAdressInFooter',
//        \f\ifm::t('enableIntro')           => 'enableIntro',
//        \f\ifm::t('showCopyrightInFooter') => 'showCopyrightInFooter',
//        \f\ifm::t('showTitleInHeader')     => 'showTitleInHeader',
//    ),
//    'label'       => array (
//        'text' => \f\ifm::t('settings'),
//    ),
//        )) ;
$config .= $addWidget->rowEnd() ;
?>


<script>
    $(document).ready(function () {
        $('#onlineReserve-0').click(function () {
            if (this.checked)
                $('#reserveAdress').animate({'opacity': '1'});
            else
                $('#reserveAdress').animate({'opacity': '0'});
        })
    })
</script>