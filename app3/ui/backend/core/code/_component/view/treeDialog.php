<?php
if ( $includeResources )
{
    ?>
    <link rel="stylesheet" href="<?= f\ifm::app()->componentBaseUrl . 'view/lib/jstree/dist/themes/default/style.min.css' ?>" />
    <script src="<?= f\ifm::app()->componentBaseUrl . 'view/lib/jstree/dist/jstree.js' ?>"></script>
<?php } ?>
<style>
    .rtl .tree-classic li.open {
        background-position:right 5px;
        margin-right:-3px;
        padding-right:19px;
    }   
    .rtl .tree-classic li.closed {
        background-position:right 5px;
        margin-right:-3px;
        padding-right:19px;
    }
    .rtl .tree-classic #dragged li.open {
        background-position: right 5px;
    }    

    li, h2#title{
        font-family: Yekan;
        font-size: 13px ;
    }
</style>

<?= $treeMarkup ?>

<script>

    var editDialogManager = {
        getFormMarkup: function (data) {
            $.ajax({
                url: "<?= \f\ifm::app()->baseUrl ?>core/code/documentTheCode",
                data: {type: data["type"], path: data["path"]},
                type: 'POST',
                success: function (response) {
                    if (response !== '')
                    {
                        $('#editDialog .modal-body').html(response);
                        //  widgetHelper.refreshUIElements();
                        $('form').parsley();
                        $('#methodForm').off('submit');


                    }
                    else
                    {
                        alert('New markup is empty !');
                    }
                }
            });
        },
        mousePosition: function () {
            document.addEventListener('mousemove', function (e) {
                x = e.clientX || e.pageX;
                y = e.clientY || e.pageY;
                return [x, y];
            }, false);
        }
    };
<?php
if ( $includeResources )
{
    ?>
        $(document).ready(function () {
            $(".jstree").jstree({
                "plugins": ["html_data", "dnd", "ui", "checkbox", "crrm"]
            });
        });
<?php } ?>


</script>
