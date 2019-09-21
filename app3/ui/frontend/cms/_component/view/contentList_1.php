<?php
if ( ! empty ( $row ) )
{
    $this->registerGadgets ( array (
        'dateG' => 'date' ) ) ;
    foreach ( $row AS $data )
    {
        $picture = $data[ 'picture' ] ? $data[ 'picture' ] : 530 ;
        ?>
        <li>

            <img alt="" src="<?= \f\ifm::app ()->fileBaseUrl . $picture ?>">
            <p>
                <span >
                    <a href="<?= \f\ifm::app ()->siteUrl . 'contentDetail/' . $data[ 'id' ] ?>" target="_blank" style="margin:0px;padding: 0px;font-size:18px">
                        <?= $data[ 'title' ] ?>
                    </a>
                </span>
                <br>
                <?php
                $date    = $this->dateG->dateTime ( $data[ 'date_register' ], 1 ) ;
                echo $this->dateG->dateGrToJa ( $date, 2 ) . ' ، ' . date ( "H:i",
                                                                            $data[ 'date_register' ] ) ;
                ?>
            </p>
        </li>
        
        <?php
    }
}
else
{
    echo 'مطلبی در سایت وجود ندارد...!' ;
}
?>