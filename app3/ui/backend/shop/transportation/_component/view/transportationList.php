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
                'width'     => '35%'
            ),
            'sortable'  => true,
            'formatter' => \f\ifm::t ( 'title' ),
        ),
        'cost'      => array (
            'htmlOptions' => array (
                'id'    => '',
                'class' => '',
            ),
            'style' => array (
                'width'       => '15%'
            ),
            'sortable'    => true,
            'formatter'   => \f\ifm::t ( 'cost' ),
        ),
        'description' => array (
            'htmlOptions' => array (
                'id'    => '',
                'class' => '',
            ),
            'style' => array (
                'width'     => '33%'
            ),
            'sortable'  => true,
            'formatter' => \f\ifm::t ( 'description' ),
        ),
        'act' => array (
            'htmlOptions' => array (
                'id'    => '',
                'class' => '',
            ),
            'style' => array (
                'width'     => '12%'
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
echo $pageWidget->renderTitle ( array ( 'title' => \f\ifm::t ( 'transportation' ), 'links' => array ( array ( 'title'    => '+ ' . \f\ifm::t ( 'addtransportation' ), 'href'     => \f\ifm::app ()->baseUrl . 'shop/transportation/transportationAdd/' . $param ) ) ) ) ;
/* @var $boxWidget \f\w\box */
$boxWidget = \f\widgetFactory::make ( 'box' ) ;
echo $boxWidget->begin ( array ( 'type'  => 'table', 'title' => \f\ifm::t ( 'list' ) . \f\ifm::t ( 'transportation' ) ) ) ;


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
            "aaSorting": [[0, 'desc']]
        }
            
        widgetHelper.makeDataTable('#myTable' , newOption , '<?= \f\ifm::app ()->baseUrl ?>shop/transportation/transportationList');
         
    });   
  
     
</script>

<style>
    .listslideUser{
        float:left;
        clear:both;
    }
</style>
