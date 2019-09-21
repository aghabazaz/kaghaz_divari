<?php
//echo $param;
$title = $row ? 'editmemberList' : 'addmemberList' ;
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
            'title' => \f\ifm::t ( 'normUsersList' ),
            'href'  => \f\ifm::app ()->baseUrl . 'member/memberList/normUsers/index' ) ) ) ) ;


echo $this->boxW->begin ( array (
    'type'  => 'form',
    'title' => \f\ifm::t ( $title ) ) ) ;



$form = '' ;
$form.=$this->formW->begin ( array (
    'htmlOptions' => array (
        'method' => 'post',
        'action' => \f\ifm::app ()->baseUrl . 'member/memberList/normUsers/normUsersSave',
        'id'     => 'normUsersAdd'
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
    'htmlOptions' => array(
        'type'       => 'text',
        'name'       => 'name',
        'value'      => $row[ 'name' ],
    ) ,
    'validation' => array (
        'required' => ''
    ),

    'label'    => array (
        'text' => \f\ifm::t ( 'titleMemberList2' ),
    ),
) ) ;
$form.=$this->formW->rowEnd () ;

$form.=$this->formW->rowStart () ;
$htmlOptions=array (
    'type'       => 'text',
    'name'       => 'mobile',
    'value'      => $row[ 'mobile' ],
);
if($row['id'])//if mode edit => disable change username
{
    $htmlOptions['disabled']='';
}
$form.=$this->formW->input ( array (
    'htmlOptions' =>$htmlOptions ,
    'validation' => array (
        'required' => ''
    ),

    'label'    => array (
        'text' => \f\ifm::t ( 'titleMemberList' ),
    ),
) ) ;
$form.=$this->formW->rowEnd () ;
$form.=$this->formW->rowStart () ;
$form.=$this->formW->select ( array (
    'htmlOptions' => array (
        'name'     => 'type_user',
    ),
    'label'    => array (
        'text'     => \f\ifm::t ( 'typeUser' )
    ),
    'choices'  => array(
        'normUser'=>'کاربر عادی'
    ),
    'selected' => ($row[ 'type_user' ]==null?'normUser':$row[ 'type_user' ])
) ) ;
$form.=$this->formW->rowEnd () ;



$form.=$this->formW->rowStart () ;
$form.=$this->formW->input ( array (
    'htmlOptions' => array(
        'type'       => 'email',
        'name'       => 'email',
        'value'      => $row[ 'email' ],
    ) ,

    'label'    => array (
        'text' => \f\ifm::t ( 'emailMember' ),
    ),
) ) ;
$form.=$this->formW->rowEnd () ;

$form.=$this->formW->rowStart () ;
if(!isset($row['id']))//if mode edit => disable change username
{
    $required =array (
        'required' => ''
    );
}else{
    $required=array ();
}
$form.=$this->formW->input ( array (
    'htmlOptions' => array(
        'id'         => 'password',
        'type'       => 'password',
        'name'       => 'password',

    ) ,
    'validation' => $required,
    'label'    => array (
        'text' => \f\ifm::t ( 'passMember' ),
    ),
) ) ;
$form.=$this->formW->rowEnd () ;

$form.=$this->formW->rowStart () ;
$form.=$this->formW->input ( array (
    'htmlOptions' => array(
        'type'                  => 'password',
        'name'                  => 'password_re',
        'data-parsley-equalto'  => '#password',
    ) ,
    'validation' => $required,

    'label'    => array (
        'text' => \f\ifm::t ( 'pass_reMember' ),
    ),
) ) ;
$form.=$this->formW->rowEnd () ;

$form.=$this->formW->rowStart () ;
$form.=$this->formW->input ( array (
    'htmlOptions' => array(
        'type'       => 'text',
        'name'       => 'mobile',
        'value'      => $row[ 'mobile' ],
    ) ,
    'label'    => array (
        'text' => \f\ifm::t ( 'mobileMember' ),
    ),
) ) ;
$form.=$this->formW->rowEnd () ;

$form.=$this->formW->rowStart () ;
$form.=$this->formW->input ( array (
    'htmlOptions' => array(
        'type'       => 'text',
        'name'       => 'address',
        'value'      => $row[ 'address' ],
    ) ,
    'label'    => array (
        'text' => \f\ifm::t ( 'addressMember' ),
    ),
) ) ;
$form.=$this->formW->rowEnd () ;


$form.='<br></br>' ;
$form.=$this->formW->rowStart () ;
$form.=$this->formW->buttonTag ( array (
    'htmlOptions' => array (
        'type'    => 'submit',
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
        widgetHelper.formSubmit('#normUsersAdd');
    </script>

<?

?>