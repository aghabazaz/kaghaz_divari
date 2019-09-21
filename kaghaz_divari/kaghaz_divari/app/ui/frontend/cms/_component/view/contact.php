<section class="breadcrumbs white-block">
    <div class="container">
        <div class="clearfix">
            <div class="pull-right">
                <ul class="list-unstyled list-inline breadcrumbs-list" style="padding-right:0px">
                    <li>
                        <a href="<?= \f\ifm::app ()->siteUrl ?>"><i class="fa fa-home"></i> <?= 'خانه' ?></a>
                    </li>


                    <li>تماس با ما</li>
                </ul>			
            </div>
            <div class="pull-right">
            </div>
        </div>
    </div>
</section>
<section>
    <div class="container" style="min-height: 600px">
        <div class="row" >
            <div class="widget white-block">
                <div class="blog-title" style="font-size: 18px;border-bottom: 1px solid #eee;padding-bottom: 15px;margin-bottom: 10px">
                    <div class="pull-right">
                        <i class="fa fa-phone-square"></i> <?= 'تماس با ما' ?>
                    </div>

                    <div class="clearfix"></div>

                </div>
                <br>
                </br>
                <form method="post" action="<?= \f\ifm::app ()->siteUrl ?>api/cms/contact/contactSave" class="clearfix" id="contact-form" novalidate="novalidate">

                    <div class="form-group has-feedback">
                        <label for="name">نام شما : </label>
                        <input type="text" name="name" id="contact_name" class="form-control">
                    </div>
                    <div class="form-group has-feedback">
                        <label for="email">پست الکترونیکی</label>
                        <input type="email" name="email" id="contact_email" class="form-control">
                    </div>
                    <div class="form-group has-feedback">
                        <label for="contact_message">پیشنهاد یا انتقاد :</label>
                        <textarea name="message" id="contact_message" class="form-control" cols="100" rows="6" placeholder=""></textarea>															
                    </div>


                    <p class="form-submit">

                        <input type="submit" value="ثبت دیدگاه شما" class="submit" id="submit-contact" name="submit">
                    <div id="response" style=" direction: rtl;">

                    </div>

                    </p>				
                </form>
                
            </div>
        </div>
</section>
