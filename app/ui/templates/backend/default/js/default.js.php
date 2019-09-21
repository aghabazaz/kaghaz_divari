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
    //alert('ok');
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

    return table;


},
    refreshDataTable: function (tableId, urlData) {

    $.getJSON(urlData, null, function( json )
{
    table = $(tableId).dataTable();
    oSettings = table.fnSettings();
    oSettings.ajax=urlData;
    table.object=oSettings;
    table.fnClearTable();

    for (var i=0; i<json.aaData.length; i++)
{
    table.oApi._fnAddData(oSettings, json.aaData[i]);
}

    oSettings.aiDisplay = oSettings.aiDisplayMaster.slice();
    table.fnDraw();
});
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
} else if (lang == 'ar') {
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
} else {
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
    makeSelect2: function (selector, placeholder, formatFunction, formatSelectionFunction, matcher)
{

    var option = {};
    if (placeholder !== null) {
    option.placeholder = placeholder;
}

    if (formatFunction !== null) {
    option.formatResult = formatFunction;
}

    if (formatSelectionFunction !== null) {
    option.formatSelection = formatSelectionFunction;
}

    if (matcher !== null)
{
    option.matcher = matcher;
}

    $(selector).select2(option);
},
    makeSelect2Ajax: function (selector, url, minimumInputLength, placeholder, formatFunction, formatSelectionFunction, matcher)
{

    $(selector).select2({
    ajax: {
    url: url,
    dataType: 'json',
    data: function (params) {
    return {
    search: params.term, // search term
    page: params.page || 1
};
},
    processResults: function (data, params) {
    params.page = params.page || 1;

    return {
    results: data.items,
    pagination: {
    more: (params.page * 10) < data.total_count
}
};
},
    cache: true
},
    placeholder: placeholder,
    formatFunction: formatFunction || '',
    formatSelectionFunction: formatSelectionFunction || '',
    matcher: matcher || '',
    minimumInputLength: minimumInputLength || 2
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

    var result, message, func = null;
    //alert(message);

    var responseArray = JSON.parse(data); // non assosiative response, depricated

    //console.log(responseArray);


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
    if (result == 'success' && typeof (responseArray.result) !== 'undefined')
{
    setTimeout(function () {
    widgetHelper.successDialog(message);
    widgetHelper.closeDialog('successDialog');

}, 800);
    //alert(responseArray.reset);
    if (responseArray.reset)
{
    $(formId)[0].reset();
    $('select').select2('val', 'All');
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

    $('.black_overlay').remove();
    $('.loading').remove();
    if (position)
{
    var loading = '<div id="light" class="loading" style="position:absolute"><div class="spinner"><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div></div><br>در حال ارسال اطلاعات. لطفا منتظر بمانید ...</div><div id="fade" class="black_overlay" style="position:absolute"></div>';
} else
{
    var loading = '<div id="light" class="loading"><div class="spinner"><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div></div><br>در حال ارسال اطلاعات. لطفا منتظر بمانید ...</div><div id="fade" class="black_overlay"></div>';
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
    var icon = 'edit';
}
    $('#formDialog').remove();
    var dialog = '<div class="modal fade" id="formDialog" ><div class="modal-dialog" style="width:' + width + '"><div class="modal-content"><div class="modal-header dialog-header-' + type + '"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
    dialog += '<h4 class="modal-title" id="myModalLabel"><i class="fa fa-' + icon + '"></i> ' + title + '</h4>';
    dialog += '</div>';
    dialog += '<div class="modal-body">' + data + '</div>';
    dialog += '</div></div></div>';

    $('body').append(dialog);

    $('#formDialog').modal();
    $('form').parsley();
    $('[data-toggle=confirmation]').confirmation();
    CKEDITOR.replace( 'editor' );
    //alert('ok');

},
    tt: function (tier, catalog, params, callBackFunction) {

    if (tier === 'service') {
    tierUrl = "api";
} else
{
    tierUrl = "<?= \f\ifm::app ()->appName ?>";
}
    var baseUrl = "<?= \f\ifm::app ()->legacyBaseUrl ?>" + tierUrl + "/";

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
    //alert(url);
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
    url: '<?= \f\ifm::app ()->legacyBaseUrl . 'api/core/autoComplete/getData' ?>',
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
}
};
    function remove(params) {
    if ($(params['selector']).length === 0) {
    $(params['selector'] + params['id']).closest("tr").hide();
} else
{
    $(params['selector']).closest("tr").hide();
}
}
    function status(params) {

    //alert(params['status']);
    var str;
    var confirm;
    var str2;
    if ($('#s' + params['id']).attr('data-on-confirm'))
{
    str = $('#s' + params['id']).attr('data-on-confirm');
    confirm = true;
} else
{
    str = $('#s' + params['id']).attr('onclick');
    confirm = false;
}
    if (params['status'] === 'enabled')
{
    $('#s' + params['id']).children("i").removeClass().addClass("fa fa-check-circle fa-lg");
    str2 = str.replace('disabled', 'enabled');
} else
{
    $('#s' + params['id']).children("i").removeClass().addClass("fa fa-minus-circle fa-lg");
    str2 = str.replace('enabled', 'disabled');
}
    if (confirm)
{
    $('#s' + params['id']).attr('data-on-confirm', str2);
} else
{
    $('#s' + params['id']).attr('onclick', str2);
}
}
    function special(params) {

    //alert(params['status']);
    var str;
    var confirm;
    var str2;
    if ($('#sp' + params['id']).attr('data-on-confirm'))
{
    str = $('#sp' + params['id']).attr('data-on-confirm');
    confirm = true;
} else
{
    str = $('#s' + params['id']).attr('onclick');
    confirm = false;
}
    if (params['status'] === 'enabled')
{
    $('#sp' + params['id']).children("i").removeClass().addClass("fa fa-star fa-lg");
    str2 = str.replace('disabled', 'enabled');
} else
{
    $('#sp' + params['id']).children("i").removeClass().addClass("fa fa-star-o fa-lg");
    str2 = str.replace('enabled', 'disabled');
}
    if (confirm)
{
    $('#sp' + params['id']).attr('data-on-confirm', str2);
} else
{
    $('#sp' + params['id']).attr('onclick', str2);
}
}

    function refreshPage(param) {
    location.reload();
}

    $(document).ready(function () {
    $(".comma").keyup(function ()
    {
        //alert('ok');
        addCommas(this);
    });

});
    function addCommas(id)
    {

        nStr = id.value;
        nStr = nStr.replace(/[^0-9\.]/g, "");
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(nStr)) {
        nStr = nStr.replace(rgx, '$1,$2');
    }


        nStr = nStr.replace(/(\.\d)$/, "$10");  // if only one DP add another 0

        id.value = nStr;
    }

    function refreshGalleryPic(params)
    {
        params['galId'] = '<?= $id ?>';
        widgetHelper.tt('ui', 'core.gallery.addPic', params, 'addPicGallery');
    }
    function addPicGallery(params)
    {
        $('.king-gallery').prepend(params.content);
        var numPic = parseInt($('#num_pic').val()) + 1;
        $('#num_pic').val(numPic);
        $('.modal').modal('hide');
        $('[data-toggle=confirmation]').confirmation();
        var cover = $('#picture').val();
        if (!cover)
    {
        $('#picture').val(params.fileId);
    }
    }
    function removePicGallery(params)
    {
        $('#pic' + params.id).remove();
        var numPic = parseInt($('#num_pic').val()) - 1;
        $('#num_pic').val(numPic);
        var cover = parseInt($('#picture').val());
        if (cover == params.id)
    {
        $('#picture').val('');
    }
    }
    function coverPicGallery(id)
    {
        $('.king-gallery .item').each(function (i, e) {
            if (e.id === 'pic' + id) {
                $('#pic' + id + ' .thumbnail').css('border', '2px dotted #34A6C8');
            } else {
                $('#' + e.id + ' .thumbnail').css('border', '');
            }
        });
        $('#picture').val(id);
    }
</script>


