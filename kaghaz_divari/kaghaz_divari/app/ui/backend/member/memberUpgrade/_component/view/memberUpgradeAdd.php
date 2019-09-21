<?php
//echo $param;
$title = $row ? 'editMemberUpgrade' : 'addMemberUpgrade' ;
//var_dump($param);
/* @var $this membersView */

$this->registerWidgets ( array (
    'formW'      => 'form',
    'boxW'       => 'box',
    'pageTitleW' => 'pageTitle'
) ) ;


//$this->

echo $this->pageTitleW->renderTitle ( array (
    'title' => \f\ifm::t ( $title ),
    'links' => array (
        array (
            'title' => \f\ifm::t ( 'memberUpgradeList' ),
            'href'  => \f\ifm::app ()->baseUrl . 'member/memberUpgrade/index' ) ) ) ) ;


echo $this->boxW->begin ( array (
    'type'  => 'form',
    'title' => \f\ifm::t ( $title ) ) ) ;



$form = '' ;
$form.=$this->formW->begin ( array (
    'htmlOptions' => array (
        'method' => 'post',
        'action' => \f\ifm::app ()->baseUrl . 'member/memberUpgrade/memberUpgradeSave',
        'id'     => 'memberUpgradeAdd'
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
        'name'     => 'user_id',
        'disabled'=>'disabled'
        ),
    'label'    => array (
        'text'     => \f\ifm::t ( 'users' )
    ),

    'choices'  => $users,
    'selected' => ($row[ 'user_id' ])
) ) ;
$form.=$this->formW->rowEnd () ;


$form.=$this->formW->rowStart () ;
$form.=$this->formW->input ( array (
    'htmlOptions' => array(
        'type'       => 'text',
        'name'       => 'shop_name',
        'value'      => $row[ 'shop_name' ],
    ) ,
    'validation' => array (
        'required' => ''
    ),

    'label'    => array (
        'text' => \f\ifm::t ( 'shop_name' ),
    ),
) ) ;
$form.=$this->formW->rowEnd () ;

$form.=$this->formW->rowStart () ;
$form.=$this->formW->textarea ( array (
    'htmlOptions' => array (
        'name' => 'address',
    ),
    'label' => array (
        'text'    => \f\ifm::t ( 'address' )
    ),

    'content' => $row[ 'address' ]
) ) ;

$form.=$this->formW->rowEnd () ;
$statusArr2=array('عدم تایید'=>'no','تایید'=>'yes');
$form.=$this->formW->rowStart () ;
$form.=$this->formW->radio ( array (
    'htmlOptions' => array (
        'name' => 'confirmation',
    ),
    'choices'     => $statusArr2,
    'label'       => array (
        'text' => \f\ifm::t ( 'confirmation' ),
    ),
    'checked'     => $row[ 'confirmation' ] ? $row[ 'confirmation' ] : 'disabled',
    'linear'      => TRUE
) ) ;

$form.=$this->formW->rowEnd () ;
$form.=$this->formW->input ( array (
    'htmlOptions' => array(
        'type'       => 'hidden',
        'name'       => 'user_id',
        'value'      => $row[ 'user_id' ],
    ) ,
) ) ;
$form.='<br></br>' ;
$form.=$this->formW->rowStart () ;
$form.=$this->formW->buttonTag ( array (
    'htmlOptions' => array (
        'type'    => 'submit',
    ),
    'style' => array(
        'float'=>'right'
    ),
    'content' => '<i class="fa fa-floppy-o"></i> ' . ($row ? \f\ifm::t ( 'saveEdit' ) : \f\ifm::t ( 'saveNew' )),
) ) ;

$form.=$this->formW->rowEnd () ;


$form.=$this->formW->flush () ;

echo $form ;

echo $this->boxW->flush () ;
?>

    <script>
        widgetHelper.makeSelect2('select','<?= \f\ifm::t ( 'select' ) ?>');
        widgetHelper.formSubmit('#memberUpgradeAdd');

    </script>

<?

?>