<?php
/* @var $this membersView */

$this->registerWidgets ( array (
    'formW'      => 'form',
    'boxW'       => 'box',
    'pageTitleW' => 'pageTitle'
) ) ;


//$this->

echo $this->pageTitleW->renderTitle ( array (
    'title' => \f\ifm::t ( 'surveyShowChart' ),
    'links' => array (
        array (
            'title' => \f\ifm::t ( 'listSurvey' ),
            'href'  => \f\ifm::app ()->baseUrl . 'cms/survey/index' ) ) ) ) ;


echo $this->boxW->begin ( array (
    'type'  => 'form',
    'title' => $survey[ 'title' ] ) ) ;

$form.=$this->formW->rowStart () ;
$form.=\f\ifm::t('question').' : '.$survey['question'];
$form.=$this->formW->rowEnd () ;
$i=0;
foreach ($answres AS $data)
{
    $form.=$this->formW->rowStart () ;
    $i++;
    $form.='<li style="color:gray;margin-right:30px">';
    $form.='گزینه '.$i.' : '.$data['title'];
    $form.='</li>';
    $form.=$this->formW->rowEnd () ;
}
$form.='<br>' ;
$form.=$this->formW->rowStart () ;
$form.='<div style="background:#BAE2FF;border-radius:5px;padding:5px;width:auto;display:inline">تعداد کل شرکت کنندگان : '.$survey['number'].' نفر</div>';
$form.=$this->formW->rowEnd () ;
$form.='<br>' ;
$form.=$this->formW->rowStart () ;
$form.="<div id='survey_chart'></div>" ;
$form.=$this->formW->rowEnd () ;
$form.='<br>' ;


echo $form ;

echo $this->boxW->flush () ;
?>

<script>
 
    jQuery(document).ready(function () {
        var id='survey_chart';
        var questionId='<?=$survey['questionId']?>';
        var pollId='<?=$survey['id']?>';
        getChartByCount(id,questionId,pollId);
    });


    function getChartByCount(id,questionId,pollId) {
        var options = {
            id: id,
            questionId:questionId,
            pollId:pollId
                                  
                                    
        };
        widgetHelper.tt("ui", "cms.survey.getChartByCount", options, 'makeChart');
    }
</script>

<? ?>