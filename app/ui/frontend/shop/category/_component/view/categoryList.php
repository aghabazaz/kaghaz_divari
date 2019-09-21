<div class="container-fluid">
    <div class="row align-items-center justify-content-center mt-3 mb-md-5 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="400">
        <div class="col-md-auto">
            <ul class="nav sort-source justify-content-center mb-4 mb-md-0" data-sort-id="portfolio" data-option-key="filter" data-plugin-options="{'layoutMode': 'masonry', 'filter': '*'}">
                <li class="nav-item active" data-option-value="*"><a class="nav-link active" href="#">همه</a></li>
                <?php
                $i = 1;
                $active = 'active';
                foreach ($specialCategory as $item) {
                    ?>
                    <li class="nav-item" data-option-value=".<?=$item['title_en']?>"><a class="nav-link text-uppercase" href="#"><?=$item['title_en']?></a></li>


                    <?php
                    $i++;
                    $active = '';
                } ?>
            </ul>
        </div>
    </div>
    <div class="row appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="600">
        <div class="col-md-12 px-0">
            <div class="sort-destination-loader sort-destination-loader-showing">
                <ul class="portfolio-list portfolio-list-no-gap sort-destination" data-sort-id="portfolio">
                    <?php
                    foreach ($newProducts as $item) {
                    if(!empty($item['product'])) {
                    foreach ($item['product'] as $data){
                    $stock=false;
                    if($data['stock']>0){
                        $stock=true;
                    }
                    if($data['amazingPrice']>0 and $data['amazingPrice']!=''){
                        $discount=$data['amazingPrice'];
                        $typeDiscount=$data['discountTypeAmazing'];
                    }else{
                        $discount=$data['discount'];
                        $typeDiscount=$data['type_discount'];
                    }

                    if($typeDiscount=='percent'){
                        $price=$data['shopKepperPrice']-($data['shopKepperPrice']*$discount/100);
                    }else if($typeDiscount=='fixed'){
                        $price=$data['shopKepperPrice']-$discount;
                    }else{
                        $price=$data['shopKepperPrice'];
                    }
                                $picture = \f\ttt::service('core.fileManager.loadFileUrl', [
                                    'fileId' => $data['picture'],
                                    'width' => '270',
                                    'height' => '270',
                                    'option' => 'auto',
                                ]);

                    ?>
                    <li class="col-sm-4 col-md-4 col-lg-1-5 p-0 isotope-item  <?= $catTitle[$item['catId']] ?>">
                        <div class="portfolio-item appear-animation" data-appear-animation="fadeInUpShorter" data-plugin-options="{'accY' : -50}">
                            <a href="<?= \f\ifm::app()->siteUrl . 'productDetail/' . $data['id'] ?>">
													<span class="image-frame image-frame-style-1 image-frame-effect-1">
														<span class="image-frame-wrapper">
															<img src="<?=$picture?>" class="img-fluid" style="height:230px;" alt="">
															<span class="image-frame-inner-border"></span>
															<span class="image-frame-action">
																<span class="image-frame-action-icon">
																	<i class="fa fa-paperclip"></i>
																</span>
															</span>
														</span>
													</span>
                            </a>
                        </div>
                    </li>


                        <?php
                    }
                    }
                    }
                    ?>
                </ul>
            </div>
        </div>
    </div>
</div>
