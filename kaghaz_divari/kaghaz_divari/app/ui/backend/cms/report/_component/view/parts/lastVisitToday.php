<?
echo $boxWidget->begin ( array (
    'type'   => 'form',
    'title'  => \f\ifm::t ( 'lastVisitToday' ) . ' ' . $this->dateG->todayDate (),
    'focus'  => '1',
    'expand' => 1,
    'remove' => 1 ) ) ;
?>
<div class="content" style="font-size: 13px">
    <div class="report_row">
        <div class="title_tbl report_col1"><?= \f\ifm::t ( 'countryIP' ) ?></div>
        <div class=" title_tbl report_col2"><?= \f\ifm::t ( 'clock' ) ?></div>
        <div class=" title_tbl report_col2"><?= \f\ifm::t ( 'feature' ) ?></div>
        <div class="clear"></div>
    </div>
<?php
$i = 1 ;
foreach ( $visitDay AS $data )
{
    $i ++ ;
    ?>
        <div class="report_row " style="color:gray;<? if ( $i % 2 == 0 ) echo 'background:#F7F9FF' ?>">

            <div class="report_col1 ">
                <div class="flag flag-<?php echo strtolower ( $data[ 'country' ] ) ?> " title="<?php echo $data[ 'country' ] ?>" <? if ( $data[ 'country' ] == 'Unkown' )
    { ?>style=background-color:blue<? } ?>></div>  
                <div class="right">  <?php echo $data[ 'ip' ] ?></div>

            </div>
            <div class="title_tbl report_col2"><?php echo $data[ 'time' ] ?></div>
            <div class="title_tbl report_col2">
                <div style="width:68px;margin:0px auto">
                    
                
    <?php
    if ( $data[ 'browserName' ] != 'IE' )
    {
        ?>
                    <div class="browser <?php echo $data[ 'browserName' ] ?>" title="<?php echo $data[ 'browserName' ] . ' ' . $data[ 'browserVersion' ] ; ?>" > </div> 

        <?php
    }
    else
    {
        if ( $data[ 'browserVersion' ] < 8 )
        {
            $v = 6 ;
        }
        else
        {
            $v = 8 ;
        }
        ?>
                    <div class="browser <?php echo $data[ 'browserName' ] . $v ?>" title="<?php echo $data[ 'browserName' ] . ' ' . $data[ 'browserVersion' ] ; ?>" > </div> 

                    <?php
                }
                if ( $data[ 'osName' ] != 'windows' )
                {
                    ?>
                    <div class="os <?php echo $data[ 'osName' ] ?>" title="<?php echo $data[ 'osVersion' ] ?>"></div>                             

                    <?php
                }
                else
                {
                    if ( $data[ 'osVersion' ] == 'Windows Vista' || $data[ 'osVersion' ] == 'Windows 7' || $data[ 'osVersion' ] == 'Windows 8' )
                    {
                        $v = '-7' ;
                    }
                    else if($data[ 'osVersion' ] == 'Windows 10')
                    {
                        $v='-10';
                    }
                    else
                    {
                        $v = '-xp' ;
                    }
                    ?>
                    <div class="os <?php echo $data[ 'osName' ] . $v ?>" title="<?php echo $data[ 'osVersion' ] ?>"></div>                             

                    <?php
                }
                ?>
                </div>    

            </div>
            <div class="clear"></div>
            <div style="padding:10px 12px 0px 0px;color:#444">
    <?=  \f\ifm::t ( 'backlink' )?> : 
    <?
    if ( $data[ 'backlink' ] == '' || $data[ 'backlink' ] == '--' ) echo '--' ;
    else
    {
        preg_match ( '#^(?:http://|https://)?([^/]+)#i', $data[ 'backlink' ],
                     $siteName ) ;
        $domain = str_replace ( 'www.', '', $siteName[ 1 ] ) ;
        ?>
                    <a href="<?= $data[ 'backlink' ] ?>" target="_blank"><?= $domain ?></a>
                    <?
                }
                ?>
            </div>
        </div>


    <?php
}
?>



</div>
    <?
    echo $boxWidget->flush () ;
    ?>