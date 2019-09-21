<?php

if ( $page > 1 )
{
    echo '<a href="' . $href . '/page/' . $pr . '">صفحه قبلی</a>' ;
}
else
{
    echo '<a class="btn disabled" href="javascript:void(0)">صفحه قبلی</a>' ;
}
echo '<ul>' ;
//---------------------------------------------------------------------------------------------------
if ( $lastpage < 7 + ($adjacents * 2) )
{
    for ( $counter = 1 ; $counter <= $lastpage ; $counter ++  )
    {
        if ( $counter == $page )
                echo '<li class="current"><a href="javascript:void(0)"  >', \f\ifm::faDigit($counter), '</a></li>' ;
        else
                echo '<li><a href="' . $href . '/page/' . $counter . '"  >', \f\ifm::faDigit($counter), '</a></li>' ;
    }
}
elseif ( $lastpage > 5 + ($adjacents * 2) )
{

    if ( $page < 1 + ($adjacents * 2) )
    {
        for ( $counter = 1 ; $counter < 4 + ($adjacents * 2) ; $counter ++  )
        {
            if ( $counter == $page )
                echo '<li class="current"><a href="javascript:void(0)"  >', \f\ifm::faDigit($counter), '</a></li>' ;
        else
                echo '<li><a href="' . $href . '/page/' . $counter . '"  >', \f\ifm::faDigit($counter), '</a></li>' ;
        }
        echo '<li class="dots"><a>...</a></li>' ;
        echo '<li><a href="' . $href . '/page/' . $lpm1 . '"  >', $lpm1, '</a></li>' ;
        echo '<li><a href="' . $href . '/page/' . $lastpage . '"  >', $lastpage, '</a></li>' ;
       
    }

    elseif ( $lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2) )
    {
        echo '<li><a href="' . $href . '/page/1"  >1</a></li>' ;
        echo '<li><a href="' . $href . '/page/2"  >2</a></li>' ;
        echo '<li class="dots"><a>...</a></li>' ;

        for ( $counter = $page - $adjacents ; $counter <= $page + $adjacents ; $counter ++  )
        {
            if ( $counter == $page )
                     echo '<li class="current"><a href="javascript:void(0)"  >', \f\ifm::faDigit($counter), '</a></li>' ;
            else
                     echo '<li><a href="' . $href . '/page/' . $counter . '"  >',\f\ifm::faDigit($counter), '</a></li>' ;
        }
       echo '<li class="btn disabled"><a href="javascript:void(0)"  >......</a></li>' ;
       echo '<li><a href="' . $href . '/page/' . $lpm1 . '"  >', $lpm1, '</a></li>' ;
       echo '<li><a href="' . $href . '/page/' . $lastpage . '"  >', $lastpage, '</a></li>' ;
    }

    else
    {
       echo '<li><a href="' . $href . '/page/1"  >1</a></li>' ;
       echo '<li><a href="' . $href . '/page/2"  >2</a></li>' ;
       echo '<li class="disabled"><a href="javascript:void(0)"  >......</a></li>' ;

        for ( $counter = $lastpage - (2 + ($adjacents * 2)) ; $counter <= $lastpage ; $counter ++  )
        {
            if ( $counter == $page )
                     echo '<li class="current"><a href="javascript:void(0)"  >', \f\ifm::faDigit($counter), '</a></li>' ;
            else
                     echo '<li><a href="' . $href . '/page/' . $counter . '"  >',\f\ifm::faDigit($counter), '</a></li>' ;
        }
    }
}
echo '</ul>' ;
//--------------------------------------------------------------------------------------------------------------------------------------
if ( $page < $counter - 1 )
{
    echo '<a href="' . $href . '/page/' . $nx . '"  >صفحه بعدی</a>' ;
}
else
{
    echo '<a class="btn disabled" href="javascript:void(0)"  >صفحه بعدی</a>' ;
}
?>