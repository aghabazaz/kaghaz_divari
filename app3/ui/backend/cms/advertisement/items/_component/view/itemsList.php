<?php
/* @var $table \f\w\table */
$table  = \f\widgetFactory::make ( 'table' ) ;
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
                'width'     => '20%'
            ),
            'sortable'  => true,
            'formatter' => \f\ifm::t ( 'name' ),
        ),
        'email'     => array (
            'htmlOptions' => array (
                'id'    => '',
                'class' => '',
            ),
            'style' => array (
                'width'     => '20%'
            ),
            'sortable'  => true,
            'formatter' => \f\ifm::t ( 'email' ),
        ),
        'phone'     => array (
            'htmlOptions' => array (
                'id'    => '',
                'class' => '',
            ),
            'style' => array (
                'width'     => '20%'
            ),
            'sortable'  => true,
            'formatter' => \f\ifm::t ( 'phone' ),
        ),
        'plan'      => array (
            'htmlOptions' => array (
                'id'    => '',
                'class' => '',
            ),
            'style' => array (
                'width'        => '10%'
            ),
            'sortable'     => true,
            'formatter'    => \f\ifm::t ( 'plan' ),
        ),
        'credit_point' => array (
            'htmlOptions' => array (
                'id'    => '',
                'class' => '',
            ),
            'style' => array (
                'width'     => '15%'
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
echo $pageWidget->renderTitle ( array ( 'title' => \f\ifm::t ( 'advertise' ), 'links' => array ( array ( 'title'    => '+ ' . \f\ifm::t ( 'addadvertise' ), 'href'     => \f\ifm::app ()->baseUrl . 'cms/advertisement/items/itemsAdd/' . $param ) ) ) ) ;
/* @var $boxWidget \f\w\box */
$boxWidget = \f\widgetFactory::make ( 'box' ) ;
echo $boxWidget->begin ( array ( 'type'  => 'table', 'title' => \f\ifm::t ( 'list' ) . \f\ifm::t ( 'advertise' ) ) ) ;


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
            
        widgetHelper.makeDataTable('#myTable' , newOption , '<?= \f\ifm::app ()->baseUrl ?>cms/advertisement/items/itemsList');
         
    });   
  
     
</script>

<style>
    .listtagUser{
        float:left;
        clear:both;
    }
</style>
