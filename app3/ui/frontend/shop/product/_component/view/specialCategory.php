<div class="container-inner">
    <div class="row">
<div class="col-md-12">
    <?php
        if(!empty($row)) {
            ?>
            <div class="special-cats container-fluid noPaddingRL">
                <header><span class="title"></span></header>
                <div class="content">
                    <div class="row p8 flex-c-child">
                        <?php
                        foreach ($row as $data) {
                            ?>
                            <div class="col-lg-2 col-md-4 col-xs-6">
                                <div class="special-cat">
                                    <a href="<?=\f\ifm::app()->siteUrl."product/".$data['title_en']?>" title="<?=$data['title']?>">
                                        <span class="title"><?= $data['title'] ?></span>
                                        <figure class="thumb"><img src="<?= \f\ifm::app()->fileBaseUrl . $data['picture'] ?>"
                                                                   alt="<?= $data['title'] ?>" title="<?=$data['title']?>"></figure>
                                        <span class="more"><i class="fa fa-chevron-down"></i><i class="fa fa-chevron-down"></i></span>
                                    </a>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>
</div>
    </div>
</div>