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
                'width'        => '20%'
            ),
            'sortable'     => true,
            'formatter'    => \f\ifm::t ( 'name' ),
        ),
         'link'     => array (
            'htmlOptions' => array (
                'id'    => '',
                'class' => '',
            ),
            'style' => array (
                'width'        => '20%'
            ),
            'sortable'     => true,
            'formatter'    => \f\ifm::t ( 'domain' ),
        ),
         'component_id'     => array (
            'htmlOptions' => array (
                'id'    => '',
                'class' => '',
            ),
            'style' => array (
                'width'        => '15%'
            ),
            'sortable'     => true,
            'formatter'    => \f\ifm::t ( 'num_visit' ),
        ), 
        'alexa_world'     => array (
            'htmlOptions' => array (
                'id'    => '',
                'class' => '',
            ),
            'style' => array (
                'width'        => '15%'
            ),
            'sortable'     => true,
            'formatter'    => \f\ifm::t ( 'alexa_world' ),
        ), 
        'alexa_country'     => array (
            'htmlOptions' => array (
                'id'    => '',
                'class' => '',
            ),
            'style' => array (
                'width'        => '15%'
            ),
            'sortable'     => true,
            'formatter'    => \f\ifm::t ( 'alexa_country' ),
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
<?php
/* @var $pageWidget \f\w\pageTitle */
$pageWidget = \f\widgetFactory::make ( 'pageTitle' ) ;
echo $pageWidget->renderTitle ( array ( 'title' => \f\ifm::t ( 'backlink' ), 'links' => array (/* array ( 'title'    => '+ ' . \f\ifm::t ( 'addbacklink' ), 'href'     => \f\ifm::app ()->baseUrl . 'core/seo/backlink/backlinkAdd/' . $param ) */) ) ) ;
/* @var $boxWidget \f\w\box */
$boxWidget = \f\widgetFactory::make ( 'box' ) ;
echo $boxWidget->begin ( array ( 'type'  => 'table', 'title' => \f\ifm::t ( 'list' ) . \f\ifm::t ( 'backlink' ) ) ) ;


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
            "aaSorting": [[0, 'asc']]
        }
            
        widgetHelper.makeDataTable('#myTable' , newOption , '<?= \f\ifm::app ()->baseUrl ?>core/seo/backlink/backlinkList');
         
    });   
</script>

<style>
    .listbacklinkUser{
        float:left;
        clear:both;
    }
</style>
