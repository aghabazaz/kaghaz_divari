<div class="col-md-9">
    <div class="block-recomment padding-bottom-30 opt-2">
        <div class="title-top">
            <h3 class="title-block style2"> <?= $title ?> </h3>
        </div>
        <div class="owl-carousel equal-container nav-style2 select-cat" data-nav="true" data-autoplay="false"
             data-dots="false" data-loop="true" data-margin="0"
             data-responsive='{"0":{"items":2},"480":{"items":3},"641":{"items":3},"992":{"items":3},"1200":{"items":5},"1400":{"items":5}}'>
            <?php
          //\f\pre($newProducts);
            foreach ( $newProducts AS $data )
            {
                $picture = \f\ttt::service( 'core.fileManager.loadFileUrl',[
                    'fileId' => $data['picture'],
                    'width'  => '124',
                    'height' => '165',
                    'option' => 'auto',
                ] );
                if(in_array($data['id'],$amazingProId)){

                }else {
                    ?>
                    <div class="product-item style-1">
                        <div class="product-inner">
                            <div class="product-thumb style2">
                                <div class="thumb-inner">
                                    <a href="<?= \f\ifm::app()->siteUrl . 'productDetail/' . $data['id'] ?>"><img
                                                src=<?= \f\ifm::app()->fileBaseUrl . $data['picture']; ?>" alt="<?= $data['title'] ?>
                                        "></a>
                                </div>
                            </div>
                            <div class="product-innfo">
                                <div class="product-name main-page"><a
                                            href="<?= \f\ifm::app()->siteUrl . 'productDetail/' . $data['id'] ?>"><?= $data['title'] ?></a>
                                </div>
                                <span class="price">
                                <?php
                                if (empty($_SESSION['user_id']) or $_SESSION['type_user'] == 'normUser') {
                                    $mainPrice = $data['user_price'] - $data['endDisNormUser'];
                                } else {
                                    $mainPrice = $data['price'] - $data['endDisSeller'];
                                }
                                ?>
                                    <ins><?php if (empty($_SESSION['user_id']) or $_SESSION['type_user'] == 'normUser') {
                                            echo $mainPrice;
                                        } else {
                                            echo $mainPrice;
                                        } ?>&nbsp;
                                    ریال</ins>
                                    <?php
                                    if (empty($_SESSION['user_id']) or $_SESSION['type_user'] == 'normUser') {
                                        $mainDis = $data['endDisNormUser'];
                                        $price = $data['user_price'];
                                    } else {
                                        $mainDis = $data['endDisSeller'];
                                        $price = $data['price'];
                                    }

                                    if ($mainDis > 0) {
                                        ?>
                                        <del>
                                   <?= $price ?>
                                            &nbsp;
                                        ریال
                                </del>
                                        <?php
                                    }
                                    ?>
                                    </span>
                                <div>
                                    <div class="inner">
                                        <p class="product-des"></p>
                                        <a href="<?= \f\ifm::app()->siteUrl . 'productDetail/' . $data['id'] ?>"
                                           class="btn-add-to-cart">جزئیات بیشتر</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
    </div>

</div>