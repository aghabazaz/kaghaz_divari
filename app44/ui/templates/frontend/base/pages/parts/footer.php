
<a href="javascript:;" class="to_top btn">
    <span class="fa fa-angle-up"></span>
</a>

<section class="copyrights">
    <div class="container">
        <div class="row">

            <div class="footer-right">
                <?=
                \f\ttt::block ( 'cms.menu.index',
                                array (
                    'name' => 'footer'
                ) )
                ?>
            </div>
            <div class="footer-left" style="font:12px Tahoma">Copyright © <?= date ( 'Y' ) ?> | All rights reserved</div>

        </div>
    </div>
</section>
<style>
    .footer-right
    {
        float:right;
        direction: rtl;
    }
    .footer-left
    {
        float:left;
    }
    @media screen and (max-width:767px){
        .footer-right
        {
            width:100%;
            text-align: center;
            margin:0px auto;
        }
        .footer-left
        {
            width:100%;
            text-align: center;
            margin-top:20px;
        }
    }
    .footer-nav li
    {

        display:inline;
        padding: 0px 10px;

    }
    .footer-nav li:first-child
    {
        padding-right:0px;
    }
    .footer-nav li a
    {
        color:#fff;
    }

</style>

<script type='text/javascript' src='<?= \f\ifm::app ()->siteUrl ?>app/ui/templates/frontend/base/js/bootstrap.js'></script>
<script type='text/javascript' src='<?= \f\ifm::app ()->siteUrl ?>app/ui/templates/frontend/base/js/bootstrap-timepicker.js'></script>
<script type='text/javascript' src='<?= \f\ifm::app ()->siteUrl ?>app/ui/templates/frontend/base/js/jquery/jquery-migrate.min.js'></script>
<script type='text/javascript' src='<?= \f\ifm::app ()->siteUrl ?>app/ui/templates/frontend/base/js/jquery/jquery.validate.min.js'></script>
<script type='text/javascript' src='<?= \f\ifm::app ()->siteUrl ?>app/ui/templates/frontend/base/js/jquery/additional-methods.js'></script>
<script type='text/javascript' src='<?= \f\ifm::app ()->siteUrl ?>app/ui/templates/frontend/base/js/jquery/jquery.form.js'></script>
<script type="text/javascript" src="<?= \f\ifm::app ()->siteUrl ?>app/ui/templates/frontend/base/js/datepicker/jquery.ui.datepicker-cc.js"></script>
<script type="text/javascript" src="<?= \f\ifm::app ()->siteUrl ?>app/ui/templates/frontend/base/js/datepicker/jquery.ui.datepicker-cc-ar.js"></script>
<script type="text/javascript" src="<?= \f\ifm::app ()->siteUrl ?>app/ui/templates/frontend/base/js/datepicker/jquery.ui.datepicker-cc-fa.js"></script>
<script type="text/javascript" src="<?= \f\ifm::app ()->siteUrl ?>app/ui/templates/frontend/base/js/datepicker/calendar.js"></script>
<script type="text/javascript" src="<?= \f\ifm::app ()->siteUrl ?>app/ui/templates/frontend/base/js/datepicker/jalali.js"></script> 

<script type='text/javascript' src="<?= \f\ifm::app ()->siteUrl ?>app/ui/templates/frontend/base/js/tooltip.js"></script>

<script type='text/javascript' src="<?= \f\ifm::app ()->siteUrl ?>app/ui/templates/frontend/base/js/confirm.js"></script>
<script type='text/javascript' src="<?= \f\ifm::app ()->siteUrl ?>app/ui/templates/frontend/base/js/parsley/parsley.js"></script>

<link rel="stylesheet" href="<?= \f\ifm::app ()->siteUrl ?>app/ui/templates/frontend/base/js/jqueryui/jquery-ui.min.css">
<script type="text/javascript" src="<?= \f\ifm::app ()->siteUrl ?>app/ui/templates/frontend/base/js/ckeditor/ckeditor.js"></script>

<script type="text/javascript" src="<?= \f\ifm::app ()->siteUrl ?>app/ui/templates/frontend/base/js/rs-plugin/js/jquery.themepunch.plugins.min.js"></script>
<script type="text/javascript" src="<?= \f\ifm::app ()->siteUrl ?>app/ui/templates/frontend/base/js/rs-plugin/js/jquery.themepunch.revolution.min.js"></script>
<link rel="stylesheet" href="<?= \f\ifm::app ()->siteUrl ?>app/ui/templates/frontend/base/js/rs-plugin/css/settings.css" type="text/css">


</body>
</html>