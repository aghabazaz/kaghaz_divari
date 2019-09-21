$(document).on('click.bs.wizard.data-api', '[data-toggle="wizard"]', function (e) {
    e.preventDefault();
    if ($(this).attr('class') == "enable") {

        $(this).tab('show');

        $(this).css('cursor', 'default');
        $(this).parent().nextAll().children('a').attr('class', 'disable');
        $(this).parent().nextAll().children('a').css('cursor', 'default');

        $(this).parent().attr('id', '');
        $(this).parent().nextAll('li').attr('id', '');

        $(this).parent().children('span').last().removeClass('badge-success');
        $(this).parent().children('span').last().addClass('badge-info');

        $(this).parent().nextAll().children('span').removeClass('badge-success');
        $(this).parent().nextAll().children('span').removeClass('badge-info');

        //$(this).children('span').removeClass('badge-success');
        $(this).children('span').removeClass('badge-info');

    }

    $('.wizard-button-next').css('display', '');
    $('.wizard-button-last').css('display', 'none');

    $('.enable').each(function () {
        if ($(this).parent().attr('class') !== "active") {
            $(this).css('cursor', 'pointer');
            $(this).children('span').addClass('badge-success');
        }
    });
});

$(document).on('click.bs.wizard.data-api', '[data-toggle="wizard-button-next"]', function (n) {

    $('.nav-wizards li').each(function () {

        if ($(this).attr('class') == "active" && $(this).children('a').attr('href') !== "#" + $('.wizard-button-next').attr('id'))
        {

            if ($($(this).children('a').attr('href')).find('.parsley-errors-list').length == 0)
            {
                changeStep($(this));
            }
            else {
                var formId = $($(this).children('a').attr('href') + ' form').attr('id');
                $("#" + formId).submit();
                if ($($(this).children('a').attr('href') + ' .parsley-errors-list').html() == '') {
                    changeStep($(this));
                }
                return false;
            }
        }
    });
});

$(document).on('click.bs.wizard.data-api', '[data-toggle="wizard-button-previus"]', function (p) {

    $('.nav-wizards li').each(function () {
        if ($(this).attr('class') == "active" && $(this).children('a').attr('href') !== "#" + $('.wizard-button-previus').attr('id')) {

            //a change
            $(this).attr('id', '');
            $(this).removeClass('active');
            $(this).children('a').css('cursor', 'default');
            $(this).children('a').attr('class', 'disable');

            //$(this).children('span').last().removeClass('badge-info');
            $(this).children('span').last().removeClass('badge-info');
            $(this).prev().children('span').last().removeClass('badge-success');
            $(this).prev().children('span').last().addClass('badge-info');

            //panel active
            $($(this).children('a').attr('href')).removeClass('active');
            $($(this).prev().children('a').attr('href')).addClass('active');

            //li active
            $(this).prev().addClass('active');
            $(this).prev().attr('id', '');
            $('.wizard-button-next').css('display', '');
            $('.wizard-button-last').css('display', 'none');
            return false;
        }
    });
});
$(document).on('click.bs.wizard.data-api', '[data-toggle="wizard-button-last"]', function (p) {

     
   $(this).after('<i class="fa fa-spinner fa-spin"></i>');
       

    if ($(this).attr('type') == 'submit') {
        var list = '';
        var i = 0;
        //var dataNew = {}
        $('.step-content form').each(function () {
            var id = $(this).attr('id');

            if (i == 0) {
                var sep = '';
            }
            else {
                var sep = ',';
            }

            list = list + sep + "#" + id;

            var form = $(this);
            // var formData = new FormData(this);
            // console.log(formData);
            i = i + 1;
        });
        var test = $(list).serializeArray();
        console.log(test);

         console.log("list of forms : " + list);
        var action = $('.wizard').attr('ajax'),
                method = 'POST';
        if (test)  // for HTML5 browsers
        {
            //console.log(test);

            var request = $.ajax(
                    {
                        type: method,
                        url: action,
                        data: test
                    });


            request.done(function (data)
            {
                //  alert(data);

                var array = JSON.parse(data);
                //var func=array[2];

                if (typeof (func) !== 'undefined')
                {
                    func();
                }
                else
                {
                    if (array[0] == 'error')
                    {
                        widgetHelper.errorDialog(array[1]);
                        //alert('error');
                        //error(array[1]);
                    }
                    if (array[0] == 'success')
                    {
                        widgetHelper.successDialog(array[1]);
                        //alert('success');
                    }
                }
                widgetHelper.removeLoading();
                
                $('.actions .fa-spinner').remove();
            });
            return false;
        }
    }
    else {
        alert($('.wizard').attr('ajax'));
        $('.actions .fa-spinner').remove();
    }
});

function changeStep(step) {

    step.attr('id', 'complete');

    step.children('span').last().removeClass('badge-info');
    step.children('span').last().addClass('badge-success');
    step.next().children('span').last().addClass('badge-info');

    step.removeClass('active');
    //$(this).children('span').addClass('badge-success');
    step.children('a').css('cursor', 'pointer');
    step.children('a').attr('class', 'enable');

    //$(this).children('span').removeClass('badge-success');
    //panel active
    $(step.children('a').attr('href')).removeClass('active');
    $(step.next().children('a').attr('href')).addClass('active');

    //li active
    step.next().addClass('active');
    if (step.next('li').children('a').attr('href') == "#" + $('.wizard-button-next').attr('id')) {
        $('.wizard-button-next').css('display', 'none');
        $('.wizard-button-last').css('display', '');
    }

    return false;
}

$(document).ready(function () {
    $('.step-content form').each(function () {
        var id = $(this).attr('id');
        $('#' + id).on("submit", function ()
        {
            return false;
        })
    });
});
