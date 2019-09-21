<?php
if($row){
foreach ($row as $data )
{
    ?>
    <div class="favorit-item">
        <div class="col-md-2">
            <div class="fa-product-image">
                <a href="<?= \f\ifm::app()->siteUrl . 'productDetail/' . $data['id'] ?>"><img src="<?= \f\ifm::app()->fileBaseUrl . $data['picture'] ?>"
                                                                                              class="img-responsive"></a>
            </div>
        </div>
        <div class="col-md-7">
            <a href="<?= \f\ifm::app()->siteUrl . 'productDetail/' . $data['id'] ?>">
                <div class="fa-product-title">
                    <span> <?= $data['title'] ?> </span>
                </div>
            </a>
        </div>
        <div class="col-md-1"></div>
        <div class="col-md-2">
            <div class="fa-product-delet">
                <a id="<?= $data['id']?>" class="alert-trigger"><i class="fa fa-trash-o"></i></a>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>

    <?php
}
}else{
    ?>
    <div style="padding-top: 10px;">
    <span style="color: #ef535069;
    font-size: 15px;
    padding: 19px;"> لیست علاقه مندی های شما خالیست ! </span>
    </div>
    <?php
}
?>
<div class="alert" role="alert">
    <div class="alert-container">
        <p>آیا مطمئن هستید که این محصول از لیست مورد علاقه شما حذف شود؟</p>
        <footer class="buttons">
            <a href="#" class="alert-confirm">بله</a>
            <a href="#" class="alert-cancel">خیر</a>
        </footer>
        <a href="#" class="alert-close img-replace">&times;</a>
    </div>
</div>
<script>

    $(".alert-trigger").on("click", function(e) {
        e.preventDefault();
        var prodId = $(this).attr('id');
        $('.alert-confirm').attr('id',prodId);
        $(".alert").addClass("is-visible");
        $(".alert .alert-confirm")
            .attr("data-action", $(this).attr("data-action"))
            .attr("data-item", $(this).attr("data-item"));
    });
    $(".alert-confirm").on("click", function(e) {
        e.preventDefault();
        var data = {
            p_id: $(this).attr('id'),
            user_id: <?= $_SESSION['user_id']?>,
        };
        widgetHelper.tt('ui', 'member.deletFaveProduct', data, 'showResultCountReturn');
        $(".alert").removeClass("is-visible");
    });
    $(".alert-close, .alert-cancel").on("click", e => {
        e.preventDefault();
    $(".alert").removeClass("is-visible");
    });





    $('.delete-btn-fav').click(function(){

        var data = {
            p_id: $(this).attr('id'),
            user_id: <?= $_SESSION['user_id']?>,
        };
        widgetHelper.tt('ui', 'member.deletFaveProduct', data, 'showResultCountReturn');
    })
    function showResultCountReturn(){
        ajaxFavoritContent();
    }
</script>
<style>
    .fa-product-delet:hover {
        cursor: pointer;
    }



    .alert {
        position: fixed;
        left: 0;
        top: 0;
        height: 100%;
        width: 100%;
        background-color: rgba(0, 0, 0, 0.75);
        opacity: 0;
        visibility: hidden;
        transition: opacity 0.3s 0s, visibility 0s 0.3s;
    }
    .alert.is-visible {
        opacity: 1;
        visibility: visible;
        z-index: 999;
        transition: opacity 0.3s 0s, visibility 0s 0s;
    }

    .alert-container {
        position: relative;
        width: 90%;
        max-width: 400px;
        margin: 4em auto;
        background: #fff;
        color: #666;
        border-radius: 0.25em 0.25em 0.4em 0.4em;
        text-align: center;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
        transform: translateY(-40px);
        transition-property: transform;
        transition-duration: 0.3s;
        overflow: hidden;
    }
    .alert-container p {
        padding: 3em 1em;
    }
    .alert-container footer {
        display: flex;
        width: 100%;
        justify-content: center;
    }
    .alert-container footer a {
        display: block;
        height: 60px;
        line-height: 60px;
        text-transform: uppercase;
        color: #fff;
        font-weight: 700;
        text-shadow: 0 1px 0 rgba(0, 0, 0, 0.2);
        flex: 1;
        background: #b6bece;
        text-decoration: none;
        transition: background-color 0.2s;
    }
    .alert-container footer a:hover {
        box-shadow: 0 0 100em 100em rgba(0, 0, 0, 0.2) inset;
    }
    .alert-container footer .alert-cancel {
        background: #fc5169;
    }

    .alert-container .alert-close {
        position: absolute;
        top: 8px;
        right: 8px;
        width: 30px;
        height: 30px;
        color: #8f9cb5;
        font-weight: 900;
        font-size: 1.5em;
        text-decoration: none;
    }
    .is-visible .alert-container {
        transform: translateY(0);
    }

</style>