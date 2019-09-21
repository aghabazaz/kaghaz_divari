<?php

/* @var $table \f\w\table */
$table = \f\widgetFactory::make ( 'table' ) ;

$params = array (
    'table' => array (
        'title'       => \f\ifm::t ( $param ),
        'htmlOptions' => array (
            'id'          => 'myTable',
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
        'name'      => array (
            'htmlOptions' => array (
                'id'    => '',
                'class' => '',
            ),
            'style' => array (
                'width'     => '50%'
            ),
            'sortable'  => true,
            'formatter' => \f\ifm::t ( 'name' ),
        ),
        'phone'     => array (
            'htmlOptions' => array (
                'id'    => '',
                'class' => '',
            ),
            'style' => array (
                'width'     => '15%'
            ),
            'formatter' => \f\ifm::t ( 'phone' ),
        ),
        'email'     => array (
            'htmlOptions' => array (
                'id'    => '',
                'class' => '',
            ),
            'style' => array (
                'width'     => '15%'
            ),
            'formatter' => \f\ifm::t ( 'email' ),
        ),
        'act'       => array (
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
<?php 
/* @var $pageWidget \f\w\pageTitle */
$pageWidget=\f\widgetFactory::make ( 'pageTitle' ) ;
echo $pageWidget->renderTitle(array('title'=>\f\ifm::t ( $param ),'links'=>array(array('title'=> '+ '.\f\ifm::t ( 'add' ),'href'=>\f\ifm::app ()->baseUrl . 'core/user/userAdd/' . $param))));
/* @var $boxWidget \f\w\box */
$boxWidget=\f\widgetFactory::make ( 'box' ) ;
echo $boxWidget->begin(array('type'=>'table','title'=>\f\ifm::t ('list').\f\ifm::t ( $param )));
echo $table->renderTable ( $params ) ;
echo $boxWidget->flush ();

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
            
        widgetHelper.makeDataTable('#myTable' , newOption , '<?= \f\ifm::app ()->baseUrl ?>core/user/userList/<?= $param ?>');
         
    });   
  
     
</script>
