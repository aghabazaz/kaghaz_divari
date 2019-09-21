<?php
if(! empty($newProducts))
{
foreach ( $newProducts AS $data )
{
    ?>
    <div>
        <a  href="<?= \f\ifm::app ()->siteUrl.'productDetail/'.$data['id'].'/'.$data[ 'title' ]?>" title="<?=$data[ 'title' ]?>"><div style="height :150px">
                <img style="margin: 0 auto; max-height : 100%" class="img-responsive" src="<?= \f\ifm::app ()->fileBaseUrl . $data[ 'picture' ] ?>" title="<?=$data[ 'title' ]?>" alt=" <?php echo $data[ 'title' ] ?>" >
            </div>
        <h5 class="entitle"><?php echo $data[ 'title' ] ; ?></h5></a>
        <?php
        if ( $data[ 'discount' ] )
        {
            ?>
            <h4 class="old-price"><?php echo number_format ( $data[ 'price' ] ) ; ?></h4>
            <?php
        }
        else
        {
            ?>
            <h4 style="height:10px;"></h4>
            <?php
        }
        ?>
        <?php
        if ( $data[ 'discount' ] )
        {
            ?>
            <span class="final-price"><?php echo number_format ( $data[ 'price' ] - $data[ 'discount' ] ) ; ?><span class="currency">تومان</span></span>  
            <?php
        }
        else
        {
            ?>
            <span class="final-price"><?php echo number_format ( $data[ 'price' ] ) ; ?><span class="currency">تومان</span></span>  
            <?php
        }
        ?>
    </div>
    <?php
}
}
else
{
    echo '<div style="direction:rtl;text-align:center;padding:10px">هیچ محصولی وجود ندارد</div>' ;
}
?>
