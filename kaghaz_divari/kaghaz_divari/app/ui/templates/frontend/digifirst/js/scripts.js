
// number to convert toman
function toTomanComment(value) {
    value = value.toString();
    var nStr = value.replace(/[^0-9\.]/g, "");
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(nStr)) {
        nStr = nStr.replace(rgx, '$1,$2');
    }
    nStr = nStr.replace(/(\.\d)$/, "$10");  // if only one DP add another 0
    return nStr;
}

//Block search BOX suggestion
jQuery("body").mouseup(function ()
{

    if (jQuery('#result_search').css('display') != "none")
    {
        jQuery("#result_search").slideUp("fast");
    }
    if (jQuery('#searchtxt').val())
    {
        jQuery('#key').val(1);
    }
});

function search_keyword(url,type)
{
    if(type=='mobile')
    {
        var div='-mobile';
    }
    else
    {
        div='';
    }
    jQuery('#searchtxt'+div).keypress(function (e)
    {
        jQuery('#key'+div).val(e.which);
    });
    var loading = '<p style="text-align:right;color:gray;padding:5px">&nbsp;<img src="' + url + 'app/ui/templates/backend/default/images/loading2.gif" align="center" width="20px" height="20px">&nbsp;&nbsp;&nbsp;در حال جستجو....</p>';

    if (jQuery('#searchtxt'+div).val())
    {
        if (jQuery('#key'+div).val() != 0 && jQuery('#key'+div).val() != 13)
        {
            jQuery('#result_search'+div).html(loading);

            if (jQuery('#result_search'+div).css('display') == "none")
            {
                jQuery("#result_search"+div).slideDown("fast");
            }
        }

    } else
    {
        jQuery("#result_search"+div).slideUp("fast");
    }
    if (jQuery('#searchtxt'+div).val().length >= 2)
    {
        //go to method controller productController
        var base_url = url + "cms/getAjaxSearchAllIndex";
        jQuery.post(base_url, {keyword: jQuery('#searchtxt'+div).val()}
            , function (data)
            {

                jQuery('#result_search'+div).html(data);
                if (jQuery('#searchtxt'+div).val())
                {
                    var divs = jQuery('.result'),
                        selectedDiv,
                        i;
                    //console.log(selectedDiv);
                    if (divs.length < jQuery('#selectDiv'+div).val())
                    {
                        selectedDiv = 0;
                    } else
                    {
                        selectedDiv = jQuery('#selectDiv'+div).val();
                    }

                    for (i = 0; i < divs.length; i++)
                    {
                        divs[i].onmouseover = (function (i)
                        {

                            return function ()
                            {

                                divs[selectedDiv].style.backgroundColor = '';
                                divs[selectedDiv].style.borderTop = "1px solid #e4e4e4";
                                divs[selectedDiv].style.borderBottom = "1px solid #e4e4e4";
                                selectedDiv = i;
                                divs[selectedDiv].style.backgroundColor = '#EEF9FF';
                                divs[selectedDiv].style.borderTop = "1px solid #e4e4e4";
                                divs[selectedDiv].style.borderBottom = "1px solid #e4e4e4";

                                jQuery('#selectDiv'+div).val(selectedDiv);
                            }
                        })(i);
                    }
                    divs[selectedDiv].style.backgroundColor = '#EEF9FF';
                    divs[selectedDiv].style.borderTop = "1px solid #gray";
                    divs[selectedDiv].style.borderBottom = "1px solid #gray";
                    jQuery('#searchtxt'+div).keydown(function (e)
                    {
                        if (e.keyCode == 38)
                        {
                            x = -1;
                        } else if (e.keyCode == 40)
                        {
                            x = 1;
                        } else if (e.keyCode == 13)
                        {
                            document.location = jQuery('#' + selectedDiv).attr('href');
                            return;
                        } else
                        {
                            return;
                        }
                        divs[selectedDiv].style.backgroundColor = '';
                        divs[selectedDiv].style.borderTop = "1px solid white";
                        divs[selectedDiv].style.borderBottom = "1px solid white";

                        selectedDiv = ((parseInt(selectedDiv) + x) % divs.length);

                        selectedDiv = selectedDiv < 0 ? divs.length + selectedDiv : selectedDiv;
                        jQuery('#selectDiv'+div).val(selectedDiv)


                        divs[selectedDiv].style.backgroundColor = '#EEF9FF';
                        divs[selectedDiv].style.borderTop = "1px solid #gray";
                        divs[selectedDiv].style.borderBottom = "1px solid #gray";
                    });

                    jQuery('#searchtxt'+div).focus();
                }
            });
    }
}
//END Block search BOX suggestion

/**/
/* on resize event */
/**/
$(window).resize(function ()
{

    sticky()
    /**/
    /* benefits */
    /**/
    $('.benefits .text').css('padding-bottom', 51);
    if ($(window).width() > 767)
    {
        $('.benefits li').each(function ()
        {
            if ($(this).outerHeight() < $('.benefits').outerHeight())
            {
                $(this).find('.text').css('padding-bottom', $('.benefits').outerHeight() - $(this).outerHeight() + 51);
            }
        });
    } else if ($(window).width() > 479)
    {
        $('.benefits li:nth-child(even)').each(function ()
        {
            elem = $(this);
            if (elem.outerHeight() < elem.prev().outerHeight())
            {
                elem.find('.text').css('padding-bottom', elem.prev().outerHeight() - elem.outerHeight() + 51);
            } else if ($(this).outerHeight() > $(this).prev().outerHeight())
            {
                elem.prev().find('.text').css('padding-bottom', elem.outerHeight() - elem.prev().outerHeight() + 51);
            }
        });
    }


});


/**/
/* on load event */
/**/
$(function ()
{

    /**/
    /* mobile main nav */
    /**/
    $('#mobile-main-nav').on('click', 'i', function ()
    {
        $(this).nextAll('ul').slideToggle('fast');
    });
    $('#mobile-main-nav').on('click', '.opener', function ()
    {
        $(this).next('ul').slideToggle('fast');
        return false;
    });


    /**/
    /* quick search */
    /**/
    $('#quick-search-switcher').on('click', function ()
    {
        $('#quick-search').toggleClass('quick-search-visible');
    });




    $('#slider .next').on('click', function ()
    {
        $('#slider').layerSlider('next');
        return false;
    });
    $('#slider .prev').on('click', function ()
    {
        $('#slider').layerSlider('prev');
        return false;
    });





    /**/
    /* doctors carousel */
    /**/
    $('#doctors-carousel').owlCarousel({
        items: 4,
        navContainerClass: 'owl-buttons',
        nav: true,
        navText: ['<i class="fa fa-angle-right"></i>', '<i class="fa fa-angle-left"></i>'],
        pagination: false,
        rtl: true,
        loop: true,
        responsive: {
            0: {
                items: 1
            },
            250: {
                items: 1
            },
            500: {
                items: 2
            },
            750: {
                items: 3
            },
            1000: {
                items: 4
            }
        },
    });


    $('#review-carousel').owlCarousel({
        items: 1,
        rtl: true,
        nav: true,
        navContainerClass: 'owl-buttons',
        navText: ['<i class="fa fa-angle-right" style="font-size:32px"></i>', '<i class="fa fa-angle-left" style="font-size:32px"></i>'],
        pagination: false,
        loop: true,
        autoplay: true,
        autoplayTimeout: 4000,
        autoplayHoverPause: true
    });



    /**/
    /* map */
    /**/



    /**/
    /* widget comments */
    /**/
    $('#comments-carousel').owlCarousel({
        singleItem: true,
        navigation: true,
        navigationText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
        pagination: false,
        slideSpeed: 200,
        paginationSpeed: 200,
        rewindSpeed: 200,
        transitionStyle: 'fade',
        autoHeight: true
    });





});


widgetHelper.formSubmit('#contactform');
widgetHelper.makeSelect2('select', 'انتخاب کنید...');



    /********************************************/


//update instance after 5 sec

function is_mobile() {
    if (($(window).width() < 767) || (navigator.userAgent.match(/(iPhone|iPod|iPad)/))) {
        return true;
    } else {
        return false;
    }
}
/*work*/


function sticky() {
    var sticky_container = $(".sticky-container")
    var sticky = $(".sticky")
    var sticky_height = $(".sticky").outerHeight();
    var offset_top_sticky = sticky.offset().top
    if ($(window).width() > 767) {
        if (!$(".sticky>.sticky-container").hasClass("second-sticky")) {
            $(sticky).append($(sticky_container)[0].outerHTML)
        }
        $(sticky).find(">.sticky-container").addClass("second-sticky");
        $(window).scroll(function () {
            if (jQuery(document).scrollTop() > (offset_top_sticky + (2 * sticky_height))) {
                $(sticky).addClass("show");
            } else {
                $(sticky).removeClass("show");
            }
            if ($(window).width() < 767) {
                $(sticky).removeClass("show");
            }
        });
    } else {
        $(sticky).removeClass("show")
        $(".sticky>.sticky-container").remove()
    }
}





$( ".fa-digit" ).each(function() {
  var text=$(this).text();
  var newText=persianJs(text).englishNumber().toString();
  $(this).text(newText);
});



$('form').parsley();
if($('#rateSave').html())
{
   $('#rateSave').parsley().destroy(); 
   $('#commentSave').parsley().destroy();
}

$(document).ready(function(){
    var $gallery = $('.gallery');
    var $gallery1 = $('.gallery1');
    var $gallery2 = $('.gallery2');


    $gallery.vitGallery({
        debag: true,
        thumbnailMargin: 5,
        fullscreen: true
    })

    $gallery1.vitGallery({
        controls: 'points',
        transition: 'crossfade',
        autoplay: false,
        fullscreen: true
    })

    $gallery2.vitGallery({
        controls: 'points',
        transition: 'slide-blur',
        autoplay: false,
        fullscreen: true,
        thumnailAnimationSpeed: 500,
        animateSpeed: 500,
    })
})