<script>

    $(document).ready(function ()
    {
        $('[data-toggle=confirmation]').confirmation();
    });
    var widgetHelper = {
        makeButton: function (selector)
        {
            $(selector).button();
        },
        makeDataTable: function (selector, newOption, urlPlugin) {
            //type,
            //$('#myTable tbody').html(response);

            var defultOption = {
                //"stateSave": true,
                "language": {
                    //"url": "template/backend/datatables/resources/lang.txt",
                    //"lengthMenu": "_MENU_"
                    "processing": "لطفا منتظر بمانید...",
                    "lengthMenu": "_MENU_",
                    "zeroRecords": "هیچ نتیجه ای یافت نشد",
                    "info": "صفحه _PAGE_ از _PAGES_",
                    "infoEmpty": "داده ای وجود ندارد",
                    "sEmptyTable": "داده ای ثبت نشده",
                    "infoFiltered": "(تعداد کل _MAX_ )",
                    "infoPostFix": "",
                    "search": "جستجو ",
                    "url": "",
                    "paginate": {
                        "first": "اول",
                        "previous": "قبلی",
                        "next": "بعدی",
                        "last": "آخر"
                    }
                },
                "dom": '<"searchTable"fl><"top">rtp<"bottom"i><"clear">',
                "pagingType": "full_numbers",
                //"jQueryUI":       true,
                "processing": true,
                "serverSide": true,
                "sServerMethod": "POST",
                "ajax": urlPlugin,
                "aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                // "deferLoading": 57,             
                "initComplete": function () {
                    var api = this.api();
                    api.$('.tdsearch').click(function () {
                        api.search(this.innerHTML).draw();
                    });
                    $('[data-toggle=confirmation]').confirmation();
                }
            }
            if (newOption) {
                var extended = $.extend(defultOption, newOption);
            }
            //  console.log(defultOption);

            var table = $(selector).dataTable(defultOption);


        },
        refreshUIElements: function ()
        {
            widgetHelper.makeButton('.uibutton');

        },
        registerEventAttacher: function (attacherCallback) {

        },
        makeDatePicker: function (selector, lang, newOption, newOptionTo) {

            if (lang == 'fa') {

                var defultOption = {
                    dateFormat: 'yy/mm/dd',
                    minDate: 'd',
                    onSelect: function (dateText, inst) {
                        $(selector + '-to').datepicker('option', 'minDate', new JalaliDate(inst['selectedYear'], inst['selectedMonth'], inst['selectedDay']));
                    }
                }

                var defultOptionTo = {
                    dateFormat: 'yy/mm/dd'
                }
            }
            else if (lang == 'ar') {
                var defultOption = {
                    dateFormat: 'yy/mm/dd',
                    regional: 'ar',
                    minDate: 'd',
                    onSelect: function (dateText, inst) {
                        $(selector + '-to').datepicker('option', 'minDate', new Date(inst['selectedYear'], inst['selectedMonth'], inst['selectedDay']));
                    }
                }

                var defultOptionTo = {
                    dateFormat: 'yy/mm/dd',
                    regional: 'ar'
                }
            }
            else {
                var defultOption = {
                    dateFormat: 'yy/mm/dd',
                    regional: '',
                    minDate: 'd',
                    onSelect: function (dateText, inst) {
                        $(selector + '-to').datepicker('option', 'minDate', new Date(inst['selectedYear'], inst['selectedMonth'], inst['selectedDay']));
                    }
                }

                var defultOptionTo = {
                    dateFormat: 'yy/mm/dd',
                    regional: ''
                }
            }

            if (newOption) {
                var extended = $.extend(defultOption, newOption);

                console.log(JSON.stringify(extended));
            }
            if (newOptionTo) {
                var extendedTo = $.extend(defultOptionTo, newOptionTo);

                console.log(JSON.stringify(extended));
            }

            $(selector).datepicker(defultOption);
            $(selector + '-to').datepicker(defultOptionTo);
        },
        makeSelect2: function (selector, placeholder)
        {
            $(selector).select2(
            {
                placeholder: placeholder
            });
        },
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
                    console.log(formData);
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

                        var result, message, func = null;

                        var responseArray = JSON.parse(data); // non assosiative response, depricated


                        if (typeof (responseArray.func) !== 'undefined') {
                            func = responseArray.func;
                        }
                        else if (typeof (responseArray[2]) !== 'undefined')
                        {
                            func = responseArray[2];
                        }

                        if (typeof (responseArray.message) !== 'undefined') {
                            message = responseArray.message;
                        }
                        else if (typeof (responseArray[1]) !== 'undefined')
                        {
                            message = responseArray[1];
                        }

                        if (typeof (responseArray.result) !== 'undefined') {
                            result = responseArray.result;
                        }
                        else if (typeof (responseArray[0]) !== 'undefined')
                        {
                            result = responseArray[0];
                        }

                        if (func !== null)
                        {
                            arguments = responseArray.params;
                            console.log(responseArray);
                            window[func](arguments);
                        }
                        if (result.toUpperCase() == 'ERROR' || result.toUpperCase() == 'FAILED')
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
            //alert(tag);
            $('.black_overlay').remove();
            $('.loading').remove();
            if (position)
            {
                var loading = '<div id="light" class="loading" style="position:absolute"><div class="spinner"><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div></div><br>در حال ارسال اطلاعات. لطفا منتظر بمانید ...</div><div id="fade" class="black_overlay" style="position:absolute"></div>';
            }
            else
            {
                var loading = '<div id="light" class="loading"><div class="spinner"><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div></div><br>در حال ارسال اطلاعات. لطفا منتظر بمانید ...</div><div id="fade" class="black_overlay"></div>';
            }
            if (!tag)
            {
                tag = 'body';
            }
            $(tag).append(loading);
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
        tt: function (tier, catalog, params, callBackFunction) {
            if (tier === 'service') {
                tierUrl = "api";
            }
            else
            {
                tierUrl = "<?= \f\ifm::app ()->appName ?>";
            }
            var baseUrl = "<?= \f\ifm::app ()->legacyBaseUrl ?>" + tierUrl + "/";

            catalogUrl = catalog.replace(/\./g, "/");

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
                    }

                    if (typeof (responseArray.message) !== 'undefined') {
                        message = responseArray.message;
                    }

                    if (typeof (responseArray.func) !== 'undefined') {
                        clientFuncFromServer = responseArray.func;
                    }

                    var newOption = $.extend(params, data);

                    if (clientFuncFromServer !== 'null') {
                        window[clientFuncFromServer](newOption);
                    }

                    if (callBackFunction !== 'null')
                    {
                        window[callBackFunction](newOption);
                    }

                    if (callBackFunction === null && clientFuncFromServer === null)
                    {
                        if (result === 'error')
                        {
                            widgetHelper.errorDialog(message);
                        }
                        if (result === 'success')
                        {
                            widgetHelper.successDialog(message);
                        }
                    }
                }
            });

        }

    };
    function remove(params) {
        if ($(params['selector']).length === 0) {
            $(params['selector'] + params['id']).closest("tr").hide();
        }
        else
        {
            $(params['selector']).closest("tr").hide();
        }
    }
    function status(params) {
        //alert(params['status']);
        var str;
        var confirm;
        var str2;
        if($('#s'+params['id']).attr('data-on-confirm'))
        {
            str=$('#s'+params['id']).attr('data-on-confirm');
            confirm=true;
        }
        else
        {
            str=$('#s'+params['id']).attr('onclick');
            confirm=false;
        }
        if(params['status']==='enabled')
        {
            $('#s'+params['id']).children("i").removeClass().addClass("fa fa-check-circle fa-lg");
            str2=str.replace('disabled','enabled');
        }
        else
        {
            $('#s'+params['id']).children("i").removeClass().addClass("fa fa-minus-circle fa-lg");
            str2=str.replace('enabled','disabled');
        }
        if(confirm)
        {
            $('#s'+params['id']).attr('data-on-confirm',str2);
        }
        else
        {
            $('#s'+params['id']).attr('onclick',str2);
        }
    }

    function refreshPage(param) {
        location.reload();
    }


</script>