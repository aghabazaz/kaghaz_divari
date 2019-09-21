<section class="big-search">
    <ul class="list-unstyled big-search-slider">
        <?php
        foreach ($row AS $data)
        {
            ?>
            <li><img data-src="<?= \f\ifm::app ()->fileBaseUrl.$data['picture'] ?>" src="<?= \f\ifm::app ()->siteUrl ?>app/ui/templates/frontend/base/images/holder.jpg" class="reviews-lazy-load" width="1600" height="1067" alt=""></li>
          
            <?php
        }
        ?>
        
       
    </ul>

    <!--<div class="big-search-overlay"></div>-->
    <div class="container" style="height:180px">
       
    </div>

</section>