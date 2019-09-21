<section class="page-title">
    <div class="grid-row clearfix">
        <h1>بازگشت از بانک</h1>

    </div>
</section>

<main class="page-content" style="min-height: 343px">
    <div class="grid-row">
        <section >

            <div style="direction: rtl">
                <div class="col-sm-12 col-md-6" style="margin:30px auto">
                    <?php
                    if ( $status == 'pay' )
                    {
                        ?>
                        <div class="alert alert-success">
                            <i class="fa fa-check-circle fa-2x"></i> <?= \f\ifm::t ( $status ) ?>

                            <? echo \f\ifm::t ( 'refId').' : '.$refId?>
                        </div>
                        <?
                        }
                        else
                        {
                        ?>
                        <div class="alert alert-danger">
                            <i class="fa fa-warning fa-2x"></i> <?= \f\ifm::t ( $status ) ?>
                    </div>
                    <?
                    }
                    ?>
                </div>
            </div>
        </section>
    </div>

</main>
