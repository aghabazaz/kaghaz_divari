<!doctype html>
<html>
    <head>
        <?php
        include_once __DIR__ . \f\DS . 'parts' . \f\DS . 'head.php' ;
        ?>
    </head>

    <body >
        <div class="wrapper" >

            <?php
            if ( ! isset($legacyPanel) )
            {
                include_once __DIR__ . \f\DS . 'parts' . \f\DS . 'header.php' ;
            }
            ?>
            <div class="bottom">
                <div class="container">
                    <div class="row">
                        <?php
                        include_once __DIR__ . \f\DS . 'parts' . \f\DS . 'sidebar.php' ;
                        ?>
                        <div class="col-md-10 content-wrapper">
                            <div class="row">
                                <?php
                                if ( isset($breadcrumb) && ! empty($breadcrumb) )
                                {
                                    include __DIR__ . \f\DS . 'parts' . \f\DS . 'breadcrumb.php' ;
                                }
                                ?>
                                <?php
                                if ( isset($content) && ! empty($content) )
                                {
                                    ?>
                                    <div id="content">
                                        <?= $content ; ?>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>


                    </div>
                </div>
                <div class="push-sticky-footer"></div>
            </div>
            <footer class="footer" >

                <div style="width:90%;margin: 0px auto">
				<!---
                    <div class="col-md-10" style="text-align: right">
                        <a href="">درباره ما</a>
                        <a href="">قوانین و مقررات</a>
                        <a href="">پرسش های متداول</a>
                        <a href="">پشتیبانی آنلاین</a>
                        <a href="">راهنما</a>
                    </div> 
				
                    <div class="col-md-2" style="font:12px Tahoma">
                       Admin Panel © <?= date('Y') ?>
                    </div> 
					-->	
                </div>

            </footer>


        </div>


    </body>
</html>