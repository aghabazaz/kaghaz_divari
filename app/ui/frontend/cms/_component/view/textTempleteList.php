<?php
if(!empty($row)){
foreach ( $row AS $data )
{
    ?>
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="event-box">
            <div class="content">
            </div><!-- .content end -->
            <div class="content-overlay">
                <h3 style="color: <?= $data['color']?>;"><?= $data['title']?></h3>
                <p><?= $data['text']?></p>
                <i style="color: <?= $data['color']?>" class="fa <?= $data['icon']?>"></i>
            </div><!-- .content-overlay end -->
        </div><!-- .event-box end -->
    </div>


    <?php
}
}else{
    ?>
<div>هیچ مطلبی در این زمینه وجود ندارد.</div>
    <?php
}
?>