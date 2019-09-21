<div class="theiaStickySidebar">
    <div class="content boxShadow">
        <header class="col-xs-12">
            <span class="fa fa-cart-plus"></span>
            سبد خرید
            <span id="numItems" class="item pull-xs-left"><?=\f\ifm::faDigit(count($basketBuy))?></span>
        </header>
        <?php
       //\f\pre($basketBuy);
        if(!empty($basketBuy)) {
            ?>
            <input type="hidden" value="<?=$basketBuy[0]['order_id']?>" id="order_id">
            <div class="mCustomScrollbar _mCS_1 mCS-dir-rtl mCS_no_scrollbar"
                 style="max-height: 277px;">
                <div id="mCSB_1" class="mCustomScrollBox mCS-light mCSB_vertical mCSB_inside"
                     style="max-height: none;" tabindex="0">
                    <div id="mCSB_1_container" class="mCSB_container mCS_y_hidden mCS_no_scrollbar_y"
                         style="position:relative; top:0; left:0;" dir="rtl">
                        <div id="basketItems">
                            <?php
                            $fullPrice=0;
                            //\f\pre($basketBuy);
                            foreach ($basketBuy as $item) {
                                $fullPrice+=($item['price']-$item['discountEnd'])*$item['count'];
                                ?>
                                <div class="basketItem col-xs-12" data-id="<?=$item['orderItem_id']?>" id="pro<?=$item['product_id']?>" >
                                    <div class="row">
                                        <div class="itemTitle col-xs-12">
                                                    <span class="productName">
                                                        <a href="<?= \f\ifm::app()->siteUrl . 'productDetail/' . $item['product_id'] ?>"><?= $item['productTitle'] ?></a>
                                                    </span>
                                        </div>
                                        <div class="itemPrice">

                                            <span><?=\f\ifm::faDigit(number_format($item['price']-$item['discountEnd']));?></span>&nbsp;
                                            ریال

                                        </div>
                                        <div class="counterWrap">
                                            <span class="number pull-left"><?= \f\ifm::faDigit($item['count']) ?></span>
                                            <span class="counter d-inline-block pull-left">
                                                                <input type="hidden" value="<?=$item['product_price_id']?>" id="product_price_id">
                                                <input type="hidden" value="<?=$item['product_id']?>" id="product_id">
                                                 <input type="hidden" value="<?=($item['dynamic']=='on'?'dynamic':'static')?>" id="dynamic">
                                                 <input type="hidden" value="<?=$item['orderItem_id']?>" id="orderItem_id">
                                                          <span class="increase fa fa-plus" onclick="plusItem(this)">
                                                          </span>
                                                          <span class="decrease fa fa-minus" onclick="minusItem(this)">
                                                          </span>
                                                      </span>
                                            <span class="fa fa-trash pull-left trashPro" onclick="deletePro(this)"></span>
                                        </div>
                                    </div>
                                </div>


                                <?php
                            }
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
                    <span class="col-xs-6 d-inline-block text-xs-left"><span id="totalPrice"><?=\f\ifm::faDigit(number_format($fullPrice));?>&nbsp;</span> ریال</span>
                </div>
            </div>
            <?php
        }else{
            ?>
            <div id="basketEmptyContent" class="row" >
               <span class="col-xs-12">
               سبد خرید شما خالی است.
               </span>
            </div>
            <?php
        }

        if(!empty($basketBuy)) {
            ?>
            <div id="basketButton" class="col-xs-12 text-xs-center" style="">
                <a id="rgisterOrder" class="animateBtn" href="<?=\f\ifm::app()->siteUrl?>cart">
                    <i class="fa fa-chevron-left" aria-hidden="true"></i>
                    ثبت سفارش
                </a>
            </div>
            <?php
        }
        ?>
        <div class="clearfix"></div>
    </div>

</div>
