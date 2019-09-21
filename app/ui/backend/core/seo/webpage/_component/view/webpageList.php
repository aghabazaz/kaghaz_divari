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
                'width'        => '25%'
            ),
            'sortable'     => true,
            'formatter'    => \f\ifm::t ( 'titleWebpage' ),
        ),
         'link'     => array (
            'htmlOptions' => array (
                'id'    => '',
                'class' => '',
            ),
            'style' => array (
                'width'        => '40%'
            ),
            'sortable'     => true,
            'formatter'    => \f\ifm::t ( 'link' ),
        ),
         'component_id'     => array (
            'htmlOptions' => array (
                'id'    => '',
                'class' => '',
            ),
            'style' => array (
                'width'        => '10%'
            ),
            'sortable'     => true,
            'formatter'    => 'component_id',
        ),
         'item_id'     => array (
            'htmlOptions' => array (
                'id'    => '',
                'class' => '',
            ),
            'style' => array (
                'width'        => '10%'
            ),
            'sortable'     => true,
            'formatter'    =>  'item_id' ,
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
echo $pageWidget->renderTitle ( array ( 'title' => \f\ifm::t ( 'webpage' ), 'links' => array (/* array ( 'title'    => '+ ' . \f\ifm::t ( 'addwebpage' ), 'href'     => \f\ifm::app ()->baseUrl . 'core/seo/webpage/webpageAdd/' . $param ) */) ) ) ;
/* @var $boxWidget \f\w\box */
$boxWidget = \f\widgetFactory::make ( 'box' ) ;
echo $boxWidget->begin ( array ( 'type'  => 'table', 'title' => \f\ifm::t ( 'list' ) . \f\ifm::t ( 'webpage' ) ) ) ;


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
            
        widgetHelper.makeDataTable('#myTable' , newOption , '<?= \f\ifm::app ()->baseUrl ?>core/seo/webpage/webpageList');
         
    });   
  
     
</script>

<style>
    .listwebpageUser{
        float:left;
        clear:both;
    }
</style>
