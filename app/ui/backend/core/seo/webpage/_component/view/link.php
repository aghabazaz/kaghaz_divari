<div class="row">
    <div class="col-md-12">
        <div class="project-section general-info">
             <h4>
                 <i class="fa fa-link"></i> 
                 لینک  ها
            </h4>
           
            <?php
            if ( count( $link )<=200 )
            {
                echo '<div class="alert alert-success"><i class="fa fa-check-circle"></i> تعداد لینک های صفحه برابر با '.count( $link ).' لینک می باشد که از نظر موتورهای جستجو قابل قبول است.</div>' ;
            }
            else
            {
                echo '<div class="alert alert-danger"><i class="fa fa-times-circle"></i> تعداد لینک های هر صفحه بهتر است از 200 عدد کمتر باشد تا از نظر موتورهای جستجو به عنوان اسپمر شناخته نشود.</div>' ;
            }
            ?>
            <?php
            if ( ! empty ( $link ) )
            {
            ?>
            <table class="table ">
                <thead>
                    <tr style="background: #ddd;" >
                        <td width="10%">ردیف</td>
                        <td  width="75%">عنوان لینک</td>
                        <td  width="15%">نوع لینک</td>
                    </tr> 
                </thead>
                <?php
                $i=1;
                foreach ( $link AS $data )
                {
                    echo '<tr style="background: #fff">
                    <td >'.$i.'</td>
                    <td><a href="'.$data['link_address'].'">'.($data['link_title']?$data['link_title']:'بدون عنوان').'</a></td>
                    <td>'.\f\ifm::t ($data['type']).'</td>
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
