<?php
$this->registerWidgets ( array (
    'formW'      => 'form',
    'boxW'       => 'box',
    'pageTitleW' => 'pageTitle'
) ) ;
$this->registerGadgets ( array (
    'strG'  => 'str',
    'dateG' => 'date' ) ) ;


echo \f\html::markupBegin ( 'div' ) ;
echo \f\html::markupBegin ( 'div',
                            array (
    'htmlOptions' => array (
        'class' => 'col-md-6' ) ) ) ;
echo \f\html::markupBegin ( 'i',
                            array (
    'htmlOptions' => array (
        'class' => 'fa fa-bookmark fa-4x' ),
    'style'       => array (
        'float'        => 'right',
        'padding-left' => '20px',
        'padding-top'  => '5px'
) ) ) ;
echo \f\html::markupEnd ( 'i' ) ;
echo \f\html::markupBegin ( 'div',
                            array (
    'style' => array (
        'font-size' => '18px'
    )
) ) ;
echo $row[ 0 ][ 'name' ] ;
echo '<br><span style="font-size:13px;color:gray">' . $row[ 0 ][ 'domain' ] . '</span>' ;
echo \f\html::markupEnd ( 'div' ) ;

echo \f\html::markupEnd ( 'div' ) ;
echo \f\html::markupBegin ( 'div',
                            array (
    'htmlOptions' => array (
        'class' => 'col-md-6' ),
    'style'       => array (
        'text-align' => 'left'
) ) ) ;

$form .= \f\html::markupBegin ( 'button',
                                array (
            'htmlOptions' => array (
                'type'    => 'button',
                'onclick' => 'updateInfo(' . '"' . $row[ 0 ][ 'name' ] . '"' . ')',
                'class'   => 'btn btn-danger' ) ) ) ;
$form .= '<i class="fa fa-refresh"></i> ' . 'بروزرسانی' ;
$form .= \f\html::markupEnd ( 'button' ) ;

echo $form ;

echo \f\html::markupEnd ( 'div' ) ;
echo \f\html::markupBegin ( 'div',
                            array (
    'htmlOptions' => array (
        'class' => 'clear' ) ) ) ;
echo \f\html::markupEnd ( 'div' ) ;
echo \f\html::markupEnd ( 'div' ) ;
echo '<br></br>' ;
?>
<table class="table ">
    <thead>
        <tr style="background: #ddd;" >
            <td width="10%">ردیف</td>
            <td  width="35%">دامنه</td>
            <td  width="20%">رتبه الکسا در جهان</td>
            <td  width="20%">رتبه الکسا در کشور</td>
            <td  width="15%">تعداد بازدید</td>
        </tr> 
    </thead>
    
    <?php
    $i = 1 ;
    foreach ( $row AS $data )
    {
        echo '<tr style="background: #fff">
                    <td >' . $i . '</td>
                    <td><a href="http://' . $data[ 'domain' ] . '">' . $data[ 'domain' ] . '</a></td>
                    <td>' . ($data[ 'alexa_world_rank' ]?number_format($data['alexa_world_rank']):'N/A') . '</td>
                    <td>' . ($data[ 'alexa_country_rank' ]?'<div class="flag flag-'.$data[ 'alexa_country_code' ].'"></div> '.number_format($data['alexa_country_rank']):'N/A') . '</td>
                    <td>' . $data[ 'num_visit' ] . '</td>
                </tr>' ;
        $i ++ ;
    }
    ?>


</table> 
<script>
    function updateInfo(id)
    {
        widgetHelper.addLoading();
        widgetHelper.tt('ui', 'core.seo.backlink.updateInfo', {id: id}, 'refreshPage');
    }
    function refreshPage()
    {
        location.reload();
    }
</script>