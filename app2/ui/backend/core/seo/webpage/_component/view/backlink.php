<div class="row">
    <div class="col-md-12">
        <div class="project-section general-info">
            <h4>
                <i class="fa fa-sign-in"></i> 
                پیوندها
            </h4>
            <div class="alert alert-info">
                <i class="fa fa-info-circle"></i> این جدول آدرس صفحاتی از سایت یا سایت های دیگر که این صفحه را لینک کرده اند نشان می دهد.
            </div>

            <?php
            if ( ! empty ( $backlink ) )
            {
                ?>
                <table class="table ">
                    <thead>
                        <tr style="background: #ddd;" >
                            <td width="5%">ردیف</td>
                            <td  width="40%">لینک</td>
                            <td  width="15%">نوع پیوند</td>
                            <td  width="15%">تعداد بازدید</td>
                            <td  width="25%">آخرین بازدید</td>
                        </tr> 
                    </thead>
                    <?php
                    $i = 1 ;
                    foreach ( $backlink AS $data )
                    {
                        if ( strpos ($data[ 'link' ], \f\ifm::app ()->siteUrl ) === FALSE )
                        {
                            $type = 'external' ;
                        }
                        else
                        {
                            $type = 'internal' ;
                        }
                        echo '<tr style="background: #fff">
                    <td>' . $i . '</td>
                    <td><a href="' . $data[ 'link' ] . '">' . $data[ 'link' ] . '</a></td>
                    <td>' . \f\ifm::t ($type) . '</td>
                    <td>' . $data[ 'num_visit' ] . '</td>
                    <td>' . $this->dateG->dateTime ( $data[ 'last_visit' ], 2 ) . ' ، ساعت : ' . date ( 'H:i',
                                                                                                         $data[ 'last_visit' ] ) . '</td>
                </tr>' ;
                        $i ++ ;
                    }
                    ?>


                </table> 
                <?php
            }
            ?>
        </div>
    </div>
</div>
