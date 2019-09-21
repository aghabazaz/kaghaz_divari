<?php
if ( ! empty ( $row ) )
{
    ?>
    <div class="widget-title" style="margin-top: 30px"><?= 'آگهی ها' ?></div>
    <section class="services" style="direction: rtl;border-top: 1px solid #eee;padding-top:10px">
        <ul>
            <?php
            foreach ( $row AS $data )
            {
                ?>
                <li>
                    <a href="<?= \f\ifm::app ()->siteUrl. 'advertDetail/' . $data[ 'id' ] ?>" class="pic">
                        <img src="<?= \f\ifm::app ()->fileBaseUrl.$data['picture'] ?>" style="width:90px;height:90px">
                    </a>
                    <h2><a href="<?= \f\ifm::app ()->siteUrl. 'advertDetail/' . $data[ 'id' ] ?>" ><?=$data['title']?></a></h2>
                    <p>
                        <?php
                        //=substr($data['content'], 0, 100).'...';
                        $arr=explode(" ", $data['content']);
                        echo implode(array_slice($arr, 0, 25),' ').'...';
                        ?>                        
                    </p>
                    <a href="<?= \f\ifm::app ()->siteUrl. 'advertDetail/' . $data[ 'id' ] ?>" class="more fa fa-long-arrow-left"></a>
                </li>
                <?php
            }
            ?>
        </ul>
    </section>
    <?php
}
else
{
    echo '&nbsp;' ;
}
?>
