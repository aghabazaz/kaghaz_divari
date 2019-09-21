
<?php
/* @var $pageWidget \f\w\pageTitle */
$pageWidget = \f\widgetFactory::make ( 'pageTitle' ) ;
echo $pageWidget->renderTitle ( array ( 'title' => \f\ifm::t ( 'category' ), 'links' => array ( array ( 'title'    => '+ ' . \f\ifm::t ( 'addcategory' ), 'href'     => \f\ifm::app ()->baseUrl . 'shop/category/categoryAdd/' . $param ) ) ) ) ;

/* @var $boxWidget \f\w\box */
$boxWidget = \f\widgetFactory::make ( 'box' ) ;
echo $boxWidget->begin ( array ( 'type'  => 'table', 'title' => \f\ifm::t ( 'list' ) . \f\ifm::t ( 'category' ) ) ) ;
echo $row ;
echo $boxWidget->flush () ;
?> 
<script>
   
    $(document).ready(function () {
        $('#categoryTable').dataTable({
            "bSort" : false,
            "paging": false
        });


    }); 
     
</script>

<style>
    .listslideUser{
        float:left;
        clear:both;
    }
</style>
