<section class="breadcrumbs white-block marginTop70 page-info">
    <div class="container">
        <div class="clearfix">
            <div class="pull-right">
                <ul class="list-unstyled list-inline breadcrumbs-list flex-box-five" style="padding-right:0px">
                    <li>
                        <a href="<?= \f\ifm::app ()->siteUrl ?>"><i class="fa fa-home"></i> <?= 'خانه' ?></a>
                    </li>


                    <li>درباره ما</li>
                </ul>			
            </div>
            <div class="pull-right">
            </div>
        </div>
    </div>
</section>
<section>
    <div class="container" style="min-height: 600px">
        <div class="row" >
            <div class="widget white-block">
                <div class="blog-title" style="font-size: 18px;border-bottom: 1px solid #eee;padding-bottom: 15px;margin-bottom: 10px">
                    <div class="pull-right">
                        <i class="fa fa-info-circle"></i> <?= 'درباره ما' ?>
                    </div>
                    
                    <div class="clearfix"></div>

                </div>
                <?= $row[ 'content' ] ?>
            </div>
        </div>
    </div>
</section>
