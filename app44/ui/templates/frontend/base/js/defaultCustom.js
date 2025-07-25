var key;
var siteUrl = $('#siteUrl').val();


var widgetHelper = {

    formSubmit: function (formId)
    {

        $(document).off("submit", formId);
        $(document).on("submit", formId, function ()
        {

            widgetHelper.addLoading();
            var form = $(this),
                action = form.attr('action'),
                method = form.attr('method');

            if (window.FormData !== undefined)  // for HTML5 browsers
            {
                var formData = new FormData(this);

                //

                var request = $.ajax(
                    {
                        type: method,
                        url: action,
                        data: formData,
                        mimeType: "multipart/form-data",
                        contentType: false,
                        cache: false,
                        processData: false
                    });

                request.done(function (data)
                {
                    //alert(data);


                    var result, message, func = null;
                    //alert(message);

                    var responseArray = JSON.parse(data); // non assosiative response, depricated

                    //console.log(responseArray);

                    if (responseArray.url)
                    {
                        window.location.href = responseArray.url;
                    }

                    if (typeof (responseArray.func) !== 'undefined') {
                        func = responseArray.func;
                    } else if (typeof (responseArray[2]) !== 'undefined')
                    {
                        func = responseArray[2];
                    }

                    if (typeof (responseArray.message) !== 'undefined') {
                        message = responseArray.message;
                    } else if (typeof (responseArray[1]) !== 'undefined')
                    {
                        message = responseArray[1];
                    }

                    if (typeof (responseArray.result) !== 'undefined') {
                        result = responseArray.result;
                    } else if (typeof (responseArray[0]) === 'string')
                    {
                        result = responseArray[0];
                    } else
                    {
                        result = '';
                    }

                    if (func !== null)
                    {
                        arguments = responseArray.params;

                        window[func](arguments);
                    }
                    if (result.toUpperCase() == 'ERROR' || result.toUpperCase() === 'FAILED')
                    {
                        setTimeout(function () {
                            widgetHelper.errorDialog(message);
                            widgetHelper.closeDialog('errorDialog');
                        }, 800);

                        //alert('error');
                        //error(array[1]);
                    }
                    if (result == 'success')
                    {
                        setTimeout(function () {
                            widgetHelper.successDialog(message);
                            widgetHelper.closeDialog('successDialog');

                        }, 800);
                        //alert(responseArray.reset);
                        if (responseArray.reset)
                        {
                            $(formId)[0].reset();
                        }


                        //                            widgetHelper.successDialog(message);
                        //alert('success');

                    }



                    widgetHelper.removeLoading();


                });
                return false;
            }

        });
    },
    addLoading: function (tag, position)
    {
        var logo = $('.logo img').attr('src');
        $('.black_overlay').remove();
        $('.loading').remove();
        if (position)
        {
            var loading = '<div id="light" class="loading" style="position:absolute"><img src="' + logo + '" style="max-width:200px"><div class="spinner"><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div></div></div><div id="fade" class="black_overlay" style="position:absolute"></div>';
        } else
        {
            var loading = '<div id="light" class="loading"><img src="' + logo + '" style="max-width:200px"><div class="spinner"><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div></div></div><div id="fade" class="black_overlay"></div>';
        }
        if (!tag)
        {
            tag = 'body';
        }
        $(tag).append(loading);
        //alert($(tag).html());
        $('.black_overlay').fadeIn('slow');
        $('.loading').fadeIn('slow');
    },
    removeLoading: function ()
    {
        $('.black_overlay').fadeOut('slow');
        $('.loading').fadeOut('slow');

    },
    errorDialog: function (msg)
    {
        $('#errorDialog').remove();
        var dialog = '<div class="modal fade" id="errorDialog" ><div class="modal-dialog"><div class="modal-content"><div class="modal-header dialog-header-error"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
        dialog += '<h4 class="modal-title" id="myModalLabel"><i class="fa fa-warning"></i> خطای سیستم</h4>';
        dialog += '</div>';
        dialog += '<div class="modal-body">' + msg + '</div>';
        dialog += '</div></div></div>';

        $('body').append(dialog);

        $('#errorDialog').modal();
    },
    successDialog: function (msg)
    {
        $('#successDialog').remove();
        var dialog = '<div class="modal fade" id="successDialog" ><div class="modal-dialog"><div class="modal-content"><div class="modal-header dialog-header-success"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
        dialog += '<h4 class="modal-title" id="myModalLabel"><i class="fa fa-check-circle"></i> پیغام سیستم</h4>';
        dialog += '</div>';
        dialog += '<div class="modal-body">' + msg + '</div>';
        dialog += '</div></div></div>';

        $('body').append(dialog);

        $('#successDialog').modal();
        //alert('ok');

    },
    closeDialog: function (id)
    {
        setTimeout(function () {
            $('#' + id).modal('hide');

        }, 2000);
    },
    formDialog: function (data, title, type, width)
    {
        if (!type)
        {
            type = 'form';
            icon = 'edit';
        }
        $('#formDialog').remove();
        var dialog = '<div class="modal fade" data-backdrop="static" data-keyboard="false" id="formDialog" ><div class="modal-dialog" style="width:' + width + '"><div class="modal-content"><div class="modal-header dialog-header-' + type + '"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
        dialog += '<h4 class="modal-title" id="myModalLabel"><i class="fa fa-' + icon + '"></i> ' + title + '</h4>';
        dialog += '</div>';
        dialog += '<div class="modal-body">' + data + '</div>';
        dialog += '</div></div></div>';
        $('body').append(dialog);
        $('#formDialog').modal();
        $('form').parsley();
        $('[data-toggle=confirmation]').confirmation();
        //alert('ok');

    },
    tt: function (tier, catalog, params, callBackFunction) {
        if (tier === 'service') {
            tierUrl = "api";
        } else
        {
            tierUrl = "";
        }
        //alert(siteUrl);
        var baseUrl = siteUrl + tierUrl + "/";
        //alert(baseUrl);

        //baseUrl = "";
        catalogUrl = catalog.replace(/\./g, "/");
        //alert(callBackFunction);

        $.ajax({
            url: baseUrl + catalogUrl,
            method: "POST",
            dataType: "JSON",
            data: params,
            success: function (data) {



                var result, message, clientFuncFromServer = 'null';

                var responseArray = data;
                if (typeof (responseArray.result) !== 'undefined') {
                    result = responseArray.result;
                } else
                {
                    result = '';
                }

                if (typeof (responseArray.message) !== 'undefined') {
                    message = responseArray.message;
                }

                if (typeof (responseArray.func) !== 'undefined') {
                    clientFuncFromServer = responseArray.func;
                }
                //alert(data.params.result);

                var newOption = $.extend(params, data);

                if (clientFuncFromServer !== 'null') {
                    window[clientFuncFromServer](newOption);
                }

                if (callBackFunction !== 'null')
                {
                    //alert(callBackFunction);
                    window[callBackFunction](newOption);
                }
                if (result.toUpperCase() === 'ERROR' || result.toUpperCase() === 'FAILED')
                {
                    if (message)
                    {
                        setTimeout(function () {
                            widgetHelper.errorDialog(message);
                            widgetHelper.closeDialog('errorDialog');
                        }, 800);
                    }


                    //alert('error');
                    //error(array[1]);
                }
                if (result === 'success')
                {
                    if (message)
                    {
                        setTimeout(function () {
                            widgetHelper.successDialog(message);
                            widgetHelper.closeDialog('successDialog');

                        }, 800);
                    }

                    //                            widgetHelper.successDialog(message);
                    //alert('success');

                }


            }
        });

    },
    autoComplete: function (id, tbl, col)
    {
        //alert(id);
        var cache = {};
        $("#" + id).autocomplete({
            minLength: 2,
            source: function (request, response) {
                var term = request.term;
                if (term in cache) {
                    response(cache[ term ]);
                    return;
                }
                $.ajax({
                    url: siteUrl + 'api/core/autoComplete/getData',
                    method: "POST",
                    dataType: "JSON",
                    data: {
                        q: term,
                        tbl: tbl,
                        col: col
                    },
                    success: function (data) {
                        //alert(data);
                        cache[ term ] = data;
                        response(data);
                    }
                });

            }
        });
    },

    search: function ()
    {


        jQuery('#searchBox').keypress(function (e)
        {
            key = e.which;
            //alert(key);
        });
        //alert('ok');


        var loading = '<div style="color:silver;text-align:center"><div class="spinner" style="margin-top:20px"><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div></div> در حال جستجو ...</div>';

        if (jQuery('#searchBox').val())
        {

            if (key != 0 && key != 13)
            {
                jQuery('#result_search').html(loading);

                if (jQuery('#result_search').css('display') == "none")
                {
                    jQuery("#result_search").slideDown("fast");
                }
            }

        } else
        {
            jQuery("#result_search").slideUp("fast");
        }
        if (jQuery('#searchBox').val().length >= 3)
        {

            var base_url = siteUrl + 'wiki/search/';
            jQuery.post(base_url, {
                    keyword: jQuery('#searchBox').val()
                }
                , function (data)
                {

                    jQuery('#result_search').html(data);
                    if (jQuery('#searchBox').val())
                    {

                        var divs = jQuery('.result'),
                            selectedDiv,
                            i;

                        if (divs.length < jQuery('#selectDiv').val())
                        {
                            selectedDiv = 0;
                        } else
                        {
                            selectedDiv = jQuery('#selectDiv').val();
                        }

                        for (i = 0; i < divs.length; i++)
                        {
                            divs[i].onmouseover = (function (i)
                            {

                                return function ()
                                {

                                    divs[selectedDiv].style.backgroundColor = '';
                                    divs[selectedDiv].style.borderTop = "1px solid white";
                                    divs[selectedDiv].style.borderBottom = "1px solid #e4e4e4";
                                    selectedDiv = i;
                                    divs[selectedDiv].style.backgroundColor = '#DEF7F4';
                                    divs[selectedDiv].style.borderTop = "1px solid #26A69A";
                                    divs[selectedDiv].style.borderBottom = "1px solid #26A69A";

                                    jQuery('#selectDiv').val(selectedDiv);
                                }
                            })(i);
                        }

                        divs[selectedDiv].style.backgroundColor = '#DEF7F4';
                        divs[selectedDiv].style.borderTop = "1px solid #26A69A";
                        divs[selectedDiv].style.borderBottom = "1px solid #26A69A";


                        jQuery('#searchBox').keydown(function (e)
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
                            divs[selectedDiv].style.borderBottom = "1px solid #e4e4e4";


                            //int b=selectedDiv+x;
                            // jQuery('#x').html(b);
                            selectedDiv = ((parseInt(selectedDiv) + x) % divs.length);

                            selectedDiv = selectedDiv < 0 ? divs.length + selectedDiv : selectedDiv;
                            jQuery('#selectDiv').val(selectedDiv)


                            divs[selectedDiv].style.backgroundColor = '#DEF7F4';
                            divs[selectedDiv].style.borderTop = "1px solid #26A69A";
                            divs[selectedDiv].style.borderBottom = "1px solid #26A69A";
                        });

                        jQuery('#searchBox').focus();
                    }
                });
        }
    }
};

function refreshPage(param) {
    location.reload();
}






