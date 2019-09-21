    <link type="text/css" rel="stylesheet" href="<?= \f\ifm::app()->siteUrl ?>app/ui/templates/frontend/digifirst/css/galleryPic/lightgallery.css" />
    <?php
    $path = 'cms.picture.' . $row[0]['id'];
    $picture = \f\ttt::service('core.fileManager.getList',
        [
            'path' => $path,
        ]);
    $m = $picture['list'];
    $a = explode("/", $row[0]['pictureUrl']);
    $a[3] = $row[0]['id'];
    $i = 0;
   // \f\pre($picture['list']);
    ?>
    <div class="container marginTop20R">
        <div class="col-md-12">
    <div class="url-page-box">
        <div class="page-address-box padding-addressBar">
            <i style="padding-left:3px;" class="fa fa-home"></i><span class="address-name"><a
                        href="<?= \f\ifm::app()->siteUrl ?>" title="خانه">خانه</a></span>
            <span class="arrow-address5 fa fa-angle-left"></span><span class="address-name"><a
                        href="<?= \f\ifm::app()->siteUrl ?>" title="گالری">گالری</a></span>
        </div>
    </div>
        </div>

        <div class="col-md-12">
        <div class="demo-gallery url-page-box">
            <ul id="lightgallery" class="list-unstyled row">
                <?php
                foreach($picture['list'] as $data){
                    if($data['type']=='file') {
                        ?>
                        <li class="col-xs-6 col-sm-4 col-md-3"
                            data-responsive="<?php echo \f\ifm::app()->fileBaseUrl . $data['id'] ?> 375, img/1-480.jpg 480, img/1.jpg 800"
                            data-src="<?php echo \f\ifm::app()->fileBaseUrl . $data['id'] ?>"
                            data-sub-html="<h4><?php echo $data['title'] ?></h4>">
                            <a href="">
                                <img class="img-responsive"
                                     src="<?php echo \f\ifm::app()->fileBaseUrl . $data['id'] ?>">
                            </a>
                        </li>
                        <?php
                    }
                }
                ?>
            </ul>
        </div>

        </div>

    </div>
    <!-- MAIN CONTENT-->
<!-- lightgallery plugins -->

