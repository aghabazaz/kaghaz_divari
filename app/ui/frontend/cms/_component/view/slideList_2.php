<div class="slider-wrapper">
    <section class="slider" id="slider">
        <?php
        $effect=array(
            array(
                'slide'=>'transition2d:9;slidedelay:7000;',
                'box'=>'offsetyin:top;offsetxin:0;durationin:2000;offsetyout:bottom;offsetxout:0;durationout:1000;'
            ),
            array(
                'slide'=>'transition2d:40;slidedelay:7000;',
                'box'=>'scalexin:0.3;scaleyin:0.3;rotatexin:180;offsetxin:0;durationin:2000;durationout:2000;scalexout:2;scaleyout:2;offsetxout:0;fadeout:true;showuntil:3000;'
            ),
            array(
                'slide'=>'transition2d:11;slidedelay:7000;',
                'box'=>'skewxin:30;skewyin:0;offsetxin:right;fadein:false;durationin:2000;durationout:1000;offsetxout:right;offsetyout:0;fadeout:true;'
            ),
        );
        $i=0;
        foreach ( $row AS $data )
        {
            ?>
            <div class="ls-slide" data-ls="<?=$effect[$i%3]['slide']?>">					
                <img src="<?= \f\ifm::app ()->fileBaseUrl.$data['picture'] ?>" alt="" class="ls-bg">

                <div class="intro ls-l" data-ls="<?=$effect[$i%3]['box']?>" style="left:80%;top:35%;">
                    <span class="icon fa <?=$data['icon']?>"></span>
                    <h2><span><?=$data['top_title']?></span><?=$data['title']?></h2>
                    <p><?=$data['comment']?></p>
                    <div class="buttons">
                        <a href="javascript:void(0)" class="prev"><i class="fa fa-angle-left"></i></a>
                        <!--
                        --><a href="<?=$data['link']?>" class="button"><?='اطلاعات بیشتر'?></a><!--
                        --><a href="javascript:void(0)" class="next"><i class="fa fa-angle-right"></i></a>
                    </div>
                </div>
            </div>
            <?php
            $i++;
        }
        ?>

        
    </section>
</div>