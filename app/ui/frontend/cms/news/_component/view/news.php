<?php
//\f\pre($newsList);
if(!empty($newsList)) {

    foreach ($newsList AS $data) {
        $this->registerGadgets(array(
            'dateG' => 'date'));
        $date_register = $this->dateG->dateTime($data['date_register'], 2);
        $date = explode("/", $date_register);
        $formattedDate = $this->dateG->formated_j_date($date[0], $date[1],
            $date[2]);

        $picture = \f\ttt::service('core.fileManager.loadFileUrl', [
            'fileId' => $data['picture'],
            'width' => '244',
            'height' => '114',
            'option' => 'auto',
        ]);
        ?>

<div class="owl-carousel nav-style2" data-nav="true" data-autoplay="true" data-dots="false" data-loop="true" data-margin="30" data-responsive='{"0":{"items":1},"480":{"items":3},"768":{"items":3},"1200":{"items":1}}'>

        <div class="post-item">
            <div class="post-thumb">
                <a href="<?= \f\ifm::app()->siteUrl . 'newsDetail/' . $data['id'].'/'.$data['title'] ?>" title="<?= $data['title'] ?>"><img
                            src="<?= $picture ?>" alt="<?= $data['title'] ?>" title="<?= $data['title'] ?>"></a>
            </div>
            <div class="post-metas">
                <span class="icon"><i class="fa fa-calendar"
                                      aria-hidden="true"></i><span><?= \f\ifm::faDigit($formattedDate[2]) ?> <?= $formattedDate[1] ?> <?= \f\ifm::faDigit($formattedDate[0]) ?></span></span>
            </div>
            <h3 class="post-name"><a title="<?= $data['title'] ?>"
                        href="<?= \f\ifm::app()->siteUrl . 'newsDetail/' . $data['id'].'/'.$data['title'] ?>"><?= $data['title'] ?></a>
            </h3>
            <div class="post-item-info">
                <a href="<?= \f\ifm::app()->siteUrl . 'newsDetail/' . $data['id'].'/'.$data['title'] ?>" class="read-more-homepage" title="<?=$data['title']?>">مشاهده
                    بیشتر</a>
            </div>
        </div>
</div>
        <?php
    }
}else{
    ?>
<div>هیچ خبری منتشر نشده است.</div>
    <?php
}
?>










