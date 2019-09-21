<?php
/* @var $table \f\w\table */
$table = \f\widgetFactory::make ( 'table' ) ;

$params     = array (
    'table' => array (
        'title'       => \f\ifm::t ( $param ),
        'htmlOptions' => array (
            'id' => 'myTable',
        )
    ),
    'thead' => array (
        'check'     => array (
            'htmlOptions' => array (
                'id'    => '',
                'class' => 'no_sort',
            ),
            'style'       => array (
                'width' => '5%'
            ),
            'formatter'   => \f\ifm::t ( 'check' ),
        ),
        'orderId'      => array (
            'htmlOptions' => array (
                'id'    => '',
                'class' => '',
            ),
            'style'       => array (
                'width' => '15%'
            ),
            'sortable'    => true,
            'formatter'   => \f\ifm::t ( 'orderId' ),
        ),
        'name'      => array (
            'htmlOptions' => array (
                'id'    => '',
                'class' => '',
            ),
            'style'       => array (
                'width' => '15%'
            ),
            'sortable'    => true,
            'formatter'   => \f\ifm::t ( 'name' ),
        ),
        'date_pay'  => array (
            'htmlOptions' => array (
                'id'    => '',
                'class' => '',
            ),
            'style'       => array (
                'width' => '15%'
            ),
            'sortable'    => true,
            'formatter'   => \f\ifm::t ( 'date_pay' ),
        ),
        'price_pay' => array (
            'htmlOptions' => array (
                'id'    => '',
                'class' => '',
            ),
            'style'       => array (
                'width' => '20%'
            ),
            'sortable'    => true,
            'formatter'   => \f\ifm::t ( 'price_pay' ),
        ),
        'status'    => array (
            'htmlOptions' => array (
                'id'    => '',
                'class' => '',
            ),
            'style'       => array (
                'width' => '10%'
            ),
            'sortable'    => true,
            'formatter'   => \f\ifm::t ( 'status' ),
        ),
        'act'       => array (
            'htmlOptions' => array (
                'id'    => '',
                'class' => '',
            ),
            'style'       => array (
                'width' => '15%'
            ),
            'formatter'   => '',
        ),
    ),
    'body'  => '',
        ) ;
?>
<?php
/* @var $pageWidget \f\w\pageTitle */
$pageWidget = \f\widgetFactory::make ( 'pageTitle' ) ;
echo $pageWidget->renderTitle ( array (
    'title' => \f\ifm::t ( 'stockOrders' ) ) ) ;
/* @var $boxWidget \f\w\box */
$boxWidget  = \f\widgetFactory::make ( 'box' ) ;
echo $boxWidget->begin ( array (
    'type'  => 'table',
    'title' => \f\ifm::t ( 'list' ) . \f\ifm::t ( 'stockOrders' ) ) ) ;


echo $table->renderTable ( $params ) ;
echo $boxWidget->flush () ;
?> 
<script>
    $(document).ready(function () {
        var newOption = {
            "serverSide": true,
            "sServerMethod": "POST",
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

        widgetHelper.makeDataTable('#myTable', newOption, '<?= \f\ifm::app ()->baseUrl ?>accountingStock/stockControl/stockOrders/stockOrdersList');

    });


</script>

<style>
    .listslideUser{
        float:left;
        clear:both;
    }
</style>
