<?php
\f\pre($contntList);
foreach ($contntList AS $data) {
    $this->registerGadgets(array(
        'dateG' => 'date'));
    $date_register = $this->dateG->dateTime($data['date_register'], 2);
    $date = explode("/", $date_register);
    $formattedDate = $this->dateG->formated_j_date($date[0], $date[1],
        $date[2]);

    $picture = \f\ttt::service('core.fileManager.loadFileUrl', [
        'fileId' => $data['picture'],
        'width' => '64',
        'height' => '64',
        'option' => 'auto',
    ]);
    ?>
    <div class="container">
        <div class="row rowNews">
            <div class="col-lg-4 col-md-4 imgLatestNews">
                <img class="b-lazy img-responsive" src="<?= \f\ifm::app()->siteUrl . 'loading.gif' ?>"
                     data-src="<?= $picture ?>" alt="<?= $data['title'] ?>"/>
            </div>
            <div class="col-lg-8 col-md-8 textLatestNews">
                <a href="<?= \f\ifm::app()->siteUrl . 'newsDetail/' . $data['id'] ?>"><h5><?= $data['title'] ?></h5></a>
                <i class="fa fa-clock-o" aria-hidden="true"></i>
                <span><?= \f\ifm::faDigit($formattedDate[2]) ?> <?= $formattedDate[1] ?> <?= \f\ifm::faDigit($formattedDate[0]) ?> </span>
            </div>
        </div>
    </div>
    <?php
}
?>