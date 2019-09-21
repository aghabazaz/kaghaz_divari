<?php
$title = $row ? 'editSms' : 'addSms' ;


$this->registerWidgets ( array (
    'formW'      => 'form',
    'boxW'       => 'box',
    'pageTitleW' => 'pageTitle'
) ) ;


echo $this->pageTitleW->renderTitle ( array (
    'title' => \f\ifm::t ( $title ),
    'links' => array (
        array (
            'title' => \f\ifm::t ( 'listSms' ),
            'href'  => \f\ifm::app ()->baseUrl . 'newsletter/templateSend/smsTemp/index' ) ) ) ) ;

echo $this->boxW->begin ( array (
    'type'  => 'form',
    'title' => \f\ifm::t ( $title ) ) ) ;



$form = '' ;
$form.=$this->formW->begin ( array (
    'htmlOptions' => array (
        'method' => 'post',
        'action' => \f\ifm::app ()->baseUrl . 'newsletter/templateSend/smsTemp/smsTempSave',
        'id'     => 'smsTempAdd',
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
$form.=$this->formW->input ( array (
    'htmlOptions' => array (
        'type'  => 'text',
        'name'  => 'title',
        'value' => $row[ 'title' ],
    ),
    'validation'  => array (
        'required' => ''
    ),
    'label'       => array (
        'text' => \f\ifm::t ( 'titleSms' ),
    ),
        ) ) ;
$form.=$this->formW->rowEnd () ;
$form.=$this->formW->rowStart () ;

$form.=$this->formW->select ( array (
    'htmlOptions' => array (
        'name' => 'cat_id',
        'id'   => 'cat_id'
    ),
    'label'       => array (
        'text' => \f\ifm::t ( 'category' )
    ),
    'validation'  => array (
        'required' => ''
    ),
    'choices'     => $category,
    'selected'    => $row[ 'cat_id' ] ? $row[ 'cat_id' ] : ''
        ) ) ;
$form.=$this->formW->rowEnd () ;

$form.=$this->formW->rowStart () ;
$form.=$this->formW->textarea ( array (
    'htmlOptions' => array (
        'name' => 'template',
        'rows'=>5
    ),
    'label' => array (
        'text'    => \f\ifm::t ( 'template' )
    ),
    'content' => $row[ 'template' ]
        ) ) ;

$form.=$this->formW->rowEnd () ;

$form.='<div class="formRow">'
        . '<div class="col-sm-10">'
        . '<label class="col-sm-3 control-label">الگوهای قابل استفاده</label>'
        . '<div class="col-sm-9">'
        . '<table style="border:1px solid #eee;background: white" width="100%">
        <tbody><tr style="background:#eee">
                <td width="50%" style="padding:2px">عنوان</td>
                <td width="50%">الگو</td>
            </tr>
            <tr style="border-bottom:1px solid #eee">
                <td style="color:gray;padding: 2px">نام محصول</td>
                <td>#title#</td>
            </tr>
            <tr style="border-bottom:1px solid #eee">
                <td style="color:gray;padding: 2px">نام (انگلیسی)</td>
                <td>#title_sub#</td>
            </tr>
            <tr style="border-bottom:1px solid #eee">
                <td style="color:gray;padding: 2px">برند فارسی</td>
                <td>#brand_fa#</td>
            </tr>
            <tr style="border-bottom:1px solid #eee">
                <td style="color:gray;padding: 2px">لینک</td>
                <td>#link#</td>
            </tr>
            

        </tbody>
    </table>'
        . '</div>'
        . '</div>'
        . '<div class="clear"></div>'
        . '</div>' ;


$form.=$this->formW->rowStart () ;
$form.=$this->formW->buttonTag ( array (
    'htmlOptions' => array (
        'type' => 'submit',
    ),
    'content'     => '<i class="fa fa-floppy-o"></i> ' . ($row ? \f\ifm::t ( 'saveEdit' ) : \f\ifm::t ( 'saveNew' )),
        ) ) ;
$form.=$this->formW->rowEnd () ;


$form.=$this->formW->flush () ;

echo $form ;

echo $this->boxW->flush () ;
?>
<script>
    widgetHelper.makeSelect2('#cat_id', '<?= \f\ifm::t ( 'select' ) ?>');
    widgetHelper.formSubmit('#smsTempAdd');


</script>

