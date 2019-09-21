<div class="container-inner basketContainer">
    <div class="row">
      <!--  <div class="copyName"></div>
        <div class="col-md-3">
            <?php
         //   if(!empty($basketBuy)) {
                ?>
                <aside id="basketSidebar" class="basketCol  cart_anchor"">
                <div class="theiaStickySidebar">
                    <div class="content boxShadow">
                        <header class="col-xs-12">
                            <span class="basket-icon"></span>
                            سبد خرید
                            <span id="numItems"
                                  class="item pull-xs-left"><?= \f\ifm::faDigit(number_format(count($basketBuy))); ?></span>
                        </header>
                        <?php
                        //\f\pre($basketBuy);
              //          if (!empty($basketBuy)) {
                            ?>
                            <input type="hidden" value="<?= $basketBuy[0]['order_id'] ?>" id="order_id">
                            <div class="mCustomScrollbar _mCS_1 mCS-dir-rtl mCS_no_scrollbar"
                                 style="max-height: 277px;">
                                <div id="mCSB_1" class="mCustomScrollBox mCS-light mCSB_vertical mCSB_inside"
                                     style="max-height: none;" tabindex="0">
                                    <div id="mCSB_1_container" class="mCSB_container mCS_y_hidden mCS_no_scrollbar_y"
                                         style="position:relative; top:0; left:0;" dir="rtl">
                                        <div id="basketItems">
                                            <?php
                                  /*          $fullPrice = 0;
                                            foreach ($basketBuy as $item) {
                                                $fullPrice += ($item['price'] - $item['discountEnd']) * $item['count'];*/
                                                ?>

                                                <div class="basketItem col-xs-12" data-id="<?= $item['orderItem_id'] ?>"
                                                     id="pro<?= $item['product_id'] ?>">
                                                    <div class="row">
                                                        <div class="itemTitle col-xs-12">
                                                    <span class="productName">
                                                        <a href="<?= \f\ifm::app()->siteUrl . 'productDetail/' . $item['product_id'] ?>"><?= $item['productTitle'] ?></a>
                                                    </span>
                                                        </div>
                                                        <div class="itemPrice">
                                                            <span><?= \f\ifm::faDigit(number_format($item['price'] - $item['discountEnd'])); ?></span>&nbsp;
                                                            ریال

                                                        </div>
                                                        <div class="counterWrap">
                                                            <span class="number pull-left"><?= \f\ifm::faDigit(number_format($item['count'])); ?></span>
                                                            <span class="counter d-inline-block pull-left">
                                                                <input type="hidden"
                                                                       value="<?= $item['product_price_id'] ?>"
                                                                       id="product_price_id">
                                                <input type="hidden" value="<?= $item['product_id'] ?>" id="product_id">
                                                                <input type="hidden"
                                                                       value="<?= ($item['dynamic'] == 'on' ? 'dynamic' : 'static') ?>"
                                                                       id="dynamic">
                                                           <input type="hidden" value="<?= $item['orderItem_id'] ?>"
                                                                  id="orderItem_id">
                                                                <span class="increase fa fa-plus"
                                                                      onclick="plusItem(this)">

                                                          </span>
                                                          <span class="decrease fa fa-minus" onclick="minusItem(this)">

                                                          </span>
                                                      </span>
                                                            <span class="fa fa-trash pull-left trashPro"
                                                                  onclick="deletePro(this)"></span>
                                                        </div>
                                                    </div>
                                                </div>


                                                <?php
                                           // }
                                            ?>
                                        </div>
                                    </div>
                                    <div id="mCSB_1_scrollbar_vertical"
                                         class="mCSB_scrollTools mCSB_1_scrollbar mCS-light mCSB_scrollTools_vertical"
                                         style="display: none;">
                                        <div class="mCSB_draggerContainer">
                                            <div id="mCSB_1_dragger_vertical" class="mCSB_dragger"
                                                 style="position: absolute; min-height: 30px; top: 0px; height: 0px;">
                                                <div class="mCSB_dragger_bar" style="line-height: 30px;"></div>
                                            </div>
                                            <div class="mCSB_draggerRail"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="finalPrice col-xs-12">
                                <div id="basketContent" class="row" style="">
               <span class="col-xs-6 d-inline-block">
               قیمت کل
               </span>
                                    <span class="col-xs-6 d-inline-block text-xs-left"><span
                                                id="totalPrice"><?= \f\ifm::faDigit(number_format($fullPrice)) ?>
                                            &nbsp;</span> ریال</span>
                                </div>
                            </div>
                            <?php
                    //    } else {
                            ?>
                            <div id="basketEmptyContent" class="row">
               <span class="col-xs-12">
               سبد خرید شما خالی است.
               </span>
                            </div>
                            <?php
                      //  }

                        //if (!empty($basketBuy)) {
                            ?>

                            <div id="basketButton" class="col-xs-12 text-xs-center" style="">
                                <a id="rgisterOrder" class="animateBtn" href="<?= \f\ifm::app()->siteUrl ?>cart">
                                    <i class="fa fa-chevron-left" aria-hidden="true"></i>
                                    ثبت سفارش
                                </a>
                            </div>
                            <?php
                       // }
                        ?>
                        <div class="clearfix"></div>
                    </div>

                </div>
                </aside>
                <?php
         //   }else {
                ?>
                <img src="<?=\f\ifm::app()->fileBaseUrl.$picRepBasket?>" class="picRepBasket"/>
                <?php
           // }
            ?>
        </div>-->
        <?php
        if ( $amazingProducts )
        {
            ?>
            <div class="col-md-12">
                <div class="block-recomment padding-bottom-30 opt-2">
                    <div class="title-top">
                        <h3 class="title-block style2"> پیشنهادات شگفت انگیز</h3>
                    </div>
                    <div class="owl-carousel equal-container nav-style2 zoomOption" data-nav="true" data-autoplay="true" data-dots="false" data-loop="true" data-margin="0" data-responsive='{"0":{"items":2},"480":{"items":3},"641":{"items":3},"992":{"items":4},"1200":{"items":5},"1400":{"items":5}}'>

                        <?php
                        $this->registerGadgets( [
                            'dateG' => 'date' ] );
                        foreach ( $amazingProducts AS $data )
                        {
                            $picture = \f\ttt::service( 'core.fileManager.loadFileUrl',[
                                'fileId' => $data['picture'],
                                'width'  => '124',
                                'height' => '165',
                                'option' => 'auto',
                            ] );

                            $time      = $this->dateG->dateJaToGr( $data['date_end'],1 );
                            $timeAmzin = explode( '/',$time );
                                if($data['discount_type']=='percent'){
                                    $price=$data['colleague_price']-($data['colleague_price']*($data['discount']/100));
                                    $mainPrice=$data['colleague_price'];
                                }else{
                                    $price=$data['colleague_price']-$data['discount'];
                                    $mainPrice=$data['colleague_price'];
                                }

                            ?>

                            <div class="product-item style-1">
                                <div class="product-inner">
                                    <div class="product-thumb style2 amazing-product-main">
                                        <div class="thumb-inner">
                                            <a href="<?= \f\ifm::app()->siteUrl . 'productDetail/' . $data['id'].'/'.$data['title']  ?>" title="<?= $data['title'] ?>"><img src="<?= $picture ?>" alt="<?= $data['title'] ?>" title="<?= $data['title'] ?>"></a>
                                        </div>
                                        <span class="onsale style2 currency_amazing"><?php
                                            if($data['discount_type']=='percent'){
                                                $currency='%';
                                            }else{
                                                $currency='R';
                                            }
                                            echo  $data['discount'].' '.$currency; ?>  </span>
                                    </div>
                                    <div class="product-innfo">
                                        <div class="product-name  main-page"><a href="<?= \f\ifm::app()->siteUrl . 'productDetail/' . $data['id'].'/'.$data['title']  ?>" title="<?= $data['title'] ?>"><?= $data['title'] ?></a></div>
                                        <span class="price">
                                    <ins><?= \f\ifm::faDigit(number_format($price)). ' ریال ';?></ins>
                                    <del><?=\f\ifm::faDigit(number_format($mainPrice)).' ریال '?></del>
                                    </span>
                                        <div class="hover-hidden">
                                            <div class="inner">
                                                <p class="product-des"></p>
                                                <a class="btn-add-to-cart" title="<?= $data['title'] ?>" onclick="sendAddToCart(<?=$data['id']?>,<?=$data['product_price_id']?>,this)"> &nbsp; افزودن به سبد خرید</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <?php
                        }
                        ?>
                    </div>

                </div>
            </div>
        <?php } ?>





