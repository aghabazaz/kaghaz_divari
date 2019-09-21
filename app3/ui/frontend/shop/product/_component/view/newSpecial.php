<div class="col-md-9">
<div class="block-recomment padding-bottom-30 opt-2">
<div class="title-top">
        <h3 class="title-block style2"> جدیدترین محصولات </h3>
    </div>
    <?php
    if(!empty($row)) {
        //\f\pre($row);
        ?>
        <div class="owl-carousel equal-container nav-style2 zoomOption" data-nav="true" data-autoplay="false" data-dots="false"
             data-loop="true" data-margin="0"
             data-responsive='{"0":{"items":2},"480":{"items":3},"641":{"items":3},"992":{"items":3},"1200":{"items":5},"1400":{"items":5}}'>
            <?php
            foreach ($row AS $data) {
                $picture = \f\ttt::service('core.fileManager.loadFileUrl', [
                    'fileId' => $data['picture'],
                    'width' => '124',
                    'height' => '165',
                    'option' => 'auto',
                ]);
                ?>
                <div class="product-item style-1">
                    <div class="product-inner">
                        <div class="product-thumb style2">
                            <div class="thumb-inner">
                                <a href="<?= \f\ifm::app()->siteUrl . 'productDetail/' . $data['id'].'/'.$data['title'] ?>" title="<?=$data['title']?>">
                                    <img class="b-lazy img-responsive" src="<?= $picture ?>" alt="<?= $data['title'] ?>" title="<?=$data['title']?>"></a>
                            </div>
                        </div>
                        <div class="product-innfo">
                            <div class="product-name">
                                <a href="<?= \f\ifm::app()->siteUrl . 'productDetail/' . $data['id'].'/'.  $data['title']?>" title="<?=$data['title']?>"><?= $data['title'] ?></a>
                            </div>
                            <span class="price">
                        <?php

                        if($data['dynamic']=='false') {
                            $mainPrice = $data['price'];
                            if ($data['type_discount'] == 'percent') {
                                $price = $data['price'] - (($data['discount'] * $data['price']) / 100);
                            } else {
                                $price = $data['price'] - $data['discount'];
                            }
                        }else{
                            $mainPrice=$data['majorPrice'];
                        }

                       //. \f\pre($data);
                        if ($data['discount'] > 0) {
                            ?>
                            <ins><?= \f\ifm::faDigit(number_format($price)) . ' ریال '; ?></ins>
                            <del><?= \f\ifm::faDigit(number_format($mainPrice)) . ' ریال ' ?></del>
                            <?php
                        } else {
                            ?>
                            <ins><?= \f\ifm::faDigit(number_format($mainPrice)) . ' ریال '; ?></ins>
                            <del></del>
                        <?php }
                        ?>

                    </span>
                            <div>
                                <div class="inner">
                                    <p class="product-des"></p>

                                    <a href="<?= \f\ifm::app()->siteUrl . 'productDetail/' . $data['id'].'/'.  $data['title']?>" class="btn-add-to-cart" data-type="<?=($data['dynamic']=='true'?'dynamic':'static')?>" title="<?=$data['title']?>">جزئیات محصول</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
        <?php
    }else{
        ?>
        <div>هیچ محصولی در این دسته بندی وجود ندارد.</div>
    <?php
    }
    ?>
</div>

