
<?php
//echo $param;
/* @var $pageWidget \f\w\pageTitle */
$pageWidget=\f\widgetFactory::make ( 'pageTitle' ) ;
echo $pageWidget->renderTitle(array('title'=>\f\ifm::t ('changePassword')));

/* @var $boxWidget \f\w\box */
$boxWidget=\f\widgetFactory::make ( 'box' ) ;
echo $boxWidget->begin(array('type'=>'form','title'=>\f\ifm::t ('changePassword')));

/* @var $addWidget \f\w\form */
$addWidget = \f\widgetFactory::make ( 'form' ) ;

$form='';
$form.=$addWidget->begin ( array (
        'htmlOptions' => array (
        'method' => 'post',
        'action' => \f\ifm::app ()->baseUrl.'core/user/saveChangePassword',
        'id'=>'changePassword'
    ),
) ) ;
$form.=$addWidget->fieldsetStart ( array (
    'legend' => array (
        'text' =>  \f\ifm::t ('userInfo'),
    ),
) ) ;


$form.=$addWidget->rowStart () ;
$form.=$addWidget->input ( array (
    'htmlOptions' => array (
        'type'    => 'text',
        'name'    => 'username',
        'value'   => $row['username'],
        
    ),
    'validation'=>array (
        'required'=>''
    ),
   
    'style'   => array (
        'direction' => 'ltr',
    ),
   
    'label'     => array (
        'text' => \f\ifm::t ('username'),
    ),
) ) ;

$form.=$addWidget->rowEnd () ;

$form.=$addWidget->rowStart () ;
$form.=$addWidget->input ( array (
    'htmlOptions' => array (
        'type'  => 'password',
        'name'  => 'password',
    ),
     'validation'=>array(
        'required'=>  '' ,
    ),
    'style' => array (
        'direction' => 'ltr',
    ),
    'label'     => array (
        'text' => \f\ifm::t ('currentPassword'),
    ),
) ) ;
$form.=$addWidget->rowEnd () ;

$form.=$addWidget->rowStart () ;
$form.=$addWidget->input ( array (
    'htmlOptions' => array (
        'type'  => 'password',
        'name'  => 'newPassword',
        'id' => 'newPassword'
    ),
     'validation'=>array(
        'required'=> '' ,
    ),
    'style' => array (
        'direction' => 'ltr',
    ),
    'label'     => array (
        'text' => \f\ifm::t ('newPassword'),
    ),
) ) ;
$form.=$addWidget->rowEnd () ;

$form.=$addWidget->rowStart () ;
$form.=$addWidget->input ( array (
    'htmlOptions' => array (
        'type'  => 'password',
        'name'  => 'repeatPassword',
    ),
     'validation'=>array(
        'required'=> '' ,
        'equalto'=>'#newPassword'
    ),
    'style' => array (
        'direction' => 'ltr',
    ),
    'label'     => array (
        'text' => \f\ifm::t ('repPassword'),
    ),
) ) ;
$form.=$addWidget->rowEnd () ;


$form.=$addWidget->fieldsetEnd () ;
$form.=$addWidget->newLine () ;


$form.=$addWidget->rowStart () ;
$form.=$addWidget->button ( array (
    'htmlOptions' => array (
        'type'  => 'submit',
    ),
    'content'  =>  \f\ifm::t ('saveNew'),
) ) ;
$form.=$addWidget->rowEnd () ;

$form.=$addWidget->flush () ;

echo $form;
echo \f\html::markupEnd ( 'div' );
echo $boxWidget->flush ();
?>


<script>
    widgetHelper.formSubmit('#changePassword');
</script>
