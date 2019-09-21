<?php
/* @var $table \f\w\table */
$table = \f\widgetFactory::make('table') ;

$params     = array (
    'table' => array (
        'title'       => \f\ifm::t(roles),
        'htmlOptions' => array (
            'id' => 'roleTable',
        )
    ),
    'thead' => array (
        'check' => array (
            'htmlOptions' => array (
                'id'    => '',
                'class' => 'no_sort',
            ),
            'style'       => array (
                'width' => '8%'
            ),
            'formatter'   => '',
        ),
        'title' => array (
            'htmlOptions' => array (
                'id'    => '',
                'class' => '',
            ),
            'style'       => array (
                'width'      => '50%',
                'text-align' => 'center'
            ),
            'sortable'    => true,
            'formatter'   => \f\ifm::t('title'),
        ),
        'act'   => array (
            'htmlOptions' => array (
                'id'    => '',
                'class' => '',
            ),
            'style'       => array (
                'width' => '10%'
            ),
            'formatter'   => '',
        )
    ),
    'body'  => '',
        ) ;
?>
<?
/* @var $pageWidget \f\w\pageTitle */
$pageWidget = \f\widgetFactory::make('pageTitle') ;
echo $pageWidget->renderTitle(array ( 'title' => \f\ifm::t('roles'), 'links' => array (
        array ( 'title' => '+ ' . \f\ifm::t('add'), 'href' => \f\ifm::app()->baseUrl . 'core/rbac/roleAdd' ) ) )) ;
/* @var $boxWidget \f\w\box */
$boxWidget  = \f\widgetFactory::make('box') ;

echo $boxWidget->begin(array ( 'type' => 'table', 'title' => \f\ifm::t('list') . ' ' . \f\ifm::t('roles') )) ;
echo $table->renderTable($params) ;
echo $boxWidget->flush() ;
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
            "aaSorting": [[2, 'asc']]
        }

        widgetHelper.makeDataTable('#roleTable', newOption, '<?= \f\ifm::app()->baseUrl ?>core/rbac/roles/getRecords');

    });


</script>
