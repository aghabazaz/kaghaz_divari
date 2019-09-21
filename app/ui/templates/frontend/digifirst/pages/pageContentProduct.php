<?php
$websiteInfo = $content[ 'websiteInfo' ] ;
$title       = $websiteInfo[ 'title' ] ;
if ( $content[ 'component_id' ] && $content[ 'item_id' ] )
{
    $seoParams = \f\ttt::service ( 'core.seo.getPageInfo',
        array (
            'component_id' => $content[ 'component_id' ],
            'item_id'      => $content[ 'item_id' ]
        ) ) ;
}
if ( $seoParams[ 'title' ] )
{
    $title = $seoParams[ 'title' ] ;
}elseif ($content['title'])
{
    $title=$content['title'];
}
if ( $seoParams[ 'keywords' ] )
{
    $keywords    =$seoParams['keywords'] ;
}elseif($content['keywords'])
{
    $keywords    =$content['keywords'] ;
}
else
{
    $keywords    =$websiteInfo[ 'keywords' ] ;
    if($content['title'])
    {
        $keywords.=' , '.  str_replace ( ' ', ',',$content['title'] );
    }

}
if ( $seoParams[ 'description' ] )
{

    $description    =$seoParams['description'] ;
}elseif($content['description'])
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
$pictureUrl=$logo;
include 'parts' . \f\DS . 'headerNewIndex.php' ;
?>

<?php
echo $content[ 'content' ] ;
?>


<?php
include 'parts' . \f\DS . 'footerProduct.php' ;
