<div class="top_header_right">
    <?php
    $param = '' ;
    if ( $row[ 'twitter' ] )
    {
        $param .= "
        <a class='twitter' href='" . $row[ 'twitter' ] . "' target='_blank'><i class='fa fa-twitter '></i></a> 
    " ;
    }
    if ( $row[ 'Facebook' ] )
    {
        $param .= "
        <a class='facebook' href='" . $row[ 'Facebook' ] . "' target='_blank'><i class='fa fa-facebook'></i></a> 
    " ;
    }
    if ( $row[ 'Google' ] )
    {
        $param .= "
        <a class='googleplus' href='" . $row[ 'Google' ] . "' target='_blank'><i class='fa fa-google-plus '></i></a> 
    " ;
    }
    if ( $row[ 'Instagram' ] )
    {
        $param .= "
        <a class='instagram' href='" . $row[ 'Instagram' ] . "' target='_blank'><i class='fa fa-instagram '></i></a> 
    " ;
    }
    if ( $row[ 'Telegram' ] )
    {
        $param .= "
        <a class='telegram' href='" . $row[ 'Telegram' ] . "' target='_blank'><i class='fa fa-send '></i></a> 
    " ;
    }
    if ( $row[ 'LinkedIn' ] )
    {
        $param .= "
        <a class='linkedin' href='" . $row[ 'LinkedIn' ] . "' target='_blank'><i class='fa fa-linkedin'></i></a> 
    " ;
    }


    echo $param ;
    ?>

 
</div>

<div class="top_header_left">
    <div class="text-left" style="direction: ltr">

        <div class="top_header_left_sec2 " >
            <i class="fa fa-phone-square"></i> <span class="fa-digit"><?= $row[ 'phone' ] ?></span>
        </div>
        <div class="top_header_left_sec1">
            <i class="fa fa-envelope"></i> <?= $row[ 'email' ] ?>


        </div>
    </div>
</div>
<div class="clearfix"></div>


