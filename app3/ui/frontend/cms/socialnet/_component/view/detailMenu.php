<?
if ( $row[ 'status' ] == 'enabled' )
{
    ?>
    <section class="breadcrumbs white-block">
        <div class="container">
            <div class="clearfix">
                <div class="pull-right">
                    <ul class="list-unstyled list-inline breadcrumbs-list" style="padding-right:0px">
                        <li>
                            <a href="<?= \f\ifm::app ()->siteUrl ?>"><i class="fa fa-home"></i> <?= 'خانه' ?></a>
                        </li>

                        <li><?= $row[ 'Title' ] ?></li>
                    </ul>			
                </div>
                <div class="pull-right">
                </div>
            </div>
        </div>
    </section>
    <section class="single-blog">
        <div class="container" >
            <div class="row">
                <div class="col-sm-12">

                    <div >

                        <div class="widget blog-media white-block" >
                            <div class="blog-title" style="font-size: 18px;border-bottom: 1px solid #eee;padding-bottom: 15px;margin-bottom: 10px">
                                <div class="pull-right">
                                    <i class=""></i> <?= $row[ 'Title' ] ?>
                                </div>

                                <div class="clearfix"></div>

                            </div>
                            <?= $row[ 'content' ] ?>
                        </div>
                    </div>
                </div>

   
 
            </div>
        </div>
    </section>

    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&language=fa"></script>
    <?
}
?>

