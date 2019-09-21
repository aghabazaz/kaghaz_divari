
<div class="main-page-banner" style="padding-top:9px;" dir="ltr">
    <?php
    foreach ( $row AS $data )
    {
    ?>
    <div class="col-xs-4 pull-left main-banner">
        <div class="box-sizing">
            <a href="<?= $data['link'] ?>" target="_self">
                <img alt="<?= $data['title'] ?>" class="img-rounded lazy-loaded" src="<?= \f\ifm::app ()->fileBaseUrl . $data['picture'] ?>" data-src="#">
            </a>
        </div>
    </div>
        <?php
    }
    ?>
    <div class="clearfix"></div>
</div>


