<?php
$this->registerWidgets ( array (
    'formW'      => 'form',
    'boxW'       => 'box',
    'pageTitleW' => 'pageTitle'
) ) ;
$this->registerGadgets ( array (
    'strG'  => 'str',
    'dateG' => 'date' ) ) ;


echo \f\html::markupBegin ( 'div' ) ;
echo \f\html::markupBegin ( 'div',
                            array (
    'htmlOptions' => array (
        'class' => 'col-md-6' ) ) ) ;
echo \f\html::markupBegin ( 'i',
                            array (
    'htmlOptions' => array (
        'class' => 'fa fa-file-text-o fa-4x' ),
    'style'       => array (
        'float'        => 'right',
        'padding-left' => '20px',
        'padding-top'  => '5px'
) ) ) ;
echo \f\html::markupEnd ( 'i' ) ;
echo \f\html::markupBegin ( 'div',
                            array (
    'style' => array (
        'font-size' => '18px'
    )
) ) ;
echo $row[ 'title' ] ;
echo '<br><span style="font-size:13px;color:gray">' . $row[ 'component_id' ] . '</span>' ;
echo \f\html::markupEnd ( 'div' ) ;

echo \f\html::markupEnd ( 'div' ) ;
echo \f\html::markupBegin ( 'div',
                            array (
    'htmlOptions' => array (
        'class' => 'col-md-6' ),
    'style'       => array (
        'text-align' => 'left'
) ) ) ;


$form .= \f\html::readyMarkup ( 'button',
                                '<i class="fa fa-edit "></i> ' . (\f\ifm::t ( 'editBtn' ) ),
                                                                              array (
            'htmlOptions' => array (
                'type'  => 'button',
                'class' => 'btn btn-primary',
                'id'    => 'editBtn' . $row[ 'id' ]
            ),
            'action'      => array (
                'display' => 'dialog',
                'params'  => array (
                    'targetRoute'    => "core.seo.editParameterDialog",
                    'triggerElement' => 'editBtn' . $row[ 'id' ], //chanage
                    'dialogTitle'    => 'ویرایش اطلاعات صفحه',
                    'ajaxParams'     => array (
                        'component_id' => $row[ 'component_id' ],
                        'item_id'      => $row[ 'item_id' ],
                    )
                ) ) ), TRUE ) ;

if ( $row[ 'link' ] )
{
    $row['link']= substr($row[link], 1);
    $form .= \f\html::markupBegin ( 'a',
                                    array (
                'htmlOptions' => array (
                    'href' => \f\ifm::app ()->siteUrl . $row[ 'link' ],
                    'target'=>"_blank"
        ) ) ) ;
    $form .= \f\html::markupBegin ( 'button',
                                    array (
                'htmlOptions' => array (
                    'type'  => 'button',
                    'class' => 'btn btn-success' ) ) ) ;
    $form .= '<i class="fa fa-eye"></i> ' . 'مشاهده' ;
    $form .= \f\html::markupEnd ( 'button' ) ;
    $form .= \f\html::markupEnd ( 'a' ) ;

    $form .= \f\html::markupBegin ( 'button',
                                    array (
                'htmlOptions' => array (
                    'type'    => 'button',
                    'onclick' => 'updateInfo(' . '"' . \f\ifm::app()->siteUrl. $row[ 'link' ] . '"' . ','.$row['id'].')',
                    'class'   => 'btn btn-danger' ) ) ) ;
    $form .= '<i class="fa fa-refresh"></i> ' . 'بروزرسانی' ;
    $form .= \f\html::markupEnd ( 'button' ) ;
}
echo $form ;
echo \f\html::markupEnd ( 'div' ) ;
echo \f\html::markupBegin ( 'div',
                            array (
    'htmlOptions' => array (
        'class' => 'clear' ) ) ) ;
echo \f\html::markupEnd ( 'div' ) ;
echo \f\html::markupEnd ( 'div' ) ;
echo '<br></br>' ;

$tabWidget = \f\widgetFactory::make ( 'tab' ) ;

$tabWidget->begin ( array (
    'htmlOptions' => array (
        'class' => 'mytabs'
    )
) ) ;
$tabWidget->tab ( array (
    'active'  => true,
    'title'   => array (
        'text' => \f\ifm::t ( "baseInfo" ),
        'icon' => 'fa-info-circle'
    ),
    'content' => array (
        'content' => $this->render ( 'base',
                                     array (
            'row' => $row,
        ) )
    ),
    'block'   => array ()
) ) ;
$tabWidget->tab ( array (
    'title'   => array (
        'text' => \f\ifm::t ( "heading" ),
        'icon' => 'fa-code'
    ),
    'content' => array (
        'content' => $this->render ( 'heading',
                                     array (
            'row' => $row,
            'heading' => $heading,
        ) )
    ),
    'block'   => array ()
) ) ;

$tabWidget->tab ( array (
    'title'   => array (
        'text' => \f\ifm::t ( "link" ),
        'icon' => 'fa-link'
    ),
    'content' => array (
        'content' => $this->render ( 'link',
                                     array (
            'link' => $link,
        ) )
    ),
    'block'   => array ()
) ) ;


$tabWidget->tab ( array (
    'title'   => array (
        'text' => \f\ifm::t ( "density" ),
        'icon' => 'fa-tachometer'
    ),
    'content' => array (
        'content' => $this->render ( 'density',
                                     array (
            'words' => $words,
        ) )
    ),
    'block'   => array ()
) ) ;
$tabWidget->tab ( array (
    'title'   => array (
        'text' => \f\ifm::t ( "backlink" ),
        'icon' => 'fa-sign-in'
    ),
    'content' => array (
        'content' => $this->render ( 'backlink',
                                     array (
            'backlink' => $backlink,
        ) )
    ),
    'block'   => array ()
) ) ;
echo $tabWidget->flush () ;
?>
<script>
function updateInfo(link,id)
{
    widgetHelper.addLoading();
    widgetHelper.tt('ui','core.seo.webpage.updateInfo',{link:link,id:id},'refreshPage');
}
function refreshPage()
{
    location.reload();
}
</script>