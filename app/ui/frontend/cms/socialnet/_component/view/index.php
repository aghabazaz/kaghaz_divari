<div class="teaser_content media">
    <div class="" style="width:100%;text-align:center;direction: rtl">

        <h3 style="font-size:22px;color:#FFF">
            <i class="fa fa-phone-square"></i> اطلاعات تماس
        </h3>
        <!-- testimonials indicators -->

    </div>

    <section class="widget-alt location">


        <address style="color:#fff;padding-top: 20px">
            <?=$row['address']?>
        </address>
        <ul>
            <li>
                <i class="fa fa-phone"></i>
                <?=$row['phone']?>
            
            </li>
            <li>
                <i class="fa fa-at"></i>
                <?=$row['email']?>
            
            </li>

        </ul>
        <nav>
            <?php
            
            
            $param = '' ;
            if ( $row[ 'twitter' ] )
            {
                $param.="
        <a class='fa fa-twitter' href='" . $row[ 'twitter' ] . "' target='_blank'></a> 
    " ;
            }
            if ( $row[ 'Facebook' ] )
            {
                $param.="
        <a class='fa fa-facebook' href='" . $row[ 'Facebook' ] . "' target='_blank'></a> 
    " ;
            }
            if ( $row[ 'Google' ] )
            {
                $param.="
        <a class='fa fa-google-plus' href='" . $row[ 'Google' ] . "' target='_blank'></a> 
    " ;
            }
            if ( $row[ 'Instagram' ] )
            {
                $param.="
        <a class='fa fa-instagram' href='" . $row[ 'Instagram' ] . "' target='_blank'></a> 
    " ;
            }
            if ( $row[ 'Telegram' ] )
            {
                $param.="
        <a class='fa fa-paper-plane-o' href='" . $row[ 'Telegram' ] . "' target='_blank'></a> 
    " ;
            }
            if ( $row[ 'LinkedIn' ] )
            {
                $param.="
        <a class='fa fa-linkedin' href='" . $row[ 'LinkedIn' ] . "' target='_blank'></a> 
    " ;
            }


            echo $param ;
            ?>


        </nav>
    </section>
</div>



