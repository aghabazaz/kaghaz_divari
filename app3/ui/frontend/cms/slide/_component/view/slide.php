
<div class="container-inner">
    <div class="block-slide full-width slide-opt-5">
        <div class="owl-carousel nav-style-1" data-nav="false" data-autoplay="ture" data-dots="true" data-loop="true" data-margin="0" data-responsive='{"0":{"items":1},"600":{"items":1},"1000":{"items":1}}'>
            <?php
            $i = 0 ;
            if(!empty($SlideList)) {
                foreach ($SlideList AS $data) {
                    $picture = \f\ttt::service('core.fileManager.loadFileUrl', [
                        'fileId' => $data['picture']
                    ]);
                    if ($i == 0) {
                        $active = 'active';
                    } else {
                        $active = '';
                    }
                    ?>
                    <div class="item-slide item-slide-1">
                        <a href="<?=$data['link']?>" title="<?=$data['title']?>" target="_blank"><img class="main-slide-img" src="<?= $picture ?>" data-src="<?= $picture ?>"
                                        alt="<?= $data['title'] ?>" title="<?=$data['title']?>"></a>
                    </div>
                    <?php
                    $i++;
                }
            }
            ?>
        </div>
    </div>
</div>

