<script type="text/javascript"
        src="<?= \f\ifm::app()->siteUrl ?>app/ui/templates/frontend/digifirst-mobile/js/jquery.min.js"></script>


<script type='text/javascript' src='<?= \f\ifm::app ()->siteUrl ?>app/ui/templates/frontend/base/js/blazy.min.js'></script>
<script type='text/javascript'  src='<?= \f\ifm::app()->siteUrl ?>app/ui/templates/frontend/base/js/defaultCustom.js'></script>
<script>
    getProductByParam(1);
    function getProductByParam(page)
    {
        if (!page)
        {
            page = 1;
        }

        var brand = [];
        $.each($("input[name='brand']:checked"), function () {
            brand.push($(this).val());
        });

        var color = [];
        if ($('#color').val()) {
            color.push($('#color').val());
        } else {
            $.each($("input[name='color']:checked"), function () {

                color.push($(this).val());

            });
        }

            var mode = 'mobile';
            var sort = $('#sort-mobile').val();
            var sort_type = $('#sort-type-mobile').val();
            if ($('#sale_status_mobile').is(":checked"))
            {
                var sale_status = "disabled";
            } else
            {
                sale_status = '';
            }

        $('#page').val(page);
        cat_id = $('#cat_id').val();
        var option = {
            sort: sort,
            sale_status: sale_status,
            sort_type: sort_type,
            page: page,
            brand: brand,
            cat_id: cat_id,
            color: color,
            searchText: $('#searchText').val(),
            mode: mode
        };
        widgetHelper.addLoading("#product-mobile", "absolute");
        widgetHelper.tt('ui', 'shop.product.getProductByParam',option, 'showResult')
    }
    function showResult(params)
    {
        if ($(window).width() <= 767) {
            var page = $('#page').val();

            if (page == 1) {
                $('#product-mobile').html(params.content);
            } else {
                $('#product-mobile').html(params.content);
            }


        } else {
            $('#product').html(params.content);
        }
    }


</script>
<script>

    /* Set the width of the side navigation to 250px */
    function openNav() {
        document.getElementById("mySidenav").style.right = "0px";
        document.getElementById("myCanvasNav").style.width = "100%";
        document.getElementById("myCanvasNav").style.opacity = "0.8";
        $('body').addClass('noscroll');
    }

    /* Set the width of the side navigation to 0 */
    function closeNav() {
        document.getElementById("mySidenav").style.right = "-999px";
        document.getElementById("myCanvasNav").style.width = "0%";
        document.getElementById("myCanvasNav").style.opacity = "0";
        $('body').removeClass('noscroll');

    }
    $("#mySidenav.header-menu-mobile>ul>li>ul>li:has('ul')").find("i.fa-caret-left:first").addClass("fa-plus-circle").removeClass("fa-caret-left");

    $("#mySidenav.header-menu-mobile>ul>li>a").on('click',function () {
        $("#mySidenav.header-menu-mobile>ul>li ul").hide();
        $("#mySidenav.header-menu-mobile>ul>li>a>i.fa-angle-up").addClass("fa-angle-down");
        $("#mySidenav.header-menu-mobile>ul>li>a>i.fa-angle-up").removeClass("fa-angle-up");
        var showUl=$(this).attr('class');
        if(showUl=="show-ul"){
            $("#mySidenav.header-menu-mobile>ul>li>a.show-ul").parent().find("ul").hide();
            $(this).removeClass('show-ul');
            $(this).find("i.fa-angle-up").addClass("change");
            $(this).find("i.change").removeClass("fa-angle-up");
            $(this).find("i.change").addClass("fa fa-angle-down");
            $(this).find("i.change").removeClass("change");

            $("#mySidenav.header-menu-mobile>ul>li>a").removeClass("show-ul");
        }else{
            $("#mySidenav.header-menu-mobile>ul>li>a").removeClass("show-ul");
            $("#mySidenav.header-menu-mobile>ul>li>ul>li:has('ul')").find("i.fa-minus-circle").addClass("fa-plus-circle").removeClass("fa-minus-circle");
            $(this).parent().find("ul:first").show();
            $(this).addClass('show-ul');
            $(this).find("i.fa-angle-down").addClass("change");
            $(this).find("i.change").removeClass("fa-angle-down");
            $(this).find("i.change").addClass("fa fa-angle-up");
            $(this).find("i.change").removeClass("change");
        }
    });
    $("#mySidenav.header-menu-mobile>ul>li>ul>li>i").on('click',function () {
        var plusClass=$(this).attr('class');
        console.log(plusClass);
        if(plusClass=="fa fa-plus-circle"){
            $(this).addClass("fa-minus-circle").removeClass("fa-plus-circle");
        }else{
            $(this).addClass("fa-plus-circle").removeClass("fa-minus-circle");
        }
        $(this).parent().find("ul").toggle();
    });

</script>

<script>
    $(document).ready(function () {
        var submitIcon = $('.searchbox-icon');
        var inputBox = $('.searchbox-input');
        var searchBox = $('.searchbox');
        var isOpen = false;
        submitIcon.click(function () {
            if (isOpen == false) {
                searchBox.addClass('searchbox-open');
                inputBox.focus();
                isOpen = true;
            } else {
                searchBox.removeClass('searchbox-open');
                inputBox.focusout();
                isOpen = false;
            }
        });
        submitIcon.mouseup(function () {
            return false;
        });
        searchBox.mouseup(function () {
            return false;
        });
        $(document).mouseup(function () {
            if (isOpen == true) {
                $('.searchbox-icon').css('display', 'block');
                submitIcon.click();
            }
        });
    });
    function buttonUp() {
        var inputVal = $('.searchbox-input').val();
        inputVal = $.trim(inputVal).length;
        if (inputVal !== 0) {
            $('.searchbox-icon').css('display', 'none');
        } else {
            $('.searchbox-input').val('');
            $('.searchbox-icon').css('display', 'block');
        }
    }



</script>
<!--<!--..................mobile AND tablet.............-->
<script>
    $(window).load(function () {

        var bLazy = new Blazy();
        $('.services-item1').on('changed.owl.carousel', bLazy.revalidate);
        $('.myCarouselLogo').on('changed.owl.carousel', bLazy.revalidate);
        //$('.review-comments').on('changed.owl.carousel', bLazy.revalidate);
    });

</script>


<!--        end for owl-curouser...................-->
</body>

</html>