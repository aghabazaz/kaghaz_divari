<?php
//echo $param;
$title = $row ? 'editSellers' : 'addSellers' ;
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
            'title' => \f\ifm::t ( 'sellersList' ),
            'href'  => \f\ifm::app ()->baseUrl . 'member/memberList/sellers/index' ) ) ) ) ;


echo $this->boxW->begin ( array (
    'type'  => 'form',
    'title' => \f\ifm::t ( $title ) ) ) ;



$form = '' ;
$form.=$this->formW->begin ( array (
    'htmlOptions' => array (
        'method' => 'post',
        'action' => \f\ifm::app ()->baseUrl . 'member/memberList/sellers/sellersSave',
        'id'     => 'sellersAdd'
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
    'name'       => 'username',
    'value'      => $row[ 'username' ],
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
        'normUser'=>'کاربر عادی',
        'seller'=>'فروشنده'
    ),
    'selected' => ($row[ 'type_user' ]==null?'seller':$row[ 'type_user' ])
) ) ;
$form.=$this->formW->rowEnd () ;

$form.=$this->formW->rowStart () ;
$form.=$this->formW->select ( array (
    'htmlOptions' => array (
        'name'     => 'statusAccount',
    ),
    'label'    => array (
        'text'     => \f\ifm::t ( 'statusAccount' )
    ),
    'choices'  => array(
        'goodAccount'=>'خوش حساب',
        'badAccount'=>'بد حساب'
    ),
    'selected' => $row[ 'statusAccount' ]
) ) ;
$form.=$this->formW->rowEnd () ;

$form.=$this->formW->rowStart () ;
$form.=$this->formW->input ( array (
    'htmlOptions' => array(
        'type'       => 'text',
        'name'       => 'phone',
        'value'      => $row[ 'phone' ],
    ) ,
    'label'    => array (
        'text' => \f\ifm::t ( 'phoneMember' ),
    ),
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
        'text' => \f\ifm::t ( 'mobileNum' ),
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

$form .= $this->formW->fieldsetStart(array(
    'legend' => array(
        'text' => \f\ifm::t('creditPrice')
    )
));
$form.=$this->formW->rowStart () ;
$form.=$this->formW->input ( array (
    'htmlOptions' => array(
        'type'       => 'text',
        'name'       => 'wallet_credit',
        'class'=>'comma',
        'value'      => number_format($row[ 'wallet_credit' ]),
    ) ,
    'label'    => array (
        'text' => \f\ifm::t ( 'wallet_credit' ),
    ),
) ) ;
$form.=$this->formW->rowEnd () ;


$form.=$this->formW->rowStart () ;
$form.=$this->formW->input ( array (
    'htmlOptions' => array(
        'type'       => 'text',
        'name'       => 'creditPurchaseCeiling',
        'class'=>'comma',
        'value'      => number_format($row[ 'creditPurchaseCeiling' ]),
    ) ,
    'label'    => array (
        'text' => \f\ifm::t ( 'creditPurchaseCeiling' ),
    ),
) ) ;
$form.=$this->formW->rowEnd () ;

$form.=$this->formW->rowStart () ;
$form.=$this->formW->input ( array (
    'htmlOptions' => array(
        'type'       => 'text',
        'name'       => 'creditPurchaseFloor',
        'class'=>'comma',
        'value'      => number_format($row[ 'creditPurchaseFloor' ]),
    ) ,
    'label'    => array (
        'text' => \f\ifm::t ( 'creditPurchaseFloor' ),
    ),
) ) ;
$form.=$this->formW->rowEnd () ;

$form.=$this->formW->rowStart () ;
$form.=$this->formW->input ( array (
    'htmlOptions' => array(
        'type'       => 'text',
        'name'       => 'minPurchase',
        'value'      => number_format($row[ 'minPurchase' ]),
        'class'=>'comma'
    ) ,
    'label'    => array (
        'text' => \f\ifm::t ( 'minPurchase' ),
    ),
) ) ;
$form.=$this->formW->rowEnd () ;


$form .= $this->formW->rowStart () ;
$form .= $this->formW->input ( array (
    'htmlOptions' => array (
        'type'  => 'text',
        'name'  => 'day_settlement',
        'id'    => 'day_settlement',
        'value' => $row[ 'day_settlement' ],
    ),
    'label'       => array (
        'text' => \f\ifm::t ( 'day_settlement' ),
    ),
) ) ;
$form .= $this->formW->rowEnd () ;


$form.=$this->formW->rowStart () ;
$form.=$this->formW->input ( array (
    'htmlOptions' => array(
        'type'       => 'text',
        'name'       => 'conditional_number',
        'value'      => number_format($row[ 'conditional_number' ]),
        'class'=>'comma'
    ) ,
    'label'    => array (
        'text' => \f\ifm::t ( 'conditional_number' ),
    ),
) ) ;
$form.=$this->formW->rowEnd () ;

$form .= $this->formW->fieldsetEnd () ;

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
        widgetHelper.formSubmit('#sellersAdd');
        $(document).ready(function () {
            $('.date').each(function () {

                var selector = "#" + $(this).attr('id');
                var lang = 'fa';
                var newOption = {
                };
                var newOptionTo = {};
                widgetHelper.makeDatePicker(selector, lang, newOption, newOptionTo);

            });
            $(".comma").keyup(function ()
            {
                addCommas(this);
            });
        });
    </script>

<?

?>