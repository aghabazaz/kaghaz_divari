<?php
/* @var $table \f\w\table */
$table = \f\widgetFactory::make ( 'table' ) ;

$params = array (
    'table' => array (
        'title'       => \f\ifm::t ( $param ),
        'htmlOptions' => array (
            'id'    => 'myTable',
        )
    ),
    'thead' => array (
        'check' => array (
            'htmlOptions' => array (
                'id'    => '',
                'class' => 'no_sort',
            ),
            'style' => array (
                'width'     => '5%'
            ),
            'formatter' => \f\ifm::t ( 'check' ),
        ),
        'title'     => array (
            'htmlOptions' => array (
                'id'    => '',
                'class' => '',
            ),
            'style' => array (
                'width'        => '30%'
            ),
            'sortable'     => true,
            'formatter'    => \f\ifm::t ( 'title' ),
        ),
        'date_credit' => array (
            'htmlOptions' => array (
                'id'    => '',
                'class' => '',
            ),
            'style' => array (
                'width'     => '55%'
            ),
            'formatter' => \f\ifm::t ( 'date_credit' ),
        ),
        'act'       => array (
            'htmlOptions' => array (
                'id'    => '',
                'class' => '',
            ),
            'style' => array (
                'width'     => '10%'
            ),
            'formatter' => '',
        ),
    ),
    'body'      => '',
) ;
?>
<?
/* @var $pageWidget \f\w\pageTitle */
$pageWidget = \f\widgetFactory::make ( 'pageTitle' ) ;
echo $pageWidget->renderTitle ( array ( 'title' => \f\ifm::t ( 'basketOffList' ), 'links' => array ( array ( 'title'    => '+ ' . \f\ifm::t ( 'addBasketOff' ), 'href'     => \f\ifm::app ()->baseUrl . 'shop/discount/basketOff/basketOffAdd/' . $param ) ) ) ) ;
/* @var $boxWidget \f\w\box */
$boxWidget = \f\widgetFactory::make ( 'box' ) ;
echo $boxWidget->begin ( array ( 'type'  => 'table', 'title' => \f\ifm::t ( 'list' ) . \f\ifm::t ( 'basketOffList' ) ) ) ;


echo $table->renderTable ( $params ) ;
echo $boxWidget->flush () ;
?>
<script>
    $(document).ready(function () {
        var newOption = {
            "serverSide": true,
            "sServerMethod":"POST",
            /*"aoColumns": [
            {
                "bSortable": false
            },
            null,
            null,
            null
            ],*/
            "aaSorting": [[1, 'asc']]
        }

        widgetHelper.makeDataTable('#myTable' , newOption , '<?= \f\ifm::app ()->baseUrl ?>shop/discount/basketOff/basketOffList');
    });


</script>

<style>
    .listmemberListUser{
        float:left;
        clear:both;
    }
</style>
