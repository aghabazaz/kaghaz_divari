<?php
$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]" ;


$param.="
       <ul>
    " ;

//\f\pr($row);
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
            <a href="' . $link . '" ' . $class . '>' . $data[ 'data' ][ 'title' ] . '</a>' ;
 
    $param.="
            </li>
        " ;
}
$param.="
            </ul>
        " ;

echo $param ;
?>



