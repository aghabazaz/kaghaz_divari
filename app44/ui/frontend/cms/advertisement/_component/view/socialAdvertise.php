<?php
if(!empty($row)) {
    ?>
    <div class="block-banner opt-2 style3">
        <div class="row">
            <div class="col-md-6">
                <div class="promotion-banner style-1">
                    <a href="<?= $row[0]['link'] ?>" title="<?= $row[0]['name'] ?>" class="banner-img"><img
                                src="<?= \f\ifm::app()->fileBaseUrl . $row[0]['picture'] ?>"
                                alt="<?= $row[0]['name'] ?>" title="<?= $row[0]['name'] ?>"></a>
                </div>
            </div>
            <div class="col-md-6">
                <div class="promotion-banner style-1">
                    <a href="<?= $row[1]['link'] ?>" title="<?= $row[1]['name'] ?>" class="banner-img"><img
                                src="<?= \f\ifm::app()->fileBaseUrl . $row[1]['picture'] ?>"
                                alt="<?= $row[1]['name'] ?>" titel="<?= $row[1]['name'] ?>"></a>
                </div>
            </div>
        </div>
    </div>
    <?php
}
?>



