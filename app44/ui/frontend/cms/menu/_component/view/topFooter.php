<ul class="footer-nav">
   
<?php
//\f\pre($row);
foreach ( $row AS $data )
{
    if($data[ 'data' ][ 'link' ])
    {
        $link=$data[ 'data' ][ 'link' ].'/';
    }
    else
    {
        $link=\f\ifm::app ()->siteUrl . 'menuDetail/' . $data[ 'data' ][ 'id' ];
    }
    
    //namayesh menu asli
    $param.='<div class="col-md-2 col-sm-6 col-xs-12" style="text-align:center"><div class="title-text-serise">
            <span class="title-footer">'.$data['data']['title'].'</span></div>';
    if ( count ( $data[ 'child' ] ) )
    {
       $param.='<div class="seris-text"><ul class="footer-series">';
       foreach ( $data[ 'child' ] AS $val2 )
        {
            //namayesh sub menu haaa
                if ( $val2[ 'data' ][ 'type' ] == 'link' )
                {
                    if ( $val2[ 'data' ][ 'link' ] )
                    {
                        $param.="
                                    <li><a href='" . $val2[ 'data' ][ 'link' ] . "' target='_blank' >" . $val2[ 'data' ][ 'title' ] . "</a></li>
                            " ;
                    }
                    else
                    {
                        $param.="
                                    <li><a href='" . \f\ifm::app ()->siteUrl . 'menuDetail/' . $val2[ 'data' ][ 'id' ] . "' target='_blank'>". $val2[ 'data' ][ 'title' ] . "</a></li>
                            " ;
                    }
                }
                else
                {
                    $param.="
                        <li><a href='" . \f\ifm::app ()->siteUrl . 'menuDetail/' . $val2[ 'data' ][ 'id' ] . "' target='_blank'>". $val2[ 'data' ][ 'title' ] . "</a></li>
                            
                            " ;
                }   
        }
       $param.='</ul>
            </div>';
    }
    $param.='</div>';
}

echo $param;
?>
</ul>