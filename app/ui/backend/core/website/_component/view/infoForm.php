<?php
/* @var $addWidget2 \f\w\form */
$addWidget2 = \f\widgetFactory::make ( 'form' ) ;

/* @var $tab \f\w\tab */
$tab = \f\widgetFactory::make ( 'tab' ) ;

//language array
if ( $row )
{
    foreach ( $row[ 'resultLangInfo' ] as $key => $val )
    {
        $langWebsite[ ] = $key ;
    }
}
else
{
    $langWebsite = array ( ) ;
}

//------------------------------------------------------------------------------
$infoForm = '' ;

$infoForm.=$addWidget2->begin ( array (
    'htmlOptions' => array (
        'method' => 'post',
        'action' => '',
        'id'     => 'siteInfo'
    ),
        ) ) ;
$infoForm .= $addWidget2->rowStart () ;
$infoForm .= $addWidget2->checkbox ( array (
    'htmlOptions' => array (
        'name'    => 'language[]',
        'class'   => 'langSite',
    ),
    'choices' => $language,
    'checked' => (isset ( $row )) ? $langWebsite : '',
    'label'   => array (
        'text'  => \f\ifm::t ( 'language' ),
    ),
    'block' => array ( ),
        ) ) ;
//----------------------------------language Info-------------------------------
$tab->begin ( array ( ) ) ;
$numact = 0 ;
foreach ( $language as $key => $result )
{
    $infoLang =  ($row) ? $row[ 'resultLangInfo' ][ $result ] : '' ;

    $dir = ($result == 1) ? 'ltr' : 'rtl' ;

    $display = 'none' ;
    if (  $langWebsite && in_array ( $result, $langWebsite )  )
    {
        $display = 'block' ;
    }

    $infoTab = '' ;
    $infoTab.=$addWidget2->rowStart (
            array (
        'display' => $display,
            )
            , '',
            array (
        'id'    => 'info-' . $result,
        'class' => 'info-' . $result,
            )
            ) ;
    $infoTab.=$addWidget2->rowStart () ;
    $infoTab.=$addWidget2->select ( array (
        'htmlOptions' => array (
            'id'    => 'template',
            'name'  => 'template['.$result.']',
        ),
        'label' => array (
            'text'     => \f\ifm::t ( 'tempalte' ),
        ),
        'choices'  => $template [ $result ],
        'selected' => ($infoLang) ? $infoLang[ 'core_templateid' ] : '',
            ) ) ;
    $infoTab.=$addWidget2->rowEnd () ;

    $infoTab.=$addWidget2->rowStart () ;
    $infoTab.=$addWidget2->input ( array (
        'htmlOptions' => array (
            'type'  => 'text',
            'name'  => 'siteTitle['.$result.']',
            'value' => $infoLang[ 'title' ],
        ),
        'style' => array (
            'direction' => $dir,
        ),
        'label'     => array (
            'text' => \f\ifm::t ( 'siteTitle' ),
        ),
            ) ) ;
    $infoTab.=$addWidget2->rowEnd () ;

    $infoTab.=$addWidget2->rowStart () ;
    $infoTab.=$addWidget2->textarea ( array (
        'htmlOptions' => array (
            'name'  => 'desc['.$result.']',
            'id'    => 'desc',
        ),
        'style' => array (
            'height'    => '100px',
            'direction' => $dir,
        ),
        'label'     => array (
            'text'    => \f\ifm::t ( 'desc' ),
        ),
        'content' => $infoLang[ 'description' ],
            )
            ) ;
    $infoTab.=$addWidget2->rowEnd () ;

    $infoTab.=$addWidget2->rowStart () ;
    $infoTab.=$addWidget2->textarea ( array (
        'htmlOptions' => array (
            'name'  => 'keywords['.$result.']',
            'id'    => 'keywords',
        ),
        'style' => array (
            'height'    => '100px',
            'direction' => $dir,
        ),
        'label'     => array (
            'text'    => \f\ifm::t ( 'keyword' ),
        ),
        'content' => $infoLang[ 'keywords' ],
            )
            ) ;
    $infoTab.=$addWidget2->rowEnd () ;

    $infoTab.=$addWidget2->rowStart () ;
    $infoTab.=$addWidget2->input ( array (
        'htmlOptions' => array (
            'type'  => 'file',
            'name'  => 'logo['.$result.']',
        //'value' => $row[ '' ],
        ),
        'label' => array (
            'text' => \f\ifm::t ( 'logo' ),
        ),
            ) ) ;
    $infoTab.=$addWidget2->rowEnd () ;

    $infoTab.=$addWidget2->rowStart () ;
    $infoTab.=$addWidget2->input ( array (
        'htmlOptions' => array (
            'type'  => 'file',
            'name'  => 'footer['.$result.']',
        //'value' => $row[ '' ],
        ),
        'label' => array (
            'text' => \f\ifm::t ( 'footer' ),
        ),
            ) ) ;
    $infoTab.=$addWidget2->rowEnd () ;

    $infoTab.=$addWidget2->rowStart () ;
    $infoTab.=$addWidget2->input ( array (
        'htmlOptions' => array (
            'type'  => 'file',
            'name'  => 'icon['.$result.']',
        //'value' => $row[ '' ],
        ),
        'label' => array (
            'text' => \f\ifm::t ( 'icon' ),
        ),
            ) ) ;
    $infoTab.=$addWidget2->rowEnd () ;
    $infoTab.=$addWidget2->rowEnd () ;

    $tabArray = array (
        'title' => array (
            'text'    => \f\ifm::t ( 'baseInfo' ) . " " . $key,
        ),
        'content' => array (
            'content'     => $infoTab,
        ),
        'htmlOptions' => array (
            'id'    => 'info-' . $result,
            'class' => 'info-' . $result,
        ),
        'style' => array (
            'display' => $display,
        ),
    ) ;
    if ($langWebsite && in_array ( $result, $langWebsite ) && $numact == 0)
    {
        $tabArray[ 'active' ] = '' ;
        $numact = 1 ;
    }
    $tab->tab ( $tabArray ) ;
}
$infoForm.=$tab->flush () ;
//------------------------------------------------------------------------------
$infoForm.= $addWidget2->rowEnd () ;
$infoForm.=$addWidget2->flush () ;
?>


<script>
    $(document).ready(function(){
        $('.langSite').on('click' , function(){
            var lang = $(this).val();
            if($(this).is(':checked')){
                $('.info-'+lang).slideDown('slow');
            }
            else{
                $('.info-'+lang).slideUp('slow');
            }
        });
    });


</script>


