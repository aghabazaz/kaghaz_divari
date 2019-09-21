
<?php
$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]" ;


$param.="
       <ul>
    " ;


foreach ( $row AS $data )
{

    if ( $data[ 'data' ][ 'link' ] )
    {
        $link = $data[ 'data' ][ 'link' ] . '/' ;
    }
    else
    {
        $link = \f\ifm::app ()->siteUrl . 'menuDetail/' . $data[ 'data' ][ 'id' ] ;
    }
    $arr  = explode ( "/", $actual_link ) ;
    $arr2 = explode ( "/", $link ) ;
    if ( ($arr[ '3' ] == $arr2[ '3' ] ) )
    {
        $class = "class='active'" ;
    }
    else
    {
        $class = '' ;
    }
    //namayesh menu asli

    $param.='<li>
            <a href="' . $link . '" ' . $class . '><i class="fa ' . $data[ 'data' ][ 'icon' ] . '"></i>' . $data[ 'data' ][ 'title' ] . '</a>' ;
    if ( count ( $data[ 'child' ] ) )
    {


        $param.="
                <ul class='title-main-menu'>
            " ;
        foreach ( $data[ 'child' ] AS $val2 )
        {

            if ( $val2[ 'data' ][ 'icon' ] )
            {
                $icon = '<i class="fa ' . $val2[ 'data' ][ 'icon' ] . '"></i>' ;
            }
            else
            {
                $icon = '<i class="fa fa-square"></i>' ;
            }
            //namayesh sub menu haaa
            $param.="
                        <li>
                        " ;
            if ( $val2[ 'data' ][ 'link' ] )
            {
                $param.="
                                <a href='" . $val2[ 'data' ][ 'link' ] . "'  >" . $icon . ' ' . $val2[ 'data' ][ 'title' ] . "</a>
                        " ;
            }
            else
            {
                $param.="
                                <a href='" . \f\ifm::app ()->siteUrl . 'menuDetail/' . $val2[ 'data' ][ 'id' ] . "' target='_blank'>" . $icon . ' ' . $val2[ 'data' ][ 'title' ] . "</a>
                        " ;
            }
            if ( count ( $val2[ 'child' ] ) )
            {


                $param.="
                <ul class='intro' style='background-image:url(" . \f\ifm::app ()->fileBaseUrl . $val2[ 'data' ][ 'picture' ] . ")'>
            " ;

                foreach ( $val2[ 'child' ] AS $val3 )
                {
                    if ( $val3[ 'data' ][ 'icon' ] )
                    {
                        $icon = '<i class="fa ' . $val3[ 'data' ][ 'icon' ] . '"></i>' ;
                    }
                    else
                    {
                        $icon = '<i class="fa fa-dot-circle-o"></i>' ;
                    }
                    //namayesh sub menu haaa
                    $param.="
                        <li>
                        " ;
                    if ( $val3[ 'data' ][ 'link' ] )
                    {
                        $param.="
                                <a href='" . $val3[ 'data' ][ 'link' ] . "'  >" . $icon . ' ' . $val3[ 'data' ][ 'title' ] . "</a>
                        " ;
                    }
                    else
                    {
                        $param.="
                                <a href='" . \f\ifm::app ()->siteUrl . 'menuDetail/' . $val3[ 'data' ][ 'id' ] . "' target='_blank'>" . $icon . ' ' . $val3[ 'data' ][ 'title' ] . "</a>
                        " ;
                    }
                    if ( count ( $val3[ 'child' ] ) )
                    {


                        $param.="
                <ul class='intro_in'>
            " ;

                        foreach ( $val3[ 'child' ] AS $val4 )
                        {
                            $icon='';
                            //namayesh sub menu haaa
                            $param.="
                        <li class='col-sm-6'>
                        " ;
                            if ( $val4[ 'data' ][ 'link' ] )
                            {
                                $param.="
                                <a href='" . $val4[ 'data' ][ 'link' ] . "' >" . $icon . ' ' . $val4[ 'data' ][ 'title' ] . "</a>
                        " ;
                            }
                            else
                            {
                                $param.="
                                <a href='" . \f\ifm::app ()->siteUrl . 'menuDetail/' . $val4[ 'data' ][ 'id' ] . "' target='_blank'>" . $icon . ' ' . $val4[ 'data' ][ 'title' ] . "</a>
                        " ;
                            }

                            $param.="
                        </li>
                    " ;
                        }
                        $param.="
               </ul>
            " ;
                    }

                    $param.="
                        </li>
                    " ;
                }
                $param.="
               </ul>
            " ;
            }

            $param.="
                        </li>
                    " ;
        }
        $param.="
               </ul>
            " ;
    }
    $param.="
            </li>
        " ;
}
$param.="
            </ul>
        " ;
?>
<nav class="main-nav">
    <?php echo $param ; ?>
</nav>
<!--
<nav id="mobile-main-nav" class="mobile-main-nav">
    <i class="fa fa-bars"></i><a href="index.html#" class="opener"><?= 'منوی سایت' ?></a>
        <?php echo $param ; ?>
</nav>
-->
<style>
.intro_in {
    height:100%;
}
ul.title-main-menu li a {
    color: #f22e2e;
}
ul.intro li a:hover {
    color: #0089ff !important;
}.main-nav li li li a {
    padding: 6px 20px !important;
}

</style>

