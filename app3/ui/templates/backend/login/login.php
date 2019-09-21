<!doctype html>
<html>
    <head>
        <?php
        include_once __DIR__ . \f\DS . 'parts' . \f\DS . 'head.php' ;
        ?>

        <style>
            body{
                background-image: url('<?=  \f\ifm::app()->fileBaseUrl?>26');
                background-size: 100%;
                background-repeat: no-repeat;                
            }
        </style>
    </head>

    <body >

        <div class="wrapper full-page-wrapper page-login text-center" >
            <div class="inner-page" style="margin-top:7%">
                <?php
                if ( isset($content) && ! empty($content) )
                {
                    echo $content ;
                }
                ?>                
            </div>
            <div class="push-sticky-footer"></div>
        </div>

      

    </body>

</html>