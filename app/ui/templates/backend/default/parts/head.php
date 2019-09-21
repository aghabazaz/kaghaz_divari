<meta charset="utf-8">

<title>
    <?= isset ( $title ) ? $title : \f\ifm::app ()->backendTitle ?>
</title>

<script src="<?= \f\ifm::app ()->defaultBackendTemplateUrl ?>js/jquery.js"></script>
<script src="<?= \f\ifm::app ()->defaultBackendTemplateUrl ?>js/bootstrap.js"></script>

<script src="<?= \f\ifm::app ()->defaultBackendTemplateUrl ?>lib/jqueryui/jquery-ui.min.js"></script>
<link rel="stylesheet" href="<?= \f\ifm::app ()->defaultBackendTemplateUrl ?>lib/jqueryui/jquery-ui.min.css">

<script src="<?= \f\ifm::app ()->defaultBackendTemplateUrl ?>lib/nicescroll/nice_scroll.js"></script>

<script src="<?= \f\ifm::app ()->defaultBackendTemplateUrl ?>lib/select/select2.js"></script>
<script src="<?= \f\ifm::app ()->defaultBackendTemplateUrl ?>lib/select/select2_locale_fa.js"></script>

<script src="<?= \f\ifm::app ()->defaultBackendTemplateUrl ?>lib/parsley/parsley.js"></script>

<link rel="stylesheet" href="<?= \f\ifm::app ()->defaultBackendTemplateUrl ?>lib/select/select2.css">

<link rel="stylesheet" href="<?= \f\ifm::app ()->defaultBackendTemplateUrl ?>css/bootstrap.css">

<link rel="stylesheet" href="<?= \f\ifm::app ()->defaultBackendTemplateUrl ?>lib/jqplot/jquery.jqplot.min.css" />

<link rel="stylesheet" href="<?= \f\ifm::app ()->defaultBackendTemplateUrl ?>css/font-awesome.css">
<link rel="stylesheet" href="<?= \f\ifm::app ()->defaultBackendTemplateUrl ?>css/font.css">
<link rel="stylesheet" href="<?= \f\ifm::app ()->defaultBackendTemplateUrl ?>css/main.css">
<link rel="stylesheet" href="<?= \f\ifm::app ()->defaultBackendTemplateUrl ?>css/style.css">
<link rel="stylesheet" href="<?= \f\ifm::app ()->defaultBackendTemplateUrl ?>css/skins/darkblue.css">
<link rel="stylesheet" href="<?= \f\ifm::app ()->defaultBackendTemplateUrl ?>css/flags.css">
<link rel="stylesheet" type="text/css" href="<?= \f\ifm::app ()->defaultBackendTemplateUrl ?>lib/datatables/media/css/jquery.dataTables.css">

<script type="text/javascript" language="javascript" src="<?= \f\ifm::app ()->defaultBackendTemplateUrl ?>lib/datatables/media/js/jquery.dataTables.js"></script>

<script type="text/javascript" src="<?= \f\ifm::app ()->defaultBackendTemplateUrl ?>lib/datepicker/jquery.ui.datepicker-cc.js"></script>
<script type="text/javascript" src="<?= \f\ifm::app ()->defaultBackendTemplateUrl ?>lib/datepicker/jquery.ui.datepicker-cc-ar.js"></script>
<script type="text/javascript" src="<?= \f\ifm::app ()->defaultBackendTemplateUrl ?>lib/datepicker/jquery.ui.datepicker-cc-fa.js"></script>
<script type="text/javascript" src="<?= \f\ifm::app ()->defaultBackendTemplateUrl ?>lib/datepicker/calendar.js"></script>
<script language="javascript" type="text/javascript" src="<?= \f\ifm::app ()->defaultBackendTemplateUrl ?>lib/datepicker/jalali.js"></script> 
<script src="<?= \f\ifm::app ()->defaultBackendTemplateUrl ?>js/king-common.min.js"></script>
<script src="<?= \f\ifm::app ()->defaultBackendTemplateUrl ?>js/tooltip.js"></script>
<script src="<?= \f\ifm::app ()->defaultBackendTemplateUrl ?>js/confirm.js"></script>
<script src="<?= \f\ifm::app ()->defaultBackendTemplateUrl ?>js/wizard.js"></script>
<script src="<?= \f\ifm::app ()->defaultBackendTemplateUrl ?>js/jquery.easypiechart.min.js"></script>
<script src="<?= \f\ifm::app ()->defaultBackendTemplateUrl ?>js/bootstrap-progressbar.min.js"></script>
<script src="<?= \f\ifm::app ()->defaultBackendTemplateUrl ?>js/bootstrap-tour.custom.js"></script>
<script src="<?= \f\ifm::app ()->defaultBackendTemplateUrl ?>js/bootstrap-timepicker.js"></script>
<script src="<?= \f\ifm::app ()->defaultBackendTemplateUrl ?>js/jquery.tablesorter.js"></script>

<!--                      -----jqPlot-----                                   -->
<script type="text/javascript" src="<?= \f\ifm::app ()->defaultBackendTemplateUrl ?>lib/jqplot/jquery.jqplot.min.js"></script>
<script type="text/javascript" src="<?= \f\ifm::app ()->defaultBackendTemplateUrl ?>lib/jqplot/jqplot.barRenderer.min.js"></script>
<script type="text/javascript" src="<?= \f\ifm::app ()->defaultBackendTemplateUrl ?>lib/jqplot/jqplot.pieRenderer.min.js"></script>
<script type="text/javascript" src="<?= \f\ifm::app ()->defaultBackendTemplateUrl ?>lib/jqplot/jqplot.categoryAxisRenderer.min.js"></script>
<script type="text/javascript" src="<?= \f\ifm::app ()->defaultBackendTemplateUrl ?>lib/jqplot/jqplot.pointLabels.min.js"></script>
<script type="text/javascript" src="<?= \f\ifm::app ()->defaultBackendTemplateUrl ?>lib/jqplot/jqplot.highlighter.js"></script>
<script type="text/javascript" src="<?= \f\ifm::app ()->defaultBackendTemplateUrl ?>lib/jqplot/jqplot.canvasAxisTickRenderer.min.js"></script>
<script type="text/javascript" src="<?= \f\ifm::app ()->defaultBackendTemplateUrl ?>lib/jqplot/jqplot.dateAxisRenderer.min.js"></script>
<script type="text/javascript" src="<?= \f\ifm::app ()->defaultBackendTemplateUrl ?>lib/jqplot/jqplot.canvasTextRenderer.min.js"></script>
<script type="text/javascript" src="<?= \f\ifm::app ()->defaultBackendTemplateUrl ?>lib/jqplot/jqplotDefult.js"></script>

<!--                          End                                            -->
<script type="text/javascript" src="<?= \f\ifm::app ()->defaultBackendTemplateUrl ?>lib/colorpicker/colors.js"></script>
<script type="text/javascript" src="<?= \f\ifm::app ()->defaultBackendTemplateUrl ?>lib/colorpicker/jqColorPicker.js"></script>

<link rel="stylesheet" href="<?= \f\ifm::app ()->defaultBackendTemplateUrl ?>lib/fontawesome/fontawesome-iconpicker.css">
<script type="text/javascript" src="<?= \f\ifm::app ()->defaultBackendTemplateUrl ?>lib/fontawesome/fontawesome-iconpicker.js"></script>

<script type="text/javascript" src="<?= \f\ifm::app ()->defaultBackendTemplateUrl ?>lib/ckeditor/ckeditor.js"></script>

<?php include __DIR__ . \f\DS . '..' . \f\DS . "js" . \f\DS . "default.js.php" ; ?>
