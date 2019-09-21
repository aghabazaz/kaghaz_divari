<?php
//\f\pr($ajaxParams);

$dialogW      = \f\widgetFactory::make('dialog') ;
$dialogId     = 'dialogDisplay' . rand(1, 1000000) ;
$funcNameRand = rand(1, 1000000) ;
$dialogMarkup = $dialogW->begin(array (
    'htmlOptions' => array (
        'id'           => $dialogId,
        'funcNameRand' => $funcNameRand,
        
    ),
    'title'       => array (
        'text' => $dialogTitle
    ),
   
    'style'       => array (
        'width' => $width?$width:'1000px'
    )
        )) ;

$dialogMarkup .= $dialogW->flush(array ()) ;
$dialogMarkup = str_replace(array ( "\r\n", "\n", "\r" ), '', $dialogMarkup) ;
?>

<script>
    var runningFuncRandName;
    var fileManagerContainerId;

    function displayDialog<?= $funcNameRand ?>(response) {
        runningFuncRandName = <?= $funcNameRand ?>;
        
        fileManagerContainerId = '<?= $containerId ?>';
        $('#<?= $dialogId ?> .modal-body').html(response.content);
        $("#<?= $dialogId ?> ").modal();
        $('form').parsley();
    }

    function closeFileDialog<?= $funcNameRand ?>() {
        $("#<?= $dialogId ?> ").modal('hide');
    }
    $(document).ready(function () {
        var dialogMarkup = $.parseHTML("<?= $dialogMarkup ?>");
        $('body').append(dialogMarkup);
        $('#<?= $triggerElement ?>').click(function (e) {
            e.preventDefault();

<?php
if ( isset($ajaxParams) )
{
    echo "ajaxParams = " . json_encode($ajaxParams) . ';' ;
}
else
{
    echo "ajaxParams = {};" ;
}
?>
            widgetHelper.tt('ui', '<?= $targetRoute ?>', ajaxParams, 'displayDialog<?= $funcNameRand ?>');

        });
    });
</script>