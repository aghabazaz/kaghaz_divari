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
                'width'        => '15%'
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
                'width'        => '20%'
            ),
            'sortable'     => true,
            'formatter'    => \f\ifm::t ( 'titleMemberList2' ),
        ),
        'date_pay'     => array (
            'htmlOptions' => array (
                'id'    => '',
                'class' => '',
            ),
            'style' => array (
                'width'        => '25%'
            ),
            'sortable'     => true,
            'formatter'    => \f\ifm::t ( 'date_pay' ),
        ),
        'type'     => array (
            'htmlOptions' => array (
                'id'    => '',
                'class' => '',
            ),
            'style' => array (
                'width'        => '25%'
            ),
            'sortable'     => true,
            'formatter'    => \f\ifm::t ( 'type' ),
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


$boxWidget = \f\widgetFactory::make ( 'box' ) ;
/* @var $pageWidget \f\w\pageTitle */
$pageWidget = \f\widgetFactory::make ( 'pageTitle' ) ;
echo $pageWidget->renderTitle ( array ( 'title' => \f\ifm::t ( 'statisticalRepUserOperation' ) )  ) ;
echo $boxWidget->begin ( array ( 'type'  => 'table', 'title' => \f\ifm::t ( 'list' ) . \f\ifm::t ( 'statisticalRepUserOperation' ) ) ) ;

echo \f\html::markupEnd ( 'div' ,
    array (
        'htmlOptions' => array (
            'class' => 'widget widget-table' ) )) ;
echo \f\html::markupBegin ( 'div',
    array (
        'htmlOptions' => array (
            'class' => 'col-md-12' ) ) ) ;

$this->registerWidgets ( array (
    'formW'      => 'form',
    'boxW'       => 'box',
    'pageTitleW' => 'pageTitle'
) ) ;

$form = '' ;


$form.=$this->formW->rowStart () ;
$form.=$this->formW->input ( array (
    'htmlOptions' => array (
        'type'       => 'text',
        'name'       => 'date_start',
        'class'      => 'date',
        'id'         => 'date_start',
        'value'      => $row[ 'date_start' ],
    ),
    'label'    => array (
        'text' => \f\ifm::t ( 'date_start' ),
    ),
) ) ;
$form.=$this->formW->rowEnd () ;
$form.=$this->formW->rowStart () ;
$form.=$this->formW->input ( array (
    'htmlOptions' => array (
        'type'       => 'text',
        'name'       => 'date_end',
        'class'      => 'date',
        'id'         => 'date_end',
        'value'      => $row[ 'date_end' ],
    ),
    'label'    => array (
        'text' => \f\ifm::t ( 'date_end' ),
    ),
) ) ;
$form.=$this->formW->rowEnd () ;

$form.=$this->formW->rowStart () ;
$form.=$this->formW->select ( array (
    'htmlOptions' => array (
        'id'       => 'buyerListArr',
        'name'     => 'buyerListArr[]',
        'multiple' => TRUE
    ),
    'label'       => array (
        'text' => \f\ifm::t ( 'buyerList' ),
    ),
    'choices'     => $buyerList,
    'selected'    => '',
) ) ;

$form.=$this->formW->rowEnd () ;

$form.=$this->formW->buttonTag ( array (
    'htmlOptions' => array (
        'type'    => 'button',
        'id'      =>'createRep'
    ),
    'style'=>array(
        'display'=>'block',
        'margin-right'=>'auto',
        'margin-left'=>'auto',
        'margin-bottom'=>'10px !important'
    ),
    'content' => '<i class="fa fa-credit-card"></i> ' . \f\ifm::t ( 'reporting' ) ,
) ) ;


echo $form ;

echo \f\html::markupEnd ( 'div' ) ;

echo \f\html::markupBegin ( 'div',
    array (
        'htmlOptions' => array (
            'class' => 'clear' ) ) ) ;

echo \f\html::markupEnd ( 'div' ) ;

echo \f\html::markupEnd ( 'div' ) ;

echo $boxWidget->flush () ;

/* @var $boxWidget \f\w\box */
$boxWidget = \f\widgetFactory::make ( 'box' ) ;


echo $boxWidget->begin ( array ( 'type'  => 'table', 'title' => \f\ifm::t ( 'list' ) . \f\ifm::t ( 'statisticalRepUserOperation' ) ) ) ;

echo $table->renderTable ( $params ) ;
echo $boxWidget->flush () ;
?>
<script>
    widgetHelper.makeSelect2('select','<?= \f\ifm::t ( 'select' ) ?>');
    var newOption = {
            "serverSide": true,
            "sServerMethod":"POST",

           /* "aoColumns": [
            {
                "bSortable": false
            },
            null,
            null,
            null
            ],*/
            "aaSorting": [[1, 'asc']],

       };
        widgetHelper.makeDataTable('#myTable' , newOption , '<?= \f\ifm::app ()->baseUrl ?>accountingStock/statisticalReports/userOperateRep/userOperateList');
   $('.date').each(function () {

       var selector = "#" + $(this).attr('id');
       var lang = 'fa';
       var newOption = {
           minDate: '',
           changeMonth: true,
           changeYear: true

       }
       var newOptionTo = {}
       widgetHelper.makeDatePicker(selector, lang, newOption, newOptionTo);

   });
    $('#createRep').click(function(){
       // return;
        var dateStart=$("#date_start").val();
        if(dateStart!=''){
            dateStart=dateStart.replace("/", " ");
            dateStart=dateStart.replace("/", " ");
        }else{
            dateStart='-';
        }
        var dateEnd=$("#date_end").val();
        if(dateEnd!=''){
            dateEnd=dateEnd.replace("/", " ");
            dateEnd=dateEnd.replace("/", " ");
        }else{
            dateEnd='-';
        }
        var userId=$('#buyerListArr').val();

        widgetHelper.refreshDataTable('#myTable','<?= \f\ifm::app()->baseUrl ?>accountingStock/statisticalReports/userOperateRep/userOperateList2/'+dateStart+'/'+dateEnd+'/'+userId);
    });

</script>

<style>
    .listmemberListUser{
        float:left;
        clear:both;
    }
</style>
