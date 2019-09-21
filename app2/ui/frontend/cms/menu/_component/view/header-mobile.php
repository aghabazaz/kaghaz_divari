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
    $param.='<li>
            <a href="' . $link . '"><i class="fa ' . $data[ 'data' ][ 'icon' ] . '"></i>' . $data[ 'data' ][ 'title' ]  ;

    if ( count ( $data[ 'child' ] ) )
    {
        $param.='<i class="fa fa-angle-down" id="arrow"></i>';
    }
    $param.= '</a>';
    if ( count ( $data[ 'child' ] ) )
    {


        $param.="
                <ul>
            " ;
        foreach ( $data[ 'child' ] AS $val2 )
        {
            if ( $val2[ 'data' ][ 'icon' ] )
            {
                $icon = '<i class="fa ' . $val2[ 'data' ][ 'icon' ] . '"></i>' ;
            }
            else
            {
                $icon = '<i class="fa fa-caret-left"></i>' ;
            }
            //namayesh sub menu haaa
            $param.="
                        <li>
                        " ;
            if ( $val2[ 'data' ][ 'link' ] )
            {
                $param.="
                                 $icon<a href='" . $val2[ 'data' ][ 'link' ] . "' >"   . $val2[ 'data' ][ 'title' ] . "</a>
                        " ;
            }
            else
            {
                $param.="
                               $icon  <a href='" . \f\ifm::app ()->siteUrl . 'menuDetail/' . $val2[ 'data' ][ 'id' ] . "' >"  . $val2[ 'data' ][ 'title' ] . "</a>
                        " ;
            }
            if ( count ( $val2[ 'child' ] ) )
            {


                $param.="
                <ul>
            " ;

                foreach ( $val2[ 'child' ] AS $val3 )
                {
                    if ( $val3[ 'data' ][ 'icon' ] )
                    {
                        $icon = '<i class="fa ' . $val3[ 'data' ][ 'icon' ] . '"></i>' ;
                    }
                    else
                    {

                    }
                    //namayesh sub menu haaa
                    $param.="
                        <li>
                        " ;
                    if ( $val3[ 'data' ][ 'link' ] )
                    {
                        $param.="
                                $icon <a href='" . $val3[ 'data' ][ 'link' ] . "'  >"   . $val3[ 'data' ][ 'title' ] . "</a>
                        " ;
                    }
                    else
                    {
                        $param.="
                                 $icon<a href='" . \f\ifm::app ()->siteUrl . 'menuDetail/' . $val3[ 'data' ][ 'id' ] . "' >"  . $val3[ 'data' ][ 'title' ] . "</a>
                        " ;
                    }
                    if ( count ( $val3[ 'child' ] ) )
                    {


                        $param.="
                <ul >
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
                                $icon  <a href='" . $val4[ 'data' ][ 'link' ] . "' >" . $val4[ 'data' ][ 'title' ] . "</a>
                        " ;
                            }
                            else
                            {
                                $param.="
                                $icon<a href='" . \f\ifm::app ()->siteUrl . 'menuDetail/' . $val4[ 'data' ][ 'id' ] . "' >" .  $val4[ 'data' ][ 'title' ] . "</a>
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
        $param.='</ul>';
    }
}
$param.='</ul>';

echo $param ;
?>
