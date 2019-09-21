<?php
/* @var $this websiteCenterView */

$this->registerWidgets ( array (
    'formW'      => 'form',
    'boxW'       => 'box',
    'pageTitleW' => 'pageTitle'
) ) ;

echo $this->pageTitleW->renderTitle ( array (
    'title' => \f\ifm::t ( 'socialnetSetting' ),
) ) ;


echo $this->boxW->begin ( array (
    'type'  => 'form',
    'title' => \f\ifm::t ( 'socialnetSetting' ) ) ) ;



$form = '' ;
$form.=$this->formW->begin ( array (
    'htmlOptions' => array (
        'method' => 'post',
        'action' => \f\ifm::app ()->baseUrl . 'cms/socialnet/SocialnetSettingSave',
        'id'     => 'portAdd'
    ),
        ) ) ;

$form.=$this->formW->input ( array (
    'htmlOptions' => array (
        'type'  => 'hidden',
        'name'  => 'id',
        'value' => $settings[ 'id' ],
    ),
        ) ) ;

$form.=$this->formW->rowStart () ;
$form.=$this->formW->input ( array (
    'htmlOptions' => array (
        'type'  => 'text',
        'name'  => 'address',
        'id'    => 'address',
        'value' => $settings[ 'address' ],
    ),
//    'validation'  => array (
//        'required' => ''
//    ),
    'label' => array (
        'text' => \f\ifm::t ( 'address' ),
    ),
        ) ) ;
$form.=$this->formW->rowEnd () ;
$form.=$this->formW->rowStart () ;
$form.=$this->formW->colStart ( array ( ), 'col-sm-10' ) ;
$form.=$this->formW->label ( \f\ifm::t ( 'map' ) ) ;
$form.=$this->formW->colStart ( array ( ), 'col-sm-9' ) ;
$form.=$this->formW->colStart ( array (
    'padding' => '0px 0px 0px 2px'
        ), 'col-sm-4' ) ;
$form.=$this->formW->input ( array (
    'htmlOptions' => array (
        'type'        => 'text',
        'name'        => 'longitude',
        'id'          => 'longitude',
        'value'       => $settings[ 'longitude' ],
        'placeholder' => \f\ifm::t ( 'longitude' ),
    ),
    'style'       => array (
        'text-align' => 'center',
    ),
    'colRow'     => TRUE,
        ) ) ;

$form.=$this->formW->colEnd () ;
$form.=$this->formW->colStart ( array (
    'padding' => '0px 0px 0px 2px'
        ), 'col-sm-4' ) ;
$form.=$this->formW->input ( array (
    'htmlOptions' => array (
        'type'        => 'text',
        'name'        => 'latitude',
        'id'          => 'latitude',
        'value'       => $settings[ 'latitude' ],
        'placeholder' => \f\ifm::t ( 'latitude' ),
    ),
    'style'       => array (
        'text-align' => 'center',
    ),
    'colRow'     => TRUE,
        ) ) ;

$form.=$this->formW->colEnd () ;
$form.=$this->formW->colStart ( array (
    'padding' => '0px 0px 0px 0px'
        ), 'col-sm-4' ) ;
$form.=\f\html::readyMarkup ( 'button',
                              '<i class="fa fa-map-marker "></i> ' . (\f\ifm::t ( 'cordinateMap' ) ),
                                                                                  array (
            'htmlOptions' => array (
                'type'  => 'button',
                'class' => 'btn btn-info',
                'id'    => 'mapBt',
            ),
                ), TRUE ) ;

$form.=$this->formW->colEnd () ;

$form.=$this->formW->colEnd () ;
$form.=$this->formW->colEnd () ;
$form.=$this->formW->rowEnd () ;


$form.=$this->formW->rowStart () ;
$form.=$this->formW->input ( array (
    'htmlOptions' => array (
        'type'  => 'text',
        'name'  => 'phone',
        'value' => $settings[ 'phone' ],
    ),
//    'validation'  => array (
//        'required' => ''
//    ),
    'label' => array (
        'text'  => \f\ifm::t ( 'phone' ),
    ),
    'style' => array (
        'direction' => 'ltr'
    )
        ) ) ;
$form.=$this->formW->rowEnd () ;

$form.=$this->formW->rowStart () ;
$form.=$this->formW->input ( array (
    'htmlOptions' => array (
        'type'  => 'text',
        'name'  => 'fax',
        'value' => $settings[ 'fax' ],
    ),
//    'validation'  => array (
//        'required' => ''
//    ),
    'label' => array (
        'text'  => \f\ifm::t ( 'fax' ),
    ),
    'style' => array (
        'direction' => 'ltr'
    )
        ) ) ;
$form.=$this->formW->rowEnd () ;
$form.=$this->formW->rowStart () ;
$form.=$this->formW->input ( array (
    'htmlOptions' => array (
        'type'  => 'text',
        'name'  => 'mobile',
        'value' => $settings[ 'mobile' ],
    ),
//    'validation'  => array (
//        'required' => ''
//    ),
    'label' => array (
        'text'  => \f\ifm::t ( 'mobile' ),
    ),
    'style' => array (
        'direction' => 'ltr'
    )
        ) ) ;
$form.=$this->formW->rowEnd () ;
$form.=$this->formW->rowStart () ;
$form.=$this->formW->input ( array (
    'htmlOptions' => array (
        'type'  => 'text',
        'name'  => 'email',
        'value' => $settings[ 'email' ],
    ),
//    'validation'  => array (
//        'required' => ''
//    ),
    'label' => array (
        'text'  => \f\ifm::t ( 'email' ),
    ),
    'style' => array (
        'direction' => 'ltr'
    )
        ) ) ;
$form.=$this->formW->rowEnd () ;
$form.=$this->formW->rowStart () ;
$form.=$this->formW->input ( array (
    'htmlOptions' => array (
        'type'  => 'text',
        'name'  => 'timeWorke',
        'value' => $settings[ 'timeWorke' ],
    ),
//    'validation'  => array (
//        'required' => ''
//    ),
    'label' => array (
        'text'  => \f\ifm::t ( 'timeWorke' ),
    ),
    'style' => array (
        'direction' => 'rtl'
    )
) ) ;
$form.=$this->formW->rowEnd () ;

$form.=$this->formW->rowStart () ;
$form.=$this->formW->input ( array (
    'htmlOptions' => array (
        'type'  => 'text',
        'name'  => 'twitter',
        'value' => $settings[ 'twitter' ],
    ),
//    'validation'  => array (
//        'required' => ''
//    ),
    'label' => array (
        'text'  => \f\ifm::t ( 'twitter' ),
    ),
    'style' => array (
        'direction' => 'ltr'
    )
        ) ) ;
$form.=$this->formW->rowEnd () ;

$form.=$this->formW->rowStart () ;
$form.=$this->formW->input ( array (
    'htmlOptions' => array (
        'type'  => 'text',
        'name'  => 'Facebook',
        'value' => $settings[ 'Facebook' ],
    // 'placeholder'=>\f\ifm::t('keywordCm')
    ),
    'label' => array (
        'text'  => \f\ifm::t ( 'Facebook' ),
    ),
    'style' => array (
        'direction' => 'ltr'
    )
        ) ) ;
$form.=$this->formW->rowEnd () ;

$form.=$this->formW->rowStart () ;
$form.=$this->formW->input ( array (
    'htmlOptions' => array (
        'type'  => 'text',
        'name'  => 'Google',
        'value' => $settings[ 'Google' ],
    // 'placeholder'=>\f\ifm::t('keywordCm')
    ),
    'label' => array (
        'text'  => \f\ifm::t ( 'Google' ),
    ),
    'style' => array (
        'direction' => 'ltr'
    )
        ) ) ;
$form.=$this->formW->rowEnd () ;
$form.=$this->formW->rowStart () ;
$form.=$this->formW->input ( array (
    'htmlOptions' => array (
        'type'  => 'text',
        'name'  => 'Instagram',
        'value' => $settings[ 'Instagram' ],
    // 'placeholder'=>\f\ifm::t('keywordCm')
    ),
    'label' => array (
        'text'  => \f\ifm::t ( 'Instagram' ),
    ),
    'style' => array (
        'direction' => 'ltr'
    )
        ) ) ;
$form.=$this->formW->rowEnd () ;

$form.=$this->formW->rowStart () ;
$form.=$this->formW->input ( array (
    'htmlOptions' => array (
        'type'  => 'text',
        'name'  => 'Telegram',
        'value' => $settings[ 'Telegram' ],
    // 'placeholder'=>\f\ifm::t('keywordCm')
    ),
    'label' => array (
        'text'  => \f\ifm::t ( 'Telegram' ),
    ),
    'style' => array (
        'direction' => 'ltr'
    )
        ) ) ;
$form.=$this->formW->rowEnd () ;
$form.=$this->formW->rowStart () ;
$form.=$this->formW->input ( array (
    'htmlOptions' => array (
        'type'  => 'text',
        'name'  => 'LinkedIn',
        'value' => $settings[ 'LinkedIn' ],
    // 'placeholder'=>\f\ifm::t('keywordCm')
    ),
    'label' => array (
        'text'  => \f\ifm::t ( 'LinkedIn' ),
    ),
    'style' => array (
        'direction' => 'ltr'
    )
        ) ) ;
$form.=$this->formW->rowEnd () ;

$form.=$this->formW->rowStart () ;
$form.=$this->formW->buttonTag ( array (
    'htmlOptions' => array (
        'type'    => 'submit',
    ),
    'content' => '<i class="fa fa-floppy-o"></i> ' . (\f\ifm::t ( 'save' )),
        ) ) ;
$form.=$this->formW->rowEnd () ;


$form.=$this->formW->flush () ;

echo $form ;

echo $this->boxW->flush () ;
?>

<script>
    $(document).ready(function () {
        widgetHelper.makeSelect2('select', '<?= \f\ifm::t ( 'select' ) ?>');
    });
    widgetHelper.formSubmit('#portAdd');
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=<?= \f\ifm::app ()->googleMapKey ?>&v=3.exp&language=fa"></script>
<script>
  
    var map = null; 
    function googleMap(selector, lat, lng,marker,zoom) 
    {
        var myLatlng = new google.maps.LatLng(lat, lng);
        if (!map) {
            var myOptions = {
                zoom: zoom,
                center: myLatlng, 
                disableDefaultUI: true
                
            }
            map = new google.maps.Map(document.getElementById(selector), myOptions);
            //alert(marker);
            if(marker)
            {
                var myLatlng1 = new google.maps.LatLng(lat,lng);
                new google.maps.Marker({
                    position: myLatlng1,
                    map: map
           
                });
            }
            
        
        
            
        } 
        else 
        {
            
            map.setCenter(myLatlng);
            
        }
        google.maps.event.addListener(map, "click", function (e) 
        {

            var latLng = e.latLng;
            $('#latitude').val(latLng.lat());
            $('#longitude').val(latLng.lng());
           
            $('#ipDialog').dialog('close');

        });
    
    }
    

    function getLatitudeLongitude(callback, address) 
    {
        // If adress is not supplied, use default value 'Ferrol, Galicia, Spain'
        address = address || 'Iran';
        // Initialize the Geocoder
        geocoder = new google.maps.Geocoder();
        if (geocoder) 
        {
            geocoder.geocode({
                'address': address
            }, function (results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    callback(results[0]);
                }
            });
        }
    }
    function showResult(result) 
    {
        //alert('ok');
        var latitude = result.geometry.location.lat();
        var longitude = result.geometry.location.lng();
        
        googleMap("map",latitude,longitude,false,15);
    }
     
</script>
<div id="ipDialog">
    <div id="map" style="height:550px"></div> 
</div>
<script>
    var map = null;

    jQuery(document).ready(function () {
        var ipDialog = $("#ipDialog").dialog({
            modal: false,
            width: 900,
            height: 600,
            autoOpen: false,
            title: 'پیدا کردن مختصات جغرافیایی',
            resizeStop: function (event, ui) { google.maps.event.trigger(map, 'resize') },
            open: function (event, ui) { google.maps.event.trigger(map, 'resize'); },
        

        });

        $("#mapBt").on("click", function () 
        {
            var latitude=$('#latitude').val();
            var longitude=$('#longitude').val();
            var address=$('#address').val();
            //var city=$("#city_id option:selected").text();
           

            //alert(address);
            if(latitude && longitude)
            {
                googleMap("map",latitude,longitude,true,15);
            }
            else if(address)
            {
                 getLatitudeLongitude(showResult,address);     
            }
            else
            {
                googleMap("map",32.48628799905412,53.421385288238525,false,5);
            }   
            
            
            
            
            $('#ipDialog').dialog('open');
            return false;
        });


    });




</script>