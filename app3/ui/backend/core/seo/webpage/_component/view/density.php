<?php

function checkStatus ( $status )
{
    if ( $status == 'yes' )
    {
        return '<i class="fa fa-check" style="color:#5DB95D"></i>' ;
    }
    else
    {
        return '<i class="fa fa-times" style="color:#DD6460"></i>' ;
    }
}
?>
<div class="row">
    <div class="col-md-12">
        <div class="project-section general-info">
            <h4>
                <i class="fa fa-tachometer"></i> 
                چگالی کلمات
            </h4>
            <div class="alert alert-info">
                <i class="fa fa-info-circle"></i> این جدول کلمات با بیشترین تکرار در صفحه و همچنین استفاده یا عدم استفاده از آن کلمه در تگ عنوان ، متاتگ توضیحات و سرفصل های صفحه را نشان می دهد .
            </div>
            <?php
            if ( ! empty ( $words ) )
            {
                ?>
                <table class="table ">
                    <thead>
                        <tr style="background: #ddd;" >
                            <td width="45%">عنوان کلمه</td>
                            <td  width="10%">تکرار</td>
                            <td  width="15%">TITLE</td>
                            <td  width="15%">DESCRIPTION</td>
                            <td  width="15%">HEADING</td>
                        </tr> 
                    </thead>
                    <?php
                    $i = 1 ;
                    foreach ( $words AS $data )
                    {
                        echo '<tr style="background: #fff">
                    <td >' . $data[ 'word' ] . '</td>
                    <td >' . $data[ 'num_repeat' ] . '</td>
                    <td >' . checkStatus( $data[ 'title' ] ) . '</td>
                    <td >' . checkStatus($data[ 'description' ]) . '</td>
                    <td >' . checkStatus($data[ 'heading' ]) . '</td>
                    
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
