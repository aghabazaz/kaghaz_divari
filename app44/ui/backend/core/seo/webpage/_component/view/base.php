
<div class="row">
    <div class="col-md-7">
        <div class="project-section general-info">
            <h4>
                تگ عنوان صفحه
            </h4>
            <div class="seo">
                <?php
                if ( mb_strlen ( $row[ 'title' ] ) <= 70 && mb_strlen ( $row[ 'title' ] ) > 0 )
                {
                    echo '<i class="fa fa-check-circle" style="color:#27AE60;font-size: 20px;display: inline-block;vertical-align: top"></i>' ;
                }
                else
                {
                    echo '<i class="fa fa-times-circle" style="color:#E74C3C;font-size: 20px;display: inline-block;vertical-align: top"></i>' ;
                }
                ?> 
                <div class="box-seo">
                    <div class="content"><?= $row[ 'title' ] ? $row[ 'title' ] : 'N/A' ?></div>
                    <?php
                    if ( mb_strlen ( $row[ 'title' ] ) > 0 )
                    {
                        ?>
                        <div class="comment">طول : <?= mb_strlen ( $row[ 'title' ] ) ?> حرف</div>
                        <?php
                    }
                    ?>

                </div>
            </div>

            <h4>
                متاتگ توضیحات
            </h4>
            <div class="seo">
                <?php
                if ( mb_strlen ( $row[ 'description' ] ) <= 150 && mb_strlen ( $row[ 'description' ] ) > 0 )
                {
                    echo '<i class="fa fa-check-circle" style="color:#27AE60;font-size: 20px;display: inline-block;vertical-align: top"></i>' ;
                }
                else
                {
                    echo '<i class="fa fa-times-circle" style="color:#E74C3C;font-size: 20px;display: inline-block;vertical-align: top"></i>' ;
                }
                ?> 
                <div class="box-seo">
                    <div class="content"><?= $row[ 'description' ] ? $row[ 'description' ] : 'N/A' ?></div>
                    <?php
                    if ( mb_strlen ( $row[ 'description' ] ) > 0 )
                    {
                        ?>
                        <div class="comment">طول : <?= mb_strlen ( $row[ 'description' ] ) ?> حرف</div>
                        <?php
                    }
                    ?>
                </div>
            </div>
            <h4>
                کلمات کلیدی
            </h4>
            <div class="seo">
                <?php
                $countWords = $this->strG->utf8_str_word_count ( $row[ 'keywords' ],
                                                                 0 ) ;
                //\f\pr($countWords);
                if ( $countWords <= 10 && $countWords > 0 )
                {
                    echo '<i class="fa fa-check-circle" style="color:#27AE60;font-size: 20px;display: inline-block;vertical-align: top"></i>' ;
                }
                else
                {
                    echo '<i class="fa fa-times-circle" style="color:#E74C3C;font-size: 20px;display: inline-block;vertical-align: top"></i>' ;
                }
                ?> 
                <div class="box-seo">
                    <div class="content"><?= $row[ 'keywords' ] ? $row[ 'keywords' ] : 'N/A' ?></div>
                    <?php
                    if ( $countWords > 0 )
                    {
                        ?>
                        <div class="comment">طول : <?= $countWords ?> کلمه</div>
                        <?php
                    }
                    ?>
                </div>
            </div>
           
        </div>
    </div>
    <div class="col-md-5">
        <?php
        echo $this->boxW->begin ( array (
            'type'   => 'chart',
            'title'  => \f\ifm::t ( 'report' ),
            'focus'  => '1',
            'expand' => 1,
            'remove' => 1 ) ) ;
        ?>
        <div class="report_row">
            <div class="report_col">تعداد بازدید</div>
            <div class="report_col" style="color: gray"><?php echo $row['num_visit'] . ' بازدید' ?>  </div>
            <div class="clear"></div>
        </div>
        <div class="report_row">
            <div class="report_col">نسبت متن به کد</div>
            <div class="report_col" style="color: gray">
                <?php
                if($row['size_page'])
                {
                    echo number_format(($row['size_text']/$row['size_page'])*100,2).' %' ;
                }
                else
                {
                    echo 'N/A' ;
                }
                ?>
            </div>
            <div class="clear"></div>
        </div>
        <div class="report_row">
            <div class="report_col">حجم متن محتوا</div>
            <div class="report_col" style="color: gray">
                <?php
                if($row['size_text'])
                {
                    echo $row['size_text'].' بایت' ;
                }
                else
                {
                    echo 'N/A' ;
                }
                ?>
            </div>
            <div class="clear"></div>
        </div>
        <div class="report_row">
            <div class="report_col">کل حجم کد HTML</div>
            <div class="report_col" style="color: gray">
                <?php
                if($row['size_page'])
                {
                    echo $row['size_page'].' بایت' ;
                }
                else
                {
                    echo 'N/A' ;
                }
                ?>
            </div>
            <div class="clear"></div>
        </div>
        <div class="report_row">
            <div class="report_col">آخرین بازدید</div>
            <div class="report_col" style="color: gray">
                <?php
                echo $this->dateG->dateTime ( $row[ 'last_visit' ],
                                                              2 ) . ' ، ساعت : ' . date ( 'H:i',
                                                                                        $row[ 'last_visit' ] )
                ?>
                
            </div>
            <div class="clear"></div>
        </div>
        <div class="report_row">
            <div class="report_col">تاریخ بروزرسانی</div>
            <div class="report_col" style="color: gray">
                <?php
                if($row['date_update'])
                {
                    echo $this->dateG->dateTime ( $row[ 'date_update' ],
                                                              2 ) . ' ، ساعت : ' . date ( 'H:i',
                                                                                        $row[ 'date_update' ] );
                }
                else
                {
                    echo 'N/A' ;
                }
                
                ?>
                
            </div>
            <div class="clear"></div>
        </div>
        <?php
        echo $this->boxW->flush () ;
        ?>
    </div>

</div>

<style>
    .seo
    {
        background: #eaeaea;width:100%;padding: 10px;
        margin-bottom: 30px;
    }
    .box-seo
    {
        margin-right: 15px;
        display: inline-block;
    }
    .box-seo .comment
    {
        color:gray;
    }
    .report_row {
        border-bottom: 1px solid #eee;
        padding: 10px 0;
    }
    .report_col {
        float: right;
        width: 50%;
    }
</style>    