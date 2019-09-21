<?php
$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";


$param.='
      <ul class="nav navbar-nav" style="padding-bottom: 50px;width:100%">
    ' ;
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
    $arr = explode("/", $actual_link);
    $arr2 = explode("/", $link);   
    if ( $arr['4'] == $arr2['4'] )
    {
        $class="active";
    }
    else
    {
        $class='';
    }
    if(count ( $data[ 'child' ] ))
    {
        $class.=" dropdown";
    }
        
    //namayesh menu asli

    $param.='<li class="'.$class.'">
            <a href="' . $link . '" ><i class="fa ' . $data[ 'data' ][ 'icon' ] . '"></i> ' . $data[ 'data' ][ 'title' ] . '</a>' ;
    if ( count ( $data[ 'child' ] ) )
    {
        $param.='
                <ul class="dropdown-menu forAnimate" role="menu">
            ' ;
        foreach ( $data[ 'child' ] AS $val2 )
        {
            //namayesh sub menu haaa
            $param.="
                        <li >
                        " ;
            if ( $val2[ 'data' ][ 'link' ] )
            {
                $param.="
                                <a href='" . $val2[ 'data' ][ 'link' ] . "'  ><i class='fa " . $val2[ 'data' ][ 'icon' ] . "'></i> " . $val2[ 'data' ][ 'title' ] . "</a>
                        " ;
            }
            else
            {
                $param.="
                                <a href='" . \f\ifm::app ()->siteUrl . 'menuDetail/' . $val2[ 'data' ][ 'id' ] . "' target='_blank'><i class='fa " . $val2[ 'data' ][ 'icon' ] . "'></i> " . $val2[ 'data' ][ 'title' ] . "</a>
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

echo $param;
?>
<!--
    <li class="active">
        <a href="#">
            <i class="fa fa-home"></i> <?= 'داشبورد' ?>  
        </a>
    </li>
    <li class="">
        <a href="#">
            <i class="fa fa-bullhorn"></i> <?= 'آگهی ها' ?>  
        </a>
    </li>
    <li class="">
        <a href="#">
            <i class="fa fa-gears"></i> <?= 'ماشین آلات و دستگا ها' ?>  
        </a>
    </li>
    <li class="">
        <a href="#">
            <i class="fa fa-envelope"></i> <?= 'پیام ها' ?>  
        </a>
    </li>
    <li class="">
        <a href="#">
            <i class="fa fa-user"></i> <?= 'اطلاعات کاربری' ?>  
        </a>
    </li>
    <li class="">
        <a href="#">
            <i class="fa fa-key"></i> <?= 'تغییر کلمه عبور' ?> 
        </a>
    </li>
    <li class="">
        <a href="<?= \f\ifm::app ()->siteUrl . 'member/logout' ?>">
            <i class="fa fa-sign-out"></i> <?= 'خروج' ?> 
        </a>
    </li>

</ul>

<li class="dropdown">
   <a href="#" class="dropdown-toggle" data-toggle="dropdown">Usuarios <span class="caret"></span><span style="font-size:16px;" class="pull-right hidden-xs showopacity glyphicon glyphicon-user"></span></a>
   <ul class="dropdown-menu forAnimate" role="menu">
       <li><a href="">Crear</a></li>
       <li><a href="#">Modificar</a></li>
       <li><a href="#">Reportar</a></li>
       <li class="divider"></li>
       <li><a href="#">Separated link</a></li>
       <li class="divider"></li>
       <li><a href="#">Informes</a></li>
   </ul>
</li> 
-->