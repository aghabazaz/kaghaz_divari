<?php

include 'infoForm.php';
require 'conf.php';

/* @var $addWidget \f\w\form */
$addWidget = \f\widgetFactory::make ( 'form' ) ;

/* @var $wizard \f\w\wizard */
$wizard = \f\widgetFactory::make ( 'wizard' ) ;

/* @var $date \f\g\date */
$date = \f\gadgetFactory::make ( 'date' ) ;

$wizard->begin ( array (
    'title' => \f\ifm::t ( 'siteNew' ),
    'icon'  => 'fa-magic',
    'ajax'  => \f\ifm::app ()->baseUrl .'core/website/saveSite',
) ) ;

$formDomain = '' ;
$formDomain.=$addWidget->begin ( array (
    'htmlOptions' => array (
        'method' => 'post',
        'action' => '',
        'id'     => 'formDomain'
    ),
        ) ) ;

$formDomain.=$addWidget->rowStart () ;
$formDomain.=$addWidget->input ( array (
    'htmlOptions' => array (
        'type'       => 'hidden',
        'name'       => 'id',
        'id'         => 'id',
        'value'      => ($row) ? $row['resultMain'][ 'id' ] : '',
        ),
        ) ) ;
$formDomain.=$addWidget->rowEnd () ;

$formDomain.=$addWidget->rowStart ( '', '',
                                    array (
    'id'    => 'row-domain0',
    'class' => 'formRow',
        )
        ) ;

$formDomain.=$addWidget->input ( array (
    'htmlOptions' => array (
        'type'       => 'text',
        'name'       => 'domain[]',
        'id'         => 'domain0',
        'value'      => ($row) ? $row['resultDomain'][0]['domain'] : '',
        'onblur'     => "check_domain('domain0');",
    ),
    'validation' => array (
        'required' => ''
    ),
    'style'    => array (
        'direction' => 'ltr',
    ),
    'label'     => array (
        'text' => \f\ifm::t ( 'domainAddress' ),
    ),
        ) ) ;
$formDomain.=\f\html::readyMarkup ( 'span','',array ( 'htmlOptions' => array ( 'class' => 'fa fa-plus-square addDomain' ) ) ) ;
$formDomain.=$addWidget->rowEnd () ;
if($row){
foreach($row['resultDomain'] as $key => $domain){
    if($key !== 0){
    $formDomain.=$addWidget->rowStart ( '', '',
                                    array (
    'id'    => 'row-domain'.$key,
    'class' => 'formRow',
        )
        ) ;
    $formDomain.=$addWidget->input ( array (
    'htmlOptions' => array (
        'type'       => 'text',
        'name'       => 'domain[]',
        'id'         => 'domain'.$key,
        'value'      => $domain['domain'],
        'onblur'     => "check_domain('domain".$key."');",
    ),
    'validation' => array (
        'required' => ''
    ),
    'style'    => array (
        'direction' => 'ltr',
    ),
    'label'     => array (
        'text' => '',
    ),
        ) ) ;
    $formDomain.=$addWidget->rowEnd () ;
    }
}
}
$formDomain.=$addWidget->rowStart ( '', '',
                                    array (
    'id'    => 'row-user',
    'class' => 'formRow',
        )
        ) ;
$formDomain.=$addWidget->select ( array (
    'htmlOptions' => array (
        'id'         => 'userId',
        'name'       => 'userId',
    ),
    'validation' => array (
        'required' => ''
    ),
    'label'    => array (
        'text'     => \f\ifm::t ( 'username' ),
    ),
    'choices'  => $userList,
    'selected' => ($row) ? $row['resultMain'][ 'core_userid' ] : '',
        ) ) ;
$formDomain.=$addWidget->rowEnd () ;

$formDomain.=$addWidget->rowStart () ;
$formDomain.=$addWidget->input ( array (
    'htmlOptions' => array (
        'type'  => 'text',
        'name'  => 'expireDate',
        'class' => 'form-control date',
        'id'    => 'expire',
        'value' => ($row && $row ['resultMain'][ 'expire_date' ] !== '0000-00-00' && $row ['resultMain'][ 'expire_date' ]) ? $date->dateGrToJa ( $row ['resultMain'][ 'expire_date' ],
                                                                                                             1 ) : '',
    ),
    'label' => array (
        'text' =>  \f\ifm::t ('creditDate'),
    ),
        ) ) ;
$formDomain.=$addWidget->rowEnd () ;

$formDomain.=$addWidget->flush () ;

$wizard->step ( array (
    'title' => array (
        'text'    => \f\ifm::t ( 'domainSetting' ),
    ),
    'content' => array (
        'content' => $formDomain,
        'active'  => ''
    )
) ) ;
//------------------------------------------------------------------------------

$wizard->step ( array (
    'title' => array (
        'text'    => 'پیکربندی سایت',
    ),
    'content' => array (
        'content' => $config,
    ),
) ) ;
$wizard->step ( array (
    'title' => array (
        'text'    => \f\ifm::t ( 'siteInfo' ),
    ),
    'content' => array (
        'content' => $infoForm,
    ),
) ) ;

echo $wizard->flush ( array (
    'button' => array (
        'next' => array (
            'content'     => 'بعدی',
            'htmlOptions' => array (
            ),
        ),
        'previus' => array (
            'content' => 'قبلی',
        ),
        'last'    => array (
            'content'     => 'ثبت نهایی',
            'htmlOptions' => array (
                'type' => 'submit'
            ),
        ),
    ),
) ) ;
?>

<script>
    $(document).ready(function () {
        widgetHelper.makeSelect2('select','<?= \f\ifm::t ( 'select' ) ?>');
    });
    
    
    function check_domain(id){
        
        var domain = $('#'+id).val();
        var websiteId = $('#id').val();
        //if ($('#domainRow .parsley-errors-list').html() == ''){
        $('#row-'+id+' .col-sm-6').after('<i class="fa fa-spinner fa-spin"></i>');
        // }
        var select = "#row-"+id+" .parsley-errors-list";
        widgetHelper.tt("ui","core.website.checkDomain",{domain:domain,websiteId:websiteId,selector:select,row:id},"domain_result" );
    }
    function domain_result(params){
        console.log(params);
        if(params['result'] == 'error' && params['domain']){
            if(params['message'] == 'invalid'){
                var msg = '<?= \f\ifm::t ( 'errorDomain' ) ?>';
            }
            else if(params['message'] == 'repeat'){
                var msg = '<?= \f\ifm::t ( 'repeatDomain' ) ?>';
            }
            if ($(params["selector"]).find('.domainWarning').length == 0){
                $(params["selector"]).append('<li class="domainWarning">'+msg+'</li>');
            }
            $(params["selector"] + ' .domainWarning').html(msg);
        }
        else{
            $(params["selector"] + ' .domainWarning').remove();
        }
        $('#row-'+params["row"]+' .fa-spinner').remove();
    }
    //--------------------------------------------------------------------------
    
    $(document).ready(function () {
        $('.addDomain').on('click' , function(){
            var time =  Math.floor(Math.random() * 999999 );
           
            $('.parsley-errors-list').attr('id' , 'parsley-id-'+time);
            var onclicked = "'domain"+time+"'";
            var newDomain = '<div id="row-domain'+time+'" class="formRow"><div class="col-sm-6"><label class="col-sm-3 control-label"></label>'+
               '<div class="col-sm-9"><input id="domain'+time+'" class="form-control" type="text" onblur="check_domain('+onclicked+');" name="domain[]" style="direction: ltr; " data-parsley-id="'+time+'"></div>'
               +'</div>'+'<ul id="parsley-id-'+time+'" class="parsley-errors-list"></ul>'+'</div>';
            $('#row-user').before(newDomain);
        });
        
        
        
            //----------------------------------------------------------------------
        $('.date').each(function () {
               var selector = "#" + $(this).attr('id');
                var lang = 'fa';
                var newOption = {
                    minDate: '',
                    changeMonth: true,
                    changeYear: true,
                    yearRange: "0:+100",
                }
                var newOptionTo = {}
                widgetHelper.makeDatePicker(selector, lang, newOption, newOptionTo);
        });
        
    });

</script>