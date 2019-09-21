<?php
/* @var $table \f\w\table */
$table  = \f\widgetFactory::make( 'table' );
$params = [
    'table' => [
        'title'       => \f\ifm::t( $param ),
        'htmlOptions' => [
            'id' => 'myTable2',
        ]
    ],
    'thead' => [
        'check'         => [
            'style'     => [
                'width' => '4%'
            ],
            'formatter' => \f\ifm::t( 'check' ),
        ],
        'title_fa' => [
            'style'     => [
                'width' => '10%'
            ],
            'formatter' => \f\ifm::t( 'title' ),
        ],

        'stock' => [
            'style'     => [
                'width' => '15%'
            ],
            'formatter' => \f\ifm::t( 'stock' ),
        ],
        'count_pro'    => [
            'style'     => [
                'width' => '15%'
            ],
            'formatter' => \f\ifm::t( 'count' ),
        ],

    ],
    'body'  => '',
];
?>
<?php
/* @var $pageWidget \f\w\pageTitle */
$pageWidget = \f\widgetFactory::make( 'pageTitle' );
/* @var $boxWidget \f\w\box */
$boxWidget = \f\widgetFactory::make( 'box' );
echo $boxWidget->begin( [ 'type' => 'table','title' => \f\ifm::t( 'list' ) . \f\ifm::t( 'oneDayTourReservation' ) ] );
echo $table->renderTable( $params );
echo $boxWidget->flush();
?>
<script>
    $(document).ready(function () {
    var newOption = {
        "serverSide": true,
        "sServerMethod": "POST",
        "aaSorting": [[0, 'desc']]
    }
        widgetHelper.makeDataTable('#myTable2', newOption, '<?= \f\ifm::app()->baseUrl ?>accountingStock/statisticalReports/mostSellRep/mostSellRepBrandList');
        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            $($.fn.dataTable.tables(true)).DataTable()
                .columns.adjust();
        });
    });

</script>

<style>
    .listoneDayTourReservationUser {
        float: left;
        clear: both;
    }
</style>
