<?php
$title = $row ? 'editSurvey' : 'addSurvey' ;
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
            'title' => \f\ifm::t ( 'listSurvey' ),
            'href'  => \f\ifm::app ()->baseUrl . 'cms/survey/index' ) ) ) ) ;


echo $this->boxW->begin ( array (
    'type'  => 'form',
    'title' => \f\ifm::t ( $title ) ) ) ;



$form = '' ;
$form.=$this->formW->begin ( array (
    'htmlOptions' => array (
        'method' => 'post',
        'action' => \f\ifm::app ()->baseUrl . 'cms/survey/surveySave',
        'id'     => 'slideAdd'
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
        'type'       => 'text',
        'name'       => 'title',
        'value'      => $row[ 'title' ],
    ),
    'validation' => array (
        'required' => ''
    ),
    'label'    => array (
        'text' => \f\ifm::t ( 'titleSurvey' ),
    ),
        ) ) ;
$form.=$this->formW->rowEnd () ;

$form.=$this->formW->rowStart () ;
$form.=$this->formW->radio ( array (
    'htmlOptions' => array (
        'name'    => 'typechoose',
    ),
    'choices' => $chossArr,
    'label'                => array (
        'text'    => \f\ifm::t ( 'choose' ),
    ),
    'checked' => $row[ 'typechoose' ] ? $row[ 'typechoose' ] : 'one',
    'linear'  => TRUE
        ) ) ;
$form.=$this->formW->rowEnd () ;

$form.=$this->formW->rowStart () ;
$form.=$this->formW->radio ( array (
    'htmlOptions' => array (
        'name'    => 'typevisitors',
    ),
    'choices' => $visitArr,
    'label'                => array (
        'text'    => \f\ifm::t ( 'visitors' ),
    ),
    'checked' => $row[ 'typevisitors' ] ? $row[ 'typevisitors' ] : 'all',
    'linear'  => TRUE
        ) ) ;
$form.=$this->formW->rowEnd () ;

$form.=$this->formW->rowStart () ;
$form.=$this->formW->radio ( array (
    'htmlOptions' => array (
        'name'    => 'typechart',
    ),
    'choices' => $chartArr,
    'label'                => array (
        'text'    => \f\ifm::t ( 'typechart' ),
    ),
    'checked' => $row[ 'typechart' ] ? $row[ 'typechart' ] : 'hide',
    'linear'  => TRUE
        ) ) ;
$form.=$this->formW->rowEnd () ;


$form.=$this->formW->rowStart () ;
$form.=$this->formW->textarea ( array (
    'htmlOptions' => array (
        'name'  => 'question',
    ),
    'label' => array (
        'text'    => \f\ifm::t ( 'question' )
    ),
    'content' => $row[ 'question' ]
        ) ) ;

$form.=$this->formW->rowEnd () ;

$form.=$this->formW->rowStart () ;
$form.="<div class='col-sm-10'><label class='col-sm-3 control-label' for='answer[]'>" . \f\ifm::t ( 'answer' ) . "</label>" ;
$form.="<div class='col-sm-9'><table id='answerTable' style='width:100%'>
                        <tr>                         
                         
                          <th style='width:85%'>" . \f\ifm::t ( '' ) . "</th>
                           <th style='width:5%'> " . \f\ifm::t ( '' ) . " </th>
                          <th style='width:10%'>" . \f\ifm::t ( '' ) . "</th>
                        </tr>" ;
if ( $choices )
{
    foreach ( $choices as $answer )
    {
        $form.=" <tr><td>" ;
         $form.=$this->formW->input ( array (
            'htmlOptions' => array (
                'name'  => 'answer[]',
                'type'  => 'text',
                'value' => $answer[ 'title' ],
            ),
            'style' => array (
                'width'  => '100%',
                'margin' => '5px'
            ),
                ) ) ;
        
        $form.=" </td><td>" ;
       $form.=$this->formW->input ( array (
            'htmlOptions' => array (
                'name'  => 'answerId[]',
                'class' => 'answerId',
                'type'  => 'hidden',
                'value' => $answer[ 'id' ],
            ),
            'style' => array (
                'width'  => '100%',
                'margin' => '5px'
            ),
                ) ) ;
        $form.=" </td><td>
    <a href='javascript:void(0)'  class='removeanswer'><i class='fa fa-times'></i></a>
                              </td>
                              </tr>" ;
    }
}
else
{
    $form.=" <tr><td>" ;
     $form.=$this->formW->input ( array (
        'htmlOptions' => array (
            'name'  => 'answer[]',
            'type'  => 'text',
            'value' => '',
        ),
        'style' => array (
            'width'  => '100%',
            'margin' => '5px'
        ),
            ) ) ;
    $form.=" </td><td>" ;
    $form.=$this->formW->input ( array (
        'htmlOptions' => array (
            'name'  => 'answerId[]',
            'class' => 'answerId',
            'type'  => 'hidden',
            'value' => $answer[ 'id' ],
        ),
        'style' => array (
            'width'  => '100%',
            'margin' => '5px'
        ),
            ) ) ;
   
    $form.=" </td><td>
  <a href='javascript:void(0)'  class='removeanswer'><i class='fa fa-times'></i></a>
                              </td>
                              </tr>" ;
}

$form.=" </table> </div><a href='javascript:void(0)' id ='addanswer'><i class='fa fa-plus-circle'></i> " . \f\ifm::t ( 'addanswer' ) . "</a></div>" ;

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
    widgetHelper.formSubmit('#slideAdd');
    
    jQuery(document).ready(function () {
        $("#addanswer").click(function() {
            $("table tr:last").clone().find("input").each(function() {
                $(this).val('').attr({
                    'value': ''               
                });
            }).end().appendTo("#answerTable");
                          
            $('a.removeanswer').on('click',function() {
                $(this).closest( 'tr').remove();
                return false;
            });
            i++;
        });
        $('a.removeanswer').on('click',function() {
            $(this).closest( 'tr').remove();
        });
    });
</script>

<? ?>