<?php
$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]" ;
$param.="
<div class='header-menu-nav-inner'>
                    <div class='header-menu-nav'>
                        <div class='header-menu'>
       <ul class='header-nav smarket-nav'>

    " ;
//\f\pre($row);
foreach ( $row AS $data )
{
    if ( $data[ 'data' ][ 'link' ] )
    {
        $link = $data[ 'data' ][ 'link' ] . '/' ;
    }
    else
    {
        if($data['data']['type']=='page')
        {

            $link = \f\ifm::app ()->siteUrl . 'page/' . $data[ 'data' ][ 'page' ] ;
        }
        else
        {

            $link = \f\ifm::app ()->siteUrl . 'menuDetail/' . $data[ 'data' ][ 'id' ] ;

        }
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

    if ( count ( $data[ 'child' ] ) )
    {
        $itemmegamenu = 'item-megamenu ';
    }else{
        $itemmegamenu ='';
    }

    //namayesh menu asli
    $param.='<li class="menu-item-has-children '." $itemmegamenu ".' arrow">
            <a title="'.$data[ 'data' ][ 'title' ].'" href="' . $link . '" ' . $class . '>'
        . '<i class="fa ' . $data[ 'data' ][ 'icon' ] . '"></i>'
        . $data[ 'data' ][ 'title' ] . ''
        . '</a>' .'';
    if($itemmegamenu=='item-megamenu '){
        $param.='<span class="toggle-submenu hidden-mmobile"></span>';
    }


    if ( count ( $data[ 'child' ] ) )
    {
        $picture=\f\ttt::service('core.fileManager.loadFileUrl',[
            'fileId'=> $data[ 'data' ][ 'picture' ]
        ]);
        $title=$data[ 'data' ][ 'title' ];
        $param.="
                <div class='submenu dropdown-menu megamenu'>
                <div class='row'>
                <div class='submenu-banner submenu-banner-menu-1'>
                <img class='imgMenu' src='$picture' title='$title' alt='$title'/>
            " ;

        foreach ( $data[ 'child' ] AS $val2 )
        {
            $param.="
 <div class='col-md-3'>
                <div class='dropdown-menu-info'>
                            " ;
            //namayesh sub menu haaa
            if ( $val2[ 'data' ][ 'show_title' ] == 'enabled' )
            {
                if ( $val2[ 'data' ][ 'type' ] == 'link' )
                {
                    if ( $val2[ 'data' ][ 'link' ] )
                    {
                        $param.="
                                    <span class='dropdown-menu-title'><a title='".$val2[ 'data' ][ 'title' ]."' href='" . $val2[ 'data' ][ 'link' ] . "'  >" . $icon . ' ' . $val2[ 'data' ][ 'title' ] . "</a></span>
                            " ;
                    }
                    else
                    {
                        if($val2['data']['type']=='page')
                        {
                            $link = \f\ifm::app ()->siteUrl . 'page/' . $val2[ 'data' ][ 'page' ] ;
                        }
                        else
                        {
                            $link = \f\ifm::app ()->siteUrl . 'menuDetail/' . $val2[ 'data' ][ 'id' ] ;
                        }
                        $param.="
                                   <span class='dropdown-menu-title'><a href='".$link. "' >" . $icon . ' ' . $val2[ 'data' ][ 'title' ] . "</a></span>
                            " ;
                    }
                }
                else
                {
                    $param.="
                                    " . $icon . ' ' . $val2[ 'data' ][ 'title' ] . "
                            " ;
                }
            }

            if ( count ( $val2[ 'child' ] ) )
            {
                $param.="
                <ul class='menu'  >
            " ;

                foreach ( $val2[ 'child' ] AS $val3 )
                {
                    if ( $val3[ 'data' ][ 'icon' ] )
                    {
                        $icon = '<i class="fa ' . $val3[ 'data' ][ 'icon' ] . '"></i>' ;
                    }
                    else
                    {
                        $icon = '<i class=""></i>' ;
                    }

                    //namayesh sub menu haaa
                    $param.="

                        <li class='menu-item'>

                        " ;

                    if ( $val3[ 'data' ][ 'link' ] )

                    {

                        $param.="

                                <a title='".$val3[ 'data' ][ 'title' ]."' href='" . $val3[ 'data' ][ 'link' ] . "'  >" . $icon . ' ' . $val3[ 'data' ][ 'title' ] . "</a>

                        " ;

                    }

                    else

                    {

                        if($val3['data']['type']=='page')

                        {

                            $link = \f\ifm::app ()->siteUrl . 'page/' . $val3[ 'data' ][ 'page' ] ;

                        }

                        else

                        {

                            $link = \f\ifm::app ()->siteUrl . 'menuDetail/' . $val3[ 'data' ][ 'id' ] ;

                        }

                        $param.="

                                    <a href='".$link. "' >" . $icon . ' ' . $val3[ 'data' ][ 'title' ] . "</a>

                            " ;

                    }

                    if ( count ( $val3[ 'child' ] ) )

                    {





                        $param.="
                <div class='dropdown-menu-content'>
                <ul class='menu'>
            " ;
                        foreach ( $val3[ 'child' ] AS $val4 )
                        {
                            $icon = '' ;
                            //namayesh sub menu haaa
                            $param.="
                        <li class='menu-item'>

                        " ;

                            if ( $val4[ 'data' ][ 'link' ] )

                            {

                                $param.="

                                <a title='".$val4[ 'data' ][ 'title' ]."' href='" . $val4[ 'data' ][ 'link' ] . "'  >" . $icon . ' ' . $val4[ 'data' ][ 'title' ] . "</a>

                        " ;

                            }

                            else

                            {

                                if($val4['data']['type']=='page')

                                {

                                    $link = \f\ifm::app ()->siteUrl . 'page/' . $val4[ 'data' ][ 'page' ] ;

                                }

                                else

                                {

                                    $link = \f\ifm::app ()->siteUrl . 'menuDetail/' . $val4[ 'data' ][ 'id' ] ;

                                }

                                $param.="

                                            <a href='".$link. "' title='".$val4[ 'data' ][ 'title' ]."'>" . $icon . ' ' . $val4[ 'data' ][ 'title' ] . "</a>

                                    " ;

                            }



                            $param.="

                        </li>

                    " ;

                        }
                        $param.="

               </ul>
               </div>

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

               </div>
               </div>

            " ;
        }
        $param.="

             
               </div>
               </div>
               </div>

            " ;

    }
}
$param.="
             
               </ul>
               </div>
                        <span data-action='toggle-nav' class='menu-on-mobile hidden-mobile'>
                        <span class='btn-open-mobile home-page'>
                        <span></span>
                        <span></span>
                        <span></span>
                        </span>
                        <span class='title-menu-mobile'>منوی اصلی</span>
                        </span>
                    </div>
                </div>
            " ;
echo $param ;
?>









