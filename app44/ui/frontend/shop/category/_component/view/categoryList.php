<div class="content">
    <div class="row p8 flex-c-child">
    <?foreach ($categoryList AS $data)
    {
        ?>
        <div class="col-lg-2 col-md-4 col-xs-6">
            <div class="special-cat">
                <a href="<?= \f\ifm::app ()->siteUrl . 'product/' . $data[ 'title_en' ] ?>">
                    <span class="title"> <?= $data['title'] ?> </span>
                    <figure class="thumb"><img src="<?= \f\ifm::app()->fileBaseUrl . $data['picture']; ?>" alt="<?= $data['title'] ?>""></figure>
                    <span class="more"><i class="fa fa-chevron-down"></i><i class="fa fa-chevron-down"></i></span>
                </a>
            </div>
        </div>
        <?php
    }
    ?>


    </div>
</div>

<style>
    figure.thumb img {
        max-width: 150px;
    }
</style>






















