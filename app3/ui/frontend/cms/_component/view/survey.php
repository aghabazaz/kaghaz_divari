<div class="teaser_content media">
    <div style="width:100%;text-align:center;direction: rtl">

        <h3 style="font-size:22px;color:#FFF">
            <i class="fa fa-bar-chart"></i> نظرسنجی
        </h3>


    </div>

    <div style="margin-top: 30px;direction: rtl;text-align: center;color: white" class="widget-doctors">
        <?php
        //\f\pr($row);
        if ( ! empty ( $row ) )
        {
            if ( $row[ 'typechoose' ] == 'one' )
            {
                $type = 'radio' ;
            }
            else
            {
                $type = 'checkbox' ;
            }
            ?>
            <form method="post" action="<?= \f\ifm::app ()->siteUrl ?>api/cms/survey/answerSurveySave" class="clearfix" id="contactform" novalidate="novalidate">

                <input type="hidden" name="poll_id" value="<?=$row['id']?>">
                <input type="hidden" name="user_id" value="<?=$userId?>">
                <input type="hidden" name="question_id" value="<?=$row['questionId']?>">
                <div style="text-align: right">
                    <div style="padding-bottom: 15px">
                        <i class="fa fa-question-circle"></i> <?= $row[ 'question' ] ?>
                    </div>
                    <div style="height:188px;">
                        <?php
                        foreach ( $choice AS $data )
                        {
                            ?>
                            <div style="padding-bottom: 10px;">
                                <input type="<?= $type ?>"  name="choice[]" value="<?= $data[ 'id' ] ?>" id="sur<?= $data[ 'id' ] ?>" style="display: inline-block;cursor: pointer"> 
                                <label for="sur<?= $data[ 'id' ] ?>" style="display: inline-block;cursor: pointer"><?= $data[ 'title' ] ?></label>
                            </div>

                            <?php
                        }
                        ?>
                    </div>
                    <div>
                        <button type="submit" class="wpb_button wpb_btn-alt wpb_regularsize" style="font-size: 13px;margin-bottom: 0px;float:right">ثبت پاسخ</button>
                    </div>
                </div>
            </form>
            <?php
        }
        else
        {
            echo 'در حال حاضر نظرسنجی فعالی در سایت وجود ندارد.' ;
        }
        ?>

    </div>
</div>