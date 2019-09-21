<?php
$tabWidget = \f\widgetFactory::make( 'tab' );
$tabWidget->begin( [
    'htmlOptions' => [
        'class' => 'mytabs'
    ]
] );
$tabWidget->tab( [
    'active'  => true,
    'title'   => [
        'text' => \f\ifm::t( "category" ),
        'icon' => 'fa-check-square-o'
    ],
    'content' => [
        'content' => $this->render( 'mostSellRepBaseOnProduct',
            [
                // 'mostSellBaseCat'=>$mostSellCat
            ] )
    ],
    'block'   => []
] );
$tabWidget->tab( [
    'title'   => [
        'text' => \f\ifm::t( "category" ),
        'icon' => 'fa-check-square-o'
    ],
    'content' => [
       'content' => $this->render( 'mostSellRepBaseOnCat',
            [
               // 'mostSellBaseCat'=>$mostSellCat
            ] )
    ],
    'block'   => []
] );
$tabWidget->tab( [

    'title'   => [
        'text' => \f\ifm::t( "brand" ),
        'icon' => 'fa-warning'
    ],
    'content' => [
       'content' => $this->render( 'mostSellRepBaseOnBrand',
            [

            ] )
    ],
    'block'   => []
] );
echo $tabWidget->flush();
?>
<script>
    $('.nav-tabs li').removeClass('active');
    $('.tab-content div').removeClass('active');
    $('.nav-tabs li:first-child').addClass('active');
    $('.tab-content div:first-child').addClass('active');

    function activeTab() {
        var url = window.location.href;
        var activeTab = url.substring(url.indexOf("#") + 1);
        //alert(activeTab);
        if (activeTab != url) {
            $(".tab-pane").removeClass("active in");
            $("#" + activeTab).addClass("active in");
            $('a[href="#' + activeTab + '"]').tab('show')
        }
    }

    activeTab();
</script>
