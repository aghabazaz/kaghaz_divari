<?
echo $boxWidget->begin ( array (
    'type'   => 'form',
    'title'  => \f\ifm::t ( 'alexa' ),
    'focus'  => '1',
    'expand' => 1,
    'remove' => 1 ) ) ;
?>
<div class="content" style="font-size: 13px">
    <div class="report_row">
        <div class="report_col" style=""><?= \f\ifm::t('domain') ?></div>
        <div class="report_col" style="color: gray;font:12px Arial"><?php echo $alexaToday[ 'domain' ] ; ?></div>
        <div class="clear"></div>
    </div>
    <div class="report_row"  >
        <div class="report_col" ><?= \f\ifm::t('iranRank') ?></div>
        <div class="report_col" style="color: gray;width:30%"><?php echo $alexaToday[ 'country' ]?$alexaToday[ 'country' ]:'---' ; ?></div>
        <div class="report_col" style="width:20%">
            <?
            if($alexaYesterday[ 'country' ]!=0)
            {
                $diffCountry = $alexaYesterday[ 'country' ] - $alexaToday[ 'country' ] ;
                if ( $diffCountry > 0 )
                {
                    ?>
                    <span class="desc"><?= $diffCountry ; ?></span>
                    <?
                }
                else if ( $diffCountry < 0 )
                {
                    ?>
                    <span class="asc"><?= (-$diffCountry) ; ?></span>
                    <?
                }
            }
            ?>

        </div>
        <div class="clear"></div>
    </div>
    <div class="report_row">
        <div class="report_col" style=""><?= \f\ifm::t('worldRank') ?></div>
        <div class="report_col" style="color: gray;width:30%"><?php echo $alexaToday[ 'world' ]?$alexaToday[ 'world' ]:'---' ; ?></div>
        <div class="report_col" style="width:20%">
            <?
            $diffWorld = $alexaYesterday[ 'world' ] - $alexaToday[ 'world' ] ;
            if ( $diffWorld > 0 )
            {
                ?>
                <span class="desc"><?= $diffWorld ; ?></span>
                <?
            }
            else if ( $diffWorld < 0 )
            {
                ?>
                <span class="asc"><?= (-$diffWorld) ; ?></span>
                <?
            }
            ?>
        </div>
        <div class="clear"></div>
    </div>
    <!--THIS IS A PLACEHOLDER FOR FLOT - Report & Graphs -->
</div>
<?
echo $boxWidget->flush () ;
?>