<?php
$title = $row ? 'editNlMember' : 'addNlMember' ;


$cat = array_keys ( $category ) ;

$this->registerWidgets ( array (
    'formW'      => 'form',
    'boxW'       => 'box',
    'pageTitleW' => 'pageTitle'
) ) ;


echo $this->pageTitleW->renderTitle ( array (
    'title' => \f\ifm::t ( $title ),
    'links' => array (
        array (
            'title' => \f\ifm::t ( 'listNlMember' ),
            'href'  => \f\ifm::app ()->baseUrl . 'newsletter/nlMember/index' ) ) ) ) ;

echo $this->boxW->begin ( array (
    'type'  => 'form',
    'title' => \f\ifm::t ( $title ) ) ) ;



$form = '' ;
$form.=$this->formW->begin ( array (
    'htmlOptions' => array (
        'method' => 'post',
        'action' => \f\ifm::app ()->baseUrl . 'newsletter/nlMember/nlMemberSave',
        'id'     => 'nlMemberAdd',
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
        'name'  => 'name',
        'value' => $row[ 'name' ],
    ),
    'validation'  => array (
        'required' => ''
    ),
    'label'       => array (
        'text' => \f\ifm::t ( 'name' ),
    ),
        ) ) ;
$form.=$this->formW->rowEnd () ;

$form.=$this->formW->rowStart () ;
$form.=$this->formW->input ( array (
    'htmlOptions' => array (
        'type'  => 'email',
        'name'  => 'email',
        'value' => $row[ 'email' ],
    ),
    'label'       => array (
        'text' => \f\ifm::t ( 'email' ),
    ),
        ) ) ;
$form.=$this->formW->rowEnd () ;

$form.=$this->formW->rowStart () ;
$form.=$this->formW->input ( array (
    'htmlOptions' => array (
        'type'                   => 'text',
        'name'                   => 'mobile',
        'value'                  => $row[ 'mobile' ],
        'data-parsley-type'      => 'number',
        'data-parsley-minlength' => '10',
    ),
    'label'       => array (
        'text' => \f\ifm::t ( 'mobile' ),
    ),
        ) ) ;
$form.=$this->formW->rowEnd () ;

//$form.=$this->formW->rowStart () ;
//
//$form.=$this->formW->select ( array (
//    'htmlOptions' => array (
//        'name'     => 'category[]',
//        'multiple' => TRUE,
//        'id'       => 'category',
//    ),
//    'label'       => array (
//        'text' => \f\ifm::t ( 'category' )
//    ),
//    'choices'     => $category,
//    'selected'    => $catMe
//        ) ) ;
//$form.=$this->formW->rowEnd () ;

if ( $row[ 'id' ] )
{
    $form.=$this->formW->rowStart () ;
    $form.=$this->formW->input ( array (
        'htmlOptions' => array (
            'type' => 'checkbox',
            'name' => 'newsletterCancel',
        ),
        'label'       => array (
            'text' => \f\ifm::t ( 'newsletterCancel' ),
        ),
            ) ) ;
    $form.=$this->formW->rowEnd () ;
}

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
    widgetHelper.makeSelect2('#category', '<?= \f\ifm::t ( 'select' ) ?>');
    widgetHelper.formSubmit('#nlMemberAdd');

</script>

