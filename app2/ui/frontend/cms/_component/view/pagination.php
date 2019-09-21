<?

if ( $page > 1 )
{
    echo '<li><a href="' . $href . '/page/' . $pr . '" style="font-size:13px" >صفحه قبلی</a></li>' ;
}
else
{
    echo '<li class="disabled" ><a href="javascript:void(0)" style="font-size:13px" >صفحه قبلی</a></li>' ;
}

//---------------------------------------------------------------------------------------------------
if ( $lastpage < 7 + ($adjacents * 2) )
{
    for ( $counter = 1 ; $counter <= $lastpage ; $counter ++  )
    {
        if ( $counter == $page )
                echo '<li class="active"><a href="javascript:void(0)" style="font-size:13px" >', $counter, '</a></li>' ;
        else
                echo '<li><a href="' . $href . '/page/' . $counter . '" style="font-size:13px" >', $counter, '</a></li>' ;
    }
}
elseif ( $lastpage > 5 + ($adjacents * 2) )
{

    if ( $page < 1 + ($adjacents * 2) )
    {
        for ( $counter = 1 ; $counter < 4 + ($adjacents * 2) ; $counter ++  )
        {
            if ( $counter == $page )
                echo '<li class="active"><a href="javascript:void(0)" style="font-size:13px" >', $counter, '</a></li>' ;
        else
                echo '<li><a href="' . $href . '/page/' . $counter . '" style="font-size:13px" >', $counter, '</a></li>' ;
        }
        echo '<li class="disabled"><a href="javascript:void(0)" style="font-size:13px" >......</a></li>' ;
        echo '<li><a href="' . $href . '/page/' . $lpm1 . '" style="font-size:13px" >', $lpm1, '</a></li>' ;
        echo '<li><a href="' . $href . '/page/' . $lastpage . '" style="font-size:13px" >', $lastpage, '</a></li>' ;
       
    }

    elseif ( $lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2) )
    {
        echo '<li><a href="' . $href . '/page/1" style="font-size:13px" >1</a></li>' ;
        echo '<li><a href="' . $href . '/page/2" style="font-size:13px" >2</a></li>' ;
        echo '<li class="disabled"><a href="javascript:void(0)" style="font-size:13px" >......</a></li>' ;

        for ( $counter = $page - $adjacents ; $counter <= $page + $adjacents ; $counter ++  )
        {
            if ( $counter == $page )
                     echo '<li class="active"><a href="javascript:void(0)" style="font-size:13px" >', $counter, '</a></li>' ;
            else
                     echo '<li><a href="' . $href . '/page/' . $counter . '" style="font-size:13px" >', $counter, '</a></li>' ;
        }
       echo '<li class="disabled"><a href="javascript:void(0)" style="font-size:13px" >......</a></li>' ;
       echo '<li><a href="' . $href . '/page/' . $lpm1 . '" style="font-size:13px" >', $lpm1, '</a></li>' ;
       echo '<li><a href="' . $href . '/page/' . $lastpage . '" style="font-size:13px" >', $lastpage, '</a></li>' ;
    }

    else
    {
       echo '<li><a href="' . $href . '/page/1" style="font-size:13px" >1</a></li>' ;
       echo '<li><a href="' . $href . '/page/2" style="font-size:13px" >2</a></li>' ;
       echo '<li class="disabled"><a href="javascript:void(0)" style="font-size:13px" >......</a></li>' ;

        for ( $counter = $lastpage - (2 + ($adjacents * 2)) ; $counter <= $lastpage ; $counter ++  )
        {
            if ( $counter == $page )
                     echo '<li class="active"><a href="javascript:void(0)" style="font-size:13px" >', $counter, '</a></li>' ;
            else
                     echo '<li><a href="' . $href . '/page/' . $counter . '" style="font-size:13px" >', $counter, '</a></li>' ;
        }
    }
}

//--------------------------------------------------------------------------------------------------------------------------------------
if ( $page < $counter - 1 )
{
     echo '<li><a href="' . $href . '/page/' . $nx . '" style="font-size:13px" >صفحه بعدی</a></li>' ;
   
}
else
{
    echo '<li class="disabled" ><a href="javascript:void(0)" style="font-size:13px" >صفحه بعدی</a></li>' ;
}
?>