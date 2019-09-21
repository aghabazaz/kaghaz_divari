<?php
//\f\pre($content);
$websiteInfo = $content[ 'websiteInfo' ] ;
//\f\pre($websiteInfo);
$title       = $websiteInfo[ 'title' ] ;
if($content['title'])
{
    $title.=' - '.$content['title'];
}
if($content['keywords'])
{
    $keywords    = $websiteInfo[ 'keywords' ].','.$content['keywords'] ;
}
else
{
    $keywords    =$websiteInfo[ 'keywords' ] ;
    if($content['title'])
    {
        $keywords.=' , '.  str_replace ( ' ', ',',$content['title'] );
    }
    
}
if($content['description'])
{
    $description =$content['description'] ;
    
}
else
{
    $description = $websiteInfo[ 'description' ];
}

$logo     = \f\ifm::app ()->fileBaseUrl . $websiteInfo[ 'logo' ] ;

if($content['picture'])
{
    $picture    = \f\ifm::app ()->fileBaseUrl . $content[ 'picture' ] ;
}
else
{
    $picture=$logo;
}

//\f\pre($logo);
//$header_menu=$content['header_menu'];


include 'parts' . \f\DS . 'header.php' ;
?>

            <?php
            echo $content[ 'content' ] ;
            ?>
   

<?php
include 'parts' . \f\DS . 'footer.php' ;
