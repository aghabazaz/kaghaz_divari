<?php


$this->registerWidgets ( array (
    'formW'      => 'form',
    'boxW'       => 'box',
    'pageTitleW' => 'pageTitle'
) ) ;


//$this->

echo $this->pageTitleW->renderTitle ( array (
    'title' => \f\ifm::t ( 'cmsReports' )
   ) ) ;


echo $this->boxW->begin ( array (
    'type'  => 'form',
    'title' => \f\ifm::t ( 'cmsReports' ) ) ) ;



$form = '' ;
$form.=$this->formW->begin ( array (
    'htmlOptions' => array (
        'method' => 'post',
        'action' => \f\ifm::app ()->baseUrl . 'accountingStock/reports/reportsSave',
        'id'     => 'reportAdd'
    ),
        ) ) ;
$form.=$this->formW->input ( array (
    'htmlOptions' => array (
        'type'  => 'hidden',
        'name'  => 'id',
        'value' => $row[ 'id' ],
    ),
        ) ) ;

$form.=$this->formW->rowStart () ;
$form.=$this->formW->select ( array (
    'htmlOptions' => array (
        'id'       => 'typeReport',
        'name'     => 'typeReport',
        'multiple' => TRUE
    ),
    'label'       => array (
        'text' => \f\ifm::t ( 'typeReport' ),
    ),
    'choices'     => array(
            'userOperation'=>'عملکرد کاربران',
            'userTypeDealler'=>'مشخص کردن کاربران خوش حساب و بدحساب',
            'deptUser'=>'میزان بدهی کاربران',
        'sellPro'=>' فروش کالا براسا دسته بندی، برند و محصول',
        ''
    ),
    'selected'    => '',
) ) ;

$form.=$this->formW->rowEnd () ;
//$form.=$this->formW->rowStart () ;
//$form.=$this->formW->textarea ( array (
//    'htmlOptions' => array (
//        'name'       => 'short',
//        'value'      => $row[ 'short' ],
//        'rows'       => 4
//    ),
//    'validation' => array (
//        'required' => ''
//    ),
//    'label'    => array (
//        'text'    => \f\ifm::t ( 'shortContent' )
//    ),
//    'content' => $row[ 'short' ]
//        ) ) ;
//$form.=$this->formW->rowEnd () ;



$form.=$this->formW->rowStart () ;
$form.=$this->formW->input ( array (
    'htmlOptions' => array (
        'type'       => 'text',
        'name'       => 'date_start',
        'class'      => 'date',
        'id'         => 'date_start',
     //   'value'      => $row[ 'date_start' ],
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
    ),
    'label'    => array (
        'text' => \f\ifm::t ( 'date_end' ),
    ),
        ) ) ;
$form.=$this->formW->rowEnd () ;
$form.=$this->formW->rowStart () ;
$form.=$this->formW->select ( array (
    'htmlOptions' => array (
        'id'       => 'brand',
        'name'     => 'brand[]',
        'multiple' => TRUE
    ),
    'label'       => array (
        'text' => \f\ifm::t ( 'brand' ),
    ),
    'choices'     => $brand,
    'selected'    => '',
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
    'choices'     => $buyerListArr,
    'selected'    => '',
        ) ) ;

$form.=$this->formW->rowEnd () ;
$form.=$this->formW->rowStart () ;
$form.=$this->formW->input ( array (
    'htmlOptions' => array (
        'type'  => 'hidden',
        'id'    => 'oldCat',
        'value' => $row[ 'shop_category_id' ],
    ),
        ) ) ;
$form.=$this->formW->rowStart () ;
$form.='<div class="col-sm-10">'
        . '<label class="col-sm-3 control-label">بخش بندی محصول</label>'
        . '<div class="col-sm-9">'
        . '<select name="category" id="category" onChange="loadFeature()" ><option></option>' ;

foreach ( $category AS $data )
{
    if ( $row[ 'shop_category_id' ] == $data[ 'id' ] )
    {
        $selected = "selected" ;
    }
    else
    {
        $selected = "" ;
    }
    $form.='<option value="' . $data[ 'id' ] . '" id="' . $data[ 'parent' ] . '" ' . $selected . '>'
            . $data[ 'title' ]
            . '</option>' ;
}
$form.= '</select>'
        . '</div>'
        . '<div class="clear"></div>'
        . '</div>' ;

$form.=$this->formW->rowEnd () ;


$form.=$this->formW->rowStart () ;
$form.=$this->formW->buttonTag ( array (
    'htmlOptions' => array (
        'type'    => 'submit',
    ),
    'content' => '<i class="fa fa-floppy-o"></i> ' . ( \f\ifm::t ( 'saveReport' )),
        ) ) ;
$form.=$this->formW->rowEnd () ;


$form.=$this->formW->flush () ;

echo $form ;
echo $this->formW->rowStart () ;
echo $this->formW->colStart () ;
echo '<div id="downloadLink" style="margin-top:20px;"></div>' ;
echo $this->formW->colEnd () ;
echo $this->formW->rowEnd () ;

echo $this->boxW->flush () ;
?>

<!--
<input type="hidden" id="thisid" style="width:300px" multiple="multiple" class="input-xlarge" />
-->
<script>
    widgetHelper.makeSelect2('select','<?= \f\ifm::t ( 'select' ) ?>');
    widgetHelper.formSubmit('#reportAdd');
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
    
    function creatLink()
    {
        $('#downloadLink').html('<a href="<?php echo \f\ifm::app()->siteUrl.'upload/report.xls'?>"><i class="fa fa-file-excel-o"></i> دانلود خروجی گزارش در قالب اکسل</a>');
        
        document.location.href ="<?php echo \f\ifm::app()->siteUrl.'upload/report.xls'?>" ;
    }
   

    
</script>

