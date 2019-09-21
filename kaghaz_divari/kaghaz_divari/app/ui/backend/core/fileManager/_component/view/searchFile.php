<div style="padding: 5px 0px;border-bottom: 1px solid #eee;font-size: 22px">
    نتایج جستجو
</div>
<?php
if(!empty($files))
{
foreach ( $files as $file )
{
    if ( $file[ 'type' ] == 'file' )
    {
        ?>
        <div class="largeImgItem" data-id="<?= $file[ 'id' ] ?>">
            <img src="<?= \f\ifm::app ()->fileBaseUrl . $file[ 'id' ] ?>">
        </div>
        <div class="fileItem" data-id="<?= $file[ 'id' ] ?>">
            <img class='imgItem' src="<?= \f\ifm::app ()->fileBaseUrl . $file[ 'id' ] ?>">
        </div>
        <?php
    }
}
}
else
{
    ?>
    <div style="padding: 5px;color:red">
     هیچ نتیجه ای برای جستجو یافت نشد!
    </div>
    <?
}
?>
<div class='clear'></div>
<div style="padding: 0px 0px 5px; border-bottom: 1px solid #eee;">
     
</div>