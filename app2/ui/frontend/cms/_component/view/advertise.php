<?php

foreach ( $row AS $data )
{
    $type=  explode('/', $data['mime_type']);
    
    echo '<div class="col-sm-12 col-md-6">' ;
    
    if($type[0]=='image')
    {
        echo '<a href="'.$data['link'].'" target="_blank">' ;
        echo '<img src="'.\f\ifm::app ()->legacyBaseUrl.'upload/cms/advertisement/'.$data['name'].'" style="width:100%">' ;
          echo '</a>' ;
    }
    else
    {
        echo '<embed src="'.\f\ifm::app ()->legacyBaseUrl.'upload/cms/advertisement/'.$data['name'].'" width="100%" height="100%" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" >' ;
    }
    echo '</div>' ;
  

}

?>
<div class="clearfix"></div>
<style>
    .K
    {
        width: 480px;
        height: 60px;
    }
    .J
    {
        width: 480px;
        height: 60px;
    }
    .I
    {
        width: 160px;
        height: 200px;
         padding: 5px 0px;
    }
    .H
    {
        width: 160px;
        height: 200px;
         padding: 5px 0px;
    }
    .G
    {
        width: 160px;
        height: 200px;
        padding: 5px 0px;
    }
    .F
    {
        width: 480px;
        height: 60px;
    }
    .E
    {
        width: 480px;
        height: 60px;
    }
    .D
    {
        width: 480px;
        height: 60px;
        padding: 0px 10px;
    }
    .C
    {
        width: 168px;
        height: 120px;
        padding: 5px 0px;
    }
    .B
    {
        width: 480px;
        height: 80px;
        padding: 5px 0px;
    }
    .A
    {
        width: 300px;
        height: 80px;
        padding: 5px 0px;
    }
</style>
