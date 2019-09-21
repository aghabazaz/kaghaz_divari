
<?php
foreach ( $heading AS $data )
{
    $numHeading[ $data[ 'type' ] ] ++ ;
}
?>
<div class="row">
    <div class="col-md-12">
        <div class="project-section general-info">
             <h4>
                 <i class="fa fa-code"></i> 
                تگ های heading
            </h4>
           
            <?php
            if ( ! empty ( $heading ) )
            {
                echo '<div class="alert alert-success"><i class="fa fa-check-circle"></i> بسیار عالی ،از تگ های عنوان  ( H1 تا H6 ) در این صفحه استفاده شده است.</div>' ;
            }
            else
            {
                echo '<div class="alert alert-danger"><i class="fa fa-times-circle"></i> از تگ های عنوان  ( H1 تا H6 ) استفاده نشده است.</div>' ;
            }
            ?>
            <table class="table  text-center">
                <thead>
                    <tr style="background: #ddd;text-align: center" >
                        <?php
                        for ( $i = 1 ; $i <= 6 ; $i ++ )
                        {
                            echo '<td style="font:bold 14px Times"> H' . $i . ' </td>' ;
                        }
                        ?>
                    </tr> 
                </thead>

                <tr style="background: #fff">
                    <?php
                    for ( $i = 1 ; $i <= 6 ; $i ++ )
                    {
                        echo '<td>' . ($numHeading[ 'h' . $i ] ? $numHeading[ 'h' . $i ] : 'N/A') . '</td>' ;
                    }
                    ?>
                </tr>
            </table>
            <?php
            if ( ! empty ( $heading ) )
            {
            ?>
            <table class="table ">
                <thead>
                    <tr style="background: #ddd;" >
                        <td width="10%">ردیف</td>
                        <td  width="75%">عنوان تگ</td>
                        <td  width="15%">نوع تگ</td>
                    </tr> 
                </thead>
                <?php
                $i=1;
                foreach ( $heading AS $data )
                {
                    echo '<tr style="background: #fff">
                    <td >'.$i.'</td>
                    <td>'.$data['text'].'</td>
                    <td style="font-family:Arial">'.strtoupper($data['type']).'</td>
                </tr>' ;
                    $i++;
                }
                ?>

                
            </table> 
            <?php
            }
            ?>
        </div>
    </div>
</div>
