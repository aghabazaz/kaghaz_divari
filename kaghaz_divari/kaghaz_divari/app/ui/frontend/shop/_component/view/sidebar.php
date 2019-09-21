<?php
/* @var $formWidget \f\w\form */
$formWidget = \f\widgetFactory::make ( 'form' ) ;
?>
<header class="avatar">
    <div style="font-size:17px;color:#000">
        <i class='fa fa-square-o' style='font-size:10px'></i> 
        <?= 'بر اساس وضعیت دستگاه' ?>
    </div>
</header>
<div style="padding: 10px">
    <?php
    echo $formWidget->checkbox2 ( array (
        'htmlOptions' => array (
            'name'  => 'condition',
            
            'onchange'=>'getProductByParam()',
            'class' => 'condition',
        ),
        'choices'     => $baseInfo[ 'condition' ][ 'title' ],
    ) ) ;
    ?>   
</div>
<div class="clearfix"></div>

<?php
if ( ! $catId )
{
    ?>

    <header class="avatar">
        <div style="font-size:17px;color:#000">
            <i class='fa fa-square-o' style='font-size:10px'></i> 
            <?= 'بر اساس نوع دستگاه' ?>
        </div>
    </header>
    <div style="padding: 10px">
        <?php
        echo $formWidget->checkbox2 ( array (
            'htmlOptions' => array (
                'name'  => 'category',
                'class' => 'info',
                'onchange'=>'getProductByParam()',
            ),
            'choices'     => $category,
        ) ) ;
        ?>
    </div>
    <?php
}
else
{
    echo '<input type="hidden" value="'.$catId.'" id="category">' ;
}
?>

<style>
    .clear
    {
        clear: both;
    }
</style>