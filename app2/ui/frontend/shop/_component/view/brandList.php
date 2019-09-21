<div class="block-brand full-width">
    <div class="container-inner ">
        <div class="owl-carousel nav-style3" data-nav="true" data-autoplay="false" data-dots="false" data-loop="true" data-margin="11" data-responsive='{"0":{"items":2},"480":{"items":2},"600":{"items":4},"992":{"items":5},"1366":{"items":6}}'>

        <?php
foreach ($row AS $data){
    $picture=\f\ttt::service('core.fileManager.loadFileUrl',[
        'fileId'=> $data[ 'logo'],
        'width'=>'200',
        'height'=>'200',
        'option'=>'auto',
    ]);
    ?>
            <a href="<?= \f\ifm::app()->siteUrl . 'product/brand/'. $data['id'].'/'.$data['title_fa']?>" class="item-brand" title="<?=$data['title_fa']?>"><img src="<?=$picture ?>" alt="<?=$data['title_fa']?>" title="<?=$data['title_fa']?>"></a>

    <?php
}
?>
        </div>
    </div>
</div>













