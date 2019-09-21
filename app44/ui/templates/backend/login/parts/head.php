<meta charset="utf-8">

<title>
    <?= isset($title) ? $title : \f\ifm::app()->backendTitle ?>
</title>

<script src="<?= \f\ifm::app()->defaultBackendTemplateUrl ?>js/jquery.js"></script>
<script src="<?= \f\ifm::app()->defaultBackendTemplateUrl ?>js/bootstrap.js"></script>

<script src="<?= \f\ifm::app()->defaultBackendTemplateUrl ?>lib/jqueryui/jquery-ui.min.js"></script>
<link rel="stylesheet" href="<?= \f\ifm::app()->defaultBackendTemplateUrl ?>lib/jqueryui/jquery-ui.min.css">

<script src="<?= \f\ifm::app()->defaultBackendTemplateUrl ?>lib/nicescroll/nice_scroll.js"></script>

<script src="<?= \f\ifm::app()->defaultBackendTemplateUrl ?>lib/select/select2.js"></script>
<script src="<?= \f\ifm::app()->defaultBackendTemplateUrl ?>lib/select/select2_locale_fa.js"></script>

<script src="<?= \f\ifm::app()->defaultBackendTemplateUrl ?>lib/parsley/parsley.js"></script>

<link rel="stylesheet" href="<?= \f\ifm::app()->defaultBackendTemplateUrl ?>lib/select/select2.css">

<link rel="stylesheet" href="<?= \f\ifm::app()->defaultBackendTemplateUrl ?>css/bootstrap.css">
<link rel="stylesheet" href="<?= \f\ifm::app()->defaultBackendTemplateUrl ?>css/font-awesome.css">
<link rel="stylesheet" href="<?= \f\ifm::app()->defaultBackendTemplateUrl ?>css/font.css">
<link rel="stylesheet" href="<?= \f\ifm::app()->defaultBackendTemplateUrl ?>css/main.css">
<link rel="stylesheet" href="<?= \f\ifm::app()->defaultBackendTemplateUrl ?>css/style.css">
<link rel="stylesheet" href="<?= \f\ifm::app()->defaultBackendTemplateUrl ?>css/skins/darkblue.css">

<script language="javascript" type="text/javascript" src="<?= \f\ifm::app()->defaultBackendTemplateUrl ?>lib/datepicker/jalali.js"></script> 
<script src="<?= \f\ifm::app()->defaultBackendTemplateUrl ?>js/tooltip.js"></script>

<?php include __DIR__ . \f\DS . '..' . \f\DS . "js" . \f\DS . "default.js.php" ; ?>
