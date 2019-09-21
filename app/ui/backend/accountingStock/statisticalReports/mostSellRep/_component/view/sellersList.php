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
        'username'     => array (
            'htmlOptions' => array (
                'id'    => '',
                'class' => '',
            ),
            'style' => array (
                'width'        => '10%'
            ),
            'sortable'     => true,
            'formatter'    => \f\ifm::t ( 'titleMemberList' ),
        ),
        'name'     => array (
            'htmlOptions' => array (
                'id'    => '',
                'class' => '',
            ),
            'style' => array (
                'width'        => '10%'
            ),
            'sortable'     => true,
            'formatter'    => \f\ifm::t ( 'titleMemberList2' ),
        ),
        'mobile'     => array (
            'htmlOptions' => array (
                'id'    => '',
                'class' => '',
            ),
            'style' => array (
                'width'        => '10%'
            ),
            'sortable'     => true,
            'formatter'    => \f\ifm::t ( 'mobileMember' ),
        ),
        'email'     => array (
            'htmlOptions' => array (
                'id'    => '',
                'class' => '',
            ),
            'style' => array (
                'width'        => '15%'
            ),
            'sortable'     => true,
            'formatter'    => \f\ifm::t ( 'emailMember' ),
        ),
        'credit_point' => array (
            'htmlOptions' => array (
                'id'    => '',
                'class' => '',
            ),
            'style' => array (
                'width'     => '20%'
            ),
            'formatter' => \f\ifm::t ( 'date_register' ),
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
echo $pageWidget->renderTitle ( array ( 'title' => \f\ifm::t ( 'sellersList' ), 'links' => array ( array ( 'title'    => '+ ' . \f\ifm::t ( 'addSellersList' ), 'href'     => \f\ifm::app ()->baseUrl . 'member/memberList/sellers/sellersAdd/' . $param ) ) ) ) ;
/* @var $boxWidget \f\w\box */
$boxWidget = \f\widgetFactory::make ( 'box' ) ;
echo $boxWidget->begin ( array ( 'type'  => 'table', 'title' => \f\ifm::t ( 'list' ) . \f\ifm::t ( 'sellersList' ) ) ) ;


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
            "aaSorting": [[1, 'asc']]
        }

        widgetHelper.makeDataTable('#myTable' , newOption , '<?= \f\ifm::app ()->baseUrl ?>member/memberList/sellers/sellersList');
    });


</script>

<style>
    .listmemberListUser{
        float:left;
        clear:both;
    }
</style>
