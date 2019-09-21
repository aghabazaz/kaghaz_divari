<section class="big-search" style="height:550px">
    <div id="revolution-slider" >
        <ul>
            <?
            foreach ( $row AS $data )
            {
                ?>
                <li data-transition="fade"  data-masterspeed="1500">
                    <!--  BACKGROUND IMAGE -->
                    <img src="<?= \f\ifm::app ()->fileBaseUrl . $data[ 'picture' ] ?>" alt="" />
                    <div class="tp-caption med-white sft"
                         data-x="0"
                         data-y="200"
                         data-speed="800"
                         data-start="400"
                         data-easing="easeInOutExpo"
                         data-endspeed="450" style="color:<?=$data['color']?>">
                             <?= $data[ 'title' ] ?>
                    </div>

                    <div class="tp-caption ultra-big-white customin customout start"
                         data-x="0"
                         data-y="center"
                         data-customin="x:0;y:0;z:0;rotationX:0;rotationY:0;rotationZ:0;scaleX:2;scaleY:2;skewX:0;skewY:0;opacity:0;transformPerspective:600;transformOrigin:50% 50%;"
                         data-customout="x:0;y:0;z:0;rotationX:0;rotationY:0;rotationZ:0;scaleX:0.85;scaleY:0.85;skewX:0;skewY:0;opacity:0;transformPerspective:600;transformOrigin:50% 50%;"
                         data-speed="800"
                         data-start="400"
                         data-easing="easeInOutExpo"
                         data-endspeed="400" style="color:<?=$data['color']?>">
                             <?= $data[ 'comment' ] ?>
                    </div>
                    <?
                    if ( $data[ 'link' ] )
                    {
                        ?>
                        <div class="tp-caption sfb"
                             data-x="0"
                             data-y="335"
                             data-speed="400"
                             data-start="800"
                             data-easing="easeInOutExpo">
                            <a href="<?= $data[ 'link' ] ?>" class="btn-slider">
                                <?= 'اطلاعات بیشتر' ?>
                            </a>
                        </div>
                        <?
                    }
                    ?>	

                </li>
                <?
            }
            ?>
        </ul>
    </div>
</section>
<script>	
    jQuery(document).ready(function() {		
        jQuery("#revolution-slider").revolution({
            delay:8000,
            startwidth:1280,
            startheight:550,
            hideThumbs:10,
            fullWidth:"on",
            fullScreen:"off",
            fullScreenOffsetContainer: "",
            touchenabled:"on",
            navigationType:"none",
            dottedOverlay:""	
        });		
    });	
</script>