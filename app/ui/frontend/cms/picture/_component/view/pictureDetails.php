<link href="<?= \f\ifm::app ()->siteUrl ?>app/ui/templates/frontend/digifirst/css/lightgallery.css" rel="stylesheet">
<div class="container topbreadcrumb" >
    <div>
        <div class="url-page-box">
            <div class="page-address-box padding-addressBar">
                <i style="padding-left:3px;" class="fa fa-home"></i>
                <span class="address-name">
                    <a href="<?= \f\ifm::app()->siteUrl ?>">خانه</a>
                </span>
                <span class="arrow-address5 fa fa-angle-left"></span><span class="address-name"> گالری تصویر </span>
            </div>
        </div>
    </div>
</div>
<?php
                                        $path    = 'cms.picture.' . $row[ 0 ][ 'id' ] ;
                                        $picture = \f\ttt::service ( 'core.fileManager.getList',
                                            [
                                                'path' => $path,
                                            ] ) ;
                                        $m       = $picture[ 'list' ] ;
                                        $i       = 0 ;

                                            ?>
<div class="container">
    <div class="demo-gallery" >
        <ul id="lightgallery" class="list-unstyled row">
            <?php
            foreach ( $m as $data )
            {
                ?>
                <li class="col-xs-6 col-sm-4 col-md-3" data-responsive="<?php echo \f\ifm::app ()->fileBaseUrl . $data[ 'id' ] ; ?>" data-src="<?php echo \f\ifm::app ()->fileBaseUrl . $data[ 'id' ] ; ?>" data-sub-html="<h4><?php echo $data[ 'title' ] ?></h4>">
                    <a href="">
                        <img class="img-responsive" src="<?php echo \f\ifm::app ()->fileBaseUrl . $data[ 'id' ] ; ?>">
                    </a>
                </li>
                <?php
            }
            ?>
        </ul>
    </div>
</div>


<script type="text/javascript">
    $(document).ready(function () {
        $(window).scroll(function(){

            if($(window).scrollTop()>200){
                $('.accessMenu').css({'display':'none'});
                $('.middleMenu').css({'display':'none'});
                $('.small-logo').css({'display':'block'});
            }
            if($(window).scrollTop()<200){
                $('.accessMenu').css({'display':'block'});
                $('.middleMenu').css({'display':'block'});
                $('.small-logo').css({'display':'none'});
            };

            var currentScroll = $(this).scrollTop();

        });
        $('#lightgallery').lightGallery();
    });
</script>
<!--for gallery image-->
<script src="<?= \f\ifm::app ()->siteUrl ?>app/ui/templates/frontend/digifirst/js/picturefill.min.js"></script>
<script src="<?= \f\ifm::app ()->siteUrl ?>app/ui/templates/frontend/digifirst/js/lightgallery-all.js"></script>
<script src="<?= \f\ifm::app ()->siteUrl ?>app/ui/templates/frontend/digifirst/js/jquery.mousewheel.min.js"></script>
